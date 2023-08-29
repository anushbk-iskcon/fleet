<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Driver;
use App\Models\HrApi;
use App\Models\Ownership;
use App\Models\RTACircleOffice;
use App\Models\Vehicle;
use App\Models\VehicleDivision;
use App\Models\VehicleType;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleRequisition;
use App\Models\RequisitionPurpose;
use App\Models\RequisitionType;
use App\Models\Phase;
use App\Models\ApprovalAuthority;
use DataTables;
use Str;
use App\Models\User;

class VehicleReqController extends Controller
{
    public function __construct()
    {
        
    }
    /////////Requisition List//////////////
    public function index(Request $request)
    {
        $emp='';
        $driver=Driver::where(['IS_ACTIVE'=>'Y'])->get();
        $vehicle_type=VehicleType::where(['IS_ACTIVE'=>'Y'])->get();
        $purpose=RequisitionPurpose::where(['IS_ACTIVE'=>'Y'])->get();
        $hrApi = new HrApi;
        $employee = $hrApi->getEmployeeList($emp);
        $empData = $employee['data'];
        $departments = $hrApi->getDepartments();

        if ($request->ajax()) {

            $data=VehicleRequisition::orderBy('VEHICLE_REQ_ID','desc')->get();
    
            return Datatables::of($data)
    
                ->addIndexColumn()
    
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('req_forsr'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['REQUISITION_FOR'], $request->get('req_forsr')) ? true : false;
                        });
                    }
                    if (!empty($request->get('vehicle_typesr'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['VEHICLE_TYPE_ID'], $request->get('vehicle_typesr')) ? true : false;
                        });
                    }
                    if (!empty($request->get('from'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $requestedDate = $request->get('from');
                        $rowDate = $row['TIME_FROM'];
                           return strtotime($rowDate) >= strtotime($requestedDate);
                        });
                    }
                    if (!empty($request->get('to'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $requestedDate = $request->get('to');
                        $rowDate = $row['TIME_TO'];
                           return strtotime($rowDate) <= strtotime($requestedDate);
                        });
                    }
                    if (!empty($request->get('status'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['STATUS'], $request->get('status')) ? true : false;
                        });
                    }
                })
                ->addColumn('req_for', function($row){
                   $req_for=getEmployeename($row['REQUISITION_FOR']);   
                   return $req_for;
    
                })
                ->addColumn('req_date', function($row){
                    $req_for=date('j-F-Y',strtotime($row['REQUISITION_DATE']));   
                    return $req_for;
     
                 })
                 ->addColumn('driver', function($row){
                    if($row['DRIVER_ID']){
                        $drv=Driver::where(['DRIVER_ID'=>$row['DRIVER_ID']])->first();
                        $driver = ($drv) ? $drv->DRIVER_NAME : '';
                    }else{
                        $driver = 'NULL';
                    }  
                    return $driver;
     
                 })
                 ->addColumn('create_by', function($row){
                    $crt_by = User::where(['USER_ID'=>$row['CREATED_BY']])->first();
                    return ($crt_by) ? $crt_by->FIRST_NAME." ".$crt_by->LAST_NAME : '';
     
                 })
                 ->addColumn('status', function($row){
                    if($row['STATUS'] == 'P'){
                        $status = 'Pending';
                    }elseif($row['STATUS'] == 'A'){
                        $status = 'Approved';
                    }else{
                        $status = 'Cancel';
                    }  
                    return $status;
     
                 })
                ->addColumn('action', function($row){
                    $btn = '<a data-id="'.$row['VEHICLE_REQ_ID'].'" style="cursor:pointer;color:#fff;"  data-toggle="modal" data-target="#edit"
                    class="btn btn-primary btn-sm mr-1 editModal" data-toggle="tooltip"
                    data-placement="left" title="Update"><i class="ti-pencil"></i></a>';
                    if($row['DRIVER_ID']){
                        $btn.='<a data-driverid="'.$row['DRIVER_ID'].'" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#driverModal" style="cursor:pointer;color:#fff;"
                        class="btn btn-success btn-sm mr-1 driver-modal" data-toggle="tooltip"
                        data-placement="left" title="Update"><i class="ti-user"></i></a>';
                    }else{
                        $btn.='<a data-driverid="" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#driverModal" style="cursor:pointer;color:#fff;"
                        class="btn  btn-danger btn-sm mr-1 driver-modal" data-toggle="tooltip"
                        data-placement="left" title="Update"><i class="ti-user"></i></a>';
                    }
                    if($row['STATUS'] == 'P'){
                        $btn.='<div class="text-right" style="display:inline-block;">
                        <div class="actions" style="display:inline-block;">
                        <div class="dropdown action-item" aria-expanded="false">
                        <a href="#" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#statusModal" class="action-item statusModal"><i class="ti-more-alt"></i></a>
                        </div>
                        </div>
                        </div>';
                    
                    }elseif($row['STATUS'] == 'A'){
                        $btn.='<a data-id="'.$row['VEHICLE_REQ_ID'].'" style="cursor:pointer;color:#fff;"
                        class="btn btn-success btn-sm mr-1" data-toggle="tooltip"
                        data-placement="left" title="Approved"><i class="ti-check"></i></a>';
                        $btn.='<div class="text-right" style="display:inline-block;">
                        <div class="actions" style="display:inline-block;">
                        <div class="dropdown action-item" aria-expanded="false">
                        <a href="#" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#statusModal" class="action-item statusModal"><i class="ti-more-alt"></i></a>
                        </div>
                        </div>
                        </div>';
                    }else{
                        $btn.='<a data-id="'.$row['VEHICLE_REQ_ID'].'" style="cursor:pointer;color:#fff;"
                        class="btn btn-danger btn-sm mr-1" data-toggle="tooltip"
                        data-placement="left" title="Cancel"><i class="ti-close"></i></a>';
                       
                    }

                    return $btn;
    
                })
    
                ->rawColumns(['action','req_for','req_date','driver','create_by','status'])
    
                ->make(true);
    
        }
        return view('vehicle-req.vehicle-requisition',compact('driver','vehicle_type','purpose','empData','departments'));
    }
    public function addRequisition(Request $request)
    {

        DB::beginTransaction();

		try{
            $getVehicle = Vehicle::where(['VEHICLE_ID'=>$request->vehicle])->first();
    	    $dataInsert = VehicleRequisition::create([
                'DEPT_ID'=>$request->department,
                'REQUISITION_FOR'=>$request->req_for,
                'VEHICLE_TYPE_ID'=>$request->vehicle_type,
                'WHERE_FROM'=>$request->where_fr,
                'WHERE_TO'=>$request->where_to,
                'PICK_UP'=>$request->pickup,
                'REQUISITION_DATE'=>date('Y-m-d',strtotime($request->req_date)),
                'TIME_FROM'=>date('H:i',strtotime($request->time_fr)),
                'TIME_TO'=>date('H:i',strtotime($request->time_to)),
                'TOLERANCE_DURATION'=>date('H:i',strtotime($request->tolerance)),
                'NUMBER_OF_PASSENGER'=>$request->nunpassenger,
                'REQUISITION_PURPOSE_ID'=>$request->purpose,
                'DETAILS'=>$request->details,
                'STATUS'=>'P',
                'DRIVER_ID'=>($getVehicle->DRIVER_ID) ? $getVehicle->DRIVER_ID : '',
                'VEHICLE_ID'=>$request->vehicle,
                'IS_CHECK'=>$request->checkValue,
                'CREATED_ON'=>date('Y-m-d H:i:s'),
                'CREATED_BY'=>Auth::id(),
              
            ]);
            DB::commit();
            if ($dataInsert) {
                $arr=[
                    'error'=>false,
                    'msg'=>'Booking Details Inserted Successfully',
                ];
                return json_encode($arr);
            }
            else {
                $arr=[
                    'error'=>true,
                    'msg'=>'Error Adding Booking. Please try again'
                ];
                return json_encode($arr);
            }

        }catch(\Exception $e){
            DB::rollback();
            // echo $e->getMessage();
            // exit;
            $arr=[
                'error'=>true,
                'msg'=>$e->getMessage()
            ];
            return json_encode($arr);
        }

    }
    public function editRequisition(Request $request)
    {

        DB::beginTransaction();

		try{
            $getVehicle = Vehicle::where(['VEHICLE_ID'=>$request->vehicle])->first();
            $data=VehicleRequisition::where(['VEHICLE_REQ_ID'=>$request->id])->first();
    	    $data->update([
                'DEPT_ID'=>$request->department,
                'REQUISITION_FOR'=>$request->req_for,
                'VEHICLE_TYPE_ID'=>$request->vehicle_type,
                'WHERE_FROM'=>$request->where_fr,
                'WHERE_TO'=>$request->where_to,
                'PICK_UP'=>$request->pickup,
                'REQUISITION_DATE'=>date('Y-m-d',strtotime($request->req_date)),
                'TIME_FROM'=>date('H:i',strtotime($request->time_fr)),
                'TIME_TO'=>date('H:i',strtotime($request->time_to)),
                'TOLERANCE_DURATION'=>date('H:i',strtotime($request->tolerance)),
                'NUMBER_OF_PASSENGER'=>$request->nunpassenger,
                'REQUISITION_PURPOSE_ID'=>$request->purpose,
                'DETAILS'=>$request->details,
                'DRIVER_ID'=>($getVehicle->DRIVER_ID) ? $getVehicle->DRIVER_ID : '',
                'VEHICLE_ID'=>$request->vehicle,
                'IS_CHECK'=>$request->checkValue,
                'MODIFIED_ON'=>date('Y-m-d H:i:s'),
                'MODIFIED_BY'=>Auth::id(),
            ]);
            DB::commit();
            if ($data->save()) {
                $arr=[
                    'error'=>false,
                    'msg'=>'Booking Details Updated Successfully',
                ];
                return json_encode($arr);
            }
            else {
                $arr=[
                    'error'=>true,
                    'msg'=>'Error Updating Booking. Please try again'
                ];
                return json_encode($arr);
            }

        }catch(\Exception $e){
            DB::rollback();
            // echo $e->getMessage();
            // exit;
            $arr=[
                'error'=>true,
                'msg'=>$e->getMessage()
            ];
            return json_encode($arr);
        }

    }
    public function getData(Request $request)
    {
        $data=VehicleRequisition::where(['VEHICLE_REQ_ID'=>$request->req_id])->first();
        // $type=($data->VEHICLE_TYPE_ID) ? $data->VEHICLE_TYPE_ID : '';
        // $rdate=($data->REQUISITION_DATE) ? $data->REQUISITION_DATE : '';
        // $frmt=($data->TIME_FROM) ? $data->TIME_FROM : '';
        // $tot=($data->TIME_TO) ? $data->TIME_TO : '';
        // $checked = ($data->IS_CHECK=='1') ? 'true' : 'false';
        // if($checked == 'true')
        // {
        //     $getVehicle=Vehicle::where(['VEHICLE_TYPE_ID'=>$type])->get();
        // }else{
        //     $existingVehicleIds = VehicleRequisition::where('VEHICLE_TYPE_ID', $type)
        //     ->when($rdate, function ($query, $rdate) {
        //         $query->where('REQUISITION_DATE', date('Y-m-d', strtotime($rdate)));
        //     })
        //     ->when($frmt, function ($query, $frmt) {
        //         $query->where(function ($subQuery) use ($frmt) {
        //             $subQuery->whereTime('TIME_FROM', '>=', $frmt);
        //         });
        //     })
        //     ->when($tot, function ($query, $tot) {
        //         $query->orWhere(function ($subQuery) use ($tot) {
        //             $subQuery->whereTime('TIME_TO', '<=', $tot);
        //         });
        //     })

        //     ->where('STATUS','!=','R')
        //     ->pluck('VEHICLE_ID')
        //     ->toArray();
        //     $getVehicle = Vehicle::where('VEHICLE_TYPE_ID', $type)
        //         ->whereNotIn('VEHICLE_ID', $existingVehicleIds)
        //         ->get();
        //     }
        // $data['vehicle_lis'] = $getVehicle;
        $getVehicle = Vehicle::where('VEHICLE_ID', $data->VEHICLE_ID)
        ->first();
        $data['max_num'] = $getVehicle->SEAT_CAPACITY;
        return json_encode($data);
    }
    public function addDriver(Request $request)
    {
        DB::beginTransaction();
		try{

    	    $dataInsert = VehicleRequisition::where(['VEHICLE_REQ_ID'=>$request->req_id])->first();
            $dataInsert->DRIVER_ID = $request->drivenby;

            if ($dataInsert->save()) {
                DB::commit();
                $arr=[
                    'error'=>false,
                    'msg'=>'Driver Assigned Successfully',
                ];
                return json_encode($arr);
            }
            else {
                $arr=[
                    'error'=>true,
                    'msg'=>'Error Assigned Driver. Please try again'
                ];
                return json_encode($arr);
            }

        }catch(\Exception $e){
            DB::rollback();
            $arr=[
                'error'=>true,
                'msg'=>$e->getMessage()
            ];
            return json_encode($arr);
        }

    }
    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
		try{

    	    $dataInsert = VehicleRequisition::where(['VEHICLE_REQ_ID'=>$request->req_id])->first();
            $dataInsert->STATUS = $request->status;

            if ($dataInsert->save()) {
                DB::commit();
                $arr=[
                    'error'=>false,
                    'msg'=>'Status Change Successfully',
                ];
                return json_encode($arr);
            }
            else {
                $arr=[
                    'error'=>true,
                    'msg'=>'Error Status Change. Please try again'
                ];
                return json_encode($arr);
            }

        }catch(\Exception $e){
            DB::rollback();
            $arr=[
                'error'=>true,
                'msg'=>$e->getMessage()
            ];
            return json_encode($arr);
        }

    }
    public function getVehicleData(Request $request)
    {
        $type=($request->type) ? $request->type : '';
        $rdate=($request->rdate) ? $request->rdate : '';
        $frmt=($request->frmt) ? $request->frmt : '';
        $tot=($request->tot) ? $request->tot : '';
        $checked = $request->checked;
        if($checked == 'true')
        {
            $getVehicle=Vehicle::where(['VEHICLE_TYPE_ID'=>$type,'IS_ACTIVE'=>'Y'])->get();
        }else{
            $existingVehicleIds = VehicleRequisition::where('VEHICLE_TYPE_ID', $type)
            ->when($rdate, function ($query, $rdate) {
                $query->where('REQUISITION_DATE', date('Y-m-d', strtotime($rdate)));
            })
            ->when($frmt, function ($query, $frmt) {
                $query->where(function ($subQuery) use ($frmt) {
                    $subQuery->whereTime('TIME_FROM', '>=', $frmt);
                });
            })
            ->when($tot, function ($query, $tot) {
                $query->orWhere(function ($subQuery) use ($tot) {
                    $subQuery->whereTime('TIME_TO', '<=', $tot);
                });
            })

            ->where('STATUS','!=','R')
            ->pluck('VEHICLE_ID')
            ->toArray();
            $getVehicle = Vehicle::where('VEHICLE_TYPE_ID', $type)
                ->where(['IS_ACTIVE'=>'Y'])
                ->whereNotIn('VEHICLE_ID', $existingVehicleIds)
                ->get();
            }
        
        $html ='<option value="" selected="selected">Please Select Vehicle</option>';
        foreach($getVehicle as $val)
        {
            $html.='<option value="'.$val->VEHICLE_ID.'" data-limit="'.$val->SEAT_CAPACITY.'">'.$val->VEHICLE_NAME.'</option>';
        }
        echo $html;

    }
    public function getEditVehicleData(Request $request)
    {
        DB::enableQueryLog();
        $type=($request->type) ? $request->type : '';
        $rdate=($request->rdate) ? $request->rdate : '';
        $frmt=($request->frmt) ? $request->frmt : '';
        $tot=($request->tot) ? $request->tot : '';
        $checked = $request->checked;
        if($checked == 'true')
        {
            $getVehicle=Vehicle::where(['VEHICLE_TYPE_ID'=>$type])->get();
        }else{
            $existingVehicleIds = VehicleRequisition::where('VEHICLE_TYPE_ID', $type)
            ->where('VEHICLE_REQ_ID',"!=",$request->id)
            ->where('STATUS','!=','R')
            ->when($rdate, function ($query, $rdate) {
                $query->where('REQUISITION_DATE', date('Y-m-d', strtotime($rdate)));
            })
            ->when($frmt, function ($query, $frmt) {
                $query->whereTime('TIME_FROM', '>=', $frmt);
            })
            ->when($tot, function ($query, $tot) {
                $query->whereTime('TIME_TO', '<=', $tot);
            })
            ->pluck('VEHICLE_ID')
            ->toArray();
            // print_r(DB::getQueryLog());
            // print_r($existingVehicleIds);
            // exit;
            $getVehicle = Vehicle::where('VEHICLE_TYPE_ID', $type)
                ->whereNotIn('VEHICLE_ID', $existingVehicleIds)
                ->get();
            }
       
        $html ='<option value="" selected="selected">Please Select Vehicle</option>';
        foreach($getVehicle as $val)
        {
            $html.='<option value="'.$val->VEHICLE_ID.'" data-limit="'.$val->SEAT_CAPACITY.'">'.$val->VEHICLE_NAME.'</option>';
        }
        echo $html;

    }

    // ///////////Approval List/////////////////
    public function approvalAuthorities(Request $request)
    {
        if (request()->isMethod('post')) {
            // Return JSON list of all approval authorities
            $filter_dept = $request->dept_sr;
            $filter_status = $request->req_phasesr;
            $req_typesr = 1; // For Maintenance Requisition

            $approvalAuthData = DB::table('mstr_approval_authorities')
                ->join('mstr_requisition_types', 'mstr_approval_authorities.REQUISITION_TYPE', '=', 'mstr_requisition_types.REQUISITION_TYPE_ID')
                ->join('mstr_phases', 'mstr_approval_authorities.REQUISITION_PHASE', '=', 'mstr_phases.PHASE_ID')
                ->select(
                    'mstr_approval_authorities.*',
                    'mstr_requisition_types.REQUISITION_TYPE_NAME as REQ_TYPE_NAME',
                    'mstr_phases.PHASE_NAME as PHASE_NAME'
                )
                ->where('REQUISITION_TYPE', $req_typesr)
                ->when($filter_dept, function ($query, $filter_dept) {
                    return $query->where('DEPARTMENT_CODE', '=', $filter_dept);
                })
                ->when($filter_status, function ($query, $filter_status) {
                    return $query->where('REQUISITION_PHASE', '=', $filter_status);
                })
                ->get();

            return $approvalAuthData->toJson();
        } else {
            $reqTypes = RequisitionType::where('IS_ACTIVE', 'Y')->get();
            $phases = Phase::where('IS_ACTIVE', 'Y')->get();

            // To get departments and employees
            $hrApi = new HrApi;
            $departments = $hrApi->getDepartments();
            $employees = $hrApi->getEmployeeList(""); //Dept "" to get all employees

            return view('vehicle-req.approval-authorities', compact('reqTypes', 'departments', 'employees', 'phases'));
        }
    }

    /**
     * Load Employees to Add/Edit Approval Authority when department is selected/changed
     */
    public function getEmployeeData(Request $request)
    {
        $dept = $request->department;

        if ($dept == "" || $dept == null)
            return;
        $deptArray = explode('|', $dept); # Since option values are in form: deptCode|deptName
        // dd($deptArray);
        $data = new stdClass;
        $data->department = $deptArray[1]; # Send deptName to API method to get employee list
        $hrApi = new HrApi;

        $employeeData = $hrApi->getEmployeeList($data);
        return $employeeData;
    }
    public function addApprovalAuthority(Request $request)
    {
        $maintenReqApprovalAuthority = new ApprovalAuthority;

        // To get Dept and Employee Details which are in form id|value
        // e.g. Dept option value is in format deptCode|deptName to enable storing both details in DB
        $deptString = $request->department;
        $employeeString = $request->employee;
        $deptData = explode('|', $deptString);
        $deptCode = $deptData[0];
        $deptName = $deptData[1];
        $employeeData = explode('|', $employeeString);
        $employeeId = $employeeData[0];
        $employeeName = $employeeData[1];

        // Add Details
        $maintenReqApprovalAuthority->REQUISITION_TYPE = $request->req_type;
        $maintenReqApprovalAuthority->REQUISITION_PHASE = $request->phase;
        $maintenReqApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $maintenReqApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $maintenReqApprovalAuthority->EMPLOYEE_ID = $employeeId;
        $maintenReqApprovalAuthority->EMPLOYEE_NAME = $employeeName;
        $maintenReqApprovalAuthority->CREATED_BY = Auth::id();
        $added = $maintenReqApprovalAuthority->save();

        if ($added) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully added']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Could not add approval authority']);
        }
    }

    /**
     * Update Maintenance Approval Authority Details
     */
    public function updateApprovalAuthority(Request $request)
    {
        $authority_id = $request->auth_id;
        $maintenReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $maintenReqApprovalAuthority->REQUISITION_PHASE = $request->phase;

        $deptString = $request->department;
        $deptData = explode('|', $deptString);
        $deptCode = $deptData[0];
        $deptName = $deptData[1];

        # Employee (approver) is not currently changeable

        $maintenReqApprovalAuthority->DEPARTMENT_CODE = $deptCode;
        $maintenReqApprovalAuthority->DEPARTMENT_NAME = $deptName;
        $maintenReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $updated = $maintenReqApprovalAuthority->save();
        if ($updated) {
            return response()->json(['successCode' => 1, 'message' => 'Approval authority successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update approval authority']);
        }
    }

    /**
     * Activate / De-activate Approval Authority
     */
    public function changeActivationOfApprovalAuthority(Request $request)
    {
        $authority_id = $request->req_auth_id;
        $status = $request->req_status == 1 ? 'Y' : 'N';

        $maintenReqApprovalAuthority = ApprovalAuthority::find($authority_id);
        $maintenReqApprovalAuthority->IS_ACTIVE = $status;
        $maintenReqApprovalAuthority->MODIFIED_BY = Auth::id();
        $activationUpdated = $maintenReqApprovalAuthority->save();

        if ($activationUpdated) {
            return response()->json(['successCode' => 1, 'message' => 'Successfully updated']);
        } else {
            return response()->json(['successCode' => 0, 'message' => 'Failed to update']);
        }
    }
}
