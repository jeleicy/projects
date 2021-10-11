<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	Session::put("message","");
    return view('User/login');
});

Route::get('index', function () {
    Session::put("message","");
    return view('Dashboard/index');
});


Route::get('forgot-password', function () {
    Session::put("message","");
    return view('User/forgot-password');
});

Route::get('listBuilding', function () {
    Session::put("message","");
    return view('Building/Form');
});

Route::get('listRole', function () {
    Session::put("message","");
    return view('Role/Form');
});

/**********************Users************************/

Route::get('logOut', array(
    'as' => 'logOut',
    'uses' => 'UsersController@logOut'
));

Route::post('verify_user', array(
    'as' => 'verify_user',
    'uses' => 'UsersController@verify_user'
));

Route::get('formUsers', function () {
    Session::put("message","");
    return view('User/Form');
});

Route::post('createUsers', array(
    'as' => 'createUsers',
    'uses' => 'UsersController@create'
));

Route::get('updatePassword/{id}', array(
    'as' => 'updatePassword',
    'uses' => 'UsersController@updatePassword'
));

Route::post('saveupdateUsers', array(
    'as' => 'saveupdateUsers',
    'uses' => 'UsersController@saveupdateUsers'
));

Route::post('updateUsers', array(
    'as' => 'updateUsers',
    'uses' => 'UsersController@update'
));

Route::get('deleteUsers/{id}', array(
    'as' => 'deleteUsers',
    'uses' => 'UsersController@destroy'
));

Route::get('editUsers/{id}', array(
    'as' => 'editUsers',
    'uses' => 'UsersController@edit'
));

Route::get('listUsers', array(
    'as' => 'listUsers',
    'uses' => 'UsersController@show'
));

/**********************Activities************************/

Route::get('formActivities', function () {
    return view('Activities/Form');
});

Route::post('createActivities', array(
    'as' => 'createActivities',
    'uses' => 'ActivitiesController@create'
));

Route::post('updateActivities', array(
    'as' => 'updateActivities',
    'uses' => 'ActivitiesController@update'
));

Route::get('deleteActivities/{id}', array(
    'as' => 'deleteActivities',
    'uses' => 'ActivitiesController@destroy'
));

Route::get('editActivities/{id}', array(
    'as' => 'editActivities',
    'uses' => 'ActivitiesController@edit'
));

Route::get('listActivities', array(
    'as' => 'listActivities',
    'uses' => 'ActivitiesController@show'
));

/**********************Condominium************************/

Route::get('formCondominium', function () {
    return view('Condominium/Form');
});

Route::post('createCondominium', array(
    'as' => 'createCondominium',
    'uses' => 'CondominiumController@create'
));

Route::post('updateCondominium', array(
    'as' => 'updateCondominium',
    'uses' => 'CondominiumController@update'
));

Route::get('deleteCondominium/{id}', array(
    'as' => 'deleteCondominium',
    'uses' => 'CondominiumController@destroy'
));

Route::get('editCondominium/{id}', array(
    'as' => 'editCondominium',
    'uses' => 'CondominiumController@edit'
));

Route::get('listCondominium', array(
    'as' => 'listCondominium',
    'uses' => 'CondominiumController@show'
));

/**********************Building************************/

Route::get('formBuilding', function () {
    return view('Building/Form');
});

Route::post('createBuilding', array(
    'as' => 'createBuilding',
    'uses' => 'BuildingController@create'
));

Route::post('updateBuilding', array(
    'as' => 'updateBuilding',
    'uses' => 'BuildingController@update'
));

Route::get('deleteBuilding/{id}', array(
    'as' => 'deleteBuilding',
    'uses' => 'BuildingController@destroy'
));

Route::get('editBuilding/{id}', array(
    'as' => 'editBuilding',
    'uses' => 'BuildingController@edit'
));

Route::get('listBuilding', array(
    'as' => 'listBuilding',
    'uses' => 'BuildingController@show'
));

/**********************Role************************/

Route::get('formRole', function () {
    return view('Role/Form');
});

Route::post('createRole', array(
    'as' => 'createRole',
    'uses' => 'RoleController@create'
));

Route::post('updateRole', array(
    'as' => 'updateRole',
    'uses' => 'RoleController@update'
));

Route::get('deleteRole/{id}', array(
    'as' => 'deleteRole',
    'uses' => 'RoleController@destroy'
));

Route::get('editRole/{id}', array(
    'as' => 'editRole',
    'uses' => 'RoleController@edit'
));

Route::get('listRole', array(
    'as' => 'listRole',
    'uses' => 'RoleController@show'
));

/**********************Employees************************/

Route::get('formEmployee', function () {
    return view('Employee/Form');
});

Route::post('createEmployee', array(
    'as' => 'createEmployee',
    'uses' => 'EmployeeController@create'
));

Route::post('updateEmployee', array(
    'as' => 'updateEmployee',
    'uses' => 'EmployeeController@update'
));

Route::get('deleteEmployee/{id}', array(
    'as' => 'deleteEmployee',
    'uses' => 'EmployeeController@destroy'
));

Route::get('editEmployee/{id}', array(
    'as' => 'editEmployee',
    'uses' => 'EmployeeController@edit'
));

Route::get('listEmployee', array(
    'as' => 'listEmployee',
    'uses' => 'EmployeeController@show'
));

/**********************Items************************/

Route::get('formItems', function () {
    return view('Items/Form');
});

Route::post('createItems', array(
    'as' => 'createItems',
    'uses' => 'ItemsController@create'
));

Route::post('updateItems', array(
    'as' => 'updateItems',
    'uses' => 'ItemsController@update'
));

Route::get('deleteItems/{id}', array(
    'as' => 'deleteItems',
    'uses' => 'ItemsController@destroy'
));

Route::get('editItems/{id}', array(
    'as' => 'editItems',
    'uses' => 'ItemsController@edit'
));

Route::get('listItems', array(
    'as' => 'listItems',
    'uses' => 'ItemsController@show'
));

/**********************Inventory************************/

Route::get('formInventory', function () {
    return view('Inventory/Form');
});

Route::post('createInventory', array(
    'as' => 'createInventory',
    'uses' => 'InventoryController@create'
));

Route::post('updateInventory', array(
    'as' => 'updateInventory',
    'uses' => 'InventoryController@update'
));

Route::get('deleteInventory/{id}', array(
    'as' => 'deleteInventory',
    'uses' => 'InventoryController@destroy'
));

Route::get('editInventory/{id}', array(
    'as' => 'editInventory',
    'uses' => 'InventoryController@edit'
));

Route::get('listInventory', array(
    'as' => 'listInventory',
    'uses' => 'InventoryController@show'
));

/**********************ActivitieEmployee************************/

Route::get('formActivitieEmployee', function () {
    return view('ActivitieEmployee/Form');
});

Route::post('createActivitieEmployee', array(
    'as' => 'createActivitieEmployee',
    'uses' => 'ActivitieEmployeeController@create'
));

Route::post('updateActivitieEmployee', array(
    'as' => 'updateActivitieEmployee',
    'uses' => 'ActivitieEmployeeController@update'
));

Route::get('deleteActivitieEmployee/{id}', array(
    'as' => 'deleteActivitieEmployee',
    'uses' => 'ActivitieEmployeeController@destroy'
));

Route::get('editActivitieEmployee/{id}', array(
    'as' => 'editActivitieEmployee',
    'uses' => 'ActivitieEmployeeController@edit'
));

Route::get('listActivitieEmployee', array(
    'as' => 'listActivitieEmployee',
    'uses' => 'ActivitieEmployeeController@show'
));

/**********************Menu************************/

Route::get('formMenu', function () {
    return view('Menu/Form');
});

Route::post('createMenu', array(
    'as' => 'createMenu',
    'uses' => 'MenuController@create'
));

Route::post('updateMenu', array(
    'as' => 'updateMenu',
    'uses' => 'MenuController@update'
));

Route::get('deleteMenu/{id}', array(
    'as' => 'deleteMenu',
    'uses' => 'MenuController@destroy'
));

Route::get('editMenu/{id}', array(
    'as' => 'editMenu',
    'uses' => 'MenuController@edit'
));

Route::get('listMenu', array(
    'as' => 'listMenu',
    'uses' => 'MenuController@show'
));

//***************************AJAX****************************

Route::get('viewRoleEmp', array(
    'as' => 'viewRoleEmp',
    'uses' => 'FunctionsControllers@viewRoleEmp'
));

Route::get('viewBuilding', array(
    'as' => 'viewBuilding',
    'uses' => 'FunctionsControllers@viewBuilding'
));

Route::get('putName', array(
    'as' => 'putName',
    'uses' => 'FunctionsControllers@putName'
));

Route::get('getQuantity', array(
    'as' => 'getQuantity',
    'uses' => 'FunctionsControllers@getQuantity'
));