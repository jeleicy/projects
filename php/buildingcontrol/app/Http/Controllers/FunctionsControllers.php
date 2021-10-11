<?php

namespace App\Http\Controllers;

use App\activities;
use App\condominium;
use App\building;
use App\role;
use App\users;
use App\employee;
use App\jobposition;
use App\activitiemployee;
use App\items;
use App\inventory;
use App\itemused;
use App\menu;
use App\menuuser;

use URL;
use route;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Session;
use Validator;

class FunctionsControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function viewRoleEmp(Request $request) {
        $idCondominium=$request->idCondominium;
        $idRole=$request->idRole;
        $idEmployee=$request->idEmployee;

        //dd($request->all());
        
        $role = role::where("idCondominium",$idCondominium)->get();
        $resultRole="";
        foreach ($role as $role) {
            if ($idRole==$role->id)
                $selected=" selected";
            else
                $selected="";

            $resultRole.="<option ".$selected." value=".$role->id.">".$role->name."</option>";
        }

        $employee = employee::where("idCondominium",$idCondominium)->get();
        $resultEmployee="";
        foreach ($employee as $employee) {
            if ($idEmployee==$employee->id)
                $selected=" selected";
            else
                $selected="";

            $resultEmployee.="<option ".$selected." value=".$employee->id.">".$employee->name."</option>";
        }

        //return $resultEmployee;

        return response()->json(['role'=>$resultRole, 'employee'=>$resultEmployee]);
    }

    public function viewBuilding(Request $request) {
        $idCondominium=$request->idCondominium;
        $idBuilding=$request->idBuilding;

        //dd($request->all());
        
        $building = building::where("idCondominium",$idCondominium)->get();
        $resultBuilding="";
        foreach ($building as $building) {
            if ($idBuilding==$building->id)
                $selected=" selected";
            else
                $selected="";

            $resultBuilding.="<option ".$selected." value=".$building->id.">".$building->name."</option>";
        }

        //return $resultBuilding;

        return response()->json(['building'=>$resultBuilding]);
    }

    public function putName(Request $request) {
        //dd($request->all());
        $id=$request->id;
        $table=$request->table;

        //dd($request->all());
        
        $data = items::where("id",$id)->get();
        $result="";
        foreach ($data as $data)
            $result=$data->name;

        //return $result;
        return response()->json(['result'=>$result]);
    }  

    public function getQuantity(Request $request) {
        //dd($request->all());
        $idItem=$request->idItem;
        $idCondominium=$request->idCondominium;

        //Inventiry Quantity        
        $data = inventory::
            where("idItem",$idItem)
            ->where("idCondominium",$idCondominium)
            ->select(DB::raw('sum(entryQuantity) AS entryQuantity'))
            ->get();
        
        $result="";
        foreach ($data as $data)
            $inventoryQuantity=$data->entryQuantity;

        //Used Quantity        
        $data = itemUsed::
            where("idItem",$idItem)
            ->where("idCondominium",$idCondominium)
            ->select(DB::raw('sum(quantity) AS quantity'))
            ->get();
        
        $result="";
        foreach ($data as $data)
            $usedQuantity=$data->quantity;

        $totalQuantity=$inventoryQuantity-$usedQuantity; 

        //return $result;
        return response()->json(['result'=>$totalQuantity]);
    }          

    public static function getName($table, $id)
    {
        //
        if ($table=='activities') $data = activities::where("id",$id)->get();
        if ($table=='condominium') $data = condominium::where("id",$id)->get();
        if ($table=='building') $data = building::where("id",$id)->get();
        if ($table=='role') $data = role::where("id",$id)->get();
        if ($table=='users') $data = users::where("id",$id)->get();
        if ($table=='employee') $data = employee::where("id",$id)->get();
        if ($table=='jobposition') $data = jobposition::where("idEmployee",$id)->get();
        if ($table=='activitiemployee') $data = activitiemployee::where("id",$id)->get();
        if ($table=='items') $data = items::where("id",$id)->get();
        if ($table=='inventory') $data = inventory::where("id",$id)->get();
        if ($table=='itemused') $data = itemused::where("id",$id)->get();
        if ($table=='menu') $data = menu::where("id",$id)->get();

        $res = "";
        foreach ($data as $data)
        	$res = $data->name;
        
        return $res;
    }

    public static function getCondominiumBuilding($idBuilding) {
        $building = building::
                where("id",$idBuilding)
                ->get();  

        foreach ($building as $building)
            $idCondominium = $building->idCondominium;

        $condominium = condominium::
                where("id",$idCondominium)
                ->get();  

        foreach ($condominium as $condominium)
            return $condominium->name;                 
    }    

    public static function getIdEmployee($user) {
        $users = users::
                where("user",$user)
                ->get();  

        foreach ($users as $users)
            return $users->idEmployee;      
    }

    public static function getCondominiumUser($id) 
    {
        //
        $users = users::where("id",$id)->get();
        foreach ($users as $users)
            $idEmployee=$users->idEmployee;

        $employee = employee::where("id",$idEmployee)->get();
        foreach ($employee as $employee)
            $idCondominium=$employee->idCondominium;        

        return self::getName("condominium",$idCondominium);
    }   

    public static function MySQLDate($date) 
    {
        $result=explode("/", $date);
        $result=$result[2]."-".$result[0]."-".$result[1];
        return $result;
    }

    public static function NormalDate($date)
    {
        $result=explode("-", $date);
        $result=$result[1]."-".$result[2]."-".$result[0];
        return $result;
    }

    public static function getItemQuantity($id)
    {
        $inventory = inventory::get();
        foreach ($inventory as $inventory)
            return $inventory->entryQuantity;

    }

    public static function createMenu() {
        $userName=Session::get("user");
        $idCondominium=Session::get("condominium");
        $idMenu = [];

        $users = users::
                    where("user",$userName)
                    ->where("idCondominium",$idCondominium)
                    ->get();

        foreach ($users as $users)
            $idUser=$users->id;

        $menuuser = menuuser::
                    where("idUser",$idUser)
                    ->get();

        $i=0;
        foreach ($menuuser as $menuuser) {
            $idMenu[]=$menuuser->idMenu;
            $i++;
        }
        
        //$idMenu=substr($idMenu,0,strlen($idMenu)-1);

        $menu = menu::
                whereIn("id",$idMenu)
                ->get();

        $navigate="";
        $i=1;

        foreach ($menu as $menu) {
            $navigate.='<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
              <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti'.$i.'" data-parent="#exampleAccordion">
                <i class="far fa-arrow-alt-circle-right"></i>
                <span class="nav-link-text">'.$menu->name.'</span>
              </a>';
            $subMenu = menu::
                    where("father",$menu->id)
                    ->get();

            if ($subMenu->isEmpty())  {
                $navigate=$navigate;
            } else {
                $navigate.='<ul class="sidenav-second-level collapse" id="collapseMulti'.$i.'">';
                foreach ($subMenu as $subMenu) {
                    $navigate.='<li>
                        <a href="'.URL::route($subMenu->url).'"><i class="fas fa-arrow-right"></i>'.$subMenu->name.'</a>
                    </li>';
                }
                $navigate.='</ul>';
            }
            $navigate.='</li>';
            $i++;
        }
        echo $navigate;
    }

    public static function fillCheck($table, $idUser) {
        $data = menu::
                where("father",0)
                ->get();

        $resultado="";
        foreach ($data as $data) {
            $menuuser = menuuser::
                            where("idUser",$idUser)
                            ->where("idMenu",$data->id)
                            ->get();

            if($menuuser->isEmpty())
                $selected="";
            else
                $selected=" checked='checked'";

            $resultado.="<input type='checkbox' ".$selected." name='menu_".$data->id."' value='menu_".$data->id."'>".$data->name."<br />";
        }
        echo $resultado;

    }

    public static function fillSelect($table, $id)
    {
        //
        $roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")))
        ;

        //return "roleName=".$roleName;

        if (strpos($roleName,"super") !== false) {
            if ($table=='activities') $data = activities::get();
            if ($table=='building') $data = building::get();
            if ($table=='role') $data = role::get();
            if ($table=='employee') $data = employee::get();
            if ($table=='items') $data = items::get();
            if ($table=='inventory') $data = inventory::get();
            if ($table=='itemused') $data = itemused::get();
            if ($table=='activitiemployee') $data = activitiemployee::get();
            if ($table=='users') $data = users::get();                
        } else {
            if ($table=='activities') $data = activities::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='building') $data = building::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='role') $data = role::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='employee') $data = employee::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='items') $data = items::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='inventory') $data = inventory::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='itemused') $data = itemused::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();

            if ($table=='activitiemployee') $data = activitiemployee::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();
            if ($table=='users') $data = users::
                                        where("idCondominium",Session::get("condominium"))
                                        ->get();                
        }

        //echo "rolname=$roleName";
        if ($table=='jobposition') $data = jobposition::where("idEmployee",$id)->get();
        if ($table=='condominium') $data = condominium::get();
        if ($table=='menu') $data = menu::where("father",0)->get();

        $result="";
        $select="";

        //echo "count=".$data->count();
        //return;

        foreach ($data as $data) {
            if ($id==$data->id)
                $select=" selected";
            else
                $select="";

            $result.="<option value='".$data->id."'$select>".$data->name."</option>";
        }

        echo $result;
        return;
    }

    public static function getItemsUsed($idActivitieEmployee) {
        $itemused = itemused::where("idActivitieEmployee",$idActivitieEmployee)->get();
        $result="";
        $i=1;
        foreach ($itemused as $itemused) {
            $img='<a href="javascript:;" onclick="minusItems('.$i.')">';
            $img.='<img id="minus_'.$i.'" src="'.URL::asset('images/minus.png').'" width="30" height="30">';
            $result.="<tr id='r".$i."'>";
                $result.="<td>".$itemused->idItem."</td>";
                $result.="<td>".$itemused->quantity."</td>";
                $result.="<td>".$img."</td>";
            $result.="</tr>";
            $i++;
            echo "  <script>
                        Item_array[i]=".$itemused->idItem.";
                        Quantity_array[i]=".$itemused->quantity.";
                                                        
                        Item_array_values=addValues(Item_array);
                        Quantity_array_values=addValues(Quantity_array);
                        i++;
                        alert(i);
                        $('#valItems').val(Item_array_values);
                        $('#valQuantity').val(Quantity_array_values);
                    </script>";
        }
        echo $result;
        return;
    }
}