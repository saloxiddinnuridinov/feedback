<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{asset('vendor_admin/images/logo/photo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('vendor_admin/images/logo/photo.png')}}" type="image/x-icon">
    <title>"Ipak yoʻli" turizm va madiny meros xalqaro universiteti</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('admin.layouts.simple.css')
    @yield('style')
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="loader">
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-bar"></div>
        <div class="loader-ball"></div>
    </div>
</div>
<!-- Loader ends-->
<!-- tap on top starts-->
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<!-- tap on tap ends-->
<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
    @include('admin.layouts.simple.header')
    <!-- Page Header Ends-->
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('admin.layouts.simple.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            @yield('breadcrumb-title')
                        </div>
                        <div class="col-12 col-sm-6">
                            <ol class="breadcrumb">
                                @yield('breadcrumb-items')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            @yield('content')
            <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('admin.layouts.simple.footer')
        </div>
    </div>
<!-- latest jquery-->
    @include('admin.layouts.simple.script')
<!-- Plugin used-->
</body>
</html>
