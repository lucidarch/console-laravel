// configure vue-resource
Vue.http.options.root = '/lucid';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
Vue.http.interceptors.push((request, next)  => {

    var indicator = document.createElement("div");
    indicator.className = "lucid-progress-indicator mdl-progress mdl-js-progress mdl-progress__indeterminate full-width";
    document.querySelector('#lucid-progress-container').appendChild(indicator);

    // continue to next interceptor
    next((response) => {
        indicator.remove();
    });
});

var Toast = new Vue({
    el: '#lucid-toast',

    methods: {
        show: function(text, actionText, actionHandler) {
            var data = {
                message: text,
                timeout: 5000
            }

            if (actionText) {
                data.actionText = actionText;
                data.actionHandler = actionHandler
            }

            this.$el.MaterialSnackbar.showSnackbar(data);
        }
    }
});

new Vue({
    el: '#creation-menu',

    methods: {
        showCreateJobDialog: function() {
            this.dialog.showModal();
        }
    },

    ready() {
        this.dialog = document.getElementById('lucid-create-job-dialog');
    }
});


new Vue({
    el: '#lucid-create-job-dialog',

    data: {
        title: '',
        // the chosen domain for the job
        domainName: '',
        // the list of domains available,
        // used to filter through
        DomainsStore: window.DomainsStore.state,
    },

    computed: {
        isNewDomain: function() {
            if (!this.domainName) return false;

            var domainNames = this.DomainsStore.domains.map(function(domain) {
                return domain.name;
            });

            var found = domainNames.find(function(name) {
                return name == this.domainName;
            }, this);

            return !found;
        }
    },

    methods: {
        /**
         * Called when a domain has been chosen from the list of filtered domains.
         *
         * @param {Object} domain
         */
        onDomainChosen: function(domain) {
            this.domainName = domain.name;
        },

        /**
         * Close the form.
         */
        closeCreateJobForm: function() {
            document.getElementById('lucid-create-job-dialog').close();
        },

        /**
         * Create the job.
         */
        createNewJob: function() {
            // make sure both fields are filled
            if (this.title.length <= 0 || this.domainName.length <= 0) {
                return false;
            }

            var data = {
                title: this.title,
                domain: this.domainName
            };

            // create the job
            this.$http.post('jobs', data).then(
                // success
                function (response) {
                    this.closeCreateJobForm();

                    console.log('Job created successfully', response.json());

                    var job = response.json();
                    Toast.show('Job '+job.title+' created successfully');

                    // update the domains list when a new domain is added
                    if (this.$get('isNewDomain')) {
                        window.domainsStore.load();
                    }

                    this.resetForm();
                },
                // error
                function (response) {
                    console.log('Error creating the job', response.status);
                }
            );
        },

        resetForm: function() {
            this.title = '';
            this.domainName = '';
        }
    },

    ready() {
        window.DomainsStore.load();
    }
})
