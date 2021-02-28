<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1LBTWDK701"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-1LBTWDK701');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('description')">

    @if(\Route::current() -> getName() == 'index')
        <meta property="og:title" content="{{ config('app.name', 'Laravel') }}" />
    @else
        <meta property="og:title" content="@yield('title') | {{ config('app.name', 'Laravel') }}" />
    @endif
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:image" content="{{ config('asset_url', 'https://find-my-pet.net') }}/images/screenshot.png" />
    <meta property="og:site_name"  content="{{ config('app.name', 'Laravel') }}" />
    <meta property="og:description" content="@yield('description')" />

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="" />
    @if(\Route::current() -> getName() == 'index')
        <meta name="twitter:title" content="{{ config('app.name', 'Laravel') }}" />
    @else
        <meta name="twitter:title" content="@yield('title') | {{ config('app.name', 'Laravel') }}" />
    @endif
    <meta name="twitter:url" content="{{ \Request::fullUrl() }}" />
    <meta name="twitter:description" content="@yield('description')" />
    <meta name="twitter:image" content="{{ config('asset_url', 'https://find-my-pet.net') }}/images/screenshot.png" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(\Route::current() -> getName() == 'index')
    <title>{{ config('app.name', 'Laravel') }}</title>
    @else
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="shadow-sm w-100">
            <div class="bg-warning pt-1 pb-1">
                <div class="container">
                    <span>迷子のペットを探すサイト</span>
                </div>
            </div>
            <nav class="navbar navbar-expand-md navbar-light bg-white">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('dog') }}"><i class="fas fa-dog"></i>&nbsp;&nbsp;迷い犬一覧</a>
                            </li>
                            -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-dog"></i>&nbsp;&nbsp;迷い犬
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($dog_prefecture_list as $item)
                                        <a class="dropdown-item" href="{{ route('dog.prefecture', ['prefecture_slug' => $item->slug])}}">{{ $item->label }}&nbsp;({{ $item->posts_count }}件)</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cat"></i>&nbsp;&nbsp;迷い猫
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach($cat_prefecture_list as $item)
                                        <a class="dropdown-item" href="{{ route('cat.prefecture', ['prefecture_slug' => $item->slug])}}">{{ $item->label }}&nbsp;({{ $item->posts_count }}件)</a>
                                    @endforeach
                                </div>
                            </li>
                            <!--
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cat') }}"><i class="fas fa-cat"></i>&nbsp;&nbsp;迷い猫一覧</a>
                            </li>
                            -->

                            @yield('mobile-prefecture-menu')
                        </ul>


                        @if(\Route::current() -> getName() == 'admin')
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
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
                        @endif


                    </div>
                </div>
            </nav>
        </div>

        @if(\Route::current() -> getName() == 'index')
        <main class="py-0">
        @else
        <main class="py-4">
        @endif
            @yield('content')
        </main>
    </div>

<div class="footer bg-warning pt-5 pb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-unstyled">
                    <li><a href="{{route('index')}}">トップページ</a></li>
                    <li><a href="{{route('dog')}}">迷い犬一覧</a></li>
                    <li><a href="{{route('cat')}}">迷い猫一覧</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <small class="d-block text-center">{{date('Y')}} Find My Pet</small>
            </div>
        </div>
    </div>
</div>

</body>
</html>
