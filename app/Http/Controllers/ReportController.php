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
    public function generatePDF(Request $request)
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
            $currentMonth = date('m');
            $nextMonth = $currentMonth + 1;

            $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;
            $endDate = date('Y-') . $nextMonth . '-01';

            $displayMonthShortName = date('M');
            $displayMonthFullName = date('F');
            $displayYear = date('Y');
        } else if (!isset($debitNoteYear) && isset($debitNoteMonth)) {
            $zeroPaddedMonth = $debitNoteMonth < 10 ? '0' . $debitNoteMonth : $debitNoteMonth;
            $nextMonth = ($debitNoteMonth + 1) < 10 ? '0' . ($debitNoteMonth + 1) : ($debitNoteMonth + 1);
            $startDate = date('Y') . '-' . $zeroPaddedMonth . '-01';
            $endDate = date('Y') . '-' . $nextMonth . '-01';

            $displayMonthShortName = date('M', strtotime($startDate));
            $displayMonthFullName = date('F', strtotime($startDate));
            $displayYear = date('Y');
        } else if (!isset($debitNoteMonth) && isset($debitNoteYear)) {
            if ($debitNoteYear == date('Y')) { // For the current year, show current month
                $startDate = date('Y-m-01');
                $currentMonth = date('m');
                $nextMonth = $currentMonth + 1;

                $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;
                $endDate = date('Y-') . $nextMonth . '-01';

                $displayMonthShortName = date('M');
                $displayMonthFullName = date('F');
                $displayYear = date('Y');
            } else {
                $startDate = $debitNoteYear . '-01-01';
                $endDate = $debitNoteYear . '-02-01';

                $displayMonthShortName = date('M', strtotime($startDate));
                $displayMonthFullName = date('F', strtotime($startDate));
                $displayYear = $debitNoteYear;
            }
        } else {
            // Both year and month are set
            $nextMonth = $debitNoteMonth + 1;
            $nextMonth = $nextMonth < 10 ? 0 . $nextMonth : $nextMonth;
            $currentMonth = $debitNoteMonth < 10 ? 0 . $debitNoteMonth : $debitNoteMonth;
            $startDate = $debitNoteYear . '-' . $currentMonth . '-01';
            $endDate = $debitNoteYear . '-' . $nextMonth . '-01';

            $displayMonthShortName = date('M', strtotime($startDate));
            $displayMonthFullName = date('F', strtotime($startDate));
            $displayYear = $debitNoteYear;
        }

        $currentDate = date('Y-m-d');

        // QUERY To get the total gas charges
        $gasCharges = DB::table('refuel_setting')
            ->join('vehicles', 'refuel_setting.VEHICLE', '=', 'vehicles.VEHICLE_ID')
            // ->selectRaw('SUM(refuel_setting.TOTAL_AMOUNT)')
            ->where('vehicles.DEPARTMENT_ID', $entityCode)
            ->where('refuel_setting.FUEL_TYPE', '=', 5) //5 - Fuel Type ID for LPG
            # Should CNG also be included?
            ->whereBetween('refuel_setting.REFUELED_DATE', [$startDate, $endDate])
            ->sum('refuel_setting.TOTAL_AMOUNT');

        $gasCharges = number_format((float)$gasCharges, 2, '.', '');
        // Add line item to gas charges if not zero
        if (intval($gasCharges) != 0) {
            $lineItems[] = [$slNo, 'Gas', 'Kg', '', '', $gasCharges];
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
            ->where('other_transaction.TRANSACTION_TYPE', 5)  # Transaction type 5 for Drivers' Tour Batas Expenses
            ->whereBetween('other_transaction.BILL_DATE', [$startDate, $endDate])
            ->sum('other_transaction.BILL_AMOUNT');
        $driversTourBataAmt = number_format((float)$driverTourBata, 2, '.', '');

        if (intval($driversTourBataAmt) != 0) {
            $lineItems[] = [$slNo, 'Driver\'s Tour Bata', 'Rs', '', '', $driversTourBataAmt];
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
            ->pluck('DRIVER_ID')->toArray();

        // Query for Drivers Salary calculation
        $driverSalary = DB::table('drivers')->whereIn('drivers.DRIVER_ID', $driversArray)->selectRaw('SUM(drivers.CTC/12) as total_salary')->first();
        $totalDriversSalary = number_format((float)$driverSalary->total_salary, 2, '.', '');

        // Query for Drivers' OT calculation for the Same Department
        $totalDriversOT = DB::table('driver_transaction')->whereIn('driver_transaction.DRIVER_ID', $driversArray)
            ->where('driver_transaction.DEVOTEE_DEPARTMENT_CODE', $entityCode)
            ->sum('driver_transaction.AMOUNT');

        $totalDriverSalaryPlusOT = floatval($totalDriversSalary) + floatval($totalDriversOT);
        $totalDriverSalaryPlusOT = number_format((float)$totalDriverSalaryPlusOT, 2, '.', '');
        if (intval($totalDriverSalaryPlusOT) != 0) {
            $lineItems[] = [$slNo, 'Driver salary & OT', 'Rs', '', '', $totalDriverSalaryPlusOT];
            $slNo++;
        }

        // dd($totalDriverSalaryPlusOT);

        // Query for Drivers OT calculation debited to other departments
        $otherDeptOT = DB::table('driver_transaction')->whereIn('driver_transaction.DRIVER_ID', $driversArray)
            ->where('driver_transaction.DEVOTEE_DEPARTMENT_CODE', '<>', $entityCode)
            ->sum('driver_transaction.AMOUNT');

        $otherDeptOT = number_format((float)$otherDeptOT, 2, '.', '');
        if (intval($otherDeptOT) != 0) {
            $lineItems[] = [$slNo, 'Other Dept drivers\' OT', 'Rs', '', '', $otherDeptOT];
            $slNo++;
        }

        $grandTotal = floatval($gasCharges) + floatval($petrolCost) + floatval($dieselCost) + floatval($maintenanceCost) +
            floatval($totalHireCharges) + floatval($driversTourBataAmt) + floatval($miscCharges) + floatval($totalDriverSalaryPlusOT) +
            floatval($otherDeptOT);

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
        // return view('pdf.template',compact('data'));
        $pdf = PDF::loadView('pdf.template', $data);
        $pdf->setOptions([
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);
        return $pdf->stream('Vahan_Debit_Note_' . $entityCode . '_' . $currentDate . '.pdf');

        // return $pdf->download('sample.pdf');
    }
}
