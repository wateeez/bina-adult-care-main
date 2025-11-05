<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - Bina Adult Care</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            max-width: 450px;
            margin: 100px auto;
            padding: 2.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .login-header h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
        }

        .form-group input {
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 1.5rem;
            text-align: center;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .login-btn {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-btn:hover {
            background: var(--primary-dark);
        }

        .resend-link {
            text-align: center;
            margin-top: 1rem;
        }

        .resend-link a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }

        .info-box i {
            color: #2196F3;
            margin-right: 0.5rem;
        }

        .info-box p {
            margin: 0;
            color: #333;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-shield-alt"></i>
            <h1>Two-Factor Authentication</h1>
            <p>Enter the 6-digit code sent to your email</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <p><strong>Code expires in 10 minutes.</strong> Check your email inbox and spam folder.</p>
        </div>

        <form class="login-form" method="POST" action="{{ route('admin.verify2fa.submit') }}">
            @csrf
            <div class="form-group">
                <label for="code">Verification Code</label>
                <input 
                    type="text" 
                    id="code" 
                    name="code" 
                    maxlength="6" 
                    pattern="[0-9]{6}" 
                    placeholder="000000"
                    required 
                    autofocus
                    autocomplete="off"
                >
                @error('code')
                    <span style="color: #dc3545; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-check"></i> Verify & Login
            </button>
        </form>

        <div class="resend-link">
            <p>Didn't receive the code? 
                <form method="POST" action="{{ route('admin.resend2fa') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: var(--primary-color); cursor: pointer; text-decoration: underline;">
                        Resend Code
                    </button>
                </form>
            </p>
            <p style="margin-top: 0.5rem;">
                <a href="{{ route('admin.login') }}">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </p>
        </div>
    </div>

    <script>
        // Auto-format code input
        const codeInput = document.getElementById('code');
        codeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto-submit when 6 digits are entered
        codeInput.addEventListener('input', function(e) {
            if (this.value.length === 6) {
                this.form.submit();
            }
        });
    </script>
</body>
</html>
