<?php

namespace App\Http\Controllers;

use App\role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        //dd($request->all());
        $role = new role($request->all());
        $role->save();

        $role = role::get();
        return view::make('role.List', compact('role'));        
        return view('role/List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $role = role::get();
        return view::make('role.List', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $role = role::where("id",$id)
                    ->get();
        return view::make('role.Edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$role=role::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $role=role::find($id);
        $role->fill($request->all());

        $role->save();

        $role = role::get();
        return view::make('role.List', compact('role'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $role = role::where("id",$id)
                    ->delete();

        if ($role==0)
            Session::put("message","You can not delete this role");
        else
            Session::put("message","");

        $role = role::get();
        return view::make('role.List', compact('role'));                    
    }
}
