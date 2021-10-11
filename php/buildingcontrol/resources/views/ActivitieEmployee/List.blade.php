<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

$roleName=FunctionsControllers::getName("role",Session::get("role"));

if (strtolower($roleName)=="employee")
	$nameEmployee=Session::get("name");
else
	$nameEmployee="";

?>

@include ('Layout.header')

    <div class="content-border">
		<div class="card-header">Activitie Employee <h3>{{ $nameEmployee }}</h3></div>
      <div class="card-body">

         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formActivitieEmployee') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			      <th>Employee</th>
			      <th>Activitie</th>
			      <th>Condominium</th>
			      <th>Building</th>
			      <th>Floor</th>
			      <th>Apartment</th>
			      <th>Date</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($ActivitieEmployee as $ActivitieEmployee)
			    <tr>
			      <td>{{ FunctionsControllers::getName("employee",$ActivitieEmployee->idEmployee) }}</td>
			      <td>{{ FunctionsControllers::getName("activities",$ActivitieEmployee->idActivitie) }}</td>
			      <td>{{ FunctionsControllers::getCondominiumBuilding($ActivitieEmployee->idBuilding) }}</td>	      
			      <td>{{ FunctionsControllers::getName("building",$ActivitieEmployee->idBuilding) }}</td>
			      <td>{{ $ActivitieEmployee->floor }}</td>
			      <td>{{ $ActivitieEmployee->apartment }}</td>
			      <td>{{ $ActivitieEmployee->ActivitiDateTime }}</td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('editActivitieEmployee',['id' => $ActivitieEmployee->id]) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('deleteActivitieEmployee',['id' => $ActivitieEmployee->id]) }}">Delete</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>

@include ('Layout.footer')