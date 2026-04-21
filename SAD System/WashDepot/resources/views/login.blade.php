<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WashDepot</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background-image: url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?w=1600');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.55);
            z-index: 0;
        }

        .navbar {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: white;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 30px;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-links a:hover { text-decoration: underline; }

        .main {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 60px 40px;
            min-height: calc(100vh - 80px);
        }

        .left-side {
            color: white;
            max-width: 380px;
            font-size: 14px;
            line-height: 1.8;
            align-self: flex-end;
            padding-bottom: 40px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 40px;
            border-radius: 12px;
            width: 340px;
            color: white;
        }

        .login-card h1 {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 24px;
            color: white;
        }

        .error-box {
            background: rgba(254,226,226,0.9);
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
            color: white;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            background: rgba(255,255,255,0.9);
            outline: none;
        }

        .forgot {
            text-align: center;
            margin: 14px 0;
        }

        .forgot a {
            color: white;
            font-size: 13px;
            text-decoration: none;
        }

        .forgot a:hover { text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 8px;
        }

        .btn-login:hover { background-color: #1d4ed8; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">WashDepot</div>
        <div class="nav-links">
            <a href="/login">LOGIN</a>
            <a href="/queue-status">QUEUE STATUS</a>
        </div>
    </nav>

    <div class="main">

        <div class="left-side">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Donec rutrum posuere ornare. Proin enim turpis, pellentesque
            quis mattis eu, aliquam ac augue. Integer elit libero, dapibus
            in aliquet at, posuere vel justo.</p>
        </div>

        <div class="login-card">
            <h1>Login</h1>

            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/login">
                @csrf

                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password">
                </div>

                <div class="forgot">
                    <a href="/forgot-password">Forgot Password</a>
                </div>

                <button type="submit" class="btn-login">Login</button>

            </form>
        </div>

    </div>

</body>
</html>