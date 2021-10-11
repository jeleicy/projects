<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Activities</div>
      <div class="card-body">

         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formActivities') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			    <tr>
			      <th>Name</th>
			      <th>Condominium</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($activities as $activities)
			    <tr>
			      <td>{{ $activities->name }}</td>
			      <td>{{ FunctionsControllers::getName("condominium", $activities->idCondominium) }}</td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('editActivities',['id' => $activities->id]) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('deleteActivities',['id' => $activities->id]) }}">Delete</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>

@include ('Layout.footer')