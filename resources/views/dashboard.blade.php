@extends('lucid::layout')

@section('content')
<div class="page-content">
    <div class="mdl-grid lucid-analysis">

    <!-- Summary -->
        <div class="mdl-cell mdl-cell--12-col">
            <h2 class="mdl-layout__title">Summary</h2>
        </div>
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" v-if="analysis.size">
            <div class="mdl-layout-spacer"></div>
            <div class="mdl-cell--10-col">
                <donut-chart title="Classes" :percent="Math.round(analysis.size.classes.percent)" foreground-color="orange" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Logical LOC" :percent="Math.round(analysis.size.logical_loc_percent)" foreground-color="#1394F6" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Commented Code" :percent="Math.round(analysis.size.comment_loc_percent)" foreground-color="#EC1361" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Static Method Calls" :percent="Math.round(analysis.dependencies.method.static_percent)" foreground-color="#9D1AB2" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <br>
                <donut-chart title="Abstract Classes" :percent="Math.round(analysis.structure.classes.abstract_percent)" foreground-color="orange" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Concrete Classes" :percent="Math.round(analysis.structure.classes.concrete_percent)" foreground-color="orange" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Static Methods" :percent="Math.round(analysis.structure.methods.scope.static_percent)" foreground-color="#9D1AB2" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
                <donut-chart title="Instance Methods" :percent="Math.round(analysis.structure.methods.scope.instance_percent)" foreground-color="#9D1AB2" background-color="#ededed" stroke-width="20" radius="60"></donut-chart>
            </div>
            <div class="mdl-layout-spacer"></div>
        </div>

        <!-- Structure -->
         <div class="mdl-cell mdl-cell--12-col">
            <h2 class="mdl-layout__title">Structure</h2>
        </div>
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" v-if="analysis.size">
            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Namespaces:</span>@{{analysis.structure.namespaces}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Interfaces:</span>@{{analysis.structure.interfaces}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Traits:</span> @{{analysis.structure.traits}}</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Classes:</span>@{{analysis.structure.classes.count}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Abstract Classes:</span>@{{analysis.structure.classes.abstract}} (@{{Math.round(analysis.structure.classes.abstract_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Concrete Classes:</span>@{{analysis.structure.classes.concrete}} (@{{Math.round(analysis.structure.classes.concrete_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Methods:</span>@{{analysis.structure.methods.count}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Abstract Methods:</span>@{{analysis.structure.methods.scope.instance}} (@{{Math.round(analysis.structure.methods.scope.instance_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Static Methods:</span>@{{analysis.structure.methods.scope.static}} (@{{Math.round(analysis.structure.methods.scope.static_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Public Methods:</span>@{{analysis.structure.methods.visibility.public}} (@{{Math.round(analysis.structure.methods.visibility.public_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Non-Public Methods:</span>@{{analysis.structure.methods.visibility.non_public}} (@{{Math.round(analysis.structure.methods.visibility.non_public_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Functions:</span>@{{analysis.structure.functions.count}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Anonymous Functions:</span>@{{analysis.structure.functions.anonymous}} (@{{Math.round(analysis.structure.functions.anonymous_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Named Functions:</span>@{{analysis.structure.functions.named}} (@{{Math.round(analysis.structure.functions.named_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Constants:</span>@{{analysis.structure.constants.count}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Global Constants:</span>@{{analysis.structure.constants.global}} (@{{Math.round(analysis.structure.constants.global_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Named Functions:</span>@{{analysis.structure.constants.classes}} (@{{Math.round(analysis.structure.constants.classes_percent)}}%)</li>
                </ul>
            </div>
        </div>

        <!-- Size -->
         <div class="mdl-cell mdl-cell--12-col">
            <h2 class="mdl-layout__title">Size</h2>
        </div>
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" v-if="analysis.size">
            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Lines of Code:</span>@{{analysis.size.loc}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Logical Lines of Code:</span>@{{analysis.size.logical_loc}} (@{{Math.round(analysis.size.logical_loc_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Commented Lines of Code:</span> @{{analysis.size.comment_loc}} (@{{Math.round(analysis.size.comment_loc_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Non-commented Lines of Code:</span>@{{analysis.size.non_comment_loc}} (@{{Math.round(analysis.size.non_comment_loc_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Classes:</span>@{{analysis.size.classes.count}} (@{{Math.round(analysis.size.classes.percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Class Length:</span>@{{Math.round(analysis.size.classes.avg_class_length)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Minimum Class Length:</span> @{{analysis.size.classes.min_class_length}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Maximum Class Length:</span>@{{analysis.size.classes.max_class_length}}</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Method Length:</span>@{{Math.round(analysis.size.classes.avg_method_length)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Minimum Method Length:</span>@{{analysis.size.classes.min_method_length}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Maximum Method Length:</span> @{{analysis.size.classes.max_method_length}}</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Functions:</span>@{{analysis.size.functions.count}} (@{{Math.round(analysis.size.functions.percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Function Length:</span>@{{Math.round(analysis.size.functions.avg_function_length)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Not in Classes nor Functions:</span>@{{analysis.size.not_in_classes_nor_functions}} (@{{Math.round(analysis.size.not_in_classes_nor_functions_percent)}}%)</li>
                </ul>
            </div>
        </div>

        <!-- Complexity -->
        <div class="mdl-cell mdl-cell--12-col">
            <h2 class="mdl-layout__title">Cyclomatic Complexity</h2>
        </div>
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" v-if="analysis.size">
            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Complexity per LLOC:</span>@{{Math.round(analysis.cyclomatic_complexity.avg_per_lloc)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Complexity per Class:</span>@{{Math.round(analysis.cyclomatic_complexity.avg_class)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Minimum Class Complexity:</span> @{{analysis.cyclomatic_complexity.min_class}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Maximum Class Complexity:</span>@{{analysis.cyclomatic_complexity.max_class}}</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Average Method Complexity:</span>@{{Math.round(analysis.cyclomatic_complexity.avg_method)}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Minimum Method Complexity:</span>@{{analysis.cyclomatic_complexity.min_method}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Maximum Method Complexity:</span> @{{analysis.cyclomatic_complexity.max_method}}</li>
                </ul>
            </div>
        </div>

        <!-- Dependencies -->
        <div class="mdl-cell mdl-cell--12-col">
            <h2 class="mdl-layout__title">Dependencies</h2>
        </div>
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" v-if="analysis.size">
            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Global Accesses:</span>@{{analysis.dependencies.global.accesses}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Global Constants:</span>@{{analysis.dependencies.global.constants}} (@{{Math.round(analysis.dependencies.global.constants_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Global Variables:</span> @{{analysis.dependencies.global.variables}} (@{{Math.round(analysis.dependencies.global.variables_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Super-Global Variables:</span>@{{analysis.dependencies.global.super_global_variables}} (@{{Math.round(analysis.dependencies.global.super_global_variables_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Attribue Accesses:</span>@{{analysis.dependencies.attribute.accesses}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Non-Static Attributes:</span>@{{analysis.dependencies.attribute.non_static}} (@{{Math.round(analysis.dependencies.attribute.non_static_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Static Attributes:</span> @{{analysis.dependencies.attribute.static}} (@{{Math.round(analysis.dependencies.attribute.static_percent)}}%)</li>
                </ul>
            </div>

            <div class="mdl-cell--4-col">
                <ul class="mdl-list">
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Method Calls:</span>@{{analysis.dependencies.method.calls}}</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Instance Methods:</span>@{{analysis.dependencies.method.instance}} (@{{Math.round(analysis.dependencies.method.instance_percent)}}%)</li>
                    <li class="mdl-list__item"><span class="mdl-list__item-primary-content">Static Methods:</span> @{{analysis.dependencies.method.static}} (@{{Math.round(analysis.dependencies.method.static_percent)}}%)</li>
                </ul>
            </div>
        </div>

    </div>
</div>
@stop

@section('scripts')

<script type="text/x-template" id="donut-template">
  <svg width="100" height="100" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">

    <!-- Background circle -->
    <path :d="dBg"
          fill="transparent"
          stroke="@{{backgroundColor}}"
          stroke-width="@{{strokeWidth}}"/>
    <text text-anchor="middle" x="100" y="105" fill="grey">@{{percent}}%</text>
    <!-- Move to start position, start drawing arc -->
    <path :d="d"
          fill="transparent"
          stroke="@{{foregroundColor}}"
          stroke-width="@{{strokeWidth}}"/>
    <text text-anchor="middle" x="100" y="190" fill="grey">@{{title}}</text>
  </svg>
</script>

<script type="text/javascript">

Vue.component('donut-chart', {
    props: [
        'percent',
        'foreground-color',
        'background-color',
        'stroke-width',
        'radius',
        'title'
    ],
    template: '#donut-template',
    replace: true,
    data: {
        // default values
        foregroundColor: "#badaff",
        backgroundColor: "#bada55",
        radius: 85,
        strokeWidth: 20,
        percent: 25
    },
    computed: {
        // If more than 50% filled we need to switch arc drawing mode from less than 180 deg to more than 180 deg
        largeArc: function () {
            return this.percent < 50 ? 0 : 1;
        },
        // Where to put x coordinate of center of circle
        x: function () {
            return 100;
        },
        // Where to put y coordinate of center of circle
        y: function () {
            return 100 - this.radius;
        },
        // Calculate X coordinate of end of arc (+ 100 to move it to middle of image)
        // add some rounding error to make arc not disappear at 100%
        endX: function () {
            return -Math.sin(this.radians) * this.radius + 100 - 0.0001;
        },
        // Calculate Y coordinate of end of arc (+ 100 to move it to middle of image)
        endY: function () {
            return Math.cos(this.radians) * this.radius + 100;
        },
        // Calculate length of arc in radians
        radians: function () {
            var degrees = (this.percent/100)*360
            var value = degrees - 180; // Turn the circle 180 degrees counter clockwise

            return (value*Math.PI)/180;
        },
        // If we reach full circle we need to complete the circle, this ties into the rounding error in X coordinate above
        z: function () {
            return this.percent == 100 ? 'z' : '';
        },
        dBg: function () {
            // M 100 20 A 80 80 0 1 1 99.9999 20 z
            return "M "+this.x+" "+this.y+" A "+this.radius+" "+this.radius+" 0 1 1 "+(this.x-0.0001)+" "+this.y+" z";
        },
        d: function () {
            // M 100 20 A 80 80 0 0 1 179.51099231387002 91.1690204928762
            return "M "+this.x+" "+this.y+" A "+this.radius+" "+this.radius+" 0 "+this.largeArc+" 1 "+this.endX+" "+this.endY+" "+this.z;
        }
    }
});


new Vue({
    el: '#console',

    data: {
        analysis: {}
    },

    methods: {

    },

    ready() {
        Vue.http.get('/lucid/analysis').then(
            // success
            function (response) {
                var data = response.json();
                var analysis = {};

                // Size
                analysis.size = {
                    loc: data.loc,
                    comment_loc: data.cloc,
                    comment_loc_percent: (data.loc > 0) ? (data.cloc / data.loc) * 100 : 0,
                    non_comment_loc: data.ncloc,
                    non_comment_loc_percent: (data.loc > 0) ? (data.ncloc / data.loc) * 100 : 0,
                    logical_loc: data.lloc,
                    logical_loc_percent: (data.loc > 0) ? (data.lloc / data.loc) * 100 : 0,

                    classes: {
                        count: data.llocClasses,
                        percent: (data.lloc > 0) ? (data.llocClasses / data.lloc) * 100 : 0,
                        avg_class_length: data.classLlocAvg,
                        min_class_length: data.classLlocMin,
                        max_class_length: data.classLlocMax,
                        avg_method_length: data.methodLlocAvg,
                        min_method_length: data.methodLlocMin,
                        max_method_length: data.methodLlocMax
                    },

                    functions: {
                        count: data.llocFunctions,
                        percent: (data.lloc > 0) ? (data.llocFunctions / data.lloc) * 100 : 0,
                        avg_function_length: data.llocByNof
                    },

                    not_in_classes_nor_functions: data.llocGlobal,
                    not_in_classes_nor_functions_percent: (data.lloc > 0) ? (data.llocGlobal / data.lloc) * 100 : 0
                };

                // Cyclomatic Complexity
                analysis.cyclomatic_complexity = {
                    avg_per_lloc: data.ccnByLloc,
                    avg_class: data.classCcnAvg,
                    min_class: data.classCcnMin,
                    max_class: data.classCcnMax,
                    avg_method: data.methodCcnAvg,
                    min_method: data.methodCcnMin,
                    max_method: data.methodCcnMax
                };

                // Dependencies
                analysis.dependencies = {
                    global: {
                        accesses: data.globalAccesses,
                        constants: data.globalConstantAccesses,
                        constants_percent: (data.globalAccesses > 0) ? (data.globalConstantAccesses / data.globalAccesses) * 100 : 0,
                        variables: data.globalVariableAccesses,
                        variables_percent: (data.globalAccesses > 0) ? (data.globalVariableAccesses / data.globalAccesses) * 100 : 0,
                        super_global_variables: data.superGlobalVariableAccesses,
                        super_global_variables_percent: (data.globalAccesses > 0) ? (data.superGlobalVariableAccesses / data.globalAccesses) * 100 : 0
                    },
                    attribute: {
                        accesses: data.attributeAccesses,
                        non_static: data.instanceAttributeAccesses,
                        non_static_percent: (data.attributeAccesses > 0) ? (data.instanceAttributeAccesses / data.attributeAccesses) * 100 : 0,
                        static: data.staticAttributeAccesses,
                        static_percent: (data.attributeAccesses > 0) ? (data.staticAttributeAccesses / data.attributeAccesses) * 100 : 0
                    },
                    method: {
                        calls: data.methodCalls,
                        instance: data.instanceMethodCalls,
                        instance_percent: (data.methodCalls > 0) ? (data.instanceMethodCalls / data.methodCalls) * 100 : 0,
                        static: data.staticMethodCalls,
                        static_percent:(data.methodCalls > 0) ? (data.staticMethodCalls / data.methodCalls) * 100 : 0
                    }
                };

                analysis.structure = {
                    namespaces: data.namespaces,
                    interfaces: data.interfaces,
                    traits: data.traits,
                    classes: {
                        count: data.classes,
                        abstract: data.abstractClasses,
                        abstract_percent: (data.classes > 0) ? (data.abstractClasses / data.classes) * 100 : 0,
                        concrete: data.concreteClasses,
                        concrete_percent: (data.classes > 0) ? (data.concreteClasses / data.classes) * 100 : 0,
                    },
                    methods: {
                        count: data.methods,
                        scope: {
                            instance: data.nonStaticMethods,
                            instance_percent: (data.methods > 0) ? (data.nonStaticMethods / data.methods) * 100 : 0,
                            static: data.staticMethods,
                            static_percent: (data.methods > 0) ? (data.staticMethods / data.methods) * 100 : 0
                        },
                        visibility: {
                            public: data.publicMethods,
                            public_percent: (data.methods > 0) ? (data.publicMethods / data.methods) * 100 : 0,
                            non_public: data.nonPublicMethods,
                            non_public_percent: (data.methods > 0) ? (data.nonPublicMethods / data.methods) * 100 : 0
                        }
                    },
                    functions: {
                        count: data.functions,
                        named: data.namedFunctions,
                        named_percent: (data.functions > 0) ? (data.namedFunctions / data.functions) * 100 : 0,
                        anonymous: data.anonymousFunctions,
                        anonymous_percent: (data.functions > 0) ? (data.anonymousFunctions / data.functions) * 100 : 0
                    },
                    constants: {
                        count: data.constants,
                        global: data.globalConstants,
                        global_percent: (data.constants > 0) ? (data.globalConstants / data.constants) * 100 : 0,
                        classes: data.classConstants,
                        classes_percent: (data.constants > 0) ? (data.classConstants / data.constants) * 100 : 0
                    }
                };

                this.analysis = analysis;
            }.bind(this),
            // error
            function (response) {
                console.error(response.status);
            }
        );
    }

});

</script>
@stop
