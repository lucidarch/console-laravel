<div id="lucid-toast" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>

<script type="text/javascript">

var Toast = new Vue({
    el: '#lucid-toast',

    methods: {
        show: function(text, actionText, actionHandler) {
            var data = {
                message: text,
                timeout: 5000
            }

            if (actionText) {
                data.actionText = actionText;
                data.actionHandler = actionHandler
            }

            this.$el.MaterialSnackbar.showSnackbar(data);
        }
    }
});

</script>
