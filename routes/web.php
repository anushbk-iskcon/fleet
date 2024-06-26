<?php

use App\Http\Controllers\ChargesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverInfoLogController;
use App\Http\Controllers\FuelRateLogController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\LegalDocumentsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaintenanceRequisitionController;
use App\Http\Controllers\MaintenanceServiceController;
use App\Http\Controllers\Masters\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Masters\DepartmentController;
use App\Http\Controllers\Masters\DocumentTypeController;
use App\Http\Controllers\Masters\FuelController;
use App\Http\Controllers\Masters\FuelStationController;
use App\Http\Controllers\Masters\LicenseTypeController;
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
use App\Http\Controllers\RefuelSettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VehicleComplaintsController;
use App\Models\Role;
use App\Models\Vehicle;
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

include('requisition.php');

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
    Route::post('drivers/get-data', [DriverController::class, 'getData']);
    Route::post('get-driver-details', [DriverController::class, 'getDriverDetails']);

    Route::get('drivers/transactions', [DriverController::class, 'transactions'])->name('manage-transactions'); # OverTime page
    Route::post('drivers/transactions/list', [DriverController::class, 'transactions'])->name('driver-transaction.list');
    Route::post('drivers/transactions/add', [DriverController::class, 'storeTransactionDetails'])->name('driver-transaction.add');
    Route::post('drivers/transactions/details', [DriverController::class, 'getTransactionDetails'])->name('driver-transaction.details');
    Route::post('drivers/transactions/update', [DriverController::class, 'updateTransactionDetails'])->name('driver-transaction.update');
    Route::post('drivers/transactions/get-ot-rate', [DriverController::class, 'getOverTimeRate'])->name('driver-transaction.get-driver-ot');

    Route::get('drivers/information-log', [DriverInfoLogController::class, 'index'])->name('driver-info-log');
    Route::post('drivers/information-log/list', [DriverInfoLogController::class, 'index'])->name('driver-info-log.list');
    Route::post('drivers/information-log/add', [DriverInfoLogController::class, 'store'])->name('driver-info-log.add');
    Route::post('drivers/information-log/details', [DriverInfoLogController::class, 'getDetails'])->name('driver-info-log.details');
    Route::post('drivers/information-log/update', [DriverInfoLogController::class, 'update'])->name('driver-info-log.update');

    Route::resource('drivers', DriverController::class)->except(['destroy']);

    Route::get('manage-licenses', [LicenseTypeController::class, 'index'])->name('manage-licenses');
    Route::post('licenses/add', [LicenseTypeController::class, 'store'])->name('add-license-type');
    Route::post('licenses/update', [LicenseTypeController::class, 'update'])->name('update-license-type');
    Route::post('licenses/change-active-status', [LicenseTypeController::class, 'activationStatusChange'])->name('license.change-active-status');

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
    // Get all vehicles / filtered list of vehicles:
    Route::post('vehicle-details', [VehicleController::class, 'getAllVehicleDetails']);
    // Update vehicle details
    Route::post('vehicles/update/{vehicle}', [VehicleController::class, 'update'])->name('vehicle.update');
    // Activate/de-activate vehicle
    Route::post('vehicles/status-update', [VehicleController::class, 'statusUpdate'])->name('vehicle.status-update');
    // Assign driver a vehicle
    Route::post('vehicles/assign-to-driver', [VehicleController::class, 'assignVehicleToDriver'])->name('vehicle.assign-to-driver');
    // Get employees based on selected department
    Route::post('vehicles/get-employees', [VehicleController::class, 'getEmployees'])->name('vehicle.get-employees');
    // Allocate Vehicle to Employee / Division Head / Manager / Lead / SPOC etc.
    Route::post('vehicles/allocate', [VehicleController::class, 'allocateVehicle'])->name('vehicle.allocate');

    Route::get('vehicles/insurance', [InsuranceController::class, 'index'])->name('insurance-list');
    Route::post('vehicles/insurance', [InsuranceController::class, 'index'])->name('insurance-list.list');
    Route::post('vehicles/insurance/add', [InsuranceController::class, 'store'])->name('insurance.add');
    Route::post('insurance/details', [InsuranceController::class, 'getDetails'])->name('insurance.details');
    Route::post('vehicles/insurance/update', [InsuranceController::class, 'update'])->name('insurance.update');

    Route::get('vehicles/legal-documents', [LegalDocumentsController::class, 'index'])->name('legal-documents');
    Route::post('vehicles/legal-documents', [LegalDocumentsController::class, 'index'])->name('legal-documents.list');
    Route::post('vehicles/legal-documents/add', [LegalDocumentsController::class, 'store'])->name('legal-documents.add');
    Route::post('vehicles/legal-documents/details', [LegalDocumentsController::class, 'getDetails'])->name('legal-documents.details');
    Route::post('vehicles/legal-documents/update', [LegalDocumentsController::class, 'update'])->name('legal-documents.update');
    Route::post('vehicles/legal-documents/change-activation', [LegalDocumentsController::class, 'changeActivationStatus'])->name('legal-documents.change-activation');

    Route::get('vehicles/reminders', function () {
        return view('vehicle.reminder-list');
    })->name('vehicle-reminders');
    /*** END Vehicle Management Routes ***/

    /*** START Vehicle Requisition Routes ***/
    Route::get('vehicle-requisition/routes', function () {
        return view('vehicle-req.vehicle-routes');
    })->name('vehicle-routes');

    // Route::get('vehicle-requisition/approval-authorities', function () {
    //     return view('vehicle-req.approval-authorities');
    // })->name('vehicle-req-approval-auth');

    Route::get('vehicle-requistion/pick-drop', function () {
        return view('vehicle-req.pick-drop-requisition');
    })->name('pick-drop-requisition');
    /*** END Vehicle Requisition Routes ***/

    /*** START Maintenance Routes ***/
    // Return listing of all maintenance requisitions
    Route::get('maintenance/requisitions', [MaintenanceRequisitionController::class, 'index'])->name('maintenance-requisitions');
    // Get list of maintenance requisitions for populating table:
    Route::post('maintenance/requisitions', [MaintenanceRequisitionController::class, 'index'])->name('maintenance-requisitions.list');
    // Return form (page) to create new requisition:
    Route::get('maintenance/requisitions/create', [MaintenanceRequisitionController::class, 'create'])->name('add-maintenance-list');
    // Add new requisition to DB:
    Route::post('maintenance/requisitions/create', [MaintenanceRequisitionController::class, 'store'])->name('maintenance-requisitions.add');
    // Show form/page to allow updating maintenance requisition details:
    Route::get('maintenance/requisitions/{requisition}/edit', [MaintenanceRequisitionController::class, 'edit'])
        ->name('maintenance-requisitions.edit');
    // Update maintenance requisition details in DB:
    Route::post('maintenance/requisitions/update', [MaintenanceRequisitionController::class, 'update'])
        ->name('maintenance-requisitions.update');

    // Get details of specified Maintenance Requisition
    Route::post('maintenance/requisitions/get-details', [MaintenanceRequisitionController::class, 'getDetails'])
        ->name('maintenance-requisitions.get-details');

    // Activate / De-activate specified requisition in DB
    Route::post('maintenance/requisitions/change-activation', [MaintenanceRequisitionController::class, 'changeActivationStatus'])
        ->name('maintenance-requisitions.change-activation-status');

    // Approve/Reject Maintenance Requisition
    Route::post('maintenance/requisitions/change-activation', [MaintenanceRequisitionController::class, 'approvalStatusUpdate'])
        ->name('maintenance-requisitions.change-approval-status');

    // Show page listing all maintenance approval authorities
    Route::get('maintenance/approval-authorities', [MaintenanceRequisitionController::class, 'approvalAuthorities'])
        ->name('maintenance-approval-authorities');

    // Get list of all maintenance appoval authorities
    Route::post('maintenance/approval-authorities', [MaintenanceRequisitionController::class, 'approvalAuthorities'])
        ->name('maintenance-approval-authorities.list');

    // Load Employee Names to Approval Authority Form
    Route::post('maintenance/approval-authorities/get-employees', [MaintenanceRequisitionController::class, 'getEmployeeData'])
        ->name('maintenance-approval-authorities.get-employees');

    // Add Maintenance Approval Authority to DB
    Route::post('maintenance/approval-authorities/add', [MaintenanceRequisitionController::class, 'addApprovalAuthority'])
        ->name('maintenance-approval-authorities.add');

    // Update Maintenance Approval Authority details in DB
    Route::post('maintenance/approval-authorities/update', [MaintenanceRequisitionController::class, 'updateApprovalAuthority'])
        ->name('maintenance-approval-authorities.update');

    // Activate/de-activate Maintenance approval Authority
    Route::post('maintenance/approval-authorities/change-activation', [MaintenanceRequisitionController::class, 'changeActivationOfApprovalAuthority'])
        ->name('maintenance-approval-authorities.change-activation');

    // Maintenance Complaints Routes
    Route::get('maintenance/complaints', [VehicleComplaintsController::class, 'index'])->name('complaints.index');
    Route::post('maintenance/complaints', [VehicleComplaintsController::class, 'index'])->name('complaints.list');
    Route::post('maintenance/complaints/get-filtered-vehicles', [VehicleComplaintsController::class, 'getFilteredVehicles'])->name('complaints.vehicle-list');
    Route::post('maintenance/complaints/add', [VehicleComplaintsController::class, 'add'])->name('complaints.add');
    Route::post('maintenance/complaints/get-details', [VehicleComplaintsController::class, 'getDetails'])->name('complaints.get-details');
    Route::post('maintenance/complaints/view-details', [VehicleComplaintsController::class, 'getDetailsToView'])->name('complaints.view-details');
    Route::post('maintenance/complaints/update', [VehicleComplaintsController::class, 'update'])->name('complaints.update');
    Route::post('maintenance/complaints/update-approval', [VehicleComplaintsController::class, 'updateApprovalStatus'])->name('complaints.update-approval');
    Route::post('maintenance/complaints/update-completion', [VehicleComplaintsController::class, 'updateCompletionStatus'])->name('complaints.close-complaint');

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
    // Refuel Setting sub-module routes
    Route::get('refuel-setting', [RefuelSettingController::class, 'index'])->name('refuel-setting');
    Route::post('refuel-setting', [RefuelSettingController::class, 'index'])->name('refuel-setting.list');
    Route::post('refuel-setting/add', [RefuelSettingController::class, 'store'])->name('refuel-setting.add');
    Route::post('refuel-setting/edit', [RefuelSettingController::class, 'edit'])->name('refuel-setting.edit'); // Show Edit Form
    Route::post('refuel-setting/update', [RefuelSettingController::class, 'update'])->name('refuel-setting.update'); // update details in DB
    Route::post('refuel-setting/change-activation', [RefuelSettingController::class, 'activationStatusChange'])->name('refuel-setting.change-activation');

    // Fuel Station sub-module Routes
    Route::get('refueling/fuel-stations', [FuelStationController::class, 'index'])->name('fuel-stations');
    Route::post('refueling/fuel-stations/all', [FuelStationController::class, 'list'])->name('fuel-stations.list');
    Route::post('refueling/fuel-stations/add', [FuelStationController::class, 'store'])->name('fuel-stations.add');
    Route::post('refueling/fuel-stations/update', [FuelStationController::class, 'update'])->name('fuel-stations.update');
    Route::post('refueling/fuel-stations/update-status', [FuelStationController::class, 'statusUpdate'])->name('fuel-stations.update-status');
    Route::post('refueling/fuel-stations/get-details', [FuelStationController::class, 'getDetails'])->name('fuel-stations.get-details');

    // fuel Rate Log Sub-module routes
    Route::get('refueling/fuel-rate-log', [FuelRateLogController::class, 'index'])->name('fuel-rate-log');
    Route::post('refueling/fuel-rate-log', [FuelRateLogController::class, 'index'])->name('fuel-rate-log.list');
    Route::post('refueling/fuel-rate-log/add', [FuelRateLogController::class, 'add'])->name('fuel-rate-log.add');
    Route::post('refueling/fuel-rate-log/update', [FuelRateLogController::class, 'update'])->name('fuel-rate-log.update');
    Route::post('refueling/fuel-rate-log/change-activation', [FuelRateLogController::class, 'updateActivation'])->name('fuel-rate-log.change-activation');
    Route::post('refueling/fuel-rate-log/get-details', [FuelRateLogController::class, 'getDetails'])->name('fuel-rate-log.get-details');

    // Refueling Requisitions sub-module Routes
    Route::get('refueling/requisitions', [RefuelRequisitionController::class, 'index'])->name('refuel-requisitions');
    Route::post('refueling/requisitions/list', [RefuelRequisitionController::class, 'list'])->name('refuel-requisitions.list');
    Route::post('refueling/requisitions/add', [RefuelRequisitionController::class, 'store'])->name('refuel-requisitions.add');
    Route::post('refueling/requisitions/update', [RefuelRequisitionController::class, 'update'])->name('refuel-requisitions.update');
    Route::post('refueling/requisitions/change-activation', [RefuelRequisitionController::class, 'changeActivationStatus'])->name('refuel-requisitions.change-activation');
    Route::post('refueling/requisitions/change-status', [RefuelRequisitionController::class, 'changeStatus'])->name('refuel-requisitions.change-status');
    Route::post('refueling/requisitions/get-details', [RefuelRequisitionController::class, 'getDetails'])->name('refuel-requisitions.get-details');

    // Refuel Requisition Approval Authorities Routes
    Route::get('refueling/approval-authorities', [RefuelRequisitionController::class, 'approvalAuthorities'])->name('refuel-approval-authorities');
    Route::post('refueling/approval-authorities', [RefuelRequisitionController::class, 'approvalAuthorities'])
        ->name('refuel-approval-authorities.list');
    Route::post('refueling/approval-authorities/add', [RefuelRequisitionController::class, 'addApprovalAuthority'])
        ->name('refuel-approval-authorities.add');
    Route::post('refueling/approval-authorities/update', [RefuelRequisitionController::class, 'updateApprovalAuthority'])
        ->name('refuel-approval-authorities.update');
    Route::post('refueling/approval-authorities/change-activation', [RefuelRequisitionController::class, 'changeActivationOfApprovalAuthority'])
        ->name('refuel-approval-authorities.change-activation');
    /*** END Refueling Module ***/

    /*** START Transaction Module ***/
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('transactions', [TransactionController::class, 'index'])->name('transactions.list');
    Route::post('transactions/add', [TransactionController::class, 'addTransaction'])->name('transactions.add');
    Route::post('transactions/get-details', [TransactionController::class, 'getDetails'])->name('transactions.get-details');
    Route::post('transactions/update', [TransactionController::class, 'updateTransaction'])->name('transactions.update');
    Route::post('transactions/filtered-vehicles', [TransactionController::class, 'getfilteredVehicleList'])->name('transactions.filtered-vehicles');
    /*** END Transaction Module ***/

    /*** START: Charges (FC, Road Tax, Permit) Module ***/
    Route::get('charges', [ChargesController::class, 'index'])->name('charges.index');
    Route::post('charges', [ChargesController::class, 'index'])->name('charges.list');
    Route::post('charges/details', [ChargesController::class, 'getDetails'])->name('charges.details');
    Route::post('charges/add', [ChargesController::class, 'addCharge'])->name('charges.add');
    Route::post('charges/update', [ChargesController::class, 'updateCharge'])->name('charges.update');
    Route::post('charges/filtered-vehicles', [ChargesController::class, 'getFilteredVehicles'])->name('charges.get-filtered-vehicles');
    /*** END: Charges (FC, Road Tax, Permit) Module ***/

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
    Route::get('settings/insurance-companies', [CompanyController::class, 'index'])->name('manage-companies');
    Route::post('settings/insurance-companies/add', [CompanyController::class, 'store'])->name('manage-companies.add');
    Route::post('settings/insurance-companies/update', [CompanyController::class, 'update'])->name('manage-companies.update');
    Route::post('settings/insurance-companies/update-status', [CompanyController::class, 'statusUpdate'])->name('manage-companies.update-status');

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
