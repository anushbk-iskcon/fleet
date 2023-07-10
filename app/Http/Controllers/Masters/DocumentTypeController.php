<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentTypeController extends Controller
{
    //
    /**
     * Listing of all current Maintenance Types
     */
    public function index()
    {
        $documentTypes = DocumentType::all();
        return view('system-settings.document-types', compact('documentTypes'));
    }

    /**
     * Add new Maintenance Type to DB
     */
    public function store(Request $request)
    {
        $documentType = new DocumentType;
        $documentType->DOCUMENT_TYPE_NAME = $request->document_name;
        $documentType->CREATED_BY = Auth::user()->USER_ID;
        $added = $documentType->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Added successfully', 'data' => $documentType]);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add new document type']);
        }
    }

    /**
     * Update Maintenance Type Name in DB
     */
    public function update(Request $request)
    {
        $document_type_id = $request->document_type_id;
        $documentType = DocumentType::find($document_type_id);
        $documentType->DOCUMENT_TYPE_NAME = $request->document_name;
        $documentType->MODIFIED_BY = Auth::user()->USER_ID;
        $updated = $documentType->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Updated successfully', 'data' => $documentType]);
        } else {
            return response()->json(['successCode' => 1, 'message' => 'Could not update document type']);
        }
    }

    /**
     * Activate/de-activate Maintenance Type in DB
     */
    public function statusUpdate(Request $request)
    {
        $document_type_id = $request->document_type_id;
        $documentType = DocumentType::find($document_type_id);

        if ($documentType->IS_ACTIVE == 'Y')
            $documentType->IS_ACTIVE = 'N';
        else
            $documentType->IS_ACTIVE = 'Y';

        $documentType->save();
        return response($documentType, 200);
    }
}
