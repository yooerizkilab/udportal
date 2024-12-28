<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Auth::routes();

// Trecking vie frontend
Route::get('tracking/tools', 'ToolsTrackingController@indexFrontend')->name('trackings.tools');
Route::get('tracking/tools/{id}', 'ToolsTrackingController@show')->name('tracking.tools');

// Delivery Note view frontend
Route::get('transactions/tools', 'ToolsTransactionController@createFrontend')->name('transactions.tools');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Contract Management Fix
    Route::group(['prefix' => 'contracts'], function () {
        Route::resource('contract', 'ContractController');
        Route::get('export-detail/{id}', 'ContractController@export')->name('contract.export');
        Route::get('export-excel', 'ContractController@exportExcel')->name('contract.exportExcel');
        Route::post('import-contract', 'ContractController@importContract')->name('contract.importContract');
    });

    // Ticketing Management Fix
    Route::group(['prefix' => 'ticketings'], function () {
        Route::resource('ticketing', 'TicketingController');
        Route::resource('ticketing-categories', 'TicketingCategoriesController');
        Route::patch('handle/{id}', 'TicketingController@handle')->name('ticketing.handle');
        Route::post('comment/{id}', 'TicketingController@comment')->name('ticketing.comment');
        Route::patch('solved/{id}', 'TicketingController@solved')->name('ticketing.solved');
        Route::patch('cancel/{id}', 'TicketingController@cancled')->name('ticketing.cancled');
    });

    // Tools Management
    Route::group(['prefix' => 'tools'], function () {
        Route::resource('categories', 'ToolsCategoriesController');
        Route::resource('tools', 'ToolsController');
        Route::resource('projects', 'ProjectsController');
        Route::resource('transactions', 'ToolsTransactionController');
        Route::get('transactions-pdf/{id}', 'ToolsTransactionController@generateDN')->name('transactions.generateDN');
        Route::resource('tracking', 'ToolsTrackingController');
        Route::resource('tools-maintenances', 'ToolsMaintenanceController');
        Route::patch('tools-maintenances/completed/{id}', 'ToolsMaintenanceController@completeMaintenance')->name('tools-maintenances.completeMaintenance');
        Route::patch('tools-maintenances/cenceled/{id}', 'ToolsMaintenanceController@cancelMaintenance')->name('tools-maintenances.cancelMaintenance');
        Route::get('tools-maintenances-export-detail/{id}', 'ToolsMaintenanceController@printMaintenance')->name('tools-maintenances.exportPdf');
    });

    // Vehicles Management
    Route::group(['prefix' => 'vehicles'], function () {
        Route::resource('vehicles', 'VehiclesController');
        Route::post('assign', 'VehiclesController@assign')->name('vehicles.assign');
        Route::resource('vehicles-assign', 'VehicleAssignmentController');
        Route::resource('types', 'VehicleTypeController');
        Route::resource('vehicles-maintenances', 'VehicleMaintenanceController');
        Route::post('vehicles-maintenances/completed/{id}', 'VehicleMaintenanceController@completeMaintenance')->name('vehicles-maintenances.completeMaintenance');
        // Route::post('vehicles-maintenances/cenceled/{id}', 'VehicleMaintenanceController@cancelMaintenance')->name('vehicles-maintenances.cancelMaintenance');
        Route::get('vehicles-export-detail/{id}', 'VehicleMaintenanceController@exportPdf')->name('vehicles-maintenances.exportPdf');
        Route::resource('insurances', 'VehicleInsuranceController');
        Route::get('insurances-export-detail/{id}', 'VehicleInsuranceController@exportPdf')->name('insurances.exportPdf');
    });

    // Vouchers Management
    Route::group(['prefix' => 'vouchers'], function () {
        Route::resource('vouchers', 'VouchersController');
    });

    // Equipment Management
    Route::group(['prefix' => 'equipments'], function () {
        Route::resource('equipments', 'EquipmentsController');
    });

    // Settings Management
    Route::group(['prefix' => 'settings'], function () {
        // Companies Management
        Route::resource('companies', 'CompanyController');
        // Branches Management 
        Route::resource('branches', 'BranchController');
        // Departments Management
        Route::resource('departments', 'DepartmentController');
        // Employees Management
        Route::resource('employees', 'EmployeController');
        // Users Management
        Route::resource('users', 'UsersController');
        Route::post('users/exportPdf', 'UsersController@exportPDF')->name('users.exportPdf');
        Route::post('users/exportExcel', 'UsersController@exportExcel')->name('users.exportExcel');
        Route::post('users/importUsers', 'UsersController@importUsers')->name('users.importUsers');
        // Roles Management
        Route::resource('roles', 'RolesController');
        Route::post('roles/assignPermissions', 'RolesController@assignPermissions')->name('roles.assignPermissions');
        // Permissions Management
        Route::resource('permissions', 'PermissionsController');
    });

    // Profile Fix
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // About 
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
