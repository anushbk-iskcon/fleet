<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

use function PHPUnit\Framework\returnSelf;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $drivers = Driver::all();
        $licenseTypes = DB::select('select * from mstr_license where IS_ACTIVE = ?', ['Y']);
        return view('employee.manage-drivers', compact('drivers', 'licenseTypes'));
    }

    public function getData(Request $request)
    {
        $drivers = DB::table('drivers')->get();
        return $drivers->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Add New Driver Details
        $driver = new Driver;
        $driver->DRIVER_NAME = $request->driver_name;
        $driver->MOBILE_NUMBER = $request->mobile;
        $driver->LICENSE_NUMBER = $request->license_number;
        $driver->LICENSE_TYPE = $request->license_type;
        $driver->NATIONAL_ID = $request->national_id;
        $driver->LICENSE_ISSUE_DATE = $request->license_issue_date;
        $driver->WORKING_TIME_START = $request->timeslot_start ?? "";
        $driver->WORKING_TIME_END = $request->timeslot_end ?? "";
        $driver->JOIN_DATE = $request->join_date;
        $driver->DATE_OF_BIRTH = $request->dob ?? null;
        $driver->CTC = $request->ctc ?? 0;
        $driver->OVT = $request->ovt ?? 0;
        if ($request->permanent_address) {
            $driver->PERMANENT_ADDRESS = $request->permanent_address;
        }
        if ($request->present_address) {
            $driver->PRESENT_ADDRESS = $request->present_address;
        }
        if ($request->leavestatus) {
            $driver->LEAVE_STATUS = ($request->leavestatus == 1 ? 'Y' : 'N');
        } else {
            $driver->LEAVE_STATUS = 'N';
        }
        if ($request->is_active) {
            $driver->IS_ACTIVE = ($request->is_active == 1 ? 'Y' : 'N');
        }

        //To upload profile image
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $img = time() . '-' . date('Y') . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/profile/drivers/');
            $image->move($destinationPath, $img);
            $driver->PROFILE_PHOTO = $img;
        }

        $driver->CREATED_BY = Auth::id();

        $newDriverAdded = $driver->save();
        if ($newDriverAdded) {
            return "Driver added successfully";
        } else {
            return "Failed to add driver";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $driver = Driver::find($id);
        $driver->DRIVER_NAME = $request->driver_name;
        $driver->MOBILE_NUMBER = $request->mobile;
        $driver->LICENSE_NUMBER = $request->license_number;
        $driver->LICENSE_TYPE = $request->license_type;
        $driver->NATIONAL_ID = $request->national_id;
        $driver->LICENSE_ISSUE_DATE = $request->license_issue_date;
        $driver->WORKING_TIME_START = $request->timeslot_start ?? "";
        $driver->WORKING_TIME_END = $request->timeslot_end ?? "";
        $driver->JOIN_DATE = $request->join_date;
        $driver->CTC = $request->ctc ?? 0;
        $driver->OVT = $request->ovt ?? 0;

        if ($request->dob) $driver->DATE_OF_BIRTH = $request->dob;
        if ($request->permanent_address) $driver->PERMANENT_ADDRESS = $request->permanent_address;
        if ($request->present_address) $driver->PRESENT_ADDRESS = $request->present_address;
        if ($request->leavestatus) {
            $driver->LEAVE_STATUS = ($request->leavestatus == 1 ? 'Y' : 'N');
        } else {
            $driver->LEAVE_STATUS = 'N';
        }
        if ($request->is_active) {
            $driver->IS_ACTIVE = ($request->is_active == 1 ? 'Y' : 'N');
        } else {
            $driver->IS_ACTIVE = 'N';
        }

        // To update profile photo
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $img = time() . '-' . date('Y') . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/upload/profile/drivers/');
            $image->move($destinationPath, $img);
            $driver->PROFILE_PHOTO = $img;
        }

        $driver->MODIFIED_BY = Auth::id();
        $updated = $driver->save();
        if ($updated) {
            return "Driver details successfully updated";
        } else {
            return "Could not update driver details";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show page to display and capture Overtime and other transaction details
     */
    public function transactionsPage()
    {
        $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
        return view('employee.manage-transactions', compact('drivers'));
    }

    /**
     * Store overtime or other transaction details in DB 
     */
    public function storeTransactionDetails(Request $request)
    {
        $transaction = new stdClass;

        $saved = '';
        if ($saved)
            return response()->json(['successCode' => 1, 'message' => 'Details successfully saved']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to save details']);
    }

    public function updateTransactionDetails(Request $request)
    {
        $updated = '';
        if ($updated)
            return response()->json(['successCode' => 1, 'message' => 'Details successfully saved']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to save details']);
    }

    /**
     * Deactivate the Specified Driver
     */
    public function deactivateDriver(Request $request)
    {
        $driver_id = $request->driver_id;
        $driver = Driver::find($driver_id);
        $driver->IS_ACTIVE = 'N';
        $driver->MODIFIED_BY = Auth::id();
        $deactivated = $driver->save();
        if ($deactivated) {
            return "Driver successfully deactivated";
        } else {
            return "Could not deactivate driver";
        }
    }

    /**
     * Activate / Re-activate the Specified Driver
     */
    public function activateDriver(Request $request)
    {
        $driver_id = $request->driver_id;
        $driver = Driver::find($driver_id);
        $driver->IS_ACTIVE = 'Y';
        $driver->MODIFIED_BY = Auth::id();
        $activated = $driver->save();
        if ($activated) {
            return "Driver successfully activated";
        } else {
            return "Could not activate driver";
        }
    }
}
