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
    public function generatePDF()
    {
        $data = [
            'title' => 'Debit Report',
            'entityName' => 'National Institute of Value Education',
            'entityCode' => 'CE 00',
            'items' => [
                [1, 'Gas', 'Kg', '', 68.58, 0],
                [2, 'Petrol', 'Ltr', '', 102.18, 0],
                [3, 'Diesel', 'Ltr', 200.53, 87.88, 17623],
                [4, 'Lubricants', 'Rs', '', '', ''],
                [5, 'Vehicle Maint. Expense', 'Rs', '', '', ''],
                [6, 'Hire Charges', 'Rs', '', '', ''],
                [7, 'Drivers\' Tour Bata', 'Rs', '', '', ''],
                [8, 'Misc  Expense', 'Rs', '', '', ''],
                [9, 'Driver Salary & OT', 'Rs', '', 21281, 21281],
                [10, 'Other Dept drivers\' OT', 'Rs', 0, 160, 0],
            ],
            'amountDebitable' => 38904
        ];
        // return view('pdf.template',compact('data'));
        $pdf = PDF::loadView('pdf.template', $data);
        $pdf->setOptions([
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);
        return $pdf->stream('Debit_Note_.pdf');

        // return $pdf->download('sample.pdf');
    }
}
