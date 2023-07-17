<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    //
    /**
     * Return listing of all companies
     */
    public function index()
    {
        $companies = Company::all();
        return view('system-settings.manage-companies', compact('companies'));
    }

    /**
     * Add new Company to DB
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->COMPANY_NAME = $request->company_name;
        $company->CREATED_BY = Auth::id();
        $added = $company->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully', 'data' => $company]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add company']);
        }
    }

    /**
     * Update company name in DB
     */
    public function update(Request $request)
    {
        $companyId = $request->company_id;
        $company = Company::find($companyId);
        $company->COMPANY_NAME = $request->company_name;
        $company->MODIFIED_BY = Auth::id();
        $updated = $company->save();

        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully', 'data' => $company]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not update company']);
        }
    }

    /**
     * Activate / De-activate Compamny in DB
     */
    public function statusUpdate(Request $request)
    {
        $companyId = $request->company_id;
        $company = Company::find($companyId);

        if ($company->IS_ACTIVE == 'Y')
            $company->IS_ACTIVE = 'N';
        else
            $company->IS_ACTIVE = 'Y';

        $company->MODIFIED_BY = Auth::id();
        $company->save();

        return response($company, 200);
    }
}
