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

    <script type="text/javascript" src="/vendor/lucid/js/lib/vue.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/vue-resource.js"></script>
    <script type="text/javascript" src="/vendor/lucid/js/lib/material.min.js"></script>

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
                </nav>
            </div>
        </header>

        <!-- Holds the progress indicators -->
        <div id="lucid-progress-container"></div>

        @yield('drawer')

        <main class="mdl-layout__content">
            @yield('content')
        </main>

    </div>

    <button id="lucid-add-button" class="mdl-button mdl-js-ripple-effect mdl-js-button mdl-button--fab mdl-color--accent">
        <i class="material-icons mdl-color-text--white" role="presentation">add</i>
        <span class="visuallyhidden">add</span>
        <span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
    </button>

    <div id="creation-menu">
        <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
        data-mdl-for="lucid-add-button">
            <li class="mdl-menu__item" @click="showCreateJobDialog()">Job</li>
            <li class="mdl-menu__item">Feature</li>
        </ul>
    </div>

    <!-- create job form -->
    <dialog id="lucid-create-job-dialog" class="mdl-dialog lucid-create-job">
        <h5 class="mdl-dialog__title">New Job</h5>
        <div class="mdl-dialog__content">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="lucid-job-title" v-model="title">
                <label class="mdl-textfield__label" for="lucid-job-title">Name your job</label>
            </div>

            <div id="lucid-domains-list" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" data-badge="10" @keyup="onDomainKey" v-bind:value="domainName" type="text" id="lucid-job-domain" v-model="domainName">
                <label class="mdl-textfield__label" for="lucid-job-domain">Which Domain?</label>
            </div>

            <i class="material-icons" v-if="isNewDomain">fiber_new</i>

            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
            for="lucid-domains-list" style="max-height:300px;overflow-y: auto">
                <li class="mdl-menu__item" v-for="domain in domainsStore.domains" @click="onDomainChosen(domain)">@{{domain.name}}</li>
            </ul>

        </div>
        <div class="mdl-dialog__actions">
            <button type="button" class="mdl-button mdl-js-button
                mdl-button--raised mdl-js-ripple-effect mdl-button--colored" @click="createNewJob()">Create</button>
            <button type="button" class="mdl-button mdl-js-button mdl-textfield--floating-label
                mdl-button--raised mdl-js-ripple-effect close" @click="closeCreateJobForm()">Close</button>
        </div>
    </dialog>

    <div id="lucid-toast" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>

    <script src="/vendor/lucid/js/stores.js"></script>
    <script src="/vendor/lucid/js/dashboard.js"></script>
    <script src="/vendor/lucid/js/lib/prism.js"></script>
    @yield('scripts')
</body>
</html>
