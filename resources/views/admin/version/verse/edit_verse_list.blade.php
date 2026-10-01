<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Add Verse Info</title>
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
            <h1><i class="fa fa-layer-group"></i> Verses List (Edit Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/verse_list') }}">Verses
                            List</a></li>
                    <li class="breadcrumb-item active">List of Verses Table</li>
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
                            <i class="fas fa-folder-tree me-2"></i>Verse Edit Page Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" id="verseForm"
                            action="{{ url('admin/edit_verse_list/' . $verse->id) }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container-fluid">

                                <input type="hidden" name="version_id" id="old_version_id" value="{{ $verse->version_id }}">
                                <input type="hidden" id="old_book_id" value="{{ $bookNum->id ?? old('book_id') }}">
                                <input type="hidden" id="old_chapter_id" value="{{ $verse->chapter_num  + 1 ??  old('chapter_id') }}">

                                <!-- Book ID Dropdown -->
                                <div class="form-group row mb-3">
                                    <div class="col-sm-12 d-flex align-items-center">
                                        <label for="book_id" class="col-sm-12 col-form-label h2 text-dark">Book ID<span
                                                style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" id="book_id" name="book_id" required>
                                            <option value="">Select Book</option>
                                            <!-- Add more options dynamically or statically -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Chapter ID Dropdown -->
                                <div class="form-group row mb-3">
                                    <div class="col-sm-12 d-flex align-items-center">
                                        <label for="chapter_id" class="col-sm-12 col-form-label h2 text-dark">Chapter
                                            ID<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" id="chapter_id" name="chapter_id" required>
                                            <option value="">Select Chapter</option>
                                            <!-- Add more options dynamically or statically -->
                                        </select>
                                    </div>
                                </div>

                                
                                <!-- Verse Number -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="verse_num" class="form-label">
                                            <i class="fas fa-hashtag me-2"></i>Verse Number
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="verse_num" class="form-control" id="verse_num" type="int" 
                                            placeholder="Enter verse number" 
                                            value="{{ old('verse_num', $verse->verse_num ?? '') }}" required>
                                        <small class="text-muted">The numerical identifier for this verse</small>
                                        @error('verse_num')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Verse Content -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="content" class="form-label">
                                            <i class="fas fa-tags me-2"></i>Verse Content
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="content" class="form-control" id="content" 
                                                rows="10" placeholder="Enter verse content">{{ $verse->content }}</textarea>
                                        <small class="text-muted">Enter the verse content for the bible</small>
                                        @error('content')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Meta Keywords -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="metakeywords" class="form-label">
                                            <i class="fas fa-key me-2"></i>Meta Keywords
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="metakeywords" class="form-control" id="metakeywords" type="text"
                                            placeholder="Enter comma-separated keywords for SEO (optional)" 
                                            value="{{ $verse->meta_keyword }}">
                                        <small class="text-muted">Comma-separated keywords for search engines (optional)</small>
                                        @error('metakeywords')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Meta Description -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="metadescription" class="form-label">
                                            <i class="fas fa-tags me-2"></i>Meta Description
                                        </label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="metadescription" class="form-control" id="metadescription" 
                                                rows="10" placeholder="Enter meta description for SEO (optional)">{{ $verse->meta_description }}</textarea>
                                        <small class="text-muted">Brief description for search engines (160 characters recommended)</small>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">Character count: <span id="metaDescCount">0</span>/160</small>
                                        </div>
                                        @error('metadescription')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>



                                <!-- Form Actions -->
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <hr class="mb-4">
                                        <div class="d-flex justify-content-end gap-3">
                                            <a href="{{ url('admin/verse_list') }}" class="btn btn-dark">
                                                <i class="fas fa-times me-2"></i>Cancel
                                            </a>
                                            <button type="submit" name="submit" class="btn btn-primary" id="submitBtn">
                                                <i class="fas fa-save me-2"></i>Save Verse(s)
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

    <script>
        $(document).ready(function() {

            $('.select2').select2();

            $('.select2').on('select2:open', function(e) {
                $('input.select2-search__field').prop('placeholder', 'Search here...');
                document.querySelector('.select2-search__field').focus();
            });

            $(document).ready(function () {
                var oldVersionId = $('#old_version_id').val();
                var oldBookId = $('#old_book_id').val();
                var oldChapterId = $('#old_chapter_id').val();

                // If there's an old version, set it and load books
                if (oldVersionId) {
                    $('#version_id').val(oldVersionId).trigger('change');

                    // Load books for that version
                    loadBooks(oldVersionId, oldBookId, oldChapterId);
                }
            });

            // Book dropdown change
            $('#book_id').on('change', function () {
                var versionId = $('#version_id').val();
                var bookId = $(this).val();
                loadChapters(versionId, bookId, null);
            });

            // Function to load books and optionally preselect a book and chapter
            function loadBooks(versionId, oldBookId = null, oldChapterId = null) {
                var bookSelect = $('#book_id');
                var chapterSelect = $('#chapter_id');

                bookSelect.addClass('loading').empty().append('<option value="">Loading...</option>');
                chapterSelect.empty().append('<option value="">Select Chapter</option>');
                setTimeout(() => {
                    if (versionId) {
                        $.get("{{ route('get.books') }}", { version_id: versionId }, function (data) {
                            bookSelect.removeClass('loading').empty();

                            if (data.length > 0) {
                                bookSelect.append('<option value="">Select Book (' + data.length + ')</option>');
                                $.each(data, function (_, book) {
                                    bookSelect.append('<option value="' + book.id + '">' + book.title + '</option>');
                                });

                                // If oldBookId is passed, select it
                                if (oldBookId) {
                                    bookSelect.val(oldBookId).trigger('change');
                                    loadChapters(versionId, oldBookId, oldChapterId);
                                }

                            } else {
                                bookSelect.append('<option value="">No books available</option>');
                            }
                        }).fail(function () {
                            bookSelect.removeClass('loading').empty().append('<option value="">Error loading books</option>');
                        });
                    } else {
                        bookSelect.removeClass('loading').empty().append('<option value="">Select Book</option>');
                    }
                }, 500);
            }

            // Function to load chapters and optionally preselect a chapter
            function loadChapters(versionId, bookId, oldChapterId = null) {
                var chapterSelect = $('#chapter_id');

                chapterSelect.addClass('loading').empty().append('<option value="">Loading...</option>');

                if (versionId && bookId) {
                    $.get("{{ route('get.books') }}", { version_id: versionId, book_id: bookId, status: 1 }, function (data) {
                        chapterSelect.removeClass('loading').empty();

                        if (data.length > 0) {
                            chapterSelect.append('<option value="">Select Chapter</option>');
                            $.each(data, function (_, chapter) {
                                chapterSelect.append('<option value="' + chapter.id + '">' + chapter.chapter_number + '</option>');
                            });

                            // If oldChapterId is passed, select it
                            if (oldChapterId) {
                                chapterSelect.val(oldChapterId);
                            }
                        } else {
                            chapterSelect.append('<option value="">No chapters available</option>');
                        }
                    }).fail(function () {
                        chapterSelect.removeClass('loading').empty().append('<option value="">Error loading chapters</option>');
                    });
                } else {
                    chapterSelect.removeClass('loading').empty().append('<option value="">Select Chapter</option>');
                }
            }

            
            // Form validation
            $('#verseForm').on('submit', function(e) {
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