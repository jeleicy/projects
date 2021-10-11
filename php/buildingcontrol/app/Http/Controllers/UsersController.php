<?php

namespace App\Http\Controllers;

use App\activities;
use App\condominium;
use App\building;
use App\role;
use App\menuuser;
use App\users;
use App\employee;
use App\jobposition;
use App\activitiemployee;
use App\items;
use App\inventory;
use App\itemused;

use Illuminate\Http\Request;
use Validator;
use Session;
use View;

class UsersController extends Controller
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

        $pass=$request->password;
        $pass=hash('ripemd160', $pass);

        $employee = employee::where("id",$request->idEmployee)
                    ->get();

        foreach ($employee as $employee)
            $idCondominium=$employee->idCondominium;

        $users = users::where("user",$request->user)
                    ->where("idCondominium",$idCondominium)
                    ->get();

        if ($users->count()>0)
            Session::put("message","This user exist");
        else {
            $users = users::where("idEmployee",$request->idEmployee)
                        ->get();

            if ($users->count()>0)
                Session::put("message","This employee already have an user");
            else {
                Session::put("message","User saved successfully");
                $users = new users($request->all());
                $users->password=$pass;
                $users->idCondominium=$idCondominium;
                $users->save();
                $datos=$request->all();
                foreach ($datos as $key => $value) {
                    if (strpos($key,"menu_") !== false) {
                        $idMenu=substr($key,strpos($key,"_")+1);
                        $menuuser = new menuuser($request->all());
                        $menuuser->idMenu=$idMenu;
                        $menuuser->idUser=$users->id;
                        $menuuser->save();                    
                    }
                }
            }           
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
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        if (strpos(strtolower(Session::get("roleName")),"super") !== false)     
            $users = users::get();
        else
            $users = users::where("idCondominium",Session::get("condominium"))->get();

        return view::make('User.List', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users = users::where("id",$id)
                    ->get();
        return view::make('User.Edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        //dd($request->all());
        $id=$request->id;

        $users=users::find($id);
        $users->fill($request->all());
        $users->save();

        $menuuser = menuuser::where("idUser",$id)
                    ->delete();        

        $datos=$request->all();
        foreach ($datos as $key => $value) {
            if (strpos($key,"menu_") !== false) {
                $idMenu=substr($key,strpos($key,"_")+1);
                $menuuser = new menuuser($request->all());
                $menuuser->idMenu=$idMenu;
                $menuuser->idUser=$users->id;
                $menuuser->save();                    
            }
        }        

        return self::show();
    }

    public function updatePassword($id) {

        $users = users::where("id",$id)
                    ->get();  

        return view::make('User.updatePassword', compact('users'));
    }

    public function saveupdateUsers(Request $request) 
    {
        //
        //dd($request->all());
        $id=$request->id;
        $pass=$request->password;
        $repeatpassword=$request->repeatpassword;

        if ($pass==$repeatpassword) {
            $pass=hash('ripemd160', $pass);

            $users=users::find($id);
            $users->fill($request->all());
            $users->password=$pass;
            $users->save();

            Session::put("message","Password changed successfull");

            $users = users::get();  
            return view::make('User.List', compact('users'));
        } else {
            Session::put("message","Password are not the same");
            $users = users::where("id",$id)
                        ->get();  

            return view::make('User.updatePassword', compact('users'));            
        }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\users  $users
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // dd($id);

        $menu = menuuser::where("idUser",$id)
                    ->delete();          

        $users = users::where("id",$id)
                    ->delete();   

        if ($users==0)
            Session::put("message","You can not delete this users");
        else
            Session::put("message","");

        return self::show();
    }

    public function logOut() {
        Session::put("user","");
        Session::put("name","");
        Session::put("role","");
        Session::put("condominium",""); 
        Session::put("roleName","");
        return view('User/login');
    }

     /**
     * Show the form Login
     *
     * @return \Illuminate\Http\Response
     */
    public function verify_user(Request $request)
    {

        $username=$request->username;
        $pass=$request->pass;

        Session::put("user","");
        Session::put("role","");

        $username=strtolower($username);
        $pass=hash('ripemd160', $pass);
        //echo "pass=$pass";
        //echo "pass=".$pass;
        //return;

        $validador = Validator::make(
            array('username' => $username, 'pass' => $pass),
            array('username' => 'required', 'pass' => 'required')
        );

        if ($validador->passes()) {
            $data = users::where('user', $username)
                    ->where('password',$pass)
                    ->get();
            
            if ($data->isEmpty()) {
                Session::put("user","");
                Session::put("name","");
                Session::put("role","");
                Session::put("condominium","");
                Session::put("roleName","");
                Session::put("message","Invalid Username or Passord");
                
                return View::make('User.login')->with('mensaje','error_autenticacion');
            } else {
                Session::put("user",$username);

                foreach ($data as $data) {
                    $employee = employee::where('id', $data->idEmployee)
                            ->get();

                    foreach ($employee as $employee) {      
                        Session::put("condominium",$employee->idCondominium);
                        Session::put("name",$employee->name);     
                    }        

                    Session::put("role",$data->idRole);
                    $roleName=FunctionsControllers::getName("role",Session::get("role"));
                    Session::put("roleName",$roleName);
                }
                Session::put("message","");

                return View::make('Dashboard.index');
            }
        } else {
            Session::put("message","Invalid Username or Passord");
            return view('User.login');
        }        
    }
}
