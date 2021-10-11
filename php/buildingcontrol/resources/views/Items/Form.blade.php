<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Items Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="createItems">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listItems">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name">
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