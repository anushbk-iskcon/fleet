<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class LegalDocumentsController extends Controller
{
    //
    /**
     * Return page listing all legal documents
     */
    public function index(Request $request)
    {
        if (request()->isMethod('post')) {
        } else {
            $vehicles = Vehicle::where('IS_ACTIVE', 'Y')->get(['VEHICLE_ID', 'VEHICLE_NAME']);
            $documentTypes = DocumentType::where('IS_ACTIVE', 'Y')->get(['DOCUMENT_TYPE_ID', 'DOCUMENT_TYPE_NAME']);
            return view('vehicle.legal-docs', compact('vehicles', 'documentTypes'));
        }
    }

    /**
     * Add new Legal Document to Database
     */
    public function store(Request $request)
    {
    }

    /**
     * Get details of specified legal document
     */
    public function getDetails(Request $request)
    {
    }

    /**
     * Update a specified legal document's details
     */
    public function update(Request $request)
    {
    }
}
