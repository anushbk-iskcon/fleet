<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverInfoLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverInfoLogController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $driver = $request->driver_sr;
            $logDate = null;
            $filterDate = $request->date_sr;
            if (isset($filterDate))
                $logDate = date('Y-m-d', strtotime($filterDate));
            $category = $request->log_categ_sr;

            // Query to get results
            $driverLogs = DB::table('driver_info_log')->join('drivers', 'driver_info_log.DRIVER', '=', 'drivers.DRIVER_ID')
                ->select('driver_info_log.*', 'drivers.DRIVER_NAME AS DRIVER_NAME')
                ->when($driver, function ($query, $driver) {
                    return $query->where('driver_info_log.DRIVER', '=', $driver);
                })
                ->when($logDate, function ($query, $logDate) {
                    return $query->where('driver_info_log.DATE', '=', $logDate);
                })
                ->when($category, function ($query, $category) {
                    return $query->where('driver_info_log.CATEGORY', '=', $category);
                })
                ->get();

            // Return in JSON format
            $driverLogData = $driverLogs->toJson();
            return $driverLogData;
        } else {
            // Return listing of all driver logs
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
            return view('employee.info-log', compact('drivers'));
        }
    }

    // Store log Details in DB
    public function store(Request $request)
    {
        $driverLog = new DriverInfoLog;
        $driverLog->DRIVER = $request->driver;
        $driverLog->DATE = date('Y-m-d', strtotime($request->log_date));
        $driverLog->CATEGORY = $request->log_category;
        $driverLog->REMARKS = $request->remarks;
        $driverLog->CREATED_BY = Auth::id();

        $added = $driverLog->save();
        if ($added)
            return response()->json(['successCode' => 1, 'message' => 'Added successfully']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to add log']);
    }

    // Get details of specific log
    public function getDetails(Request $request)
    {
    }

    // Update Driver Log Details in DB
    public function update(Request $request)
    {
    }
}
