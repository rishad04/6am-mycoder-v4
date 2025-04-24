<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Jobs\SendTaskWelcomeEmail;
use App\Http\Controllers\Controller;

class FrontendUserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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
