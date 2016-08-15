@extends('lucid::layout')

@section('content')

<div class="page-content">
    <div class="mdl-grid" id="lucid-logs">
        <div class="mdl-layout-spacer"></div>
        <div class="dl-cell mdl-cell--10-col">
            <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp full-width">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric" style="width: 10%;">
                            Level
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
                        <th class="mdl-data-table__cell--non-numeric" style="width: 60%;">Error</th>
                        <th class="mdl-data-table__cell--non-numeric" style="width: 20%;">Time</th>
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
                            <td class="mdl-data-table__cell--non-numeric">
                                <b>@{{entry.header | header | trim }}</b>
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
                                <b><pre style="line-height: 70px;">@{{entry.header}}</pre></b>
                                <hr>
                                <pre>@{{entry.stack}}</pre>
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
<script type="text/javascript" src="/vendor/lucid/js/logs.js"></script>
@stop
