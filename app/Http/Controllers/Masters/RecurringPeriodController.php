<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\RecurringPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecurringPeriodController extends Controller
{
    //
    /**
     * Return page listing all current Recurring Periods
     */
    public function index()
    {
        $recurringPeriods = RecurringPeriod::all();
        return view('system-settings.recurring-periods', compact('recurringPeriods'));
    }

    /**
     * Add new Recurring Period to DB
     */
    public function store(Request $request)
    {
        $recurringPeriod = new RecurringPeriod;
        $recurringPeriod->RECURRING_PERIOD_NAME = $request->recurring_period_name;
        $recurringPeriod->IS_ACTIVE = 'Y';
        $recurringPeriod->CREATED_BY = Auth::id();
        $added = $recurringPeriod->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully', 'data' => $recurringPeriod]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add recurring period']);
        }
    }

    /**
     * Update Recurring Period Name in DB
     */
    public function update(Request $request)
    {
        $recurring_period_id = $request->recurring_period_id;
        $recurringPeriod = RecurringPeriod::find($recurring_period_id);

        $recurringPeriod->RECURRING_PERIOD_NAME = $request->recurring_period_name;
        $recurringPeriod->MODIFIED_BY = Auth::id();
        $updated = $recurringPeriod->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully', 'data' => $recurringPeriod]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not update recurring period']);
        }
    }

    /**
     * Activate / De-activate Recurring Period
     */
    public function statusUpdate(Request $request)
    {
        $recurring_period_id = $request->recurring_period_id;
        $recurringPeriod = RecurringPeriod::find($recurring_period_id);

        if ($recurringPeriod->IS_ACTIVE == 'Y')
            $recurringPeriod->IS_ACTIVE = 'N';
        else
            $recurringPeriod->IS_ACTIVE = 'Y';

        $recurringPeriod->MODIFIED_BY = Auth::id();
        $recurringPeriod->save();
        return response($recurringPeriod, 200);
    }
}
