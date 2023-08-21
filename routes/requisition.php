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
    use App\Models\Role;
    use Illuminate\Support\Facades\Route;

    Route::get('vehicle-requisitions', [VehicleReqController::class, 'index'])->name('vehicle-requisitions');
    Route::post('add-requisition', [VehicleReqController::class, 'addRequisition'])->name('add_requisition');
?>