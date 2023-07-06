<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\RTACircleOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RTACircleOfficeController extends Controller
{
    // Screen listing all RTA offices
    public function index()
    {
        $rtaOffices = RTACircleOffice::all();
        return view('system-settings.rta-details', compact('rtaOffices'));
    }

    // Function to store newly created RTA office in DB
    public function store(Request $request)
    {
        $RTAOffice = new RTACircleOffice;
        $RTAOffice->RTA_CIRCLE_OFFICE_NAME = $request->office_location;
        $RTAOffice->IS_ACTIVE = 'Y';
        $RTAOffice->CREATED_BY = Auth::id();
        $created = $RTAOffice->save();

        if ($created) {
            return response()->json([
                'successCode' => 1,
                'message' => 'RTA Circle Office added successfully',
                'data' => $RTAOffice
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => 'Could not add new RTA office'
            ]);
        }
    }

    // Edit RTA Circle Office Name
    public function update(Request $request)
    {
        $rtaOfficeId = $request->rta_circle_office_id;
        $RTAOffice = RTACircleOffice::find($rtaOfficeId);
        $RTAOffice->RTA_CIRCLE_OFFICE_NAME = $request->new_rta_circle_office_name;
        $RTAOffice->MODIFIED_BY = Auth::id();
        $updated = $RTAOffice->save();

        if ($updated) {
            return response()->json([
                'successCode' => 1,
                'message' => 'Updated successfully',
                'data' => $RTAOffice
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => 'Could not update'
            ]);
        }
    }

    // Activate/De-activate RTA Circle Office
    public function statusUpdate(Request $request)
    {
        $rtaOfficeId = $request->rta_circle_office_id;
        $RTAOffice = RTACircleOffice::find($rtaOfficeId);
        if ($RTAOffice->IS_ACTIVE == 'Y')
            $RTAOffice->IS_ACTIVE = 'N';
        else
            $RTAOffice->IS_ACTIVE =  'Y';

        $RTAOffice->MODIFIED_BY = Auth::id();
        $RTAOffice->save();
        return response($RTAOffice, 200);
    }
}
