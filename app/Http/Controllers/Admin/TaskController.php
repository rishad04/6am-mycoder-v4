<?php

namespace App\Http\Controllers\Admin;

use \stdClass;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:task-view|task-create|task-update|task-delete', ['only' => ['index']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $page_title               = 'Task';
        $info                     = new stdClass();
        $info->title              = 'Tasks';
        $info->first_button_title = 'Add Task';
        $info->first_button_route = 'admin.tasks.create';
        $info->route_index        = 'admin.tasks.index';
        $info->description        = 'These all are Tasks';

        $with_data = [];

        $data = Task::query();

        $data = $data->orderBy('id', 'DESC');

        $data = $data->paginate(15);

        return view('backend.tasks.index', compact('page_title', 'data', 'info'))->with($with_data);
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
