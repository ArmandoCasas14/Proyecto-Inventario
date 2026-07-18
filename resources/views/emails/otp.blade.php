<!DOCTYPE html>
<html>
<head>
    <title>Código de verificación</title>
</head>
<body>
    <p>Hola {{ $user->name }},</p>
    <p>Tu código de verificación es: <strong>{{ $otp }}</strong></p>
    <p>Este código es válido por 5 minutos.</p>
    <p>Si no solicitaste este código, ignora este mensaje.</p>
</body>
</html>