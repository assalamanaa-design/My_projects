<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register medic-care</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('{{ asset('images/doctor-s-hand-holding-stethoscope-closeup.jpg') }}') center/cover no-repeat;

            height: 100vh;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 10%;
            backdrop-filter: blur(5px);
            animation: fadeIn 1s ease-out;
        }
        .login-container { width: 350px; animation: fadeIn 1.5s ease-out; }
        .login-box {
            background: white;
            padding: 30px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: fadeIn 2s ease-out;
        }
        .login-box h1 { font-size: 28px; font-weight: bold; margin-bottom: 10px; animation: fadeIn 2.5s ease-out; }
        .login-box p { font-size: 14px; color: #666; margin-bottom: 20px; animation: fadeIn 3s ease-out; }
        form label { display: block; text-align: left; font-size: 14px; font-weight: bold; margin-bottom: 5px; animation: fadeIn 3.5s ease-out; }
        form input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 10px; animation: fadeIn 4s ease-out; }
        button { width: 100%; padding: 10px; background: #247cff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: transform 0.3s ease, box-shadow 0.3s ease; animation: fadeIn 4.5s ease-out; }
        button:hover { background: #206bdb; transform: scale(1.05); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); }
        .forgot-password { display: block; margin-top: 15px; font-size: 14px; color: #666; text-decoration: none; animation: fadeIn 5s ease-out; }
        .forgot-password:hover { text-decoration: underline; }
        .error { background: #ffe6e6; padding: 10px; border: 1px solid #ff4d4d; border-radius: 5px; margin-bottom: 15px; color: #ff0000; text-align: left; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Medic Care</h1>
            <p>"Enter your name, email address, and password to create your secure account."</p>
            
            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" required>
                </div>
                <!-- Ici, le champ "type" n'est pas présenté car il est forcé à "premium_patient" dans le contrôleur -->
                <button type="submit">S'inscrire</button>
                <p class="forgot-password">
                    Already have an account ? <a href="{{ route('login.form') }}">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
