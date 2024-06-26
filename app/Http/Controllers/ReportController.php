<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Driver;
use App\Models\HrApi;
use App\Models\Ownership;
use App\Models\RTACircleOffice;
use App\Models\Vehicle;
use App\Models\VehicleDivision;
use App\Models\VehicleType;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleRequisition;
use App\Models\RequisitionPurpose;
use App\Models\RequisitionType;
use App\Models\Phase;
use App\Models\ApprovalAuthority;
use DataTables;
use Str;
use App\Models\User;
use Illuminate\Support\Facades\View;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
    }
    public function debitNote(Request $request)
    {
        $hrApi = new HrApi;
        $departments = $hrApi->getDepartments();
        return view('reports.debit-notes', compact('departments'));
    }
    public function getDebitNoteData(Request $request)
    {
        $entityCode = $request->dept_code;
        $entityName = $request->dept_name;
        $debitNoteYear = $request->debit_note_year;
        $debitNoteMonth = $request->debit_note_month;

        $startDate = '';
        $endDate = '';

        $lineItems = [];
        $slNo = 1;

        $displayMonthShortName = '';
        $displayMonthFullName = '';
        $displayYear = '';

        if (!isset($debitNoteYear) && !isset($debitNoteMonth)) {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t'); // t gives no. of days in a month

            $displayMonthShortName = date('M');
            $displayMonthFullName = date('F');
            $displayYear = date('Y');
        } else if (!isset($debitNoteYear) && isset($debitNoteMonth)) {
            $zeroPaddedMonth = $debitNoteMonth < 10 ? '0' . $debitNoteMonth : $debitNoteMonth;
            // $nextMonth = ($debitNoteMonth + 1) < 10 ? '0' . ($debitNoteMonth + 1) : ($debitNoteMonth + 1);
            $startDate = date('Y-' . $zeroPaddedMonth . '-01');
            $endDate = date('Y-m-t', strtotime($startDate));

            $displayMonthShortName = date('M', strtotime($startDate));
            $displayMonthFullName = date('F', strtotime($startDate));
            $displayYear = date('Y');
        } else if (!isset($debitNoteMonth) && isset($debitNoteYear)) {
            if ($debitNoteYear == date('Y')) { // For the current year, show current month
                $startDate = date('Y-m-01');
                $endDate = date('Y-m-t', strtotime($startDate));

                $currentMonth = date('m');
                $displayMonthShortName = date('M');
                $displayMonthFullName = date('F');
                $displayYear = date('Y');
            } else {
                $startDate = $debitNoteYear . '-01-01';
                $endDate = $debitNoteYear . '-01-31';

                $displayMonthShortName = date('M', strtotime($startDate));
                $displayMonthFullName = date('F', strtotime($startDate));
                $displayYear = $debitNoteYear;
            }
        } else {
            // Both year and month are set
            $currentMonth = $debitNoteMonth < 10 ? 0 . $debitNoteMonth : $debitNoteMonth;
            $startDate = $debitNoteYear . '-' . $currentMonth . '-01';
            $endDate = date('Y-m-t', strtotime($startDate));

            $displayMonthShortName = date('M', strtotime($startDate));
            $displayMonthFullName = date('F', strtotime($startDate));
            $displayYear = $debitNoteYear;
        }

        $currentDate = date('Y-m-d');

        // QUERY To get the total gas charges
        $gasChargesRes = DB::table('refuel_setting')
            ->join('vehicles', 'refuel_setting.VEHICLE', '=', 'vehicles.VEHICLE_ID')
            ->selectRaw('SUM(refuel_setting.TOTAL_AMOUNT) as COST, SUM(refuel_setting.UNIT_TAKEN) as QTY')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('refuel_setting.FUEL_TYPE', '=', 5) //5 - Fuel Type ID for LPG
            # Should CNG also be included?
            ->whereBetween('refuel_setting.REFUELED_DATE', [$startDate, $endDate])
            ->first();
        $gasQty = $gasChargesRes->QTY;
        $gasCost = $gasChargesRes->COST;

        $gasQty = number_format((float)$gasQty, 2, '.', '');
        $gasCharges = number_format((float)$gasCost, 2, '.', '');
        // Add line item to gas charges if not zero
        // print_r($gasCharges);
        // exit;
        if (intval($gasCharges) != 0) {
            $lineItems[] = [$slNo, 'Gas', 'Kg', $gasQty, '', $gasCharges];
            $slNo++;
        }

        // QUERY To get total petrol charges
        $petrolCostRes = DB::table('refuel_setting')
            ->join('vehicles', 'refuel_setting.VEHICLE', '=', 'vehicles.VEHICLE_ID')
            ->selectRaw('SUM(refuel_setting.UNIT_TAKEN) as QTY, SUM(refuel_setting.TOTAL_AMOUNT) as COST')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('refuel_setting.FUEL_TYPE', '=', 1) // 1 - Fuel Type ID for Petrol
            ->whereBetween('refuel_setting.REFUELED_DATE', [$startDate, $endDate])
            ->first();

        $petrolQty = $petrolCostRes->QTY;
        $petrolCost = $petrolCostRes->COST;
        $petrolRate = 0;

        if ($petrolQty != 0)
            $petrolRate = $petrolCost / $petrolQty; # Whether to use this average rate value in form
        $petrolQty = number_format((float)$petrolQty, 2, '.', '');
        $petrolCost = number_format((float)$petrolCost, 2, '.', '');

        // Add line item for petrol qty and charges
        if (intval($petrolCost) != 0) {
            $lineItems[] = [$slNo, 'Petrol', 'Ltr', $petrolQty, '', $petrolCost];
            $slNo++;
        }

        // QUERY To get total diesel charges
        $dieselCostRes = DB::table('refuel_setting')
            ->join('vehicles', 'refuel_setting.VEHICLE', '=', 'vehicles.VEHICLE_ID')
            ->selectRaw('SUM(refuel_setting.UNIT_TAKEN) as QTY, SUM(refuel_setting.TOTAL_AMOUNT) as COST')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('refuel_setting.FUEL_TYPE', '=', 2) // 2 - Fuel Type ID for Diesel
            ->whereBetween('refuel_setting.REFUELED_DATE', [$startDate, $endDate])
            ->first();

        $dieselQty = $dieselCostRes->QTY;
        $dieselCost = $dieselCostRes->COST;
        $dieselRate = '';
        $dieselQty = number_format((float)$dieselQty, 2, '.', '');
        $dieselCost = number_format((float)$dieselCost, 2, '.', '');

        if (intval($dieselCost) != 0) {
            $lineItems[] = [$slNo, 'Diesel', 'Ltr', $dieselQty, '', $dieselCost];
            $slNo++;
        }

        // QUERY To get total maintenance charges
        $maintenanceCost = DB::table('maintenance_requisitions')
            ->join('vehicles', 'maintenance_requisitions.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->whereBetween('maintenance_requisitions.SERVICE_DATE', [$startDate, $endDate])
            ->sum('maintenance_requisitions.TOTAL_AMOUNT');

        $maintenanceCost = number_format((float)$maintenanceCost, 2, '.', '');
        // dd($maintenanceCost);
        if (intval($maintenanceCost) != 0) {
            $lineItems[] = [$slNo, 'Vehicle Maint. Expense', 'Rs', '', '', $maintenanceCost];
            $slNo++;
        }

        // QUERY To get Hire Charges Data
        $hireCharges = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 4)  # Transaction type 4 for Hire Charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');

        $totalHireCharges = number_format((float)$hireCharges, 2, '.', '');
        // dd($totalHireCharges);

        if (intval($totalHireCharges) != 0) {
            $lineItems[] = [$slNo, 'Hire Charges', 'Rs', '', '', $totalHireCharges];
            $slNo++;
        }

        // QUERY to get total Drivers Tour Bata
        $driverTourBata = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 5)  # Transaction type 5 for Drivers' Tour Bata Expenses
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');
        $driversTourBataAmt = number_format((float)$driverTourBata, 2, '.', '');

        // Add entry to Debit Note if total amount for the month & dept. is not zero
        if (intval($driversTourBataAmt) != 0) {
            $lineItems[] = [$slNo, 'Driver\'s Tour Bata', 'Rs', '', '', $driversTourBataAmt];
            $slNo++;
        }

        // QUERY to get Puncture Charges
        $punctureChargesData = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 1)  #Transaction type 1 for Puncture Charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');
        $punctureCharges = number_format((float)$punctureChargesData, 2, '.', '');

        if (intval($punctureCharges) != 0) {
            $lineItems[] = [$slNo, 'Puncher Charges', 'Rs', '', '', $punctureCharges];
            $slNo++;
        }

        // QUERY to get parking charges
        $parkingChargesData = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 2)  #Transaction type 2 for Parking Charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');

        $parkingCharges = number_format((float)$parkingChargesData, 2, '.', '');
        if (intval($parkingCharges) != 0) {
            $lineItems[] = [$slNo, 'Parking Charges', 'Rs', '', '', $parkingCharges];
            $slNo++;
        }

        // QUERY to get Total Toll Fee charges
        $tollFeeChargesData = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 3)  #Transaction type 3 for Toll Fee charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');
        $tollFeeCharges = number_format((float)$tollFeeChargesData, 2, '.', '');
        if (intval($tollFeeCharges) != 0) {
            $lineItems[] = [$slNo, 'Toll Fee Charges', 'Rs', '', '', $tollFeeCharges];
            $slNo++;
        }

        // QUERY to get Total Emission Test Charges
        $emissionsChargesData = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 7)  #Transaction type 7 for Emission charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');
        $emissionsCharges = number_format((float)$emissionsChargesData, 2, '.', '');
        if (intval($emissionsCharges) != 0) {
            $lineItems[] = [$slNo, 'Emission Charges', 'Rs', '', '', $emissionsCharges];
            $slNo++;
        }

        // QUERY To get miscellaneous expenses data
        $miscellaneousCostsRes = DB::table('other_transaction')
            ->where('other_transaction.DEBIT_TO_DEPT', $entityCode)
            ->where('other_transaction.TRANSACTION_TYPE', 6)  # Transaction type 6 for Miscellaneous Charges
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');

        $miscCharges = number_format((float)$miscellaneousCostsRes, 2, '.', '');
        if (intval($miscCharges) != 0) {
            $lineItems[] = [$slNo, 'Misc Expenses', 'Rs', '', '', $miscCharges];
            $slNo++;
        }

        // To calculate Drivers Salary and overtime costs
        // Query To select drivers associated with a department
        $driversArray = DB::table('vehicles')
            ->where('DEPARTMENT_ID', $entityCode)
            ->whereNotNull('DRIVER_ID')
            ->pluck('DRIVER_ID')->toArray();

        $driversArray = array_unique($driversArray);
        // In some cases drivers array also has the ID 0, whether to not select this ID

        // Query for Drivers Salary calculation
        $driverSalary = DB::table('drivers')->whereIn('drivers.DRIVER_ID', $driversArray)->selectRaw('SUM(drivers.CTC) as total_salary')->first();
        $totalDriversSalary = number_format((float)$driverSalary->total_salary, 2, '.', '');

        if ($totalDriversSalary != 0) {
            $lineItems[] = [$slNo, 'Drivers\' salary', 'Rs', '', '', $totalDriversSalary];
            $slNo++;
        }

        // Query for Drivers' OT calculation for the Same Department
        $totalDriversOT = DB::table('driver_transaction')->whereIn('driver_transaction.DRIVER_ID', $driversArray)
            ->where('driver_transaction.DEVOTEE_DEPARTMENT_CODE', $entityCode)
            ->whereBetween('driver_transaction.TRANSACTION_DATE', [$startDate, $endDate])
            ->sum('driver_transaction.AMOUNT');

        $totalDriversOT = number_format((float)$totalDriversOT, 2, '.', '');

        $totalDriverSalaryPlusOT = floatval($totalDriversSalary) + floatval($totalDriversOT);
        $totalDriverSalaryPlusOT = number_format((float)$totalDriverSalaryPlusOT, 2, '.', '');
        if (intval($totalDriversOT) != 0) {
            $lineItems[] = [$slNo, 'Drivers\' OT', 'Rs', '', '', $totalDriversOT];
            $slNo++;
        }

        // dd($totalDriverSalaryPlusOT);

        // Query for Drivers OT calculation debited to other departments
        $otherDeptOT = DB::table('driver_transaction')->whereNotIn('driver_transaction.DRIVER_ID', $driversArray)
            ->where('driver_transaction.DEVOTEE_DEPARTMENT_CODE', '=', $entityCode)
            ->whereBetween('driver_transaction.TRANSACTION_DATE', [$startDate, $endDate])
            ->sum('driver_transaction.AMOUNT');

        $otherDeptOT = number_format((float)$otherDeptOT, 2, '.', '');
        if (intval($otherDeptOT) != 0) {
            $lineItems[] = [$slNo, 'Other Dept drivers\' OT', 'Rs', '', '', $otherDeptOT];
            $slNo++;
        }

        // Query for adding Insurance Costs
        $insuranceCostRes = DB::table('vehicle_insurance')->join('vehicles', 'vehicle_insurance.VEHICLE', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('vehicle_insurance.IS_ACTIVE', 'Y')
            ->where(function ($query) use ($startDate, $endDate) { // To generate where conditions within brackets
                $query->whereBetween('vehicle_insurance.START_DATE', [$startDate, $endDate]);
                // ->orWhereBetween('vehicle_insurance.RECURRING_DATE', [$startDate, $endDate]);
            })
            ->selectRaw('SUM(vehicle_insurance.CHARGE_PAYABLE) as INSURANCE_TOTAL_COST')
            ->first();

        // dd($insuranceCostRes);

        $insuranceCost = number_format((float)$insuranceCostRes->INSURANCE_TOTAL_COST, 2, '.', '');

        // dd($insuranceCost);

        if ($insuranceCost != 0) {
            $lineItems[] = [$slNo, 'Insurance', 'Rs', '', '', $insuranceCost];
            $slNo++;
        }

        // Query to get Amount charged for Fitness Certificates
        $fitnessCertChargesAmount = DB::table('charges')->join('vehicles', 'charges.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('charges.CHARGE_TYPE', 1)   # Charge Type = 1 for FC
            ->whereBetween('charges.START_DATE', [$startDate, $endDate])
            ->selectRaw('SUM(charges.AMOUNT) as FC_CHARGES')
            ->first();

        $fcCharges = number_format((float)$fitnessCertChargesAmount->FC_CHARGES, 2, '.', '');

        if (intval($fcCharges) != 0) {
            $lineItems[] = [$slNo, 'FC Charges', 'Rs', '', '', $fcCharges];
            $slNo++;
        }

        // Query to get Amount charged for Road Taxes
        $roadTaxChargesAmount = DB::table('charges')->join('vehicles', 'charges.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('charges.CHARGE_TYPE', 2)   # Charge Type = 2 for Road Tax
            ->whereBetween('charges.START_DATE', [$startDate, $endDate])
            ->selectRaw('SUM(charges.AMOUNT) as RT_CHARGES')
            ->first();

        $roadTaxCharges = number_format((float)$roadTaxChargesAmount->RT_CHARGES, 2, '.', '');

        if ($roadTaxCharges != 0) {
            $lineItems[] = [$slNo, 'Road Tax Charges', 'Rs', '', '', $roadTaxCharges];
            $slNo++;
        }

        // Query to get Amount charged for Permits
        $vehiclePermitChargesAmount = DB::table('charges')->join('vehicles', 'charges.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('charges.CHARGE_TYPE', 3)   # Charge Type = 3 for Permit
            ->whereBetween('charges.START_DATE', [$startDate, $endDate])
            ->selectRaw('SUM(charges.AMOUNT) as PERMIT_CHARGES')
            ->first();

        $permitCharges = number_format((float)$vehiclePermitChargesAmount->PERMIT_CHARGES, 2, '.', '');

        if ($permitCharges != 0) {
            $lineItems[] = [$slNo, 'Permit Charges', 'Rs', '', '', $permitCharges];
            $slNo++;
        }

        // Query to get Requisition Charges for Auto Rickshaw Requisitions
        $autoRickshawReqCosts = DB::table('vehicle_requisition')->join('vehicles', 'vehicle_requisition.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicle_requisition.USER_ENTITY_CODE', $entityCode)
            ->where('vehicle_requisition.VEHICLE_TYPE_ID', 1) # Value for Vehicle Type Auto = 1
            ->where('vehicle_requisition.TOTAL_KM', '>', 0)
            ->whereBetween('REQUISITION_DATE', [$startDate, $endDate])
            ->selectRaw('SUM(vehicle_requisition.TOTAL_KM * vehicles.RATE_PER_KM) as AUTO_REQ_CHARGES')
            ->first();

        $autoReqCharges = number_format((float)$autoRickshawReqCosts->AUTO_REQ_CHARGES, 2, '.', '');

        // Query to Get Requistion Charges for Car Requisitions
        $carReqCosts = DB::table('vehicle_requisition')->join('vehicles', 'vehicle_requisition.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
            ->where('vehicle_requisition.USER_ENTITY_CODE', $entityCode)
            ->whereIn('vehicle_requisition.VEHICLE_TYPE_ID', [2, 3, 4, 5, 8]) # Values for Vehicle Type Car = 2 / 3 / 4 / 5 / 8
            ->where('vehicle_requisition.TOTAL_KM', '>', 0)
            ->whereBetween('REQUISITION_DATE', [$startDate, $endDate])
            ->selectRaw('SUM(vehicle_requisition.TOTAL_KM * vehicles.RATE_PER_KM) as CAR_REQ_CHARGES')
            ->first();

        $carReqCharges = number_format((float)$carReqCosts->CAR_REQ_CHARGES, 2, '.', '');

        // Calculate Total Requistion Costs based on adding the above two values\
        $requisitionCharges = $autoReqCharges + $carReqCharges;

        if ($requisitionCharges > 0) {
            $lineItems[] = [$slNo, 'Vehicle Req. Charges', 'Rs', '', '', $requisitionCharges];
            $slNo++;
        }


        $grandTotal = floatval($gasCharges) + floatval($petrolCost) + floatval($dieselCost) + floatval($maintenanceCost) +
            floatval($totalHireCharges) + floatval($driversTourBataAmt) + floatval($miscCharges) + floatval($totalDriverSalaryPlusOT) +
            floatval($otherDeptOT) + floatval($insuranceCost) + floatval($punctureCharges) + floatval($parkingCharges) +
            floatval($tollFeeCharges) + floatval($emissionsCharges) + floatval($fcCharges) + floatval($roadTaxCharges) +
            floatval($permitCharges) + floatval($requisitionCharges);

        $grandTotal = number_format((float)$grandTotal, 2, '.', '');

        $data = [
            'title' => 'Debit Report',
            'entityName' => $entityName,
            'entityCode' => $entityCode,
            'displayYear' => $displayYear,
            'displayMonthShortName' => $displayMonthShortName,
            'displayMonthFullName' => $displayMonthFullName,
            'items' => [],
            'amountDebitable' => $grandTotal
        ];

        $data['items'] = $lineItems;

        return $data;

        // $pdf = PDF::loadView('pdf.template', $data);
        // $pdf->setOptions([
        //     'margin_top' => 0,
        //     'margin_right' => 0,
        //     'margin_bottom' => 0,
        //     'margin_left' => 0,
        // ]);
        // return $pdf->stream('Vahan_Debit_Note_' . $entityCode . '_' . $currentDate . '.pdf');

        // return $pdf->download('sample.pdf');
    }

    function viewDebitNoteHTML(Request $request)
    {
        $data = $this->getDebitNoteData($request);

        if ($data['amountDebitable'] == 0) {
            $htmlContent = '<div class="info"><i class="fas fa-exclamation-circle"></i> No data found for ' .
                $data['displayMonthFullName'] . ' ' . $data['displayYear'] .
                ' for ' . $data['entityName'] . '</div>';
            return $htmlContent;
        }

        $htmlContent = View::make('reports.debit-note-view', compact('data'))->render();
        return $htmlContent;
    }

    public function generatePDF(Request $request)
    {
        $data = $this->getDebitNoteData($request);

        $currentDate = date('Y-m-d');

        $pdf = PDF::loadView('pdf.template', $data);
        $pdf->setOptions([
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0
        ]);

        return $pdf->stream('Vahan_Debit_Note_' . $request->dept_code . '_' . $currentDate . '.pdf');
    }
}
