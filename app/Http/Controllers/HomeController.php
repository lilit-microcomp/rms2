<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Models\Home;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$all_commentID = $this->comment_inteface->all_comments;
        /*$tasks = DB::table('tasks')
            ->get();*/
        //dd($tasks);
        $task_comments = DB::table('comments')
            ->LeftJoin('tasks', 'tasks.id', '=', 'comments.type_page_row_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('comments.parent_id', NULL)
            ->where('comments.type_page', 'tasks')
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'tasks.*', 'projects.*', 'comments.created_at as comment_created_at', 'comments.status as comment_status', 'comments.id as comment_id')
            ->get();


        //dd($task_comments);
        $supports = DB::table('support')
            ->LeftJoin('users_support', 'users_support.support_id', '=', 'support.id')
            ->LeftJoin('users', 'users.id', '=', 'users_support.developer_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->select('support.*', 'users_support.*', 'users.*', 'support.due_date as support_due_date', 'support.id as support_id')
            ->get();
        //dd($supports);
        $tasks = DB::table('tasks')
            ->LeftJoin('users_tasks', 'users_tasks.task_id', '=', 'tasks.id')
            ->LeftJoin('users', 'users.id', '=', 'users_tasks.developer_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('access_projects', 'projects.id', '=', 'access_projects.project_id')
            ->select('tasks.*', 'users_tasks.*', 'users.*', 'projects.*', 'access_projects.*', 'projects.name as project_name', 'tasks.due_date as task_due_date', 'access_projects.data as access_data', 'tasks.status as task_status', 'tasks.id as task_taskid')
            ->get();

        $support_comments = DB::table('comments')
            ->LeftJoin('support', 'support.id', '=', 'comments.type_page_row_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->where('comments.parent_id', NULL)
            ->where('comments.type_page', 'support')
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'support.*', 'comments.created_at as comment_created_at', 'comments.status as comment_status', 'comments.id as comments_id')
            ->get();



            //dd($support_comments[0]->status);
            $s = 0;
            $i = 0;
            foreach ($support_comments as $supp_comment) {
                if ($supp_comment->comment_status == 0) {
                    $s += 1;
                }
                $aaa[$i] = $supp_comment->comment_status;
                $i++;
            }
            if ($s == 0) {
                $done_notes = "true";
            } else {
                $done_notes = "false";
            }
//dd($aaa);



        $pm = DB::table('tasks')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users', 'users.id', '=', 'projects.user_id')
            ->select('users.*', 'users.id as pm_id', 'users.email as pm_mail')
            ->get();
//dd($tasks);

        $task_files = DB::table('tasks')
            ->where('id', 4)
            ->select('files')
            ->get();

        //$task_files = $task_files[0]->files;
        //dd($id);
        //$task_files = (explode("\"[{\"files\":\"\"", $task_files));
        if ($task_files->count()) {
            $task_files = (explode(",", $task_files[0]->files));

            unset($task_files[0]);
        }





//dd();


        if (Auth::user()->role_id == 1)
            return view('dashboard/admin', compact('tasks', 'all_commentID', 'supports', 'task_comments', 'support_comments', 'pm', 'done_notes'))
                ->with([
                    'i' => (request()->input('page',1)-1) *20,
                    //'comments' => $this->comment_inteface->all_comments,

                ]);
        else
            return view('dashboard/admin', compact('tasks', 'all_commentID', 'supports', 'task_comments', 'support_comments', 'pm', 'done_notes'))
                ->with([
                    'i' => (request()->input('page',1)-1) *20,
                    //'comments' => $this->comment_inteface->all_comments,

                ]);





    }

    public function doneTask(Home $task){
        //dd($task->status);
        if ($task->status == 0) {
            $task->update(['status'=>1]);
        } else {
            $task->update(['status'=>0]);
        }



        /*$task_comments = DB::table('comments')
            ->LeftJoin('tasks', 'tasks.id', '=', 'comments.type_page_row_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('comments.parent_id', NULL)
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'tasks.*', 'projects.*', 'comments.created_at as comment_created_at', 'comments.status as comment_status')
            ->get();

        $support_comments = DB::table('comments')
            ->LeftJoin('support', 'support.id', '=', 'comments.type_page_row_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->where('comments.parent_id', NULL)
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'support.*','comments.created_at as comment_created_at', 'comments.status as comment_status')
            ->get();

        $supports = DB::table('support')
            ->LeftJoin('users_support', 'users_support.support_id', '=', 'support.id')
            ->LeftJoin('users', 'users.id', '=', 'users_support.developer_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->select('support.*', 'users_support.*', 'users.*', 'projects.name as project_name', 'support.due_date as support_due_date')

            ->get();
        //dd($supports);
        $tasks = DB::table('tasks')
            ->LeftJoin('users_tasks', 'users_tasks.task_id', '=', 'tasks.id')
            ->LeftJoin('users', 'users.id', '=', 'users_tasks.developer_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('access_projects', 'projects.id', '=', 'access_projects.project_id')
            ->select('tasks.*', 'users_tasks.*', 'users.*', 'projects.*', 'access_projects.*', 'projects.name as project_name', 'tasks.due_date as task_due_date', 'access_projects.data as access_data', 'tasks.status as task_status')
            ->get();

        $pm = DB::table('tasks')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('users', 'users.id', '=', 'projects.user_id')
            ->select('users.*', 'users.id as pm_id', 'users.email as pm_mail')
            ->get();
        //dd($pm);
        return view('dashboard/admin', compact('tasks', 'all_commentID', 'supports', 'task_comments', 'support_comments', 'pm'));*/
        return $this->index();

    }

    public function doneNote(Home $task_comment){
        dd($task_comment);
        //dd($task_comment->id = comments.type_page_row_id);
//dd($task_comment->id);
        $comm = DB::table('comments')
            ->where('comments.id', $task_comment->id)
            ->LeftJoin('tasks', 'tasks.id', '=', 'comments.type_page_row_id')
            //->where('tasks.created_at', $task_comment->created_at)
            ->select('comments.*', 'tasks.* ','comments.id as comment_id', 'comments.status as comment_status')
            ->get();
        ///dd($comm);


        //dd('kkk');


        //dd($task_comment->status);
        if ($comm[0]->comment_status == 0) {
            //dd(0);
            //$task_comment->update(['status'=>1]);
            DB::table('comments')
                ->where('id', $comm[0]->comment_id)
                ->update(array(
                    'status' => 1,
                ));
        } else {
            //dd(1);
            DB::table('comments')
                ->where('id', $comm[0]->comment_id)
                ->update(array(
                    'status' => 0,
                ));
        }



        $task_comments = DB::table('comments')
            ->LeftJoin('tasks', 'tasks.id', '=', 'comments.type_page_row_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('comments.parent_id', NULL)
            ->where('comments.type_page', 'tasks')
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'tasks.*', 'projects.*', 'comments.created_at as comment_created_at', 'comments.status as comment_status')
            ->get();

        $support_comments = DB::table('comments')
            ->LeftJoin('support', 'support.id', '=', 'comments.type_page_row_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->where('comments.parent_id', NULL)
            ->where('comments.type_page', 'support')
            ->limit(4)
            ->orderBy('comments.created_at', 'desc')
            ->select('comments.*', 'support.*', 'comments.created_at as comment_created_at', 'comments.status as comment_status')
            ->get();

        $supports = DB::table('support')
            ->LeftJoin('users_support', 'users_support.support_id', '=', 'support.id')
            ->LeftJoin('users', 'users.id', '=', 'users_support.developer_id')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->select('support.*', 'users_support.*', 'users.*', 'support.due_date as support_due_date')

            ->get();
        //dd($supports);
        $tasks = DB::table('tasks')
            ->LeftJoin('users_tasks', 'users_tasks.task_id', '=', 'tasks.id')
            ->LeftJoin('users', 'users.id', '=', 'users_tasks.developer_id')
            ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->LeftJoin('access_projects', 'projects.id', '=', 'access_projects.project_id')
            ->select('tasks.*', 'users_tasks.*', 'users.*', 'projects.*', 'access_projects.*', 'projects.name as project_name', 'tasks.due_date as task_due_date', 'access_projects.data as access_data', 'tasks.status as task_status')
            ->get();


        $s = 0;
        $i = 0;
        foreach ($support_comments as $supp_comment) {
            if ($supp_comment->comment_status == 0) {
                $s += 1;
            }
            $aaa[$i] = $supp_comment->comment_status;
            $i++;
        }
        if ($s == 0) {
            $done_notes = "true";
        } else {
            $done_notes = "false";
        }

        //return view('dashboard/admin', compact('tasks', 'all_commentID', 'supports', 'task_comments', 'support_comments', 'done_notes'));

        return $this->index();
    }


    public function doneNoteSupp(Home $supp_comment) {
        dd($supp_comment);
    }
    /*public function fileUpload(Request $request) {

//dd($request);
        //$task_id = (int)$tasks_id;//$request->fullUrl();//url()->current();
        //$task_id = substr($task_id, -1);


//dd("fff");
        $image = $request->file('image');
        $value = Session::get('_previous')['url'];
        $value = (explode("/", $value));
        //dd($value);
        $task_id = (int)$value[4];
//dd($task_id);
        $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();

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

        return back()->with('success', 'Image Upload successful');

    }*/

        /*
        public function edit(Request $request, $id) {

            DB::table('tasks')
                ->where('id', $id)
                ->update(array(
                    'status' => 1,
                ));

            $task_comments = DB::table('comments')
                ->LeftJoin('tasks', 'tasks.id', '=', 'comments.type_page_row_id')
                ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
                ->where('comments.parent_id', NULL)
                ->limit(4)
                ->orderBy('comments.created_at', 'desc')
                ->select('comments.*', 'tasks.*', 'projects.*', 'comments.created_at as comment_created_at')
                ->get();

            $supports = DB::table('support')
                ->LeftJoin('users_support', 'users_support.support_id', '=', 'support.id')
                ->LeftJoin('users', 'users.id', '=', 'users_support.developer_id')
                ->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
                ->select('support.*', 'users_support.*', 'users.*', 'projects.*', 'projects.name as project_name', 'support.due_date as support_due_date')

                ->get();
            //dd($supports);
            $tasks = DB::table('tasks')
                ->LeftJoin('users_tasks', 'users_tasks.task_id', '=', 'tasks.id')
                ->LeftJoin('users', 'users.id', '=', 'users_tasks.developer_id')
                ->LeftJoin('projects', 'projects.id', '=', 'tasks.project_id')
                ->LeftJoin('access_projects', 'projects.id', '=', 'access_projects.project_id')
                ->select('tasks.*', 'users_tasks.*', 'users.*', 'projects.*', 'access_projects.*', 'projects.name as project_name', 'tasks.due_date as task_due_date', 'access_projects.data as access_data', 'tasks.status as task_status')
                ->get();

            return 111;//view('dashboard/admin', compact('tasks', 'all_commentID', 'supports', 'task_comments'));
            return redirect()->route('/');
        }

        */






    public function fileUploadTaskDash(Request $request, $task_id) {
//dd($task_id);
        $image = $request->file('image');
        //$value = Session::get('_previous')['url'];
        //$value = (explode("/",$value));

        //$task_id = (int)$value[4];

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/images/task');

        $image->move($destinationPath, $input['imagename']);

        $files = DB::table('tasks')
            ->where('id', $task_id)
            ->select('files')
            ->get();

        DB::table('tasks')
            ->where('id', $task_id)
            ->update(array(
                'files' => $files[0]->files . "," . $input['imagename'],
            ));

        return back()->with('success','Image Upload successful');

    }


    public function fileUploadSuppDash(Request $request, $supp_id)
    {
        //dd($supp_id);
        $image = $request->file('image');
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/images/support');
        $image->move($destinationPath, $input['imagename']);
        $files = DB::table('support')
            ->where('id', $supp_id)
            ->select('files')
            ->get();
        DB::table('support')
            ->where('id', $supp_id)
            ->update(array(
                'files' => $files[0]->files . "," . $input['imagename'],
            ));
        return back()->with('success','Image Upload successful');
    }
}
