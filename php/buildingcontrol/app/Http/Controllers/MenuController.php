<?php

namespace App\Http\Controllers;

use App\menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class MenuController extends Controller
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
        $menu = new menu($request->all());
        $menu->save();

        $menu = menu::get();
        return view::make('Menu.List', compact('menu'));        
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
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $menu = menu::get();
        return view::make('Menu.List', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $menu = menu::where("id",$id)
                    ->get();
        return view::make('Menu.Edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$menu=menu::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $menu=menu::find($id);
        $menu->fill($request->all());
        $menu->save();

        $menu = menu::get();
        return view::make('Menu.List', compact('menu'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $menu = menu::where("id",$id)
                    ->delete();

        if ($menu==0)
            Session::put("message","You can not delete this menu");
        else
            Session::put("message","");

        $menu = menu::get();
        return view::make('Menu.List', compact('menu'));                    
    }
}
