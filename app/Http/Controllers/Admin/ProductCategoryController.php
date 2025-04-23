<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use App\Classes\SelfCoder\FileManager;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-category-view|product-category-create|product-category-update|product-category-delete', ['only' => ['index']]);
        $this->middleware('permission:product-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-category-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Product Category';
        $info                     = new stdClass();
        $info->title              = 'Product Categories';
        $info->first_button_title = 'Add Product Category';
        $info->first_button_route = 'admin.product-categories.create';
        $info->route_index        = 'admin.product-categories.index';
        $info->description        = 'These all are Product Categories';

        $with_data = [];

        $data = ProductCategory::query();

        $data = $data->orderBy('id', 'DESC');

        $data = $data->paginate(15);

        return view('backend.product-categories.index', compact('page_title', 'data', 'info'))->with($with_data);
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
