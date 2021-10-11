<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')
    <div class="content-border">
      <div class="card-header">Users Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('createUsers') }}">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="{{ URL::route('listUsers') }}">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">User</label>
                <input class="form-control" id="user" name="user" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Password</label>
                <input class="form-control" id="password" name="password" type="password" required="required" aria-describedby="nameHelp" placeholder="Password" value="">
              </div>
            </div>
          </div>  
          @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select onChange="viewRoleEmp(this.value,'',0, 0)" class="form-control" id="idCondominium" name="idCondominium" required="required">{{ Session::get("condominium") }}
                    {{ FunctionsControllers::fillSelect("condominium", 0) }}
                </select>
              </div>
            </div>    
            @else
              <input type="hidden" name="idCondominium" id="idCondominium" value="{{ Session::get('condominium') }}">
            @endif            
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Role</label>
                <select class="form-control" id="idRole" name="idRole" required="required">
                </select>
              </div>
            </div>               
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Employee</label>
                <select class="form-control" id="idEmployee" name="idEmployee" required="required">
                </select>
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Enable Menu</label><br />
                    {{ FunctionsControllers::fillCheck("menu", 0) }}
              </div>
            </div>                                                               
            <div class="form-row">
              <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
            </div>
        </form>
      </div>
    </div>

    <script type="text/javascript">
        var idCondominium={{ Session::get("condominium") }};
        var idRole={{ Session::get("role") }};
        var idEmployee=0;
    </script>

@include ('Layout.footer')