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
    <script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//pwk.psln.nl/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '8']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <noscript><p><img src="//pwk.psln.nl/matomo.php?idsite=8&amp;rec=1" style="border:0;" alt="" /></p></noscript>
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-database" aria-hidden="true"></i> @ucfirst(__('app.home'))</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('address.admin') }}"><i class="fas fa-map-pin" aria-hidden="true"></i> @ucfirst(trans_choice('app.addresses', 2))</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('category.admin') }}"><i class="fas fa-folder" aria-hidden="true"></i> @ucfirst(trans_choice('app.categories', 2))</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('country.admin') }}"><i class="fas fa-globe" aria-hidden="true"></i> @ucfirst(trans_choice('app.countries', 2))</a>
                </li>
            </ul>
            @auth
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('import.index') }}" title="@ucfirst(__('app.formImportFile'))"><i class="fas fa-file-upload" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('export.index') }}" title="@ucfirst(__('app.formExportFile'))"><i class="fas fa-file-download" aria-hidden="true"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-user-cog"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
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
