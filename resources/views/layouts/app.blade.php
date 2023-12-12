<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gerenciador Finanças</title>

        <!-- Estilos -->
        <link rel="stylesheet" href="{{ asset('css/site.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

        <!-- Ícone -->
        <link rel="icon" type="image/x-icon" href="{{ asset('img/1.ico') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/datatables.js') }}"></script>
        <!-- <script src="{{ asset('js/site.js') }}"></script> -->

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
            }

            .col-content {
                margin-left: 1%;
                margin-top: 10px;
            }

            .row {
                margin-right: 0px !important;
            }

        </style>

    </head>
    <body>
        <div class="col-content" id="col-content">
            @yield('content')
        </div>
    </body>
</html>
