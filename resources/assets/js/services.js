
new Vue({

    el:'#content',

    data: {
        // whether code preview is showing or not
        isCodeShowing: false,
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
            // set the currently viewing feature
            this.currentFeature = feature;

            // fetch the contents of the current feature
            this.$http.get('features/'+feature.title).then(
                // success
                function (response) {
                    console.log('feature details: ', response.json());
                    this.$set('currentFeature', response.json());

                    // show the code modal
                    this.$set('isCodeShowing', true);
                    $('#codePreview').modal();

                    // generate and set highlighted content for this feature
                    this.$set('currentFeature.highlightedContent', Prism.highlight(this.$get('currentFeature.content'), Prism.languages.php));
                },
                // error
                function (response) {
                    console.log('Error fetching feature details', response.status);
                }
            );
            console.log('Got to show the details of: ', feature.title);
        }

    },

    ready: function () {
        this.loadServices();
    }
});
