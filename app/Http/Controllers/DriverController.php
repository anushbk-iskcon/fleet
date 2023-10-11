<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverTransaction;
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
        // $driver->NATIONAL_ID = $request->national_id ?? "";
        $driver->LICENSE_ISSUE_DATE = date('Y-m-d', strtotime($request->license_issue_date));
        $driver->WORKING_TIME_START = $request->timeslot_start ?? "";
        $driver->WORKING_TIME_END = $request->timeslot_end ?? "";
        $driver->JOIN_DATE = date('Y-m-d', strtotime($request->join_date));
        if ($request->dob)
            $driver->DATE_OF_BIRTH = date('Y-m-d', strtotime($request->dob));
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

        // Additional details
        $driver->DISTANCE_FROM_TEMPLE = $request->distance_from_temple ?? 0;
        $driver->MODE_OF_TRAVEL = $request->mode_of_travel ?? "";

        // Emergency Contact Details
        $driver->EMERGENCY_CONTACT_NAME = $request->emergency_contact ?? "";
        $driver->EMERGENCY_CONTACT_NUMBER = $request->emergency_contact_num ?? "";
        $driver->EMERGENCY_CONTACT_REL = $request->emergency_contact_rel ?? "";

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

        $driver->LICENSE_ISSUE_DATE = date('Y-m-d', strtotime($request->license_issue_date));
        $driver->WORKING_TIME_START = $request->timeslot_start ?? "";
        $driver->WORKING_TIME_END = $request->timeslot_end ?? "";
        $driver->JOIN_DATE = date('Y-m-d', strtotime($request->join_date));
        $driver->CTC = $request->ctc ?? 0;
        $driver->OVT = $request->ovt ?? 0;

        if ($request->dob) $driver->DATE_OF_BIRTH = date('Y-m-d', strtotime($request->dob));
        if ($request->permanent_address) $driver->PERMANENT_ADDRESS = $request->permanent_address;
        if ($request->present_address) $driver->PRESENT_ADDRESS = $request->present_address;
        if ($request->leavestatus) {
            $driver->LEAVE_STATUS = ($request->leavestatus == 1 ? 'Y' : 'N');
        }

        // Additional details
        $driver->DISTANCE_FROM_TEMPLE = $request->distance_from_temple ?? 0;
        $driver->MODE_OF_TRAVEL = $request->mode_of_travel ?? "";

        // Emergency Contact Details
        $driver->EMERGENCY_CONTACT_NAME = $request->emergency_contact ?? "";
        $driver->EMERGENCY_CONTACT_NUMBER = $request->emergency_contact_num ?? "";
        $driver->EMERGENCY_CONTACT_REL = $request->emergency_contact_rel ?? "";

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
    public function transactions(Request $request)
    {
        if (request()->isMethod('post')) {
            // Return list of all or filtered transactions
            $driver = $request->driver_sr;
            $transactionDate = null;
            if ($request->date_sr)
                $transactionDate = date('Y-m-d', strtotime($request->date_sr));
            $purpose = $request->purpose_sr;

            $transactionList = DB::table('driver_transaction')
                ->join('drivers', 'driver_transaction.DRIVER_ID', '=', 'drivers.DRIVER_ID')
                ->select('driver_transaction.*', 'drivers.DRIVER_NAME')
                ->when($driver, function ($query, $driver) {
                    return $query->where('driver_transaction.DRIVER_ID', '=', $driver);
                })
                ->when($transactionDate, function ($query, $transactionDate) {
                    return $query->where('driver_transaction.TRANSACTION_DATE', '=', $transactionDate);
                })
                ->when($purpose, function ($query, $purpose) {
                    return $query->where('driver_transaction.PURPOSE', '=', $purpose);
                })
                ->get();

            return $transactionList->toJson();
        } else {
            // Return the page
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
            return view('employee.manage-transactions', compact('drivers'));
        }
    }

    /** */

    /**
     * Store overtime or other transaction details in DB 
     */
    public function storeTransactionDetails(Request $request)
    {
        $transaction = new DriverTransaction;

        $transaction->TRANSACTION_DATE = date('Y-m-d', strtotime($request->transaction_date));
        $transaction->PURPOSE = $request->purpose;
        $transaction->DRIVER_ID = $request->driver;
        $transaction->DURATION = $request->duration ?? "";
        $transaction->AMOUNT = $request->amount;

        $transaction->CREATED_BY = Auth::id();

        $saved = $transaction->save();
        if ($saved)
            return response()->json(['successCode' => 1, 'message' => 'Details successfully saved']);
        else
            return response()->json(['successCode' => 0, 'message' => 'Failed to save details']);
    }

    /**
     * Get details of specified transaction
     */
    public function getDetails(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $transaction = DriverTransaction::find($transaction_id);
        return $transaction->toJson();
    }

    /**
     * Update transaction details in DB
     */
    public function updateTransactionDetails(Request $request)
    {
        $transaction_id = $request->transaction_id;
        $transaction = DriverTransaction::find($transaction_id);

        $transaction->TRANSACTION_DATE = date('Y-m-d', strtotime($request->transaction_date));
        $transaction->PURPOSE = $request->purpose;
        $transaction->DRIVER_ID = $request->driver;
        $transaction->DURATION = $request->duration ?? "";
        $transaction->AMOUNT = $request->amount;

        $transaction->MODIFIED_BY = Auth::id();

        $updated = $transaction->save();
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
