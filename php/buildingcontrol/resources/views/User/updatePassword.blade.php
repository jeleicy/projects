<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;
use URL;

?>

@include ('Layout.header')
@foreach ($users as $users)
    <div class="content-border">
      <div class="card-header">Update Password from User <strong>{{ $users->user }}</strong></div>
      <div class="card-body">
        
         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

        <form name="form1" method="post" action="{{ URL::route('saveupdateUsers') }}">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $users->id }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">New Password:</label>
                <input class="form-control" id="password" name="password" type="password" required="required" aria-describedby="nameHelp" placeholder="New Password" value="">
              </div>
            </div>
          </div>   
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Repeat New Password:</label>
                <input class="form-control" id="repeatpassword" name="repeatpassword" type="password" required="required" aria-describedby="nameHelp" placeholder="Repeat New Password" value="">
              </div>
            </div>
          </div>                                    
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach    
@include ('Layout.footer')