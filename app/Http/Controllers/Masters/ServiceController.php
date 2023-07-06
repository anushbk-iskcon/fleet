<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    //
    /**
     * Listing of all current vehicle services
     */
    public function index()
    {
        $services = Service::all();
        return view('system-settings.service-types', compact('services'));
    }

    /**
     * Add new Vehicle Service Type to DB Table
     */
    public function store(Request $request)
    {
        $service = new Service;
        $service->SERVICE_NAME = $request->service_type_name;
        $service->CREATED_BY = Auth::user()->USER_ID;
        $added = $service->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $service]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add new service']);
        }
    }

    /**
     * Update Servicing Type Name in DB
     */
    public function update(Request $request)
    {
        $service_id = $request->service_id;
        $service = Service::find($service_id);
        $service->SERVICE_NAME = $request->service_type_name;
        $service->MODIFIED_BY = Auth::user()->USER_ID;
        $changed = $service->save();

        if ($changed) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $service]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
        }
    }

    /**
     * Activate/de-activate Service Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $service_id = $request->service_id;
        $service = Service::find($service_id);

        if ($service->IS_ACTIVE == 'Y')
            $service->IS_ACTIVE = 'N';
        else
            $service->IS_ACTIVE = 'Y';

        $service->MODIFIED_BY = Auth::user()->USER_ID;
        $service->save();

        return response($service, 200);
    }
}
