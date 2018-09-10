<?php

namespace App\Http\Controllers;

use App\Models\ThirdParty;
use DB;
use Auth;
use Illuminate\Http\Request;

class ThirdPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('third party');

        $accesses = DB::table('third_party')
            ->get();
        //dd($accesses);
        return view('admin.thirdparty.index', compact('accesses'));

        //return view('admin.thirdparty.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd('barev');
        return view('admin.thirdparty.crud.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'website'       => 'required',
            'username'      => 'required',
            'password'      => 'required',

        ]);


        $accessData = ThirdParty::create([
            'website'       => $request['website'],
            'username'      => $request['username'],
            'password'      => $request['password'],
            'description'   => $request['description'],
        ]);

        return redirect()->route('thirdparty.index')
            ->with('success', 'Access data created successfully.');
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
        $access_data =  DB::table('third_party')
            ->where('id', $id)
            ->get();

        return view('admin.thirdparty.crud.edit', compact('access_data'));


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
            'website'       => 'required',
            'username'      => 'required',
            'password'      => 'required',

        ]);
        $request = $request->all();
        //dd($request);
        $accessData = ThirdParty::find($id)->update([
            'website'       => $request['website'],
            'username'      => $request['username'],
            'password'      => $request['password'],
            'description'   => $request['description'],
        ]);


        return redirect()->route('thirdparty.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('third_party')
            ->where('id', $id)
            ->delete();



        return redirect()->route('thirdparty.index')
            ->with('success','Project deleted successfully.');
    }
}
