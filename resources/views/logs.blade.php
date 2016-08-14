@extends('lucid::layout')

@section('content')

<div class="page-content">
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>
        <div class="dl-cell mdl-cell--11-col">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width" style="word-wrap: break-word; max-width: 200px;">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Level</th>
                        <th colspan=2 class="mdl-data-table__cell--non-numeric full-width">
                            <button id="lucid-logs-filter" class="mdl-button mdl-js-button mdl-button--icon">
                                <i class="material-icons">@{{levelIcon}}</i>
                            </button>

                            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
                                for="lucid-logs-filter">
                                <li class="mdl-menu__item mdl-menu__item--full-bleed-divider" @click="chooseFilterLevel('all')">All</li>
                                <li class="mdl-menu__item" @click="chooseFilterLevel('error')">Errors</li>
                                <li class="mdl-menu__item" @click="chooseFilterLevel('warning')">Warnings</li>
                                <li class="mdl-menu__item" @click="chooseFilterLevel('info')">Info</li>
                            </ul>

                        </th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">Type</th>
                        <th class="mdl-data-table__cell--non-numeric">Error</th>
                        <th class="mdl-data-table__cell--non-numeric">Time</th>
                        <th class="mdl-data-table__cell--non-numeric">Stack</th>
                        <th class="mdl-data-table__cell--non-numeric">Read</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="(key, entry) in logs">
                        <tr>
                            <td class="mdl-data-table__cell--non-numeric">
                                <i :class="['material-icons', 'text-colour-'+entry.level]">@{{entry.level}}</i>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric lucid-log-slack">
                                <b>@{{entry.header | header | trim | truncate 155}}</b>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric">@{{entry.date}}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <a href="#" @click="toggleStack(key)"><i class="material-icons">list</i></a>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <a href="#" @click="markRead(entry, key)"><i class="material-icons">check_circle</i></a>
                            </td>
                        </tr>
                        <tr v-if="entry.showStack">
                            <td colspan="5" class="lucid-logs-stack">
                                <pre>@{{entry.header}}</pre>
                                <hr>
                                <pre>@{{entry.stack}}</pre>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="mdl-layout-spacer"></div>
        <div class="mdl-layout-spacer"></div>
        <div class="mdl-layout-spacer"></div>
        <div class="mdl-layout-spacer"></div>
    </div>
</div>
@stop

@section('scripts')
<script type="text/javascript" src="/vendor/lucid/js/logs.js"></script>
@stop
