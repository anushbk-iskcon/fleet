<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    // Screen listing all vendors
    public function index()
    {
        $vendors = Vendor::all();
        return view('system-settings.manage-vendors', compact('vendors'));
    }

    // Add new vendor to DB
    public function store(Request $request)
    {
        $vendor = new Vendor;
        $vendor->VENDOR_NAME = $request->vendor_name;
        $vendor->IS_ACTIVE = 'Y';
        $vendor->CREATED_BY = Auth::user()->USER_ID;
        $added = $vendor->save();

        if ($added) {
            return response()->json([
                'successCode' => 1,
                'message' => "Vendor added successfully",
                'data' => $vendor
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => "Could not add vendor"
            ]);
        }
    }

    // Modify vendor name in DB
    public function update(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $vendor = Vendor::find($vendor_id);
        $vendor->VENDOR_NAME = $request->new_vendor_name;
        $vendor->MODIFIED_BY = Auth::user()->USER_ID;
        $modified = $vendor->save();

        if ($modified) {
            return response()->json([
                'successCode' => 1,
                'message' => "Successfully updated",
                'data' => $vendor
            ]);
        } else {
            return response()->json([
                'successCode' => 0,
                'message' => "Failed to update vendor"
            ]);
        }
    }

    // Activate/ de-activate vendor in DB
    public function statusUpdate(Request $request)
    {
        $vendorId = $request->vendor_id;
        $vendor = Vendor::find($vendorId);

        if ($vendor->IS_ACTIVE == 'Y')
            $vendor->IS_ACTIVE = 'N';
        else
            $vendor->IS_ACTIVE = 'Y';

        $vendor->MODIFIED_BY = Auth::user()->USER_ID;
        $vendor->save();

        return response($vendor, 200);
    }
}
