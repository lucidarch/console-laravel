@extends('lucid::layout', ['active' => 'services'])

@section('content')
<div id="content">
    <div id="services" class="col-md-2">
        <ul class="nav">
            <li v-for="service in services">
                <a @click="loadFeaturesForService(service)" :class="['btn', 'btn-danger', {disabled: currentService == service}]">@{{ service.name }}</a>
            </li>
        </ul>
    </div>

    <div id="features" class="col-md-10">
        <table class="table table-striped table-bordered table-hover row-select">
            <h3 v-if="features.length <= 0 && !currentService" class="text-center">👈 choose a service to see its features list</h3>
            <h3 v-if="features.length <= 0 && currentService" class="text-center"><small>This service has no features</small></h3>
            <thead v-if="features.length > 0">
                <tr>
                    <th>Feature</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="feature in features" >
                    <td class="vertical-middle"><h5>@{{feature.title}}</h5></td>
                    <td>
                        <div class="btn btn-xs btn-success" @click="showFeature(feature)">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            <span class="glyphicon glyphicon-chevron-right"></span>
                            <br/>
                            source
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal" id="codePreview">
        <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title">
                        @{{currentFeature.title}}
                        <small><span class="label label-info">Feature</span></small>
                    </h2>
                    <h4>
                        <small>
                            <br/>
                            @{{currentFeature.file}}
                            <br/>
                            @{{currentFeature.relativePath}}
                        </small>
                    </h4>
                </div>
              <div class="modal-body">
                <pre><code class="language-php">@{{{currentFeature.highlightedContent}}}</code></pre>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
@stop

@section('scripts')
<script src="/vendor/lucid/js/dashboard.js"></script>
<script src="/vendor/lucid/js/services.js"></script>
@stop
