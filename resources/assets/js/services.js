
new Vue({

    el:'#console',

    data: {
        // whether code preview is showing or not
        ServicesStore: window.ServicesStore.state,
        // determines whether the code preview is currently showing
        isCodeShowing: false,
        // the code preview dialog reference
        codeDialog: null,
        // the features of the currently chosen service
        features: [],
        currentService: null,
        currentFeature: null,
        // controls whether to show the filter row in the results
        filterQuery: '',
        shouldShowFilterRow: false,
        filteredFeatures: []
    },

    computed: {
        // determine whether to show the filtered results or not
        shouldShowFilteredResults: function() {
            return this.filterQuery.length > 1;
        },
    },

    methods: {

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

            this.filteredFeatures = this.features.filter(function(feature) {
                // do case-insensitive search
                var title = feature.title.replace(' ', '').trim().toLowerCase();
                var query = this.filterQuery.trim().toLowerCase();

                return title.indexOf(query) !== -1 ||                   // non-spaced title
                    feature.title.toLowerCase().indexOf(query) !== -1 ||    // title as is (with spaces)
                    feature.file.toLowerCase().indexOf(query) !== -1;       // file name
            }, this);
        },

        cancelFilter: function() {
            this.shouldShowFilterRow = false;
            this.filterQuery = '';
        }
    },

    ready: function () {
        window.ServicesStore.load();
        // set the code dialog reference
        this.codeDialog = document.querySelector('dialog');
    }
});
