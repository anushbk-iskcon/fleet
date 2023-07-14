<?php

namespace App\Http\Controllers;

use App\Models\RefuelRequisition;
use App\Models\Fuel;
use App\Models\FuelStation;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RefuelRequisitionController extends Controller
{
    //
    /**
     * Return page listing all refueling requests
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $fuelTypes = Fuel::all();
        $fuelStations = FuelStation::all();
        return view('refueling.refuel-requisitions', compact('fuelTypes', 'fuelStations', 'vehicles'));
    }

    /**
     * Return JSON Response listing all or filtered Requisitions, for drawing/re-drawing table
     */
    public function reqList(Request $request)
    {
        // Filters if applied

        // Data filtered if any of the values above are present
        $reqList = RefuelRequisition::all();
        return $reqList->toJson();
    }

    /**
     * Add new refueling requisition to DB
     */
    public function store(Request $request)
    {
        $refuelRequest = new RefuelRequisition;
        $refuelRequest->VEHICLE_ID = $request->vehicle_name;
        $refuelRequest->FUEL_TYPE = $request->fuel_type;
        $refuelRequest->QUANTITY = $request->qty;
        $refuelRequest->CURRENT_ODOMETER = $request->current_odometer;
        $refuelRequest->FUEL_STATION = $request->fuel_station;
        $refuelRequest->STATUS = 'P';
        $refuelRequest->CREATED_BY = Auth::id();
        $added = $refuelRequest->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Refuel requisition added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add requisition']);
        }
    }

    /**
     * Update Refuel Requisition Details in DB
     */
    public function update(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        $refuelRequest->VEHICLE_ID = $request->vehicle_name;
        $refuelRequest->FUEL_TYPE = $request->fuel_type;
        $refuelRequest->QUANTITY = $request->qty;
        $refuelRequest->CURRENT_ODOMETER = $request->current_odometer;
        $refuelRequest->FUEL_STATION = $request->fuel_station;
        $refuelRequest->MODIFIED_BY = Auth::id();
        $modified = $refuelRequest->save();

        if ($modified) {
            return response()->json(['successCode' => 1, 'message' => 'Changes successfully saved']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to make changes']);
        }
    }

    /**
     * Activate / Deactivate Refuel Requisition
     */
    public function changeActivationStatus(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        if ($refuelRequest->IS_ACTIVE === 'Y')
            $refuelRequest->IS_ACTIVE = 'N';
        else
            $refuelRequest->IS_ACTIVE = 'Y';

        $refuelRequest->MODIFIED_BY = Auth::id();
        $refuelRequest->save();
        return response($refuelRequest, 200);
    }

    /**
     * Change status (pending/approved)
     */
    public function changeStatus(Request $request)
    {
        $refuel_req_id = $request->refuel_req_id;
        $refuelRequest = RefuelRequisition::find($refuel_req_id);
        $requisition_status = $request->requisition_status;
        if ($requisition_status == 'P') // Pending
            $refuelRequest->STATUS = 'P';
        else if ($requisition_status == 'R') // Released
            $refuelRequest->STATUS = 'R';
        else                                 // Default
            $refuelRequest->STATUS = 'P';

        $refuelRequest->MODIFIED_BY = Auth::id();
        $refuelRequest->save();
        return response($refuelRequest, 200);
    }
}
