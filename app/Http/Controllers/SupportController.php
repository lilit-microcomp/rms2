<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;
use Session;
use App\User;
use App\Models\Clients;
use App\Models\Support;
use App\Models\Projects;
use App\Models\Comments;
use App\Models\UsersSupport;
use Illuminate\Support\Facades\Input;
use App\Helpers\Contracts\CommentInterface;


class SupportController extends Controller
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
        $users = User::select(['id','firstname'])
            //->where('role_id', 0)
            ->pluck('firstname', 'id');


        /*$support = DB::table('projects')
                    ->LeftJoin('support', 'projects.id', '=', 'support.project_id')
                    ->LeftJoin('users_support', 'support.id', '=', 'users_support.support_id')
                    ->where("support.status", "=", 0)
                    ->select('projects.*', 'support.*', 'support.id as support_supportid', 'users_support.*')
                    ->paginate(20);*/
        $support = DB::table('support')
                    ->LeftJoin('users_support', 'support.id', '=', 'users_support.support_id')
                    ->where("support.status", "=", 1)
                    ->orWhere("support.status", "=", 0 )
                    ->select('support.*', 'support.id as support_supportid', 'users_support.*', 'support.status as supp_suppstatus')
                    ->paginate(20);
//dd($support);
        $users_projects = DB::table('users_projects')
                        ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                        ->get();

        return view('admin.support.index', compact('support', 'users', 'users_projects'))
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
        $pm_user = User::select(['id','firstname'])
            ->where('role_id', 2)
            ->orWhere('role_id', 1)
            ->pluck('firstname', 'id');
        return view('admin.support.crud.create', compact('clients', 'users', 'lead_user', 'dev_user', 'pm_user'));
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
        //dd($request['access_data']);
        request()->validate([
            'client_id'     => 'required',
            'project_url'   => 'required',
            'due_date'      => 'required',
            'team_lead_id'  => 'required',
            'developer_id'  => 'required',
            'pm_id'         => 'required',
            'description'   => 'required',
            'access_data'   => 'required',

        ]);
        //dd($request);
        $support = Support::create([
            'client_id' => $request['client_id'],
            'project_url' => $request['project_url'],
            'due_date' => $request['due_date'],
            'duration' => $request['duration'],
            'description' => $request['description'],
            'access_data' => $request['access_data'],
            'searchable_words[' => $request['project_url'] . " " . $request['description'] . " " . $request['client_id'],
            'send_email_notification' => $request['send_email_notification'],
        ]);
        // dd($request['developer_id']);

        UsersSupport::create([
            'developer_id' => $request['developer_id'],
            'team_lead_id' => $request['team_lead_id'],
            'support_id' => $support->id,
            'pm_id' => $request['pm_id'],
        ]);



        $pm_id = Input::get('pm_id');
        $dev_id = Input::get('developer_id');
        $lead_id = Input::get('team_lead_id');

        $pm = User::select('users')
            ->where('id', $pm_id)
            ->select('users.*')
            ->get();
        $dev = User::select('users')
            ->where('id', $dev_id)
            ->select('users.*')
            ->get();
        $lead = User::select('users')
            ->where('id', $lead_id)
            ->select('users.*')
            ->get();

        Mail::send('emails.supp_create', array('name'=>$pm[0]->firstname, 'proj_url'=>$request['project_url']), function($message){
            //$a = $pm_id;
            $pm_id = Input::get('pm_id');
            $user = User::select('users')
                ->where('id', $pm_id)
                ->select('users.*')
                ->get();
            $message->to($user[0]->email, $user[0]->firstname.' '.$user[0]->lastname)->subject('Micro-comp LLC registeration info');
        });

        Mail::send('emails.supp_create', array('name'=>$dev[0]->firstname, 'proj_url'=>$request['project_url']), function($message){
            //$a = $pm_id;
            $dev_id = Input::get('developer_id');
            $user = User::select('users')
                ->where('id', $dev_id)
                ->select('users.*')
                ->get();
            $message->to($user[0]->email, $user[0]->firstname.' '.$user[0]->lastname)->subject('Micro-comp LLC registeration info');
        });

        Mail::send('emails.supp_create', array('name'=>$lead[0]->firstname, 'proj_url'=>$request['project_url']), function($message){
            //$a = $pm_id;
            $lead_id = Input::get('team_lead_id');
            $user = User::select('users')
                ->where('id', $lead_id)
                ->select('users.*')
                ->get();
            $message->to($user[0]->email, $user[0]->firstname.' '.$user[0]->lastname)->subject('Micro-comp LLC registeration info');
        });


        return redirect()->route('support.index')
                ->with('success', 'Support created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clients = DB::table('support')
            //->LeftJoin('projects', 'projects.id', '=', 'support.project_id')
            ->LeftJoin('clients', 'clients.id', '=', 'support.client_id')
            ->where('support.id', $id)
            ->get();

        $users = User::select(['id','firstname'])
            //->where('role_id', 0)
            ->pluck('firstname', 'id');

        $comments = $this->comment_inteface->setAllCommentsByTypeAndId($id,'support');

        /*$projects = DB::table('projects')
            ->LeftJoin('support', 'projects.id', '=', 'support.project_id')
            ->where("support.id", $id)
            ->get();

        $access_data = DB::table('access_projects')
            ->where('project_id', $projects[0]->id)
            ->get();*/

        $support = DB::table('support')
            //->LeftJoin('support', 'projects.id', '=', 'support.project_id')
            ->LeftJoin('users_support', 'support.id', '=', 'users_support.id')
            ->LeftJoin('users', 'users_support.developer_id', '=', 'users.id')
            ->where("support.status", "=", 0)
            ->where("support.id", $id)
            ->get();


        $supports = Support::find($id);

        $support_files = DB::table('support')
            ->where('id', $id)
            ->select('files')
            ->get();

        $support_files = (explode(",", $support_files[0]->files));
        unset($support_files[0]);

        $destinationPath = public_path('/images/support');

        /*$users_projects = DB::table('users_projects')
            ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
            ->get();

        $access_data = DB::table('access_projects')
            ->where('project_id', $id)
            ->get();*/

        $all_commentID = $this->comment_inteface->all_comments;

        return view('admin.support.crud.show', compact('support', 'users', 'users_projects', 'clients', 'supports', 'all_commentID', 'access_data', 'support_files', 'destinationPath'))
            ->with([
                'i' => (request()->input('page',1)-1) *20,
                'comments' => $this->comment_inteface->all_comments,
                //'barev' => DB::table('users')->where('id', $comments->user_id)->value('firstname'), //'admin',

            ]);
        //dd($users_projects);
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
        $pm_user = User::select(['id','firstname'])
            ->where('role_id', 2)
            ->orWhere('role_id', 1)
            ->pluck('firstname', 'id');
//dd($users);

        $support = DB::table('support')
                    //->LeftJoin('support', 'projects.id', '=', 'support.project_id')
                    ->LeftJoin('users_support', 'support.id', '=', 'users_support.support_id')
                    ->where("support.status", "=", 0)
                    ->where("support.id", $id)
                    ->select('support.*', 'support.id as support_supportid', 'users_support.*')
                    ->get();

        $cycle_date1 = $support[0]->due_date; //
        if (!$cycle_date1 == null) {
            $cycle_date = explode('-', $cycle_date1);//"2016-04-30";
            $cycle_year = (int)$cycle_date[0];
            $cycle_month = (int)$cycle_date[1];
            $cycle_day = (int)$cycle_date[2];

            $now_date = date("Y-m-d");
            $now_month = explode('-', $now_date);
            $now_day = (int)$now_month[2];
            $now_month = (int)$now_month[1];

//dd();


            if ($cycle_day < $now_day && $cycle_month < $now_month || $cycle_day < $now_day && $cycle_month == $now_month || $cycle_month <= $now_month) {
                // for february 28 and 29
                if ($cycle_month == 1 && $cycle_day > 28) {
                    //dd(1);

                    if ($cycle_year % 4 == 0) {
                        //dd($cycle_date1);
                        //$cycle_day == 31 ? $count = 29 : $count = 28;
                        if ($cycle_day == 31)
                            $count = 29;
                        elseif ($cycle_day == 30)
                            $count = 30;
                        else
                            $count = 31;
                        $cycle_date1 = date('Y-m-d', strtotime($cycle_date1 . " + $count days"));
                    } else {
                        //dd('jj');
                        if ($cycle_day == 31)
                            $count = 28;
                        elseif ($cycle_day == 30)
                            $count = 29;
                        elseif ($cycle_day == 29)
                            $count = 30;
                        $cycle_date1 = date('Y-m-d', strtotime($cycle_date1 . " + $count days"));
                    }
                    //if ($cycle_day == 29 && ) {
                }


                // for months 30 and 31
                elseif ($cycle_day == 31) {
                    //dd(2);
                    if ($cycle_month == 3 || $cycle_month == 5 || $cycle_month == 8 || $cycle_month == 10) {
                        $cycle_date1 = date('Y-m-d', strtotime($cycle_date1 . ' + 30 days'));
                    }
                    else {
                        //dd(3);
                        $cycle_date1 = date('Y-m-d', strtotime($cycle_date1 . ' + 1 month'));
                    }
                }
                else {
                    //dd(4);
                    $cycle_date1 = date('Y-m-d', strtotime($cycle_date1 . ' + 1 month'));
                }

            }
        }

//dd($cycle_date1);
//dd($now_month . " x " .$cycle_month);
        /*$users_projects = DB::table('users_projects')
                        ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                        ->get();
        $proj = Projects::all(['id', 'name'])->pluck('name', 'id');*/

        return view('admin.support.crud.edit', compact('support', 'users', 'users_support', 'clients', 'proj', 'users_projects', 'lead_user', 'dev_user', 'pm_user', 'cycle_date1'))
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

        request()->validate([
            'client_id'     => 'required',
            'project_url'   => 'required',
            'due_date'      => 'required',
            'team_lead_id'  => 'required',
            'developer_id'  => 'required',
            'pm_id'         => 'required',
            'description'   => 'required',
            'access_data'   => 'required',

        ]);
        Support::find($id)->update([
            //'project_id' => $request['project_id'],
            'project_url' => $request['project_url'],
            'due_date' => $request['due_date'],
            'duration' => $request['duration'],
            'description' => $request['description'],
            'access_data' => $request['access_data'],
            'send_email_notification' => $request['send_email_notification'],
        ]);

        UsersSupport::find($id)->update([
            'developer_id' => $request['developer_id'],
            'team_lead_id' => $request['team_lead_id'],
            'support_id' => $id,
            'pm_id' => $request['pm_id'],
        ]);

        /*UsersSupport::find($id)->update([
            'developer_id' => 37,//$request['developer_id'],
            'team_lead_id' => 39, //$request['team_lead_id'],
            'support_id' => $id,
        ]);

        UsersSupport::create([
            'developer_id' => $request['developer_id'],
            'team_lead_id' => $request['team_lead_id'],
            'support_id' => $support->id,
        ]);*/



        DB::table('users_support')
            ->where('support_id', $id)
            ->update(array(
                'developer_id' => $request['developer_id'],
                'team_lead_id' => $request['team_lead_id'],
                'support_id' => $id,
            ));




        return redirect()->route('support.index')
                ->with('success', 'Support edited successfully.');
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
        /*$stud = DB::table('support')
            ->join('users_support','support.id','=','users_support.support_id')
            ->where('support.id','=',$id)->get();
            //->get();
        //dd($stud);
        $stud->delete();


        //User::find($id)->delete();*/

        DB::table('support')
            ->where('id', $id)
            ->delete();

        DB::table('users_support')
            ->where('support_id', $id)
            ->delete();


        return redirect()->route('support.index')
            ->with('success','Support deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userSupport($user_id)
    {
        $users = User::select(['id','firstname'])
            ->where('role_id', 0)
            ->pluck('firstname', 'id');

        $support = DB::table('clients')
                    ->LeftJoin('support', 'clients.id', '=', 'support.clients_id')
                    ->LeftJoin('users_support', 'support.id', '=', 'users_support.support_id')
                    ->where("support.status", "=", 0)
                    ->where("users_support.developer_id", $user_id)
                    ->paginate(20);

        $users_projects = DB::table('users_projects')
                        ->LeftJoin('users', 'users.id', '=', 'users_projects.user_id')
                        ->get();


        return view('admin.support.index', compact('support', 'users', 'users_projects'))
                ->with('i',(request()->input('page',1)-1) *20);
    }




    public function saveComment(Request $request, $support_id)
    {

        $id = Auth::id();

        $user_name = DB::table('users')->where('id', $id)->value('firstname');

        if($request['comment_parent_id']){
            $commentParent = Comments::find($request['comment_parent_id']);

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
                'parent_id' => $request['comment_parent_id'],
                'user_id' => $id,
                'user_name' => $user_name,
                'type_page' => 'support',
                'type_page_row_id' => $support_id,
                'status' => 0
            ]);
        }





        return redirect()->route('support.show', $support_id)
            ->with('success', 'Comment created successfully.');
    }


    public function doneSupp(Support $supp) {
        //dd($task->status);
        if ($supp->status == 0) {
            $supp->update(['status'=>1]);
            DB::table('users_tasks')
                ->where('task_id', $supp->id)
                ->update(array(
                    'status' => 1,
                ));
        } else {
            $supp->update(['status'=>0]);
            DB::table('users_tasks')
                ->where('task_id', $supp->id)
                ->update(array(
                    'status' => 0,
                ));
        }

        //dd('ok');

        //return view('admin.tasks.index');
        return $this->index();


    }





    public function fileUploadSupp(Request $request) {
//dd('barev');
        $image = $request->file('image');
        $value = Session::get('_previous')['url'];
        $value = (explode("/",$value));

        $supp_id = (int)$value[4];

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/images/support');

        $image->move($destinationPath, $input['imagename']);

        $files = DB::table('support')
            ->where('id', $supp_id)
            ->select('files')
            ->get();
        //$a = $files[0]->files ."asdfg;";
        //dd($a);
        DB::table('support')
            ->where('id', $supp_id)
            ->update(array(
                'files' => $files[0]->files . "," . $input['imagename'],
            ));

        return back()->with('success','Image Upload successful');

    }

}
