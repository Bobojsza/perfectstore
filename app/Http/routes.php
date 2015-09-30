<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DashboardController@index');

Route::resource('dashboard', 'DashboardController');

Route::resource('form','FormsController');

Route::resource('multiselect','MultiSelectController');

Route::resource('singleselect','SingleSelectController');

Route::get('audittemplate/{id}/forms', ['as' => 'audittemplate.form', 'uses' => 'AuditTemplateController@forms']);
Route::get('audittemplate/{id}/addform', ['as' => 'audittemplate.addform', 'uses' => 'AuditTemplateController@addform']);
Route::post('audittemplate/{id}/addform', ['as' => 'audittemplate.storeform', 'uses' => 'AuditTemplateController@storeform']);
Route::put('audittemplate/{id}/updateorder', ['as' => 'audittemplate.updateorder', 'uses' => 'AuditTemplateController@updateorder']);

Route::resource('audittemplate','AuditTemplateController');

Route::resource('formcategory','FormCategoryController');

Route::resource('formgroup','FormGroupController');

Route::resource('audit','AuditController');

Route::resource('account','AccountController');

Route::resource('customer','CustomerController');

Route::resource('area', 'AreaController');

Route::resource('region', 'RegionController');

Route::resource('distributor', 'DistributorController');

Route::resource('store', 'StoreController');

Route::resource('gradematrix', 'GradeMatrixController');

Route::resource('role', 'RoleController');

Route::resource('user', 'UserController');

Route::group(array('prefix' => 'api'), function()
{
   Route::get('form/inputs', 'Api\FormsController@inputs');
   Route::get('forms', 'Api\FormsController@forms');
   Route::get('stores', 'Api\StoreController@stores');

   Route::get('user/{id}/stores', 'Api\AuditController@stores');
   Route::post('auth', 'Api\AuthUserController@auth');
});//
