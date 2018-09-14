<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \DB;
use Mail;
use Auth;
//use App\Http\Controllers\Mail;
use App\User;
use App\Role;
use App\Quotation;
//use App\DemoMail;
use Illuminate\Support\Facades\Input;




class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user());
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'))
                ->with('i',(request()->input('page',1)-1) *10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::select(['id', 'fullname'])
            ->pluck('fullname', 'id');
        return view('admin.users.crud.create', compact('roles'));
    }

    /**
     * Store a newly creat=ed resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd($request);

        //$aa = DB::table('roles')->where('id', $request['role'])->value('name');
        //dd($aa);
        request()->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);



        //dd(Input::get('email'));

        User::create([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $request['role'],
            'role_name' => DB::table('roles')->where('id', $request['role'])->value('name'), //'admin',      where
        ]);






        Mail::send('emails.demo', array('firstname'=>Input::get('firstname'), 'password'=>Input::get('password')), function($message){
            $message->to(Input::get('email'), Input::get('firstname').' '.Input::get('lastname'))->subject('Micro-comp LLC registeration info');
        });



        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  User::find($id);
        $roles = Role::select(['id', 'fullname'])
            ->pluck('fullname', 'id');
        return view('admin.users.crud.edit', compact('user', 'roles'));
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|string|min:6|confirmed',
        ]);

        // User::find($id)->update($request->all());

        User::find($id)->update([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $request['role'],
            'role_name' => DB::table('roles')->where('id', $request['role'])->value('name'), //'admin',      where
        ]);

        return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                ->with('success','User deleted successfully.');
    }


    public function edit_account() {
        $user = User::find(Auth::id());
        $id = $user->id;




        return view('admin.users.edit_account', compact('user'));

        //return $id;
    }



    public function update_account(Request $request, $id)
    {
        //dd('asdfgh');


        request()->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        // User::find($id)->update($request->all());

        User::find($id)->update([
            'password' => bcrypt($request['password']),
        ]);

        return redirect()->route('home')
            ->with('success', 'Account info updated successfully.');
    }
}
