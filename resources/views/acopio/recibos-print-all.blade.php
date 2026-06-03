<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Recibo</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        .titulo {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .subtitulo {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

</head>

<body onload="window.print()">

    @foreach($productores as $productor)

    @include('acopio.partials.recibo',['productor' => $productor])

    @unless($loop->last)

    <div class="page-break"></div>

    @endunless

    @endforeach

</body>

</html>