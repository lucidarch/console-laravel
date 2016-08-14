new Vue({
    el: '#console',

    data: {
        page: 1,
        level: 'all',
        levelIcon: 'filter_list',
        logs: []
    },

    methods: {
        loadLogs: function(level) {
            var query = '';
            if (level && level !== 'all') {
                query = '&level='+level;
                this.level = level;
                this.levelIcon = level;
            } else {
                this.level = 'all';
                this.levelIcon = 'filter_list';
            }

            Vue.http.get('logs?page='+this.page+query).then(
                // success
                function(response) {
                    console.log('logs', response.json());
                    // this.$set('logs', response.json().data);
                    this.logs = response.json().data;
                }.bind(this),
                // error
                function (response) {
                    console.error(response.status());
                }
            );
        },

        chooseFilterLevel: function(level) {
            this.loadLogs(level);
        },

        markRead: function(entry, key) {
            Vue.http.put('logs/'+entry.id+'/read').then(
                // success
                function(response) {
                    console.log(response);
                    // delete from list
                    Vue.delete(this.logs, key);
                }.bind(this),
                // error
                function (response) {
                    console.error(response.status);
                }
            );
        },

        toggleStack: function(key) {
            // this.logs[key].showStack = !this.logs[key].showStack;
            Vue.set(this.logs[key], 'showStack', !this.logs[key].showStack);
        }
    },

    filters: {
        header: function(string) {
            return string.substr(string.indexOf(': ', string) + 2, string.length);
        },

        truncate: function(string, value) {
            if (string.length <= value) {
                return string;
            }

            return string.substring(0, value) + '...';
        }
    },

    ready: function() {
        console.log('logs ready');
        this.loadLogs();
    },
});
