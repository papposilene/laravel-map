<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
	<meta name="robots" content="noindex,notranslate,nosnippet,noarchive,nocache,noimageindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Philippe-Alexandre Pierre">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ $appName }}</title>
    @section('favicon')
    <link rel="icon" href="{{ asset('/img/favicon.ico') }}" />
    @endsection
	<link rel="canonical" href="{{ URL::current() }}" />
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700|Roboto">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}" />
    @yield('css-file')
    <style>
    body{font-family: 'PT Sans', serif;padding-top: 4.5rem;}
    h1, h2, h3, h4, h5{font-family: 'Roboto', sans-serif;}
    </style>
    @yield('css-style')
</head>

<body>
    @section('navbar')
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">{{ $appName }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownAfrica" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-africa" aria-hidden="true"></i> {{ __('app.africa') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownAfrica">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownAmericas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-americas" aria-hidden="true"></i> {{ __('app.americas') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownAmericas">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownAsia" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-asia" aria-hidden="true"></i> {{ __('app.asia') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownAsia">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="country" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-europe" aria-hidden="true"></i> {{ __('app.europa') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownEuropa">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownOceania" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-globe-asia" aria-hidden="true"></i> {{ __('app.oceania') }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownOceania">
                    </div>
                </li>
            </ul>
            @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-database"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
            @else
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i></a>
                </li>
            </ul>
            @endauth
        </div>
    </nav>
    @show
    
    <main role="main" id="main" class="container-fluid">
    @section('main')
    {-- main section --}
    @show
    
    @section('footer')
        <div class="row d-flex justify-content-center">
            <footer class="footer col-6 my-4">
                <div class="container">
                    <p class="text-muted text-right">
                        <small>
                            <em>{{ $appName }}</em>, {{ __('app.under') }} <a href="https://opensource.org/licenses/mit-license.php" target="_blank" rel="noopener">MIT license</a>.
                        </small>
                    </p>
                </div>
            </footer>
        </div>
    @show
    </main>
	
    <script type="text/javascript" src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/fontawesome.all.min.js') }}" data-auto-replace-svg="nest" defer></script>
	@yield('js')
</body>
</html>
