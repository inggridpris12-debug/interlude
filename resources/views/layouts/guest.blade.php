<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Interlude' }} — Jeda untuk berbagi cerita</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --linen: #FFEDE3;
            --tangelo: #FB4D00;
            --brown: #49261D;
            --blue: #CAE7F7;
            --cream: #FFFAF6;
            --white: #FFFFFF;
            --text-soft: #705D55;
            --border: #E9DCD4;
            --error: #EF4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--brown);
            line-height: 1.6;
        }

        /* NAVBAR */
        .navbar {
            padding: 20px 7%;
            background: var(--cream);
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -1px;
            color: var(--brown);
            text-decoration: none;
        }

        .logo span { color: var(--tangelo); }

        /* AUTH CONTAINER */
        .auth-container {
            min-height: calc(100vh - 80px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
        }

        .auth-box {
            width: 100%;
            max-width: 440px;
            background: var(--white);
            border-radius: 20px;
            padding: 48px;
            border: 1.5px solid var(--border);
            box-shadow: 0 10px 40px rgba(73, 38, 29, 0.08);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--brown);
        }

        .auth-subtitle {
            font-size: 15px;
            color: var(--text-soft);
        }

        /* FORM STYLES */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--brown);
        }

        .form-input {
            width: 100%;
            height: 48px;
            padding: 0 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: 0.2s;
        }

        .form-input:focus {
            border-color: var(--tangelo);
            box-shadow: 0 0 0 4px rgba(251, 77, 0, 0.1);
        }

        .form-input.error {
            border-color: var(--error);
        }

        .form-error {
            color: var(--error);
            font-size: 13px;
            margin-top: 6px;
        }

        /* CHECKBOX */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 1.5px solid var(--border);
            border-radius: 5px;
            cursor: pointer;
        }

        .checkbox-label {
            font-size: 14px;
            color: var(--text-soft);
            cursor: pointer;
        }

        /* BUTTON */
        .btn-submit {
            width: 100%;
            height: 50px;
            background: var(--tangelo);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #e04400;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(251, 77, 0, 0.3);
        }

        /* LINK */
        .auth-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: var(--text-soft);
        }

        .auth-link a {
            color: var(--tangelo);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        /* DIVIDER */
        .divider {
            display: flex;
            align-items: center;
            margin: 28px 0;
            color: var(--text-soft);
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            padding: 0 16px;
        }

        /* SOCIAL BUTTON */
        .btn-social {
            width: 100%;
            height: 48px;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-social:hover {
            background: var(--cream);
            border-color: var(--brown);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="/" class="logo">Interlude<span>.</span></a>
    </nav>

    <div class="auth-container">
        <div class="auth-box">
            {{ $slot }}
        </div>
    </div>
</body>
</html>