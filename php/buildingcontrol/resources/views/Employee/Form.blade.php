<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

use Carbon\Carbon;

$current = Carbon::now();
$current = new Carbon();

// get today - 2015-12-19 00:00:00
$todayDateTime = Carbon::today();

$today=substr($todayDateTime,0,strpos($todayDateTime," "));
$today=FunctionsControllers::NormalDate($today);
$today=str_replace("-", "/", $today);

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Employee Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('createEmployee') }}">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listEmployee">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Date of Hire</label>
                <input id="datehire" required="required" name="datehire" width="276" value="{{ $today }}" />
                <script>
                    $('#datehire').datepicker({
                        uiLibrary: 'bootstrap4'
                    });
                </script>
            </div>
          </div> 
        </div>  
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Phone</label>
                <input class="form-control" id="phone" name="phone" type="text" required="required" aria-describedby="nameHelp" placeholder="Phone">
              </div>
            </div>
          </div>      
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Job Position</label>
                <input class="form-control" id="jobpsition;" name="jobpsition" type="text" required="required" aria-describedby="nameHelp" placeholder="Job Position" value="">
              </div>
            </div>
          </div>   
          @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">{{ Session::get("condominium") }}
                    {{ FunctionsControllers::fillSelect("condominium", 0) }}
                </select>
              </div>
            </div>    
            @else
              <input type="hidden" name="idCondominium" id="idCondominium" value="{{ Session::get('condominium') }}">
            @endif                                   
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>

@include ('Layout.footer')