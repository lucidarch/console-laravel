<!-- create job form -->
<dialog id="lucid-create-feature-dialog" class="mdl-dialog lucid-create-job">
    <h5 class="mdl-dialog__title">New Feature</h5>

    <div class="mdl-dialog__content">
        <!-- feature name -->
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="lucid-feature-title" v-model="title">
            <label class="mdl-textfield__label" for="lucid-feature-title">Name your Feature</label>
        </div>

        <!-- feature's service -->
        <div id="lucid-services-list" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" v-bind:value="serviceName" type="text" id="lucid-feature-service" v-model="serviceName" placeholder="Which Service?">
        </div>
        <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
        for="lucid-services-list" style="max-height:300px;overflow-y: auto">
            <li class="mdl-menu__item" v-for="service in ServicesStore.services" @click="onServiceChosen(service)">@{{service.name}}</li>
        </ul>

        <!-- feature's job(s) -->
        <h2><i class="material-icons" style="margin-top: 5px;">list</i> Jobs</h2>
        <!-- print feature's jobs list -->
        <ul class="mdl-list">
            <li class="mdl-list__item mdl-list__item--two-line" v-for="job in jobs">
                <span class="mdl-list__item-primary-content">
                    <span>@{{job.title}}</span>
                    <span class="mdl-list__item-sub-title">@{{job.domain.name}}</span>
                </span>
            </li>
        </ul>
        <!-- jobs filter -->

        <!-- print add a job field -->
        <div :class="[{'mui-dropdown': 'filteredJobs.length > 0'}]">
            <div id="lucid-feature-filtered-jobs-list" data-mui-toggle="dropdown" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input type="text" id="lucid-feature-add-jobs" class="mdl-textfield__input" @keyup.enter="onJobEnter" @keyup="onJobKeyUp" placeholder="Add Job">
            </div>
            <ul class="mui-dropdown__menu">
                <li v-for="matchedJob in filteredJobs">
                    <a href="#" @click="onJobChosen(matchedJob)">@{{matchedJob.title}}</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button
            mdl-button--raised mdl-js-ripple-effect mdl-button--colored" @click="createNewFeature()">Create</button>
        <button type="button" class="mdl-button mdl-js-button mdl-textfield--floating-label
            mdl-button--raised mdl-js-ripple-effect close" @click="closeCreateFeatureForm()">Close</button>
    </div>
</dialog>

<script type="text/javascript">

var CreateFeatureDialog = new Vue({
    el: '#lucid-create-feature-dialog',

    data: {
        title: '',
        serviceName: '',
        // the jobs list of the feature being created.
        jobs: [],
        // the list of filtered jobs when entering
        filteredJobs: [],
        ServicesStore: window.ServicesStore.state,
        JobsStore: window.JobsStore.state,
    },

    methods: {
        show: function() {
            window.ServicesStore.load();
            window.JobsStore.load();

            this.$el.showModal();
        },

        onServiceChosen: function(service) {
            this.serviceName = service.name;
        },

        onJobKeyUp: function(event) {
            if (event.charCode != 13 && event.target.value.length >= 3) {
                this.filteredJobs = this.filterJobs(event.target.value);
            }
        },

        onJobEnter: function() {
            if (this.filteredJobs.length > 0) {
                this.addJob(this.filteredJobs[0]);
            }
        },

        onJobChosen: function(job) {
            this.addJob(job);
        },

        addJob: function(job) {
            this.jobs.push(job);
            document.querySelector('#lucid-feature-add-jobs').value = '';
        },


        closeCreateFeatureForm: function() {
            this.$el.close();
        },

        resetForm: function() {
            this.title = '';
            this.serviceName = '';
        },

        filterJobs: function(query) {
            return this.JobsStore.jobs.filter(function(job) {
                // do case-insensitive search
                var title = job.title.replace(' ', '').toLowerCase();
                query = query.trim().toLowerCase();

                return title.indexOf(query) !== -1 ||                   // non-spaced title
                    job.title.toLowerCase().indexOf(query) !== -1 ||    // title as is (with spaces)
                    job.file.toLowerCase().indexOf(query) !== -1;       // file name
            });
        },

        createNewFeature: function() {
            // make sure both fields are filled
            if (this.title.length <= 0 || this.serviceName.length <= 0) {
                return false;
            }

            var data = {
                title: this.title,
                service: this.serviceName,
                jobs: this.jobs
            };

            // create the feature
            Vue.http.post('features', data).then(
                // success
                function (response) {
                    this.closeCreateFeatureForm();

                    console.log('Feature created successfully', response.json());

                    var feature = response.json();
                    Toast.show('Feature '+feature.title+' created successfully');

                    this.resetForm();
                }.bind(this),
                // error
                function (response) {
                    console.log('Error creating the feature', response.status);
                }
            );
        }
    }
});

</script>
