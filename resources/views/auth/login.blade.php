<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UPEMARKET | INICIO DE SESIÓN</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-completo-upemarket.png') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url("{{ asset('img/Patron comercial.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        /* Capa translúcida para suavizar el fondo */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .login-card {
            position: relative;
            z-index: 2;
            background: #bd6464;
            color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-sizing: border-box;
        }

        .login-card img {
            max-width: 100px;
            margin-bottom: 15px;
        }

        .login-card h2 {
            margin-bottom: 24px;
            color: white;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: white;
            text-align: center;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: transparent;
            color: white;
            background-color: transparent;
            border-bottom: 2px solid white;
            font-size: 14px;
            box-sizing: border-box;
            text-align: center;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group input:focus {
            outline: none;
            border-color: white;
            box-shadow: none;
        }

        .btn-submit {
            width: 100%;
            background-color: white;
            color: red;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-submit:hover {
            background-color: black;
            color: white;
        }

        .error-message {
            color: #ffcccc;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Logo corregido con src -->
    <img src="{{ asset('img/Logo Completo UPEMarket.png') }}" alt="Logo UPEMarket">
    <h2>Iniciar Sesión</h2>

    <!-- Formulario apuntando a la ruta POST /login -->
    <form action="{{ url('/login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="tucorreo@upemor.edu.mx">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="********">
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Ingresar</button>
    </form>

    <p style="margin-top: 20px; font-size: 14px; color: white;">
        ¿No tienes cuenta?
        <a href="{{ url('/registro') }}" style="color: white; font-weight: bold; text-decoration: underline;">Regístrate</a>
    </p>
</div>

</body>
</html>
