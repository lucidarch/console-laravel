new Vue({

    el:'#content',

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
            // set the currently viewing job
            this.currentJob = job;

            // fetch the contents of the current job
            this.$http.get('jobs/'+job.title).then(
                // success
                function (response) {
                    console.log('job details: ', response.json());
                    this.$set('currentJob', response.json());

                    // show the code modal
                    this.$set('isCodeShowing', true);
                    $('#codePreview').modal();

                    // generate and set highlighted content for this job
                    this.$set('currentJob.highlightedContent', Prism.highlight(this.$get('currentJob.content'), Prism.languages.php));
                },
                // error
                function (response) {
                    console.log('Error fetching job details', response.status);
                }
            );

            console.log('Got to show the details of: ', job.title);
        }

    },

    ready: function () {
        this.loadDomains();
    }
});
