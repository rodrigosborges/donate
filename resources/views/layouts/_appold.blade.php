<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!--  <title>{{ config('app.name', 'Donate') }}</title> -->
   <title>Donate</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    
    <!-- Icon -->
    <link rel="icon" type="image/png" href="{{asset('img/icones/donate.ico')}}">
    
    @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="logo text-white" href="{{ url('/') }}">
                   <!--  {{ config('app.name', 'Donate') }} -->
                   Donate
                </a>
                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                    <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            @if (Route::has('register'))
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Registrar') }}</a>
                            @endif
                        </li>
                    @else
                       <!--  <li class="nav-item espacamento-icon">
                            <a href="{{url('/usuarios/mensagens')}}"><i id="msg-icon" class="text-white fas fa-envelope"></i>
                        </li> -->
                       <!--  <span class="text-white nav-item">|</span> -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="text-white nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nome }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{url('/doacoes/create')}}" class="dropdown-item">Anunciar</a>
                                 <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/usuarios/perfil/'.Auth::id())}}">Meu Perfil</a>
                                 <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/doacoes/meus-anuncios')}}">Meus Anúncios</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{url('/usuarios/mensagens')}}">Mensagens</a>
                                <div class="dropdown-divider"></div>
                                @if(Auth::user()->nivel == 1)
                                <a class="dropdown-item" href="{{url('/doacoes/aguardando-aprovacao')}}">Aguardando Aprovação</a>
                                <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>


                            </div>
                        </li>
                    @endguest
                </ul>
            <!-- </div> -->
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div id="sidebar" class="py-5">
                   
                    <ul>
                        <li>LINK 1</li>
                        <li>LINK 2</li>
                        <li>LINK 3</li>
                        <li>LINK 4</li>

                    </ul>
                    
                </div>
            </div>

            <main class="py-4col-md-10 ml-sm-auto col-lg-10 pt-3 px-4">
                @yield('content')
            </main>
        </div>

        <footer>
            <div class="col-md-12 text-center">
                <span>2018 - Donate © - Todos os Direitos Reservados</span>
            </div>
        </footer>
    </div>
    @yield('js')
</body>
</html>
