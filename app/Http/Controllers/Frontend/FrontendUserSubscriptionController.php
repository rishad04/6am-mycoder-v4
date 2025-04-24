<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Services\MockStripeService;
use App\Http\Controllers\Controller;

class FrontendUserSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $stripe;

    public function __construct(MockStripeService $stripe)
    {
        $this->stripe = $stripe;
    }


    public function subscribe(Request $request)
    {
        // Validation
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id', // subscription plan exists or not check
        ]);

        $plan = SubscriptionPlan::find($request->plan_id);

        $user = auth()->user();

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

        // Prevent downgrade
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

        // Deactivate other active subscriptions
        SubscriptionUser::where('user_id', $user->id)
            ->where('is_active', 1)
            ->update(['is_active' => 0]);


        $key = config('services.mock_stripe.key');

        // Simulating subscription creation with a mock Stripe API
        $result = $this->stripe::createSubscription($user, $plan, $key);

        if ($result['status'] == 'success') {

            $subscription                   = new SubscriptionUser();
            $subscription->user_id          = $user->id;
            $subscription->plan_id          = $plan->id;
            $subscription->is_active        = $result['status']         == 'success' ? 1 : 0;
            $subscription->payment_status   = $result['payment_status'] == 'success' ? 'Paid' : 'Unpaid';
            $subscription->payment_method   = $result['payment_status'] == 'success' ? 'Stripe MOCK' : 'Not Found';
            $subscription->payment_verified = $result['payment_status'] == 'success' ? 1 : 0;
            $subscription->paid             = $result['payment_status'] == 'success' ? $plan->price : 0;
            $subscription->status           = $result['payment_status'] == 'success' ? 'Subscribed' : 'Unsubscribed';
            $subscription->start_date       = now();

            if ($plan->billing_cycle->value == 'weekly') {
                $subscription->end_date = now()->addDays(7);
            } elseif ($plan->billing_cycle->value == 'monthly') {
                $subscription->end_date = now()->addMonths(1);
            } elseif ($plan->billing_cycle->value == 'yearly') {
                $subscription->end_date = now()->addYear();
            } else {
                $subscription->end_date = null;
            }

            $subscription->save();

            return apiResponse(true, 'Subsribed Successfully!', $subscription, 200);
        } elseif ($result['status'] == 'config_mismatch') {
            return apiResponse(false, 'Please Check Stripe Configuration');
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
}
