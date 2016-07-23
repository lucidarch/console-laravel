<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lucid • Dashboard</title>
        <script type="text/javascript" src="/vendor/lucid/js/vue.js"></script>
        <script type="text/javascript" src="/vendor/lucid/js/vue-resource.js"></script>
    </head>
    <body>
        <div id="console">

            <div id="navigation">
                <a href="#" @click="currentView = 'services-page'">Services</a> |
                <a href="#" @click="currentView = 'services-page'">Domains</a>
            </div>

            <div id="page-content">

                <h3>Services</h3>
                <div id="services">
                    <li v-for="service in services">
                        <a @click="loadFeaturesForService(service)">{{ service.name }}</a>
                    </li>
                </div>

                <h3>Features</h3>
                <div id="features">
                    <li v-for="feature in features">
                        {{feature.title}}
                    </li>
                </div>

            </div>
        </div>
    <script type="text/javascript" src="/vendor/lucid/js/dashboard.js"></script>
    </body>
</html>
