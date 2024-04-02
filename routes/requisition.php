<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\InsuranceController;
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
use App\Http\Controllers\VehicleReqController;
use App\Http\Controllers\ReportController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('vehicle-requisitions', [VehicleReqController::class, 'index'])->name('vehicle-requisitions');
    Route::post('add-requisition', [VehicleReqController::class, 'addRequisition'])->name('add_requisition');
    Route::post('add-driver', [VehicleReqController::class, 'addDriver'])->name('add_driver');
    Route::post('update-status', [VehicleReqController::class, 'updateStatus'])->name('update_status');
    Route::post('edit-requisition', [VehicleReqController::class, 'editRequisition'])->name('edit_requisition');
    Route::get('get-data', [VehicleReqController::class, 'getData'])->name('get.req.data');
    Route::get('get-vehicle-list', [VehicleReqController::class, 'getVehicleData'])->name('get.vehicle.data');
    Route::get('get-edit-vehicle-list', [VehicleReqController::class, 'getEditVehicleData'])->name('get.editvehicle.data');

    // ///////////Approval List///////////

    Route::get('vehicle-requisition/approval-authorities', [VehicleReqController::class, 'approvalAuthorities'])
        ->name('vehicle-req-approval-auth');
    // Get list of all maintenance appoval authorities
    Route::post('vehicle-requisition/approval-authorities', [VehicleReqController::class, 'approvalAuthorities'])
        ->name('vehicle-req-approval-auth.list');
    // Load Employee Names to Approval Authority Form
    Route::post('vehicle-requisition/approval-authorities/get-employees', [VehicleReqController::class, 'getEmployeeData'])
        ->name('vehicle-req-approval-auth.get-employees');
    // Add Maintenance Approval Authority to DB
    Route::post('vehicle-requisition/approval-authorities/add', [VehicleReqController::class, 'addApprovalAuthority'])
        ->name('vehicle-req-approval-auth.add');
    // Update Maintenance Approval Authority details in DB
    Route::post('vehicle-requisition/approval-authorities/update', [VehicleReqController::class, 'updateApprovalAuthority'])
        ->name('vehicle-req-approval-auth.update');
    // Activate/de-activate Maintenance approval Authority
    Route::post('vehicle-requisition/approval-authorities/change-activation', [VehicleReqController::class, 'changeActivationOfApprovalAuthority'])
        ->name('vehicle-req-approval-auth.change-activation');

    // /////////////////////Debit Notes Report//////////////
    Route::get('reports/debit-notes', [ReportController::class, 'debitNote'])->name('debit.note');
    Route::post('reports/generate-pdf', [ReportController::class, 'generatePDF'])->name('generate.pdf');

    // /////////////Salary/////////////////////
    Route::get('manage-salary', [SalaryController::class, 'index'])->name('manage-salary');
});
