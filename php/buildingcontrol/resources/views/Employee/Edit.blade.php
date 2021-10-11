<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

$roleName=strtolower(FunctionsControllers::getName("role",Session::get("role")));

?>

@include ('Layout.header')
@foreach ($employee as $employee)

<?php
  $datehire=$employee->datehire;
  $datehire=FunctionsControllers::NormalDate($datehire);
?>

    <div class="content-border">
      <div class="card-header">Employee Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ URL::route('updateEmployee') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $employee->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listEmployee">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="{{ $employee->name }}">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Date of Hire</label>
                <input id="datehire" required="required" name="datehire" width="276" value="{{ $datehire }}" />
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
                <input class="form-control" id="phone" name="phone" type="text" required="required" aria-describedby="nameHelp" placeholder="Phone" value="{{ $employee->phone }}">
              </div>
            </div>
          </div>   
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Job Position</label>
                <input class="form-control" id="jobpsition;" name="jobpsition" type="text" required="required" aria-describedby="nameHelp" placeholder="Job Position" value="{{ FunctionsControllers::getName('jobposition', $employee->id) }}">
              </div>
            </div>
          </div>   
          @if (strpos($roleName,"super") !== false)
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">{{ Session::get("condominium") }}
                    {{ FunctionsControllers::fillSelect("condominium", $employee->idCondominium) }}
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
@endforeach
@include ('Layout.footer')