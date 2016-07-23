@extends('lucid::layout', ['active' => 'domains'])

@section('content')
<div id="content">
    <div id="domains" class="col-md-2">
        <ul class="nav">
            <li v-for="domain in domains">
                <a @click="loadJobsForDomain(domain)" :class="['btn', 'btn-danger', {disabled: currentService == domain}]">@{{ domain.name }}</a>
            </li>
        </ul>
    </div>

    <div id="jobs" class="col-md-10">
        <table class="table table-striped table-bordered table-hover row-select">
            <h3 v-if="jobs.length <= 0 && !currentDomain" class="text-center">👈 choose a domain to see its jobs list</h3>
            <h4 v-if="jobs.length <= 0 && currentDomain" class="text-center"><small>This domain has no jobs</small></h4>
            <thead v-if="jobs.length > 0">
                <tr>
                    <th>Jobs</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="job in jobs">
                    <td class="vertical-middle">@{{job.title}}</td>
                    <td>
                        <div class="btn btn-xs btn-success" @click="showJob(job)">
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
                        @{{currentJob.title}} <small><span class="label label-warning">Job</span></small>
                    </h2>
                    <h4>
                        <small>
                            <br/>
                            @{{currentJob.file}}
                            <br/>
                            @{{currentJob.relativePath}}
                        </small>
                    </h4>
                </div>
              <div class="modal-body">
                <pre><code class="language-php">@{{{currentJob.highlightedContent}}}</code></pre>
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
<script src="/vendor/lucid/js/domains.js"></script>
@stop
