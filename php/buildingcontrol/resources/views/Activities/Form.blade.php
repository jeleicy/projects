<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Activities Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="createActivities">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listActivities">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name">
              </div>
            </div>
          </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Condominium</label>
                <select class="form-control" id="idCondominium" name="idCondominium" required="required">
                    {{ FunctionsControllers::fillSelect("condominium", 0) }}
                </select>
              </div>
            </div>            
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>

@include ('Layout.footer')