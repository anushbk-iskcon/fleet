@extends('layouts.main.app')

@section('title', 'Legal Documents')

@section('css-content')
<style>
    div.error {
        font-size: .8em;
        color: #f66;
    }

    select.error~.select2 .select2-selection {
        border: 1px solid #f99;
    }

    div.file-upload-container {
        display: flex;
        flex-wrap: wrap;
    }
</style>
@endsection

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Vehicle Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Vehicle Management</h1>
<small id="controllerName">Manage Legal Documents</small>
@endsection

@section('content')

<div id="add0" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add Legal Documentation</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{route('legal-documents.add')}}" id="addLegalDocumentForm" class="row" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="document_type" class="col-sm-5 col-form-label">Document Type </label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" name="document_type" id="document_type">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($documentTypes as $documentType)
                                    <option value="{{$documentType['DOCUMENT_TYPE_ID']}}">{{$documentType['DOCUMENT_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vehicle" class="col-sm-5 col-form-label">Vehicle <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vehicle" id="vehicle">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="last_issue_date" class="col-sm-5 col-form-label">Last Issue Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="last_issue_date" autocomplete="off" required="" class="form-control newdatetimepicker" type="text" placeholder="Last Issue Date" id="last_issue_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expire_date" class="col-sm-5 col-form-label">Expire Date <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="expire_date" required="" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date" id="expire_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="charge_paid" class="col-sm-5 col-form-label">Charge Paid <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="charge_paid" class="form-control" type="number" placeholder="Charge Paid" id="charge_paid">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vendor" class="col-sm-5 col-form-label">Vendor <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="vendor" id="vendor">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($vendors as $vendor)
                                    <option value="{{$vendor['VENDOR_ID']}}">{{$vendor['VENDOR_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="form-group row">
                            <label for="commission" class="col-sm-5 col-form-label">Commission <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <input name="commission" required="" class="form-control" type="number" placeholder="Commission" id="commission">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notification_before" class="col-sm-5 col-form-label">Notification Before <i class="text-danger">*</i></label>
                            <div class="col-sm-7">
                                <select class="form-control basic-single" required="" name="notification_before" id="notification_before">
                                    <option value="" selected="selected">Please Select One</option>
                                    @foreach($notifTypes as $notifType)
                                    <option value="{{$notifType['NOTIFICATION_TYPE_ID']}}">{{$notifType['NOTIFICATION_TYPE_NAME']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">Email </label>
                            <div class="col-sm-2">
                                <div class="form-check form-check-inline">
                                    <input id="emailCheckbox" class="form-check-input" name="is_email" type="checkbox" data-toggle="toggle" data-style="mr-1">
                                    <label for="emailCheckbox" class="form-check-label">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input name="email" class="form-control" type="email" placeholder="Email" id="email" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">SMS </label>
                            <div class="col-sm-2">
                                <div class="form-check form-check-inline">
                                    <input id="smsCheckbox" class="form-check-input" type="checkbox" name="is_sms" data-toggle="toggle" data-style="mr-1">
                                    <label for="smsCheckbox" class="form-check-label">&nbsp;</label>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <input name="sms" class="form-control" type="text" placeholder="SMS" id="sms" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document_attachment" class="col-sm-5 col-form-label">Document Attachment</label>
                            <div class="col-sm-7 file-upload-container">
                                <input name="document_attachment" type="file" accept="image/*, application/pdf" />
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

<div id="edit" class="modal fade bd-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Update Legal Documentation</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">

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
                            Add Legal Documentation
                        </button>
                    </small>
                </h4>
            </div>
            <div class="card-body row">
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="vehiclesr" class="col-sm-5 col-form-label justify-content-start text-left">Vehicles </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="vehiclesr" id="vehiclesr">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{$vehicle['VEHICLE_ID']}}">{{$vehicle['VEHICLE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="document_typesr" class="col-sm-5 col-form-label justify-content-start text-left">Document Type </label>
                        <div class="col-sm-7">
                            <select class="form-control basic-single" name="document_typesr" id="document_typesr">
                                <option value="" selected="selected">Please Select One</option>
                                @foreach($documentTypes as $documentType)
                                <option value="{{$documentType['DOCUMENT_TYPE_ID']}}">{{$documentType['DOCUMENT_TYPE_NAME']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <label for="exp_date_fr" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date From </label>
                        <div class="col-sm-7">
                            <input name="exp_date_fr" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date From" id="exp_date_fr">
                        </div>
                    </div>
                    <div class="form-group row mb-1">
                        <label for="exp_date_to" class="col-sm-5 col-form-label justify-content-start text-left">Expire Date To </label>
                        <div class="col-sm-7">
                            <input name="exp_date_to" autocomplete="off" class="form-control newdatetimepicker" type="text" placeholder="Expire Date To" id="exp_date_to">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4">
                    <div class="form-group row mb-1">
                        <div class="col-sm-8 text-right">
                            <button type="button" class="btn btn-success" id="btn-filter">Search</button>&nbsp;
                            <button type="button" class="btn btn-inverse" id="btn-reset">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Legal Documentation List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="legalDocumentsTable" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Document Type</th>
                                <th>Vehicle</th>
                                <th>Last Issue Date</th>
                                <th>Expire Date</th>
                                <th>Vendor</th>
                                <th>Commission</th>
                                <th>Notification Before</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- <tr role="row" class="odd">
                                <td class="sorting_1" tabindex="0">1</td>
                                <td>NID</td>
                                <td>Nissan</td>
                                <td>2021-02-01</td>
                                <td>2021-02-24</td>
                                <td>Abc</td>
                                <td>6787</td>
                                <td>1 Month</td>
                                <td style="display: none;"><input name="url" type="hidden" id="url_3" value="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/updatedocumentfrm"><a onclick="editinfo(3)" style="cursor:pointer;color:#fff;" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="Update"><i class="ti-pencil"></i></a><a href="https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/delete_documentation/3" onclick="return confirm('Are you sure ?') " class="btn btn-xs btn-danger btn-sm mr-1"><i class="ti-trash"></i></a></td>
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
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/documentation_list.js"></script> -->
<script>
    // Routes and other information
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let documentsListURL = "{{route('legal-documents.list')}}";
    let getDetailsURL = "{{route('legal-documents.details')}}";
    let changeActivationURL = "{{route('legal-documents.change-activation')}}";
    let updateDetailsURL = "{{route('legal-documents.update')}}";

    // Converting JSON returned from Laravel controller for use in External JS
    let vehicles = JSON.parse(`{!! json_encode($vehicles) !!}`);
    let documentTypes = JSON.parse(`{!! json_encode($documentTypes) !!}`);
    let vendors = JSON.parse(`{!! json_encode($vendors) !!}`);
    let notificationTypes = JSON.parse(`{!! json_encode($notifTypes) !!}`);

    let documentsPath = "{{asset('public/upload/documents/legal/')}}";
</script>
<script src="{{asset('public/dist/js/vehicles/legal_documents.js')}}">
</script>
@endsection