<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceServiceController;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\DocumentTypeController;
use App\Http\Controllers\Masters\FuelController;
use App\Http\Controllers\Masters\FuelStationController;
use App\Http\Controllers\Masters\MaintenanceTypeController;
use App\Http\Controllers\Masters\NotificationTypeController;
use App\Http\Controllers\Masters\OwnershipController;
use App\Http\Controllers\Masters\PhaseController;
use App\Http\Controllers\Masters\PriorityController;
use App\Http\Controllers\Masters\RecurringPeriodController;
use App\Http\Controllers\Masters\RequisitionPurposeController;
use App\Http\Controllers\Masters\RequisitionTypeController;
use App\Http\Controllers\Masters\RTACircleOfficeController;
use App\Http\Controllers\Masters\ServiceController;
use App\Http\Controllers\Masters\TripTypeController;
use App\Http\Controllers\Masters\VehicleDivisionController;
use App\Http\Controllers\Masters\VehicleTypeController;
use App\Http\Controllers\Masters\VendorController;
use App\Http\Controllers\RefuelRequisitionController;

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('home', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

/*** START Login and Logout Routes */
Route::get('login', [LoginController::class, 'loginPage'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'doLogin'])->name('loginAction');
Route::post('logout', [LoginController::class, 'logout']);

Route::redirect('/', 'login')->middleware('guest');
/*** END Login and Logout Routes */


Route::middleware('auth')->group(function () {
    /*** START Employee Module Routes ***/
    Route::get('employee', function () {
        return view('employee.employee');
    })->name('employees');

    Route::get('employee/positions', function () {
        return view('employee.position');
    })->name('positions');

    Route::get('employee/manage-positions', function () {
        return view('employee.manage-position');
    })->name('manage-position');

    Route::get('employee/departments', function () {
        return view('employee.department');
    })->name('departments');

    Route::get('employee/manage-departments', function () {
        return view('employee.manage-departments');
    })->name('manage-departments');


    // Driver management routes
    Route::put('deactivate-driver', [DriverController::class, 'deactivateDriver']);
    Route::put('activate-driver', [DriverController::class, 'activateDriver']);

    Route::resource('drivers', DriverController::class)->except(['destroy']);

    Route::get('employee/manage-licenses', function () {
        return view('employee.manage-license');
    })->name('manage-licenses');

    Route::get('driver-performance', function () {
        return view('employee.driver-performance');
    })->name('driver-performance');

    Route::get('manage-request-approvals', function () {
        return view('employee.manage-request-approval');
    })->name('manage-request-approval');

    /*** END Employee Module Routes ***/

    /*** START Vehicle Management Routes ***/
    Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicle.index');
    Route::post('vehicles/add', [VehicleController::class, 'store'])->name('vehicle.add');
    Route::post('vehicles/details', [VehicleController::class, 'getDetails'])->name('vehicle.get-details');
    // Get all vehicles / filtered list of vehicles
    Route::post('vehicle-details', [VehicleController::class, 'getAllVehicleDetails']);
    // Update vehicle details
    Route::post('vehicles/update/{vehicle}', [VehicleController::class, 'update'])->name('vehicle.update');
    // Activate/de-activate vehicle
    Route::post('vehicles/status-update', [VehicleController::class, 'statusUpdate'])->name('vehicle.status-update');

    Route::get('vehicle/insurance', function () {
        return view('vehicle.insurance-list');
    })->name('insurance-list');

    Route::get('vehicle/legal-documents', function () {
        return view('vehicle.legal-docs');
    })->name('legal-documents');

    Route::get('vehicle/reminders', function () {
        return view('vehicle.reminder-list');
    })->name('vehicle-reminders');
    /*** END Vehicle Management Routes ***/

    /*** START Vehicle Requisition Routes ***/
    Route::get('vehicle-requisition', function () {
        return view('vehicle-req.vehicle-requisition');
    })->name('vehicle-requisitions');

    Route::get('vehicle-requisition/routes', function () {
        return view('vehicle-req.vehicle-routes');
    })->name('vehicle-routes');

    Route::get('vehicle-requisition/approval-authorities', function () {
        return view('vehicle-req.approval-authorities');
    })->name('vehicle-req-approval-auth');

    Route::get('vehicle-requistion/pick-drop', function () {
        return view('vehicle-req.pick-drop-requisition');
    })->name('pick-drop-requisition');
    /*** END Vehicle Requisition Routes ***/

    /*** START Maintenance Routes ***/
    Route::get('maintenance/requisitions', function () {
        return view('maintenance.maintenance-requisition');
    })->name('maintenance-requisitions');

    Route::get('maintenance/add', function () {
        return view('maintenance.add-maintenance-list');
    })->name('add-maintenance-list');

    Route::get('maintenance/approval-authorities', function () {
        return view('maintenance.maintenance-approval-authorities');
    })->name('maintenance-approval-authorities');

    // Maintenance Services Master routes
    Route::get('maintenance/service-list', [MaintenanceServiceController::class, 'index'])->name('maintenance-service-list');
    Route::post('maintenance/service-list', [MaintenanceServiceController::class, 'index'])->name('maintenance-service-list.list');
    Route::post('maintenance/service-list/add', [MaintenanceServiceController::class, 'store'])->name('maintenance-service-list.add');
    Route::post('maintenance/service-list/edit', [MaintenanceServiceController::class, 'edit'])->name('maintenance-service-list.edit');
    Route::post('maintenance/service-list/update', [MaintenanceServiceController::class, 'update'])->name('maintenance-service-list.update');
    Route::post('maintenance/service-list/update-status', [MaintenanceServiceController::class, 'activationStatusUpdate'])->name('maintenance-service-list.update-status');
    /*** END Maintenance Routes ***/

    /*** START Cost and Inventory Routes ***/
    Route::get('costs/manage-expense-types', function () {
        return view('cost-inventory.manage-expense-type');
    })->name('manage-expense-types');

    Route::get('costs/add-new-expense', function () {
        return view('cost-inventory.add-new-expense');
    })->name('add-new-expense');

    Route::get('costs/all-expenses', function () {
        return view('cost-inventory.all-expenses-list');
    })->name('all-expenses-list');

    Route::get('inventory/manage-parts', function () {
        return view('cost-inventory.manage-parts');
    })->name('manage-parts');

    Route::get('inventory/categories', function () {
        return view('cost-inventory.inventory-categories');
    })->name('inventory-categories');

    Route::get('inventory/locations', function () {
        return view('cost-inventory.locations');
    })->name('locations');

    Route::get('inventory/manage-stock', function () {
        return view('cost-inventory.manage-stocks');
    })->name('manage-stocks');
    /*** END Cost and Inventory Routes ***/

    /*** START Purchase and Usage Routes ***/
    Route::get('purchases', function () {
        return view('purchase-usage.purchase-details');
    })->name('purchases');
    Route::get('purchases/add', function () {
        return view('purchase-usage.add-purchase');
    })->name('add-purchase');

    Route::get('parts-usage', function () {
        return view('purchase-usage.parts-usages-list');
    })->name('parts-usages-list');

    Route::get('parts-usage/add', function () {
        return view('purchase-usage.add-parts-usage');
    })->name('add-parts-usage');

    /*** END Purchase and Usage Routes ***/


    /*** BEGIN Refueling Module ***/
    Route::get('refuel-setting', function () {
        return view('refueling.refuel-setting');
    })->name('refuel-setting');

    //Fuel Station sub-module Routes
    Route::get('refueling/fuel-stations', [FuelStationController::class, 'index'])->name('fuel-stations');
    Route::post('refueling/fuel-stations/all', [FuelStationController::class, 'list'])->name('fuel-stations.list');
    Route::post('refueling/fuel-stations/add', [FuelStationController::class, 'store'])->name('fuel-stations.add');
    Route::post('refueling/fuel-stations/update', [FuelStationController::class, 'update'])->name('fuel-stations.update');
    Route::post('refueling/fuel-stations/update-status', [FuelStationController::class, 'statusUpdate'])->name('fuel-stations.update-status');
    Route::post('refueling/fuel-stations/get-details', [FuelStationController::class, 'getDetails'])->name('fuel-stations.get-details');

    // Refueling Requisitions sub-module Routes
    Route::get('refueling/requisitions', [RefuelRequisitionController::class, 'index'])->name('refuel-requisitions');
    Route::post('refueling/requisitions/list', [RefuelRequisitionController::class, 'list'])->name('refuel-requisitions.list');
    Route::post('refueling/requisitions/add', [RefuelRequisitionController::class, 'store'])->name('refuel-requisitions.add');
    Route::post('refueling/requisitions/update', [RefuelRequisitionController::class, 'update'])->name('refuel-requisitions.update');
    Route::post('refueling/requisitions/change-activation', [RefuelRequisitionController::class, 'changeActivationStatus'])->name('refuel-requisitions.change-activation');
    Route::post('refueling/requisitions/change-status', [RefuelRequisitionController::class, 'changeStatus'])->name('refuel-requisitions.change-status');
    Route::post('refueling/requisitions/get-details', [RefuelRequisitionController::class, 'getDetails'])->name('refuel-requisitions.get-details');

    Route::get('refueling/approval-authorities', function () {
        return view('refueling.refuel-approval-authorities');
    })->name('refuel-approval-authorities');
    /*** END Refueling Module ***/

    /*** START Reports Module ***/
    Route::get('reports/employees', function () {
        return view('reports.employee-reports');
    })->name('employee-reports');

    Route::get('reports/drivers', function () {
        return view('reports.driver-reports');
    })->name('driver-reports');

    Route::get('reports/vehicles', function () {
        return view('reports.vehicle-reports');
    })->name('vehicle-reports');

    Route::get('reports/vehicle-requisition', function () {
        return view('reports.vehicle-requisition-reports');
    })->name('vehicle-requisition-reports');

    Route::get('reports/renewal-reports', function () {
        return view('reports.renewal-reports');
    })->name('renewal-reports');

    Route::get('reports/pick-drop-requisition', function () {
        return view('reports.pick-drop-requisition-reports');
    })->name('pick-drop-requisition-reports');

    Route::get('reports/refuel-requisition', function () {
        return view('reports.refuel-requisition-reports');
    })->name('refuel-requisition-reports');

    Route::get('reports/purchase-details', function () {
        return view('reports.purchase-details-reports');
    })->name('purchase-details-reports');

    Route::get('reports/expense-details', function () {
        return view('reports.expense-details-reports');
    })->name('expense-details-reports');

    Route::get('reports/maintenance-requisition', function () {
        return view('reports.maintenance-req-reports');
    })->name('maintenance-req-reports');

    /*** END Reports Module ***/

    /*** START System Settings Module ***/
    // Companies Master Data routes
    Route::get('settings/manage-companies', [CompanyController::class, 'index'])->name('manage-companies');
    Route::post('settings/manage-companies/add', [CompanyController::class, 'store'])->name('manage-companies.add');
    Route::post('settings/manage-companies/update', [CompanyController::class, 'update'])->name('manage-companies.update');
    Route::post('settings/manage-companies/update-status', [CompanyController::class, 'statusUpdate'])->name('manage-companies.update-status');

    // Recurring Periods Data routes
    Route::get('settings/recurring-periods', [RecurringPeriodController::class, 'index'])->name('recurring-periods');
    Route::post('settings/recurring-periods/add', [RecurringPeriodController::class, 'store'])->name('recurring-periods.add');
    Route::post('settings/recurring-periods/update', [RecurringPeriodController::class, 'update'])->name('recurring-periods.update');
    Route::post('settings/recurring-periods/update-status', [RecurringPeriodController::class, 'statusUpdate'])->name('recurring-periods.update-status');

    // Notification types/ periods master data routes
    Route::get('settings/notifications', [NotificationTypeController::class, 'index'])->name('notification-settings');
    Route::post('settings/notifications/add', [NotificationTypeController::class, 'store'])->name('notification-settings.add');
    Route::post('settings/notifications/update', [NotificationTypeController::class, 'update'])->name('notification-settings.update');
    Route::post('settings/notifications/update-status', [NotificationTypeController::class, 'statusUpdate'])->name('notification-settings.update-status');

    // Document types master data routes
    Route::get('settings/document-types', [DocumentTypeController::class, 'index'])->name('document-type-settings');
    Route::post('settings/document-types/add', [DocumentTypeController::class, 'store'])->name('document-type-settings.add');
    Route::post('settings/document-types/update', [DocumentTypeController::class, 'update'])->name('document-type-settings.update');
    Route::post('settings/document-types/update-status', [DocumentTypeController::class, 'statusUpdate'])->name('document-type-settings.update-status');


    // Vendors Master Data
    Route::get('settings/vendors', [VendorController::class, 'index'])->name('vendor-settings');
    Route::post('settings/vendors/add', [VendorController::class, 'store'])->name('vendor-settings.add');
    Route::post('settings/vendors/update', [VendorController::class, 'update'])->name('vendor-settings.update');
    Route::post('settings/vendors/update-status', [VendorController::class, 'statusUpdate'])->name('vendor-settings.status-update');

    // Vehicle Types Master data
    Route::get('settings/vehicle-types', [VehicleTypeController::class, 'index'])->name('vehicle-types');
    Route::post('settings/vehicle-types/add', [VehicleTypeController::class, 'store'])->name('vehicle-type.add');
    Route::post('settings/vehicle-types/update', [VehicleTypeController::class, 'update'])->name('vehicle-type.update');
    Route::post('settings/vehicle-types/update-status', [VehicleTypeController::class, 'statusUpdate'])->name('vehicle-type.status-update');

    // Requisition purposes master data
    Route::get('settings/requisition-purpose', [RequisitionPurposeController::class, 'index'])->name('requisition-purposes');
    Route::post('settings/requisition-purpose/add', [RequisitionPurposeController::class, 'store'])->name('requisition-purposes.add');
    Route::post('settings/requisition-purpose/update', [RequisitionPurposeController::class, 'update'])->name('requisition-purposes.update');
    Route::post('settings/requisition-purpose/update-status', [RequisitionPurposeController::class, 'statusUpdate'])->name('requisition-purposes.update-status');

    // Requistion types master data
    Route::get('settings/requisition-type', [RequisitionTypeController::class, 'index'])->name('requisition-types');
    Route::post('settings/requisition-type/add', [RequisitionTypeController::class, 'store'])->name('requisition-types.add');
    Route::post('settings/requisition-type/update', [RequisitionTypeController::class, 'update'])->name('requisition-types.update');
    Route::post('settings/requisition-type/update-status', [RequisitionTypeController::class, 'statusUpdate'])->name('requisition-types.update-status');

    // Requisition Phases Master Data
    Route::get('settings/requisition-phase', [PhaseController::class, 'index'])->name('requisition-phases');
    Route::post('settings/requisition-phase/add', [PhaseController::class, 'store'])->name('requisition-phases.add');
    Route::post('settings/requisition-phase/update', [PhaseController::class, 'update'])->name('requisition-phases.update');
    Route::post('settings/requisition-phase/update-status', [PhaseController::class, 'statusUpdate'])->name('requisition-phases.update-status');

    // Maintenance Types master data
    Route::get('settings/maintenance-types', [MaintenanceTypeController::class, 'index'])->name('maintenance-types');
    Route::post('settings/maintenance-types/add', [MaintenanceTypeController::class, 'store'])->name('maintenance-types.add');
    Route::post('settings/maintenance-types/update', [MaintenanceTypeController::class, 'update'])->name('maintenance-types.update');
    Route::post('settings/maintenance-types/update-status', [MaintenanceTypeController::class, 'statusUpdate'])->name('maintenance-types.update-status');

    // Priorities master data
    Route::get('settings/priority', [PriorityController::class, 'index'])->name('priority');
    Route::post('settings/priority/add', [PriorityController::class, 'store'])->name('priority.add');
    Route::post('settings/priority/update', [PriorityController::class, 'update'])->name('priority.update');
    Route::post('settings/priority/update-status', [PriorityController::class, 'statusUpdate'])->name('priority.update-status');

    // Vehicle Service Types Master Data
    Route::get('settings/service-types', [ServiceController::class, 'index'])->name('service-types');
    Route::post('settings/service-types/add', [ServiceController::class, 'store'])->name('service-types.add');
    Route::post('settings/service-types/update', [ServiceController::class, 'update'])->name('service-types.update');
    Route::post('settings/service-types/update-status', [ServiceController::class, 'statusUpdate'])->name('service-types.update-status');

    // Fuel Types master data
    Route::get('settings/fuel-types', [FuelController::class, 'index'])->name('fuel-types');
    Route::post('settings/fuel-types/add', [FuelController::class, 'store'])->name('fuel-types.add');
    Route::post('settings/fuel-types/update', [FuelController::class, 'update'])->name('fuel-types.update');
    Route::post('settings/fuel-types/update-status', [FuelController::class, 'statusUpdate'])->name('fuel-types.update-status');

    // Trip types master data
    Route::get('settings/trip-types', [TripTypeController::class, 'index'])->name('trip-types');
    Route::post('settings/trip-types/add', [TripTypeController::class, 'store'])->name('trip-types.add');
    Route::post('settings/trip-types/update', [TripTypeController::class, 'update'])->name('trip-types.update');
    Route::post('settings/trip-types/update-status', [TripTypeController::class, 'statusUpdate'])->name('trip-types.update-status');

    // Vehicle divisions master data
    Route::get('settings/divisions', [VehicleDivisionController::class, 'index'])->name('divisions');
    Route::post('settings/divisions/add', [VehicleDivisionController::class, 'store'])->name('divisions.add');
    Route::post('settings/divisions/update', [VehicleDivisionController::class, 'update'])->name('divisions.update');
    Route::post('settings/divisions/update-status', [VehicleDivisionController::class, 'statusUpdate'])->name('divisions.status-update');

    // RTO Details master data
    Route::get('settings/rta-details', [RTACircleOfficeController::class, 'index'])->name('rta-details');
    Route::post('settings/rta-details/add', [RTACircleOfficeController::class, 'store'])->name('rta-details.add');
    Route::post('settings/rta-details/update', [RTACircleOfficeController::class, 'update'])->name('rta-details.update');
    Route::post('settings/rta-details/update-status', [RTACircleOfficeController::class, 'statusUpdate'])->name('rta-details.status-update');

    // Route::get('settings/ownership', function () {
    //     return view('system-settings.ownership');
    // })->name('ownership');

    Route::get('settings/department', [DepartmentController::class, 'index'])->name('department');
    Route::post('settings/department/create', [DepartmentController::class, 'store'])->name('department.store');
    Route::post('settings/department/edit/{department}', [DepartmentController::class, 'update'])->name('department.update');
    Route::post('settings/department/update/{department}', [DepartmentController::class, 'statusUpdate'])->name('department.status');

    Route::get('settings/ownership', [OwnershipController::class, 'index'])->name('ownership');
    Route::post('settings/ownership/create', [OwnershipController::class, 'store'])->name('ownership.store');
    Route::put('settings/ownership/update/{ownership}', [OwnershipController::class, 'update'])->name('ownership.update');
    Route::post('settings/ownership/update/{department}', [OwnershipController::class, 'statusUpdate'])->name('ownership.status');

    /*** END System Settings Module ***/

    /*** START User Module ***/
    Route::put('deactivate-user', [UserController::class, 'deactivateUser']);
    Route::put('activate-user', [UserController::class, 'activateUser']);

    Route::resource('users', UserController::class)->names([
        'create' => 'add-user',
        'index' => 'manage-users',
        'edit' => 'edit-user'
    ]);

    /*** END User Module ***/

    /*** START Roles and Permissions Module ***/
    // Display users and their roles
    Route::get('roles/user-access', [RoleController::class, 'getUserAccessRoles'])->name('roles.user-access-roles');

    // Assign roles to users
    Route::get('roles/assign', [RoleController::class, 'assignRoleToUser'])->name('roles.assign-role-to-user');
    Route::post('roles/assign', [RoleController::class, 'assignRoleToUser'])->name('roles.assign-user-role');

    // Screen to allow Updating Role assigned to a User
    Route::get('roles/edit-user-access/{userid}', [RoleController::class, 'getUserAccessRole'])->name('edit-user-acess-role');
    // Updating Role assigned to User
    Route::post('roles/update-user-access', [RoleController::class, 'updateUserAccessRole']);

    Route::put('deactivate-role', [RoleController::class, 'deactivateRole'])->name('roles.deactivate');
    Route::put('activate-role', [RoleController::class, 'activateRole'])->name('roles.activate');

    Route::resource('roles', RoleController::class);

    /*** END Roles and Permissions Module ***/

    /*** START: Application Settings ***/
    Route::get('dashboard/settings', function () {
        return view('app-settings');
    })->name('application-settings');
    /*** END: Application Settings ***/

    /*** START: Profile View/Edit Pages ***/
    Route::get('profile', [ProfileController::class, 'viewProfile']);
    Route::get('profile/edit', [ProfileController::class, 'editProfile'])->name('edit-profile');
    Route::post('profile', [ProfileController::class, 'updateProfile'])->name('update-profile');
    /*** END: Profile View/Edit Pages ***/
});
