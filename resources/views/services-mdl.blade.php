@extends('lucid::layout', ['active' => 'services'])

@section('drawer')
<!-- <div class="mdl-layout__tab-bar">
    <template v-for="service in services">
        <a
            href="#@{{service.slug}}-tab"
            @click="loadFeaturesForService(service)"
            :class="['mdl-layout__tab', {'is-active': currentService == service}]"
        >
            @{{ service.name }}
        </a>
    </template>
</div>
 -->

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
    <div class="mdl-layout__drawer">

        <span class="mdl-layout-title">Services</span>
        <nav class="mdl-navigation">
            <template v-for="service in services">
                <a
                    href="#"
                    @click="loadFeaturesForService(service)"
                    :class="['mdl-navigation__link', {'mdl-navigation__link--current': currentService == service}]"
                >
                    @{{service.name}}
                </a>
            </template>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="mdl-grid">
    <div class="mdl-layout-spacer"></div>
    <div class="dl-cell mdl-cell--4-col">
        <h5 v-if="features.length <= 0 && !currentService">
             <small>choose a service to see its features list</small>
        </h5>
    </div>
    <div class="mdl-layout-spacer"></div>
</div>

<div class="page-content">
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>
        <div class="mdl-layout-spacer"></div>
        <div class="mdl-layout-spacer"></div>
        <div class="dl-cell mdl-cell--9-col">

        <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width" v-if="features.length > 0">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric full-width">Feature</th>
                    <th class="mdl-data-table__cell--non-numeric">Code</th>
                </tr>
            </thead>
            <tbody>
                <template v-for="feature in features">
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">@{{feature.title}}</td>
                        <td>
                            <button class="mdl-button mdl-js-button mdl-button--icon" @click="showFeature(feature)">
                                <i class="material-icons">code</i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        </div>
        <div class="mdl-layout-spacer"></div>
    </div>
</div>

<!-- <template v-for="service in services">
    <section :class="['mdl-layout__tab-panel', {'is-active': currentService == service}]" id="#@{{service.slug}}-tab">
        <div class="page-content">
            <div class="mdl-grid">
                <div class="mdl-layout-spacer"></div>
                <div class="dl-cell mdl-cell--10-col">

                    <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp full-width">
                        <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric full-width">Feature</th>
                                <th class="mdl-data-table__cell--non-numeric">Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="feature in features">
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">@{{feature.title}}</td>
                                    <td>
                                        <button class="mdl-button mdl-js-button mdl-button--icon" @click="showFeature(feature)">
                                            <i class="material-icons">code</i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                </div>
                <div class="mdl-layout-spacer"></div>
            </div>
        </div>
    </section>
</template> -->

<dialog class="mdl-dialog lucid-code-preview">
    <h5 class="mdl-dialog__title">@{{currentFeature.title}}</h5>
    <div class="mdl-dialog__content">
        <pre><code class="language-php">@{{{currentFeature.highlightedContent}}}</code></pre>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button close" @click="closeCurrentFeature()">Close</button>
    </div>
</dialog>

@stop

@section('scripts')
    <script src="/vendor/lucid/js/services.js"></script>
@stop
