<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UPEMARKET | REGISTRO</title>
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
            min-height: 100vh;
            position: relative;
        }

        /* Capa translúcida para suavizar el fondo */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 1;
        }

        .register-card {
            position: relative;
            z-index: 2;
            background: #bd6464;
            color: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            margin: 20px 0;
            box-sizing: border-box;
        }

        .register-card img {
            max-width: 90px;
            margin-bottom: 10px;
        }

        .register-card h2 {
            margin-bottom: 20px;
            color: white;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: white;
            text-align: center;
            font-size: 14px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: transparent;
            color: white;
            background-color: transparent;
            border-bottom: 2px solid white;
            font-size: 14px;
            box-sizing: border-box;
            text-align: center;
        }

        /* Estilo especial para opciones de select si se usa */
        .form-group option {
            background-color: #bd6464;
            color: white;
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
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: black;
            color: white;
        }

        .error-message {
            color: #ffcccc;
            font-size: 12px;
            margin-top: 3px;
            text-align: center;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
            color: white;
        }

        .login-link a {
            color: white;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-card">
    <img src="{{ asset('img/Logo Completo UPEMarket.png') }}" alt="Logo UPEMarket">
    <h2>Registro de Usuario</h2>

    <!-- Formulario apuntando a la ruta POST /registro -->
    <form action="{{ url('/registro') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required autofocus placeholder="ej. Juan Perez">
            @error('nombre')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Correo Institucional</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="correo@upemor.edu.mx">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="carrera">Carrera</label>
            <input type="text" id="carrera" name="carrera" value="{{ old('carrera') }}" required placeholder="ej. IID, IFI">
            @error('carrera')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono (10 dígitos)</label>
            <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="ej. 7771234567">
            @error('telefono')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="Min. 6 caracteres">
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>

    <div class="login-link">
        ¿Ya tienes cuenta? <a href="{{ url('/login') }}">Inicia Sesión</a>
    </div>
</div>

</body>
</html>
