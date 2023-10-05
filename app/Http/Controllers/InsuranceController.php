<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\RecurringPeriod;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class InsuranceController extends Controller
{
    //
    /**
     * Return page listing all insurance details
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
            $vehicle = $request->vehiclesr;
            $insuranceCompany = $request->insurance_company;
            $policyNumber = $request->policy_numbersr;
            $dateFrom = $request->date_fr;
            $dateTo = $request->date_to;
            $startDate = null;
            $endDate = null;
            # To convert Date from 01-Jan-2023 format to 2023-01-01 format
            if ($dateFrom) $startDate = date('Y-m-d', strtotime($dateFrom));
            if ($dateTo) $endDate = date('Y-m-d', strtotime($dateTo));

            $insuranceList = DB::table('vehicle_insurance')
                ->join('vehicles', 'vehicle_insurance.VEHICLE', '=', 'vehicles.VEHICLE_ID')
                ->join('mstr_recurring_periods', 'vehicle_insurance.RECURRING_PERIOD', '=', 'mstr_recurring_periods.RECURRING_PERIOD_ID')
                ->select('vehicle_insurance.*', 'vehicles.VEHICLE_NAME', 'mstr_recurring_periods.RECURRING_PERIOD_NAME')
                ->when($vehicle, function ($query, $vehicle) {
                    return $query->where('vehicle_insurance.VEHICLE', '=', $vehicle);
                })
                ->when($insuranceCompany, function ($query, $insuranceCompany) {
                    return $query->where('vehicle_insurance.COMPANY_NAME', '=', $insuranceCompany);
                })
                ->when($policyNumber, function ($query, $policyNumber) {
                    return $query->where('vehicle_insurance.POLICY_NUMBER', '=', $policyNumber);
                })
                ->when($startDate, function ($query, $startDate) {
                    return $query->where('vehicle_insurance.START_DATE', '>=', $startDate);
                })
                ->when($endDate, function ($query, $endDate) {
                    return $query->where('vehicle_insurance.END_DATE', '<=', $endDate);
                })
                ->get();

            return $insuranceList->toJson();
        } else {
            $vehicles = Vehicle::select('VEHICLE_ID', 'VEHICLE_NAME')->where('IS_ACTIVE', 'Y')->get();
            $recurringPeriods = RecurringPeriod::select('RECURRING_PERIOD_ID', 'RECURRING_PERIOD_NAME')->where('IS_ACTIVE', 'Y')->get();
            return view('vehicle.insurance-list', compact('vehicles', 'recurringPeriods'));
        }
    }

    /**
     * Add Insurance Details to DB
     */
    public function store(Request $request)
    {
        $insurance = new Insurance;
        $insurance->COMPANY_NAME = $request->company_name;
        $insurance->VEHICLE = $request->vehicle;
        $insurance->POLICY_NUMBER = $request->policy_number;
        $insurance->CHARGE_PAYABLE = $request->charge_payable;
        $insurance->START_DATE = date('Y-m-d', strtotime($request->start_date));
        $insurance->END_DATE = date('Y-m-d', strtotime($request->end_date));
        $insurance->RECURRING_PERIOD = $request->recurring_period;
        if (isset($request->recurring_date))
            $insurance->RECURRING_DATE = date('Y-m-d', strtotime($request->recurring_date));
        $insurance->RECURRING_PERIOD_REMINDER = $request->add_reminder == 1 ? 'Y' : 'N';
        $insurance->STATUS = $request->status == 1 ? 'Y' : 'N';
        $insurance->REMARKS = $request->remarks ?? null;
        $insurance->DEDUCTIBLE = $request->deductible;

        // To upload insurance policy document
        if ($request->hasFile('policy_document')) {
            $file = $request->file('policy_document');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/insurance/');
            $file->move($uploadDestination, $fileName);
            $insurance->POLICY_DOCUMENT = $fileName;
        }

        $insurance->CREATED_BY = Auth::user()->USER_ID;
        $added = $insurance->save();
        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add insurance details']);
        }
    }

    /**
     * Get details of the selected insurance
     */
    public function getDetails(Request $request)
    {
        $insurance_id = $request->insurance_id;

        $insurance = Insurance::find($insurance_id);
        return $insurance->toJSON();
    }

    /**
     * Update Insurance Details in DB
     */
    public function update(Request $request)
    {
        $ins_id = $request->insurance_id;
        // Update details after fetching the correct model

        $insurance = Insurance::find($ins_id);
        $insurance->COMPANY_NAME = $request->company_name;
        $insurance->VEHICLE = $request->vehicle;
        $insurance->POLICY_NUMBER = $request->policy_number;
        $insurance->CHARGE_PAYABLE = $request->charge_payable;
        $insurance->START_DATE = $request->start_date;
        $insurance->END_DATE = $request->end_date;
        $insurance->RECURRING_PERIOD = $request->recurring_period;

        if ($request->has('recurring_date'))
            $insurance->RECURRING_DATE = $request->recurring_date;

        $insurance->RECURRING_PERIOD_REMINDER = $request->add_reminder == 1 ? 'Y' : 'N';
        $insurance->STATUS = $request->status == 1 ? 'Y' : 'N';

        if ($request->has('remarks'))
            $insurance->REMARKS = $request->remarks;
        $insurance->DEDUCTIBLE = $request->deductible;

        // To upload insurance policy document if new document is attached
        if ($request->hasFile('policy_document')) {
            $file = $request->file('policy_document');
            $fileName = time() . '-' . date('Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/insurance/');
            $file->move($uploadDestination, $fileName);
            $insurance->POLICY_DOCUMENT = $fileName;
        }

        $updated = $insurance->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not update insurance details']);
        }
    }
}
