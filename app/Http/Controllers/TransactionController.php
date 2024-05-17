<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\HrApi;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    //
    /** 
     * Return page listing all transactions in case of GET request,
     * in case of POST, return all data in JSON data for all transactions / transactions filtered by criteria
     */
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // For listing and filtering
            $transactionType = $request->filter_transaction_type;
            $filterDateFrom = $request->filter_date_from;
            $filterDateTo = $request->filter_date_to;
            $driver = $request->filter_driver;
            $department = $request->filter_department;
            $devoteeName = $request->filter_devotee_name;

            $date_from = null;
            $date_to = null;
            # To convert date times to required format as in DB (YYYY-MM-DD)
            if (isset($filterDateFrom))
                $date_from = date('Y-m-d', strtotime($filterDateFrom));
            if (isset($filterDateTo))
                $date_to = date('Y-m-d', strtotime($filterDateTo));

            $transactionList = DB::table('other_transaction')
                ->join('lkp_transaction_types', 'other_transaction.TRANSACTION_TYPE', '=', 'lkp_transaction_types.TRANSACTION_TYPE_ID')
                ->leftJoin('vehicles', 'other_transaction.VEHICLE_ID', '=', 'vehicles.VEHICLE_ID')
                ->select('other_transaction.*', 'lkp_transaction_types.TRANSACTION_TYPE as TRANS_TYPE', 'vehicles.VEHICLE_NAME', 'vehicles.LICENSE_PLATE')
                ->when($transactionType, function ($query, $transactionType) {
                    return $query->where('other_transaction.TRANSACTION_TYPE', '=', $transactionType);
                })
                ->when($date_from, function ($query, $date_from) {
                    return $query->where('other_transaction.BILL_DATE', '>=', $date_from);
                })
                ->when($date_to, function ($query, $date_to) {
                    return $query->where('other_transaction.BILL_DATE', '<=', $date_to);
                })
                ->when($driver, function ($query, $driver) {
                    return $query->where('other_transaction.DRIVER_ID', '=', $driver);
                })
                ->when($department, function ($query, $department) {
                    return $query->where('other_transaction.DEBIT_TO_DEPT', '=', $department);
                })
                ->when($devoteeName, function ($query, $devoteeName) {
                    return $query->where('other_transaction.DEVOTEE_NAME', 'like', '%' . $devoteeName . '%');
                })
                ->get();

            return $transactionList->toJson();
        } else {
            // For returning page
            $transactionTypes = TransactionType::where('IS_ACTIVE', 'Y')->get();
            $drivers = Driver::where('IS_ACTIVE', 'Y')->get();
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get();
            $vehicleTypes = VehicleType::where('IS_ACTIVE', 'Y')->get();

            $hrApi = new HrApi;
            $departments = $hrApi->getDepartments();
            return view('transactions.transactions', compact('transactionTypes', 'drivers', 'vehicles', 'vehicleTypes', 'departments'));
        }
    }

    /**
     * Get a list of vehicles filterd by vehicle type for use in add/edit forms
     */
    public function getfilteredVehicleList(Request $request)
    {
        $vehicleType = $request->vehicle_type;
        $vehicleList = Vehicle::where('VEHICLE_TYPE_ID', $vehicleType)->where('IS_ACTIVE', 'Y')->get();
        return $vehicleList->toJson();
    }

    /**
     * To add Transaction details
     */
    public function addTransaction(Request $request)
    {
        $transaction = new Transaction();
        $transactionType = $request->transaction_type;

        if ($transactionType == 1 || $transactionType == 2 || $transactionType == 6 || $transactionType == 7) {
            # 1 = Puncture Charges
            # 2 = Parking Charges
            # 6 = Miscellaneous Charges
            # 7 = Emissions Test Charges

            $transaction->TRANSACTION_TYPE = $transactionType;
            $transaction->BILL_NUMBER = $request->bill_number;
            $transaction->BILL_DATE = date('Y-m-d', strtotime($request->bill_date));
            $transaction->DRIVER_ID = $request->driver_name;
            $transaction->DEVOTEE_NAME = $request->devotee_name;
            $transaction->VEHICLE_ID = $request->vehicle;
            $transaction->VEHICLE_TYPE_ID = $request->vehicle_type;
            if (isset($request->description))
                $transaction->DESCRIPTION = $request->description;
            $transaction->BILL_AMOUNT = $request->bill_amount;
            $transaction->DEBIT_TO_DEPT = $request->debit_to;
            $transaction->DEPARTMENT_NAME = $request->debit_to_dept_name;

            # For uploading invoice file if present
            if ($request->hasFile('invoice_upload')) {
                $file = $request->file('invoice_upload');
                $fileName = time() . '-' . date('d-m-Y') . '.' . $file->getClientOriginalExtension();
                $uploadDestination = public_path('/upload/documents/transactions/');
                $file->move($uploadDestination, $fileName);
                $transaction->INVOICE_DOCUMENT = $fileName;
            }

            $transaction->CREATED_BY = Auth::id();

            $added = $transaction->save();
            if ($added) {
                return response()->json(['successCode' => 1, 'message' => 'Transaction details added successfully']);
            } else {
                return response()->json(['successCode' => 0, 'message' => 'Failed to add Transaction details']);
            }
        } else if ($transactionType == 3) {
            # Transaction type 3 for Toll Fee

            $transaction->TRANSACTION_TYPE = $transactionType;

            $transaction->VEHICLE_ID = $request->vehicle;
            $transaction->VEHICLE_TYPE_ID = $request->vehicle_type;
            $transaction->DRIVER_ID = $request->driver_name;
            $transaction->DEVOTEE_NAME = $request->devotee_name;
            $transaction->BILL_DATE = date('Y-m-d', strtotime($request->bill_date));
            $transaction->BILL_AMOUNT = $request->bill_amount;
            $transaction->DEBIT_TO_DEPT = $request->debit_to;
            $transaction->DEPARTMENT_NAME = $request->debit_to_dept_name;

            # For uploading invoice file if present
            if ($request->hasFile('invoice_upload')) {
                $file = $request->file('invoice_upload');
                $fileName = time() . '-' . date('d-m-Y') . '.' . $file->getClientOriginalExtension();
                $uploadDestination = public_path('/upload/documents/transactions/');
                $file->move($uploadDestination, $fileName);
                $transaction->INVOICE_DOCUMENT = $fileName;
            }

            $transaction->CREATED_BY = Auth::id();

            $added = $transaction->save();
            if ($added) {
                return response()->json(['successCode' => 1, 'message' => 'Transaction details added successfully']);
            } else {
                return response()->json(['successCode' => 0, 'message' => 'Failed to add Transaction details']);
            }
        } else if ($transactionType == 4) {
            # Transaction Type 4 for Hire Charges
            $transaction->TRANSACTION_TYPE = $transactionType;

            $transaction->BILL_NUMBER = $request->bill_number;
            $transaction->BILL_DATE = date('Y-m-d', strtotime($request->bill_date));
            $transaction->DEVOTEE_NAME = $request->devotee_name;
            $transaction->VEHICLE_TYPE_ID = $request->vehicle_type;
            if (isset($request->description))
                $transaction->DESCRIPTION = $request->description;
            $transaction->BILL_AMOUNT = $request->bill_amount;
            $transaction->DEBIT_TO_DEPT = $request->debit_to;
            $transaction->DEPARTMENT_NAME = $request->debit_to_dept_name;

            # If vehicle details are present, add them
            if (isset($request->vehicle)) {
                $transaction->VEHICLE_ID = $request->vehicle;
            }

            # For uploading invoice file if present
            if ($request->hasFile('invoice_upload')) {
                $file = $request->file('invoice_upload');
                $fileName = time() . '-' . date('d-m-Y') . '.' . $file->getClientOriginalExtension();
                $uploadDestination = public_path('/upload/documents/transactions/');
                $file->move($uploadDestination, $fileName);
                $transaction->INVOICE_DOCUMENT = $fileName;
            }

            $transaction->CREATED_BY = Auth::id();

            $added = $transaction->save();
            if ($added) {
                return response()->json(['successCode' => 1, 'message' => 'Transaction details added successfully']);
            } else {
                return response()->json(['successCode' => 0, 'message' => 'Failed to add Transaction details']);
            }
        } else if ($transactionType == 5) {
            # Transaction Type 5 for Tour Bata Expenses
            $transaction->TRANSACTION_TYPE = $transactionType;

            $transaction->BILL_DATE = date('Y-m-d', strtotime($request->bill_date));
            $transaction->DRIVER_ID = $request->driver_name;
            $transaction->DEVOTEE_NAME = $request->devotee_name;
            $transaction->JOURNEY_START_DATE = date('Y-m-d', strtotime($request->start_date_of_journey));
            $transaction->JOURNEY_RETURN_DATE = date('Y-m-d', strtotime($request->return_date_of_journey));
            $transaction->JOURNEY_NUM_OF_DAYS = $request->journey_total_days;
            $transaction->RATE_PER_DAY = $request->rate_per_day;
            $transaction->BILL_AMOUNT = $request->bill_amount;
            $transaction->DEBIT_TO_DEPT = $request->debit_to;
            $transaction->DEPARTMENT_NAME = $request->debit_to_dept_name;

            # If vehicle details are present, add them
            if (isset($request->vehicle)) {
                $transaction->VEHICLE_ID = $request->vehicle;
            }
            if (isset($request->vehicle_type)) {
                $transaction->VEHICLE_TYPE_ID = $request->vehicle_type;
            }

            # For uploading invoice file if present
            if ($request->hasFile('invoice_upload')) {
                $file = $request->file('invoice_upload');
                $fileName = time() . '-' . date('d-m-Y') . '.' . $file->getClientOriginalExtension();
                $uploadDestination = public_path('/upload/documents/transactions/');
                $file->move($uploadDestination, $fileName);
                $transaction->INVOICE_DOCUMENT = $fileName;
            }

            $transaction->CREATED_BY = Auth::id();

            $added = $transaction->save();
            if ($added) {
                return response()->json(['successCode' => 1, 'message' => 'Transaction details added successfully']);
            } else {
                return response()->json(['successCode' => 0, 'message' => 'Failed to add Transaction details']);
            }
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add Transaction details']);
        }
    }

    /**
     * Get Details of Specified Transaction
     */
    public function getDetails(Request $request)
    {
        $transactionId = $request->transaction_id;
        $transactionDetails = Transaction::find($transactionId);
        return $transactionDetails->toJSON();
    }

    /**
     * Update Transaction Details in DB
     */
    public function updateTransaction(Request $request)
    {
        $transactionId = $request->transaction_id;

        $transactionToUpdate = Transaction::find($transactionId);

        # Get transaction type currently form DB entry
        $transactionType = $transactionToUpdate->TRANSACTION_TYPE;

        // Not checked for all transaction types since most fields are similar
        if (isset($request->bill_date))
            $transactionToUpdate->BILL_DATE = date('Y-m-d', strtotime($request->bill_date));
        if (isset($request->devotee_name))
            $transactionToUpdate->DEVOTEE_NAME = $request->devotee_name;
        if (isset($request->bill_amount))
            $transactionToUpdate->BILL_AMOUNT = $request->bill_amount;
        if (isset($request->debit_to))
            $transactionToUpdate->DEBIT_TO_DEPT = $request->debit_to;
        if (isset($request->debit_to_dept_name))
            $transactionToUpdate->DEPARTMENT_NAME = $request->debit_to_dept_name;
        if (isset($request->bill_number))
            $transactionToUpdate->BILL_NUMBER = $request->bill_number;
        if (isset($request->driver_name))
            $transactionToUpdate->DRIVER_ID = $request->driver_name;
        if (isset($request->vehicle))
            $transactionToUpdate->VEHICLE_ID = $request->vehicle;
        if (isset($request->vehicle_type))
            $transactionToUpdate->VEHICLE_TYPE_ID = $request->vehicle_type;
        if (isset($request->description))
            $transactionToUpdate->DESCRIPTION = $request->description;

        if ($transactionType == 5) {
            # 5 = Tour Bata Expenses
            $transactionToUpdate->JOURNEY_START_DATE = date('Y-m-d', strtotime($request->start_date_of_journey));
            $transactionToUpdate->JOURNEY_RETURN_DATE = date('Y-m-d', strtotime($request->return_date_of_journey));
            $transactionToUpdate->JOURNEY_NUM_OF_DAYS = $request->journey_total_days;
            $transactionToUpdate->RATE_PER_DAY = $request->rate_per_day;
        }
        # For uploading and updating invoice file if present i.e. if new invoice file has been selected for upload
        if ($request->hasFile('invoice_upload')) {
            $file = $request->file('invoice_upload');
            $fileName = time() . '-' . date('d-m-Y') . '.' . $file->getClientOriginalExtension();
            $uploadDestination = public_path('/upload/documents/transactions/');
            $file->move($uploadDestination, $fileName);
            $transactionToUpdate->INVOICE_DOCUMENT = $fileName;
        }

        $transactionToUpdate->MODIFIED_BY = Auth::id();

        $updated = $transactionToUpdate->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Transaction details updated successfully']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update Transaction details']);
        }
    }
}
