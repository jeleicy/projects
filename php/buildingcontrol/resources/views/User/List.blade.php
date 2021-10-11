<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')
    <div class="content-border">
      <div class="card-header">Users</div>
      <div class="card-body">

         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formUsers') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			    <tr>
			      <th>User</th>
			      <th>Role</th>
			      <th>Employee</th>
			      <th>Condominium</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($users as $users)
			    <tr>
			      <td>{{ $users->user }}</td>
			      <td>{{ FunctionsControllers::getName("role", $users->idRole) }}</td>
			      <td>{{ FunctionsControllers::getName("employee", $users->idEmployee) }}</td>
			      <td>{{ FunctionsControllers::getCondominiumUser($users->id) }}</td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-12" href="{{ url('editUsers',['id' => $users->id]) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-12" href="{{ url('deleteUsers',['id' => $users->id]) }}">Delete</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-12" href="{{ url('updatePassword',['id' => $users->id]) }}">Update Password</a>
			      </td>			      
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>
@include ('Layout.footer')