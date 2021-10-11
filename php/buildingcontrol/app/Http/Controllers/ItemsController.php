<?php

namespace App\Http\Controllers;

use App\items;
use Illuminate\Http\Request;
use View;
use Session;

class itemsController extends Controller
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
        $items = new items($request->all());
        $items->save();

        return self::show();
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
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        if (strpos(strtolower(Session::get("roleName")),"super") !== false)
            $items = items::get();
        else
            $items = items::where("idCondominium",Session::get("condominium"))->get();

        return view::make('Items.List', compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $items = items::where("id",$id)
                    ->get();
        return view::make('Items.Edit', compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$items=items::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $items=items::find($id);
        $items->fill($request->all());
        $items->save();

        return self::show();       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $items = items::where("id",$id)
                    ->delete();

        if ($items==0)
            Session::put("message","You can not delete this Activitie");
        else
            Session::put("message","");

        return self::show();                   
    }
}
