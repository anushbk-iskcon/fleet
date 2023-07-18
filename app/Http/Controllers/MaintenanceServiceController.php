<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceServiceController extends Controller
{
    //
    /**
     * Return listing of all Maintenance Services
     */
    public function index()
    {
        return view('maintenance.maintenance-service-list');
    }

    /**
     * Add new Maintenance Service to DB
     */
    public function store(Request $request)
    {
    }

    /**
     * Update Maintenance Service details in DB
     */
    public function update(Request $request)
    {
    }

    /**
     * Deactivate / activate Maintenance Service in DB
     */
    public function activationStatusUpdate(Request $request)
    {
    }
}
