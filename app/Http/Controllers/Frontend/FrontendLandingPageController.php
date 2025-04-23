<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Jobs\SendTaskWelcomeEmail;
use App\Services\MockStripeService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class FrontendLandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans_frontend = SubscriptionPlan::where('is_active', 1)->orderBy('order', 'asc')->take(3)->get();

        return view('frontend.landing_Page_index', compact('plans_frontend'));
    }

    public function loginFormShow()
    {

        return view('frontend.login_form');
    }

    public function registerFormShow()
    {
        return view('frontend.register_form');
    }

    public function subscribe(Request $request)
    {
        // Validation
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id', // Ensuring the subscription plan exists
        ]);

        $plan = SubscriptionPlan::find($request->plan_id);

        $user = auth()->user(); // Assuming the user is authenticated

        if (!$user) {
            return apiResponse(false, 'User not authenticated');
        }

        // Check if the user already has this plan active
        $existingActive = SubscriptionUser::where('user_id', $user->id)
            ->where('plan_id', $plan->id)
            ->where('is_active', 1)
            ->first();

        if ($existingActive) {
            return apiResponse(false, 'Already subscribed to this plan and it is active.', null, 409);
        }

        // 2. Prevent downgrade
        $currentActivePlan = SubscriptionUser::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderByDesc('created_at') // Assuming latest is the current one
            ->first();

        if ($currentActivePlan) {
            $currentPlan = SubscriptionPlan::find($currentActivePlan->plan_id);

            if ($currentPlan && $currentPlan->level > $plan->level) {
                return apiResponse(false, 'Downgrade to this plan is not allowed.', null, 403);
            }
        }

        // 3. Deactivate other active subscriptions
        SubscriptionUser::where('user_id', $user->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);


        $key = config('services.mock_stripe.key');
        // Simulating subscription creation with a mock Stripe API
        $result = MockStripeService::createSubscription($user, $plan, $key);

        $subscription = SubscriptionUser::create([
            'user_id'          => $user->id,
            'plan_id'          => $plan->id,
            'is_active'        => $result['payment_status'] == 'success' ? 1 : 0,
            'payment_status'   => $result['payment_status'] == 'success' ? 'Paid' : 'Unpaid',
            'payment_method'   => $result['payment_status'] == 'success' ? 'Stripe MOCK' : 'Not Found',
            'payment_verified' => $result['payment_status'] == 'success' ? 1 : 0,
            'paid'             => $result['payment_status'] == 'success' ? $plan->price : 0,
            'status'           => $result['payment_status'] == 'success' ? 'Subscribed' : 'Unsubscribed',
            'start_date'       => now(),
            'end_date'         => match ($plan->billing_cycle) {
                'weekly'  => now()->addDays(7),
                'monthly' => now()->addMonths(1),
                'yearly'  => now()->addYear(),
                default   => now()->addMonths(1),
            }
        ]);

        if ($result['payment_status'] == 'success') {
            return apiResponse(true, 'Subsribed Successfully!', $subscription, 200);
        } else {
            return apiResponse(false, 'Stripe Payment failed!');
        }
    }


    public function subscriptionShowFrontend($id)
    {
        $data = SubscriptionUser::with('user', 'subscriptionPlan')->find($id);

        if (!$data) {
            return apiResponse(false, 'No Data Found', null, 200);
        }

        return apiResponse(true, 'Successfull!', $data, 200);
    }

    public function cancelSubscription(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscription_users,id'
        ]);

        $subscription = SubscriptionUser::where('id', $request->subscription_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$subscription) {
            return apiResponse(false, 'Subscription not found or unauthorized.', null, 404);
        }

        if (!$subscription->is_active) {
            return apiResponse(false, 'Subscription is already cancelled.', null, 400);
        }

        $subscription->update([
            'is_active'  => 0,
            'status'     => 'Subcription Cancelled',
            'user_unsubscribed_at'  => now(),
        ]);

        return response()->json(['message' => 'Subscription cancelled successfully.']);
    }

    public function productsCasched($slug = null)
    {
        // Start timing
        $startTime = microtime(true);

        // Cache key changes based on slug
        $cacheKey = $slug ? 'products_category_' . $slug : 'all_products';

        Log::info('Cache Key: ' . $cacheKey);

        // Cache product categories (shared)
        $product_categories = Cache::remember('product_categories', now()->addHours(1), function () {
            return ProductCategory::where('is_active', 1)->get();
        });

        Log::info('Cache Key for Product Categories: product_categories');
        // Cache products based on slug
        $products = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($slug) {
            $query = Product::query();

            if ($slug) {
                $query->whereHas('productCategory', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }

            return $query->paginate(20);
        });

        Log::info('Cache Key for Products: ' . $cacheKey);

        // Log execution time
        $executionTime = microtime(true) - $startTime;
        $backend_loading_time = number_format($executionTime, 4);
        Log::info('Execution Time for Cached products method: ' . number_format($executionTime, 4) . ' seconds');

        // Return view with products and categories
        return view('frontend.products_cached', compact('products', 'product_categories', 'backend_loading_time'));
    }

    public function products($slug = null)
    {
        // Start timing
        $startTime = microtime(true);

        // Cache key changes based on slug
        $cacheKey = $slug ? 'products_category_' . $slug : 'all_products';

        // Get product categories
        $product_categories = ProductCategory::where('is_active', 1)->get();

        // Get products based on slug
        $query = Product::query();

        if ($slug) {
            $query->whereHas('productCategory', function ($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Paginate the results (no caching)
        $products = $query->paginate(20);

        // Log execution time
        $executionTime = microtime(true) - $startTime;
        $backend_loading_time = number_format($executionTime, 4);
        Log::info('Execution Time for Non Cached products method: ' . number_format($executionTime, 4) . ' seconds');

        // Return view with products and categories
        return view('frontend.products', compact('products', 'product_categories', 'backend_loading_time'));
    }

    public function productDetails(string $slug)
    {

        $startTime = microtime(true);

        $product_categories = ProductCategory::where('is_active', 1)->get();
        $latest_products    = Product::orderby('created_at', 'desc')->take(10)->get();
        $product            = Product::where('slug', $slug)->first();

        $executionTime = microtime(true) - $startTime;

        $backend_loading_time = number_format($executionTime, 4);

        Log::info('Execution Time for Non-Cached product-Details method: ' . number_format($executionTime, 4) . ' seconds');

        return view('frontend.product_details', compact('product', 'product_categories', 'latest_products', 'backend_loading_time'));
    }

    public function productDetailsCached(string $slug)
    {
        $startTime = microtime(true);

        // Cache the product categories for 1 hour
        $product_categories = cache()->remember('product_categories', 60 * 60, function () {
            return ProductCategory::where('is_active', 1)->get();
        });

        // Cache the latest products for 30 minutes
        $latest_products = cache()->remember('latest_products', 30 * 60, function () {
            return Product::orderby('created_at', 'desc')->take(10)->get();
        });

        // Cache the specific product for 15 minutes using the product slug as a unique key
        $cacheKey = "product_details_{$slug}";
        $product = cache()->remember($cacheKey, 15 * 60, function () use ($slug) {
            return Product::where('slug', $slug)->first();
        });

        $executionTime = microtime(true) - $startTime;

        $backend_loading_time = number_format($executionTime, 4);

        Log::info('Execution Time for Cached product-Details method: ' . number_format($executionTime, 4) . ' seconds');

        return view('frontend.product_details_cached', compact('product', 'product_categories', 'latest_products', 'backend_loading_time'));
    }

    public function myTasks(Request $request)
    {
        $user = auth()->user();
        $tasks = Task::where('is_active', 1)->where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        return view('frontend.my_tasks', compact('tasks'));
    }

    public function myTasksStore(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Save task (you might have a Task model)
        $task              = new Task();
        $task->user_id     = auth()->user()->id;
        $task->title       = $request->title;
        $task->description = $request->description;
        $task->is_completed = false;
        $task->save();

        // Dispatching the welcome email job
        SendTaskWelcomeEmail::dispatch($task);

        return apiResponse(true, 'Successfully Task Created!', null, 201);
    }

    public function myTaskDetails($id)
    {
        $user = auth()->user();
        $task = Task::where('is_active', 1)->where('user_id', $user->id)->where('id', $id)->first();

        return view('frontend.my_task_details', compact('task'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
