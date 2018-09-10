<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Helpers\Contracts\CommentInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;

use App\Models\Tasks;
use App\Models\Clients;
use App\Models\UsersTasks;
use App\Models\AccessProjects;

use App\Models\Comments;
use App\User;
use DB;
use Session;


class TasksController extends Controller
{
    protected $comment_inteface;

    public function __construct(CommentInterface $comment_inteface){
        $this->comment_inteface = $comment_inteface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd("aaa");
        $users = User::select(['id','firstname'])
            //->where('role_id', 0)
            ->pluck('firstname', 'id');
            //->get();
        // $tasks = DB::table('tasks')
        //             ->where("tasks.status", "=", 0)
        //             ->LeftJoin('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
        //             ->LeftJoin('users', 'users.id', '=', 'users_tasks.user_id')
        //             ->select('tasks.*', DB::raw('group_concat(user_id) as users_id'), DB::raw('group_concat(firstname) as users_name'))
        //             ->groupBy('users_tasks.task_id', 'tasks.id')
        //             ->get();


        $tasks = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
            ->LeftJoin('clients', 'projects.client_id', '=', 'clients.id')
            ->select('projects.*', 'tasks.*', 'tasks.id as task_taskid', 'tasks.status as task_taskstatus', 'users_tasks.*', 'clients.*')
            ->where("tasks.status", "=", 1 )
            ->orWhere("tasks.status", "=", 0 )
            ->paginate(20);

        //dd($tasks);

        $users_projects = DB::table('users_projects')
            ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
            ->get();

        //dd($users);

        return view('admin.tasks.index', compact('tasks', 'users', 'users_projects'))
            ->with('i',(request()->input('page',1)-1) *20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Clients::all(['id', 'companyname'])->pluck('companyname', 'id');
        //$users = User::all(['id','firstname'])->pluck('firstname', 'id');
        $lead_user = User::select(['id','firstname'])
            ->where('role_id', 4)
            ->pluck('firstname', 'id');
        $dev_user = User::select(['id','firstname'])
            ->where('role_id', 3)
            ->pluck('firstname', 'id');
        return view('admin.tasks.crud.create', compact('clients', 'users', 'lead_user', 'dev_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//dd($request);
        request()->validate([
            'client_id'     => 'required',
            'project_id'    => 'required',
            'developer_id'  => 'required',

        ]);
//dd($request['team_lead_id']);
        $tasks = Tasks::create([
            'project_id' => $request['project_id'],
            'due_date' => $request['due_date'],
            'duration' => $request['duration'],
            'description' => $request['description'],
            'send_email_notification' => $request['send_email_notification'],
        ]);

        UsersTasks::create([

            'developer_id' => $request['developer_id'],
            'team_lead_id' => $request['team_lead_id'],
            'task_id' => $tasks->id,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tasks created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$clients = Clients::all(['id', 'companyname'])->pluck('companyname', 'id');

        $clients = DB::table('tasks')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('clients', 'clients.id', '=', 'projects.client_id')
            ->where('tasks.id', $id)
            ->get();
        //dd($aa);
        //companyname
        //email
        //phonenumber
        //fa fa-phone

        $users = User::select(['id','firstname'])
            ->where('role_id', 0)
            ->pluck('firstname', 'id');


        $comments = $this->comment_inteface->setAllCommentsByTypeAndId($id,'tasks');



        //$projects = Projects::all(['id', 'name'])->pluck('name', 'id');
        $projects = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->where("tasks.id", $id)
            ->get();
        //dd($projects[0]->project_url);


        /*$access_data = DB::table('access_projects')
            ->where('project_id', $projects[0]->id)
            ->get();*/



        $task = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
            ->LeftJoin('users', 'users_tasks.developer_id', '=', 'users.id')
            ->where("tasks.status", "=", 0)
            //->orWhere("tasks.status", "=", 1)
            ->where("tasks.id", $id)
            ->select('projects.*', 'tasks.*', 'users_tasks.*', 'users.*', 'tasks.id as task_id')
            ->get();



        $users_projects = DB::table('users_projects')
            ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
            ->get();
        $tasks = Tasks::find($id);
//dd($task[0]->description);
        $access_data = DB::table('access_projects')
            ->where('project_id', $task[0]->project_id)
            ->get();

//dd($access_data);
        $acc = strip_tags($access_data[0]->data);
        //dd($id);
        $task_files = DB::table('tasks')
            ->where('id', $id)
            ->select('files')
            ->get();

        //$task_files = $task_files[0]->files;
        //dd($id);
        //$task_files = (explode("\"[{\"files\":\"\"", $task_files));
        $task_files = (explode(",", $task_files[0]->files));
        unset($task_files[0]);
//dd($task_files);

        $destinationPath = public_path('/images');

        //dd($task_files);
       /* //dd($access_data);
if (isset($access_data) && !empty($access_data[0])) {
    dd($access_data[0]->data);
} else {
    dd("datark");
}*/


        //$aa = DB::table('users')->where('id', $comments['user_id'])->value('firstname');
        //$comments = Comments::find($id);
        $all_commentID = $this->comment_inteface->all_comments;
        //dd($all_commentID);
//dd(strip_tags($this->comment_inteface->all_comments));
        //$userID_comment = $this->comment_inteface->all_comments[3]['user_id'];
        // dd(count($all_commentID));

        // $data = array_merge($users,$users_projects);
        // dd($task[0]->id);
        //$a = strip_tags($this->comment_inteface->all_comments);
        //dd("barev");

//dd($access_data);
        //dd($comments);
        //!empty($access_data)? dd("full") : dd("err");
        return view('admin.tasks.crud.show', compact('task', 'users', 'users_projects', 'clients', 'tasks', 'all_commentID', 'projects', 'access_data', 'task_files', 'destinationPath', 'acc'))
            ->with([
                'i' => (request()->input('page',1)-1) *20,
                'comments' => $this->comment_inteface->all_comments,
                //'barev' => DB::table('users')->where('id', $comments->user_id)->value('firstname'), //'admin',

            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients = Clients::all(['id', 'companyname'])->pluck('companyname', 'id');
        $proj = Projects::all(['id', 'name'])->pluck('name', 'id');
        /*$users = User::select(['id','firstname'])
            ->where('role_id', 0)
            ->pluck('firstname', 'id');*/
        //$users = User::all(['id','firstname'])->pluck('firstname', 'id');
        $lead_user = User::select(['id','firstname'])
            ->where('role_id', 4)
            ->pluck('firstname', 'id');
        $dev_user = User::select(['id','firstname'])
            ->where('role_id', 3)
            ->pluck('firstname', 'id');

        $task = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
            ->where("tasks.status", "=", 0)
            ->orWhere("tasks.status", "=", 1)
            ->where("tasks.id", $id)
            ->select('projects.*', 'tasks.*', 'tasks.id as task_taskid', 'users_tasks.*')
            ->get();
        //dd($task);
        $users_projects = DB::table('users_projects')
            ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
            ->get();


/*$us = DB::table('users_tasks')
    ->where('task_id', $id)
    ->get();*/

        //$projects = Projects::all(['id', 'name'])->pluck('name', 'id');
        $projects = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->where("tasks.id", $id)
            ->select('projects.name')
            ->get();
        //dd($us);

        //dd($projects);
        // $data = array_merge($users,$users_projects);
        // dd($task[0]->id);

//dd($users_projects);


        //return view('admin.tasks.crud.create', compact('clients', 'users'));

        return view('admin.tasks.crud.edit', compact('task', 'users', 'users_projects', 'clients', 'projects', 'proj', 'lead_user', 'dev_user'))
            ->with('i',(request()->input('page',1)-1) *20);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request->all();
        //$aa = $request['project_id'];
        //dd($request);


        /*Tasks::find($id)->update([
            'project_id' => $request['project_id'],
            'due_date' => $request['due_date'],
            'duration' => $request['duration'],
            'description' => $request['description'],
            'send_email_notification' => $request['send_email_notification'],
        ]);*/

        DB::table('tasks')
            ->where('id', $id)
            ->update(array(
                //'project_id' => $request['project_id'],
                'due_date' => $request['due_date'],
                'duration' => $request['duration'],
                'description' => $request['description'],
                'send_email_notification' => $request['send_email_notification'],
            ));



        /*UsersTasks::create([
            'developer_id' => 37, ///$request['developer_id'],
            'team_lead_id' => 39, //$request['team_lead_id'],
            'task_id' => $id, //$tasks->id,
        ]);*/
        DB::table('users_tasks')
            ->where('id', $id)
            ->update(array(
                'developer_id' => $request['developer_id'],
                'team_lead_id' => $request['team_lead_id'],
                'task_id' => $id,
            ));
        return redirect()->route('tasks.index')
            ->with('success', 'Tasks edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        DB::table('tasks')
            ->where('id', $id)
            ->delete();

        DB::table('users_tasks')
            ->where('task_id', $id)
            ->delete();

        return redirect()->route('tasks.index')
            ->with('success','Task deleted successfully.');

        //Tasks::find($id)->delete();
        //$post = Post::where('id', $id);

        /*DB::table('tasks')->where('id', '=', $id)->delete();
        DB::table('users_tasks')->where('task_id', '=', $id)->delete();

        return redirect()->route('tasks.index')
            ->with('success','User deleted 0.');*/
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userTasks($user_id)
    {
        $users = User::select(['id','firstname'])
            ->where('role_id', 0)
            ->pluck('firstname', 'id');

        $tasks = DB::table('projects')
            ->LeftJoin('tasks', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users_tasks', 'tasks.id', '=', 'users_tasks.task_id')
            ->LeftJoin('clients', 'projects.client_id', '=', 'clients.id')
            ->where("tasks.status", "=", 0)
            ->where("users_tasks.developer_id", $user_id)
            ->paginate(20);

        $users_projects = DB::table('users_projects')
            ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
            ->get();


        return view('admin.tasks.index', compact('tasks', 'users', 'users_projects'))
            ->with('i',(request()->input('page',1)-1) *20);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveComment(Request $request, $task_id)
    {
//dd($task_taskid);
        $id = Auth::id();

        $user_name = DB::table('users')->where('id', $id)->value('firstname');
//dd($task_id);
        if($request['comment_parent_id']){
            $commentParent = Comments::find($request['comment_parent_id']);
//dd($commentParent->type_page_row_id);
            Comments::create([
                'text' => $request['create_comment'],
                'parent_id' => $request['comment_parent_id'],
                'user_id' => $id,
                'user_name' => $user_name,
                'type_page' => $commentParent->type_page,
                'type_page_row_id' => $commentParent->type_page_row_id,
                'status' => 0
            ]);
        } else {
            Comments::create([
                'text' => $request['create_comment'],
                'type' => 'f',
                'parent_id' => $request['comment_parent_id'],
                'user_id' => $id,
                'user_name' => $user_name,
                'type_page' => 'tasks',
                'type_page_row_id' => $task_id,
                'status' => 0
            ]);
        }


//dd('ddd');


        return redirect()->route('tasks.show', $task_id)
            ->with('success', 'Comment created successfully.');
    }


    /*public function fileUpload(Tasks $tasks) {
        //$input = $this->save_file($tasks);
        dd($tasks);
        //$input = $this->save_file($request);
        //$input['user_id'] = \Auth::user()->id;
        //if(Template::create($input)){
        //    flash('Template successfuly uploaded','success');
        //    return back();
        //}else{
        //    flash('Oops, something went wrong','danger');
        //    return back();
        //}
    }*/




    public function fileUpload(Request $request) {
//dd($request);
        //$task_id = (int)$tasks_id;//$request->fullUrl();//url()->current();
        //$task_id = substr($task_id, -1);



//dd("fff");
        $image = $request->file('image');
        $value = Session::get('_previous')['url'];
        $value = (explode("/",$value));

        $task_id = (int)$value[4];
        //dd($task_id);
//dd($task_id);
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/images');
//dd($destinationPath);
        $image->move($destinationPath, $input['imagename']);


        //$this->postImage->add($input);

//dd($task_id);
        $files = DB::table('tasks')
            ->where('id', $task_id)
            ->select('files')
            ->get();
        //$a = $files[0]->files ."asdfg;";
        //dd($a);
        DB::table('tasks')
            ->where('id', $task_id)
            ->update(array(
                'files' => $files[0]->files . "," . $input['imagename'],
            ));

        return back()->with('success','Image Upload successful');







        /*$a = $request->fullUrl();//url()->current();
        $task_id = (int)substr($a, -1);
        //dd($a);

        $this->validate($request, [

            'image' => 'required|max:2048',

        ]);


        $image = $request->file('image');
        //dd($image);
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $input['imagename']);

        //$this->postImage->add($input);

        DB::table('tasks')
            ->where('id', $task_id)
            ->update(array(
                'files' => $input['imagename'],
            ));

        return back()->with('success','Image Upload successful');*/

    }



    /*private function save_file(Tasks $tasks){
        $input = $tasks->all();
        if($file = $tasks->file('file_name')){
            $name = $file->getClientOriginalName();
            if(file_exists(public_path().'/uploads/tasks/'.$name)){
                $actual_name = pathinfo($name, PATHINFO_FILENAME);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $name = $actual_name."_".uniqid(rand(), true).".".$extension;
            }
            $file->move('uploads/tasks', $name);
            $input['file_name'] = $name;
        }
        return $input;
    }*/



    public function saveAccessData(Request $request, $task_id) {

        $access = DB::table('access_projects')
            ->LeftJoin('projects', 'projects.id', '=', 'access_projects.project_id')
            ->LeftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
            ->where('tasks.id', '=', $task_id)
            ->get();

        DB::table('access_projects')
            ->where('id', $access[0]->id)
            ->update(array(
                //'project_id' => $request['project_id'],
                'data' => $request['data'],
            ));

        return back();

    }




    public function setTestUrl(Request $request, $task_id) {

        //dd('');
        $project = DB::table('projects')
            ->LeftJoin('tasks', 'tasks.project_id', '=', 'projects.id')
            ->where('tasks.id', '=', $task_id)
            ->get();

        DB::table('projects')
            ->where('id', $project[0]->id)
            ->update(array(
                //'project_id' => $request['project_id'],
                'project_url' => $request['project_url'],
            ));

        return back();

    }


    public function doneTask(Tasks $task) {
        //dd($task->status);
        if ($task->status == 0) {
            $task->update(['status'=>1]);
            DB::table('users_tasks')
                ->where('task_id', $task->id)
                ->update(array(
                    'status' => 1,
                ));
        } else {
            $task->update(['status'=>0]);
            DB::table('users_tasks')
                ->where('task_id', $task->id)
                ->update(array(
                    'status' => 0,
                ));
        }

        //dd('ok');

        //return view('admin.tasks.index');
        return $this->index();


    }


}
