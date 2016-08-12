@extends('lucid::layout', ['active' => 'domains'])

@section('drawer')
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">Domains</span>
        <nav class="mdl-navigation">
            <template v-for="domain in DomainsStore.domains">
                <a
                    href="#"
                    @click="loadJobsForDomain(domain)"
                    :class="['mdl-navigation__link', {'mdl-navigation__link--current': currentDomain == domain}]"
                >
                    @{{domain.name}}
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
        <h1 v-if="jobs.length <= 0 && !currentDomain" class="text-center">
             <small>choose a domain to see its jobs list</small>
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

            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width"  v-if="jobs.length > 0">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric full-width">
                            Job
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
                    <tr v-show="shouldShowFilterRow">
                        <td colspan=2 style="text-align: left;">
                            <div class="mdl-textfield mdl-js-textfield full-width">
                                <input class="mdl-textfield__input" type="text" v-el:filter-field
                                    placeholder="Filter results..." v-model="filterQuery" @keyup="filter">
                            </div>
                        </td>
                    </tr>

                    <template v-for="job in filteredJobs" v-if="shouldShowFilteredResults">
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">@{{job.title}}</td>
                            <td>
                                <button class="mdl-button mdl-js-button mdl-button--icon" @click="showJob(job)">
                                    <i class="material-icons">code</i>
                                </button>
                            </td>
                        </tr>
                    </template>


                    <template v-for="job in jobs" v-if="!shouldShowFilteredResults">
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">@{{job.title}}</td>
                            <td>
                                <button class="mdl-button mdl-js-button mdl-button--icon" @click="showJob(job)">
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
</template>
@stop

@section('scripts')
<script src="/vendor/lucid/js/domains.js"></script>
@stop
