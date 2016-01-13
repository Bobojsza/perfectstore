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

Route::get('test', function(){

});

Route::get('/', 'DashboardController@index');

Route::resource('dashboard', 'DashboardController');

Route::resource('form','FormsController');

Route::resource('multiselect','MultiSelectController');

Route::resource('singleselect','SingleSelectController');

Route::get('audittemplate/{id}/duplicate',['as' => 'audittemplate.duplicate', 'uses' => 'AuditTemplateController@duplicate']);
Route::post('audittemplate/{id}/duplicatetemplate',['as' => 'audittemplate.duplicatetemplate', 'uses' => 'AuditTemplateController@duplicatetemplate']);
Route::get('audittemplate/{id}/deleteform',['as' => 'audittemplate.deleteform', 'uses' => 'AuditTemplateController@deleteform']);
Route::delete('audittemplate/{id}/destroyform',['as' => 'audittemplate.destroyform', 'uses' => 'AuditTemplateController@destroyform']);
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

Route::get('user/{id}/stores','UserController@stores');
Route::resource('user', 'UserController');

Route::resource('sostag', 'SostaggingController');

Route::resource('soslookup', 'SoslookupController');

Route::resource('secondarydisplay', 'SecondarydisplayController');

Route::resource('secondarylookup', 'SecondarylookupController');

Route::resource('osalookup', 'OsaController');

Route::resource('auditreport', 'AuditReportController');


Route::group(array('prefix' => 'api'), function()
{
   Route::get('form/inputs', 'Api\FormsController@inputs');
   Route::get('forms', 'Api\FormsController@forms');
   Route::get('stores', 'Api\StoreController@stores');

   Route::get('user/stores', 'Api\AuditController@stores');
   Route::get('auth', 'Api\AuthUserController@auth');

   Route::get('download', 'Api\DownloadController@index');
   Route::get('image', 'Api\DownloadController@image');

   Route::post('storeaudit', 'Api\UploadController@storeaudit');
});//
