<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\NotificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationTypeController extends Controller
{
    //
    /**
     * Listing of all current Maintenance Types
     */
    public function index()
    {
        $notificationTypes = NotificationType::all();
        return view('system-settings.notifications', compact('notificationTypes'));
    }

    /**
     * Add new Maintenance Type to DB
     */
    public function store(Request $request)
    {
        $notificationType = new NotificationType;
        $notificationType->NOTIFICATION_TYPE_NAME = $request->notification_name;
        $notificationType->CREATED_BY = Auth::user()->USER_ID;
        $added = $notificationType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully', 'data' => $notificationType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add new notification type']);
        }
    }

    /**
     * Update Maintenance Type Name in DB
     */
    public function update(Request $request)
    {
        $notification_type_id = $request->notification_type_id;
        $notificationType = NotificationType::find($notification_type_id);
        $notificationType->NOTIFICATION_TYPE_NAME = $request->notification_name;
        $notificationType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $notificationType->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully', 'data' => $notificationType]);
        } else {
            return response()->json(['successCode' => 1, 'message' => 'Could not update notification type']);
        }
    }

    /**
     * Activate/de-activate Maintenance Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $notification_type_id = $request->notification_type_id;
        $notificationType = NotificationType::find($notification_type_id);

        if ($notificationType->IS_ACTIVE == 'Y')
            $notificationType->IS_ACTIVE = 'N';
        else
            $notificationType->IS_ACTIVE = 'Y';

        $notificationType->save();
        return response($notificationType, 200);
    }
}
