<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Vidukathaigal App</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <script scr="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css') }}">

    {{-- <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/profile.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
</head>

<body>
    @include('admin.navbar')
    <!-- ======= Sidebar ======= -->
    @include('admin.sidebar')
    <div id="pre-loader" class="pre-loader is-active">
        <div class="loader">
        </div>
    </div>


    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home List</a></li>
                    <li class="breadcrumb-item active">List of Home Table</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                @endforeach
            </div>
        @endif
        @if (session()->get('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->get('error'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ asset(Auth::guard('admin')->user()->image) }}" alt="Profile"
                                class="rounded-circle">
                            <h2>{{ Auth::guard('admin')->user()->name }}</h2>
                            <h3>{{ Auth::guard('admin')->user()->role }}</h3>
                            @if (Auth::guard('admin')->user()->accountAccessPrivilege == 'system')
                                <div class="social-links mt-2">
                                    <a href="#" data-bs-toggle="tooltip" title="view is ready to use."
                                        class="twitter {{ in_array('view', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}"><i
                                            class="bi bi-person-lines-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Add is ready to use."
                                        class="facebook {{ in_array('add', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}"><i
                                            class="bi bi-person-plus-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Edit is ready to use."
                                        class="instagram {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}"><i
                                            class="bi bi-person-dash-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Delete is ready to use."
                                        class="linkedin {{ in_array('delete', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            fill="currentColor" class="bi bi-person-fill-exclamation"
                                            viewBox="0 0 16 16" style="margin-top: -4px;margin-left: -7px;">
                                            <path
                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4">
                                            </path>
                                            <path
                                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="social-links mt-2">
                                    <a href="#" data-bs-toggle="tooltip" title="view is ready to use."
                                        class="twitter {{ in_array('view', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}"><i
                                            class="bi bi-person-lines-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Add is ready to use."
                                        class="facebook {{ in_array('add', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}"><i
                                            class="bi bi-person-plus-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Edit is ready to use."
                                        class="instagram {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}"><i
                                            class="bi bi-person-dash-fill"></i></a>
                                    <a href="#" data-bs-toggle="tooltip" title="Delete is ready to use."
                                        class="linkedin {{ in_array('delete', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            fill="currentColor" class="bi bi-person-fill-exclamation"
                                            viewBox="0 0 16 16" style="margin-top: -4px;margin-left: -7px;">
                                            <path
                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4">
                                            </path>
                                            <path
                                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered" id="myTabs">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                        Profile</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-settings">Settings</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Change Password</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">About</h5>
                                    <p class="small fst-italic">
                                        Display a list of all users with relevant information such as username, email,
                                        role, and last login
                                    </p>

                                    <h5 class="card-title">Profile Details</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::guard('admin')->user()->name }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ ucfirst(Auth::guard('admin')->user()->email) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Admin Role</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::guard('admin')->user()->role }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Account Access Module</div>
                                        @if (Auth::guard('admin')->user()->accountAccessModule == 'system')
                                            <div class="col-lg-9 col-md-8">
                                                Access to all modules is granted
                                            </div>
                                        @else
                                            @php $module = explode('|',Auth::guard('admin')->user()->accountAccessModule);@endphp
                                            <div class="col-lg-9 col-md-8">
                                                @foreach ($module as $row)
                                                    {{ ucfirst(str_replace('nu', 'nu, ', str_replace('_', ' ', $row))) }}
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Account Access Privilege</div>
                                        @php $module2 = explode('|',Auth::guard('admin')->user()->accountAccessPrivilege);@endphp
                                        <div class="col-lg-9 col-md-8" style="display: -webkit-box;">
                                            {{-- <div class="vl"></div> --}}
                                            <div class="access-card">
                                                @if (Auth::guard('admin')->user()->accountAccessPrivilege == 'system')
                                                    <div
                                                        class="action view {{ in_array('view', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                                        <i class="bi bi-person-lines-fill"></i> View
                                                    </div>
                                                    <div
                                                        class="action add {{ in_array('add', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                                        <i class="bi bi-person-plus-fill"></i> Add
                                                    </div>
                                                    <div
                                                        class="action edit {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                                        <i class="bi bi-person-dash-fill"></i> Edit
                                                    </div>
                                                    <div
                                                        class="action delete {{ in_array('delete', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                            height="21" fill="currentColor"
                                                            class="bi bi-person-fill-exclamation" viewBox="0 0 16 16"
                                                            style="margin-top: -4px;margin-left: -7px;">
                                                            <path
                                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4">
                                                            </path>
                                                            <path
                                                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1">
                                                            </path>
                                                        </svg> Delete
                                                    </div>
                                                    <div
                                                        class="action ddsds {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : 'active' }}">
                                                        <i class="bi bi-person-dash-fill"></i> Active
                                                    </div>
                                                @else
                                                    <div
                                                        class="action view {{ in_array('view', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                                        <i class="bi bi-person-lines-fill"></i> View
                                                    </div>
                                                    <div
                                                        class="action add {{ in_array('add', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                                        <i class="bi bi-person-plus-fill"></i> Add
                                                    </div>
                                                    <div
                                                        class="action edit {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                                        <i class="bi bi-person-dash-fill"></i> Edit
                                                    </div>
                                                    <div
                                                        class="action delete {{ in_array('delete', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="21"
                                                            height="21" fill="currentColor"
                                                            class="bi bi-person-fill-exclamation" viewBox="0 0 16 16"
                                                            style="margin-top: -4px;margin-left: -7px;">
                                                            <path
                                                                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4">
                                                            </path>
                                                            <path
                                                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 0 1 0V11a.5.5 0 0 0-.5-.5m0 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1">
                                                            </path>
                                                        </svg> Delete
                                                    </div>
                                                    <div
                                                        class="action ddsds {{ in_array('edit', explode('|', Auth::guard('admin')->user()->accountAccessPrivilege)) ? 'active' : '' }}">
                                                        <i class="bi bi-person-dash-fill"></i> Active
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form class="forms-sample" role="form" action="{{ route('profileupdate') }}"
                                        method="POST" enctype='multipart/form-data'>
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                                Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img id="previewImage"
                                                    src="{{ asset(Auth::guard('admin')->user()->image) }}"
                                                    alt="Profile">
                                                <div class="pt-2">
                                                    <small class="text-primary">To make changes, click submit after
                                                        changing the image.</small>
                                                    <br>
                                                    <style>
                                                        .bi-upload::before {
                                                            color: #ffffff;
                                                        }
                                                    </style>
                                                    <label for="fileInput" class="btn btn-primary btn-sm"
                                                        title="Upload new profile image">
                                                        <i class="bi bi-upload"></i>
                                                        <input type="file" name="file" id="fileInput"
                                                            class="form-control" style="display: none"
                                                            accept="image/*" onchange="previewFile()">
                                                    </label>
                                                    <a href="#" class="btn btn-danger btn-sm"
                                                        title="Remove my profile image"><i
                                                            class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="name" class="col-md-4 col-lg-3 col-form-label">Full
                                                Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="name" type="text" class="form-control"
                                                    id="name" name="name"
                                                    value="{{ Auth::guard('admin')->user()->name }}">
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label for="email"
                                                class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="text" class="form-control"
                                                    id="email" name="email"
                                                    value="{{ Auth::guard('admin')->user()->email }}">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form><!-- End Profile Edit Form -->

                                </div>

                                <div class="tab-pane fade profile-settings pt-3" id="profile-settings">

                                    <!-- Settings Form -->

                                    @php
                                        $access_list = Auth::guard('admin')->user()->access_list;
                                        $arrauy = explode(',', $access_list);
                                        if (Auth::guard('admin')->user()->role == 'SuperAdmin') {
                                            $sourceEmailForInbox = 1;
                                        } else {
                                            $sender_email = Auth::guard('admin')->user()->sender_email;
                                            $email_array = str_getcsv($sender_email);
                                            $sourceEmailForInbox = 0;
                                        }
                                    @endphp
                                    <div class="row mb-3">
                                        <div class="col-md-4 text-center">
                                            <div
                                                class="sub-main align-items-center justify-content-center align-self-center">

                                                <a href="{{ url('admin/inboxes/1') }}">
                                                    <button disabled type="button" class="button-three"><span
                                                            class="material-icons"> near_me </span><span> Go to
                                                            Inbox</span></button>
                                                </a>
                                            </div>
                                            <small style="color: #7367EF;font-weight: 500;">Click to access your inbox
                                                dashboard</small>
                                        </div>
                                        <div class="col-md-7" style="display: -webkit-box">
                                            <div class="vl"></div>
                                            @if (Auth::guard('admin')->user()->accountAccessModule == 'system')
                                                <div class="row overviews">
                                                    <small class="text-primary">Note *- Super Admins can disable access
                                                        to certain buttons, but they cannot disable their own access
                                                        buttons</small>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="notification" class="label">Notification </label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="notification"
                                                                name="notification"
                                                                {{ in_array('notification', $arrauy) == true || in_array('system', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('notification',this)">
                                                            <label class="slider" for="notification"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="settings" class="label">Settings</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="settings" name="settings"
                                                                {{ in_array('settings', $arrauy) == true || in_array('system', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('settings',this)">
                                                            <label class="slider" for="settings"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="mail" class="label">Mail</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="mail" name="mail"
                                                                {{ in_array('mail', $arrauy) == true || in_array('system', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('mail',this)">
                                                            <label class="slider" for="mail"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="inbox" class="label">Inbox</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="inbox" name="inbox"
                                                                {{ in_array('inbox', $arrauy) == true || in_array('system', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('inbox',this)">
                                                            <label class="slider" for="inbox"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="profile" class="label">Profile Editing</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="profile" name="profile"
                                                                {{ in_array('profile', $arrauy) == true || in_array('system', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('profile',this)">
                                                            <label class="slider" for="profile"></label>
                                                        </div>
                                                    </div>

                                                </div>
                                            @else
                                                <div class="row overviews">
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="notification" class="label">Notification </label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="notification"
                                                                name="notification"
                                                                {{ in_array('notification', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('notification',this)">
                                                            <label class="slider" for="notification"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="settings" class="label">Settings</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="settings" name="settings"
                                                                {{ in_array('settings', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('settings',this)">
                                                            <label class="slider" for="settings"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="mail" class="label">Mail</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="mail" name="mail"
                                                                {{ in_array('mail', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('mail',this)">
                                                            <label class="slider" for="mail"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="inbox" class="label">Inbox</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="inbox" name="inbox"
                                                                {{ in_array('inbox', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('inbox',this)">
                                                            <label class="slider" for="inbox"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-xl-8 col-sm-8">
                                                        <label for="profile" class="label">Profile Editing</label>
                                                    </div>
                                                    <div class="col-md-4 col-xl-4 col-sm-4 mb-1">
                                                        <div class="switch">
                                                            <input type="checkbox" id="profile" name="profile"
                                                                {{ in_array('profile', $arrauy) == true ? 'checked' : '' }}
                                                                onchange="handleSwitchChange('profile',this)">
                                                            <label class="slider" for="profile"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        {{-- <button type="submit" class="btn btn-primary">Save Changes</button> --}}
                                    </div>
                                    <!-- End settings Form -->

                                </div>

                                <div class="tab-pane fade profile-change-password pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form class="forms-sample" role="form" action="{{ route('profileupdate') }}"
                                        method="POST" enctype='multipart/form-data'>
                                        @csrf
                                        <input name="name" type="text" class="form-control" name="name"
                                            value="{{ Auth::guard('admin')->user()->name }}" hidden>
                                        <input name="email" type="text" class="form-control" name="email"
                                            value="{{ Auth::guard('admin')->user()->email }}" hidden>

                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="password" class="form-control" id="currentPassword"
                                                    name="currentPassword" placeholder="Enter a Current Password">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-lg-3 col-form-label">New
                                                Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control"
                                                    id="password" placeholder="Enter a New Password">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="password_confirmation"
                                                class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Enter a Re-enter New Password">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>

    <script>
        // JavaScript for Preloader
        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('pre-loader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
        $(document).ready(function() {
            // Handle tab click event
            $('#myTabs button').on('click', function() {
                // Get the data-bs-target value
                var target = $(this).data('bs-target');

                // Update the URL with the key and value
                var cleanTarget = target.substring(1);

                // Update the URL with the key and value
                history.replaceState(null, null, '?key=' + cleanTarget);
                // Save the selected tab to local storage
                localStorage.setItem('selectedTab', target);
                // Remove active class from all tabs
                $('#myTabs button').removeClass('active');
                location.reload();
                // Add active class to the clicked tab
                $(this).addClass('active');
            });

            // Check if there is a key parameter in the URL
            var urlParams = new URLSearchParams(window.location.search);
            var keyParam = urlParams.get('key');
            // Check if the selected tab is stored in local storage
            var storedTab = localStorage.getItem('selectedTab');

            if (keyParam) {
                // Activate the tab based on the key parameter
                $('#myTabs button[data-bs-target="#' + keyParam + '"]').tab('show');
            } else if (storedTab) {
                // Activate the tab based on the stored value in local storage
                $('#myTabs button[data-bs-target="#' + storedTab + '"]').tab('show');
            }
        });
    </script>

    <script>
        $('#pre-loader').addClass('is-active');
        var preloader = document.getElementById('pre-loader');
        const fadeOutEffect = setInterval(() => {
            if (!preloader.style.opacity) {
                preloader.style.opacity = 0.7;
            }
            if (preloader.style.opacity > 0.7) {
                preloader.style.opacity -= 0.5;
            } else {
                $('#pre-loader').removeClass('is-active');
                $('#pre-loader').addClass('active-is');
            }
        }, 300);

        function previewFile() {
            var preview = document.getElementById('previewImage');
            var fileInput = document.getElementById('fileInput');
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset(Auth::guard('admin')->user()->image) }}";
            }
        }

        function handleSwitchChange(option, switchElement) {
            var isChecked = switchElement.checked;
            // Make an AJAX request to update the value
            $.ajax({
                type: "POST",
                url: "{{ url('admin/update-switch') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    option: option,
                    isChecked: isChecked
                },
                success: function(response) {
                    if (response.message == 1) {
                        if (option == "notification") {
                            $('#toggleButton').show();
                        }
                        Swal.fire({
                            title: "Good job!",
                            text: option.toUpperCase() + " Access successfully updated!",
                            icon: "success"
                        });
                    } else {
                        if (option == "notification") {
                            $('#toggleButton').hide();
                        }
                        Swal.fire({
                            title: "Good job!",
                            text: option.toUpperCase() + " Access successfully updated!",
                            icon: "success"
                        });
                    }
                },
                error: function(error) {
                    Swal.fire({
                        title: "Failed!",
                        text: "You clicked the button!",
                        icon: "error"
                    });
                }
            });
        }
    </script>
    <script>
        $(function() {
            $('.toggle').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var name = status;
                // alert(name);
                test_check(name);

                function test_check(name) {
                    if (name == "1") {
                        $('#check').attr("checked", true);
                        $("#Normal").show();
                        $('#check').attr("checked", false);
                        $("#Normal").show().attr('checked', true);
                    } else if (name == "0") {
                        $('#check').attr("checked", false);
                        $("#Normal").hide();
                        $('#check').attr("checked", true);
                        $("#Normal").hide().attr('checked', false);
                    }

                    if ($('#check').is(':checked')) {
                        $('#check').attr("checked", false);
                        $("#Normal").hide();
                    } else {
                        $('#check').bind('change', function() {
                            if ($(this).is(':checked')) {
                                $('#check').attr("checked", true);
                                $("#Normal").show();
                            }
                        });
                    }
                }
            })
        });
    </script>

</body>

</html>
