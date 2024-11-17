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

Route::get('send-mail', [MailController::class, 'index']);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Users Management
    Route::resource('users', 'UsersController')->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::post('users/exportPdf', 'UsersController@exportPDF')->name('users.exportPdf');
    Route::post('users/exportExcel', 'UsersController@exportExcel')->name('users.exportExcel');
    Route::post('users/importUsers', 'UsersController@importUsers')->name('users.importUsers');

    // Roles Management
    Route::resource('roles', 'RolesController')->only('index', 'create', 'store', 'edit', 'update', 'destroy');
    Route::post('roles/assignPermissions', 'RolesController@assignPermissions')->name('roles.assignPermissions');

    // Permissions Management
    Route::resource('permissions', 'PermissionsController');

    // Vehicles
    Route::group(['prefix' => 'vehicles'], function () {
        // Vehicles Management
        Route::resource('vehicles', 'VehiclesController');
        // Vehicle Type Management
        Route::resource('types', 'VehicleTypeController');
        // Vehicle Ownership Management
        Route::resource('ownerships', 'VehicleOwnershipController');
        // Vehicle Maintenance Management
        Route::resource('maintenances', 'VehicleMaintenanceController');
        // Vehicle Insurance Management
        Route::resource('insurances', 'VehicleInsuranceController');
    });

    // Tools
    Route::group(['prefix' => 'tools'], function () {
        // Tools Management
        Route::resource('tools', 'ToolsController');
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
    });

    // Profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // About 
    Route::get('/about', function () {
        return view('about');
    })->name('about');
});
