// configure vue-resource
Vue.http.options.root = '/lucid';

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
        domains: [],
    },

    computed: {
        isNewDomain: function() {
            if (!this.domainName) return false;

            var domainNames = this.domains.map(function(domain) {
                return domain.name;
            });

            var found = domainNames.find(function(name) {
                return name == this.domainName;
            }, this);

            return !found;
        }
    },

    methods: {
        loadDomains: function() {
            this.$http.get('domains').then(
                // success
                function (response) {
                    console.log('domains', response.json());
                    this.$set('domains', response.json());
                    this.$set('filteredDomains', response.json());
                },
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
        },

        /**
         * Called when a domain has been chosen from the list of filtered domains.
         *
         * @param {Object} domain
         */
        onDomainChosen: function(domain) {
            this.domainName = domain.name;
        },

        closeCreateJobForm: function() {
            document.getElementById('lucid-create-job-dialog').close();
        }
    },

    ready() {
        this.loadDomains();
    }
})
