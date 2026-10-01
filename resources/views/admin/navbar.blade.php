<!-- ======= Header ======= -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
    rel="stylesheet">


<style>
    .header {
        background: #7367EF !important;
        color: #ffffff;
        height: 65px;
        border-radius: 5px !important;
        box-shadow: 0 0 10px 2px rgba(115, 103, 240, 0.7) !important;
        cursor: pointer !important;
        transition: all ease-in-out 500ms !important;
    }

    .header[data-background-color=blue2] {
        background: #7367EF !important
    }

    .bi-list::before {
        content: "\f479";
        color: white;
    }

    .header-nav .nav-profile span {
        color: white;
    }

    .logo span {
        color: #ffffff;
    }

    .icon-button {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: #7367EF;
        color: #ffffff;
        border: none;
        outline: none;
        border-radius: 50%;
        padding-right: 24px !important;
    }

    .icon-button:hover {
        cursor: pointer;
    }

    .icon-button:active {
        background: #7367EF;
        color: #ffffff;
    }

    .icon-button__badge {
        height: 20px;
        line-height: 16px;
        font-size: 10px;
        font-weight: 700;
        border: 2px solid #fff;
        padding: 0 2px;
        position: absolute;
        top: -4px;
        right: 4px;
        background: #ff002a;
        color: white;
        border-radius: 4px;
        transform: scale(1.1);
    }

    .logo img {
        max-height: 40px;
        margin-right: -1px;
    }
</style>

<style>
    body {
        background: #dee2e6 !important;
        color: #263238;
        font-family: 'Noto Sans', sans-serif !important;
        font-size: 17px !important;
        margin: 0;
    }
    #main, #footer{
        background: #dee2e6 !important;
    }
</style>


<!-- Fonts and icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js" integrity="sha512-v/wOVTkoU7mXEJC3hXnw9AA6v32qzpknvuUF6J2Lbkasxaxn2nYcl+HGB7fr/kChGfCqubVr1n2sq1UFu3Gh1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Lato:300,400,700,900"]
        },
        custom: {
            "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                "simple-line-icons"
            ],
            urls: ['../assets/css/fonts.min.css']
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<!-- Line Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
    rel="stylesheet">

<style>
    :focus {
        outline: 0 !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important
    }

    .alert,
    .brand,
    .btn-simple,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6,
    .navbar,
    .td-name,
    a,
    body,
    button.close,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    td {
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        font-family: Lato, sans-serif
    }

    body {
        font-size: 16px;
        color: #575962
    }

    body {
        min-height: 100vh;
        position: relative;
        background: #f9fbfd
    }


    .form-floating-label {
        position: relative
    }

    .form-floating-label .placeholder {
        position: absolute;
        padding: .375rem .75rem;
        transition: all .2s;
        opacity: .8;
        margin-bottom: 0 !important;
        font-size: 14px !important;
        font-weight: 400;
        top: 12px
    }

    .form-floating-label .form-control.filled+.placeholder,
    .form-floating-label .form-control:focus+.placeholder,
    .form-floating-label .form-control:valid+.placeholder {
        font-size: 85% !important;
        transform: translate3d(0, -10px, 0);
        top: 0;
        opacity: 1;
        padding: .375rem 0 .75rem;
        font-weight: 600
    }

    .form-floating-label .form-control.filled+.placeholder {
        color: #1572e8 !important
    }

    .form-floating-label .form-control ::-webkit-input-placeholder {
        color: transparent
    }

    .form-floating-label .form-control :-moz-placeholder {
        color: transparent
    }

    .form-floating-label .form-control ::-moz-placeholder {
        color: transparent
    }

    .form-floating-label .form-control :-ms-input-placeholder {
        color: transparent
    }

    .form-floating-label .input-border-bottom+.placeholder {
        padding: .375rem 0 .75rem
    }

    .form-inline label {
        margin-bottom: 0 !important;
        display: flow-root
    }

    .col-form-label {
        font-size: 16px;
        font-weight: 600;
    }


    .alert {
        border: 0;
        position: relative;
        padding: .95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        background-color: #fff;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26)
    }

    .alert [data-notify=icon] {
        display: block
    }

    .alert [data-notify=icon]::before {
        line-height: 35px;
        font-size: 22px;
        display: block;
        left: 15px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 35px;
        height: 35px;
        border-radius: 30px;
        text-align: center;
        color: #fff
    }

    .alert [data-notify=title] {
        display: block;
        color: #2b2b2b;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 5px
    }

    .alert [data-notify=message] {
        font-size: 13px;
        color: #908e8e
    }

    .alert .close {
        background: rgba(255, 255, 255, .8);
        width: 25px;
        height: 25px;
        line-height: 25px;
        top: 12px !important;
        border-radius: 50%
    }

    .alert-default {
        border-left: 4px solid #1a2035
    }

    .alert-default [data-notify=icon]:before {
        background: #1a2035
    }

    .alert-primary {
        border-left: 4px solid #1572e8
    }

    .alert-primary [data-notify=icon]:before {
        background: #1572e8
    }

    .alert-secondary {
        border-left: 4px solid #6861ce
    }

    .alert-secondary [data-notify=icon]:before {
        background: #6861ce
    }

    .alert-info {
        border-left: 4px solid #48abf7
    }

    .alert-info [data-notify=icon]:before {
        background: #48abf7
    }

    .alert-success {
        border-left: 4px solid #31ce36
    }

    .alert-success [data-notify=icon]:before {
        background: #31ce36
    }

    .alert-warning {
        border-left: 4px solid #ffad46
    }

    .alert-warning [data-notify=icon]:before {
        background: #ffad46
    }

    .alert-danger {
        border-left: 4px solid #f25961
    }

    .alert-danger [data-notify=icon]:before {
        background: #f25961
    }

    .btn {
        padding: .65rem 1.4rem;
        font-size: 14px;
        opacity: 1;
        border-radius: 3px
    }

    .btn:focus,
    .btn:hover {
        opacity: .9;
        transition: all .3s
    }

    .btn .btn-label {
        display: inline-block
    }

    .btn .btn-label i {
        font-size: 16px;
        vertical-align: middle;
        margin-right: 2px;
        margin-left: -2px;
        line-height: 0;
        margin-top: -2.5px
    }

    .btn .btn-label.just-icon i {
        margin-left: 0 !important;
        margin-right: 0 !important
    }

    .btn-lg {
        font-size: 15px;
        border-radius: 3px;
        padding: 12.5px 27.5px;
        font-weight: 400
    }

    .btn-lg .btn-label i {
        font-size: 27px;
        vertical-align: middle;
        margin-right: 2px;
        margin-left: -7px;
        line-height: 0;
        margin-top: -2.5px
    }

    .btn-lg .btn-label.just-icon i {
        margin-left: 0 !important;
        margin-right: 0 !important
    }

    .btn-sm {
        font-size: 11px;
        padding: 7px 13px
    }

    .btn-xs {
        font-size: 10px;
        padding: 5px 9px
    }

    .btn.disabled:hover,
    .btn:hover:disabled {
        opacity: .65
    }

    .btn-icon {
        font-size: .9375rem;
        height: 2.5125rem;
        line-height: normal;
        min-width: 2.5125rem;
        overflow: hidden;
        padding: 0;
        position: relative;
        width: 2.5125rem
    }

    .btn-icon.btn-lg {
        height: 2.75rem;
        min-width: 2.75rem;
        width: 2.75rem
    }

    .btn-icon.btn-sm {
        height: 2rem;
        min-width: 2rem;
        width: 2rem
    }

    .btn-icon.btn-xs {
        height: 1.6875rem;
        min-width: 1.6875rem;
        width: 1.6875rem
    }

    .btn-white {
        background: #fff !important;
        color: #1a2035 !important
    }

    .btn-white:disabled,
    .btn-white:focus,
    .btn-white:hover {
        background: #fff !important;
        color: #1a2035 !important
    }

    .btn-default {
        background: #1a2035 !important;
        color: #fff !important
    }

    .btn-default:disabled,
    .btn-default:focus,
    .btn-default:hover {
        background: #1a2035 !important;
        color: #fff !important
    }

    .btn-primary {
        background: #1572e8 !important;
        border-color: #1572e8 !important
    }

    .btn-primary:disabled,
    .btn-primary:focus,
    .btn-primary:hover {
        background: #1572e8 !important;
        border-color: #1572e8 !important
    }

    .btn-secondary {
        background: #6861ce !important;
        border-color: #6861ce !important
    }

    .btn-secondary:disabled,
    .btn-secondary:focus,
    .btn-secondary:hover {
        background: #6861ce !important;
        border-color: #6861ce !important
    }

    .btn-info {
        background: #48abf7 !important;
        border-color: #48abf7 !important
    }

    .btn-info:disabled,
    .btn-info:focus,
    .btn-info:hover {
        background: #48abf7 !important;
        border-color: #48abf7 !important
    }

    .btn-success {
        background: #31ce36 !important;
        border-color: #31ce36 !important
    }

    .btn-success:disabled,
    .btn-success:focus,
    .btn-success:hover {
        background: #31ce36 !important;
        border-color: #31ce36 !important
    }

    .btn-warning {
        background: #ffad46 !important;
        border-color: #ffad46 !important;
        color: #fff !important
    }

    .btn-warning:disabled,
    .btn-warning:focus,
    .btn-warning:hover {
        background: #ffad46 !important;
        border-color: #ffad46 !important;
        color: #fff !important
    }

    .btn-danger {
        background: #f25961 !important;
        border-color: #f25961 !important
    }

    .btn-danger:disabled,
    .btn-danger:focus,
    .btn-danger:hover {
        background: #f25961 !important;
        border-color: #f25961 !important
    }

    .btn-light {
        background: #fff !important;
        border-color: transparent
    }

    .btn-light:disabled,
    .btn-light:focus,
    .btn-light:hover {
        background: #ebecec !important;
        border-color: transparent
    }

    .btn-dropdown-card-header {
        padding: 0;
        background: 0 0;
        color: inherit;
        font-size: 15px
    }

    .btn-dropdown-card-header:after {
        display: none
    }

    .btn-border {
        background: 0 0 !important
    }

    .btn-border:focus,
    .btn-border:hover {
        background: 0 0 !important
    }

    .btn-border.btn-white {
        color: #fff !important;
        border: 1px solid #fff !important
    }

    .btn-border.btn-default {
        color: #1a2035 !important;
        border: 1px solid #1a2035 !important
    }

    .btn-border.btn-primary {
        color: #1572e8 !important;
        border: 1px solid #1572e8 !important
    }

    .btn-border.btn-secondary {
        color: #6861ce !important;
        border: 1px solid #6861ce !important
    }

    .btn-border.btn-info {
        color: #48abf7 !important;
        border: 1px solid #48abf7 !important
    }

    .btn-border.btn-success {
        color: #31ce36 !important;
        border: 1px solid #31ce36 !important
    }

    .btn-border.btn-warning {
        color: #ffad46 !important;
        border: 1px solid #ffad46 !important
    }

    .btn-border.btn-danger {
        color: #f25961 !important;
        border: 1px solid #f25961 !important
    }

    .btn-border.btn-light {
        border: 1px solid #efefef;
        background: #fff !important
    }

    .btn-round {
        border-radius: 100px !important
    }

    .btn-link {
        border: 0 !important;
        background: 0 0 !important
    }

    .btn-link:focus,
    .btn-link:hover {
        text-decoration: underline !important;
        background: 0 0 !important;
        border: 0 !important
    }

    .btn-link.btn-default {
        color: #1a2035 !important
    }

    .btn-link.btn-default:hover {
        color: #1a2035 !important
    }

    .btn-link.btn-primary {
        color: #1572e8 !important
    }

    .btn-link.btn-primary:hover {
        color: #1572e8 !important
    }

    .btn-link.btn-secondary {
        color: #6861ce !important
    }

    .btn-link.btn-secondary:hover {
        color: #6861ce !important
    }

    .btn-link.btn-info {
        color: #48abf7 !important
    }

    .btn-link.btn-info:hover {
        color: #48abf7 !important
    }

    .btn-link.btn-success {
        color: #31ce36 !important
    }

    .btn-link.btn-success:hover {
        color: #31ce36 !important
    }

    .btn-link.btn-warning {
        color: #ffad46 !important
    }

    .btn-link.btn-warning:hover {
        color: #ffad46 !important
    }

    .btn-link.btn-danger {
        color: #f25961 !important
    }

    .btn-link.btn-danger:hover {
        color: #f25961 !important
    }

    .toggle-on.btn {
        color: #fff !important
    }

    .toggle-handle {
        background: #fff !important
    }

    .toggle-handle:hover {
        background: #fff !important
    }

    .btn-round .toggle-handle {
        border-radius: 50px
    }

    .btn-rounded {
        border-radius: 60px !important
    }

    .btn-full {
        width: 100%
    }

    .btn-no-radius {
        border-radius: 0
    }

    table.dataTable {
        clear: both;
        margin-top: 15px !important;
        margin-bottom: 15px !important;
        max-width: none !important;
        border-collapse: separate !important
    }

    table.dataTable td,
    table.dataTable th {
        -webkit-box-sizing: content-box;
        box-sizing: content-box
    }

    table.dataTable td.dataTables_empty,
    table.dataTable th.dataTables_empty {
        text-align: center
    }

    table.dataTable.nowrap td,
    table.dataTable.nowrap th {
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_length label {
        font-weight: 400;
        text-align: left;
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 75px;
        display: inline-block
    }

    div.dataTables_wrapper div.dataTables_filter {
        text-align: right
    }

    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: 400;
        white-space: nowrap;
        text-align: left
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: .5em;
        display: inline-block;
        width: auto
    }

    div.dataTables_wrapper div.dataTables_info {
        padding-top: .85em;
        white-space: nowrap
    }

    div.dataTables_wrapper div.dataTables_paginate {
        margin: 0;
        white-space: nowrap;
        text-align: right
    }

    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        margin: 2px 0;
        white-space: nowrap;
        justify-content: flex-end
    }

    div.dataTables_wrapper div.dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        margin-left: -100px;
        margin-top: -26px;
        text-align: center;
        padding: 1em 0
    }

    table.dataTable thead>tr>td.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc {
        padding-right: 30px
    }

    table.dataTable thead>tr>td:active,
    table.dataTable thead>tr>th:active {
        outline: 0
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_asc_disabled,
    table.dataTable thead .sorting_desc,
    table.dataTable thead .sorting_desc_disabled {
        cursor: pointer;
        position: relative
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        position: absolute;
        bottom: .9em;
        display: block;
        opacity: .5
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:before {
        right: 1em;
        content: "\2191";
        font-size: 15px
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc_disabled:after {
        right: .5em;
        content: "\2193";
        font-size: 15px
    }

    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:after {
        opacity: 1
    }

    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
        opacity: 0
    }

    div.dataTables_scrollHead table.dataTable {
        margin-bottom: 0 !important
    }

    div.dataTables_scrollBody table {
        border-top: none;
        margin-top: 0 !important;
        margin-bottom: 0 !important
    }

    div.dataTables_scrollBody table thead .sorting:after,
    div.dataTables_scrollBody table thead .sorting_asc:after,
    div.dataTables_scrollBody table thead .sorting_desc:after {
        display: none
    }

    div.dataTables_scrollBody table tbody tr:first-child td,
    div.dataTables_scrollBody table tbody tr:first-child th {
        border-top: none
    }

    div.dataTables_scrollFoot>.dataTables_scrollFootInner {
        box-sizing: content-box
    }

    div.dataTables_scrollFoot>.dataTables_scrollFootInner>table {
        margin-top: 0 !important;
        border-top: none
    }

    @media screen and (max-width: 767px) {

        div.dataTables_wrapper div.dataTables_filter,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_length,
        div.dataTables_wrapper div.dataTables_paginate {
            text-align: center;
            margin-top: 11px;
            margin-bottom: 10px
        }

        div.dataTables_wrapper div div.dataTables_paginate ul.pagination {
            flex-wrap: wrap !important;
            justify-content: center !important
        }

        div.dataTables_wrapper div div.dataTables_paginate ul.pagination li {
            margin-bottom: 10px
        }

        div.dataTables_wrapper div div.dataTables_paginate ul.pagination li a {
            font-size: 11px
        }
    }

    table.dataTable.table-sm>thead>tr>th {
        padding-right: 20px
    }

    table.dataTable.table-sm .sorting:before,
    table.dataTable.table-sm .sorting_asc:before,
    table.dataTable.table-sm .sorting_desc:before {
        top: 5px;
        right: .85em
    }

    table.dataTable.table-sm .sorting:after,
    table.dataTable.table-sm .sorting_asc:after,
    table.dataTable.table-sm .sorting_desc:after {
        top: 5px
    }

    table.table-bordered.dataTable td,
    table.table-bordered.dataTable th {
        border-left-width: 0
    }

    table.table-bordered.dataTable td:last-child,
    table.table-bordered.dataTable th:last-child {
        border-right-width: 0
    }

    table.table-bordered.dataTable tbody td,
    table.table-bordered.dataTable tbody th {
        border-bottom-width: 0
    }

    div.dataTables_scrollHead table.table-bordered {
        border-bottom-width: 0
    }

    div.table-responsive>div.dataTables_wrapper>div.row {
        margin: 0
    }

    div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:first-child,
    div.table-responsive>div.dataTables_wrapper>div.row>div[class^=col-]:last-child {
        padding-left: 0;
        padding-right: 0
    }
</style>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ url('admin/dashboard') }}" class="logo d-flex align-items-center">
            <span class="me-1"> <img src="{{ asset('assets/img/skyraan-technologies.avif') }}"
                    style="border-radius: 6px;"> </span>
            <span class="d-none d-lg-block"> &nbsp;Admin Dashboard</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <style>
        .heading span {
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            font-family: "Nunito", sans-serif;
        }
    </style>

    <div
        class="header-nav ms-auto text-center d-flex justify-content-center align-content-center align-items-center heading">
        <span>📚 - புனித நூல் (Bible)</span>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (Auth::guard('admin')->user()->image_type == 1)
                        <img src="{{ asset(Auth::guard('admin')->user()->image) }}"alt="Profile" class="rounded-circle">
                    @elseif(Auth::guard('admin')->user()->image_type == 2)
                        <img src="{{ Auth::guard('admin')->user()->image }}" alt="Profile" class="rounded-circle">
                    @endif
                    <br>
                    <br>
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::guard('admin')->user()->name }}</span>
                </a>


                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        @if (Auth::guard('admin')->user()->image_type == 1)
                            <img src="{{ asset(Auth::guard('admin')->user()->image) }}"alt="Profile"
                                class="rounded-circle" style="height:30% !important;width:30% !important;">
                        @elseif(Auth::guard('admin')->user()->image_type == 2)
                            <img src="{{ Auth::guard('admin')->user()->image }}" alt="Profile" class="rounded-circle"
                                style="min-height:40% !important;min-width:40% !important; ">
                        @endif
                        <h6>{{ Auth::guard('admin')->user()->name }}</h6>
                        <span></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/profile_update') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if (Auth::guard('admin')->check())
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.logout') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    @endif
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
