
new Vue({

    el:'#console',

    data: {
        // whether code preview is showing or not
        isCodeShowing: false,
        // the code dialog reference
        codeDialog: null,
        services: [],
        features: [],
        currentService: null,
        currentFeature: null,
    },

    methods: {

        loadServices: function () {
            this.$http.get('services').then(
                // success
                function (response) {
                    console.log('services', response.json());
                    this.$set('services', response.json());
                },
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
        },

        loadFeaturesForService: function(service) {
            console.log('Loading features for service: ', service);

            // set the current service
            this.currentService = service;

            // clear previous features (if any)
            this.features = [];

            // fetch the features of the service
            this.$http.get('services/'+service.slug+'/features').then(
                // success
                function (response) {
                    console.log('features:', response.json());
                    this.$set('features', response.json()[service.name]);
                },
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
        },

        showFeature: function(feature) {

            // fetch the contents of the current feature
            this.$http.get('features/'+feature.title).then(
                // success
                function (response) {
                    console.log('feature details: ', response.json());
                    // set the currently viewing feature
                    this.$set('currentFeature', response.json());

                    this.$set('isCodeShowing', true);

                    this.codeDialog.showModal();

                    // generate and set highlighted content for this feature
                    this.$set('currentFeature.highlightedContent', Prism.highlight(this.$get('currentFeature.content'), Prism.languages.php));
                },
                // error
                function (response) {
                    console.log('Error fetching feature details', response.status);
                }
            );
            console.log('Got to show the details of: ', feature.title);
        },

        closeCurrentFeature: function() {
            this.codeDialog.close();
            this.isCodeShowing = false;
            this.currentFeature = null;
        }

    },

    ready: function () {
        this.loadServices();
        // set the code dialog reference
        this.codeDialog = document.querySelector('dialog');
    }
});
