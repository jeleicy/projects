<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')
    <div class="content-border">
      <div class="card-header">Employees</div>
      <div class="card-body">

         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formEmployee') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			    <tr>
			      <th>Name</th>
			      <th>Date of hire</th>
			      <th>Phone</th>
			      <th>Job Position</th>
			      <th>Condominium</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($employee as $employee)
			    <tr>
			      <td>{{ $employee->name }}</td>
			      <td>{{ FunctionsControllers::NormalDate($employee->datehire) }}</td>
			      <td>{{ $employee->phone }}</td>
			      <td>{{ FunctionsControllers::getName("jobposition", $employee->id) }}</td>
			      <td>{{ FunctionsControllers::getName("condominium", $employee->idCondominium) }}</td>			      
			      <td>
			      	<a class="btn btn-primary btn-block col-md-12" href="{{ url('editEmployee',['id' => $employee->id]) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-12" href="{{ url('deleteEmployee',['id' => $employee->id]) }}">Delete</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>
@include ('Layout.footer')