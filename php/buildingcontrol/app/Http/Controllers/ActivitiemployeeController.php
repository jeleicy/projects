<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;

use App\ActivitieEmployee;
use Illuminate\Http\Request;
use View;
use Session;

class ActivitieEmployeeController extends Controller
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
        $entryDate=$request->entryDate;
        $entryDate=FunctionsControllers::MySQLDate($entryDate);

        $ActivitieEmployee = new ActivitieEmployee($request->all());
        $ActivitieEmployee->entryDate=$entryDate;
        $ActivitieEmployee->save();


        $ActivitieEmployee = ActivitieEmployee::get();
        return view::make('ActivitieEmployee.List', compact('ActivitieEmployee'));        
        return view('ActivitieEmployee.List');
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
     * @param  \App\ActivitieEmployee  $ActivitieEmployee
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $ActivitieEmployee = ActivitieEmployee::get();
        return view::make('ActivitieEmployee.List', compact('ActivitieEmployee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActivitieEmployee  $ActivitieEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ActivitieEmployee = ActivitieEmployee::where("id",$id)
                    ->get();
        return view::make('ActivitieEmployee.Edit', compact('ActivitieEmployee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActivitieEmployee  $ActivitieEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$ActivitieEmployee=ActivitieEmployee::findOrFail($id);
        //dd($request->all());
        $id=$request->id;
        $entryDate=$request->entryDate;
        $entryDate=FunctionsControllers::MySQLDate($entryDate);        

        $ActivitieEmployee=ActivitieEmployee::find($id);
        $ActivitieEmployee->fill($request->all());
        $ActivitieEmployee->entryDate=$entryDate;
        $ActivitieEmployee->save();

        $ActivitieEmployee = ActivitieEmployee::get();
        return view::make('ActivitieEmployee.List', compact('ActivitieEmployee'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActivitieEmployee  $ActivitieEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $ActivitieEmployee = ActivitieEmployee::where("id",$id)
                    ->delete();

        if ($ActivitieEmployee==0)
            Session::put("message","You can not delete this Activitie");
        else
            Session::put("message","");

        $ActivitieEmployee = ActivitieEmployee::get();
        return view::make('ActivitieEmployee.List', compact('ActivitieEmployee'));                    
    }
}
