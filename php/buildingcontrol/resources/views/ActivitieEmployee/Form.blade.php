<?php

  namespace App\Http\Controllers;
  use App\Http\Controllers\FunctionsControllers;
  use Session;
  use App\users;
  use Carbon\Carbon;
  use URL;

  $current = Carbon::now();
  $current = new Carbon();

  // get today - 2015-12-19 00:00:00
  //$todayDateTime = Carbon::today();
  $todayDateTime = Carbon::now();
  //echo $mytime->toDateTimeString();
  //echo "<h1>todayDateTime=".$todayDateTime->toDateTimeString()."</h1>";

  $today=explode(" ", $todayDateTime);
  $todayDate=FunctionsControllers::NormalDate($today[0]);
  $todayDate=str_replace("-", "/", $todayDate);
  $todayTime=$today[1];

  $role=Session::get("role");
  $condominium=Session::get("condominium");
  $user=Session::get("user");

  $users = users::where('user', $user)
          ->get();

  foreach ($users as $users)
    $idEmployee=$users->idEmployee;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));
  
if (strtolower($roleName)=="employee")
  $nameEmployee=Session::get("name");
else
  $nameEmployee="";

?>

@include ('Layout.header')

        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <div class="content-border">
      <div class="card-header">New Activities Employee <h3>{{ $nameEmployee }} </h3></div>
      <div class="card-body">
        <form name="form1" method="post" action="createActivitieEmployee">
          {{ csrf_field() }}
          <input type="hidden" name="valItems" id="valItems" value="">
          <input type="hidden" name="valQuantity" id="valQuantity" value="">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listActivitieEmployee">List</a>
          </div>
          @if (strtolower($roleName)!="employee")
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Employee</label>
                <select class="form-control" id="idEmployee" name="idEmployee" required="required">
                    {{ FunctionsControllers::fillSelect("employee", 0) }}
                </select>
              </div>
            </div>
            @else
            <input type="hidden" name="idEmployee" id="idEmployee" value="{{ $idEmployee }}">
            @endif 
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Activitie</label>
                <select class="form-control" id="idActivitie" name="idActivitie" required="required">
                    {{ FunctionsControllers::fillSelect("activities", 0) }}
                </select>
              </div>
            </div>  
            @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select onchange="viewBuilding(this.value,0,'')" class="form-control" id="idCondominium" name="idCondominium" required="required">
                    {{ FunctionsControllers::fillSelect("condominium", 0) }}
                </select>
              </div>
            </div>
            @else
              <input type="hidden" name="idCondominium" id="idCondominium" value="{{ Session::get('condominium') }}">
            @endif   
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Building</label>
                <select class="form-control" id="idBuilding" name="idBuilding" required="required">
                </select>
              </div>
            </div>  
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Floor</label>
                <input class="form-control col-md-3" id="floor" name="floor" type="number" required="required" aria-describedby="nameHelp" placeholder="Floor" value="">
              </div>
            </div>
          </div>    
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Apartment</label>
                <input class="form-control" id="apartment" name="apartment" type="text" required="required" aria-describedby="nameHelp" placeholder="Apartment" value="">
              </div>
            </div>
          </div>  
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Date of Issue</label>
                <input id="ActivitiDateTime" required="required" name="ActivitiDateTime" width="276" value="{{ $todayDate }} {{ $todayTime }}" readonly="" />
                <script>
                    $('#ActivitiDateTime').datetimepicker({format: 'mm/dd/yyyy hh:mm:ss'});
                </script>
            </div>
          </div> 
        </div>   
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Notes</label>
                <textarea class="form-control" id="Observations" name="Observations" required="required" aria-describedby="nameHelp" placeholder="Notes"></textarea>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Items Used</label><br />
                <label id="errorMessage" for="exampleInputName">&nbsp;</label>
                <table id="tableItems" width="100%" class="table table-bordered">
                    <tr>        
                      <th>Item</th>
                      <th>Quantity</th>
                      <th>&nbsp;</th>
                    </tr>   
                    <tr>
                      <td>
                        <select class="form-control" id="idItem" name="idItem">
                          <option value=0></option>
                          {{ FunctionsControllers::fillSelect("items", 0) }}
                        </select>
                      </td>
                      <td>
                        <input class="form-control col-md-6" id="quantity" name="quantity" type="number" aria-describedby="nameHelp" placeholder="Quantity" value="">                
                      </td>
                      <td><a href="javascript:;" onclick="addItems('')"><img src="{{ URL::asset('images/add.png') }}" width="30" height="30"></td>
                    </tr>        
                </table>
              </div>
            </div>
          </div>          
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>

    <script type="text/javascript">
      var idCondominium={{ Session::get("condominium") }};
      var idBuilding=0;
    </script>    

@include ('Layout.footer')