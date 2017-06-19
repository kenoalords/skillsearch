<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\Skills;
use App\Models\Application;
use App\Models\SaveJob;
use App\Models\ApplicationResponse;
use App\Transformers\TaskTransformer;
use App\Transformers\SimpleUserTransformers;
use App\Transformers\SimpleTaskTransformer;
use App\Transformers\UserTransformers;
use App\Transformers\ApplicationResponseTransformer;
use App\Transformers\ApplicationTransformer;
use App\Http\Requests\TaskFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Fractal\Resource\Collection;

use Mail;
use App\Mail\JobRejectNotification;
use App\Mail\JobApprovalNotification;
use App\Mail\TaskApplicationNotification;
use App\Mail\ApplicationAcceptanceNotification;

class TaskController extends Controller
{

	public function index(Request $request)
	{
		$tasks = fractal()->collection($request->user()->tasks()->orderDesc()->get())
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        // dd($tasks);
		return view('task.index')->with('tasks', $tasks);
	}

    public function add(Request $request, Skills $s)
    {
    	$skills = $s->all();
        $user = fractal()->item($request->user())
                          ->transformWith(new SimpleUserTransformers)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        // dd($user);
        if(!$user['first_name'] || !$user['last_name'] || !$user['location']){
            return view('task.cant_add');
        }
    	return view('task.add')->with(['skills' => $skills, 'user' => $user]);
    }

    public function createTask(TaskFormRequest $request)
    {
        // dd($request);
        if($request->id){
            $task = Task::where('id', $request->id)->first();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->category = $request->category;
            $task->budget = $request->budget;
            $task->budget_type = $request->budget_type;
            $task->is_public = $request->is_public;
            $task->location = $request->location;
            $task->application_limit = $request->application_limit;
            $task->expires = $request->expires;
            $task->is_approved = 0;
            $task->is_rejected = 0;
            $task->slug = str_slug($request->title);
            $task->save();
        } else {
        	$request->user()->tasks()->create([
        		'title' => $request->title,
        		'description' => $request->description,
        		'category' => $request->category,
        		'location' => $request->location,
        		'slug' => str_slug($request->title),
                'expires' => $request->expires,
                'budget' => $request->budget,
        		'application_limit' => $request->application_limit,
        		'budget_type' => $request->budget_type ? $request->budget_type : 'fixed',
        		'is_public' => ($request->is_public) ? (int)$request->is_public : 0,
        		'only_portfolio' => ($request->only_portfolio) ? $request->only_portfolio : 0,
        	]);
        }

    	return response()->json(['status'=>true], 200);
    }

    public function edit(Request $request, Task $task, Skills $s)
    {
    	$this->authorize('edit', $task);

    	$skills = $s->all();
    	return view('task.edit')->with([
    		'task' 		=> json_encode($task),
    		'skills'	=> $skills
    	]);
    }

    public function delete(Request $request, Task $task)
    {
        $this->authorize('delete', $task);
        return view('task.delete')->with([
            'task' => $task,
        ]);
    }

    public function deleteOk(Request $request, Task $task)
    {
        $task->delete();
        return redirect('profile/jobs');
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

    public function allTasks ( Request $request, Task $task, Skills $s )
    {
    	$tasks = $task->isPublic()->isApproved()->orderDesc()->get();
        $skills = $s->all();
        $tasks = fractal()->collection($tasks)
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        // dd($tasks);
    	return view('task.all')->with([ 'tasks' => $tasks, 'skills' => $skills ]);
    }

    public function getTask( Request $request, Task $task, Application $application )
    {
        // $this->authorize('is_public', $task);
        $job = fractal()->item($task)
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        // dd($job);                 
        // Get other tasks
        $other_task = $task->where('id', '!=', $task->id)->isPublic()->isApproved()->orderDesc()->take(5)->get();
        $others = fractal()->collection($other_task)
                            ->transformWith(new TaskTransformer)
                            ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                            ->toArray();

    	return view('task.single')->with([ 'task' => $job, 'others' => $others ]);
    }

    public function applyForTask( Request $request, Task $task, Application $application )
    {
        $job = fractal()->item($task)
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();

        $user = fractal()->item($request->user())
                          ->transformWith(new UserTransformers)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();

        // dd($user);
        if(!$user['first_name'] || !$user['last_name'] || !$user['location']){
            return view('task.cant_apply');
        }

        $applied = $application->where([ 'user_id'=>$request->user()->id, 'task_id' => $task->id ])->first();
        return view('task.apply')->with(['task' => $job, 'user' => $user, 'applied' => $applied ]);
    }

    public function submitApplicationForTask( Request $request, Task $task )
    {
        $application = $task->applications()->create([
                            'user_id'       => $request->user()->id,
                            'application'   => $request->application,
                            'budget'        => $request->budget
                        ]);
        $user = $task->user;
        $applicant = $request->user();
        Mail::to($user)->send(new TaskApplicationNotification($user, $applicant, $task));
        return response()->json(['application' => $application], 200);
    }

    public function interests( Request $request, Task $task )
    {
        $task = fractal()->item($task)
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        return view('task.interests')->with('task', $task);
    }

    public function applications( Request $request ){
        $applications = fractal()->collection($request->user()->applications()->get())
                          ->transformWith(new ApplicationTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        return view('task.applications')->with('applications', $applications);
    }

    public function submitApplicationResponse( Request $request, ApplicationResponse $response )
    {
        $applicationResponse = $response->create([
            'task_id'       => $request->task_id,
            'application_id'=> $request->application_id,
            'user_id'       => $request->user()->id,
            'response'      => $request->response,
        ]);

        $applicationResponse = fractal()->item($applicationResponse)
                                        ->transformWith(new ApplicationResponseTransformer)
                                        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                                        ->toArray();
        return response()->json($applicationResponse, 200);
    }

    public function approveJobs( Request $request, Task $task )
    {
        $tasks = $task->isPublic()->isNotApproved()->isNotRejected()->get();
        $tasks = fractal()->collection($tasks)
                          ->transformWith(new TaskTransformer)
                          ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                          ->toArray();
        return view('task.admin')->with([ 'tasks' => $tasks ]);
    }

    public function rejectJob( Request $request, Task $task )
    {
        if($request->user()->is_admin !== 1){
            return response()->json(null, 401);
        }
        $task->is_rejected = true;
        $task->save();

        Mail::to($task->user)->send(new JobRejectNotification($request->message, $task));
        return response()->json(null);
    }

    public function approveJob( Request $request, Task $task )
    {
        if($request->user()->is_admin !== 1){
            return response()->json(null, 401);
        }
        $task->is_approved = true;
        $task->save();

        Mail::to($task->user)->send(new JobApprovalNotification($task));
        return response()->json(null);
    }

    public function flagJob( Request $request, Task $task )
    {
        $check = $task->flags()->where('user_id', $request->user()->id)->first();
        if(!$check){
            $task->flags()->create([
                'user_id'   => $request->user()->id,
            ]);
            return response()->json(['status'=>'true'], 200);
        } else {
            return response()->json(['status'=>'flagged'], 200);
        }
    }

    public function flagJobCheck( Request $request, Task $task )
    {
        $check = $task->flags()->where(['user_id' => $request->user()->id, 'task_id' => $task->id])->first();
        if($check){
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function saveJob( Request $request, Task $task )
    {
        $check = $task->savedJob()->where(['user_id' => $request->user()->id, 'task_id' => $task->id ])->first();
        if(!$check){
            $task->savedJob()->create([
                'user_id'   => $request->user()->id,
            ]);
            return response()->json(true, 200);
        } else {
            $check->delete();
            return response()->json(false, 200);
        }
    }

    public function saveCheckJob( Request $request, Task $task )
    {
        $check = $task->savedJob()->where('user_id', $request->user()->id)->first();
        if($check){
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function savedJobs( Request $request, Task $task, SaveJob $saveJob )
    {
        $savedJobs = [];
        $saved = $saveJob->where('user_id', $request->user()->id)->get();
        if($saved){
            foreach($saved as $item){
                $getTask = Task::where('id', $item->task_id)->first();
                $task = fractal()->item($getTask)
                               ->transformWith(new TaskTransformer)
                               ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
                               ->toArray();
                array_push($savedJobs, $task);
            }
        }
        return view('task.saved')->with('tasks', $savedJobs);
    }

    // Accept application
    public function acceptApplication( Request $request, Task $task, Application $application, User $user )
    {
        // dd($request);
        // dd($request['task'][0]['title']);
        $task = $task->where('id', $request->task_id)->first();
        $this->authorize('can_accept', $task);

        // Update the job as closed
        $task->closed = true;
        $task->is_public = false;
        $task->save();

        // Update the application as accepted
        $application = $application->where('id', $request->id)->first();
        $application->accepted = true;
        $application->save();

        // Email the accepted application user
        $user = $user->where('id', $request->user_id)->first();
        Mail::to($user)->send(new ApplicationAcceptanceNotification($request['profile']['fullname'], $request['task'][0]['title'], $request['task'][0]['profile']['fullname'], $request['application'], $request['human_budget'], $request['message']));

        return response()->json(true, 200);
    }
}





