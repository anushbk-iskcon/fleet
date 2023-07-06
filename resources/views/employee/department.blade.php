@extends('layouts.main.app')

@section('title', 'Departments')

@section('breadcrumb-content')
<li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
<li class="breadcrumb-item active" id="moduleName">Employee Management</li>
@endsection

@section('header-title-media-body')
<h1 class="font-weight-bold" id="moduleName1">Employee Management</h1>
<small id="controllerName">Departments</small>
@endsection


@section('content')
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">

        <div class="card">
            <div class="card-header">
                <h4>Department<small class="float-right"> <button type="button" class="btn btn-primary btn-md" data-target="#add" data-toggle="modal"><i class="ti-plus" aria-hidden="true"></i>
                            Add New Department</button>
                        <a href="{{route('manage-departments')}}" class="btn btn-primary">Manage Department</a>
                    </small></h4>
            </div>
            <div class="card-body">
                <table width="100%" class="table table-striped table-bordered nowrap bootstrap4-modal">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Department Name</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd gradeX">
                            <td>1</td>
                            <td>Administration</td>

                        </tr>
                        <tr class="even gradeC">
                            <td>2</td>
                            <td>yhyh</td>

                        </tr>
                        <tr class="odd gradeX">
                            <td>3</td>
                            <td>Rose Water</td>

                        </tr>
                        <tr class="even gradeC">
                            <td>4</td>
                            <td>Computer</td>

                        </tr>
                        <tr class="odd gradeX">
                            <td>5</td>
                            <td>Testing</td>

                        </tr>
                        <tr class="even gradeC">
                            <td>6</td>
                            <td>Planning department</td>

                        </tr>
                        <tr class="odd gradeX">
                            <td>7</td>
                            <td>mmkmk</td>

                        </tr>
                        <tr class="even gradeC">
                            <td>8</td>
                            <td>Technical</td>

                        </tr>
                        <tr class="odd gradeX">
                            <td>9</td>
                            <td>Marketing & Sales</td>

                        </tr>
                        <tr class="even gradeC">
                            <td>10</td>
                            <td>Human Resource</td>

                        </tr>
                        <tr class="odd gradeX">
                            <td>11</td>
                            <td>Accounting</td>

                        </tr>
                    </tbody>
                </table> <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>


<div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-green text-white">
                <center><strong>
                        <h4><i class='fa fa-university' aria-hidden='true'></i> Department Form</h4>
                    </strong></center>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="card">
                            <div class="card-heading">
                            </div>
                            <div class="card-body">
                                <form action="" method="post" accept-charset="utf-8">
                                    <div class="form-group row">
                                        <label for="department_name" class="col-sm-4 col-form-label">
                                            Department Name<i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <input type="text" required="" name="department_name" class=" form-control" placeholder="Department Name">
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="reset" class="btn btn-primary w-md m-b-5">Reset</button>
                                        <button type="submit" class="btn btn-success w-md m-b-5">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">

        </div>

    </div>

</div>


@endsection