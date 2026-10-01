<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Bible App - Add Dictionary Words Info</title>
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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/quiz.css') }}" rel="stylesheet">
    <style>
        .form-section {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            position: relative;
        }

        .form-section.active {
            border-color: #0d6efd;
            background-color: #f0f8ff;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .section-title {
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .remove-section {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-section:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .add-more-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .add-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .color-dark {
            color: #343a40;
        }

        .fs-14 {
            font-size: 14px;
        }

        .fw-500 {
            font-weight: 500;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            right: 10px;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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
            <h1><i class="fa fa-layer-group"></i> Dictionary Words List (Add Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/dictionary_list') }}">Dictionary Words
                            List</a></li>
                    <li class="breadcrumb-item active">List of Dictionary Words Table</li>
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
                            <i class="fas fa-folder-tree me-2"></i>Dictionary Words Add Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" action="{{ url('admin/dictionary.insert') }}" method="POST"
                            role="form" enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container px-2">

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="word" class="col-sm-12 col-form-label h2 text-dark">Word
                                            <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <input name="word" class="form-control" id="word" type="text"
                                            placeholder="Enter Word Name" value="{{ old('word') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="description" class="col-sm-12 col-form-label h2 text-dark">
                                            Description<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <textarea name="description" class="form-control" id="description"
                                            placeholder="Enter Description"
                                            rows="7">{{ old('description') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="description" class="col-sm-12 col-form-label h2 text-dark">
                                            Chapters <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <div id="sections-container">
                                            <!-- Initial section will be added by JavaScript -->
                                        </div>
                                        
                                        <div class="text-center mb-4">
                                            <button type="button" class="btn add-more-btn" id="add-more-section">
                                                <i class="fas fa-plus me-2"></i>Add More Fields
                                            </button>
                                        </div>
                                    </div>
                                </div>



                                <br>
                                <br>


                                <div class="container px-5">
                                    <div class="row">
                                        <div class="col-sm-12 text-end">
                                            <button type="submit" name="submit" class="btn btn-primary"><i
                                                    class="fas fa-save me-1"></i> Submit</button>
                                            <button id="loading" class="btn btn-primary" type="button" disabled=""><span
                                                    class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>Loading...</button>
                                            <a href="{{ url('admin/dictionary_list') }}" class="btn btn-dark"
                                                type="button">cancel</a>
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
            let sectionCounter = 0;
            
            // Store old values for form validation/repopulation
            var old_values = {
                @if(old('sections'))
                    @foreach(old('sections') as $index => $section)
                        '{{ $index }}': {
                            'version_id': '{{ $section['version_id'] ?? '' }}',
                            'book_id': '{{ $section['book_id'] ?? '' }}',
                            'chapter_id': '{{ $section['chapter_id'] ?? '' }}'
                        },
                    @endforeach
                @endif
            };

            function createSection(sectionId) {
                return `
                    <div class="form-section fade-in" data-section-id="${sectionId}">
                        <div class="section-header">
                            <h5 class="section-title">Bible Section ${sectionId}</h5>
                            ${sectionId > 1 ? '<button type="button" class="remove-section" title="Remove Section"><i class="fas fa-times"></i></button>' : ''}
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <!-- Version ID Dropdown -->
                                <div class="form-group row mb-3">
                                    <div class="col-sm-12 d-flex align-items-center">
                                        <label for="version_id_${sectionId}" class="col-form-label color-dark fs-14 fw-500" style="padding-left: 10px">Version ID <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2 version-select" id="version_id_${sectionId}" name="sections[${sectionId}][version_id]" required data-section="${sectionId}">
                                            <option value="">Select Version</option>
                                            @foreach($versions as $item)
                                                <option value="{{$item->id}}">{{$item->id == 57 ? $item->version_name." ( 73 Books )": $item->version_name." ( 66 Books )" }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Book ID Dropdown -->
                                <div class="form-group row mb-3">
                                    <div class="col-sm-12 d-flex align-items-center">
                                        <label for="book_id_${sectionId}" class="col-form-label color-dark fs-14 fw-500" style="padding-left: 10px">Book ID <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2 book-select" id="book_id_${sectionId}" name="sections[${sectionId}][book_id]" required data-section="${sectionId}">
                                            <option value="">Select Book</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 ">

                                <!-- Chapter ID Dropdown -->
                                <div class="form-group row mb-3">
                                <div class="col-sm-12 d-flex align-items-center">
                                    <label for="chapter_id_${sectionId}" class="col-form-label color-dark fs-14 fw-500" style="padding-left: 10px">Chapter ID <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                    <select class="form-control select2 chapter-select" id="chapter_id_${sectionId}" name="sections[${sectionId}][chapter_id]" required data-section="${sectionId}">
                                        <option value="">Select Chapter</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                `;
            }

            function initializeSelect2(sectionId) {
                $(`#version_id_${sectionId}, #book_id_${sectionId}, #chapter_id_${sectionId}`).select2({
                    width: '100%',
                    placeholder: function() {
                        return $(this).attr('placeholder') || 'Select an option';
                    }
                });
            }

            function handleVersionChange(sectionId) {
                var versionId = $(`#version_id_${sectionId}`).val();
                var bookSelect = $(`#book_id_${sectionId}`);
                var chapterSelect = $(`#chapter_id_${sectionId}`);
                
                bookSelect.addClass('loading').empty().append('<option value="">Loading...</option>');
                chapterSelect.empty().append('<option value="">Select Chapter</option>');

                if (versionId) {
                    $.get("{{ route('get.books') }}", { version_id: versionId }, function(data) {
                        bookSelect.removeClass('loading').empty();
                        if (data.length > 0) {
                            bookSelect.append('<option value="">Select Book (' + data.length + ')</option>');
                            $.each(data, function(_, book) {
                                bookSelect.append('<option value="'+ book.id +'">'+ book.title +'</option>');
                            });
                            
                            // Set old value if exists
                            if (old_values[sectionId] && old_values[sectionId]['book_id']) {
                                bookSelect.val(old_values[sectionId]['book_id']).trigger('change');
                            }
                        } else {
                            bookSelect.append('<option value="">No books available</option>');
                        }
                    }).fail(function() {
                        bookSelect.removeClass('loading').empty().append('<option value="">Error loading books</option>');
                    });
                } else {
                    bookSelect.removeClass('loading').empty().append('<option value="">Select Book</option>');
                }
            }

            function handleBookChange(sectionId) {
                var versionId = $(`#version_id_${sectionId}`).val();
                var bookId = $(`#book_id_${sectionId}`).val();
                var chapterSelect = $(`#chapter_id_${sectionId}`);
                
                chapterSelect.addClass('loading').empty().append('<option value="">Loading...</option>');

                if (bookId && versionId) {
                    $.get("{{ route('get.books') }}", { version_id: versionId, book_id: bookId , status:1}, function(data) {
                        chapterSelect.removeClass('loading').empty().append('<option value="">Select Chapter</option>');
                        $.each(data, function(_, chapter) {
                            chapterSelect.append('<option value="'+ chapter.id +'">'+ chapter.chapter_number +'</option>');
                        });
                        
                        // Set old value if exists
                        if (old_values[sectionId] && old_values[sectionId]['chapter_id']) {
                            chapterSelect.val(old_values[sectionId]['chapter_id']);
                        }
                    }).fail(function() {
                        chapterSelect.removeClass('loading').empty().append('<option value="">Error loading chapters</option>');
                    });
                } else {
                    chapterSelect.removeClass('loading').empty().append('<option value="">Select Chapter</option>');
                }
            }

            function addSection() {
                sectionCounter++;
                const sectionHtml = createSection(sectionCounter);
                $('#sections-container').append(sectionHtml);
                
                // Initialize Select2 for new section
                initializeSelect2(sectionCounter);
                
                // Set old values if they exist for this section
                if (old_values[sectionCounter]) {
                    if (old_values[sectionCounter]['version_id']) {
                        $(`#version_id_${sectionCounter}`).val(old_values[sectionCounter]['version_id']).trigger('change');
                    }
                }
                
                // Scroll to new section
                setTimeout(function() {
                    $(`[data-section-id="${sectionCounter}"]`)[0].scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 100);
            }

            function removeSection(sectionId) {
                if ($('.form-section').length <= 1) {
                    alert('You must have at least one section.');
                    return;
                }
                
                $(`[data-section-id="${sectionId}"]`).fadeOut(300, function() {
                    $(this).remove();
                    updateSectionNumbers();
                });
            }

            function updateSectionNumbers() {
                $('.form-section').each(function(index) {
                    const newSectionId = index + 1;
                    const oldSectionId = $(this).attr('data-section-id');
                    
                    $(this).attr('data-section-id', newSectionId);
                    $(this).find('.section-title').text(`Bible Section ${newSectionId}`);
                    
                    // Update form field names and IDs
                    $(this).find('select, input').each(function() {
                        const currentName = $(this).attr('name');
                        const currentId = $(this).attr('id');
                        
                        if (currentName) {
                            const newName = currentName.replace(/sections\[\d+\]/, `sections[${newSectionId}]`);
                            $(this).attr('name', newName);
                        }
                        
                        if (currentId) {
                            const fieldType = currentId.split('_').slice(0, -1).join('_');
                            $(this).attr('id', `${fieldType}_${newSectionId}`);
                            $(this).attr('data-section', newSectionId);
                        }
                    });
                    
                    // Update labels
                    $(this).find('label').each(function() {
                        const currentFor = $(this).attr('for');
                        if (currentFor) {
                            const fieldType = currentFor.split('_').slice(0, -1).join('_');
                            $(this).attr('for', `${fieldType}_${newSectionId}`);
                        }
                    });
                    
                    // Update old_values reference
                    if (old_values[oldSectionId] && oldSectionId != newSectionId) {
                        old_values[newSectionId] = old_values[oldSectionId];
                        delete old_values[oldSectionId];
                    }
                });
                
                sectionCounter = $('.form-section').length;
            }

            // Event handlers
            $('#add-more-section').on('click', function() {
                addSection();
            });

            $(document).on('click', '.remove-section', function() {
                const sectionId = $(this).closest('.form-section').data('section-id');
                if (confirm('Are you sure you want to remove this section?')) {
                    removeSection(sectionId);
                }
            });

            $(document).on('change', '.version-select', function() {
                const sectionId = $(this).data('section');
                handleVersionChange(sectionId);
            });

            $(document).on('change', '.book-select', function() {
                const sectionId = $(this).data('section');
                handleBookChange(sectionId);
            });

            $(document).on('focus', '.form-section', function() {
                $('.form-section').removeClass('active');
                $(this).addClass('active');
            });

            // Form submission with validation
            $('#bibleForm').on('submit', function(e) {
                let isValid = true;
                let emptyFields = [];

                $('.form-section').each(function(index) {
                    const sectionId = $(this).data('section-id');
                    const versionId = $(`#version_id_${sectionId}`).val();
                    const bookId = $(`#book_id_${sectionId}`).val();
                    const chapterId = $(`#chapter_id_${sectionId}`).val();

                    if (!versionId) {
                        emptyFields.push(`Section ${sectionId}: Version`);
                        isValid = false;
                    }
                    if (!bookId) {
                        emptyFields.push(`Section ${sectionId}: Book`);
                        isValid = false;
                    }
                    if (!chapterId) {
                        emptyFields.push(`Section ${sectionId}: Chapter`);
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields:\n' + emptyFields.join('\n'));
                    return false;
                }
            });

            // Initialize first section or restore old sections
            if (Object.keys(old_values).length > 0) {
                // Restore old sections
                Object.keys(old_values).forEach(function(sectionId) {
                    addSection();
                });
            } else {
                // Add first section
                addSection();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            // Handle app type change
            $('#app_type').change(function() {
                const selectedType = $(this).val();
                
                // Hide all platform-specific fields first
                $('.ios-fields, .android-fields').hide();
                $('.ios-fields input, .android-fields input').removeAttr('required');
                
                // Show and set required for the selected platform
                if (selectedType === 'ios') {
                    $('.ios-fields').show();
                    $('.ios-fields input').attr('required', 'required');
                    $('#loading').hide();
                    $('#susubmitbmit').show();
                } else if (selectedType === 'android') {
                    $('.android-fields').show();
                    $('.android-fields input').attr('required', 'required');
                    $('#loading').hide();
                    $('#susubmitbmit').show();
                }
            });

            // Trigger change event on page load if there's already a selected value
            if ($('#app_type').val()) {
                $('#app_type').trigger('change');
            }
        });
            
        
        if($('#image_3').is(':checked'))
        {
            $("#Normal_image_type_1").show()
            $('#url_image_type_2').hide();
        }

        $('#image_3').bind('change', function () {
            if ($(this).is(':checked'))
                $("#Normal_image_type_1").show().removeAttr('checked',true)
                $('#url_image_type_2').hide();
            });
        
        $("#image_4").bind('change', function(){
            if ($(this).is(':checked'))
            $("#Normal_image_type_1").hide();
            $('#url_image_type_2').show().attr('checked',true);
        });

        // Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('pre-loader');
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });


        $('#loading').hide();
        $('#susubmitbmit').on('click', function() {
            $('#loading').show();
            $('#susubmitbmit').hide();
        });
    </script>

</body>

</html>