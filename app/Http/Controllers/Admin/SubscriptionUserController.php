<?php

namespace App\Http\Controllers\Admin;

use Hash;
use \stdClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionUser;
use App\Services\MockStripeService;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\SelfCoder\FileManager;
use App\Exports\SubscriptionUserExport;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class SubscriptionUserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subscription-user-view|subscription-user-create|subscription-user-update|subscription-user-delete', ['only' => ['index']]);
        $this->middleware('permission:subscription-user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:subscription-user-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subscription-user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Subscription User';
        $info                     = new stdClass();
        $info->title              = 'Subscription Users';
        $info->first_button_title = 'Add Subscription User';
        $info->first_button_route = 'admin.subscription-users.create';
        $info->route_index        = 'admin.subscription-users.index';
        $info->description        = 'These all are Subscription Users';

        $with_data = [];

        $data = SubscriptionUser::query();

        $data = $data->orderBy('id', 'DESC');

        $data = $data->paginate(15);

        return view('backend.subscription-users.index', compact('page_title', 'data', 'info'))->with($with_data);
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
