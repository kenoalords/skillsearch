<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Skills;
use App\Http\Requests\TaskFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

	public function index(Request $request)
	{
		$tasks = $request->user()->tasks()->orderDesc()->get();
		return view('task.index')->with('tasks', $tasks);
	}

    public function add(Skills $s)
    {
    	$skills = $s->all();
    	return view('task.add')->with('skills', $skills);
    }

    public function createTask(TaskFormRequest $request)
    {
    	$request->user()->tasks()->create([
    		'title' => $request->title,
    		'description' => $request->description,
    		'category' => $request->category,
    		'location' => $request->location,
    		'slug' => str_slug($request->title),
    		'budget' => $request->budget,
    		'budget_type' => $request->budget_type,
    		'is_public' => ($request->is_public) ? $request->is_public : 0,
    		'only_portfolio' => ($request->only_portfolio) ? $request->only_portfolio : 0,
    	]);

    	return redirect()->route('user_tasks');
    }

    public function edit(Request $request, Task $task, Skills $s)
    {
    	$this->authorize('edit', $task);

    	$skills = $s->all();
    	return view('task.edit')->with([
    		'task' 		=> $task,
    		'skills'	=> $skills
    	]);
    }

    public function update(TaskFormRequest $request, Task $task)
    {
    	$task->update([
    		'title' => $request->title,
    		'description' => $request->description,
    		'category' => $request->category,
    		'location' => $request->location,
    		'slug' => str_slug($request->title),
    		'budget' => $request->budget,
    		'budget_type' => $request->budget_type,
    		'is_public' => ($request->is_public) ? $request->is_public : 0,
    		'only_portfolio' => ($request->only_portfolio) ? $request->only_portfolio : 0,
    	]);

    	return redirect()->route('user_tasks');
    }

    public function allTasks ( Request $request, Task $task )
    {
    	$tasks = $task->isPublic()->orderDesc()->get();
    	return view('task.all')->with('tasks', $tasks);
    }

    public function getTask( Request $request, Task $task )
    {
    	return view('task.single')->with('task', $task);
    }
}





