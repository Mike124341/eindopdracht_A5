<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-dark justify-content-between sticky-top">
            <a class="navbar-brand">EPK</a>
            <div class="nav_link">
                <a href="">Bands</a>
                <a href="">Informatie</a>
                <a href="">Contact</a>
            </div>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn btn-outline-secondary my-2 my-sm-0" style="color:#fff;"
                    type="submit">Search</button>
            </form>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav" style="flex-direction:row;">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item" style="padding-right: 3px;">
                            <button class="btn btn-outline-secondary">
                                <a class="text-sm text-gray-700 underline" style="color:#fff;" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </button>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <button class="btn btn-outline-secondary">
                                <a class="text-sm text-gray-700 underline" style="color:#fff;" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </button>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="font-size: 18px;">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" style="background-color:#3490dc; min-width: 0rem !important; padding:
                                0 !important 0; margin: 0 !important; padding: 0px  !important; position:absolute;" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="{{ route('home') }}">
                                    {{ __('home') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('verzoeken') }}">
                                    {{ __('verzoeken') }}
                                </a>
                                
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
