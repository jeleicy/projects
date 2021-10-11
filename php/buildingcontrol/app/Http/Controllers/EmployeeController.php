<?php

namespace App\Http\Controllers;

use App\activities;
use App\condominium;
use App\building;
use App\role;
use App\users;
use App\employee;
use App\jobposition;
use App\activitieemployee;
use App\items;
use App\inventory;
use App\itemused;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FunctionsControllers;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class EmployeeController extends Controller
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
        //echo "date Hire=".FunctionsControllers::MySQLDate($request->datehire);
        //return;

        $datehire=FunctionsControllers::MySQLDate($request->datehire);

        $employee = new employee($request->all());
        $employee->datehire=$datehire;
        $datehire=str_replace("-", "/", $datehire);
        $employee->save();

        $jobposition = new jobposition();
        $jobposition->idEmployee=$employee->id;
        $jobposition->name=$request->jobpsition;
        $jobposition->begindate=$datehire;
        $jobposition->enddate=$datehire;
        $jobposition->save();

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
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        if (strpos(strtolower(Session::get("roleName")),"super") !== false)
            $employee = employee::get();
        else
            $employee = employee::where("idCondominium",Session::get("condominium"))->get();

        return view::make('Employee.List', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $employee = employee::where("id",$id)
                    ->get();
        return view::make('Employee.Edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //dd($request->all());
        $id=$request->id;
        $datehire=str_replace("-", "/", $request->datehire);
        $dateHire=FunctionsControllers::MySQLDate($datehire);

        $employee=employee::find($id);
        $employee->fill($request->all());
        $employee->datehire=$dateHire;

        $employee->save();

        $jobposition = jobposition::
                    where ("idEmployee",$id)
                    ->get();

        foreach ($jobposition as $jobposition)
            $id=$jobposition->id;
        
        $jobposition=jobposition::find($id);
        //$employee->fill($request->all());
        $jobposition->name=$request->jobpsition;
        $jobposition->save();        

        return self::show();      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // dd($id);
        // jobposition, user
        // activitieemployee, itemused

        $activitieemployee = activitieemployee::
                        where("idEmployee",$id)
                        ->get();

        $itemused = itemused::
                where("idEmployee",$id)
                ->get();                        

        if ($activitieemployee->isEmpty()) {
            if ($itemused->isEmpty()) {

                $jobposition = jobposition::where("idEmployee",$id)
                            ->delete();

                $users = users::where("idEmployee",$id)
                            ->delete();   

                $employee = employee::where("id",$id)
                            ->delete();                            

                Session::put("message","");  
            } else {
                Session::put("message","You can not delete this employee");
            }
        } else
            Session::put("message","You can not delete this employee");

        return self::show();
    }
}
