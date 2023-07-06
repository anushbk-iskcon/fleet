@extends('layouts.main.app')

@section('title', 'Request Approval')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Request Approval</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Manage Request Approval</small>
@endsection

@section('content')
<div id="edit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Change Status</strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body editinfo">
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card mb-3">
            <div class="card-header p-2">
                <h4 class="pl-3">Manage Req. Approval</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="request_approval" class="table display table-bordered table-striped table-hover ">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Requisition Date</th>
                                <th>Requisition Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2019-08-24</td>
                                <td>Vehicle Requisition</td>
                                <td>Reject</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',1,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',1,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',1,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2021-02-11</td>
                                <td>Vehicle Requisition</td>
                                <td>Approved</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',3,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',3,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',3,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>2021-02-25</td>
                                <td>Vehicle Requisition</td>
                                <td>Approved</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',5,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',5,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',5,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2021-03-02</td>
                                <td>Vehicle Requisition</td>
                                <td>Approved</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',6,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',6,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',6,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>2023-02-15</td>
                                <td>Vehicle Requisition</td>
                                <td>Reject</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',8,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',8,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',8,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>2023-04-11</td>
                                <td>Vehicle Requisition</td>
                                <td>Approved</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',9,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',9,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',9,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>2023-03-02</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',10,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',10,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',10,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>0000-00-00</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',11,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',11,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',11,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>2023-03-07</td>
                                <td>Vehicle Requisition</td>
                                <td>Approved</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',12,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',12,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',12,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>2023-03-15</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',13,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',13,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',13,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>2023-03-14</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',14,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',14,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',14,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>2023-03-16</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',15,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',15,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',15,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>2023-03-17</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',16,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',16,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',16,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>2023-03-20</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',17,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',17,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',17,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>2023-03-24</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',18,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',18,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',18,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>2023-04-07</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',20,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',20,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',20,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>2023-04-27</td>
                                <td>Vehicle Requisition</td>
                                <td>Pending</td>

                                <td>
                                    <div class="text-center">
                                        <div class="actions">

                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_requisition',21,'requisitionId')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_requisition',21,'requisitionId')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_requisition',21,'requisitionId')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>2019-09-03</td>
                                <td>Maintenance Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',1,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',1,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',1,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>2019-09-01</td>
                                <td>Maintenance Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',2,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',2,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',2,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>2019-11-16</td>
                                <td>Maintenance Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',3,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',3,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',3,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>21</td>
                                <td>2021-01-26</td>
                                <td>Maintenance Requisition</td>
                                <td>Reject</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',4,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',4,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',4,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td>2021-02-25</td>
                                <td>Maintenance Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',7,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',7,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',7,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>23</td>
                                <td>2021-02-25</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',8,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',8,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',8,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>24</td>
                                <td>2021-02-25</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',9,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',9,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',9,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>25</td>
                                <td>2020-05-05</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',10,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',10,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',10,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>26</td>
                                <td>2023-01-18</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',12,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',12,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',12,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>27</td>
                                <td>2023-02-18</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',13,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',13,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',13,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>28</td>
                                <td>2023-02-22</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',14,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',14,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',14,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>2023-02-23</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',15,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',15,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',15,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>30</td>
                                <td>2023-03-07</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',16,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',16,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',16,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>31</td>
                                <td>2023-03-29</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',17,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',17,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',17,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>32</td>
                                <td>2023-02-22</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',18,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',18,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',18,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>33</td>
                                <td>2023-04-21</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',19,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',19,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',19,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>34</td>
                                <td>2023-03-28</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',20,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',20,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',20,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>35</td>
                                <td>2023-04-20</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',21,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',21,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',21,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>36</td>
                                <td>2023-04-21</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',22,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',22,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',22,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>37</td>
                                <td>2023-04-21</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',23,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',23,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',23,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>38</td>
                                <td>2023-05-04</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',24,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',24,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',24,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>39</td>
                                <td>2023-05-04</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',25,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',25,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',25,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-05-05</td>
                                <td>Maintenance Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_maintenance',26,'maintenanceid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_maintenance',26,'maintenanceid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_maintenance',26,'maintenanceid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>41</td>
                                <td>2019-09-07</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',1,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',1,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',1,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>42</td>
                                <td>2019-08-31</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',2,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',2,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',2,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>43</td>
                                <td>2021-02-15</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',5,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',5,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',5,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>44</td>
                                <td>2021-02-23</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',6,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',6,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',6,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>45</td>
                                <td>2021-02-27</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',7,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',7,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',7,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>46</td>
                                <td>2023-01-20</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',8,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',8,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',8,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>47</td>
                                <td>2023-02-21</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',9,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',9,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',9,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>48</td>
                                <td>2023-03-07</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',10,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',10,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',10,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>49</td>
                                <td>2023-03-10</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',11,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',11,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',11,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>50</td>
                                <td>2023-03-10</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',12,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',12,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',12,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td>2023-03-10</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',13,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',13,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',13,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>52</td>
                                <td>2023-03-10</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',14,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',14,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',14,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>53</td>
                                <td>2023-03-13</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',15,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',15,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',15,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>54</td>
                                <td>2023-03-22</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',16,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',16,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',16,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>55</td>
                                <td>2023-03-30</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',17,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',17,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',17,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>56</td>
                                <td>2023-05-13</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',18,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',18,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',18,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>57</td>
                                <td>2023-05-16</td>
                                <td>Re-Fueling Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_refuel_requisition',19,'refuelreq_id')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_refuel_requisition',19,'refuelreq_id')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_refuel_requisition',19,'refuelreq_id')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2019-08-29</td>
                                <td>Pick Drop Requisition</td>
                                <td>Approved</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',3,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',3,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',3,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2019-09-07</td>
                                <td>Pick Drop Requisition</td>
                                <td>Reject</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',4,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',4,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',4,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2019-11-17</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',5,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',5,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',5,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2021-02-12</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',6,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',6,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',6,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2021-02-23</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',7,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',7,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',7,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2021-02-23</td>
                                <td>Pick Drop Requisition</td>
                                <td>Reject</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',8,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',8,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',8,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-01-25</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',9,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',9,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',9,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-02-02</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',10,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',10,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',10,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-02-18</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',12,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',12,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',12,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-02-18</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',13,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',13,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',13,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-20</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',14,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',14,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',14,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-24</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',15,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',15,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',15,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-27</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',16,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',16,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',16,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-29</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',17,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',17,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',17,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-29</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',18,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',18,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',18,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-03-29</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',19,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',19,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',19,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>40</td>
                                <td>2023-04-07</td>
                                <td>Pick Drop Requisition</td>
                                <td>Pending</td>
                                <td>
                                    <div class="text-center">
                                        <div class="actions">
                                            <div class="dropdown action-item" data-toggle="dropdown">
                                                <a href="#" class="action-item"><i class="ti-more-alt"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a onclick="changestatus('0','tbl_pickdrop_requisition',20,'pickdropreqid')" class="dropdown-item">Pending</a>
                                                    <a onclick="changestatus('1','tbl_pickdrop_requisition',20,'pickdropreqid')" class="dropdown-item">Reject</a>
                                                    <a onclick="changestatus('2','tbl_pickdrop_requisition',20,'pickdropreqid')" class="dropdown-item">Approved</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script src="https://vmsdemo.bdtask-demo.com/assets/dist/js/approval_list.js"></script> -->
<script>
    $(document).ready(function() {
        $("#request_approval").DataTable();
    });
</script>

@endsection