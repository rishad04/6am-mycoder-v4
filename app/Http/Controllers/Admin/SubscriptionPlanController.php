<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPlan\StoreRequest;
use App\Http\Requests\SubscriptionPlan\UpdateRequest;
use App\Repositories\SubscriptionPlan\SubscriptionPlanInterface;

class SubscriptionPlanController extends Controller
{

    protected  $repo;

    function __construct(SubscriptionPlanInterface $repo)
    {
        $this->middleware('permission:subscription-plan-view|subscription-plan-create|subscription-plan-update|subscription-plan-delete', ['only' => ['index']]);
        $this->middleware('permission:subscription-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-plan-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-plan-delete', ['only' => ['destroy']]);

        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $info                     = new stdClass();
        $info->title              = 'Subscription Plans';
        $info->page_title         = 'Subscription Plans';
        $info->first_button_title = 'Add Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.create';
        $info->route_index        = 'admin.subscription-plans.index';

        $with_data = [];

        $data = $this->repo->all(null, 15);

        return view('backend.subscription-plans.index', compact('data', 'info'))->with($with_data);
    }

    public function create()
    {

        $info                     = new stdClass();
        $info->title              = 'Subscription Plans Create';
        $info->page_title         = 'Subscription Plans Create';
        $info->form_route         = 'admin.subscription-plans.store';
        $info->route_index        = 'admin.subscription-plans.index';

        return view('backend.subscription-plans.create', compact('info'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('admin.subscription-plans.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function show($id)
    {
        $info                     = new stdClass();
        $info->title              = 'Subscription Plans Show';
        $info->page_title         = 'Subscription Plans Show';

        $data = $this->repo->first($id);

        return view('backend.subscription-plans.show', compact('info', 'data'));
    }

    public function edit($id)
    {
        $info                     = new stdClass();
        $info->title              = 'Subscription Plans Edit';
        $info->page_title         = 'Subscription Plans Edit';
        $info->form_route         = 'admin.subscription-plans.update';
        $info->route_index        = 'admin.subscription-plans.index';

        $data = $this->repo->first($id);

        return view('backend.subscription-plans.edit', compact('info', 'data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);

        if ($result['status']) {
            return redirect()->route('admin.subscription-plans.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
    {
        if ($this->repo->delete($id)) :
            $success[0] = ___('alert.successfully_deleted');
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }
}
