@props(['title'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" media="print">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/datatables.min.css')}}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/datatables.fixedcolumns.min.css')}}">

    {{-- Datatable Buttons --}}
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" media="print">

    {{-- Select box CSS --}}
    <link rel="stylesheet" href="{{asset('assets/css/dselect.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/js/moment.js')}}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Fontawesome Icons link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    

</head>

<body>


    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 class="mb-0">Grocery Sales</h3>
                <strong>GS</strong>
            </div>

            <ul class="list-unstyled components">
                @php
                    $role = auth()->user()->systemrole->RoleDesc
                @endphp
                @if ($role == "admin")
                    <li class="active">
                        <a href="/dashboard" aria-expanded="false">
                            <i class="bi bi-speedometer"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#setupSubMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="bi bi-sliders"></i>
                            Setup
                        </a>
                        <ul class="collapse list-unstyled" id="setupSubMenu">
                            <li>
                                <a href="/companyinformation/edit/CI-0001"><span class="me-2"><i class="bi bi-building"></i></span>Company</a>
                            </li>
                            <li>
                                <a href="/customer/index"><span class="me-2"><i class="bi bi-people"></i></span>Customer</a>
                            </li>
                            <li>
                                <a href="/supplier/index"><span class="me-2"><i class="bi bi-people"></i></span>Supplier</a>
                            </li>
                            <li>
                                <a href="/warehouse/index"><span class="me-1"><i class="fa fa-warehouse"></i></span>Warehouse</a>
                            </li>
                            <li>
                                <a href="/category/index"><span class="me-2"><i class="bi bi-grid"></i></span>Category</a>
                            </li>
                            <li>
                                <a href="/unit/index"><span class="me-2"><i class="bi bi-rulers"></i></span>Unit</a>
                            </li>
                            <li>
                                <a href="/item/index"><span class="me-2"><i class="bi bi-boxes"></i></span>Item</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li>
                    <a href="#purchaseSetting" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="bi bi-cart"></i>
                        Purchase
                    </a>
                    <ul class="collapse list-unstyled" id="purchaseSetting">
                        <li>
                            <a href="/itemarrival/index"><span class="me-2"><i class="bi bi-ui-radios"></i></span>Item Arrival</a>
                        </li>
                        <li>
                            <a href="/purchaseinvoices/index"><span class="me-2"><i class="bi bi-list-check"></i></span>Purchase List</a>
                        </li>
                        <li>
                            <a href="/purchaseinvoices/add"><span class="me-2"><i class="bi bi-bag-plus"></i></span>Purchase Invoice</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#saleSetting" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-sack-dollar"></i>
                        Sales
                    </a>
                    <ul class="collapse list-unstyled" id="saleSetting">
                        <li>
                            <a href="/salesinvoices/index"><span class="me-2"><i class="bi bi-list-check"></i></span>Sales List</a>
                        </li>
                        <li>
                            <a href="/salesinvoices/add"><span class="me-2"><i class="bi bi-file-text"></i></span>Sales Invoice</a>
                        </li>
                    </ul>
                </li>
                @if ($role=="admin")
                    <li>
                        <a href="/report/index">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Reports
                        </a>
                        {{-- <ul class="collapse list-unstyled" id="reportSubmenu">
                            <li>
                                <a href="/user/index"><span class="me-2"><i class="bi bi-file-text"></i></span>Item</a>
                            </li>
                            <li>
                                <a href="/customer/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Customer</a>
                            </li>
                            <li>
                                <a href="/supplier/reports"><span class="me-2"><i class="bi bi-file-text"></i></span>Supplier</a>
                            </li>
                        </ul> --}}
                    </li>
                    <li>
                        <a href="#settingSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="bi bi-gear-wide-connected"></i>
                            System
                        </a>
                        <ul class="collapse list-unstyled" id="settingSubmenu">
                            <li>
                                <a href="/user/index"><span class="me-2"><i class="bi bi-people"></i></span>User</a>
                            </li>
                            <li>
                                <a href="/systemrole/index"><span class="me-2"><i class="bi bi-ui-radios"></i></span>Role</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <div class="logout">
                <a href="/logout">
                    <i class="fa fa-right-from-bracket"></i><span class="ms-2">Logout</span>
                </a>
            </div>
            <div class="sidebar-footer">
                <p class="text-muted mb-0">Copyright Hein Zarni &copy; 2023</p>
            </div>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand cust-navbar sticky-top">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn main-btn">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <span class="version">v 0.0.1</span>
                    <div class="ms-auto">
                        <p class="nav-link mb-0">
                            <span class="me-2"><i class="bi bi-person-circle"></i></span>{{auth()->user()->Username}}
                        </p>
                    </div>
                </div>
            </nav>
    
            <x-error name="error"></x-error>

            {{-- @if (session('success'))
                <x-alert type='success'>{{session('success')}}</x-alert>
            @endif

            @if (session('warning'))
                <x-alert type='warning'>{{session('warning')}}</x-alert>
            @endif --}}
            
            {{$slot}}

           

        </div>

    </div>

    <!-- Jquery CDN link -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

    <!-- Bootstrap JS -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Data Tables JS -->
    <script src="{{asset('assets/js/datatables.min.js')}}"></script>

    {{-- Data Tables Button --}}
    <script src="{{asset('assets/js/buttons.dataTables.min.js')}}"></script>

    {{-- Data Tables Fixed Column JS --}}
    <script src="{{asset('assets/js/datatables.fixedcolumns.js')}}"></script>

    {{-- Select JS --}}
    <script src="{{asset('assets/js/dselect.js')}}"></script>

    <script src="{{asset('assets/js/main.js')}}"></script>

    <script src="{{asset('assets/js/toastr.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            if(sessionStorage.getItem('sidebarKey') == 1) {

                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');

                if ($('#sidebar').hasClass('active')) {
                    sessionStorage.setItem('sidebarKey', 1);
                } else {
                    sessionStorage.setItem('sidebarKey', 0);
                }  
                
            }

            $('#sidebarCollapse').on('click', function () {

                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');

                if ($('#sidebar').hasClass('active')) {
                    sessionStorage.setItem('sidebarKey', 1);
                } else {
                    sessionStorage.setItem('sidebarKey', 0);
                }

            });

            toastr.options.timeOut = 5000;
            toastr.options.closeButton = true;
            toastr.options.positionClass = "toast-top-right";
            toastr.options.showMethod = "fadeIn";
            toastr.options.progressBar = true;
            toastr.options.hideMethod = "fadeOut";
            
            @if (Session::has('error'))
                toastr.error('{{Session::get('error')}}');
            @elseif (Session::has('success'))
                toastr.success('{{Session::get('success')}}');
            @elseif (Session::has('warning'))
                toastr.warning('{{Session::get('warning')}}');
            @endif

            if (sessionStorage.getItem('save') == "success") {

                toastr.success('Save successful');

                sessionStorage.removeItem('save');
                
            } else if (sessionStorage.getItem('update') == "success") {

                toastr.success('Update successful');

                sessionStorage.removeItem('update');

            }

        });
        
    </script>
</body>

</html>