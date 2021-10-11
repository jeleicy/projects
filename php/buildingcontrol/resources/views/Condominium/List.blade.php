<?php

namespace App\Http\Controllers;
use Session;

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Condominiums</div>
		<div class="card-body">
         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formCondominium') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			    <tr>
			      <th>Name</th>
			      <th>Address</th>
			      <th>Manager</th>
			      <th>Logo</th>
			      <th>Phone</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($condominium as $condominium)
			    <tr>
			      <td>{{ $condominium->name }}</td>
			      <td>{{ $condominium->address }}</td>
			      <td>{{ $condominium->manager }}</td>
			      <td><img src="{{ asset('images/logos/' . $condominium->logo ) }}" width="100" height="100"></td>
			      <td>{{ $condominium->phone }}</td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('editCondominium/' . $condominium->id ) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('deleteCondominium/' . $condominium->id ) }}">Delete</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>

@include ('Layout.footer')