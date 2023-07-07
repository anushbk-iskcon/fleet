<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{
    //
    /** 
     *  Return screen listing all currently available priorities
     */
    public function index()
    {
        $priorities = Priority::all();
        return view('system-settings.priority', compact('priorities'));
    }

    /**
     * Add new Priority to DB Table
     */
    public function store(Request $request)
    {
        $priority = new Priority;
        $priority->PRIORITY_NAME = $request->priority_name;
        $priority->CREATED_BY = Auth::user()->USER_ID;
        $added = $priority->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully added', 'data' => $priority]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to add priority']);
        }
    }

    /**
     * Update Priority Name in DB
     */
    public function update(Request $request)
    {
        $priorityId = $request->priority_id;
        $priority = Priority::find($priorityId);
        $priority->PRIORITY_NAME = $request->priority_name;
        $priority->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $priority->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated', 'data' => $priority]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update priority']);
        }
    }

    /**
     * Activate/de-activate Priority in DB
     */
    public function statusUpdate(Request $request)
    {
        $priorityId = $request->priority_id;
        $priority = Priority::find($priorityId);

        if ($priority->IS_ACTIVE == 'Y')
            $priority->IS_ACTIVE = 'N';
        else
            $priority->IS_ACTIVE = 'Y';

        $priority->MODIFIED_BY = Auth::user()->USER_ID;
        $priority->save();

        return response($priority, 200);
    }
}
