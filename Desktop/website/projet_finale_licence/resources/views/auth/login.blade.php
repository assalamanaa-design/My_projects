<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
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
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('{{ asset('images/doctor-s-hand-holding-stethoscope-closeup.jpg') }}') center/cover; 
            height: 100vh;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 10%;
            backdrop-filter: blur(5px);
        }
        .login-container {
            width: 350px;
            animation: fadeIn 1s ease-out;
        }
        .login-box {
            background: white;
            padding: 30px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1.5s ease-out;
        }
        .login-box h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            animation: fadeIn 2s ease-out;
        }
        .login-box p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            animation: fadeIn 2.5s ease-out;
        }
        form label {
            display: block;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            animation: fadeIn 2s ease-out;
        }
        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            animation: fadeIn 2.5s ease-out;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #247cff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 3s ease-out;
        }
        button:hover {
            background: #206bdb;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .forgot-password {
            display: block;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
            text-decoration: none;
            animation: fadeIn 3.5s ease-out;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .forgot-password .Register {
            color: black;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Medic Care</h1>
            <p>Enter your email address and password to access your secure space.</p>
            
            <form action="{{ route('login') }}" method="POST">
             @csrf
             <label>Email address</label>
             <input type="email" name="email" placeholder="Enter your email" required>

             <label>Password</label>
             <input type="password" name="password" placeholder="Enter your password" required>

                  <button type="submit">Sign In</button>
            </form>


            <p class="forgot-password">Don't have an account? <a href="{{ route('register') }}" class="Register"><strong>Register</strong></a></p>
        </div>
    </div>
</body>
</html>
