<?php

namespace App\Http\Controllers;

//use Request;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;
use App\User;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\UsersProjects;
use App\Models\AccessProjects;
use App\Http\Controllers\Session;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Helper\Table;

class ProjectsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('888');
        echo "barev111";
        $url = \Request::server('REQUEST_URI');
        //dd($url);
        if (strpos($url, '?') !== false) {
            $status = explode("?",$url);
            $status = $status[1];
            //dd($status);
            if($status == 1 || $status == 0) {
                $projects = DB::table('clients')
                    ->LeftJoin('projects', 'projects.client_id', '=', 'clients.id')
                    ->LeftJoin('users_projects', 'projects.id', '=', 'users_projects.project_id')
                    ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                    ->where("projects.status", "=", $status)
                    //->orWhere("projects.status", "=", 0 )
                    ->select('clients.*', 'projects.*', 'users_projects.*', 'users.*', 'projects.id as proj_projid', 'projects.status as proj_projstatus', 'projects.descriptive_title as proj_desc_title', 'projects.project_url as proj_url')
                    ->paginate(20);
            }
            else {
                $projects = DB::table('clients')
                    ->LeftJoin('projects', 'projects.client_id', '=', 'clients.id')
                    ->LeftJoin('users_projects', 'projects.id', '=', 'users_projects.project_id')
                    ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                    ->where("projects.status", "=", 1)
                    ->orWhere("projects.status", "=", 0 )
                    ->select('clients.*', 'projects.*', 'users_projects.*', 'users.*', 'projects.id as proj_projid', 'projects.status as proj_projstatus', 'projects.descriptive_title as proj_desc_title', 'projects.project_url as proj_url')
                    ->paginate(20);
            }






        } else {
            $projects = DB::table('clients')
                ->LeftJoin('projects', 'projects.client_id', '=', 'clients.id')
                ->LeftJoin('users_projects', 'projects.id', '=', 'users_projects.project_id')
                ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                ->where("projects.status", "=", 1)
                ->orWhere("projects.status", "=", 0 )
                ->select('clients.*', 'projects.*', 'users_projects.*', 'users.*', 'projects.id as proj_projid', 'projects.status as proj_projstatus', 'projects.descriptive_title as proj_desc_title', 'projects.project_url as proj_url')
                ->paginate(20);
        }






        return view('admin.projects.index', compact('projects', 'users_projects'));
                //->with('i',(request()->input('page',1)-1) *20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Clients::select(['id', 'companyname'])
                        ->pluck('companyname', 'id');
        $users = User::select(['id','firstname'])
                        ->where('role_id', 1)
                        ->orWhere('role_id', 2)
                        ->pluck('firstname', 'id');

                        // dd($managers);
        return view('admin.projects.crud.create', compact('users', 'clients'));
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
        $this->request = $request;
        $validatedData = $request->validate([
            'name'              => 'required|max:255',
            'client_id'         => 'required',
            'user_id'           => 'required',
            'due_date'          => 'required',
            'descriptive_title' => 'required',
            'project_url'       => 'required',
            'total_budget'      => 'required',
            'description'       => 'required',
            'access_data'       => 'required',

        ]);

//dd($validatedData);
        $projects = Projects::create([
            'name' => $request['name'],
            'client_id' => $request['client_id'],
            'user_id' => $request['user_id'],
            'due_date' => $request['due_date'],
            'descriptive_title' => $request['descriptive_title'],
            'project_url' => $request['project_url'],
            //'project_url_test' => $request['project_url_test'],
            'total_budget' => $request['total_budget'],
            'description' => $request['description'],
            'send_email_notification' => $request['send_email_notification'],
        ]);

        if($request['access_data']){
            AccessProjects::create([
                'project_id' => $projects->id,
                'data' => $request['access_data'],
            ]);
        }

        UsersProjects::create([
            'project_id' => $projects->id,
            'user_id' => $request['user_id'],
        ]);



        //dd($user[0]->email);
//dd($request['due_date']);

        if ($request['send_email_notification'] == "1") {
            //dd('yes');

            $pm_id = Input::get('user_id');
            $user = User::select('users')
                ->where('id', $pm_id)
                ->select('users.*')
                ->get();

            Mail::send('emails.proj_create_pm', array('name'=>$user[0]->firstname, 'deadline'=>$user[0]->due_date, 'description'=>$user[0]->description), function($message){

                //$a = $pm_id;
                $pm_id = Input::get('user_id');
                $user = User::select('users')
                    ->where('id', $pm_id)
                    ->select('users.*')
                    ->get();

                $message->to($user[0]->email, $user[0]->firstname.' '.$user[0]->lastname)->subject('Micro-comp LLC registeration info');
            });
        }


        return redirect()->route('projects.index')
                ->with('success', 'Thank you, new project created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project =  DB::table('projects')
                        ->where('id', $id)
                        ->get();

        $users = User::select(['id','firstname'])
                        ->where('role_id', 1)
                        ->orWhere('role_id', 2)
                        ->pluck('firstname', 'id');

        $clients = Clients::select(['id', 'companyname'])
                        ->pluck('companyname', 'id');

        $proj =  Projects::find($id);

        $access_data = DB::table('access_projects')
            ->where('project_id', $id)
            ->get();
        /*if (!$access_data->count() ) {
            $a = "null";
        } else {
            $a = "full";
        }*/
//dd($a);
        /*if($request['access_data']){
            AccessProjects::create([
                'project_id' => $projects->id,
                'data' => $request['access_data'],
            ]);
        }*/


        return view('admin.projects.crud.edit', compact('project', 'users', 'clients','proj', 'access_data'));
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

        $validatedData = $request->validate([
            'name'              => 'required|max:255',
            'client_id'         => 'required',
            'user_id'           => 'required',
            'due_date'          => 'required',
            'descriptive_title' => 'required',
            'project_url'       => 'required',
            'total_budget'      => 'required',
            'description'       => 'required',
            'access_data'       => 'required',

        ]);
         $request = $request->all();
         //dd($request);
        $projects = Projects::find($id)->update([
            'name' => $request['name'],
            'client_id' => $request['client_id'],
            'user_id' => $request['user_id'],
            'due_date' => $request['due_date'],
            'descriptive_title' => $request['descriptive_title'],
            'project_url' => $request['project_url'],
            //'project_url_test' => $request['project_url_test'],
            'total_budget' => $request['total_budget'],
            'description' => $request['description'],
            'send_email_notification' => $request['send_email_notification'],
        ]);


        DB::table('users_projects')
            ->where('project_id', $id)
            ->update(array(
                'project_id' => $id,
                'user_id' => $request['user_id'],
            ));


        if($request['access_data']){
            //dd('access');
            /*AccessProjects::create([
                'project_id' => $projects->id,
                'data' => $request['access_data'],
            ]);*/



//dd($id);
            $a = DB::table('access_projects')
                ->where('project_id', $id)
                ->get();


//dd($a);
            if ($a->count()) {
                //dd("update");
                DB::table('access_projects')
                    ->where('project_id', $id)
                    ->update(array(
                        'project_id' => $id,
                        'data' => $request['access_data'],
                    ));
            } else {
                //dd("create");
                AccessProjects::create([
                    'project_id' => $id,
                    'data' => $request['access_data'],
                ]);
            }
        }



        return redirect()->route('projects.index')
                ->with('success', 'Thank you, new project updated successfully!');
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
        //Projects::find($id)->update(['status'=> 1]);


//dd($id);
        DB::table('projects')
            ->where('user_id', $id)
            ->delete();
        //Projects::find($id)->flush();
        //flush($project);

        return redirect()->route('projects.index')
                ->with('success','Project deleted successfully.');



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getProjects($id) {
        $projects = Projects::where("client_id",$id)->pluck("name","id");

       return json_encode($projects);

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function comments($id)
   {
       $project = DB::table('projects')
                       ->where('id', $id)
                       ->get();

       $users = User::select(['id','firstname'])
                       ->where('role_id', 1)
                       ->pluck('firstname', 'id');

       $clients = Clients::select(['id', 'companyname'])
                       ->pluck('companyname', 'id');


       return view('admin.projects.comments', compact('project', 'users', 'clients'));
   }


    public function doneProj(Projects $proj) {
        //dd($task->status);
        if ($proj->status == 0) {
            $proj->update(['status'=>1]);
            DB::table('users_tasks')
                ->where('task_id', $proj->id)
                ->update(array(
                    'status' => 1,
                ));
        } else {
            $proj->update(['status'=>0]);
            DB::table('users_tasks')
                ->where('task_id', $proj->id)
                ->update(array(
                    'status' => 0,
                ));
        }

        //dd('ok');

        //return view('admin.tasks.index');
        return $this->index();


    }
}
