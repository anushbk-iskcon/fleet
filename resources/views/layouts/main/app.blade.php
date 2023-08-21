<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Fleet</title>

    <link rel="shortcut icon" href="{{asset('public/img/icons/favicon.ico')}}" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

    <script>
    WebFont.load({
        google: {
            families: [
                'Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap'
            ]
        }
    });
    </script>

    <!-- Datatables bootstrap 4 -->
    <link href="{{asset('public/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Modal component -->
    <link href="{{asset('public/plugins/modals/component.css')}}" rel="stylesheet">

    <!-- Date range Picker 3.0.5 -->
    <link href="{{asset('public/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- Select2 4.0.7 -->
    <link href="{{asset('public/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css')}}" rel="stylesheet">
    <!-- Select -->
    <link href="{{asset('public/dist/css/select.css')}}" rel="stylesheet">
    <!-- iCheck v1.0.2 -->
    <link href="{{asset('public/plugins/icheck/skins/all.css')}}" rel="stylesheet">
    <!-- Bootstrap 4 Toggle -->
    <link href="{{asset('public/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css')}}" rel="stylesheet">
    <!-- Typeahead -->
    <link href="{{asset('public/plugins/typehead/typehead.css')}}" rel="stylesheet">

    <!-- Bootstrap v4.3.1 -->
    <link href="{{asset('public/dist/css/app.min.css')}}" rel="stylesheet">

    <link href="{{asset('public/dist/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('public/dist/css/create_system_role.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('public/plugins/toastr/toastr.css')}}">

    <link href="{{asset('public/dist/css/vehiclereq.css')}}" rel="stylesheet">
    <!-- Multiselected JS -->
    <link href="{{asset('public/plugins/multiselectedjs/jquery.multiselect.css')}}" rel="stylesheet">
    <style>
    .sidebar-nav ul li a i.fa,
    .sidebar-nav ul li a i.fas,
    .sidebar-nav ul li a i.far {
        font-size: 16px !important;
    }
    </style>
    @yield('css-content')


    <!-- jQuery 3.4.1 -->
    <script src="{{asset('public/dist/js/app.min.js')}}"></script>
    <script src="{{asset('public/plugins/multiselectedjs/jquery.multiselect.js')}}"></script>

    <!-- jQuery Validation plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script>
    var baseurl = "http://localhost/fleet/public/";
    </script>
</head>

<body class="fixed">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>

    <div class="wrapper">
        <nav class="sidebar sidebar-bunker">
            <div class="sidebar-header text-center">
                <a href="{{url('dashboard')}}" class="logo">
                    <img src="{{asset('public/img/header-logo.png')}}" alt="Home - Fleet">
                </a>
            </div>
            <!-- 
            <div class="profile-element d-flex align-items-center flex-shrink-0">
                <div class="avatar online">
                    <img src="{{asset('upload/profile/users/' .auth()->user()->PROFILE_IMAGE .'')}}" class="img-fluid rounded-circle" alt="">
                </div>
                <div class="profile-text">
                    <h6 class="m-0">Super Admin</h6>
                </div>
            </div> -->

            <div class="sidebar-body">
                <nav class="sidebar-nav">
                    <ul class="metismenu">
                        @php 
                        $userMenuPermissions = getMenuPermission();
                        $userMenu = getuserMenu();
                        @endphp
                        @foreach($userMenu as $menuItem)
                        @php
                        $subTitles = explode(',', $menuItem->subtitles);
                        $currentMenuTitle = array_shift($subTitles);
                        $urls = explode(',', $menuItem->urls);
                        $currentMenuLink = array_shift($urls);

                        # Collect link text (subtitles) and corresponding URLs into a new array:
                        $menuLinks = array_combine($subTitles, $urls);
                        @endphp
                        @if(count($menuLinks) >= 1)
                        @if($userMenuPermissions[$currentMenuLink]['CAN_READ'] == 'Y')
                        <li class="">
                            <a href="#" class="has-arrow material-ripple">
                                {!! $menuItem->MENU_TITLE !!}
                            </a>
                            <ul class="nav-second-level mm-collapse">

                                @foreach($menuLinks as $subTitle => $url)
                                @if($userMenuPermissions[$url]['CAN_READ'] == 'Y')
                                <li class="{{Route::is($url) ? 'mm-active' : ''}}">
                                    <a href="{{route($url)}}">{!!$subTitle!!}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @else
                        @if($menuItem->urls == 'dashboard')
                        <li class="{{Route::is('dashboard') ? 'mm-active' : ''}}">
                            <a href="{{route('dashboard')}}">
                                {!! $menuItem->MENU_TITLE !!}
                            </a>
                        </li>
                        @else
                        @if($userMenuPermissions[$currentMenuLink]['CAN_READ'] == 'Y')
                        <li class="">
                            <a href="#">
                                {!! $menuItem->MENU_TITLE !!}
                            </a>
                        </li>
                        @endif
                        @endif
                        @endif
                        @endforeach

                    </ul>

                    <!-- Existing Sidebar Menu -->
                    <!-- <li class="mm-active">
                            <a href="{{url('dashboard')}}" aria-expanded="true"><i class="typcn typcn-home-outline mr-2"></i> Dashboard</a>
                        </li>
                        <li class="">
                            <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-group-outline mr-2"></i>Employee Management</a>
                            <ul class="nav-second-level mm-collapse">

                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('employees')}}">Manage Employees</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('positions')}}">Positions</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('departments')}}">Departments</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('drivers.index')}}">Manage Drivers</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('manage-licenses')}}">Manage Licenses</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('driver-performance')}}">Driver Performance</a>
                                </li>
                                <li class="">
                                    <a style="cursor:pointer;" href="{{route('manage-request-approval')}}">Manage Req. Approval</a>
                                </li>

                            </ul>
                        </li>


                        <li class="">
                            <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-social-dribbble mr-2"></i>Vehicle Management</a>
                            <ul class="nav-second-level mm-collapse">

                                <li class="">
                                   <a style="cursor:pointer;" onclick="pageopen('https://vmsdemo.bdtask-demo.com/vehiclemgt/Vehicle_management/index')">Vehicle List</a>
                        {{--
                                   <a style="cursor:pointer;" href="{{route('vehicles')}}">Vehicle List</a> --}}
                        </li>

                        <li class="">
                            <a style="cursor:pointer;" href="{{route('insurance-list')}}">Insurance Details</a>
                        </li>

                        <li class="">
                            <a style="cursor:pointer;" href="{{route('legal-documents')}}">Manage Legal Documents</a>
                        </li>

                        <li class="">
                            <a style="cursor:pointer;" href="{{route('vehicle-reminders')}}">Reminder Details</a>
                        </li>

                    </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-eject-outline mr-2"></i>Vehicle Requisition</a>
                        <ul class="nav-second-level mm-collapse">
                            <li class="" title="Manage Vehicle Requisitions">
                                <a style="cursor:pointer;" href="{{url('vehicle-requisition')}}">Manage Vehicle Requisition</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('vehicle-routes')}}">Vehicle Route Details</a>
                            </li>

                            <li class="" title="Manage Approval Authorities">
                                <a style="cursor:pointer;" href="{{route('vehicle-req-approval-auth')}}">Manage Approval Authorities</a>
                            </li>

                            <li class="" title="Pick &amp; Drop Requisition List">
                                <a style="cursor:pointer;" href="{{route('pick-drop-requisition')}}">Pick &amp; Drop Requisition List</a>
                            </li>
                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-compass mr-2"></i>Maintenance</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('maintenance-requisitions')}}">Maintenance Req. Details</a>
                            </li>

                            <li class="" title="Manage Approval Authorities">
                                <a style="cursor:pointer;" href="{{route('maintenance-approval-authorities')}}">Manage Approval Authorities</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('maintenance-service-list')}}">Maintenance Service List</a>
                            </li>

                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="fas fa-warehouse mr-2"></i>Cost &amp; Inventory</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('manage-expense-types')}}">Manage Expense Type</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('manage-parts')}}">Manage Parts</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('inventory-categories')}}">Categories</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('locations')}}">Locations</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('manage-stocks')}}">Stock Management</a>
                            </li>

                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-ticket mr-2"></i>Purchase &amp; Usage</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{url('purchases')}}">Purchase Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('add-purchase')}}">Add Purchase</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('parts-usages-list')}}">Parts Usages List</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('add-parts-usage')}}">Add Parts Usage</a>
                            </li>

                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-arrow-sync-outline mr-2"></i>Refueling</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{url('refuel-setting')}}">Refuel Setting</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('fuel-stations')}}">Manage Fuel Stations </a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('refuel-requisitions')}}">Refuel Requisition Details</a>
                            </li>

                            <li class="" title="Manage Approval Authorities">
                                <a style="cursor:pointer;" href="{{route('refuel-approval-authorities')}}">Manage Approval Authorities</a>
                            </li>

                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-chart-area-outline mr-2"></i>Reports</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('employee-reports')}}">Employee Report</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('driver-reports')}}">Driver Report</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('vehicle-reports')}}">Vehicle Report</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('vehicle-requisition-reports')}}">Vehicle Requisition</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('renewal-reports')}}">Renewal Report</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('pick-drop-requisition-reports')}}">Pick &amp; Drop Req. List</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('refuel-requisition-reports')}}">Refuel Requisition Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('purchase-details-reports')}}">Purchase Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('expense-details-reports')}}">Expense Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('maintenance-req-reports')}}">Maintenance Req. Details</a>
                            </li>

                        </ul>
                    </li>


                    <li class="">
                        <a class="has-arrow material-ripple" href="#"><i class="typcn icon-default typcn-cog-outline mr-2"></i>System Settings</a>
                        <ul class="nav-second-level mm-collapse">

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('manage-companies')}}">Manage Company</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('recurring-periods')}}">Manage Recurring Periods</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('notification-settings')}}"> Notifications</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('document-type-settings')}}">Document Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('vendor-settings')}}">Manage Vendors</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('vehicle-types')}}">Vehicle Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('requisition-purposes')}}">Requisition Purposes</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('requisition-types')}}">Requisition Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('requisition-phases')}}">Manage Phases</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('maintenance-types')}}">Maintenance Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('priority')}}">Manage Priority</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('service-types')}}">Service Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('fuel-types')}}">Fuel Types</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('trip-types')}}">Trip Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('divisions')}}">Divisions</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('rta-details')}}">RTA Office Details</a>
                            </li>

                            <li class="">
                                <a style="cursor:pointer;" href="{{route('ownership')}}">Manage Ownership</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-label">Admin menu</li>
                    <li class="">
                        <a class="has-arrow material-ripple" href="#">
                            <i class="typcn icon-default typcn-edit mr-2"></i> User </a>
                        <ul class="nav-second-level mm-collapse">
                            <a href="https://vmsdemo.bdtask-demo.com/dashboard/user/form"> -->
                    <!-- <li class=""><a href="{{route('add-user')}}">Add User</a>
                            </li> -->
                    <!-- <a href="https://vmsdemo.bdtask-demo.com/dashboard/user/index"> -->
                    <!-- <li class=""><a href="{{route('manage-users')}}">Manage Users</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="">
                            <a class="has-arrow material-ripple" href="#">
                                <i class="typcn icon-default typcn-edit mr-2"></i>
                                Roles & Permissions
                            </a>
                            <ul class="nav-second-level mm-collapse">
                                <li class="">
                                    <a href="{{route('roles.create')}}">Create Role</a>
                                </li>
                                <li class="">
                                    <a href="{{route('roles.index')}}">Manage Roles</a>
                                </li>
                                <li class="">
                                    <a href="{{route('roles.assign-role-to-user')}}">Assign Role</a>
                                </li>
                                <li class="">
                                    <a href="{{route('roles.user-access-roles')}}">User Access Role Details</a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a href="#"><i class="typcn icon-default typcn-flag-outline mr-2"></i>
                                Language
                            </a>
                        </li>
                        <li class="">
                            <a href="{{route('application-settings')}}">
                                <i class="typcn icon-default typcn-cog-outline mr-2"></i>
                                Application Settings
                            </a>
                        </li>
                    </ul>
                </nav> -->
                    <!-- <div class="ps__rail-x" style="left: 0px; top: 0px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                </div>
                <div class="ps__rail-y" style="top: 0px; height: 159px; right: 0px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 37px;"></div>
                </div> -->

            </div>
        </nav>
        <!-- End Sidebar Menu -->

        <!-- Start Content -->
        <div class="content-wrapper">
            <div class="main-content position-relative">
                <div class="page-loader-wrapper content-loder">
                    <div class="loader">
                        <div class="preloader">
                            <div class="spinner-layer pl-green">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                        <p>Please wait...</p>
                    </div>
                </div>

                <nav class="navbar-custom-menu navbar navbar-expand-lg m-0">
                    <div class="sidebar-toggle-icon" id="sidebarCollapse">
                        sidebar toggle<span></span>
                    </div>

                    <div class="d-flex flex-grow-1">
                        <ul class="navbar-nav flex-row align-items-center ml-auto">
                            <li class="nav-item dropdown user-menu">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    @if(Auth()->user()->PROFILE_IMAGE)
                                    <img src="{{asset('public/upload/profile/users/' .auth()->user()->PROFILE_IMAGE .'')}}"
                                        alt="Profile Picture" class="header-image">
                                    @else
                                    <img src="{{asset('public/upload/profile/default.png')}}" alt="Profile Picture"
                                        class="header-image">
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header d-sm-none">
                                        <a href="" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                                    </div>
                                    <div class="user-header">
                                        <div class="img-user">
                    
                                            @if(Auth()->user()->PROFILE_IMAGE)
                                            <img src="{{asset('public/upload/profile/users/' .auth()->user()->PROFILE_IMAGE .'')}}"
                                                alt="Profile Picture">
                                            @else
                                            <img src="{{asset('public/upload/profile/default.png')}}"
                                                alt="Profile Picture">
                                            @endif
                                        </div>
                                        Super Admin
                                    </div>
                                    <a href="{{url('profile')}}" class="dropdown-item"><i
                                            class="typcn typcn-user-outline"></i> My Profile</a>
                                    <a href="{{route('edit-profile')}}" class="dropdown-item"><i
                                            class="typcn typcn-edit"></i> Edit Profile</a>

                                    <!-- For Logout -->
                                    <form action="{{url('logout')}}" method="post">
                                        @csrf
                                        <button class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign
                                            Out</button>
                                    </form>
                                </div>

                            </li>
                        </ul>

                        <div class="nav-clock">
                            <div class="time">
                                <span class="time-hours"></span>
                                <span class="time-min"></span>
                                <span class="time-sec"></span>
                            </div>
                        </div>
                    </div>

                </nav>

                <div class="content-header row align-items-center m-0" id="bedcumb">
                    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                            @yield('breadcrumb-content')
                            <!-- In the extending view:
                            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                            <li id="moduleName" class="breadcrumb-item active">
                                Dashboard
                            </li> -->
                        </ol>
                    </nav>
                    <div class="col-sm-8 header-title p-0">
                        <div class="media">
                            <div class="header-icon text-success mr-3"><i class="typcn typcn-spiral"></i></div>
                            <div class="media-body">
                                @yield('header-title-media-body')
                                <!-- <h1 class="font-weight-bold" id="moduleName1">Dashboard</h1>
                                <small id="controllerName"></small> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Begin Body Content -->
                <div class="body-content" id="bodycontent">
                    @yield('content')
                </div>
                <!-- End Body Content -->

                <footer class="footer-content">
                    <div class="footer-text d-flex align-items-center justify-content-between">
                        <div class="copy">
                            <?= date('Y') ?>
                            <a href="{{url('dashboard')}}">Fleet</a>
                        </div>
                        <div class="credit"> ISKCON Bangalore </div>
                    </div>
                </footer>
                <div class="overlay">
                </div>
            </div>
            <!-- End Main Content -->

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Wrapper -->

    <div id="toTop" class="btn-top" style="display: block;"><i class="ti-upload"></i></div>

    <!-- ChartJS -->
    <script src="{{asset('public/plugins/chartJs/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('public/plugins/sparkline/sparkline.min.js')}}"></script>

    <script src="{{asset('public/dist/js/pages/dashboard.js')}}"></script>

    <!-- DataTables -->
    <script src="{{asset('public/plugins/datatables/dataTables.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('public/plugins/datatables/data-bootstrap4.active.js')}}"></script>

    <!-- Modal -->
    <script src="{{asset('public/plugins/modals/classie.js')}}"></script>
    <script src="{{asset('public/plugins/modals/modalEffects.js')}}"></script>
    <!-- Moment JS -->
    <script src="{{asset('public/plugins/moment/moment.js')}}"></script>
    <!-- DateRangePicker 3.0.5 -->
    <script src="{{asset('public/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('public/plugins/daterangepicker/daterangepicker.active.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('public/plugins/select2/dist/js/select2.full.js')}}"></script>
    <script src="{{asset('public/dist/js/pages/demo.select2.js')}}"></script>

    <!-- iCheck -->
    <script src="{{asset('public/plugins/icheck/icheck.min.js')}}"></script>
    <!-- Bootstrap 4 Toggle -->
    <script src="{{asset('public/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js')}}"></script>
    <!-- Typeahead -->
    <script src="{{asset('public/plugins/typehead/typeahead.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('public/plugins/toastr/toastr.min.js')}}"></script>

    <script src="{{asset('public/dist/js/sidebar.js')}}"></script>
    <script src="{{asset('public/dist/js/driver_performance.js')}}"></script>

    <!-- JS Content on individual pages -->
    @yield('js-content')
</body>

</html>