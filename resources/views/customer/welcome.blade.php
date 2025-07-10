<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Toong Kopitiam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .kopitiam-card {
            max-width: 480px;
            border-radius: 1.5rem;
            padding: 2.5rem;
            background: #ffffff;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .kopitiam-title {
            color: #FF5722;
            font-weight: 700;
            font-size: 1.8rem;
        }

        .kopitiam-btn {
            background-color: #FF5722;
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .kopitiam-btn:hover {
            background-color: #e64a19;
        }

        .kopitiam-logo {
            width: 180px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
        }

        .qr-wrapper {
            border: 1px solid #eee;
            padding: 1rem;
            border-radius: 1rem;
            background-color: #fafafa;
            display: inline-block;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="kopitiam-card text-center">
        <!-- 🍽️ Logo -->
        <img src="{{ asset('images/logo.jpg') }}" alt="Toong Kopitiam Logo" class="kopitiam-logo mb-3">

        <!-- 🔥 Welcome Message -->
        <h1 class="kopitiam-title mb-2">Welcome to Toong Kopitiam</h1>
        <p class="text-secondary mb-4">Scan the QR code below or tap the button to view our digital menu.</p>

        <!-- 📱 QR Code -->
        <div class="qr-wrapper mb-4">
            {!! QrCode::size(200)->generate(url('/')) !!}
        </div>

        <!-- 🍴 View Menu Button -->
        <a href="{{ route('customer.index') }}" class="btn kopitiam-btn btn-lg w-100 text-white">
            View Menu
        </a>

        <!-- ℹ️ Info -->
        <p class="mt-3 text-muted small">
            If your camera can't scan, tap the button to proceed manually.
        </p>
    </div>

</body>
</html>
