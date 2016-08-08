// mixin to be included in any vue object
// wanting to have the functionality of code preview.
var CodePreview = {
    methods: {
        showFeature: function(feature) {
            CodePreviewDialogs.showFeature(feature);
        },

        closeCurrentFeature: function() {
            CodePreviewDialogs.closeCurrentFeature();
        },

        showJob: function(job) {
            CodePreviewDialogs.showJob(job);
        },

        closeCurrentJob: function() {
            CodePreviewDialogs.closeCurrentJob();
        }
    }
};
