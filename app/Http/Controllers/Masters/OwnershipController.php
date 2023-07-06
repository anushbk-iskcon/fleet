<?php

namespace App\Http\Controllers\Masters;


use App\Models\Ownership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OwnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system-settings.ownership')
            ->withOwnerships(Ownership::orderBy('created_on', 'DESC')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ownership =  new Ownership;

        $ownership->OWNERSHIP_NAME = $request->ownership_name_add;

        $ownership->IS_ACTIVE = 'Y';

        $ownership->CREATED_BY = 1; //Auth::id();

        $ownership->save();

        return response($ownership, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ownership = Ownership::find($id);

        $ownership->OWNERSHIP_NAME = $request->ownership_name_update;

        $ownership->IS_ACTIVE = 'Y';

        $ownership->CREATED_BY = Auth::id();

        $ownership->save();

        return response($ownership, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate($id)
    {
        $ownership = Ownership::find($id);

        if ($ownership->IS_ACTIVE == 'Y') {
            $ownership->IS_ACTIVE = 'N';
        } else {
            $ownership->IS_ACTIVE = 'Y';
        }

        $ownership->save();

        return response($ownership, 200);
    }
}
