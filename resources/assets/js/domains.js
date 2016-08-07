new Vue({

    el:'#console',

    data: {
        // whether code preview is showing or not
        DomainsStore: window.DomainsStore.state,
        isCodeShowing: false,
        jobs: [],
        currentDomain: null,
        currentJob: null,

        // controls whether to show the filter row in the results
        filterQuery: '',
        shouldShowFilterRow: false,
        filteredJobs: []
    },

     computed: {
        // determine whether to show the filtered results or not
        shouldShowFilteredResults: function() {
            return this.filterQuery.length > 1;
        },
    },

    methods: {

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
                    this.$set('jobs', response.json()[domain.slug]);
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
        },

        toggleFilter: function() {
            this.shouldShowFilterRow = !this.shouldShowFilterRow;

            if (this.shouldShowFilterRow) {
                Vue.nextTick(function () {
                    this.$els.filterField.focus();
                }, this);
            }
        },

        filter: function(e) {

            if (e.keyCode == 27) { // esc
                return this.cancelFilter();
            }

            this.filteredJobs = this.jobs.filter(function(job) {
                // do case-insensitive search
                var title = job.title.replace(' ', '').trim().toLowerCase();
                var query = this.filterQuery.trim().toLowerCase();

                return title.indexOf(query) !== -1 ||                   // non-spaced title
                    job.title.toLowerCase().indexOf(query) !== -1 ||    // title as is (with spaces)
                    job.file.toLowerCase().indexOf(query) !== -1;       // file name
            }, this);
        },

        cancelFilter: function() {
            this.shouldShowFilterRow = false;
            this.filterQuery = '';
        }

    },

    ready: function () {
        window.DomainsStore.load();
        // set the code dialog reference
        this.codeDialog = document.querySelector('dialog');
    }
});
