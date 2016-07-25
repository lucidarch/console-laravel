<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lucid • Console</title>
    <link rel="stylesheet" href="/vendor/lucid/css/lib/material.min.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/material.font.css">
    <link rel="stylesheet" href="/vendor/lucid/css/stylesheet.css">
    <link rel="stylesheet" href="/vendor/lucid/css/lib/prism.css">

    <script src="/vendor/lucid/js/lib/material.min.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/vue.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/vue-resource.js"></script>

</head>
<body>

    <!-- Simple header with fixed tabs. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header
                mdl-layout--fixed-tabs">
      <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
          <!-- Title -->
          <span class="mdl-layout-title">Title</span>
          <div class="mdl-layout-spacer"></div>
          <nav class="mdl-navigation">
              <a href="/lucid/dashboard/services" class="mdl-navigation__link mdl-navigation__link--current">Services</a>
              <a href="/lucid/dashboard/domains" class="mdl-navigation__link @if(isset($active) && $active == 'domains') mdl-navigation__link--current @endif">Domains</a>
              <a href="/lucid/dashboard/features" class="mdl-navigation__link @if(isset($active) && $active == 'features') mdl-navigation__link--current @endif">Features</a>
          </nav>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
          <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Tab 1</a>
          <a href="#fixed-tab-2" class="mdl-layout__tab">Tab 2</a>
          <a href="#fixed-tab-3" class="mdl-layout__tab">Tab 3</a>
        </div>
      </header>
      <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Title</span>
      </div>
      <main class="mdl-layout__content">
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
          <div class="page-content"><!-- Your content goes here --></div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-2">
          <div class="page-content"><!-- Your content goes here --></div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-3">
          <div class="page-content"><!-- Your content goes here --></div>
        </section>
      </main>
    </div>
</body>
</html>
