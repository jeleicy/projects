<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Menus Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ route('createMenu') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listMenus">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">URL</label>
                <input class="form-control" id="url" name="url" type="text" required="required" aria-describedby="nameHelp" placeholder="URL">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Father</label>
                <select class="form-control" id="father" name="father" required="required">
                    {{ FunctionsControllers::fillSelect("menu", 0) }}
                </select>
              </div>
            </div>                                           
          </div>
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>

@include ('Layout.footer')