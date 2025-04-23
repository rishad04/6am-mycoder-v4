<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;
use \stdClass;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-plan-view|subscription-plan-create|subscription-plan-update|subscription-plan-delete', ['only' => ['index']]);
        $this->middleware('permission:subscription-plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-plan-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-plan-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Subscription Plan';
        $info                     = new stdClass();
        $info->title              = 'Subscription Plans';
        $info->first_button_title = 'Add Subscription Plan';
        $info->first_button_route = 'admin.subscription-plans.create';
        $info->route_index        = 'admin.subscription-plans.index';
        $info->description        = 'These all are Subscription Plans';

        $with_data = [];

        $data = SubscriptionPlan::query();

        $data = $data->orderBy('id', 'DESC');

        $data = $data->paginate(15);

        return view('backend.subscription-plans.index', compact('page_title', 'data', 'info'))->with($with_data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
