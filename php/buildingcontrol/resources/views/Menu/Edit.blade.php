<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')
@foreach ($menu as $menu)
    <div class="content-border">
      <div class="card-header">Menus Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ route('updateMenu') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $menu->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listMenus">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="{{ $menu->name }}">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">URL</label>
                <input class="form-control" id="url" name="url" type="text" required="required" aria-describedby="nameHelp" placeholder="Address" value="{{ $menu->url }}">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Father</label>
                <select class="form-control" id="father" name="father" required="required">
                    {{ FunctionsControllers::fillSelect("menu", $menu->father) }}
                </select>
              </div>
            </div>                                          
          </div>
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach
@include ('Layout.footer')