<div id="lucid-code-preview">
    <dialog v-el:job-code-dialog class="mdl-dialog lucid-code-preview">
        <h5 class="mdl-dialog__title">@{{currentJob.title}}</h5>
        <div class="mdl-dialog__content">
            <pre><code class="language-php">@{{{currentJob.highlightedContent}}}</code></pre>
        </div>
        <div class="mdl-dialog__actions">
            <button type="button" class="mdl-button close" @click="closeCurrentJob">Close</button>
        </div>
    </dialog>

    <dialog v-el:feature-code-dialog class="mdl-dialog lucid-code-preview">
        <h5 class="mdl-dialog__title">@{{currentFeature.title}}</h5>
        <div class="mdl-dialog__content">
            <pre><code class="language-php">@{{{currentFeature.highlightedContent}}}</code></pre>
        </div>
        <div class="mdl-dialog__actions">
            <button type="button" class="mdl-button close" @click="closeCurrentFeature">Close</button>
        </div>
    </dialog>
</div>

<script type="text/javascript">

var CodePreview = {
    methods: {
        showFeature: function(feature) {
            CodePreviewDialogs.showFeature(feature);
        },

        closeCurrentFeature: function() {
            CodePreviewDialogs.closeCurrentFeature();
        },

        showJob: function(job) {
            CodePreviewDialogs.showJob(job);
        },

        closeCurrentJob: function() {
            CodePreviewDialogs.closeCurrentJob();
        }
    }
};

var CodePreviewDialogs = new Vue({

    el: '#lucid-code-preview',

    data: {
        // store the feature that is being viewed currently
        currentFeature: null,
        // store the job that is being viewed currently
        currentJob: null,
        // determines whether the code preview is currently showing
        isCodeShowing: false
    },

    methods: {

        showFeature: function(feature) {

            // fetch the contents of the current feature
            Vue.http.get('features/'+feature.title).then(
                // success
                function (response) {
                    // set the currently viewing feature
                    this.currentFeature = response.json();

                    this.isCodeShowing = true;

                    this.showFeatureCodeDialog();

                    // generate and set highlighted content for this feature
                    this.currentFeature.highlightedContent = Prism.highlight(this.currentFeature.content, Prism.languages.php);
                }.bind(this),
                // error
                function (response) {
                    console.log('Error fetching feature details', response.status);
                }
            );
        },

        closeCurrentFeature: function() {
            this.$els.featureCodeDialog.close();
            this.isCodeShowing = false;
            this.currentFeature = null;
        },

        showFeatureCodeDialog: function() {
            this.$els.featureCodeDialog.showModal();
        },

         showJob: function(job) {
            console.log(job.title);
            // fetch the contents of the current job
            Vue.http.get('jobs/'+job.title).then(
                // success
                function (response) {
                    // set the currently viewing job
                    this.currentJob = response.json();

                    this.isCodeShowing = true;

                    this.showJobCodeDialog();

                    // generate and set highlighted content for this job
                    this.currentJob.highlightedContent = Prism.highlight(this.currentJob.content, Prism.languages.php);
                }.bind(this),
                // error
                function (response) {
                    console.log('Error fetching job details', response.status);
                }
            );
        },

        closeCurrentJob: function() {
            this.$els.jobCodeDialog.close();
            this.isCodeShowing = false;
            this.currentFeature = null;
        },

        showJobCodeDialog: function() {
            this.$els.jobCodeDialog.showModal();
        }
    }
});


</script>
