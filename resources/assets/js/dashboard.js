// configure vue-resource
Vue.http.options.root = '/lucid';
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
Vue.http.interceptors.push((request, next)  => {

    var indicator = document.createElement("div");
    indicator.className = "lucid-progress-indicator mdl-progress mdl-js-progress mdl-progress__indeterminate full-width";
    document.querySelector('#lucid-progress-container').appendChild(indicator);

    // continue to next interceptor
    next((response) => {
        indicator.remove();
    });
});
