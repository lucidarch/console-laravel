var Services = new Vue({

    el:'#console',

    mixins: [CodePreview],

    data: {
        // whether code preview is showing or not
        ServicesStore: window.ServicesStore.state,
        // the code preview dialog reference
        codeDialog: null,
        // the features of the currently chosen service
        features: [],
        currentService: null,
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
            Vue.http.get('services/'+service.slug+'/features').then(
                // success
                function (response) {
                    this.features = response.json()[service.name];
                }.bind(this),
                // error
                function (response) {
                    console.log('Error!', response.status);
                }
            );
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
