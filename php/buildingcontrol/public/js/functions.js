// Javascripts

function viewRoleEmp(idCondominium, ruta, idRole, idEmployee) {
	
	var parametros = {
		"idCondominium" : idCondominium,
		"idRole" : idRole,
		"idEmployee" : idEmployee
	};
	//alert("viewRoleEmp?idCondominium="+idCondominium);
	$.ajax({
		data:  parametros,
		url:   ruta+'viewRoleEmp',
		type:  'get',
		success:  function (data) {
			//alert(data.role);
			$("#idRole").html(data.role);
			$("#idEmployee").html(data.employee);
			
		}
	});
}

function viewBuilding(idCondominium,idBuilding,ruta) {
	var parametros = {
		"idCondominium" : idCondominium,
		"idBuilding" : idBuilding
	};
	//alert("viewBuilding?idCondominium="+idCondominium);
	$.ajax({
		data:  parametros,
		url:   ruta+'viewBuilding',
		type:  'get',
		success:  function (data) {
			//alert(data.building);
			$("#idBuilding").html(data.building);
			
		}
	});
}

function addItems(ruta) {
	idItem_get=$('#idItem').val();
	quantity_get=$('#quantity').val();
	
	//alert("Item_array lenght = "+Item_array.length);
	
	img='<a href="javascript:;" onclick="minusItems('+i+')"><img id="minus_'+i+'" src="'+ruta+'images/minus.png" width="30" height="30">';
	if (idItem_get==0 || quantity_get=="" || quantity_get==0)
		$('#errorMessage').html("<span style='color:red; font-weight: bold'>Please Insert Item and Quantity</span>");
	else {
		if (findArray(Item_array,idItem_get) == true)
			$('#errorMessage').html("<span style='color:red; font-weight: bold'>This item has been added</span>");
		else {
			// AJAX: Verify Item Quantity from Inventory
			var idCondominium=$('#idCondominium').val();
			var parametros = {
				"idItem" : idItem_get,
				"idCondominium" : idCondominium
			};
			alert(ruta+'getQuantity?idItem='+idItem_get+"&idCondominium="+idCondominium)
			$.ajax({
				data:  parametros,
				url:   ruta+'getQuantity',
				type:  'get',
				success:  function (data) {
					//nameItem=data.result;
					//alert(data.result);
					var totalQuantity=data.result;
					
					//alert("totalQuantity="+totalQuantity);
					
					if (totalQuantity<quantity_get)
						$('#errorMessage').html("<span style='color:red; font-weight: bold'>The quantity is more that we have in the stock</span>");
					else {
						// AJAX: Find Item Name from ID
						var nameItem="";
						var parametros = {
							"id" : idItem_get,
							"table" : "items"
						};
						$.ajax({
							data:  parametros,
							url:   ruta+'putName',
							type:  'get',
							success:  function (data) {
								nameItem=data.result;
								table="";
								table+="<tr id='r"+i+"'><td>"+nameItem+"</td><td>"+quantity_get+"</td><td>"+img+"</td></tr>";
								
								Item_array[i]=idItem_get;
								Quantity_array[i]=quantity_get;
																
								Item_array_values=addValues(Item_array);
								Quantity_array_values=addValues(Quantity_array);
								i++;
								
								$("#valItems").val(Item_array_values);
								$("#valQuantity").val(Quantity_array_values);
								
								$('#idItem').val("");
								$('#quantity').val("");
								$('#tableItems').append(table);
								$('#errorMessage').html("");			
							}
						});
						// AJAX: Find Item Name from ID			
					}						
				}
			});			
			// AJAX: Verify Item Quantity from Inventory
		}
	}
}