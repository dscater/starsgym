@inject('configuracion', 'App\Models\Configuracion')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $configuracion->first()->alias }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/plantilla.css') }}">
    <style>
        html {
            height: 100%;
            width: 100%;
        }

        body {
            height: 100% !important;
            min-height: 100% !important;
            width: 100%;
        }

        #app {
            height: 100vh;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="app">
        <Control ruta="{{ route('base_path') }}" logo="{{ asset('imgs/' . $configuracion->first()->logo) }}"
            empresa="{{ $configuracion->first()->razon_social }}" configuracion="{{ $configuracion->first() }}">
        </Control>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/plantilla.js') }}"></script>
    <script></script>
</body>

</html>
