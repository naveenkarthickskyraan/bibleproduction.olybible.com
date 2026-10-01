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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/quiz.css') }}" rel="stylesheet">

    {{-- <style>
        :root {
            --primary: #5469d4 !important;
            --primary-light: #eceffe !important;
            --secondary: #0d123c !important;
            --accent: #f3a712 !important;
            --success: #3bb54a !important;
            --danger: #e74a3b !important;
            --light-gray: #f8f9fa !important;
            --medium-gray: #e9ecef !important;
            --dark-gray: #495057 !important;
            --white: #ffffff !important;
            --border-radius: 8px !important;
            --box-shadow: 0 0.25rem 1rem rgba(13, 18, 60, 0.08) !important;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
            background-color: #f5f7fb !important;
            color: var(--secondary) !important;
            line-height: 1.6 !important;
        }

        .main-container {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 2rem 1rem !important;
        }

        .btn {
            border-radius: var(--border-radius) !important;
            padding: 0.625rem 1.25rem !important;
            font-weight: 600 !important;
            transition: all 0.2s !important;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: #4559b3 !important;
            border-color: #4559b3 !important;
        }

        .btn-outline-primary {
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary) !important;
            color: var(--white) !important;
        }


        .card {
            border: none !important;
            border-radius: var(--border-radius) !important;
            box-shadow: var(--box-shadow) !important;
            margin-bottom: 1.5rem !important;
            overflow: hidden !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
        }

        .card:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 0.5rem 1.5rem rgba(13, 18, 60, 0.12) !important;
        }

        .card-header {
            background-color: var(--white) !important;
            padding: 1.25rem 1.5rem !important;
            font-weight: 600 !important;
            color: var(--secondary) !important;
            border-bottom: 1px solid var(--medium-gray) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .card-header-icon {
            margin-right: 10px !important;
            color: var(--primary) !important;
        }
    </style> --}}

    <style>
        .verse-item {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .verse-item:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .verse-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .verse-number {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .remove-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .verse-textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            resize: vertical;
            transition: border-color 0.3s ease;
            font-family: inherit;
        }

        .verse-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .verse-textarea.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin: 1rem auto;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .verse-container {
            min-height: 200px;
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
            <h1><i class="fa fa-layer-group"></i> Verse List (Add Form)</h1>
            <nav>
                <ol class="breadcrumb">&nbsp;&nbsp;&nbsp;&nbsp;&#11162;&nbsp;&nbsp;
                    <li class="breadcrumb-item"><a href="{{ url('admin/verse_list') }}">Verse
                            List</a></li>
                    <li class="breadcrumb-item active">List of Verse Table</li>
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
                            <i class="fas fa-folder-tree me-2"></i>Verse Add Form
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="forms-sample" action="{{ url('admin/verse.insert') }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <hr class="text-dark">
                            <div class="container px-2">

                                <input type="hidden" id="old_version_id" value="{{ old('version_id') }}">
                                <input type="hidden" id="old_book_id" value="{{ old('book_id') }}">
                                <input type="hidden" id="old_chapter_id" value="{{ old('chapter_id') }}">

                                <div class="form-group row">
                                    <div class="col-sm-12 d-flex aling-items-center">
                                        <label for="version_id" class="col-sm-12 col-form-label h2 text-dark">App
                                            Version<span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        <select class="form-control select2" name="version_id" id="version_id">
                                            <option value="">Select a Version name</option>
                                            @foreach ($versions as $data)
                                            <option value="{{ $data->id  }}" {{ $data->id == old('version_id') ?
                                                "selected":""}}> {{ $data->version_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

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

                                <div class="form-group row mb-3">
                                    <div class="col-sm-12 d-flex align-items-center">
                                        <label for="chapter_id" class="col-sm-12 col-form-label h2 text-dark">Verse Content
                                            <span style="color:red;">&nbsp;*</span></label>
                                    </div>
                                    <div class="col-md-12 p-2" style="padding-left: 20px !important;">
                                        {{-- Dynamic Verse Fields Container --}}
                                        <div id="verse-container" class="verse-container">
                                            @php
                                            // Handle old input or set default
                                            $oldVerses = old('verse_content', ['']);
                                            $verseCount = count($oldVerses);
                                            @endphp

                                            @foreach($oldVerses as $index => $content)
                                            <div class="verse-item" data-verse-index="{{ $index }}">
                                                <div class="verse-header">
                                                    <div class="verse-number">Verse {{ $index + 1 }}</div>
                                                    <button type="button" class="remove-btn" onclick="removeVerse(this)" {{
                                                        $verseCount <=1 ? 'disabled' : '' }} title="Remove verse">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                            <path
                                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div>
                                                    <textarea name="verse_content[]"
                                                        class="verse-textarea {{ $errors->has('verse_content.'.$index) ? 'error' : '' }}"
                                                        placeholder="Enter verse content here..." rows="4"
                                                        onkeyup="updateCharacterCount(this)"
                                                        maxlength="3000">{{ $content }}</textarea>

                                                    {{-- Laravel Blade Error Display for specific verse --}}
                                                    @error('verse_content.'.$index)
                                                    <div class="error-message">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                                            <path
                                                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                                                        </svg>
                                                        {{ $message }}
                                                    </div>
                                                    @enderror

                                                    {{-- Character Counter --}}
                                                    <div class="character-counter">
                                                        <span class="char-count">{{ strlen($content) }}</span> / 3000 characters
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                {{-- Add Verse Button --}}
                                <div class="btn-container">
                                    <button type="button" class="add-btn" onclick="addVerse()" id="addVerseBtn">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                                        </svg>
                                        Add Another Verse
                                    </button>
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
        let verseCounter = {{ count($oldVerses) }};
        const maxVerses = 10;

        function addVerse() {
            if (verseCounter >= maxVerses) {
                alert('Maximum ' + maxVerses + ' verses allowed');
                return;
            }

            const container = document.getElementById('verse-container');
            const newVerseHtml = `
                <div class="verse-item" data-verse-index="${verseCounter}" id="verse-${verseCounter}">
                    <div class="verse-header">
                        <div class="verse-number">Verse ${verseCounter + 1}</div>
                        <button 
                            type="button" 
                            class="remove-btn" 
                            onclick="removeVerse(this)"
                            title="Remove verse"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div>
                        <textarea 
                            name="verse_content[]"
                            class="verse-textarea"
                            placeholder="Enter verse content here..."
                            rows="4"
                            onkeyup="updateCharacterCount(this)"
                            maxlength="3000"
                        ></textarea>
                        
                        <div class="character-counter">
                            <span class="char-count">0</span> / 3000 characters
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', newVerseHtml);
            verseCounter++;
            
            // Update verse numbers and remove button states
            updateVerseNumbers();
            updateRemoveButtons();
            
            // Hide add button if max reached
            if (verseCounter >= maxVerses) {
                document.getElementById('addVerseBtn').style.display = 'none';
            }

            // Scroll to the newly added verse with smooth animation
            setTimeout(() => {
                const newVerse = document.getElementById(`verse-${verseCounter - 1}`);
                if (newVerse) {
                    newVerse.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                    
                    // Focus on the textarea of the new verse
                    const textarea = newVerse.querySelector('.verse-textarea');
                    if (textarea) {
                        textarea.focus();
                    }
                }
            }, 100);
        }

        function removeVerse(button) {
            const verseItem = button.closest('.verse-item');
            const allVerses = document.querySelectorAll('.verse-item');
            
            if (allVerses.length <= 1) {
                alert('At least one verse is required');
                return;
            }
            
            verseItem.remove();
            verseCounter--;
            
            // Update verse numbers and remove button states
            updateVerseNumbers();
            updateRemoveButtons();
            
            // Show add button if under max
            if (verseCounter < maxVerses) {
                document.getElementById('addVerseBtn').style.display = 'flex';
            }
        }

        function updateVerseNumbers() {
            const verses = document.querySelectorAll('.verse-item');
            verses.forEach((verse, index) => {
                const verseNumber = verse.querySelector('.verse-number');
                verseNumber.textContent = `Verse ${index + 1}`;
                verse.setAttribute('data-verse-index', index);
            });
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-btn');
            const verseCount = removeButtons.length;
            
            removeButtons.forEach(button => {
                button.disabled = verseCount <= 1;
            });
        }

        function updateCharacterCount(textarea) {
            const charCount = textarea.value.length;
            const counter = textarea.parentNode.querySelector('.char-count');
            counter.textContent = charCount;
            
            // Add warning color if approaching limit
            if (charCount > 900) {
                counter.style.color = '#ef4444';
            } else if (charCount > 800) {
                counter.style.color = '#f59e0b';
            } else {
                counter.style.color = '#6b7280';
            }
        }

        // Form validation before submission
        document.getElementById('verseForm').addEventListener('submit', function(e) {
            const textareas = document.querySelectorAll('.verse-textarea');
            let hasEmptyFields = false;
            let hasDuplicates = false;
            const contents = [];
            
            textareas.forEach((textarea, index) => {
                const content = textarea.value.trim();
                
                // Check for empty fields
                if (!content) {
                    hasEmptyFields = true;
                    textarea.classList.add('error');
                } else {
                    textarea.classList.remove('error');
                }
                
                // Check for duplicates
                if (content && contents.includes(content.toLowerCase())) {
                    hasDuplicates = true;
                    textarea.classList.add('error');
                }
                
                if (content) {
                    contents.push(content.toLowerCase());
                }
            });
            
            if (hasEmptyFields) {
                e.preventDefault();
                alert('Please fill in all verse content fields');
                return false;
            }
            
            if (hasDuplicates) {
                e.preventDefault();
                alert('Duplicate verse content is not allowed');
                return false;
            }
        });

        // Initialize character counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('.verse-textarea');
            textareas.forEach(textarea => {
                updateCharacterCount(textarea);
            });
        });
    </script>

    <script>
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

        // Version dropdown change
        $('#version_id').on('change', function () {
            var versionId = $(this).val();
            loadBooks(versionId, null, null);
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