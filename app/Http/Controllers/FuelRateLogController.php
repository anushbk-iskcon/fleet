<?php

namespace App\Http\Controllers;

use App\Models\Fuel;
use App\Models\FuelRateLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FuelRateLogController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $fuelType = $request->filter_fuel_type;
            $startDate = null;
            $endDate = null;

            $currentFuelRateLog = DB::table('fuel_rate_log')
                ->join('mstr_fuel', 'fuel_rate_log.FUEL_TYPE', '=', 'mstr_fuel.FUEL_ID')
                ->when($fuelType, function ($query, $fuelType) {
                    return $query->where('fuel_rate_log.FUEL_TYPE', '=', $fuelType);
                })
                ->select('fuel_rate_log.*', 'mstr_fuel.FUEL_TYPE_NAME')
                ->orderByDesc('fuel_rate_log.CREATED_ON')
                ->get();

            return $currentFuelRateLog->toJson();
        }
        $fuelTypes = Fuel::where('IS_ACTIVE', 'Y')->get();
        return view('refueling.rate-log', compact('fuelTypes'));
    }

    // Add New Fuel Rate Log to DB
    public function add(Request $request)
    {
        $fuelRateLog = new FuelRateLog;
        $fuelRateLog->FROM_DATE = date('Y-m-d', strtotime($request->date_from));
        if (isset($request->date_to))
            $fuelRateLog->TO_DATE = date('Y-m-d', strtotime($request->date_to));
        $fuelRateLog->FUEL_TYPE = $request->fuel_type;
        $fuelRateLog->FUEL_RATE = $request->fuel_rate;
        $fuelRateLog->CREATED_BY = Auth::id();

        $added = $fuelRateLog->save();

        // To inactivate older entries for the same fuel type once new entry is added
        $rowsAffected = DB::update(
            'update fuel_rate_log SET IS_ACTIVE = "N" where FUEL_TYPE = ? and FROM_DATE < ?',
            [$request->fuel_type, date('Y-m-d', strtotime($request->date_from))]
        );
        if ($added && $rowsAffected) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add fuel rate']);
        }
    }

    // Update fuel Rate Log Details in DB
    public function update(Request $request)
    {
        $fuelRateLogId = $request->log_id;
        $fuelRateLog = FuelRateLog::find($fuelRateLogId);
        $fuelRateLog->FROM_DATE = date('Y-m-d', strtotime($request->date_from));
        if (isset($request->date_to))
            $fuelRateLog->TO_DATE = date('Y-m-d', strtotime($request->date_to));
        $fuelRateLog->FUEL_TYPE = $request->fuel_type;
        $fuelRateLog->FUEL_RATE = $request->fuel_rate;
        $fuelRateLog->CREATED_BY = Auth::id();

        $updated = $fuelRateLog->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update fuel rate']);
        }
    }

    // Get details of Fuel Rate Log
    public function getDetails(Request $request)
    {
        $fuelRateLogId = $request->log_id;
        $fuelRateLog = FuelRateLog::find($fuelRateLogId);
        return $fuelRateLog->toJson();
    }

    // De-activate or Activate Fuel Log
    public function updateActivation(Request $request)
    {
        $fuelRateLogId = $request->log_id;
        $fuelRateLog = FuelRateLog::find($fuelRateLogId);

        $fuelRateLog->IS_ACTIVE = ($fuelRateLog->IS_ACTIVE == 'Y') ? 'N' : 'Y';
        $activationUpdated = $fuelRateLog->save();

        if ($activationUpdated)
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
    }
}
