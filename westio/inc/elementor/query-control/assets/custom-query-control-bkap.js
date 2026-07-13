(function ($, elementor) {

    var QueryControlView = elementor.modules.controls.BaseData.extend({
        isTitlesReceived: false,

        onReady: function () {
            this.initSelect2();
        },
        getControlValueByName(controlName) {
            const name = this.model.get('group_prefix') + controlName;
            return this.elementSettingsModel.attributes[name];
        },
        getQueryData() {
            // Use a clone to keep model data unchanged:
            const autocomplete = elementorCommon.helpers.cloneObject(this.model.get('autocomplete'));
            if (_.isEmpty(autocomplete.query)) {
                autocomplete.query = {};
            }
            // Specific for Group_Control_Query
            if ('cpt_tax' === autocomplete.object) {
                autocomplete.object = 'tax';
                if (_.isEmpty(autocomplete.query) || _.isEmpty(autocomplete.query.post_type)) {
                    autocomplete.query.post_type = this.getControlValueByName('post_type');
                }
            }
            return {
                autocomplete
            };
        },
        initSelect2: function () {
            var self = this;
            var $select = this.$el.find('select');

            // Init select2
            $select.select2({
                allowClear: true,
                placeholder: self.model.get('placeholder') || 'Search...',
                ajax: {
                    transport: function (params, success, failure) {

                        data = self.getQueryData();
                        data.q = params.data.q;

                        return elementorCommon.ajax.addRequest(
                            'westio_panel_posts_control_filter_autocomplete',
                            {
                                data: data,
                                success: success,
                                error: failure
                            }
                        );
                    },

                    data: function (params) {
                        return {q: params.term};
                    },
                    processResults: function (data) {
                        return data;
                    },
                    delay: 250,
                    cache: true
                }
            });

            // Load saved values (when editing)
            var controlValue = this.getControlValue();
            let filterTypeName = 'autocomplete',
                filterType = this.model.get(filterTypeName).object;
            let ids = this.getControlValue();

            if (!ids || !filterType) {
                return;
            }
            if (!_.isArray(ids)) {
                ids = [ids];
            }
            console.log('ids', ids);
            if (controlValue && controlValue.length) {
                var data = {};
                data.get_titles = self.getQueryData().autocomplete;
                data.ids = ids;
                data.unique_id = '' + self.cid + filterType;

                elementorCommon.ajax.addRequest(
                    'westio_query_control_value_titles',
                    {
                        ids: controlValue,
                        data: data,
                        success: function (results) {
                            Object.keys(results).forEach(function (id) {
                                var option = new Option(results[id], id, true, true);
                                $select.append(option);
                            });
                            $select.trigger('change');
                            console.log('results', results);
                            console.log('data', data);
                        }
                    }
                );


            }

            // Update value to Elementor
            $select.on('change', function () {
                self.setValue($(this).val());
            });
        },

    });

    // Register new control type
    elementor.addControlView('query', QueryControlView);

})(jQuery, window.elementor);


