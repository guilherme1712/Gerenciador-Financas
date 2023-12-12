<!-- resources/views/layouts/menu.blade.php -->

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
                margin: 0px;
                padding: 0px;
                overflow: hidden;
            }

            #menu {
                width: 15%;
                height: 100vh;
                background-color: #333;
                color: #fff;
                float: left;
                position: fixed;
            }

            #col-content {
                width: 85%;
                height: 100vh;
                margin-left: 15%;
            }

            iframe {
                width: 100%;
                height: 100%;
                border: none;
            }
        </style>

    </head>
    <body>
        <div class="menu" id="menu">
            @yield('content-menu')
        </div>

        <div class="col-content" id="col-content">
            <iframe id="gerenciador-frame" src="/APIs/Laravel/Gerenciador-Financas/public/financas"></iframe>
        </div>
    </body>
</html>
