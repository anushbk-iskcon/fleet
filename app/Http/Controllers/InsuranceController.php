<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        } else {
            $vehicles = Vehicle::select('VEHICLE_ID', 'VEHICLE_NAME')->where('IS_ACTIVE', 'Y')->get();
            return view('vehicle.insurance-list', compact('vehicles'));
        }
    }

    /**
     * Add Insurance Details to DB
     */
    public function store(Request $request)
    {
        $insurance = new stdClass;
        $insurance->COMPANY_NAME = $request->company_name;
        $insurance->VEHICLE = $request->vehicle;
        $insurance->POLICY_NUMBER = $request->policy_number;
        $insurance->CHARGE_PAYABLE = $request->charge_payable;
        $insurance->START_DATE = $request->start_date;
        $insurance->END_DATE = $request->end_date;
        $insurance->RECURRING_PERIOD = $request->recurring_period;
        $insurance->RECURRING_DATE = $request->recurring_date;
        $insurance->RECURRING_PERIOD_REMINDER = $request->add_reminder == 1 ? 'Y' : 'N';
        $insurance->STATUS = $request->status == 1 ? 'Y' : 'N';
        $insurance->REMARKS = $request->remarks ?? null;
        $insurance->DEDUCTIBLE = $request->deductible;

        // To upload insurance policy document
        if ($request->hasFile('policy_document')) {
        }

        $insurance->CREATED_BY = Auth::user()->USER_ID;
        $added = '';
        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add insurance details']);
        }
    }

    /**
     * Update Insurance Details in DB
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Activate / Deactivate Insurance Details in DB
     */
    public function activationStatusChange(Request $request)
    {
        $insurance = new stdClass;
        $activation_status = $request->activation_status;

        $insurance->IS_ACTIVE = $activation_status;
        $insurance->MODIFIED_BY = Auth::id();

        // Save changes and return response with message
    }
}
