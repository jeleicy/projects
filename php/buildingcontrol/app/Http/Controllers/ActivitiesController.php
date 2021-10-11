<?php

namespace App\Http\Controllers;

use App\activities;
use Illuminate\Http\Request;
use View;
use Session;

class ActivitiesController extends Controller
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
        $activities = new Activities($request->all());
        $activities->save();


        $activities = activities::get();
        return view::make('Activities.List', compact('activities'));        
        return view('Activities/List');
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
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $activities = activities::get();
        return view::make('Activities.List', compact('activities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $activities = activities::where("id",$id)
                    ->get();
        return view::make('Activities.Edit', compact('activities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$activities=activities::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $activities=activities::find($id);
        $activities->fill($request->all());
        $activities->save();

        $activities = activities::get();
        return view::make('Activities.List', compact('activities'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\activities  $activities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $activities = activities::where("id",$id)
                    ->delete();

        if ($activities==0)
            Session::put("message","You can not delete this Activitie");
        else
            Session::put("message","");

        $activities = activities::get();
        return view::make('Activities.List', compact('activities'));                    
    }
}
