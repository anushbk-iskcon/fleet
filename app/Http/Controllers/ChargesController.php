<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargesController extends Controller
{
    //
    /**
     * Return page listing all FC/Road Tax/Permit records in case of GET request,
     * In case of POST Request, return filtered data
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Filter/list out FC, Road Tax, Permit data
            $chargeType = $request->filter_charge_type;
            $filterVehicle = $request->filter_vehicle;
            $filterDateFrom = $request->filter_date_from;
            $filterDateTill = $request->filter_date_till;
            $dateFrom = null;
            $dateTill = null;

            # To convert date times to required format as in DB (YYYY-MM-DD)
            if (isset($filterDateFrom))
                $dateFrom = date('Y-m-d', strtotime($filterDateFrom));
            if (isset($filterDateTill))
                $dateTill = date('Y-m-d', strtotime($filterDateTill));

            $chargesList = DB::table('charges')
                ->join('vehicles', 'charges.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
                ->select(
                    'charges.CHARGE_ID',
                    'charges.CHARGE_TYPE',
                    'charges.CHALLAN_NUMBER',
                    'charges.START_DATE',
                    'charges.EXPIRE_DATE',
                    'charges.AMOUNT',
                    'vehicles.VEHICLE_NAME',
                    'vehicles.LICENSE_PLATE'
                )
                ->when($chargeType, function ($query, $chargeType) {
                    return $query->where('charges.CHARGE_TYPE', $chargeType);
                })
                ->when($filterVehicle, function ($query, $filterVehicle) {
                    return $query->where('charges.VEHICLE_ID', $filterVehicle);
                })
                ->when($dateFrom, function ($query, $dateFrom) {
                    return $query->where('charges.START_DATE', $dateFrom);
                })
                ->when($dateTill, function ($query, $dateTill) {
                    return $query->where('charges.EXPIRE_DATE', $dateTill);
                })
                ->get();

            return $chargesList->toJson();
        }

        $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get(['VEHICLE_ID', 'VEHICLE_NAME', 'LICENSE_PLATE']);
        $vehicleTypes = VehicleType::where('IS_ACTIVE', 'Y')->get(['VEHICLE_TYPE_ID', 'VEHICLE_TYPE_NAME']);
        return view('charges.index', compact('vehicles', 'vehicleTypes'));
    }

    /**
     * Get a list of vehicles filterd by vehicle type for use in add/edit forms
     */
    public function getFilteredVehicles(Request $request)
    {
        $vehicleType = $request->vehicle_type;
        $vehicleList = Vehicle::where('VEHICLE_TYPE_ID', $vehicleType)->where('IS_ACTIVE', 'Y')->get();
        return $vehicleList->toJson();
    }

    /**
     * Add a new Charge Record to DB
     */
    public function addCharge(Request $request)
    {
        $charge = new Charge;
        $charge->CHARGE_TYPE = $request->charge_type;
        $charge->VEHICLE_TYPE_ID = $request->vehicle_type;
        $charge->VEHICLE_ID = $request->vehicle;
        $charge->CHALLAN_NUMBER = $request->challan_number;
        $charge->START_DATE = date('Y-m-d', strtotime($request->start_date));
        $charge->EXPIRE_DATE = date('Y-m-d', strtotime($request->expiry_date));
        $charge->AMOUNT = $request->amount;
        $charge->CREATED_BY = Auth::id();
        $added = $charge->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add data']);
        }
    }

    /**
     * Get details of Specified Charges Record
     */
    public function getDetails(Request $req)
    {
        $chargeId = $req->charge_id;
        $charge = Charge::find($chargeId);
        return $charge->toJson();
    }

    /**
     * Update Charge Details
     */
    public function updateCharge(Request $request)
    {
        $chargeId = $request->charge_id;
        $charge = Charge::find($chargeId);

        $charge->CHARGE_TYPE = $request->charge_type;
        $charge->VEHICLE_TYPE_ID = $request->vehicle_type;
        $charge->VEHICLE_ID = $request->vehicle;
        $charge->CHALLAN_NUMBER = $request->challan_number;
        $charge->START_DATE = date('Y-m-d', strtotime($request->start_date));
        $charge->EXPIRE_DATE = date('Y-m-d', strtotime($request->expiry_date));
        $charge->AMOUNT = $request->amount;
        $charge->MODIFIED_BY = Auth::id();
        $updated = $charge->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not update data']);
        }
    }
}
