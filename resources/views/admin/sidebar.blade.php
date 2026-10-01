@php
    $filename = request()->segments();
    $file = request()->segment(count(request()->segments()));
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@include('admin.sidebar_show')

<aside id="sidebar" class="sidebar">

    @php $AccessModule = Auth::guard('admin')->user()->accountAccessModule @endphp
    @php $explode_1 = explode('|',$AccessModule);@endphp
    <ul class="sidebar-nav" id="sidebar-nav" style="box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1),4px 4px 15px -5px rgba(21, 114, 232, 0.4) !important;margin-top: 5px;border-radius: 5px !important;">

        <li class="nav-item align-items-center align-self-center">
            <a class="nav-link cc @php echo ($file == 'dashboard') ? 'collapse':'collapsed' @endphp @php echo ($file == 'dashboard') ? 'active':'' @endphp"
                href="{{ url('admin/dashboard') }}" class="@php echo ($file == 'dashboard') ? 'active':'' @endphp">
                <i style="font-size: 22px;margin: 0px;font-style: normal;">🖥️</i>
                <span>Dashboard</span>
            </a>
        </li>
        @if (has_module_access('cron_job_menu'))
            <li class="nav-heading">Cron Job Monitoring</li>      
            <li class="nav-item align-items-center align-self-center">
                <a class="nav-link cc @php echo ($file == 'job-status') ? 'collapse':'collapsed' @endphp @php echo ($file == 'job-status') ? 'active':'' @endphp"
                    href="{{ url('admin/job-status') }}" class="@php echo ($file == 'job-status') ? 'active':'' @endphp">
                    <i class="job-status-icon" style="font-size: 22px; margin: 0px;">🚀</i>
                    <span>Cron Job Status</span>
                </a>
            </li>
        @endif

        <style>
            /* Add rocket animation when jobs are running */
            .job-status-icon {
                display: inline-block;
                transition: transform 0.3s ease;
            }
            .nav-link:hover .job-status-icon,
            .nav-link.active .job-status-icon {
                animation: rocketPulse 1.5s infinite;
            }
            @keyframes rocketPulse {
                0% { transform: translateY(0); }
                50% { transform: translateY(-3px); }
                100% { transform: translateY(0); }
            }
        </style>
        
        @if (has_module_access('apps_menu'))
            <li class="nav-heading">Dictionary Configuration info</li>
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'apps_list' || $file == 'add_apps' || $filename[1] == 'edit_apps') ? 'collapse':'collapsed' @endphp @php echo ($file == 'apps_list' || $file == 'add_apps' || $filename[1] == 'edit_apps') ? 'active':'' @endphp"
                    data-bs-target="#forms-nav" data-bs-toggle="collapse"
                    @if ($file == 'apps_list' || $file == 'add_apps' || $filename[1] == 'edit_apps') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/apps_list') }}">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">📶</i><span> Apps Info </span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav"
                    class="nav-content collapse @if ($file == 'apps_list' || $file == 'add_apps' || $filename[1] == 'edit_apps') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        <a href="{{ url('admin/apps_list') }}"
                            class="@php echo ($file == 'apps_list') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/add_apps') }}"
                            class="@php echo ($file == 'add_apps') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_apps')
                        <li>
                            <a href="/admin/edit_apps/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_apps') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        
        @if (has_module_access('template_menu'))
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'template_list' || $file == 'add_template' || $filename[1] == 'edit_template') ? 'collapse':'collapsed' @endphp @php echo ($file == 'template_list' || $file == 'add_template' || $filename[1] == 'edit_template') ? 'active':'' @endphp"
                    data-bs-target="#template-nav" data-bs-toggle="collapse"
                    @if ($file == 'template_list' || $file == 'add_template' || $filename[1] == 'edit_template') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/template_list') }}">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">🗂️</i><span> Template Info </span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="template-nav"
                    class="nav-content collapse @if ($file == 'template_list' || $file == 'add_template' || $filename[1] == 'edit_template') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        <a href="{{ url('admin/template_list') }}"
                            class="@php echo ($file == 'template_list') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/add_template') }}"
                            class="@php echo ($file == 'add_template') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_template')
                        <li>
                            <a href="/admin/edit_template/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_template') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (has_module_access('dictionary_menu'))
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'dictionary_list' || $file == 'add_dictionary' || $file == 'import' || $filename[1] == 'edit_dictionary') ? 'collapse active':'collapsed' @endphp"
                    data-bs-target="#dictionary_list" data-bs-toggle="collapse"
                    @if ($file == 'dictionary_list' || $file == 'add_dictionary' || $file == 'import' || $filename[1] == 'edit_dictionary') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/dictionary_list') }}">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">🔤</i><span>Dictionary Words Info</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dictionary_list"
                    class="nav-content collapse @if ($file == 'dictionary_list' || $file == 'add_dictionary' || $file == 'import' || $filename[1] == 'edit_dictionary') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        @if ($filename[1] == 'edit_dictionary')
                            <a href="{{ url('admin/dictionary_list') . '#' . $file }}"
                                class="@php echo ($file == 'dictionary_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @else
                            <a href="{{ url('admin/dictionary_list') }}"
                                class="@php echo ($file == 'dictionary_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ url('admin/add_dictionary') }}"
                            class="@php echo ($file == 'add_dictionary') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/import') }}"
                            class="@php echo ($file == 'import') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Import</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_dictionary')
                        <li>
                            <a href="/admin/edit_dictionary/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_dictionary') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (has_module_access('version_menu'))
            <li class="nav-heading">Versions Configuration info</li>
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'version_list' || $file == 'add_version' || $file == 'version_import' || $filename[1] == 'edit_version') ? 'collapse active':'collapsed' @endphp"
                    data-bs-target="#version_list" data-bs-toggle="collapse"
                    @if ($file == 'version_list' || $file == 'add_version' || $file == 'import' || $filename[1] == 'edit_version') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/version_list') }}">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">⏳</i><span>Version Info</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="version_list"
                    class="nav-content collapse @if ($file == 'version_list' || $file == 'add_version' || $file == 'version_import' || $filename[1] == 'edit_version') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        @if ($filename[1] == 'edit_version')
                            <a href="{{ url('admin/version_list') . '#' . $file }}"
                                class="@php echo ($file == 'version_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @else
                            <a href="{{ url('admin/version_list') }}"
                                class="@php echo ($file == 'version_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ url('admin/add_version') }}"
                            class="@php echo ($file == 'add_version') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/version_import') }}"
                            class="@php echo ($file == 'version_import') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Import</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_version')
                        <li>
                            <a href="/admin/edit_version/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_version') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        
        @if (has_module_access('book_menu'))
            <li class="nav-heading">Books Configuration info</li>
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'book_list' || $file == 'add_book' || $file == 'book_import' || $filename[1] == 'edit_book') ? 'collapse active':'collapsed' @endphp"
                    data-bs-target="#book_list" data-bs-toggle="collapse"
                    @if ($file == 'book_list' || $file == 'add_book' || $file == 'import' || $filename[1] == 'edit_book') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/book_list') }}">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">📚</i><span>Book Info</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="book_list"
                    class="nav-content collapse @if ($file == 'book_list' || $file == 'add_book' || $file == 'book_import' || $filename[1] == 'edit_book') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        @if ($filename[1] == 'edit_book')
                            <a href="{{ url('admin/book_list') . '#' . $file }}"
                                class="@php echo ($file == 'book_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @else
                            <a href="{{ url('admin/book_list') }}"
                                class="@php echo ($file == 'book_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ url('admin/add_book') }}"
                            class="@php echo ($file == 'add_book') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/book_import') }}"
                            class="@php echo ($file == 'book_import') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Import</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_book')
                        <li>
                            <a href="/admin/edit_book/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_book') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        @if (has_module_access('verse_menu'))
            <li class="nav-heading">Verse Configuration info</li>
            <li class="nav-item">
                <a class="nav-link  @php echo ($file == 'verse_list' || $file == 'add_verse' || $file == 'verse_import' || $filename[1] == 'edit_verse') ? 'collapse active':'collapsed' @endphp"
                    data-bs-target="#verse_list" data-bs-toggle="collapse"
                    @if ($file == 'verse_list' || $file == 'add_verse' || $file == 'import' || $filename[1] == 'edit_verse') {{ 'aria-expanded="true"' ?? 'aria-expanded="false"' }} @endif
                    href="{{ url('admin/verse_list') }}">
                    <i style="font-size: 42px;margin: 0px;font-style: normal;padding-top: 15px;padding-left: 8px;color: #8e44ad;">❞</i><span>Verse Info</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="verse_list"
                    class="nav-content collapse @if ($file == 'verse_list' || $file == 'add_verse' || $file == 'verse_import' || $filename[1] == 'edit_verse') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        @if ($filename[1] == 'edit_verse')
                            <a href="{{ url('admin/verse_list') . '#' . $file }}"
                                class="@php echo ($file == 'verse_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @else
                            <a href="{{ url('admin/verse_list') }}"
                                class="@php echo ($file == 'verse_list') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>List</span>
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{ url('admin/add_verse') }}"
                            class="@php echo ($file == 'add_verse') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/verse_import') }}"
                            class="@php echo ($file == 'verse_import') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Import</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_verse')
                        <li>
                            <a href="/admin/edit_verse/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_verse') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif


        @if (has_module_access('admin_menu'))
            <li class="nav-heading">Admin Configuration info</li>

            <li class="nav-item">
                <a class="nav-link @php echo ($file == 'superadmin' || $file == 'admin_add_sub_admin' || $filename[1] == 'edit_admin') ? 'collapse':'collapsed' @endphp @php echo ($file == 'superadmin' || $file == 'admin_add_sub_admin' || $filename[1] == 'edit_admin') ? 'active':'' @endphp"
                    data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                    <i style="font-size: 22px;margin: 0px;font-style: normal;">🛠️ </i><span>Admin Info</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="admin-nav"
                    class="nav-content collapse @if ($file == 'superadmin' || $file == 'admin_add_sub_admin' || $filename[1] == 'edit_admin') {{ 'show' ?? '' }} @endif"
                    data-bs-parent="#sidebar-nav" style="margin: -3px !important;">
                    <li>
                        <a href="{{ url('admin/superadmin') }}"
                            class="@php echo ($file == 'superadmin') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/admin_add_sub_admin') }}"
                            class="@php echo ($file == 'admin_add_sub_admin') ? 'active':'' @endphp">
                            <i class="bi bi-circle"></i><span>Add</span>
                        </a>
                    </li>
                    @if ($filename[1] == 'edit_admin')
                        <li>
                            <a href="/admin/edit_admin/{{ $file }}"
                                class="@php echo ($filename[1] == 'edit_admin') ? 'active':'' @endphp">
                                <i class="bi bi-circle"></i><span>Manage</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="nav-heading">User Pages</li>

        <li class="nav-item">
            <a class="nav-link @php echo ($file == 'profile_update') ? 'collapse active':'collapsed' @endphp"
                href="{{ url('admin/profile_update') }}"
                class="@php echo ($file == 'profile_update') ? 'active':'' @endphp">
                <i style="font-size: 22px;margin: 0px;font-style: normal;">🧑‍💼 </i>
                <span>Profile Info</span>
            </a>
        </li>

        <!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.logout') }}">
                <i style="font-size: 22px;margin: 0px;font-style: normal;">🔚</i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatBox = document.querySelector(".sidebar-nav");

        // Check if chatBox exists
        if (chatBox) {
            if (chatBox.classList.contains("active")) {
                scrollToBottom(chatBox);
            } else {
                scrollToActiveLi(chatBox);
            }
        }

        function scrollToBottom(container) {
            container.scrollTop = container.scrollHeight;
        }

        function scrollToActiveLi(container) {
            const activeLi = container.querySelector(".nav-content.show li a.active");
            if (activeLi) {
                activeLi.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                    inline: "center"
                });
            }
        }
    });

</script>

