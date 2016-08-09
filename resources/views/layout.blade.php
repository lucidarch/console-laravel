<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id="token" name="_token" content="{{ csrf_token() }}">

    <title>Lucid • Console</title>
    <link rel="stylesheet" href="/vendor/lucid/css/lib/material.min.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/material.font.css">
    <link rel="stylesheet" href="/vendor/lucid/css/stylesheet.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/prism.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/mui.min.css">

    <script type="text/javascript" src="/vendor/lucid/js/lib/vue.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/vue-resource.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/material.min.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/mui.min.js"></script>

    <script src="/vendor/lucid/js/dashboard.js"></script>
    <script src="/vendor/lucid/js/stores.js"></script>
    <script src="/vendor/lucid/js/mixins.js"></script>
</head>
<body>

    <div id="console" class="mdl-layout mdl-js-layout mdl-layout--fixed-header
                mdl-layout--fixed-tabs">

         <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">Lucid • Console</span>
                <div class="mdl-layout-spacer"></div>
                <nav class="mdl-navigation">
                    <a href="/lucid/dashboard/services" class="mdl-navigation__link @if(isset($active) && $active == 'services') mdl-navigation__link--current @endif">Services</a>
                    <a href="/lucid/dashboard/domains" class="mdl-navigation__link @if(isset($active) && $active == 'domains') mdl-navigation__link--current @endif">Domains</a>
                    <a href="/lucid/dashboard/features" class="mdl-navigation__link @if(isset($active) && $active == 'features') mdl-navigation__link--current @endif">Features</a>
                    <!-- search field -->
                    <div id="search-field" class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                        mdl-textfield--floating-label mdl-textfield--align-right">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="search-textfield">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input v-model="query" @keyup="search | debounce 300" class="mdl-textfield__input" type="text"
                                id="search-textfield">
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        @include('lucid::components.search-results')

        <!-- Holds the progress indicators -->
        <div id="lucid-progress-container"></div>

        @yield('drawer')

        <main class="mdl-layout__content">
            @yield('content')
        </main>

    </div>

    @include('lucid::components.toast')
    @include('lucid::components.code-preview')
    @include('lucid::components.create-job')
    @include('lucid::components.create-feature')
    @include('lucid::components.add-menu')

    <script src="/vendor/lucid/js/lib/prism.js"></script>
    @yield('scripts')
</body>
</html>
