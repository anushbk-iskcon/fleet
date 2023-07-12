<?php

namespace App\Http\Controllers;

use App\Models\RefuelRequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RefuelRequisitionController extends Controller
{
    //
    /**
     * Return page listing all refueling requests
     */
    public function index()
    {
        return view('refueling.refuel-requisitions');
    }

    /**
     * Add new refueling requisition to DB
     */
    public function store(Request $request)
    {
        $refuelRequest = new RefuelRequisition;
    }

    /**
     * Update Refuel Requisition Details in DB
     */
    public function update(Request $request)
    {
    }

    /**
     * Activate / Deactivate Refuel Requisition
     */
    public function changeActivationStatus(Request $request)
    {
    }
}
