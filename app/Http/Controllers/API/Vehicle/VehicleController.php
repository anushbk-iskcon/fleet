<?php

namespace App\Http\Controllers\API\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{
    //
    public function getDetails(Request $request)
    {
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
                $data[] = [
                    'VEHICLE_TYPE' => 'CAR',
                    'VEHICLE_NUMBER' => $request->vehicle_number,
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
