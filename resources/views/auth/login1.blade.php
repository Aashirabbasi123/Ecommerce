<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ih SeaFood</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            list-style-type: none;
            border: none;
            outline: none;
            font-family: Poppins, sans-serif;
            color: #fff;
        }

        .content .input-box input {
            width: 100%;
            height: 100%;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 14px 20px;
            font-size: 15px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .content .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        .content .input-box input:focus {
            border-color: #ffffff;
            background-color: rgba(255, 255, 255, 0.25);
            outline: none;
        }

        body {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url("https://i.postimg.cc/RFqSM2rc/bg.jpg");
            background-size: cover;
            background-position: center;
        }

        .content {
            width: 400px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(13px);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px 35px;
        }

        .content h2 {
            font-size: 38px;
            font-weight: 700;
            text-align: center;
        }

        .content .input-box {
            position: relative;
            width: 100%;
            height: 55px;
            margin: 30px 0;
        }

        .content .input-box input {
            background: transparent;
            width: 100%;
            height: 100%;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            padding: 20px 45px 20px 20px;
            font-size: 16px;
        }

        input::placeholder {
            color: #fff;
            font-size: 16px;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #fff;
        }

        .content .remember {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -16px 0 16px;
        }

        .remember label input {
            accent-color: #fff;
            margin-right: 4px;
        }

        .remember a {
            color: #fff;
            text-decoration: none;
        }

        .remember a:hover {
            text-decoration: underline;
        }

        .btnn {
            display: inline-block;
            background: #fff;
            color: #0a2862;
            width: 100%;
            border-radius: 30px;
            font-size: 16px;
            height: 45px;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-bottom: 30px;
            margin-top: 16px;
        }

        .button {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
        }

        .button a {
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
        }

        .button a i {
            font-size: 20px;
            margin-right: 8px;
        }

        .button a:hover {
            opacity: 0.8;
        }

        input[type="checkbox"] {
            display: inline-block;
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        input::-webkit-credentials-auto-fill-button,
        input::-webkit-clear-button,
        input::-webkit-inner-spin-button,
        input::-webkit-contacts-auto-fill-button {
            display: none !important;
            visibility: hidden !important;
            pointer-events: none;
            height: 0;
            width: 0;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="content">
        <form method="POST" action={{ route('auth.login1') }} name="login-form">
            @csrf
            <h2>Login</h2>
            <div class="input-box">
                <input id="email" type="email" name="email" placeholder="Email Address *" value="{{ old('email') }}"
                    required autofocus autocomplete="username">
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-box">
                <input id="password" type="password" name="password" placeholder="Password *" required
                    autocomplete="current-password">
                <i class="ri-eye-off-fill toggle-password" id="togglePassword"></i>
                @error('password')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember">
                <label><input type="checkbox" />Remember me</label>
            </div>
            <button type="submit" class="btnn">Login</button>
        </form>
    </div>
    <script>
        const input = document.getElementById("password");
        const toggle = document.getElementById("togglePassword");
        toggle.addEventListener("click", () => {
            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";
            toggle.className = isPassword
                ? "ri-eye-fill toggle-password"
                : "ri-eye-off-fill toggle-password";
        });

    </script>
</body>

</html>