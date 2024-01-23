@extends('layouts.main.app')

@section('title', 'Vehicle Requisitions')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Requisition</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Requisition</h1>
<small id="controllerName">Manage Vehicle Requisitions</small>
@endsection

@section('css-content')

@endsection

@section('content')
<div class="row mb-3">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Search Here<small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add Requisition
                        </button>
                    </small>
                </h4>
            </div>
            <form id="searchform" method="get">
                <div class="card-body row">
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="req_forsr" class="col-sm-5 col-form-label justify-content-start text-left">Requisition For </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="req_forsr" id="req_forsr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['employeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-1">
                            <label for="vehicle_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicle Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="vehicle_typesr" id="vehicle_typesr">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="from" class="col-sm-5 col-form-label justify-content-start text-left">Time From
                            </label>
                            <div class="col-sm-7">
                                <input name="from" autocomplete="off" class="form-control vnewdatetimepicker w-100" type="time" placeholder="From" id="from">
                            </div>

                        </div>
                        <div class="form-group row mb-1">
                            <label for="to" class="col-sm-5 col-form-label justify-content-start text-left">Time To
                            </label>
                            <div class="col-sm-7">
                                <input name="to" autocomplete="off" class="form-control vnewdatetimepicker w-100" type="time" placeholder="To" id="to">
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-4">
                        <div class="form-group row mb-1">
                            <label for="status" class="col-sm-5 col-form-label justify-content-start text-left">Status
                            </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="status" id="status">
                                    <option value="" selected="selected">Please Select One</option>
                                    <option value="P">Pending</option>
                                    <option value="A">Approved </option>
                                    <option value="R">Rejected </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row  mb-1">
                            <label for="joining_d_to" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 text-right">

                                <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Requisition List</h4>
            </div>
            <div class="card-body pl-3 pr-3">
                <div class="table-responsive">
                    <table id="dataTable" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition For</th>
                                <th>Requisition Date</th>
                                <th>Driver Name</th>
                                <th>Requested By </th>
                                <th>Status</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody id="table_data">

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<div id="add" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form" action="{{route('add_requisition')}}" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="department" class="col-sm-5 col-form-label">User Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="newDepartment">
                                    <option value="">Please Select One</option>
                                    @foreach($departments['data'] as $department)
                                    <option value="{{$department['deptCode']}}">
                                        {{$department['deptName']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_for" class="col-sm-5 col-form-label">Requisition For <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="req_for" id="req_for">
                                    <option value="" selected="selected">Select User</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['hrEmployeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-5 col-form-label">User Entity Code <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="user_entity" id="userEntityCode" class="form-control basic-single">
                                    <option value="">Select User Entity Code</option>
                                    @foreach($entityData as $entity)
                                    <option value="{{$entity['entityCode'] . ' - ' . $entity['entityName']}}">{{$entity['entityCode'] . ' - ' . $entity['entityName']}}</option>
                                    @endforeach
                                </select>
                                <!-- <input type="hidden" name="user_entity_name" value="" id="addReqUserEntityName"> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-5 col-form-label">User Department HOD <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="hod_employee_id" id="userDivisionHead" class="form-control basic-single">
                                    <option value="">Select HOD</option>
                                    <option value="201">Acharya Ratna Dasa</option>
                                    <option value="3">Chamari Mathaji</option>
                                    <option value="4">Manjari Chandrashekar</option>
                                    <option value="2018">Nandanandana Dasa</option>
                                    <option value="5">Naveena Neerada Dasa</option>
                                    <option value="1">Shyama Vallabha Dasa</option>
                                    <option value="2">Sampati Dasa</option>
                                    <option value="6">Anantha Kirthi Dasa</option>
                                    <option value="7">Prahladeesha Dasa</option>
                                    <option value="TSF-1172">Pradeep Narayan Kalal</option>
                                    <option value="ISK-2302">Ayyappa Dasika</option>
                                    <option value="2076">Bindu Madhava Dasa</option>
                                    <option value="GST-0040">CHANDRA MOULESHWARAN C K</option>
                                    <option value="NIVE-0108">Alok B</option>
                                    <option value="1134">Mohana Chaitanya Dasa</option>
                                    <option value="1402">Vrajeshwara Govinda Dasa</option>
                                    <option value="1">Anirudha Balram Dasa</option>
                                    <option value="1111111">Vaishnava Bandhu Dasa</option>
                                    <option value="101804">Sharadendu Krishna Dasa</option>
                                    <option value="SVST-007">Appanna S K</option>
                                    <option value="111111">Gunabhadra Dasa</option>
                                    <option value="440">Mahotsaha Chaitanya Dasa</option>
                                    <option value="864">Akinchana Chaitanya Dasa</option>
                                    <option value="865">Suguna Krishna Dasa</option>
                                    <option value="868">Hari Bhakta Dasa</option>
                                    <option value="905">Madhava Hari Dasa</option>
                                    <option value="1110">Ratnangada Govinda Dasa</option>
                                    <option value="1128">Kalanidhi Dasa</option>
                                    <option value="ISK-2481">Sunny</option>
                                    <option value="137">Arjuna Sakha Dasa</option>
                                    <option value="102725">Srivigraha Dasa</option>
                                    <option value="102770">Ajay Kavishwar</option>
                                    <option value="102771">Bhakti Lata Devi Dasi</option>
                                    <option value="102772">Mahaprabhu Gauranga Dasa</option>
                                    <option value="102773">Raghukula Nandana Dasa</option>
                                    <option value="102774">Sachi Tanaya Dasa</option>
                                </select>
                                <input type="hidden" name="hod_employee_name" value="" id="addReqUserHODName">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_type" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_type" id="vehicle_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tripType" class="col-sm-5 col-form-label">Trip Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="trip_type" id="tripType" class="form-control">
                                    <option value="">Please Select One</option>
                                    @foreach($trip_types as $trip_type)
                                    <option value="{{$trip_type['TRIP_ID']}}">{{$trip_type['TRIP_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="odometer_start_reading" class="col-sm-5 col-form-label">Odometer at Trip Start </label>
                            <div class="col-sm-7">
                                <input name="odometer_start" class="form-control" type="number" placeholder="Odometer Start KM" id="odometer_start_reading">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="odometer_end_reading" class="col-sm-5 col-form-label">Odometer at Trip End </label>
                            <div class="col-sm-7">
                                <input name="odometer_end" class="form-control" type="number" placeholder="Odometer End KM" id="odometer_end_reading">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_trip_distance" class="col-sm-5 col-form-label">Total Distance (km) </label>
                            <div class="col-sm-7">
                                <input name="total_km" class="form-control" type="number" placeholder="Total Distance (km)" id="total_trip_distance" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_fr" class="col-sm-5 col-form-label">Where From <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_fr" required="" class="form-control" type="text" placeholder="Where From" id="where_fr">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_to" required="" class="col-sm-5 col-form-label">Where To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_to" required="" class="form-control" type="text" placeholder="Where To" id="where_to">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="pickup" class="col-sm-5 col-form-label">Pick Up <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="pickup" class="form-control" type="text" placeholder="Pick Up" id="pickup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_date" class="col-sm-5 col-form-label">Requisition Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_date" class="form-control vnewdatetimepicker" autocomplete="off" type="date" placeholder="Requisition Date" id="req_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_fr" class="col-sm-5 col-form-label">Time From <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input name="time_fr" class="form-control input-small ttimepicker" type="text" placeholder="Time From" id="time_fr" value="" aria-describedby="from_time_clock">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="from_time_clock">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_to" class="col-sm-5 col-form-label">Time To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input name="time_to" class="form-control ttimepicker" type="text" placeholder="Time To" id="time_to" value="" aria-describedby="to_time_clock">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="to_time_clock">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tolerance" class="col-sm-5 col-form-label">Tolerance Duration <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="tolerance" required="" class="form-control" type="text" placeholder="Tolerance Duration" id="tolerance" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label for="purpose" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle">
                                    <option value="" selected="selected">Please Select One</option>

                                </select>
                            </div>
                            <div class="col-sm-12 text-right mt-2">
                                <input type="hidden" name="checkValue" id="checkValue" value="0">
                                <span class="mt-2"><input type="checkbox" id="aloc_checkbox"> &nbsp;Add Allocated
                                    Vehicles</span>
                            </div>
                        </div>
                        <div class="form-group row" id="vehicle_driver" style="display:none;">
                            <label for="vehicle_driver_name" class="col-sm-5 col-form-label">Driver</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="vehicle_driver_name" value="" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nunpassenger" class="col-sm-5 col-form-label">No of Passenger(s) <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="nunpassenger" class="form-control" type="number" placeholder="No of Passenger" id="nunpassenger">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purpose" class="col-sm-5 col-form-label">Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="purpose" id="purpose">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($purpose as $val)
                                    <option value="{{$val->REQUISITION_PURPOSE_ID}}">{{$val->REQUISITION_PURPOSE_NAME}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="details" class="col-sm-5 col-form-label">Details <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="details" required="" class="form-control" type="text" placeholder="Details" id="details">
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Requisition</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form2" action="{{route('edit_requisition')}}" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <input type="hidden" name="id" id="requsition_id" value="">
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="editDepartment" class="col-sm-5 col-form-label">User Department <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="department" id="editDepartment">
                                    <option value="">Please Select One</option>
                                    @foreach($departments['data'] as $department)
                                    <option value="{{$department['deptCode']}}">
                                        {{$department['deptName']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_for2" class="col-sm-5 col-form-label">Requisition For <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="req_for" id="req_for2">
                                    <option value="" selected="selected">Select User</option>
                                    @foreach($empData as $val)
                                    <option value="{{$val['hrEmployeeId']}}">{{$val['employeeName']}}
                                        ({{$val['department']}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="userEntityCode2" class="col-sm-5 col-form-label">User Entity Code <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="user_entity" id="userEntityCode2" class="form-control basic-single">
                                    <option value="">Select User Entity Code</option>
                                    @foreach($entityData as $entity)
                                    <option value="{{$entity['entityCode'] . ' - ' . $entity['entityName']}}">{{$entity['entityCode'] . ' - ' . $entity['entityName']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="userDivisionHead2" class="col-sm-5 col-form-label">User Department HOD <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="hod_employee_id" id="userDivisionHead2" class="form-control basic-single">
                                    <option value="">Select HOD</option>
                                    <option value="201">Acharya Ratna Dasa</option>
                                    <option value="3">Chamari Mathaji</option>
                                    <option value="4">Manjari Chandrashekar</option>
                                    <option value="2018">Nandanandana Dasa</option>
                                    <option value="5">Naveena Neerada Dasa</option>
                                    <option value="1">Shyama Vallabha Dasa</option>
                                    <option value="2">Sampati Dasa</option>
                                    <option value="6">Anantha Kirthi Dasa</option>
                                    <option value="7">Prahladeesha Dasa</option>
                                    <option value="TSF-1172">Pradeep Narayan Kalal</option>
                                    <option value="ISK-2302">Ayyappa Dasika</option>
                                    <option value="2076">Bindu Madhava Dasa</option>
                                    <option value="GST-0040">CHANDRA MOULESHWARAN C K</option>
                                    <option value="NIVE-0108">Alok B</option>
                                    <option value="1134">Mohana Chaitanya Dasa</option>
                                    <option value="1402">Vrajeshwara Govinda Dasa</option>
                                    <option value="1">Anirudha Balram Dasa</option>
                                    <option value="1111111">Vaishnava Bandhu Dasa</option>
                                    <option value="101804">Sharadendu Krishna Dasa</option>
                                    <option value="SVST-007">Appanna S K</option>
                                    <option value="111111">Gunabhadra Dasa</option>
                                    <option value="440">Mahotsaha Chaitanya Dasa</option>
                                    <option value="864">Akinchana Chaitanya Dasa</option>
                                    <option value="865">Suguna Krishna Dasa</option>
                                    <option value="868">Hari Bhakta Dasa</option>
                                    <option value="905">Madhava Hari Dasa</option>
                                    <option value="1110">Ratnangada Govinda Dasa</option>
                                    <option value="1128">Kalanidhi Dasa</option>
                                    <option value="ISK-2481">Sunny</option>
                                    <option value="137">Arjuna Sakha Dasa</option>
                                    <option value="102725">Srivigraha Dasa</option>
                                    <option value="102770">Ajay Kavishwar</option>
                                    <option value="102771">Bhakti Lata Devi Dasi</option>
                                    <option value="102772">Mahaprabhu Gauranga Dasa</option>
                                    <option value="102773">Raghukula Nandana Dasa</option>
                                    <option value="102774">Sachi Tanaya Dasa</option>
                                </select>
                                <input type="hidden" name="hod_employee_name" value="" id="editReqUserHODName">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vehicle_type2" class="col-sm-5 col-form-label">Vehicle Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle_type" id="vehicle_type2">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicle_type as $val)
                                    <option value="{{$val->VEHICLE_TYPE_ID}}">{{$val->VEHICLE_TYPE_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tripType2" class="col-sm-5 col-form-label">Trip Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select name="trip_type" id="tripType2" class="form-control">
                                    <option value="">Please Select One</option>
                                    @foreach($trip_types as $trip_type)
                                    <option value="{{$trip_type['TRIP_ID']}}">{{$trip_type['TRIP_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_odometer_start_reading" class="col-sm-5 col-form-label">Odometer at Trip Start </label>
                            <div class="col-sm-7">
                                <input name="odometer_start" class="form-control" type="text" placeholder="Odometer Start KM" id="edit_odometer_start_reading">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_odometer_end_reading" class="col-sm-5 col-form-label">Odometer at Trip End </label>
                            <div class="col-sm-7">
                                <input name="odometer_end" class="form-control" type="text" placeholder="Odometer End KM" id="edit_odometer_end_reading">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_total_trip_distance" class="col-sm-5 col-form-label">Total Distance (km) </label>
                            <div class="col-sm-7">
                                <input name="total_km" class="form-control" type="text" placeholder="Total distance (KM)" id="edit_total_trip_distance" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_fr2" class="col-sm-5 col-form-label">Where From <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_fr" required="" class="form-control" type="text" placeholder="Where From" id="where_fr2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="where_to2" required="" class="col-sm-5 col-form-label">Where To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="where_to" required="" class="form-control" type="text" placeholder="Where To" id="where_to2">
                            </div>
                        </div>


                    </div>

                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="pickup2" class="col-sm-5 col-form-label">Pick Up <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="pickup" class="form-control" type="text" placeholder="Pick Up" id="pickup2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="req_date2" class="col-sm-5 col-form-label">Requisition Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="req_date" class="form-control vnewdatetimepicker" autocomplete="off" type="date" placeholder="Requisition Date" id="req_date2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_fr2" class="col-sm-5 col-form-label">Time From <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input name="time_fr" class="form-control ttimepicker" type="text" placeholder="Time From" id="time_fr2">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="time_to2" class="col-sm-5 col-form-label">Time To <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <div class="input-group">
                                    <input name="time_to" class="form-control ttimepicker" type="text" placeholder="Time To" id="time_to2">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tolerance2" class="col-sm-5 col-form-label">Tolerance Duration <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="tolerance" required="" class="form-control" type="text" placeholder="Tolerance Duration" id="tolerance2" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <label for="vehicle2" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle2">
                                    <option value="" selected="selected">Please Select One</option>

                                </select>
                            </div>
                            <div class="col-sm-12 text-right mt-2">
                                <input type="hidden" name="checkValue" id="checkValue2" value="0">
                                <span class="mt-2"><input type="checkbox" id="aloc_checkbox2"> &nbsp;Add Allocated
                                    Vehicles</span>
                            </div>
                        </div>
                        <div class="form-group row" id="vehicle_driver2">
                            <label for="vehicle_driver_name2" class="col-sm-5 col-form-label">Driver</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="vehicle_driver_name2" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nunpassenger2" class="col-sm-5 col-form-label">No of Passenger <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="nunpassenger" class="form-control" type="number" placeholder="No of Passenger" id="nunpassenger2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="purpose2" class="col-sm-5 col-form-label">Purpose <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="purpose" id="purpose2">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($purpose as $val)
                                    <option value="{{$val->REQUISITION_PURPOSE_ID}}">{{$val->REQUISITION_PURPOSE_NAME}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="details2" class="col-sm-5 col-form-label">Details <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="details" required="" class="form-control" type="text" placeholder="Details" id="details2">
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="driverModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Driver</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="driverform" action="{{route('add_driver')}}" class="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="drivenby" class="form-label">Driven By <i class="text-danger">*</i></label>
                            <input type="hidden" name="req_id" value="" id="req_id">
                            <select class="form-control basic-single" required="" name="drivenby" id="drivenby">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($driver as $val)
                                <option value="{{$val->DRIVER_ID}}">{{$val->DRIVER_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="statusModal" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Status</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="statusform" action="{{route('update_status')}}" class="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="drivenby" class="form-label">Status <i class="text-danger">*</i></label>
                            <input type="hidden" name="req_id" value="" id="st_req_id">
                            <select class="form-control" required="" name="status" id="status">
                                <option value="" selected="selected">Please Select One</option>
                                <option value="A">Approve</option>
                                <option value="R">Reject</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button type="submit" class="btn btn-success w-md m-b-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="customloader"></div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/vehiclereq_requisition_list.js"></script> -->
<style>
    #dataTable {
        width: 100% !important;
    }

    .customloader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 3px solid #ddd;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: fixed;
        top: 33%;
        right: 56%;
        display: none;
        z-index: 9999;
    }

    @keyframes rotate {
        100% {
            rotate: 360deg;
        }
    }
</style>
<script>
    // For validating that Odometer Start is Less than Odometer End
    $.validator.addMethod('lessThan', function(value, element, param) {
        if (!$(param).val()) return true;
        return this.optional(element) || parseInt(value) < parseInt($(param).val());
    }, "Should be Less than Ending Odometer Reading");

    // For validating that Odometer End is Greater than Odometer Start
    $.validator.addMethod('greaterThan', function(value, element, param) {
        if (!$(param).val()) return true;
        return this.optional(element) || parseInt(value) > parseInt($(param).val());
    }, "Should be Greater than starting Odometer Reading");

    // For validating that Requistion Time From is Less than Requisition Time To
    $.validator.addMethod('timeLessThan', function(value, elem, param) {
        if (!$(param).val()) return true;
        return moment(value, 'LT').isBefore(moment($(param).val(), 'LT'));
    }, 'Should be less than Time To');

    // For validating that Requistion Time To is Greater than Requistion Time From
    $.validator.addMethod('timeGreaterThan', function(value, elem, param) {
        if (!$(param).val()) return true;
        return moment(value, 'LT').isAfter(moment($(param).val(), 'LT'));
    }, 'Should be greater than Time From');

    $(document).ready(function() {
        var table = $("#dataTable");

        $("#add").on('shown.bs.modal', function() {
            $("#time_fr").val('');
            $("#time_to").val('');
            $("#form").trigger('reset');
            // $("#time_fr").timepicker({
            //     // minuteStep: 1,
            //     showInputs: false,
            //     // defaultTime: 'current',
            //     icons: {
            //         up: 'fas fa-chevron-up',
            //         down: 'fas fa-chevron-down'
            //     }
            // });
            // $("#time_to").timepicker({
            //     // minuteStep: 1,
            //     showInputs: false,
            //     // defaultTime: 'cu
            //     icons: {
            //         up: 'fas fa-chevron-up',
            //         down: 'fas fa-chevron-down'
            //     }
            // });

            $("#time_fr").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: false,
                timePickerIncrement: 1,
                autoUpdateInput: false,
                "locale": {
                    "format": "hh:mm A",
                    cancelLabel: 'Clear'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
                picker.container.find('.calendar-time').css('margin-right', '15px');
            });

            $('#time_fr').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('hh:mm A')).trigger('change');
            });
            $('#time_fr').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('').trigger('change');
            });

            $("#time_to").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: false,
                timePickerIncrement: 1,
                autoUpdateInput: false,
                "locale": {
                    "format": "hh:mm A",
                    cancelLabel: 'Clear'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
                picker.container.find('.calendar-time').css('margin-right', '15px');
            });

            $('#time_to').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('hh:mm A')).trigger('change');
            });
            $('#time_to').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('').trigger('change');
            });
        });

        getdata();
        $(document).on('click', '#btn-filter', function(e) {
            $('#dataTable').DataTable().ajax.reload(null, false);
        });

        function getdata() {

            $("#dataTable").DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{route('vehicle-requisitions')}}",
                    data: function(d) {
                        d.req_forsr = $('#req_forsr').val();
                        d.vehicle_typesr = $('#vehicle_typesr').val();
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.status = $('#status').val();
                    }
                },
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'VEHICLE_REQ_ID',
                        name: 'VEHICLE_REQ_ID',
                    },
                    {
                        data: 'req_for',
                        name: 'req_for'
                    },
                    {
                        data: 'req_date',
                        name: 'req_date'
                    },
                    {
                        data: 'driver',
                        name: 'driver'
                    },
                    {
                        data: 'create_by',
                        name: 'create_by'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],

            });
        }

        // To show Driver Name coonected to vehicle on changing vehicle
        $("#vehicle").change(function() {
            // console.log($("#vehicle").find(":selected").attr('data-driver-name'));

            let driverName = $("#vehicle").find(":selected").attr('data-driver-name');
            if (driverName !== '')
                $("#vehicle_driver_name").val(driverName);
            else
                $("#vehicle_driver_name").val('-');
            $("#vehicle_driver").show();
        });

        $('body').on('click', '.driver-modal', function() {
            var val = $(this).data('driverid');
            var id = $(this).data('id');
            $('#drivenby').val(val).trigger('change');
            $('#req_id').val(id);
        });

        $("#userDivisionHead").on('change', function() {
            if ($(this).val() != '') {
                let HODName = $(this).find(':selected').text();
                $("#addReqUserHODName").val(HODName);
            } else {
                $("#addReqUserHODName").val('');
            }
        });

        $("#userDivisionHead2").on('change', function() {
            if ($(this).val() != '') {
                let HODName = $(this).find(':selected').text();
                $("#editReqUserHODName").val(HODName);
            } else {
                $("#editReqUserHODName").val('');
            }
        });

        $("#add").on('hidden.bs.modal', function() {
            $("#form").trigger('reset');
            $("#form .basic-single").val('').change();
            $("#addReqUserHODName").val('');
            $("#form").data('validator').resetForm();
            $("#form .form-control").removeClass('error');
            $("#vehicle_driver").hide();
        });

        $("#edit").on('hidden.bs.modal', function() {
            $("#editReqUserHODName").val('');
            $("#form2 .form-control").removeClass('error');
        });

        $("#driverform").validate({
            rules: {
                drivenby: {
                    required: true,
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    method: form.method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.error == false) {
                            $('#driverform').find('select').val('');
                            $('.basic-single').val('').trigger('change');
                            toastr.success(data.msg);
                            $('#driverModal').modal('hide');
                            $('#dataTable').DataTable().ajax.reload(null, false);
                            // location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error Updating Driver. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });
        $('body').on('click', '.statusModal', function() {
            var id = $(this).data('id');
            $('#st_req_id').val(id);
        });
        $("#statusform").validate({
            rules: {
                status: {
                    required: true,
                },
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    method: form.method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.error == false) {
                            $('#statusform').find('select').val('');
                            toastr.success(data.msg);
                            $('#statusModal').modal('hide');
                            $('#dataTable').DataTable().ajax.reload(null, false);
                            // location.reload();
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error Updating Status. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On changing User Entity in Add Req form, set entity name value to send to server
        $("#userEntityCode").change(function() {
            if ($("#userEntityCode").val() != '')
                $("#addReqUserEntityName").val();
        });

        // On changing/entering Odometer start reading in ADD req. form, check if Odometer End value is present 
        // and calculate distance
        $("#odometer_start_reading").on('change', function() {
            $(this).valid();
            if ($("#odometer_end_reading").val() && $("#odometer_end_reading").valid()) {
                let totalKm = ($("#odometer_end_reading").val() - $("#odometer_start_reading").val());
                $("#total_trip_distance").val(totalKm);
            } else {
                $("#total_trip_distance").val(0);
            }
        });

        // On changing Odometer Ending Reading in ADD Req. Form, check if Start Reading is Present and calculate distance
        $("#odometer_end_reading").on('change', function() {
            $(this).valid();
            if ($("#odometer_start_reading").val() && $("#odometer_start_reading").valid()) {
                let totalKm = ($("#odometer_end_reading").val() - $("#odometer_start_reading").val());
                $("#total_trip_distance").val(totalKm);
            } else {
                $("#total_trip_distance").val(0);
            }
        });

        // On changing Requisition From Time in ADD Form, if To Time is also present, calculate and set Total Tolerance Duration
        $("#time_fr").change(function() {
            if ($("#time_to").val() && $(this).valid() && $("#time_to").valid()) {
                let toleranceDur = calculateToleranceDuration(moment($("#time_fr").val(), 'LT'), moment($("#time_to").val(), 'LT'));
                toleranceHours = toleranceDur.hours();
                toleranceMinutes = toleranceDur.minutes();
                let toleranceDurString = padZero(toleranceHours) + ':' + padZero(toleranceMinutes);
                $("#tolerance").val(toleranceDurString);
            }
        });

        // On changing Requistion To Time in ADD Form, if Time From is present, calculate the tolerance duration as above
        $("#time_to").change(function() {
            if ($("#time_fr").val() && $(this).valid() && $("#time_fr").valid()) {
                let toleranceDur = calculateToleranceDuration(moment($("#time_fr").val(), 'LT'), moment($("#time_to").val(), 'LT'));
                toleranceHours = toleranceDur.hours();
                toleranceMinutes = toleranceDur.minutes();
                let toleranceDurString = padZero(toleranceHours) + ':' + padZero(toleranceMinutes);
                $("#tolerance").val(toleranceDurString);
            }
        });

        $("#form").validate({
            rules: {
                department: {
                    required: true,
                },
                req_for: {
                    required: true,
                },
                vehicle_type: {
                    required: true,
                },
                vehicle: {
                    required: true,
                },
                trip_type: {
                    required: true
                },
                where_fr: {
                    required: true,
                },
                where_to: {
                    required: true,
                },
                pickup: {
                    required: true,
                },
                req_date: {
                    required: true,
                },
                time_fr: {
                    required: true,
                    timeLessThan: '#time_to'
                },
                time_to: {
                    required: true,
                    timeGreaterThan: '#time_fr'
                },
                tolerance: {
                    required: true,
                },
                nunpassenger: {
                    required: true,
                },
                purpose: {
                    required: true,
                },
                details: {
                    required: true,
                },
                odometer_start: {
                    lessThan: '#odometer_end_reading',
                    number: true,
                },
                odometer_end: {
                    greaterThan: '#odometer_start_reading',
                    number: true,
                }
            },
            errorPlacement: function(error, element) {
                $(element).closest('div[class*=col-sm-]').append(error);
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    method: form.method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.error == false) {
                            $('#form').find('input').val('');
                            $('#form').find('select').val('');
                            $('.basic-single').val('').trigger('change');
                            $('#checkValue').val('0');
                            toastr.success(data.msg);
                            $('#add').modal('hide');
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error Adding Booking. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });

        // On changing Requisition From Time in EDIT Form, if To Time is also present, calculate and set Total Tolerance Duration
        $("#time_fr2").change(function() {
            if ($("#time_to2").val() && $(this).valid() && $("#time_to2").valid()) {
                let toleranceDur = calculateToleranceDuration(moment($("#time_fr2").val(), 'LT'), moment($("#time_to2").val(), 'LT'));
                toleranceHours = toleranceDur.hours();
                toleranceMinutes = toleranceDur.minutes();
                let toleranceDurString = padZero(toleranceHours) + ':' + padZero(toleranceMinutes);
                $("#tolerance2").val(toleranceDurString);
            }
        });

        // On changing Requistion To Time in EDIT Form, if Time From is present, calculate the tolerance duration as above
        $("#time_to2").change(function() {
            if ($("#time_fr2").val() && $(this).valid() && $("#time_fr2").valid()) {
                let toleranceDur = calculateToleranceDuration(moment($("#time_fr2").val(), 'LT'), moment($("#time_to2").val(), 'LT'));
                toleranceHours = toleranceDur.hours();
                toleranceMinutes = toleranceDur.minutes();
                let toleranceDurString = padZero(toleranceHours) + ':' + padZero(toleranceMinutes);
                $("#tolerance2").val(toleranceDurString);
            }
        });

        $("#form2").validate({
            rules: {
                department: {
                    required: true,
                },
                req_for: {
                    required: true,
                },
                vehicle_type: {
                    required: true,
                },
                trip_type: {
                    required: true,
                },
                where_fr: {
                    required: true,
                },
                where_to: {
                    required: true,
                },
                pickup: {
                    required: true,
                },
                req_date: {
                    required: true,
                },
                time_fr: {
                    required: true,
                    timeLessThan: '#time_to2'
                },
                time_to: {
                    required: true,
                    timeGreaterThan: '#time_fr2'
                },
                tolerance: {
                    required: true,
                },
                nunpassenger: {
                    required: true,
                },
                purpose: {
                    required: true,
                },
                details: {
                    required: true,
                },
                odometer_start: {
                    lessThan: '#edit_odometer_end_reading',
                    number: true,
                },
                odometer_end: {
                    greaterThan: '#edit_odometer_start_reading',
                    number: true,
                }
            },
            errorPlacement: function(error, element) {
                $(element).closest('div[class*=col-sm-]').append(error);
            },
            submitHandler: function(form, ev) {
                ev.preventDefault();
                $.ajax({
                    url: form.action,
                    method: form.method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: $(form).serialize(),
                    success: function(data) {
                        if (data.error == false) {
                            $('#form2').find('input').val('');
                            toastr.success(data.msg);
                            $('#edit').modal('hide');
                            $('#dataTable').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error(data.msg);
                        }
                    },
                    error: function(jqXHR, textStatus, err) {
                        toastr.error("Error updating. Please try again", '', {
                            closeButton: true
                        });
                    }
                });
            }
        });
        $('body').on('click', '.editModal', function() {
            $('.customloader').show();
            var id = $(this).data('id');
            $('#edit').modal('show');
            $.ajax({
                url: '{{route("get.req.data")}}',
                type: 'get',
                dataType: 'json',
                data: {
                    req_id: id,
                },
                success: function(res) {
                    console.log(res);
                    let selectedUserEntityVal = res.USER_ENTITY_CODE + ' - ' + res.USER_ENTITY_NAME;
                    $('#requsition_id').val(res.VEHICLE_REQ_ID);
                    $('#editDepartment').val(res.DEPT_ID).trigger('change');
                    $('#req_for2').val(res.REQUISITION_FOR).trigger('change');
                    $("#userEntityCode2").val(selectedUserEntityVal).trigger('change');
                    $("#userDivisionHead2").val(res.HOD_EMPLOYEE_ID).trigger('change');
                    $("#editReqUserHODName").val(res.HOD_EMPLOYEE_NAME);
                    $("#tripType2").val(res.TRIP_TYPE);
                    $('#where_fr2').val(res.WHERE_FROM);
                    $('#where_to2').val(res.WHERE_TO);
                    $('#pickup2').val(res.PICK_UP);
                    $('#req_date2').val(res.REQUISITION_DATE);
                    let reqTimeFrom = moment(res.TIME_FROM, 'HH:mm:ss');
                    $('#time_fr2').val(moment(res.TIME_FROM, 'HH:mm:ss').format('LT'));
                    let reqTimeTo = moment(res.TIME_TO, 'HH:mm:ss');
                    $('#time_to2').val(moment(reqTimeTo).format('LT'));
                    let toleranceDur = moment(res.TOLERANCE_DURATION, 'HH:mm:ss');
                    $('#tolerance2').val(moment(toleranceDur).format('HH:mm'));
                    $('#nunpassenger2').val(res.NUMBER_OF_PASSENGER);
                    $('#purpose2').val(res.REQUISITION_PURPOSE_ID).trigger('change');
                    $('#details2').val(res.DETAILS);
                    $('#checkValue2').val(res.IS_CHECK);
                    if (res.IS_CHECK == '1') {
                        $('#aloc_checkbox2').prop('checked', true);
                    } else {
                        $('#aloc_checkbox2').prop('checked', false);
                    }
                    $('#vehicle_type2').val(res.VEHICLE_TYPE_ID).trigger('change');
                    $('#vehicle2').val(res.VEHICLE_ID).trigger('change');
                    $("#vehicle2").attr('data-og-selection', res.VEHICLE_ID);
                    $('#nunpassenger2').attr('max', res.max_num);

                    $("#edit_odometer_start_reading").val(res.ODOMETER_START ? res.ODOMETER_START : '');
                    $("#edit_odometer_end_reading").val(res.ODOMETER_END ? res.ODOMETER_END : '');
                    $("#edit_total_trip_distance").val(res.TOTAL_KM ? res.TOTAL_KM : '');

                    $("#vehicle_driver_name2").val(res.driver_name);
                    $("#vehicle_driver_name2").attr('data-og-val', res.driver_name);

                    // On changing/entering Odometer start reading in EDIT req. form, check if Odometer End value is present 
                    // and calculate distance
                    $("#edit_odometer_start_reading").on('change', function() {
                        $(this).valid();
                        if ($("#edit_odometer_end_reading").val() && $("#edit_odometer_end_reading").valid()) {
                            let totalKm = ($("#edit_odometer_end_reading").val() - $("#edit_odometer_start_reading").val());
                            $("#edit_total_trip_distance").val(totalKm);
                        } else {
                            $("#edit_total_trip_distance").val(0);
                        }
                    });

                    // On changing Odometer Ending Reading in EDIT Req. Form, check if Start Reading is Present and calculate distance
                    $("#edit_odometer_end_reading").on('change', function() {
                        $(this).valid();
                        if ($("#edit_odometer_start_reading").val() && $("#edit_odometer_start_reading").valid()) {
                            let totalKm = ($("#edit_odometer_end_reading").val() - $("#edit_odometer_start_reading").val());
                            $("#edit_total_trip_distance").val(totalKm);
                        } else {
                            $("#edit_total_trip_distance").val(0);
                        }
                    });

                    // If Value is changed, change driver accordingly if different from original selection
                    $("#vehicle2").change(function() {
                        if ($(this).val() != $(this).attr('data-og-selection')) {
                            let driverName = $("#vehicle2").find(":selected").attr('data-driver-name');
                            if (driverName !== '')
                                $("#vehicle_driver_name2").val(driverName);
                            else
                                $("#vehicle_driver_name2").val('-');
                        } else {
                            let originalDriver = $("#vehicle_driver_name2").attr("data-og-val");
                            $("#vehicle_driver_name2").val(originalDriver);
                        }
                    });

                    // $("#time_fr2").timepicker({
                    //     showInputs: false,
                    //     minuteStep: 1,
                    //     icons: {
                    //         up: 'fas fa-chevron-up',
                    //         down: 'fas fa-chevron-down'
                    //     }
                    // });
                    // $("#time_to2").timepicker({
                    //     showInputs: false,
                    //     minuteStep: 1,
                    //     icons: {
                    //         up: 'fas fa-chevron-up',
                    //         down: 'fas fa-chevron-down'
                    //     }
                    // });

                }
            });
        });
        $('body').on('change', '#vehicle_type', function() {
            getVehicle();
        });
        $('body').on('click', '#req_date', function() {
            getVehicle();
        });
        $('body').on('click', '#time_fr', function() {
            getVehicle();
        });
        $('body').on('click', '#time_to', function() {
            getVehicle();
        });
        $('body').on('click', '#aloc_checkbox', function() {
            if ($('#aloc_checkbox').is(':checked') == true) {
                $('#checkValue').val('1');
            } else {
                $('#checkValue').val('0');
            }
            getVehicle();
        });
        $('body').on('click', '#aloc_checkbox2', function() {
            if ($('#aloc_checkbox2').is(':checked') == true) {
                $('#checkValue2').val('1');
            } else {
                $('#checkValue2').val('0');
            }
            geteditVehicle();
        });
        $('body').on('change', '#vehicle_type2', function() {
            geteditVehicle();
        });
        $('body').on('click', '#req_date2', function() {
            geteditVehicle();
        });
        $('body').on('click', '#time_fr2', function() {
            geteditVehicle();
        });
        $('body').on('click', '#time_to2', function() {
            geteditVehicle();
        });

        $("#edit").on('shown.bs.modal', function() {
            $("#time_fr2").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: false,
                timePickerIncrement: 1,
                autoUpdateInput: false,
                "locale": {
                    "format": "hh:mm A",
                    cancelLabel: 'Clear'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
                picker.container.find('.calendar-time').css('margin-right', '15px');
            });

            $('#time_fr2').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('hh:mm A')).trigger('change');
            });
            $('#time_fr2').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('').trigger('change');
            });

            $("#time_to2").daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: false,
                timePickerIncrement: 1,
                autoUpdateInput: false,
                "locale": {
                    "format": "hh:mm A",
                    cancelLabel: 'Clear'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find(".calendar-table").hide();
                picker.container.find('.calendar-time').css('margin-right', '15px');
            });

            $('#time_to2').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('hh:mm A')).trigger('change');
            });
            $('#time_to2').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('').trigger('change');
            });

            // For Previous Bootstrap Timepicker library
            // $("#time_fr2").timepicker('setTime', $("#time_fr2").val());
            // $("#time_to2").timepicker('setTime', $("#time_to2").val());

            // $("#vehicle2").change(function() {
            //     let driverName = $("#vehicle2").find(":selected").attr('data-driver-name');
            //     if (driverName !== '')
            //         $("#vehicle_driver_name2").val(driverName);
            //     else
            //         $("#vehicle_driver_name2").val('-');
            // });
        });

        function getVehicle() {
            var chk = $('#aloc_checkbox').is(':checked');
            var type = $('#vehicle_type').val();
            var rdate = $('#req_date').val();
            var frmt = $('#time_fr').val();
            var tot = $('#time_to').val();
            $.ajax({
                url: '{{route("get.vehicle.data")}}',
                type: 'get',
                dataType: 'html',
                data: {
                    type: type,
                    rdate: rdate,
                    frmt: frmt,
                    tot: tot,
                    checked: chk
                },
                beforeSend: function() {
                    $(".customloader").show();
                },
                success: function(res) {
                    $('#vehicle').html(res);
                },
                complete: function() {
                    $('.customloader').hide();
                }
            });
        }

        function geteditVehicle() {
            var chk = $('#aloc_checkbox2').is(':checked');
            var type = $('#vehicle_type2').val();
            var rdate = $('#req_date2').val();
            var frmt = $('#time_fr2').val();
            var tot = $('#time_to2').val();
            var id = $('#requsition_id').val();

            $.ajax({
                url: '{{route("get.editvehicle.data")}}',
                type: 'get',
                dataType: 'html',
                data: {
                    type: type,
                    rdate: rdate,
                    frmt: frmt,
                    tot: tot,
                    id: id,
                    checked: chk
                },
                success: function(res) {
                    $('#vehicle2').html(res);
                    $.ajax({
                        url: '{{route("get.req.data")}}',
                        type: 'get',
                        dataType: 'json',
                        data: {
                            req_id: id,
                        },
                        beforeSend: function() {
                            $('.customloader').show();
                        },
                        success: function(res) {
                            $('#vehicle2').val(res.VEHICLE_ID).trigger('change');
                            $('.customloader').hide();
                        },
                        error: function() {
                            toastr.error("Could not load vehicles. Please try again", '', {
                                closeButton: true
                            });
                        }
                    });
                }
            });
        }
        $('body').on('change', '#vehicle', function() {
            var selectedOption = $(this).find('option:selected');
            var newLimit = parseInt(selectedOption.attr('data-limit'));
            $('#nunpassenger').attr('max', newLimit);
        });
        $('body').on('change', '#vehicle2', function() {
            var selectedOption = $(this).find('option:selected');
            var newLimit = parseInt(selectedOption.attr('data-limit'));
            $('#nunpassenger2').attr('max', newLimit);
        });
        // Remove validations, errors and reset ADD form on closing modal
        $("#add").on('hidden.bs.modal', function(ev) {
            $("#form").trigger('reset');
            $("#form").validate().resetForm();
        });

        // Remove validations, errors and reset EDIT form on closing modal
        $("#edit").on('hidden.bs.modal', function(ev) {
            $("#form2").trigger('reset');
            $("#form2").validate().resetForm();
        });


    });

    // To calculate Total Tolerance Duration in Add/Edit Requistion Forms
    function calculateToleranceDuration(startTime, endTime) {
        let dur = moment.duration(endTime.diff(startTime));
        return dur;
    }

    // To Pad numbers with 0 if less than 10 and return the string
    function padZero(num) {
        return (num < 10) ? ('0' + num) : '' + num;
    }
</script>
@endsection