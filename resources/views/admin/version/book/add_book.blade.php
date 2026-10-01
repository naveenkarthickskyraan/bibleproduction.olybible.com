<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Add Book Info</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

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

    {{--
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
        rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{--
    <!-- Templat{{ asset('e Main CSS File --> --}}

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/quiz.css') }}" rel="stylesheet">
    <style>
        .book-field-set {
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .book-field-set:hover {
            background-color: #f1f1f1;
        }

        .remove-book-field {
            transition: all 0.3s ease;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .form-control {
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .book-field-set .col-md-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 768px) {
            .book-field-set .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
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
            <h1><i class="fa fa-book"></i> Books List (Add Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/book_list') }}">Books
                            List</a></li>
                    <li class="breadcrumb-item active">List of Books Table</li>
                </ol>
            </nav>
        </div>


        <div class="alert-container"></div>

        <div class="row">
            <div class="col-md-9 grid-margin stretch-card">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        @endforeach
                    </div>
                @endif


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

                <div class="card" style="background-color: #fff;">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #7367EF !important;">
                            <i class="fas fa-folder-tree me-2"></i>Book Add Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" id="bookForm" action="{{ url('admin/book.insert') }}"
                            method="POST" role="form" enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container-fluid">


                                <!-- App Version -->
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="version_id" class="form-label">
                                            <i class="fas fa-code-branch me-2"></i>App Version
                                            <span style="color:red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" name="version_id" id="version_id" required>
                                            <option value="">Select a Version name</option>
                                            @foreach ($versions as $data)
                                            <option value="{{ $data->id }}" {{ old('version_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->version_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('version_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="metadescription" class="form-label">
                                            <i class="fas fa-tags me-2"></i>Meta Description
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="metadescription" class="form-control" id="metadescription" 
                                                rows="10" placeholder="Enter meta description for SEO (optional)">{{ old('metadescription') }}</textarea>
                                        <small class="text-muted">Brief description for search engines (160 characters recommended)</small>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Character count: <span id="metaDescCount">0</span>/160</small>
                                        </div>
                                        @error('metadescription')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Meta Keywords -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="metakeywords" class="form-label">
                                            <i class="fas fa-key me-2"></i>Meta Keywords
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="metakeywords" class="form-control" id="metakeywords" type="text"
                                            placeholder="Enter comma-separated keywords for SEO (optional)" 
                                            value="{{ old('metakeywords') }}">
                                        <small class="text-muted">Comma-separated keywords for search engines (optional)</small>
                                        @error('metakeywords')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <!-- Book Fields Container -->
                                <div id="bookFieldsContainer">
                                    @if(old('books'))
                                        <!-- Show old input if validation fails -->
                                        @foreach(old('books') as $index => $oldBook)
                                        <div class="book-field-set mb-4 p-3 border rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="text-dark">Book Information #{{ $index + 1 }}</h4>
                                                <button type="button" class="btn btn-danger btn-sm remove-book-field" {{ $loop->first ? 'disabled' : '' }}>
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>

                                            <div class="row">
                                                <!-- Book Number -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Book Number<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[{{ $index }}][book_num]" class="form-control" type="text"
                                                            placeholder="Book number" value="{{ $oldBook['book_num'] }}" required>
                                                        @error('books.'.$index.'.book_num')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Book Title -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Book Title<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[{{ $index }}][title]" class="form-control" type="text"
                                                            placeholder="Full title" value="{{ $oldBook['title'] }}" required>
                                                        @error('books.'.$index.'.title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Short Title -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Short Title<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[{{ $index }}][short_title]" class="form-control" type="text"
                                                            placeholder="Short title" value="{{ $oldBook['short_title'] }}" required>
                                                        @error('books.'.$index.'.short_title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Total Chapter Count -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total Chapters<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[{{ $index }}][total_chap_count]" class="form-control" type="number"
                                                            placeholder="Chapter count" value="{{ $oldBook['total_chap_count'] }}" required min="1">
                                                        @error('books.'.$index.'.total_chap_count')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <!-- Initial Book Field Set -->
                                        <div class="book-field-set mb-4 p-3 border rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="text-dark">Book Information #1</h4>
                                                <button type="button" class="btn btn-danger btn-sm remove-book-field" disabled>
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>

                                            <div class="row">
                                                <!-- Book Number -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Book Number<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[0][book_num]" class="form-control" type="text"
                                                            placeholder="Book number" required>
                                                    </div>
                                                </div>

                                                <!-- Book Title -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Book Title<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[0][title]" class="form-control" type="text"
                                                            placeholder="Full title" required>
                                                    </div>
                                                </div>

                                                <!-- Short Title -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Short Title<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[0][short_title]" class="form-control" type="text"
                                                            placeholder="Short title" required>
                                                    </div>
                                                </div>

                                                <!-- Total Chapter Count -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Total Chapters<span style="color:red;">&nbsp;*</span></label>
                                                        <input name="books[0][total_chap_count]" class="form-control" type="number"
                                                            placeholder="Chapter count" required min="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Add More Books Button -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <button type="button" id="addBookField" class="btn btn-success">
                                            <i class="fas fa-plus me-2"></i>Add Another Book
                                        </button>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <hr class="mb-4">
                                        <div class="d-flex justify-content-end gap-3">
                                            <a href="{{ url('admin/book_list') }}" class="btn btn-dark">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="fas fa-save me-2"></i>Save Book(s)
                                            </button>
                                            <button id="loadingBtn" class="btn btn-primary" type="button" disabled
                                                style="display: none;">
                                                <span class="spinner-grow spinner-grow-sm me-2" role="status"
                                                    aria-hidden="true"></span>
                                                Saving...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>

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

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- <script src="{{ asset('assets/js/quiz.js') }}"></script> --}}
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Book Field
            const addButton = document.getElementById('addBookField');
            const container = document.getElementById('bookFieldsContainer');
            let fieldIndex = {{ old('books') ? count(old('books')) : 1 }};

            addButton.addEventListener('click', function() {
                const newFieldSet = document.createElement('div');
                newFieldSet.className = 'book-field-set mb-4 p-3 border rounded';
                newFieldSet.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-dark">Book Information #${fieldIndex + 1}</h4>
                        <button type="button" class="btn btn-danger btn-sm remove-book-field">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>

                    <div class="row">
                        <!-- Book Number -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Book Number<span style="color:red;">&nbsp;*</span></label>
                                <input name="books[${fieldIndex}][book_num]" class="form-control" type="text"
                                    placeholder="Book number" required>
                            </div>
                        </div>

                        <!-- Book Title -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Book Title<span style="color:red;">&nbsp;*</span></label>
                                <input name="books[${fieldIndex}][title]" class="form-control" type="text"
                                    placeholder="Full title" required>
                            </div>
                        </div>

                        <!-- Short Title -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Short Title<span style="color:red;">&nbsp;*</span></label>
                                <input name="books[${fieldIndex}][short_title]" class="form-control" type="text"
                                    placeholder="Short title" required>
                            </div>
                        </div>

                        <!-- Total Chapter Count -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total Chapters<span style="color:red;">&nbsp;*</span></label>
                                <input name="books[${fieldIndex}][total_chap_count]" class="form-control" type="number"
                                    placeholder="Chapter count" required min="1">
                            </div>
                        </div>
                    </div>
                `;

                container.appendChild(newFieldSet);
                fieldIndex++;

                // Enable remove buttons when there are multiple fields
                const removeButtons = document.querySelectorAll('.remove-book-field');
                if (removeButtons.length > 1) {
                    removeButtons.forEach(button => {
                        button.disabled = false;
                    });
                }
            });

            // Remove Book Field
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-book-field')) {
                    const fieldSet = e.target.closest('.book-field-set');
                    if (document.querySelectorAll('.book-field-set').length > 1) {
                        fieldSet.remove();
                        
                        // Update numbering and disable remove button if only one field remains
                        const allFieldSets = document.querySelectorAll('.book-field-set');
                        if (allFieldSets.length === 1) {
                            allFieldSets[0].querySelector('.remove-book-field').disabled = true;
                        }
                        
                        // Renumber remaining fields
                        allFieldSets.forEach((set, index) => {
                            set.querySelector('h4').textContent = `Book Information #${index + 1}`;
                            // Update all input names to maintain array order
                            const inputs = set.querySelectorAll('input');
                            inputs.forEach(input => {
                                const name = input.name.replace(/books\[\d+\]/, `books[${index}]`);
                                input.name = name;
                            });
                        });
                    }
                }
            });

            // Character counter for meta description
            const metaDescTextarea = document.getElementById('metadescription');
            const metaDescCount = document.getElementById('metaDescCount');
            
            metaDescTextarea.addEventListener('input', function() {
                metaDescCount.textContent = this.value.length;
            });
            
            // Initialize character count if there's old input
            if(metaDescTextarea.value) {
                metaDescCount.textContent = metaDescTextarea.value.length;
            }
        });
    </script>

    <script>
        $(document).ready(function() {

            // Initialize Select2
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });
                
            $('.select2').on('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search here...');
                document.querySelector('.select2-search__field').focus();
            });

            
            // Form validation
            $('#bookForm').on('submit', function(e) {
                let isValid = true;
                
                // Validate version name
                if ($('#version_id').val() === '') {
                    $('#version_id-error').text('Version ID is required');
                    isValid = false;
                } else {
                    $('#version_id-error').text('');
                }
                
                // Validate language selection
                if ($('#languageid').val() === '') {
                    $('.errorlanguageid').html('<span class="error-message">Please select a language</span>');
                    isValid = false;
                } else {
                    $('.errorlanguageid').html('');
                }
                
                // Validate audio type if visible
                if ($('#audiotypediv').is(':visible') && $('#audiotype').val() === '') {
                    $('.erroraudiotype').html('<span class="error-message">Please select an audio type</span>');
                    isValid = false;
                } else {
                    $('.erroraudiotype').html('');
                }
                
                if (!isValid) {
                    e.preventDefault();
                    toastr.error('Please fix the validation errors before submitting');
                    return false;
                }
                
                // Show loading state
                $('#submitBtn').hide();
                $('#loadingBtn').show();
                
                return true;
            });
        });
    </script>

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
    </script>

</body>

</html>