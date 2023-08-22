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
use DataTables;
use Str;
use App\Models\User;

class VehicleReqController extends Controller
{
    public function __construct()
    {
        
    }
    public function index(Request $request)
    {
        $emp='';
        $driver=Driver::where(['IS_ACTIVE'=>'Y'])->get();
        $vehicle_type=VehicleType::where(['IS_ACTIVE'=>'Y'])->get();
        $purpose=RequisitionPurpose::where(['IS_ACTIVE'=>'Y'])->get();
        $hrApi = new HrApi;
        $employee = $hrApi->getEmployeeList($emp);
        $empData = $employee['data'];


        if ($request->ajax()) {

            $data=VehicleRequisition::orderBy('VEHICLE_REQ_ID','asc')->get();
    
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
                   $req_for='Test Employee';   
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
                    class="btn btn-xs btn-success btn-sm mr-1 editModal" data-toggle="tooltip"
                    data-placement="left" title="Update"><i class="ti-pencil"></i></a>';
                    // if($row['DRIVER_ID']){
                    //     $btn.='<a data-driverid="'.$row['DRIVER_ID'].'" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#driverModal" style="cursor:pointer;color:#fff;"
                    //     class="btn btn-xs btn-success btn-sm mr-1 driver-modal" data-toggle="tooltip"
                    //     data-placement="left" title="Update"><i class="ti-user"></i></a>';
                    // }else{
                    //     $btn.='<a data-driverid="" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#driverModal" style="cursor:pointer;color:#fff;"
                    //     class="btn btn-xs btn-danger btn-sm mr-1 driver-modal" data-toggle="tooltip"
                    //     data-placement="left" title="Update"><i class="ti-user"></i></a>';
                    // }
                    if($row['STATUS'] == 'P'){
                        $btn.='<div class="text-right" style="display:inline-block;">
                        <div class="actions" style="display:inline-block;">
                        <div class="dropdown action-item" data-toggle="dropdown" aria-expanded="false">
                        <a href="#" data-id="'.$row['VEHICLE_REQ_ID'].'" data-toggle="modal" data-target="#statusModal" class="action-item statusModal"><i class="ti-more-alt"></i></a>
                        </div>
                        </div>
                        </div>';
                    
                    }elseif($row['STATUS'] == 'A'){
                        $btn.='<a data-id="'.$row['VEHICLE_REQ_ID'].'" style="cursor:pointer;color:#fff;"
                        class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip"
                        data-placement="left" title="Approved"><i class="ti-check"></i></a>';
                    }else{
                        $btn.='<a data-id="'.$row['VEHICLE_REQ_ID'].'" style="cursor:pointer;color:#fff;"
                        class="btn btn-xs btn-danger btn-sm mr-1" data-toggle="tooltip"
                        data-placement="left" title="Cancel"><i class="ti-close"></i></a>';
                    }

                    return $btn;
    
                })
    
                ->rawColumns(['action','req_for','req_date','driver','create_by','status'])
    
                ->make(true);
    
        }
        return view('vehicle-req.vehicle-requisition',compact('driver','vehicle_type','purpose','empData'));
    }
    public function addRequisition(Request $request)
    {

        DB::beginTransaction();

		try{

    	    $dataInsert = VehicleRequisition::create([
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
            $data=VehicleRequisition::where(['VEHICLE_REQ_ID'=>$request->id])->first();
    	    $data->update([
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
        $type=$request->type;
        $rdate=$request->rdate;
        $frmt=$request->frmt;
        $tot=$request->tot;

        $getVehicle=Vehicle::where(['VEHICLE_TYPE_ID'=>$type])->get();
        $html ='<option value="" selected="selected">Please Select Vehicle</option>';
        foreach($getVehicle as $val)
        {

        }
        echo $html;

    }
}
