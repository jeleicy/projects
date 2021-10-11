<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Building Control </title>
  <!-- Bootstrap core CSS-->
  <link href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="{{ URL::asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="{{ URL::asset('vendor/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ URL::asset('css/sb-admin.css') }}" rel="stylesheet">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">  
  
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
  
	<script src="{{ URL::asset('js/bootstrap-formhelpers-phone.js') }}"></script>	
	
  <style>
	.content-border {
		border: 1px #c8c8c8 solid; 
		width: 95%;
		border-radius: 10px;
		margin:1%;
	}
  </style>
  
  <script>
	var Item_array=new Array();
	var Quantity_array=new Array();
	var i=0;
	
	function addValues(addArray) {
		var res="";
		for (j=0;j<addArray.length;j++)
			res+=addArray[j]+",";
		return res;
	}

	function minusItems(j) {
		$("#r"+j).remove();
		Item_array[j]=0;
		Quantity_array[j]=0;	
	}

	function findArray(arrayVar,arraySearch) {
		for (j=0;j<arrayVar.length;j++) {
			if (arrayVar[j]==arraySearch)
				return true;			
		}
		return false;
	}	
  </script>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  @include ('Layout.navigation')
  <div class="content-wrapper">
    <!--******************BEGIN DASHBOARD*****************************-->