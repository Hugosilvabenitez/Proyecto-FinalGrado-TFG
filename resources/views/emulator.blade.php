<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $rom->title }} · GameFlux</title>
    <style>
        :root {
            color-scheme: dark;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top, rgba(56, 189, 248, 0.18), transparent 35%),
                linear-gradient(180deg, #020617 0%, #0f172a 100%);
            color: #e2e8f0;
            display: grid;
            place-items: center;
        }

        .panel {
            width: min(720px, calc(100vw - 32px));
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 24px;
            background: rgba(15, 23, 42, 0.85);
            box-shadow: 0 20px 80px rgba(15, 23, 42, 0.45);
        }

        h1 {
            margin: 0 0 12px;
            font-size: 28px;
        }

        p {
            margin: 0 0 14px;
            color: #cbd5e1;
            line-height: 1.6;
        }

        code,
        a {
            color: #67e8f9;
        }
    </style>
</head>
<body>
    @if ($emulatorReady)
        <script>
            window.location.replace(@json($emulatorIndexUrl));
        </script>
        <div class="panel">
            <h1>Abriendo {{ $rom->title }}</h1>
            <p>Si no te redirige automaticamente, abre el emulador manualmente:</p>
            <p><a href="{{ $emulatorIndexUrl }}">Lanzar emulador</a></p>
        </div>
    @else
        <div class="panel">
            <h1>Faltan los archivos del emulador</h1>
            <p>El catalogo ya esta listo, pero en este repositorio no existe <code>public/emulator/gbajs2/index.html</code>, asi que todavia no puedo arrancar la ROM seleccionada.</p>
            <p>Juego seleccionado: <strong>{{ $rom->title }}</strong></p>
            <p>La ruta segura de la ROM ya funciona y queda preparada para cuando copies el emulador completo:</p>
            <p><a href="{{ $romUrl }}">{{ $romUrl }}</a></p>
        </div>
    @endif
</body>
</html>
