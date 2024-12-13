<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
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

Auth::routes();

// Test Trecking
Route::get('track/tools', 'ToolsTrackingController@track')->name('track.tools');
Route::post('tracking/tools', 'ToolsTrackingController@tracking')->name('tracking.tools');

// Test DN Transport
Route::get('dn-transport/tools', 'ToolsDnTransportController@dnTransport')->name('dn-transport.tools');
Route::post('dn-trans/tools', 'ToolsDnTransportController@dnTransporting')->name('dntrans.store');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Contract
    Route::group(['prefix' => 'contracts'], function () {
        // Contract Management
        Route::resource('contract', 'ContractController');

        // Contract Export fix
        Route::get('export-detail/{id}', 'ContractController@export')->name('contract.export');
        Route::get('export-pdf', 'ContractController@exportPdf')->name('contract.exportPdf');
        Route::get('export-excel', 'ContractController@exportExcel')->name('contract.exportExcel');
        Route::post('import-contract', 'ContractController@importContract')->name('contract.importContract');

        // Contract Filter
        // Route::get('export-status-contract', 'ContractController@exportStatusContract')->name('contract.filterStatusContract');
        // Route::get('export-status-proyek', 'ContractController@exportStatusProject')->name('contract.filterStatusProject');
    });

    // Tools
    Route::group(['prefix' => 'tools'], function () {
        // Tools Management
        Route::resource('tools', 'ToolsController');
        // Tools Trasfer Management
        Route::post('transfer', 'ToolsController@transfer')->name('tools.transfer');
        // Tools Categories Management
        Route::resource('categories', 'ToolsCategoriesController');
        // Tools Ownership Management
        Route::resource('owners', 'ToolsOwnershipController');
        // Tools Tracking Management
        Route::resource('tracking', 'ToolsTrackingController');
        // Tools Dn Transport Management
        Route::resource('dn-transport', 'ToolsDnTransportController');
        // Tools Maintenance Management
        Route::resource('tools-maintenances', 'ToolsMaintenanceController');
        Route::post('tools-maintenances/completed/{id}', 'ToolsMaintenanceController@completeMaintenance')->name('tools-maintenances.completeMaintenance');
        Route::post('tools-maintenances/cenceled/{id}', 'ToolsMaintenanceController@cancelMaintenance')->name('tools-maintenances.cancelMaintenance');
        // Route::post('tools-maintenances/pending/{id}', 'ToolsMaintenanceController@pendingMaintenance')->name('tools-maintenances.pendingMaintenance');
    });

    // Vehicles
    Route::group(['prefix' => 'vehicles'], function () {
        // Vehicles Management
        Route::resource('vehicles', 'VehiclesController');
        Route::post('assign', 'VehiclesController@assign')->name('vehicles.assign');
        // Vehicles Assign Management
        Route::resource('vehicles-assign', 'VehicleAssignmentController');
        // Vehicle Type Management
        Route::resource('types', 'VehicleTypeController');
        // Vehicle Ownership Management
        Route::resource('ownerships', 'VehicleOwnershipController');
        // Vehicle Maintenance Management
        Route::resource('vehicles-maintenances', 'VehicleMaintenanceController');
        Route::post('vehicles-maintenances/completed/{id}', 'VehicleMaintenanceController@completeMaintenance')->name('vehicles-maintenances.completeMaintenance');
        // Route::post('vehicles-maintenances/cenceled/{id}', 'VehicleMaintenanceController@cancelMaintenance')->name('vehicles-maintenances.cancelMaintenance');
        Route::get('vehicles-export-detail/{id}', 'VehicleMaintenanceController@exportPdf')->name('vehicles-maintenances.exportPdf');
        // Vehicle Insurance Management
        Route::resource('insurances', 'VehicleInsuranceController');
        Route::get('insurances-export-detail/{id}', 'VehicleInsuranceController@exportPdf')->name('insurances.exportPdf');
    });

    // Vouchers
    Route::group(['prefix' => 'vouchers'], function () {
        // Vouchers Management
        Route::resource('vouchers', 'VouchersController');
    });

    // Equipments
    Route::group(['prefix' => 'equipments'], function () {
        // Equipment Management
        Route::resource('equipments', 'EquipmentsController');
    });

    // Ticketing
    Route::group(['prefix' => 'ticketings'], function () {
        // Ticketing Management
        Route::resource('ticketing', 'TicketingController');
        Route::post('ticketing/handle/{id}', 'TicketingController@handle')->name('ticketing.handle');
        Route::post('ticketing/comment/{id}', 'TicketingController@comment')->name('ticketing.comment');
        Route::post('ticketing/solved/{id}', 'TicketingController@solved')->name('ticketing.solved');
        Route::post('ticketing/cancel/{id}', 'TicketingController@cancled')->name('ticketing.cancled');
    });

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

    // Profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // About 
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
