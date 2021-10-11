<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use Carbon\Carbon;

$current = Carbon::now();
$current = new Carbon();

// get today - 2015-12-19 00:00:00
$today = Carbon::today();

$today=substr($today,0,strpos($today," "));
$today=FunctionsControllers::NormalDate($today);
$today=str_replace("-", "/", $today);

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Inventory Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="createInventory">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listInventory">List</a>
          </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Item</label>
                <select class="form-control" id="idItem" name="idItem" required="required">
                    {{ FunctionsControllers::fillSelect("items", 0) }}
                </select>
              </div>
            </div> 
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Entry Date</label>
                <input id="entryDate"  required="required" name="entryDate" width="276" value="{{ $today }}" />
                <script>
                    $('#entryDate').datepicker({
                        uiLibrary: 'bootstrap4'
                    });
                </script>
            </div>
          </div> 
        </div>       
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Quantity</label>
                <input class="form-control col-md-3" id="entryQuantity" name="entryQuantity" type="number" required="required" aria-describedby="nameHelp" placeholder="Quantity">
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