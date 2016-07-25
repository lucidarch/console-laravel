new Vue({

    el:'#console',

    data: {
        // whether code preview is showing or not
        isCodeShowing: false,
        domains: [],
        jobs: [],
        currentDomain: null,
        currentJob: null,
    },

    methods: {

        loadDomains: function () {
            this.$http.get('domains').then(
                // success
                function (response) {
                    console.log('domains', response.json());
                    this.$set('domains', response.json());
                },
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
        },

        loadJobsForDomain: function(domain) {
            console.log('Loading jobs for domain: ', domain);

            // set the current domain
            this.currentDomain = domain;

            // clear previous jobs (if any)
            this.jobs = [];

            // fetch the jobs of the domain
            this.$http.get('domains/'+domain.name+'/jobs').then(
                // success
                function (response) {
                    console.log('jobs:', response.json());
                    this.$set('jobs', response.json());
                },
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
        },

        showJob: function(job) {
            // fetch the contents of the current job
            this.$http.get('jobs/'+job.title).then(
                // success
                function (response) {
                    console.log('job details: ', response.json());
                    // set the currently viewing job
                    this.$set('currentJob', response.json());

                    this.$set('isCodeShowing', true);

                    this.codeDialog.showModal();

                    // generate and set highlighted content for this job
                    this.$set('currentJob.highlightedContent', Prism.highlight(this.$get('currentJob.content'), Prism.languages.php));
                },
                // error
                function (response) {
                    console.log('Error fetching job details', response.status);
                }
            );
        },

        closeCurrentJob: function() {
            this.codeDialog.close();
            this.isCodeShowing = false;
            this.currentFeature = null;
        }

    },

    ready: function () {
        this.loadDomains();

        // set the code dialog reference
        this.codeDialog = document.querySelector('dialog');
    }
});
