<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')
@foreach ($inventory as $inventory)
    <div class="content-border">
      <div class="card-header">Inventory Form Edit</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('updateInventory') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $inventory->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listInventory">List</a>
          </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Item</label>
                <select class="form-control" id="idItem" name="idItem" required="required">
                    {{ FunctionsControllers::fillSelect("items", $inventory->idItem) }}
                </select>
              </div>
            </div> 
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Entry Date</label>
                <input id="entryDate" required="required" name="entryDate" width="276" value="{{ FunctionsControllers::NormalDate($inventory->entryDate) }}" />
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
                <input class="form-control col-md-3" id="entryQuantity" name="entryQuantity" type="number" required="required" aria-describedby="nameHelp" placeholder="Quantity" value="{{ $inventory->entryQuantity }}" >
              </div>
            </div>
          </div>                 
          @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">{{ Session::get("condominium") }}
                    {{ FunctionsControllers::fillSelect("condominium", $inventory->idCondominium) }}
                </select>
              </div>
            </div>    
            @else
              <input type="hidden" name="idCondominium" id="idCondominium" value="{{ $inventory->idCondominium }}">
            @endif        
          <input type="submit" class="btn btn-primary btn-block col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach
@include ('Layout.footer')