<?php
/**
 * @copyright 2020
 */
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Facturación</title>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <script src="https://kit.fontawesome.com/d113d634ed.js" crossorigin="anonymous"></script>
        
        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="{{ mix('css/navbar.css') }}" rel="stylesheet">
        <link href="{{ mix('css/main.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="sidenav navbar navbar-expand-lg fixed-top">
                <div class="container">
                    <div class="navbar-translate">
                        <a class="navbar-brand">Facturación</a>
                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" 
                            class="btn btn-blue btn-raised btn-rab btn-round">
                                <i class="fas fa-home"></i> 
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="main main-raised">
            @yield('content') 
        </div>
    </body>
</html>