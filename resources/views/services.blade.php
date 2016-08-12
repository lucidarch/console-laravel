@extends('lucid::layout', ['active' => 'services'])

@section('drawer')
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
    <div class="mdl-layout__drawer">

        <span class="mdl-layout-title">Services</span>
        <nav class="mdl-navigation">
            <template v-for="service in ServicesStore.services">
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
        <h1 v-if="features.length <= 0 && !currentService" class="text-center">
             <small>choose a service to see its features list</small>
        </h1>
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
                    <th class="mdl-data-table__cell--non-numeric full-width">
                        Feature
                        <!-- table actions -->
                        <span style="margin-left: 30px;">
                            <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" @click="toggleFilter">
                                <i class="material-icons" style="vertical-align: middle;">filter_list</i>
                            </button>
                        </span>
                    </th>
                    <th class="mdl-data-table__cell--non-numeric">Code</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="shouldShowFilterRow">
                    <td colspan=2 style="text-align: left;">
                        <div class="mdl-textfield mdl-js-textfield full-width">
                            <input class="mdl-textfield__input" type="text" v-el:filter-field
                                placeholder="Filter results..." v-model="filterQuery" @keyup="filter">
                        </div>
                    </td>
                </tr>

                <template v-for="feature in filteredFeatures" v-if="shouldShowFilteredResults">
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">@{{feature.title}}</td>
                        <td>
                            <button class="mdl-button mdl-js-button mdl-button--icon" @click="showFeature(feature)">
                                <i class="material-icons">code</i>
                            </button>
                        </td>
                    </tr>
                </template>

                <template v-for="feature in features" v-if="!shouldShowFilteredResults">
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
@stop

@section('scripts')
    <script src="/vendor/lucid/js/services.js"></script>
@stop
