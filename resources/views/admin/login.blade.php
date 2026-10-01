<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="csrf_token_placeholder" />

    <title>Bible App - Admin Login</title>
    <meta content="Modern admin login for Bible App" name="description">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background elements */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .floating-shapes {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-shapes:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
            width: 80px;
            height: 80px;
        }

        .floating-shapes:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
            width: 120px;
            height: 120px;
        }

        .floating-shapes:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
            width: 60px;
            height: 60px;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .app-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .app-logo i {
            font-size: 36px;
            color: white;
        }

        .app-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .app-subtitle {
            color: #718096;
            font-size: 16px;
            line-height: 1.5;
        }

        .date-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-input.has-icon {
            padding-right: 50px;
        }

        .input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .input-icon:hover {
            color: #667eea;
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #a0aec0;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #e53e3e;
        }

        .captcha-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            justify-content: center;
        }

        .captcha-image {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
        }

        .refresh-btn {
            background: #48bb78;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            background: #38a169;
            transform: rotate(180deg);
        }

        .otp-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin: 20px 0;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .otp-input:disabled {
            background: #f7fafc;
            color: #a0aec0;
        }

        /* Validation styles */
        .form-input.is-invalid {
            border-color: #e53e3e;
            box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
        }

        .form-input.is-valid {
            border-color: #48bb78;
            box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
        }

        .invalid-feedback {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 6px;
            display: none;
        }

        .valid-feedback {
            color: #48bb78;
            font-size: 14px;
            margin-top: 6px;
            display: none;
        }

        .form-input.is-invalid+.invalid-feedback {
            display: block;
        }

        .form-input.is-valid+.valid-feedback {
            display: block;
        }

        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                margin: 20px;
                padding: 30px 20px;
            }

            .date-badge {
                position: static;
                display: inline-block;
                margin-bottom: 20px;
            }
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .preloader.active {
            display: flex;
        }

        .pulse-loader {
            display: flex;
            gap: 8px;
        }

        .pulse-loader div {
            width: 16px;
            height: 16px;
            background: #3498db;
            border-radius: 50%;
            animation: pulse 1.2s infinite ease-in-out;
        }

        .pulse-loader div:nth-child(1) {
            animation-delay: -0.32s;
        }

        .pulse-loader div:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes pulse {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        /* Toastr Custom Styles - Override Defaults */
        .toast-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .toast-message {
            font-size: 14px;
            line-height: 1.4;
        }

        .toast-close-button {
            position: relative;
            right: -3px;
            top: -3px;
            font-size: 18px;
            color: inherit;
            opacity: 0.6;
        }

        .toast-close-button:hover {
            opacity: 1;
        }

        /* Toast Container Positioning */
        #toast-container {
            position: fixed;
            z-index: 999999;
        }

        #toast-container.toast-top-full-width {
            top: 0;
            right: 0;
            left: 0;
            width: 100%;
        }

        #toast-container.toast-bottom-full-width {
            bottom: 0;
            right: 0;
            left: 0;
            width: 100%;
        }

        /* Individual Toast Styling */
        .toast-center {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 9999 !important;
            width: auto !important;
        }

        /* Top-right position for error messages */
        .toast-top-right {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 9999 !important;
            width: auto !important;
        }

        .toast {
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
            font-size: 16px !important;
            padding: 20px 25px !important;
            min-width: 300px !important;
            text-align: center !important;
        }

        .toast:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            opacity: 1 !important;
        }

        /* Progress Bar */
        .toast-progress {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 8px 8px;
        }

        /* Toast Types */
        .toast-success {
            background-color: #22c55e;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M22 11.08V12a10 10 0 1 1-5.93-9.14'%3E%3C/path%3E%3Cpolyline points='22 4 12 14.01 9 11.01'%3E%3C/polyline%3E%3C/svg%3E");
        }

        .toast-error {
            background-color: #ef4444;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cline x1='15' y1='9' x2='9' y2='15'%3E%3C/line%3E%3Cline x1='9' y1='9' x2='15' y2='15'%3E%3C/line%3E%3C/svg%3E");
        }

        .toast-info {
            background-color: #3b82f6;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cline x1='12' y1='16' x2='12' y2='12'%3E%3C/line%3E%3Cline x1='12' y1='8' x2='12.01' y2='8'%3E%3C/line%3E%3C/svg%3E");
        }

        .toast-warning {
            background-color: #f59e0b;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z'%3E%3C/path%3E%3Cline x1='12' y1='9' x2='12' y2='13'%3E%3C/line%3E%3Cline x1='12' y1='17' x2='12.01' y2='17'%3E%3C/line%3E%3C/svg%3E");
        }

        /* Animation Overrides */
        .toast {
            animation-duration: 0.4s;
            animation-fill-mode: both;
        }

        .toast-show {
            animation-name: toastSlideIn;
        }

        .toast-hide {
            animation-name: toastSlideOut;
        }

        @keyframes toastSlideIn {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes toastSlideOut {
            from {
                transform: translateY(0);
                opacity: 1;
            }

            to {
                transform: translateY(100%);
                opacity: 0;
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {

            #toast-container.toast-top-full-width>div,
            #toast-container.toast-bottom-full-width>div {
                width: 100%;
                margin: 0 0 8px 0;
                border-radius: 0;
            }

            .toast {
                width: 100%;
                padding: 12px 16px 12px 50px;
                background-size: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="floating-shapes"></div>
        <div class="floating-shapes"></div>
        <div class="floating-shapes"></div>
    </div>

    <div class="preloader" id="preloader">
        <div class="pulse-loader">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Main Login Container -->
    <div class="login-container">
        <div class="date-badge" id="currentDate">
            Thu 29, May 2025
        </div>

        <div class="header-section">
            <div class="app-logo">
                <i class="fas fa-bible"></i>
            </div>
            <h1 class="app-title">Bible App</h1>
            <p class="app-subtitle">
                Admin Dashboard - Multiple modules like Quotes, Videos, Wallpapers, Daily Verses for enriched spiritual
                experience
            </p>
        </div>

        <form id="loginForm" method="POST" action="{{ route('admin.auth') }}" novalidate>
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">
                    Username / Email <span style="color: #e53e3e;">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="Enter your email address" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    Password <span style="color: #e53e3e;">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-input has-icon"
                        placeholder="Enter your password" required>
                    <i class="fas fa-eye-slash input-icon" id="togglePassword"></i>
                    <div class="invalid-feedback">Please enter your password.</div>
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>

            <div class="form-group">
                <label for="secretKey" class="form-label">
                    Unlock Your Account <span style="color: #e53e3e;">*</span>
                </label>
                <div class="input-wrapper">
                    <input type="text" id="secretKey" name="password2" class="form-input"
                        placeholder="Enter your secret key" required autocomplete="off">
                    <div class="invalid-feedback">Please enter your secret key.</div>
                    <div class="valid-feedback">Looks good!</div>
                </div>
            </div>

            <button type="button" class="btn-primary" id="loginBtn">
                <span id="btnText">Gain Access</span>
                <div class="spinner" id="btnSpinner" style="display: none;"></div>
            </button>
    </div>

    <!-- Captcha Modal -->
    <div class="modal" id="captchaModal">
        <div class="modal-content">
            <span class="modal-close" id="modalClose">&times;</span>
            <h3 style="text-align: center; margin-bottom: 20px; color: #2d3748;">Verify Security Code</h3>

            <div class="captcha-container">
                <span>{!! captcha_img('flat', ['characters' => '0123456789', 'class' => 'img-responsive'], 'numeric', 4)
                    !!}</span>
                <button type="button" class="refresh-btn" id="refreshCaptcha">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>

            <div class="otp-container">
                <input type="text" class="otp-input" maxlength="1" name="captcha1">
                <input type="text" class="otp-input" maxlength="1" name="captcha2" disabled>
                <input type="text" class="otp-input" maxlength="1" name="captcha3" disabled>
                <input type="text" class="otp-input" maxlength="1" name="captcha4" disabled>
            </div>

            <button type="button" class="btn-primary" id="verifyBtn">
                Verify & Sign In
            </button>
        </div>
    </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        // Current date display
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const options = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);
        });


        // Password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this;
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });


        // Form validation
        function validateForm() {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const secretKey = document.getElementById('secretKey');
            let isValid = true;

            // Reset validation states
            [email, password, secretKey].forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });

            // Email validation
            if (!email.value.trim()) {
                email.classList.add('is-invalid');
                isValid = false;
            } else if (!/\S+@\S+\.\S+/.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            } else {
                email.classList.add('is-valid');
            }

            // Password validation
            if (!password.value.trim()) {
                password.classList.add('is-invalid');
                isValid = false;
            } else {
                password.classList.add('is-valid');
            }

            // Secret key validation
            if (!secretKey.value.trim()) {
                secretKey.classList.add('is-invalid');
                isValid = false;
            } else {
                secretKey.classList.add('is-valid');
            }

            return isValid;
        }


        // Modal functionality
        const modal = document.getElementById('captchaModal');
        const loginBtn = document.getElementById('loginBtn');
        const modalClose = document.getElementById('modalClose');

        loginBtn.addEventListener('click', function() {
            if (validateForm()) {
                modal.classList.add('active');
                // Focus first OTP input
                document.querySelector('.otp-input').focus();
            } else {
                toastr.error('Please fill in all required fields correctly.');
            }
        });


        modalClose.addEventListener('click', function() {
            modal.classList.remove('active');
            // Reset OTP inputs
            document.querySelectorAll('.otp-input').forEach((input, index) => {
                input.value = '';
                if (index > 0) input.disabled = true;
            });
        });


        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });


        // OTP input functionality
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('paste', function(e) {
                    const paste = e.clipboardData.getData('text').trim();
                    if (!/^[0-9]{4}$/.test(paste)) {
                        e.preventDefault();
                        return;
                    }

                    const digits = paste.split('');
                    otpInputs.forEach((otpInput, i) => {
                        otpInput.value = digits[i] || '';
                        if (i > 0) otpInput.disabled = false;
                    });
                    
                    otpInputs[3].focus();
                });

                input.addEventListener('input', function() {
                    const value = this.value.replace(/[^0-9]/g, '');
                    this.value = value;

                    if (value && index < 3) {
                        otpInputs[index + 1].disabled = false;
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        otpInputs[index - 1].focus();
                        if (index < 3) {
                            otpInputs[index + 1].disabled = true;
                            otpInputs[index + 1].value = '';
                        }
                    }
                });
            });

            // Focus first input initially
            if (otpInputs.length > 0) {
                otpInputs[0].focus();
            }
        });


        // Captcha refresh
        document.getElementById('refreshCaptcha').addEventListener('click', function() {
            const btn = this;
            btn.style.transform = 'rotate(180deg)';
            
            // Reset OTP inputs
            document.querySelectorAll('.otp-input').forEach((input, index) => {
                input.value = '';
                if (index > 0) input.disabled = true;
            });
            var captchaImage = document.querySelector('.captcha-container img');
            captchaImage.src = captchaImage.src.split('?')[0] + '?' + Math.random();
            
            // Simulate captcha refresh - in real implementation, this would make an AJAX call
            setTimeout(() => {
                btn.style.transform = 'rotate(0deg)';
                document.querySelector('.otp-input').focus();
            }, 500);
        });


        // Initialize toastr with custom settings
        // Default Toastr configuration
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right", // Default position for errors
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };


        // Custom function to show success messages in center
        function showSuccessCenter(message, title = 'Success') {
            // Temporarily change position for success messages
            const originalPosition = toastr.options.positionClass;
            toastr.options.positionClass = 'toast-center';
            toastr.success(message, title);
            // Reset to original position
            toastr.options.positionClass = originalPosition;
            document.getElementById('preloader').classList.add('active');
        }

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @elseif (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif (Session::has('message'))
            showSuccessCenter("{{ Session::get('message') }}")
        @endif


        // Verify and submit
        document.getElementById('verifyBtn').addEventListener('click', function() {
            const otpValues = Array.from(document.querySelectorAll('.otp-input')).map(input => input.value);
            const captcha = otpValues.join('');

            if (captcha.length !== 4) {
                toastr.error('Please enter the complete verification code.');
                return;
            }

            // Show preloader
            document.getElementById('preloader').classList.add('active');
            
            // Simulate login process
            setTimeout(() => {
                modal.classList.remove('active');
                showSuccessCenter('Login successful! Redirecting...');
                
                setTimeout(() => {
                    // In real implementation, submit the form
                    showSuccessCenter('Welcome to the Bible App Admin Dashboard!', 'Welcome');
                    $('#loginForm').submit();
                    document.getElementById('preloader').classList.remove('active');
                }, 1000);
                
            }, 2000);
        });


        // Input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

    </script>

</body>

</html>