<?php

namespace App\Http\Controllers\Masters;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system-settings.departments')
            ->withDepartments(Department::orderBy('created_on', 'DESC')->get());
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
        $department =  new Department;

        $department->DEPARTMENT_NAME = $request->department_name_add;

        $department->IS_ACTIVE = 'Y';

        $department->CREATED_BY = Auth::id();

        $department->save();

        return response($department, 200);
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
        $department =  Department::find($id);

        $department->DEPARTMENT_NAME = $request->department_name_update;

        $department->MODIFIED_BY = Auth::id();

        $department->save();

        return response($department, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate($id)
    {
        $department = Department::find($id);

        if ($department->IS_ACTIVE == 'Y') {
            $department->IS_ACTIVE = 'N';
        } else {
            $department->IS_ACTIVE = 'Y';
        }

        $department->save();

        return response($department, 200);
    }
}
