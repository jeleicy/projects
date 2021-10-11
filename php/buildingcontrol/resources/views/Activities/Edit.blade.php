<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

?>

@include ('Layout.header')
@foreach ($activities as $activities)
    <div class="content-border">
      <div class="card-header">Activities Form Edit</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('updateActivities') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $activities->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listActivities">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="{{ $activities->name }}">
              </div>
            </div>
          </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">
                    {{ FunctionsControllers::fillSelect("condominium", $activities->idCondominium) }}
                </select>
              </div>
            </div>            
          <input type="submit" class="btn btn-primary btn-block col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach
@include ('Layout.footer')