    
<style>
    .alert-danger {
        border: 0;
        position: relative;
        padding: 0.95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        background-color: #fff;
        border-left: 5px solid red !important;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        font-size: 18px;
        text-decoration: underline white;
        color: red;
    }

    .alert-warning {
        border: 0;
        position: relative;
        padding: 0.95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        background-color: #fff;
        border-left: 4px solid #ffad46 !important;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        font-size: 18px;
        text-decoration: underline white;
        color: #ffad46;
    }

    .alert-success {
        border: 0;
        position: relative;
        padding: 0.95rem 1.25rem;
        border-radius: 1px;
        color: inherit;
        font-size: 16px;
        background-color: #fff;
        border-left: 5px solid green !important;
        color: green;
        -webkit-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        -moz-box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
        box-shadow: 1px 1px 14px 0 rgba(18, 38, 63, .26);
    }

    .btn-add,
    .btn-add:hover {
        border-color: #7367EF !important;
        font-weight: bold;
        background: #7367EF !important;
        color: #ffffff !important;
        text-transform: uppercase !important;
        box-shadow: 0 8px 25px -8px #7367EF;
    }

    .all-clour {
        border-color: #7367EF !important;
        font-weight: bold;
        background: #7367EF !important;
        color: #ffffff !important;
        font-weight: bold;
        text-transform: uppercase !important;
        box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, .1), 4px 4px 15px -5px rgba(21, 114, 232, .4) !important;
        padding: 8px 14px !important;
        margin-left: 15px;
        border-radius: 5px !important;
        font-size: 16px !important;
        margin-top: 5px !important;
        margin-bottom: 5px !important;
        width: 100% !important;
        height: 44px !important;
        text-align: center !important;
        text-decoration: none !important;
        display: inline-block !important;
        transition: all 0.3s ease !important;
        cursor: pointer !important;
    }
</style>

<style>
    .sidebar-nav {
        --primary-color: #7367EF;
        --active-color: #0f47aa;
        --text-color: #7e87a2;
        --hover-bg: rgba(199, 199, 199, 0.2);
        --transition-speed: 0.2s;
    }

    /* Base nav link styles */
    .sidebar-nav .nav-link {
        height: 51px;
        padding: 8px 14px !important;
        margin: 2px 0;
        display: flex;
        align-items: center;
        transition: all var(--transition-speed) ease;
        border-radius: 5px;
    }

    /* Collapsed state */
    .sidebar-nav .nav-link.collapsed {
        color: var(--text-color);
        background: transparent !important;
    }

    /* Expanded/active state */
    .sidebar-nav .nav-link.collapse {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.1),
            4px 4px 15px -5px rgba(21, 114, 232, 0.4) !important;
    }

    /* Icon and text styling */
    .sidebar-nav .nav-link i {
        color: inherit;
        transition: color var(--transition-speed) ease;
    }

    .sidebar-nav .nav-link span {
        font-size: 16px;
        padding-left: 6px;
        margin-top: 0 !important;
        transition: all var(--transition-speed) ease;
    }

    /* Submenu styles */
    .sidebar-nav .nav-content {
        overflow: hidden;
        transition: height var(--transition-speed) ease;
    }

    .sidebar-nav .nav-content a {
        color: var(--text-color) !important;
        padding: 8px 15px 8px 65px;
        font-weight: 700;
        display: flex;
        transition: all var(--transition-speed) ease;
        position: relative;
    }

    .sidebar-nav .nav-content a:hover {
        background: var(--hover-bg);
        color: var(--active-color) !important;
        display: flex;
    }

    /* Active states */
    .sidebar-nav .nav-content a.active {
        background: var(--hover-bg);
        color: var(--active-color) !important;
        display: flex;
    }

    /* Focus styles for accessibility */
    .sidebar-nav .nav-link:focus,
    .sidebar-nav .nav-content a:focus {
        outline: 2px solid var(--active-color);
        outline-offset: 2px;
    }

    .sidebar-nav .nav-link.collapse {
        border-left: 4px solid;
        border-color: #ffc44e !important;
        background: linear-gradient(118deg, #7367f0, rgba(115, 103, 240, 0.7)) !important;
        box-shadow: 0 0 10px 1px rgba(115, 103, 240, 0.7) !important;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 4px;
        /* text-transform: uppercase !important; */
    }

    .sidebar-nav .nav-link.collapse i {
        color: #ffffff !important;
        /* text-transform: uppercase !important; */
    }

    .sidebar-nav .nav-content a {
        color: #7e87a2 !important;
        padding-left: 65px;
        font-weight: 700;
    }

    .sidebar-nav .nav-content a:hover {
        background: rgba(199, 199, 199, .2);
        color: #0f47aa !important;
        border-radius: 5px;
    }

    .sidebar-nav .nav-link:hover{
        color: #012970 !important;
    }

    .sidebar-nav .nav-link{
        color: #012970 !important;
    }

    .sidebar-nav .nav-link.active:hover{
        color: #ffffff !important;
    }
</style>

<style>
    .nav {
        display: flex !important;
        list-style: none !important;
        padding-left: 0 !important;
    }

    .nav-item {
        margin-right: 5px !important;
    }

    .nav-heading {
        width: 100% !important;
        padding-right: 15px !important;
        /* Adjust padding as needed */
        font-weight: bold !important;
    }

    input[type="text"],
    input[type="number"],
    input[type="password"],
    input[type="email"],
    select,
    {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        line-height: 1.5 !important;
        color: #495057 !important;
        background-color: #fff !important;
        background-clip: padding-box !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5) !important;
        width: 100% !important;
        height: 44px !important;
    }

    .alert-container {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 1100;
        width: 350px;
    }

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

    .fs-14 {
        font-size: 14px;
    }

    .fw-500 {
        font-weight: 600;
    }

    .form-control {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15);
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single {
        border: 2px solid #e3e6f0 !important;
        border-radius: 8px !important;
        height: 48px !important;
        line-height: 44px !important;
        background-color: #fff !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.15) !important;
    }

    /* .form-group label::before {
        content: "•";
        color: #1cc88a;
        font-weight: bold;
        margin-right: 8px;
        font-size: 18px;
    } */

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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>