<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/slider.css')}}" rel="stylesheet">
    <link href="{{ asset('sass/app.scss') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <style>
        body {
            font-family: 'Nunito';
        }

    </style>
</head>

<body class="antialiased">
    <nav class="navbar navbar-dark bg-dark justify-content-between sticky-top">
            <a class="navbar-brand">EPK</a>
            <div class="nav_link">
                <a  href="">Bands</a>
                <a  href="">Informatie</a>
                <a  href="">Contact</a>
            </div>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn btn-outline-secondary my-2 my-sm-0" style="color:#fff;" type="submit">Search</button>
        </form>

        <div class="">
            @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 sm:block">
                @auth
                <button class="btn btn-outline-secondary">
                    <a href="{{ url('/home') }}" style="color:#fff;" class="text-sm text-gray-700 underline">Home</a>
                </button>
                @else
                <button class="btn btn-outline-secondary">
                    <a href="{{ route('login') }}" style="color:#fff;" class="text-sm text-gray-700 underline">Login</a>
                </button>

                @if (Route::has('register'))
                <button class="btn btn-outline-secondary">
                    <a href="{{ route('register') }}" style="color:#fff;"
                        class="text-sm text-gray-700 underline">Register</a>
                </button>
                @endif
                @endif
            </div>
            @endif
        </div>
    </nav>


    <div id="slider" class="carousel slide" data-ride="carousel">
        <div class="welkom_txt"> Welkom</div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{url('/img/1.jpg')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{url('/img/2.jpg')}}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{url('/img/3.jpg')}}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

</body>

</html>
