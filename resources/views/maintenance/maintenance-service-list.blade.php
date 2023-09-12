@extends('layouts.main.app')

@section('title', 'Maintenance Service List')

@section('css-content')
<style>
    #table-loader {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 6px solid #eee;
        border-top-color: #28a745;
        animation: rotate 1s infinite;
        position: absolute;
        /* top: 20%; */
        right: 50%;
        z-index: 2;
        display: none;
    }

    @keyframes rotate {
        100% {
            rotate: 360deg;
        }
    }
</style>
@endsection

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Maintenance</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Maintenance</h1>
<small id="controllerName">Maintenance Service List</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Maintenance Service</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('maintenance-service-list.add')}}" id="addMaintenanceServiceForm" class="row" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="ser_name" class="col-sm-5 col-form-label">Service Name <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="service_name" required="" class="form-control" type="text" placeholder="Service Name" id="ser_name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serv_type" class="col-sm-5 col-form-label">Service Type <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control" required="" name="service_type" id="serv_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($serviceTypes as $serviceType)
                                    <option value="{{$serviceType['MAINTENANCE_ID']}}">{{$serviceType['MAINTENANCE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label for="track_bydate" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox2" type="checkbox" name="track_bydate">
                                <label for="checkbox2">Track By Date</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row m-0">
                            <label for="fuel_tracking" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox3" type="checkbox" name="fuel_tracking" id="fuel_tracking">
                                <label for="checkbox3">Fuel Tracking</label>
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label for="milage_tracking" class="col-sm-5 col-form-label">&nbsp; </label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox4" type="checkbox" name="milage_tracking">
                                <label for="checkbox4">Milage Tracking</label>
                            </div>
                        </div>

                        <div class="form-group row m-0">
                            <label for="tolerance" class="col-sm-5 col-form-label">&nbsp;</label>
                            <div class="col-sm-7 checkbox checkbox-primary">
                                <input id="checkbox5" type="checkbox" name="is_active">
                                <label for="checkbox5">Is Active</label>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5" id="resetAddFormBtn">Reset</button>
                            <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">
                    Search Here
                    <small class="float-right">
                        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal">
                            <i class="ti-plus" aria-hidden="true"></i>
                            Add Maintenance Service
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="serv_typesr" class="col-sm-4 col-form-label justify-content-start text-left">Service Type </label>
                        <div class="col-sm-8">
                            <select class="form-control basic-single" name="serv_typesr" id="serv_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($serviceTypes as $serviceType)
                                <option value="{{$serviceType['MAINTENANCE_ID']}}">{{$serviceType['MAINTENANCE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="ser_namesr" class="col-sm-4 col-form-label justify-content-start text-left">Service Name</label>
                        <div class="col-sm-8">
                            <input name="ser_namesr" class="form-control" type="text" placeholder="Service Name" id="ser_namesr">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-7 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>Update Maintenance Service </strong>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body editinfo">
                    <form action="{{route('maintenance-service-list.update')}}" id="editMaintenanceServiceForm" method="post" class="row" accept-charset="utf-8">
                        @csrf
                    </form>
                </div>

            </div>

        </div>

    </div>

    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Maintenance Service List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="table-loader"></div>
                    <table id="maintenServiceInfoTable" class="table table-striped table-bordered dt-responsive">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Service Type</th>
                                <th>Service Name</th>
                                <th>Status</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$service->MAINTENANCE_NAME}}</td>
                                <td>{{$service->MAINTENANCE_SERVICE_NAME}}</td>
                                <td>
                                    @if($service->IS_ACTIVE == 'Y')
                                    Active
                                    @else
                                    Inactive
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info mr-1" title="Edit" data-id="{{$service->MAINTENANCE_SERVICE_ID}}" onclick="editInfo(this);"><i class="ti-pencil"></i></button>
                                    @if($service->IS_ACTIVE == 'Y')
                                    <button class="btn btn-danger mr-1" data-id="{{$service->MAINTENANCE_SERVICE_ID}}" onclick="changeActivationStatus(this);" title="Deactivate">
                                        <i class="ti-close"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-success mr-1" data-id="{{$service->MAINTENANCE_SERVICE_ID}}" onclick="changeActivationStatus(this);" title="Activate">
                                        <i class="ti-reload"></i>
                                    </button>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                            <!-- <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>Preventive Maintenance</td>
                                <td>Inspect Struts</td>
                                <td>No</td>
                                <td><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">2</td>
                                <td>Preventive Maintenance</td>
                                <td>Fuel Change</td>
                                <td>No</td>
                                <td><a onclick="editinfo(4)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/4" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">3</td>
                                <td>Repair</td>
                                <td>new</td>
                                <td>No</td>
                                <td><a onclick="editinfo(7)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/7" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">4</td>
                                <td>Repair</td>
                                <td>vbn</td>
                                <td>No</td>
                                <td><a onclick="editinfo(8)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/8" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">5</td>
                                <td>Repair</td>
                                <td>Windscreen Replacement</td>
                                <td>No</td>
                                <td><a onclick="editinfo(9)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/9" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">6</td>
                                <td>Repair</td>
                                <td>Windscreen Replacement</td>
                                <td>No</td>
                                <td><a onclick="editinfo(10)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/10" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">7</td>
                                <td>Preventive Maintenance</td>
                                <td>Entretien</td>
                                <td>No</td>
                                <td><a onclick="editinfo(11)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/11" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1" tabindex="0">8</td>
                                <td>Preventive Maintenance</td>
                                <td>gas</td>
                                <td>Yes</td>
                                <td><a onclick="editinfo(12)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/12" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr>
                            <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">9</td>
                                <td>Preventive Maintenance</td>
                                <td>tank</td>
                                <td>Yes</td>
                                <td><a onclick="editinfo(13)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/maintenance/maintenance/delete_maintservice/13" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
                            </tr> -->

                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js-content')
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/maintenservice_list.js"></script> -->
<script>
    let csrfToken = "{{csrf_token()}}";
    let activationStatusChangeURL = "{{route('maintenance-service-list.update-status')}}";
    let getTableDataURL = "{{route('maintenance-service-list.list')}}";
    let editMaintenServiceURL = "{{route('maintenance-service-list.edit')}}";
</script>
<script src="{{asset('public/dist/js/maintenance/maintenance_services.js')}}">
</script>
@endsection