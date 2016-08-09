<div id="search-results">
    <table v-if="Search.query.length > 0" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <!-- Control header -->
        <thead>
            <tr>
                <th class="mdl-data-table__cell--non-numeric"><h5>Results</h5></th>
                <th class="mdl-data-table__cell--non-numeric">
                <button class="mdl-button mdl-js-button mdl-button--icon" @click="close">
                        <i class="material-icons">close</i>
                    </button>
                </th>
            </tr>
        </thead>
        <!-- Features header -->
        <thead v-if="SearchStore.results.features.length > 0">
            <tr style="background-color: indigo;">
                <th class="mdl-data-table__cell--non-numeric" style="color: white"><h4>Features</h4></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="feature in SearchStore.results.features">
                <td class="mdl-data-table__cell--non-numeric">@{{feature.title}}</td>
                <td>
                    <button class="mdl-button mdl-js-button mdl-button--icon" @click="showFeature(feature)">
                        <i class="material-icons">code</i>
                    </button>
                </td>
            </tr>
        </tbody>
        <!-- Jobs header -->
        <thead v-if="SearchStore.results.jobs.length > 0">
            <tr style="background-color: orange;">
                <th class="mdl-data-table__cell--non-numeric" style="color: white"><h4>Jobs</h4></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="job in SearchStore.results.jobs">
                <td class="mdl-data-table__cell--non-numeric">@{{job.title}}</td>
                <td>
                    <button class="mdl-button mdl-js-button mdl-button--icon" @click="showJob(job)">
                        <i class="material-icons">code</i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

var SearchStore = {
    state: {
        results: []
    },

    search: function(query) {
        Vue.http.post('search', {query: query}).then(
            // success
            function (response) {
                this.state.results = response.json();
                console.log('searched for', query, 'and got', response.json());
            }.bind(this),
            // error
            function (response) {
                console.log('Error searching', response.status);
            }
        );
    },

    clear: function() {
        this.state.results = [];
    }
}

var Search = new Vue({
    el: '#search-field',

    data: {
        query: '',
        SearchStore: window.SearchStore.state
    },

    methods: {
        search: function(e) {
            // pressed ESC?
            if (e.keyCode == 27) {
                return this.close();
            }

            return window.SearchStore.search(this.query);
        },

        close: function() {
            this.query = '';
            this.$el.className = this.$el.className.replace('is-focused', '').replace('is-dirty', '');
            window.SearchStore.clear();
        }
    }
});

var SearchResults = new Vue({
    el: '#search-results',

    mixins: [CodePreview],

    data: {
        Search: Search,
        SearchStore: window.SearchStore.state,
    },

    methods: {
        close: function() {
            this.Search.close();
        }
    }
});

</script>
