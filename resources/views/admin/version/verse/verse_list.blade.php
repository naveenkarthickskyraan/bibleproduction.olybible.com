<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Verse Info</title>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{--
    <!-- Templat{{ asset('e Main CSS File --> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <style>
        .search-highlight {
            background-color: #ffff00 !important;
            padding: 2px !important;
            border-radius: 3px !important;
            font-weight: bold !important;
            color: #000 !important;
        }

        .highlight-row {
            background-color: #ffffd0 !important;
            transition: background-color 1s !important;
        }

        .search-highlight:hover {
            background-color: #ffa500 !important;
            transition: background-color 0.3s !important;
        }

        .app-thumbnail {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px #405189;
            border: 2px solid #fff;
            opacity: 0.85;
            object-fit: cover;
        }

        .store-link {
            color: #405189;
            text-decoration: none;
            transition: all 0.3s;
        }

        .store-link:hover {
            color: #7367EF;
            text-decoration: underline;
        }

        .date-info {
            font-size: 0.9rem;
            line-height: 1.3;
        }

        .btn-group {
            gap: 5px;
        }
    </style>

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
            <h1><i class="fa fa-layer-group"></i> Verse Info</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/verse_list') }}">Verse Info</a>
                    </li>
                    <li class="breadcrumb-item active">List of Verse Info Table</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">

                @if (Session::has('error'))
                <div class="alert-container">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>{{ Session::get('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                @if (Session::has('message'))
                <div class="alert-container">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>{{ Session::get('message') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                @endif

                <!-- Recent Sales -->
                <div class="col-12">

                    @include('admin.accounts.permission', [
                    'menu' => 'verse_menu',
                    'name' => 'Verse',
                    ])


                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-header">Verse Info List <span>| Today</span></h5>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3 mb-3">
                                    <div class="action-btn" align="right" style="padding-top:20px;padding-right:20px;">
                                        <a href="{{ url('admin/add_verse') }}" class="btn btn-sm btn-primary btn-add">
                                            <i class="ri-add-line"></i> Add New Verse </a>
                                    </div>
                                </div>
                            </div>

                            <!-- App Version -->
                            <div class="card mb-3">
                                <div class="card-body mt-3">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-12">
                                            <label for="version_id" class="form-label">
                                                <i class="fas fa-code-branch me-2"></i>Bible App Version
                                                <span style="color:red;">*</span>
                                            </label>
                                        </div>
                                        <div class="col-md-5 p-2" style="padding-left: 20px !important;">
                                            <select class="form-control select2" name="version_id" id="version_id" onchange="formUnderSubmit(this.value)">
                                                <option value="">Select a Version name</option>
                                                @foreach ($versions as $data)
                                                    <option value="{{ $data->id }}" {{ $verseIdFirst->id == $data->id ? "selected":"" }}>
                                                        {{ $data->version_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('version_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-bordered table-hover yajra-datatable text-center">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center" scope="col">Id</th>
                                        <th class="text-center" scope="col">Verse Name</th>
                                        <th class="text-center" scope="col">Verse Content</th>
                                        <th class="text-center" scope="col">Book Name</th>
                                        <th class="text-center" scope="col">Book Num</th>
                                        <th class="text-center" scope="col">Chapter Num</th>
                                        <th class="text-center" scope="col">Verse Num</th>
                                        <th class="text-center" scope="col">MetaKeywords</th>
                                        <th class="text-center" scope="col">Meta Description</th>
                                        <th class="text-center" scope="col">Created</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Action</th>
                                        <th class="text-center" scope="col">Active</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>
        </section>

        </div>
        </div>
        </div>
        <!-- page-body-wrapper ends -->
        <footer id="footer" class="footer">
            <div class="copyright">
            </div>
        </footer>

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

        <!-- Verse Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
            referrerpolicy="no-referrer"></script>

        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });
                
            $('.select2').on('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search here...');
                document.querySelector('.select2-search__field').focus();
            });

            // Check if alert was dismissed
            const alertDismissed = localStorage.getItem('versePermissionAlertDismissed');
            const dismissTime = localStorage.getItem('versePermissionAlertDismissTime');
            const now = new Date().getTime();

            // Show alert only if not dismissed or dismissed more than 1 hour ago
            if (!alertDismissed || (dismissTime && now - dismissTime > 3600000)) {
                document.getElementById('permissionAlert').style.display = 'block';
            } else {
                document.getElementById('permissionAlert').style.display = 'none';
            }

            let autoHideTimeout;

            function pauseAutoHide() {
                clearTimeout(autoHideTimeout);
            }

            function dismissPermissionAlert(permanent = false) {
                const alert = document.getElementById('permissionAlert');
                if (alert) {
                    alert.style.animation = 'fadeIn 0.4s ease-in-out reverse';
                    setTimeout(() => {
                        alert.remove();
                        if (permanent) {
                            // Store dismissal for 1 hour
                            localStorage.setItem('versePermissionAlertDismissed', 'true');
                            localStorage.setItem('versePermissionAlertDismissTime', new Date().getTime());
                        }
                    }, 400);
                }
            }
        </script>

        <script>
            // Get the current URL
            const url = new URL(window.location.href);

            // Create a URLSearchParams object
            const params = new URLSearchParams(url.search);

            var versionId = null;
            // Check if 'version_id' is set
            if (params.has('version_id')) {
                // Get the value of 'version_id'
                versionId = params.get('version_id');
                // Log the value to the console (or use it as needed)
            } else {
                versionId = "{{ $verseIdFirst->id; }}";
                // formUnderSubmit(versionId);
                // Handle the case where 'version_id' is not set
                console.log('Exam ID parameter is not set.', versionId);
            }

            function formUnderSubmit(params) {
                var url = "{{ url('admin/verse_list'); }}";
                var newUrl = url+'?version_id='+params;
                window.history.replaceState(null, '', newUrl);
                versionId = params;
                table.ajax.reload(null, true);
            }
            
            var table;
            $(document).ready(function() {
                
                table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    scrollX:true,
                    deferRender: true, // Only render visible rows
                    stateSave: true, // Remember user preferences
                    ajax: {
                        url: '{{ route("verse.list") }}',
                        data: function(d) {
                            d.version_id = versionId != null ? versionId : $('#version_id').val();
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'version_id',
                            name: 'version_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'content',
                            name: 'content',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'book_id',
                            name: 'book_id',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'book_num',
                            name: 'book_num',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'chapter_num',
                            name: 'chapter_num',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'verse_num',
                            name: 'verse_num',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'meta_keyword',
                            name: 'meta_keyword',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'meta_description',
                            name: 'meta_description',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'status_update',
                            name: 'status_update',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    "drawCallback": function(settings) {
                        var searchTerm = table.search();

                        if (searchTerm && searchTerm.trim() !== '') {
                            $('.yajra-datatable tbody tr td:not(:has(form))').each(function() {
                                var $cell = $(this);
                                if ($cell.find('button, input').length === 0) {
                                    var cellHtml = $cell.html();
                                    var highlightedHtml = highlightSearchTerm(cellHtml, searchTerm);
                                    $cell.html(highlightedHtml);
                                }
                            });
                        }

                        if (window.location.hash) {
                            var rowId = window.location.hash.substring(1);
                            var targetRow = $('div[id="' + rowId + '"]').closest('tr');

                            if (targetRow.length) {
                                setTimeout(function() {
                                    var scrollPosition = targetRow.offset().top - 100;
                                    $('html, body').animate({
                                        scrollTop: scrollPosition
                                    }, 500);

                                    targetRow.addClass('highlight-row');
                                    setTimeout(function() {
                                        targetRow.removeClass('highlight-row');
                                    }, 3000);
                                }, 200);
                            }
                        }
                    }
                });

                function highlightSearchTerm(text, searchTerm) {
                    if (!searchTerm || searchTerm.trim() === '') {
                        return text;
                    }

                    if (typeof text === 'string' && text.indexOf('<') > -1) {
                        var matches = [];
                        var textOnly = text.replace(/<[^>]*>/g, function(match) {
                            matches.push(match);
                            return '\u0001';
                        });

                        var searchRegex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')',
                            'gi');
                        textOnly = textOnly.replace(searchRegex, '<span class="search-highlight">$1</span>');

                        return textOnly.replace(/\u0001/g, function() {
                            return matches.shift();
                        });
                    } else {
                        var searchRegex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')',
                            'gi');
                        return text.replace(searchRegex, '<span class="search-highlight">$1</span>');
                    }
                }

                $('.dataTables_filter input').on('keyup', function() {
                    table.draw();
                });

                setTimeout(function() {
                    if (window.location.hash) {
                        history.replaceState(null, null, window.location.pathname + window.location.search);
                    }
                }, 4000);
            });


            // JavaScript for Preloader
            
            // Preloader
            window.addEventListener('load', function() {
                const preloader = document.getElementById('pre-loader');
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500);
            });

            function validateform(val) {
                Swal.fire({
                    title: 'Confirmation',
                    text: 'Are you sure you want to delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_submit_' + val).submit();
                    }
                });
            }
        </script>

</body>

</html>