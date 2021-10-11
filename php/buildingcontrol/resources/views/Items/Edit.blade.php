<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')
@foreach ($items as $items)
    <div class="content-border">
      <div class="card-header">items Form Edit</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('updateItems') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $items->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listItems">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="{{ $items->name }}">
              </div>
            </div>
          </div>
          @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">{{ Session::get("condominium") }}
                    {{ FunctionsControllers::fillSelect("condominium", $items->idCondominium) }}
                </select>
              </div>
            </div>    
            @else
              <input type="hidden" name="idCondominium" id="idCondominium" value="{{ Session::get('condominium') }}">
            @endif          
          <input type="submit" class="btn btn-primary btn-block col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach
@include ('Layout.footer')