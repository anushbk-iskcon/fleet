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
        return view('reports.debit-notes',compact('departments'));
    }
    public function generatePDF()
    {
        $data = [
            'title' => 'Debit Report'
        ];
        // return view('pdf.template',compact('data'));
        $pdf = PDF::loadView('pdf.template', $data);
        $pdf->setOptions([
            'margin_top' => 0,
            'margin_right' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
        ]);
        return $pdf->stream('document.pdf');

        // return $pdf->download('sample.pdf');
    }
}
