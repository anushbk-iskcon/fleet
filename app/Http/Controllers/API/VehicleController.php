<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{
    //

    public function __construct()
    {
        $this->accessKey = '176!#kc@nHKvkbngFiVnsg@523';
    }
    public function getDetails(Request $request)
    {
        if (!($request->accessKey == $this->accessKey)) {
            $this->apiResponse['successCode'] = -1;
            $this->apiResponse['message'] = 'Invalid Access Key';
            $this->apiResponse['data'] = [];
            return response()->json($this->apiResponse);
        }
        try {
            $validator = \Validator::make($request->all(), [
                'vehicle_number' => 'required',
            ]);

            if ($validator->fails()) {
                $this->apiResponse['successCode'] = 0;
                $this->apiResponse['message'] = getErrors($validator);
                return response()->json($this->apiResponse);
            }

            $data = [];
            $checkvehicle = Vehicle::where('LICENSE_PLATE', 'LIKE', '%' . $request->vehicle_number)->first();
            if ($checkvehicle) {
                // TO DO: Add vehicle type if needed after checking and comparing against master table
                $data[] = [
                    'VEHICLE_TYPE' => 'CAR',
                    'VEHICLE_NUMBER' => strlen($request->vehicle_number) > 4 ? substr($request->vehicle_number, -4) : $request->vehicle_number,
                    'FULL_VEHICLE_NUMBER' => $checkvehicle->LICENSE_PLATE
                ];
                $this->apiResponse['successCode'] = 1;
                $this->apiResponse['message'] = 'Successful';
                $this->apiResponse['data'] = $data;

                return response()->json($this->apiResponse);
            } else {
                $this->apiResponse['successCode'] = 0;
                $this->apiResponse['message'] = 'Vehicle is Inactive';
                $this->apiResponse['data'] = $data;
                return response()->json($this->apiResponse);
            }
        } catch (\Exception $e) {
            $this->apiResponse['successCode'] = 0;
            $this->apiResponse['message'] = 'Error! Please Try Again';
            $this->apiResponse['data'] = [];

            return response()->json($this->apiResponse);
        }
    }
}
