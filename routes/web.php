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

    // Tools Management Fix 
    Route::group(['prefix' => 'tools'], function () {
        Route::resource('categories', 'ToolsCategoriesController');
        Route::resource('tools', 'ToolsController');
        Route::resource('projects', 'ProjectsController');
        Route::resource('transactions', 'ToolsTransactionController');
        Route::get('transactions-pdf/{id}', 'ToolsTransactionController@generateDN')->name('transactions.generateDN');
        Route::resource('tools-maintenances', 'ToolsMaintenanceController');
        Route::patch('tools-maintenances/completed/{id}', 'ToolsMaintenanceController@completeMaintenance')->name('tools-maintenances.completeMaintenance');
        Route::patch('tools-maintenances/cenceled/{id}', 'ToolsMaintenanceController@cancelMaintenance')->name('tools-maintenances.cancelMaintenance');
        Route::get('tools-maintenances-export-detail/{id}', 'ToolsMaintenanceController@printMaintenance')->name('tools-maintenances.exportPdf');
    });

    // Vehicles Management Fix
    Route::group(['prefix' => 'vehicles'], function () {
        Route::resource('types', 'VehicleTypeController');
        Route::resource('vehicles', 'VehiclesController');
        Route::post('assign/{id}', 'VehiclesController@assign')->name('vehicles.assign');
        Route::resource('reimbursements', 'VehicleReimbursementController');
        Route::patch('reimbursements/approved/{id}', 'VehicleReimbursementController@approved')->name('reimbursements.approved');
        Route::patch('reimbursements/rejected/{id}', 'VehicleReimbursementController@rejected')->name('reimbursements.rejected');
        Route::get('export-excel', 'VehicleReimbursementController@exportExcel')->name('vehicles-reimbursements.exportExcel');
        Route::resource('vehicles-maintenances', 'VehicleMaintenanceController');
        Route::patch('vehicles-maintenances/completed/{id}', 'VehicleMaintenanceController@completeMaintenance')->name('vehicles-maintenances.completeMaintenance');
        Route::patch('vehicles-maintenances/cenceled/{id}', 'VehicleMaintenanceController@cancelMaintenance')->name('vehicles-maintenances.cancelMaintenance');
        Route::get('vehicles-maintenances-export-detail/{id}', 'VehicleMaintenanceController@printMaintenance')->name('vehicles-maintenances.exportPdf');
        Route::resource('insurances', 'VehicleInsuranceController');
        Route::get('insurances-export-detail/{id}', 'VehicleInsuranceController@exportPdf')->name('insurances.exportPdf');
    });

    // Incomming Inventory Plan Fix
    Route::group(['prefix' => 'incomings-plan'], function () {
        Route::resource('incomings-supplier', 'IncomingSupplierController');
        Route::resource('incomings-inventory', 'IncomingInventoryController');
        Route::get('incomings-inventory-export-detail/{id}', 'IncomingInventoryController@printPdf')->name('incomings-inventory.exportPdf');
    });

    // Bids Management Development
    Route::group(['prefix' => 'bids'], function () {
        Route::resource('bids-analysis', 'CostBidsAnalysisController');
        Route::get('bids-analysis-export-detail/{id}', 'CostBidsAnalysisController@exportPdf')->name('bids-analysis.exportPdf');
    });

    // Settings Management development
    Route::group(['prefix' => 'settings'], function () {
        Route::resource('companies', 'CompanyController');
        Route::resource('branches', 'BranchController');
        Route::resource('departments', 'DepartmentController');
        Route::resource('warehouses', 'WarehouseController');
        Route::resource('employees', 'EmployeController');
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
        Route::patch('assignPermissions', 'RolesController@assignPermissions')->name('assign-roles-permissions');
        Route::resource('permissions', 'PermissionsController');
    });

    // Dev Try SAP
    Route::group(['prefix' => 'sap'], function () {

        // Business Partner
        Route::group(['namespace' => 'BussinesPartner', 'prefix' => 'business-partner'], function () {
            Route::resource('bussines-master', 'BussinesMasterController');
        });
    });

    // Profile Fix
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // About 
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
