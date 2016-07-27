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
        <h5 v-if="jobs.length <= 0 && !currentDomain" class="text-center">
             <small>choose a domain to see its jobs list</small>
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

            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width"  v-if="jobs.length > 0">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric full-width">Job</th>
                        <th class="mdl-data-table__cell--non-numeric">Code</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="job in jobs">
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


<dialog class="mdl-dialog lucid-code-preview">
    <h5 class="mdl-dialog__title">@{{currentJob.title}}</h5>
    <div class="mdl-dialog__content">
        <pre><code class="language-php">@{{{currentJob.highlightedContent}}}</code></pre>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button close" @click="closeCurrentJob()">Close</button>
    </div>
</dialog>
@stop

@section('scripts')
<script src="/vendor/lucid/js/domains.js"></script>
@stop
