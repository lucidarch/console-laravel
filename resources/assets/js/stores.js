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
