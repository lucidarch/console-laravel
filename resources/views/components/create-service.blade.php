<!-- create service form -->
<dialog id="lucid-create-service-dialog" class="mdl-dialog">
    <h5 class="mdl-dialog__title">New Service</h5>
    <div class="mdl-dialog__content">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="text" id="lucid-service-title" v-model="name">
            <label class="mdl-textfield__label" for="lucid-service-title">Name your Service</label>
        </div>
    </div>
    <div class="mdl-dialog__actions">
        <button type="button" class="mdl-button mdl-js-button
            mdl-button--raised mdl-js-ripple-effect mdl-button--colored" @click="createNewService()">Create</button>
        <button type="button" class="mdl-button mdl-js-button mdl-textfield--floating-label
            mdl-button--raised mdl-js-ripple-effect close" @click="closeCreateServiceForm()">Close</button>
    </div>
</dialog>

<script type="text/javascript">

var CreateServiceDialog = new Vue({
    el: '#lucid-create-service-dialog',

    data: {
        name: ''
    },

    methods: {
        show: function() {
            this.$el.showModal();
        },

        closeCreateServiceForm: function() {
            this.$el.close();
        },

        resetForm: function() {
            this.name = '';
        },

        createNewService: function() {
            // there must be a name
            if (this.name.length <= 0) {
                return false;
            }

            Vue.http.post('services', {name: this.name}).then(
                // success
                function(response) {
                    this.closeCreateServiceForm();

                    var service = response.json();
                    Toast.show('Service '+service.name+' is now ready');

                    this.resetForm();
                }.bind(this),
                // error
                function(response) {
                    console.error('Error creating service:', response.status);
                }
            );
        }
    }
});

</script>
