<!-- create job form -->
<dialog id="lucid-create-feature-dialog" class="mdl-dialog lucid-create-job">
    <h5 class="mdl-dialog__title">New Feature</h5>
    <div class="mdl-dialog__content">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="lucid-feature-title" v-model="title">
            <label class="mdl-textfield__label" for="lucid-feature-title">Name your Feature</label>
        </div>

        <div id="lucid-services-list" class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" v-bind:value="serviceName" type="text" id="lucid-feature-service" v-model="serviceName">
            <label class="mdl-textfield__label" for="lucid-feature-service">Which Service?</label>
        </div>

        <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect"
        for="lucid-services-list" style="max-height:300px;overflow-y: auto">
            <li class="mdl-menu__item" v-for="service in ServicesStore.services" @click="onServiceChosen(service)">@{{service.name}}</li>
        </ul>

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
        ServicesStore: window.ServicesStore.state
    },

    methods: {
        show: function() {
            this.$el.showModal();
        },

        onServiceChosen: function(service) {
            this.serviceName = service.name;
        },

        closeCreateFeatureForm: function() {
            this.$el.close();
        },

        resetForm: function() {
            this.title = '';
            this.serviceName = '';
        },

        createNewFeature: function() {
            // make sure both fields are filled
            if (this.title.length <= 0 || this.serviceName.length <= 0) {
                return false;
            }

            var data = {
                title: this.title,
                service: this.serviceName
            };

            // create the feature
            this.$http.post('features', data).then(
                // success
                function (response) {
                    this.closeCreateFeatureForm();

                    console.log('Feature created successfully', response.json());

                    var feature = response.json();
                    Toast.show('Feature '+feature.title+' created successfully');

                    this.resetForm();
                },
                // error
                function (response) {
                    console.log('Error creating the feature', response.status);
                }
            );
        }
    }
});

</script>
