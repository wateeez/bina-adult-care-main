<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exception->getStatusCode() }} - Error | Bina Adult Care</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .error-container {
            text-align: center;
            background: white;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: 100px;
            font-weight: bold;
            color: #667eea;
            margin: 0;
            line-height: 1;
            text-shadow: 4px 4px 0px rgba(102, 126, 234, 0.2);
        }

        .error-icon {
            font-size: 80px;
            color: #667eea;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: 2rem;
            color: #333;
            margin: 20px 0;
        }

        .error-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-btn {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .error-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 40px 20px;
            }

            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h1 class="error-code">{{ $exception->getStatusCode() }}</h1>
            <h2 class="error-title">Something Went Wrong</h2>
            <p class="error-message">
                @if($exception->getStatusCode() == 403)
                    You don't have permission to access this page.
                @elseif($exception->getStatusCode() == 500)
                    We're experiencing technical difficulties. Please try again later.
                @elseif($exception->getStatusCode() == 503)
                    We're currently performing maintenance. We'll be back soon!
                @else
                    An error occurred while processing your request.
                @endif
            </p>
            
            <a href="{{ route('home') }}" class="error-btn">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>
