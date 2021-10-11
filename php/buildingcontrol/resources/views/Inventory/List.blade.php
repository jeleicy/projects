<?php

namespace App\Http\Controllers;
use App\Http\Controllers\FunctionsControllers;
use Session;

?>

@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Inventory Items</div>
      <div class="card-body">

         @if (Session::get("message") != "") 
         <div class="alert alert-success">
            <strong>{{ Session::get("message") }}</strong>
			{{ Session::put("message","") }}
          </div>
          @endif

		  <div class="form-group">
		      <a class="btn btn-primary btn-block col-md-2" href="{{ url('formInventory') }} ">New</a>
		  </div>

			<table align="center" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			  <thead>
			    <tr>
			      <th>Item</th>
			      <th>Entry Date</th>
			      <th>Quantity</th>
			      <th>Exists</th>
			      <th>Condominium</th>
			      <th>&nbsp;</th>
			      <th>&nbsp;</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach ($inventory as $inventory)
			    <tr>
			      <td>{{ FunctionsControllers::getName("items", $inventory->idItem) }}</td>
			      <td>{{ FunctionsControllers::NormalDate($inventory->entryDate) }}</td>
			      <td>{{ $inventory->entryQuantity }}</td>
			      <td>{{ FunctionsControllers::getItemQuantity($inventory->idItem) }}</td>
			      <td>{{ FunctionsControllers::getName("condominium", $inventory->idCondominium) }}</td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('editInventory',['id' => $inventory->id]) }}">Edit</a>
			      </td>
			      <td>
			      	<a class="btn btn-primary btn-block col-md-8" href="{{ url('deleteInventory',['id' => $inventory->id]) }}">Delete</a>
			      </td>
			    </tr>
			    @endforeach
			  </tbody>
			</table>
		</div>
	</div>

@include ('Layout.footer')