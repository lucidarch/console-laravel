var DomainsStore = {
    state: {
        domains: []
    },

    load: function() {
        Vue.http.get('domains').then(
            // success
            function (response) {
                console.log('domains', response.json());
                this.state.domains = response.json();
            }.bind(this),
            // error
            function (response) {
                console.log('Error fetching domains', response.status);
            }
        );
    }
}

var ServicesStore = {
    state: {
        services: []
    },

    load: function() {
        Vue.http.get('services').then(
            // success
            function (response) {
                console.log('services', response.json());
                this.state.services = response.json();
            }.bind(this),
            // error
            function (response) {
                console.log('Error fetching services', response.status);
            }
        );
    }
}

var JobsStore = {
    state: {
        jobs: [],
        byDomain: []
    },

    load: function() {
        Vue.http.get('jobs').then(
            // success
            function (response) {
                this.state.byDomain = response.json();
                this.state.jobs = this.flatten(this.state.byDomain);
            }.bind(this),
            // error
            function (response) {
                console.log('Error fetching jobs', response.status);
            }
        );
    },

    flatten: function(domains) {
        var jobs = [];

        for (domain in domains) {
            for (job in domains[domain]) {
                jobs.push(domains[domain][job]);
            }
        }

        return jobs;
    }
}
