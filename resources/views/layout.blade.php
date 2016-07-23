<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lucid • Console</title>
    <link rel="stylesheet" href="/vendor/lucid/css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/bootstrap-material-design-theme.min.css">
    <link rel="stylesheet" href="/vendor/lucid/css/stylesheet.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/ripples.min.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/prism.css">

    <script type="text/javascript" src="/vendor/lucid/js/lib/vue.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/vue-resource.js"></script>
</head>
<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/lucid/dashboard">Lucid • Console</a>
            </div>

            <!-- Nav sections -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                     <li @if(isset($active) && $active == 'services') class="active" @endif><a href="/lucid/dashboard/services">Services <span class="sr-only">(current)</span></a></li>
                     <li @if(isset($active) && $active == 'domains') class="active" @endif><a href="/lucid/dashboard/domains">Domains <span class="sr-only">(current)</span></a></li>
                     <li @if(isset($active) && $active == 'features') class="active" @endif><a href="/lucid/dashboard/features">Features <span class="sr-only">(current)</span></a></li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container-fluid">
        @yield('content')
    </div>

    <script src="/vendor/lucid/js/lib/jquery.min.js"></script>
    <script src="/vendor/lucid/js/lib/bootstrap.min.js"></script>
    <script src="/vendor/lucid/js/lib/material.min.js"></script>
    <script src="/vendor/lucid/js/lib/ripples.min.js"></script>
    <script type="text/javascript">
    $.material.init()
    </script>

    <script src="/vendor/lucid/js/lib/prism.js"></script>

    <script src="/vendor/lucid/js/dashboard.js"></script>
    @yield('scripts')
</body>
</html>
