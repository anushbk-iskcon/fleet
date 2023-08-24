<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LicenseTypeController extends Controller
{
    //
    public function index(Request $request)
    {
        $licenseTypes = DB::table('mstr_license')->get();
        return view('employee.manage-license', compact('licenseTypes'));
    }

    public function store(Request $request)
    {
        $license_type = $request->license_name;
        $message = '';

        $id = DB::table('mstr_license')->insertGetId([
            'LICENSE_NAME' => $license_type,
            'IS_ACTIVE' => 'Y',
            'CREATED_BY' => Auth::id(),
            'CREATED_ON' => date('Y-m-d H:i:s')
        ]);

        if ($id) {
            $message = 'Succesfully added';
            return redirect()->route('manage-licenses')->withSuccess($message);
        } else {
            $message = 'Failed to add license type';
            return redirect()->route('manage-licenses')->withFailure($message);
        }
    }

    public function update(Request $request)
    {
        $license_type = $request->license_name;
        $id = $request->license_id;

        $affectedRows = DB::table('mstr_license')->where('LICENSE_ID', $id)
            ->update(['LICENSE_NAME' => $license_type, 'MODIFIED_BY' => Auth::id(), 'MODIFIED_ON' => date('Y-m-d H:i:s')]);

        if ($affectedRows) {
            return redirect()->route('manage-licenses')->withSuccess("Successfully updated");
        } else {
            return redirect()->route('manage-licenses')->withFailure("Failed to update");
        }
    }

    public function activationStatusChange(Request $request)
    {
        $id = $request->license_id;
        $active_status = $request->activation_status == 1 ? 'Y' : 'N';

        $affectedRows = DB::table('mstr_license')->where('LICENSE_ID', $id)
            ->update(['IS_ACTIVE' => $active_status, 'MODIFIED_BY' => Auth::id(), 'MODIFIED_ON' => date('Y-m-d H:i:s')]);

        if ($affectedRows) {
            return redirect()->route('manage-licenses')->withSuccess("Successfully updated");
        } else {
            return redirect()->route('manage-licenses')->withFailure("Failed to update");
        }
    }
}
