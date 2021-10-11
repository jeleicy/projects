<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;

use App\activitieemployee;
use App\itemused;
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
        $ActivitiDateTime=explode(" ", $request->ActivitiDateTime);
        //12/02/2017 00:12:00

        $ActivitiDate=FunctionsControllers::MySQLDate($ActivitiDateTime[0]);
        $ActivitiTime=$ActivitiDateTime[1];
        //$ActivitiDateTime=FunctionsControllers::MySQLDate($ActivitiDateTime);

        $ActivitieEmployee = new activitieemployee($request->all());
        $ActivitieEmployee->ActivitiDateTime=$ActivitiDate." ".$ActivitiTime;
        $ActivitieEmployee->save();

        $idActivitieEmployee=$ActivitieEmployee->id;

        //valItems, valQuantity

        $idEmployee=$request->idEmployee;
        $idBuilding=$request->idBuilding;
        $date=$ActivitiDate." ".$ActivitiTime;
        $idCondominium=$request->idCondominium;

        $VI=substr($request->valItems,0,strlen($request->valItems)-1);
        $VQ=substr($request->valQuantity,0,strlen($request->valQuantity)-1);

        if ($request->valItems) {
            $arrayItems=explode(",", $VI);
            $arrayQuantity=explode(",", $VQ);

            //print_r ($arrayItems); return;

            foreach ($arrayItems as $key => $value) {
                //echo "...SI hay items..."; return;
                $itemused = new itemused($request->all());
                if ($value!="undefined") {
                    $itemused->idItem=$value;
                    $itemused->quantity=$arrayQuantity[$key];

                    //echo "<br>item=".$value."...quantity=".$arrayQuantity[$key];

                    $itemused->idEmployee=$idEmployee;
                    $itemused->idBuilding=$idBuilding;
                    $itemused->date=$date;
                    $itemused->idCondominium=$idCondominium;

                    $itemused->idActivitieEmployee=$idActivitieEmployee;
                    $itemused->save();
                }
            }
        } else {
            //echo "NO hay items..."; return;
            $itemused->idEmployee=$idEmployee;
            $itemused->idBuilding=$idBuilding;
            $itemused->date=$date;
            $itemused->idCondominium=$idCondominium;

            $itemused->idItem=0;
            $itemused->quantity=0;
            $itemused->idActivitieEmployee=$idActivitieEmployee;
            $itemused->save();
        }

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
     * @param  \App\ActivitieEmployee  $ActivitieEmployee
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //

        $idEmployee=FunctionsControllers::getIdEmployee(Session::get("user"));
        
        if (strpos(strtolower(Session::get("roleName")),"super") !== false) {
            $ActivitieEmployee = activitieemployee::get();
        } else {
            if (strpos(strtolower(Session::get("roleName")),"manager") !== false) {
                $ActivitieEmployee = activitieemployee::
                                where("idCondominium",Session::get("condominium"))
                                ->get(); 
            } else {
                $ActivitieEmployee = activitieemployee::
                                where("idEmployee",$idEmployee)
                                ->get();   
            }         
        }

        return view::make('ActivitieEmployee.List', compact('ActivitieEmployee'));        
        //return view('ActivitieEmployee.List');     
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
        $ActivitieEmployee = activitieemployee::where("id",$id)
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
        //dd($request->all());
        $id=$request->id;

        $ActivitiDateTime=explode(" ", $request->ActivitiDateTime);
        //05/03/2018 01:05:00

        $ActivitiDate=FunctionsControllers::MySQLDate($ActivitiDateTime[0]);

        $ActivitiTime=$ActivitiDateTime[1];
        $ActivitiDateTime=$ActivitiDate." ".$ActivitiTime;

        $ActivitieEmployee=activitieemployee::find($id);
        $ActivitieEmployee->fill($request->all());
        $ActivitieEmployee->ActivitiDateTime=$ActivitiDateTime;
        $ActivitieEmployee->save();

        //$idEmployee=FunctionsControllers::getIdEmployee(Session::get("user"));

        //valItems, valQuantity

        $idEmployee=$request->idEmployee;
        $idBuilding=$request->idBuilding;
        $date=$ActivitiDate." ".$ActivitiTime;
        $idCondominium=$request->idCondominium;

        $VI=substr($request->valItems,0,strlen($request->valItems)-1);
        $VQ=substr($request->valQuantity,0,strlen($request->valQuantity)-1);

        if ($request->valItems) {
            $arrayItems=explode(",", $VI);
            $arrayQuantity=explode(",", $VQ);

            $itemused=itemused::where("idActivitieEmployee",$id)->delete();

            //print_r ($arrayItems); return;

            foreach ($arrayItems as $key => $value) {
                //echo "...SI hay items..."; return;
                $itemused = new itemused($request->all());
                if ($value!="undefined") {
                    $itemused->idItem=$value;
                    $itemused->quantity=$arrayQuantity[$key];

                    //echo "<br>item=".$value."...quantity=".$arrayQuantity[$key];

                    $itemused->idEmployee=$idEmployee;
                    $itemused->idBuilding=$idBuilding;
                    $itemused->date=$date;
                    $itemused->idCondominium=$idCondominium;

                    $itemused->idActivitieEmployee=$id;
                    $itemused->save();
                }
            }
        } else {
            //echo "NO hay items..."; return;
            $itemused->idEmployee=$idEmployee;
            $itemused->idBuilding=$idBuilding;
            $itemused->date=$date;
            $itemused->idCondominium=$idCondominium;

            $itemused->idItem=0;
            $itemused->quantity=0;
            $itemused->idActivitieEmployee=$idActivitieEmployee;
            $itemused->save();
        }
        return self::show();
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
        $ActivitieEmployee = activitieemployee::where("id",$id)
                    ->delete();

        if ($ActivitieEmployee==0)
            Session::put("message","You can not delete this Activitie");
        else
            Session::put("message","");

        return self::show();                    
    }
}
