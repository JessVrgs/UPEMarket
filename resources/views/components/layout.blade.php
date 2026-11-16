<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'UPEMARKET' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-completo-upemarket.png') }}">
</head>
<body>
{{ $slot }}
</body>
</html>
