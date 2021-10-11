<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;

use App\inventory;
use Illuminate\Http\Request;
use View;
use Session;

class inventoryController extends Controller
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

        $inventory = new inventory($request->all());
        $inventory->entryDate=$entryDate;
        $inventory->save();

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
     * @param  \App\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        if (strpos(strtolower(Session::get("roleName")),"super") !== false)
            $inventory = inventory::get();
        else
            $inventory = inventory::where("idCondominium",Session::get("condominium"))->get();

        return view::make('Inventory.List', compact('inventory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $inventory = inventory::where("id",$id)
                    ->get();
        return view::make('Inventory.Edit', compact('inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$inventory=inventory::findOrFail($id);
        //dd($request->all());
        $id=$request->id;
        $entryDate=$request->entryDate;
        $entryDate=str_replace("-", "/", $entryDate);
        $entryDate=FunctionsControllers::MySQLDate($entryDate);        

        $inventory=inventory::find($id);
        $inventory->fill($request->all());
        $inventory->entryDate=$entryDate;
        $inventory->save();

        return self::show();      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $inventory = inventory::where("id",$id)
                    ->delete();

        if ($inventory==0)
            Session::put("message","You can not delete this Activitie");
        else
            Session::put("message","");

        return self::show();                 
    }
}
