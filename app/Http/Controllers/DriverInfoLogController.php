<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

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

            // Return in JSON format
        } else {
            // Return listing of all driver logs
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
            return view('employee.info-log', compact('drivers'));
        }
    }

    // Store log Details in DB
    public function store(Request $request)
    {
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
