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

Route::view('/', 'landing');

Auth::routes();

Route::get('/admin', 'DashboardController@index')->name('admin.dashboard');


//=== SETTINGS ===

Route::get('/admin/settings/countries', 'Settings\CountriesController@index')->name('countries.index');
Route::get('/admin/settings/countries/form/{id}', 'Settings\CountriesController@form')->name('countries.form');
Route::post('/admin/settings/countries/{id}', 'Settings\CountriesController@store')->name('countries.store');
Route::delete('/admin/settings/countries/{id}', 'Settings\CountriesController@delete')->name('countries.delete');

Route::get('/admin/settings/cities', 'Settings\CitiesController@index')->name('cities.index');
Route::get('/admin/settings/cities/form/{id}', 'Settings\CitiesController@form')->name('cities.form');
Route::post('/admin/settings/cities/{id}', 'Settings\CitiesController@store')->name('cities.store');
Route::delete('/admin/settings/cities/{id}', 'Settings\CitiesController@delete')->name('cities.delete');

Route::get('/admin/settings/time-zones', 'Settings\TimeZonesController@index')->name('timeZones.index');
Route::get('/admin/settings/time-zones/form/{id}', 'Settings\TimeZonesController@form')->name('timeZones.form');
Route::post('/admin/settings/time-zones/{id}', 'Settings\TimeZonesController@store')->name('timeZones.store');
Route::delete('/admin/settings/time-zones/{id}', 'Settings\TimeZonesController@delete')->name('timeZones.delete');

Route::get('/admin/settings/translate', 'Settings\TranslationController@index')->name('translations.index');
Route::post('/admin/settings/translate', 'Settings\TranslationController@store')->name('translations.store');

Route::get('/admin/settings/currencies', 'Settings\CurrenciesController@index')->name('currencies.index');
Route::get('/admin/settings/currencies/form/{id}', 'Settings\CurrenciesController@form')->name('currencies.form');
Route::post('/admin/settings/currencies/{id}', 'Settings\CurrenciesController@store')->name('currencies.store');
Route::delete('/admin/settings/currencies/{id}', 'Settings\CurrenciesController@delete')->name('currencies.delete');

Route::get('/admin/settings/loadFiles', 'Settings\LoadFilesController@index')->name('loadFiles.index');
Route::post('/admin/settings/loadFiles/', 'Settings\LoadFilesController@store')->name('loadFiles.store');

Route::get('/admin/settings/settings', 'Settings\SettingsController@index')->name('settings.index');
Route::get('/admin/settings/settings/form/{id}', 'Settings\SettingsController@form')->name('settings.form');
Route::post('/admin/settings/settings/{id}', 'Settings\SettingsController@store')->name('settings.store');

Route::get('/admin/settings/auth-parameters', 'Settings\AuthParametersController@index')->name('authParameters.index');
Route::get('/admin/settings/auth-parameters/form', 'Settings\AuthParametersController@form')->name('authParameters.form');
Route::post('/admin/settings/auth-parameters', 'Settings\AuthParametersController@store')->name('authParameters.store');



//=== USERS ===

// user groups
Route::get('/admin/user-groups', 'Users\UserGroupsController@index')->name('userGroups.index');
Route::get('/admin/user-groups/form/{id}', 'Users\UserGroupsController@form')->name('userGroups.form');
Route::post('/admin/user-groups/{id}', 'Users\UserGroupsController@store')->name('userGroups.store');
Route::delete('/admin/user-groups/{id}', 'Users\UserGroupsController@delete')->name('userGroups.delete');

Route::get('/admin/users', 'Users\UsersController@index')->name('users.index');
Route::get('/admin/users/form/{id}', 'Users\UsersController@form')->name('users.form');
Route::post('/admin/users/{id}', 'Users\UsersController@store')->name('users.store');
Route::delete('/admin/users/{id}', 'Users\UsersController@delete')->name('users.delete');

Route::get('/admin/user-acl-roles', 'Users\RolesController@index')->name('aclRoles.index');
Route::get('/admin/user-acl-roles/form/{id}', 'Users\RolesController@form')->name('aclRoles.form');
Route::post('/admin/user-acl-roles/{id}', 'Users\RolesController@store')->name('aclRoles.store');
Route::delete('/admin/user-acl-roles/{id}', 'Users\RolesController@delete')->name('aclRoles.delete');


//=== STORES ===

Route::get('/admin/store-groups', 'Stores\StoreGroupsController@index')->name('storeGroups.index');
Route::get('/admin/store-groups/form/{id}', 'Stores\StoreGroupsController@form')->name('storeGroups.form');
Route::post('/admin/store-groups/{id}', 'Stores\StoreGroupsController@store')->name('storeGroups.store');
Route::delete('/admin/store-groups/{id}', 'Stores\StoreGroupsController@delete')->name('storeGroups.delete');

Route::get('/admin/stores', 'Stores\StoresController@index')->name('stores.index');
Route::get('/admin/stores/form/{id}', 'Stores\StoresController@form')->name('stores.form');
Route::post('/admin/stores/{id}', 'Stores\StoresController@store')->name('stores.store');
Route::delete('/admin/stores/{id}', 'Stores\StoresController@delete')->name('stores.delete');

Route::get('/admin/stores/prices', 'Stores\PricesController@index')->name('prices.index');
Route::get('/admin/stores/prices/form/{id}', 'Stores\PricesController@form')->name('prices.form');
Route::post('/admin/stores/prices/{id}', 'Stores\PricesController@store')->name('prices.store');
Route::delete('/admin/stores/prices/{id}', 'Stores\PricesController@delete')->name('prices.delete');


//=== COMPANY ===

Route::get('/admin/company/employees', 'Company\EmployeesController@index')->name('employees.index');
Route::get('/admin/company/employees/form/{id}', 'Company\EmployeesController@form')->name('employees.form');
Route::post('/admin/company/employees/{id}', 'Company\EmployeesController@store')->name('employees.store');
Route::delete('/admin/company/employees/{id}', 'Company\EmployeesController@delete')->name('employees.delete');

Route::get('/admin/company/divisions', 'Company\DivisionsController@index')->name('divisions.index');
Route::get('/admin/company/divisions/form/{id}', 'Company\DivisionsController@form')->name('divisions.form');
Route::post('/admin/company/divisions/{id}', 'Company\DivisionsController@store')->name('divisions.store');
Route::delete('/admin/company/divisions/{id}', 'Company\DivisionsController@delete')->name('divisions.delete');

Route::get('/admin/company/company-info', 'Company\CompanyController@index')->name('company.index');
Route::get('/admin/company/company-info/form', 'Company\CompanyController@form')->name('company.form');
Route::post('/admin/company/company-info', 'Company\CompanyController@store')->name('company.store');


//=== CRM ===

Route::get('/admin/crm/clients', 'Crm\ClientsController@index')->name('clients.index');
Route::get('/admin/crm/clients/form/{id}', 'Crm\ClientsController@form')->name('clients.form');
Route::post('/admin/crm/clients/{id}', 'Crm\ClientsController@store')->name('clients.store');
Route::delete('/admin/crm/clients/{id}', 'Crm\ClientsController@delete')->name('clients.delete');
Route::get('/admin/crm/clients/info/{id}', 'Crm\ClientsController@info')->name('clients.info');
Route::get('/admin/crm/clients/amlReportView/{id}', 'Crm\ClientsController@amlReportView')->name('clients.amlReportView');
Route::get('/admin/crm/clients/amlReport/{id}', 'Crm\ClientsController@amlReport')->name('clients.amlReport');
Route::post('/admin/crm/clients/amlReport/{id}', 'Crm\ClientsController@amlReportStore')->name('clients.amlReportStore');




//=== FILES ===
Route::get('/admin/file/view/{fileId}', 'FilesController@view')->name('file.view');
Route::get('/admin/file/download/{fileId}', 'FilesController@download')->name('file.download');


//=== API ===

Route::any('/api/{ver}/{method}', 'ApiController@index');
Route::any('/api/{ver}/files/{fileId}', 'ApiController@files');
