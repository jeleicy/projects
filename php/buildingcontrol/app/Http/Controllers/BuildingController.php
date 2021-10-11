<?php

namespace App\Http\Controllers;

use App\building;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class buildingController extends Controller
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
        $building = new building($request->all());
        $building->save();

        $building = building::get();
        return view::make('building.List', compact('building'));        
        return view('building/List');
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
     * @param  \App\building  $building
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $building = building::get();
        return view::make('building.List', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\building  $building
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $building = building::where("id",$id)
                    ->get();
        return view::make('building.Edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\building  $building
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$building=building::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $building=building::find($id);
        $building->fill($request->all());

        $building->save();

        $building = building::get();
        return view::make('building.List', compact('building'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\building  $building
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $building = building::where("id",$id)
                    ->delete();

        if ($building==0)
            Session::put("message","You can not delete this building");
        else
            Session::put("message","");

        $building = building::get();
        return view::make('building.List', compact('building'));                    
    }
}
