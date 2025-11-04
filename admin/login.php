<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bina Adult Care</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--secondary-color);
            padding: 2rem;
        }

        .login-form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .btn-container {
            text-align: center;
        }

        .btn-container .btn {
            width: 100%;
        }

        .back-to-home {
            text-align: center;
            margin-top: 1rem;
        }

        .back-to-home a {
            color: var(--primary-color);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h1>Admin Login</h1>
            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn primary">Login</button>
                </div>
            </form>
            <div class="back-to-home">
                <a href="../index.php">← Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Clear any previous error messages
            const errorDiv = document.getElementById('error-message');
            if (errorDiv) {
                errorDiv.remove();
            }

            $.ajax({
                url: '../api/auth/login',
                method: 'POST',
                data: {
                    email: email,
                    password: password
                },
                success: function(response) {
                    console.log('Login response:', response);
                    if (response.success) {
                        // Redirect to dashboard
                        window.location.href = 'dashboard.php';
                    } else {
                        const errorDiv = document.createElement('div');
                        errorDiv.id = 'error-message';
                        errorDiv.style.color = 'red';
                        errorDiv.style.marginTop = '1rem';
                        errorDiv.style.textAlign = 'center';
                        errorDiv.textContent = response.message || 'Invalid credentials. Please try again.';
                        document.getElementById('loginForm').appendChild(errorDiv);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Login error:', { status, error, response: xhr.responseText });
                    const errorDiv = document.createElement('div');
                    errorDiv.id = 'error-message';
                    errorDiv.style.color = 'red';
                    errorDiv.style.marginTop = '1rem';
                    errorDiv.style.textAlign = 'center';
                    errorDiv.textContent = 'Login failed. Please try again later.';
                    document.getElementById('loginForm').appendChild(errorDiv);
                }
            });
        });
    </script>
</body>
</html>