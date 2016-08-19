<button id="lucid-add-button" class="mdl-button mdl-js-ripple-effect mdl-js-button mdl-button--fab mdl-color--accent">
    <i class="material-icons mdl-color-text--white" role="presentation">add</i>
    <span class="visuallyhidden">add</span>
    <span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span>
</button>

<div id="creation-menu">
    <ul class="mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect"
    data-mdl-for="lucid-add-button">
        <li class="mdl-menu__item" @click="showCreateServiceDialog()">Service</li>
        <li class="mdl-menu__item" @click="showCreateFeatureDialog()">Feature</li>
        <li class="mdl-menu__item" @click="showCreateJobDialog()">Job</li>
    </ul>
</div>

<script type="text/javascript">

new Vue({
    el: '#creation-menu',

    methods: {
        showCreateJobDialog: function() {
            CreateJobDialog.show();
        },

        showCreateFeatureDialog: function() {
            CreateFeatureDialog.show();
        },

        showCreateServiceDialog: function() {
            CreateServiceDialog.show();
        }
    }
});

</script>
