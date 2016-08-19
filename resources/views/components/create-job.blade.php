<!-- create job form -->
<dialog id="lucid-create-job-dialog" class="mdl-dialog">
    <h5 class="mdl-dialog__title">New Job</h5>
    <div class="mdl-dialog__content">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="lucid-job-title" v-model="title">
            <label class="mdl-textfield__label" for="lucid-job-title">Name your Job</label>
        </div>

        <div id="lucid-domains-list" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" v-bind:value="domainName" type="text" id="lucid-job-domain" v-model="domainName">
            <label class="mdl-textfield__label" for="lucid-job-domain">Which Domain?</label>
        </div>

        <i class="material-icons" v-if="isNewDomain">fiber_new</i>

        <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
        for="lucid-domains-list" style="max-height:300px;overflow-y: auto">
            <li class="mdl-menu__item" v-for="domain in DomainsStore.domains" @click="onDomainChosen(domain)">@{{domain.name}}</li>
        </ul>

    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button
            mdl-button--raised mdl-js-ripple-effect mdl-button--colored" @click="createNewJob()">Create</button>
        <button type="button" class="mdl-button mdl-js-button mdl-textfield--floating-label
            mdl-button--raised mdl-js-ripple-effect close" @click="closeCreateJobForm()">Close</button>
    </div>
</dialog>

<script type="text/javascript">

var CreateJobDialog = new Vue({
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
        show: function() {
            this.$el.showModal();
        },

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
            this.$el.close();
        },

        /**
         * Clear the form inputs
         */
        resetForm: function() {
            this.title = '';
            this.domainName = '';
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
            Vue.http.post('jobs', data).then(
                // success
                function (response) {
                    this.closeCreateJobForm();

                    var job = response.json();
                    Toast.show('Job '+job.title+' created successfully');

                    // update the domains list when a new domain is added
                    if (this.isNewDomain) {
                        // reload domains when it's a new one that's been created
                        window.DomainsStore.load();
                    }

                    this.resetForm();
                }.bind(this),
                // error
                function (response) {
                    console.log('Error creating the job', response.status);
                }
            );
        }
    },

    ready() {
        window.DomainsStore.load();
    }
});
</script>
