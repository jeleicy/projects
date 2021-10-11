<?php

namespace App\Http\Controllers;

use App\condominium;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class CondominiumController extends Controller
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
        $condominium = new condominium($request->all());
        $condominium->save();

        if ($request->logo!="") {
            // GET ALL THE INPUT DATA , $_GET,$_POST,$_FILES.
            $input = $request->all();
            
            // VALIDATION RULES
            $rules = array(
                'logo' => 'image|max:3000',
            );
        
           // PASS THE INPUT AND RULES INTO THE VALIDATOR
            $validation = Validator::make($input, $rules);
     
            // CHECK GIVEN DATA IS VALID OR NOT            
            
           $logo = array_get($input,'logo');
           // SET UPLOAD PATH 
            $destinationPath = 'images/logos'; 
            // GET THE FILE EXTENSION
            $extension = $logo->getClientOriginalExtension(); 
            // RENAME THE UPLOAD WITH RANDOM NUMBER 
            $fileName = $condominium->id . '.' . $extension; 
            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY 
            $upload_success = $logo->move($destinationPath, $fileName); 
        }

        $condominium=condominium::find($condominium->id);
        $condominium->logo=$fileName;
        $condominium->save();

        $condominium = condominium::get();
        return view::make('condominium.List', compact('condominium'));        
        return view('condominium/List');
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
     * @param  \App\condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $condominium = condominium::get();
        return view::make('condominium.List', compact('condominium'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $condominium = condominium::where("id",$id)
                    ->get();
        return view::make('condominium.Edit', compact('condominium'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //$condominium=condominium::findOrFail($id);
        //dd($request->all());
        $id=$request->id;

        $condominium=condominium::find($id);
        $condominium->fill($request->all());

        if ($request->logo!="") {
            // GET ALL THE INPUT DATA , $_GET,$_POST,$_FILES.
            $input = $request->all();
            
            // VALIDATION RULES
            $rules = array(
                'logo' => 'image|max:3000',
            );
        
           // PASS THE INPUT AND RULES INTO THE VALIDATOR
            $validation = Validator::make($input, $rules);
     
            // CHECK GIVEN DATA IS VALID OR NOT            
            
           $logo = array_get($input,'logo');
           // SET UPLOAD PATH 
            $destinationPath = 'images/logos'; 
            // GET THE FILE EXTENSION
            $extension = $logo->getClientOriginalExtension(); 
            // RENAME THE UPLOAD WITH RANDOM NUMBER 
            $fileName = $id . '.' . $extension; 
            // MOVE THE UPLOADED FILES TO THE DESTINATION DIRECTORY 
            $upload_success = $logo->move($destinationPath, $fileName); 
        }

        $condominium->save();

        $condominium = condominium::get();
        return view::make('condominium.List', compact('condominium'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        //dd($id);
        $condominium = condominium::where("id",$id)
                    ->delete();

        if ($condominium==0)
            Session::put("message","You can not delete this Condominium");
        else
            Session::put("message","");

        $condominium = condominium::get();
        return view::make('condominium.List', compact('condominium'));                    
    }
}
