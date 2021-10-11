<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use App\users;
use Carbon\Carbon;
use URL;

  $current = Carbon::now();
  $current = new Carbon();

  $role=Session::get("role");
  $condominium=Session::get("condominium");
  $user=Session::get("user");

  $users = users::where('user', $user)
          ->get();


  foreach ($users as $users)
    $idEmployee=$users->idEmployee;

$roleName=FunctionsControllers::getName("role",Session::get("role"));
  
if (strtolower($roleName)=="employee")
  $nameEmployee=Session::get("name");
else
  $nameEmployee="";

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">New Activities Employee <h3>{{ $nameEmployee }} </h3></div>
      <div class="card-body">
        @foreach ($ActivitieEmployee as $ActivitieEmployee)
        <form name="form1" method="post" action="{{ route('updateActivitieEmployee') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="id" value="{{ $ActivitieEmployee->id }}">
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
                    {{ FunctionsControllers::fillSelect("employee", $ActivitieEmployee->idEmployee) }}
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
                    {{ FunctionsControllers::fillSelect("activities", $ActivitieEmployee->idActivitie ) }}
                </select>
              </div>
            </div>  
            @if ($condominium==0)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select onchange="viewBuilding(this.value, {{ $ActivitieEmployee->idBuilding }},'')" class="form-control" id="idCondominium" name="idCondominium" required="required">
                    {{ FunctionsControllers::fillSelect("condominium", $ActivitieEmployee->idCondominium) }}
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
                    {{ FunctionsControllers::fillSelect("building", $ActivitieEmployee->idBuilding) }}
                </select>
              </div>
            </div>  
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Floor</label>
                <input class="form-control col-md-3" id="floor" name="floor" type="number" required="required" aria-describedby="nameHelp" placeholder="Floor" value="{{ $ActivitieEmployee->floor }}">
              </div>
            </div>
          </div>    
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Apartment</label>
                <input class="form-control" id="apartment" name="apartment" type="text" required="required" aria-describedby="nameHelp" placeholder="Apartment" value="{{ $ActivitieEmployee->apartment }}">
              </div>
            </div>
          </div>  
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">

                <!--2018-08-02 00:00:00-->
                <?php
                  $DateTime=explode(" ", $ActivitieEmployee->ActivitiDateTime);
                  
                  $ActivitieEmployeeDate=explode("-", $DateTime[0]);
                  
                  $DateActivitie=$ActivitieEmployeeDate[1]."/".$ActivitieEmployeeDate[2]."/".$ActivitieEmployeeDate[0];
                  $TimeActivitie=$DateTime[1];
                ?>

                <label for="exampleInputName">Date of Issue</label>
                <input readonly="readonly" id="ActivitiDateTime" required="required" name="ActivitiDateTime" width="276" value="{{ $DateActivitie }} {{ $TimeActivitie }}" />
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
                <textarea class="form-control" id="Observations" name="Observations" required="required" aria-describedby="nameHelp" placeholder="Notes">{{ $ActivitieEmployee->Observations }}</textarea>
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
                      <td><a href="javascript:;" onclick="addItems('../')"><img src="{{ URL::asset('images/add.png') }}" width="30" height="30"></td>
                    </tr>
                    {{ FunctionsControllers::getItemsUsed($ActivitieEmployee->id) }}
                </table>
              </div>
            </div>
          </div>

          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
        @endforeach
      </div>
    </div>

    <script type="text/javascript">
      var idCondominium={{ $ActivitieEmployee->idCondominium }};
      var idBuilding={{ $ActivitieEmployee->idBuilding }};
    </script>

@include ('Layout.footer')