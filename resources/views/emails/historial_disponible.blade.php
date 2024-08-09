<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Médico Disponible</title>
</head>
<body>
    <h1>Hola, {{ $paciente->nombres }} {{ $paciente->apellidos }}</h1>
    <p>Tu historial médico ya está disponible. Puedes acceder a él haciendo clic en el siguiente enlace:</p>
    
    <p>
        <a href="{{ $link }}" style="display: inline-block; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
            Ver Historial Médico
        </a>
    </p>

    <p>Gracias por confiar en nuestros servicios.</p>

    <p>Saludos,<br>El equipo de TuApp</p>
</body>
</html>
