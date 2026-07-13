(function ($, elementor, elementorCommon) {

    ControlSelect2Query = elementor.modules.controls.Select2.extend({
        cache: null,
        isTitlesReceived: false,

        // Placeholder text for the Select2 dropdown
        getSelect2Placeholder() {
            return {
                id: '',
                text: wp.i18n.__('All', 'elementor-pro')
            };
        },

        // Get another control's value inside the same control group
        getControlValueByName(controlName) {
            const name = this.model.get('group_prefix') + controlName;
            return this.elementSettingsModel.attributes[name];
        },

        // Legacy query data (deprecated format)
        getQueryDataDeprecated() {
            return {
                filter_type: this.model.get('filter_type'),
                object_type: this.model.get('object_type'),
                include_type: this.model.get('include_type'),
                query: this.model.get('query')
            };
        },

        // Modern query data (autocomplete format)
        getQueryData() {
            const autocomplete = elementorCommon.helpers.cloneObject(this.model.get('autocomplete'));

            if (_.isEmpty(autocomplete.query)) {
                autocomplete.query = {};
            }

            // Special handling for CPT Taxonomies
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

        // Default Select2 options with Elementor Ajax integration
        getSelect2DefaultOptions() {
            const self = this;

            return $.extend(
                elementor.modules.controls.Select2.prototype.getSelect2DefaultOptions.apply(this, arguments),
                {
                    ajax: {
                        transport(params, success, failure) {
                            const bcFormat = !_.isEmpty(self.model.get('filter_type'));
                            let data = {},
                                action = 'westio_panel_posts_control_filter_autocomplete';

                            if (bcFormat) {
                                data = self.getQueryDataDeprecated();
                                action = 'panel_posts_control_filter_autocomplete_deprecated';
                            } else {
                                data = self.getQueryData();
                            }

                            data.q = params.data.q;

                            return elementorCommon.ajax.addRequest(action, {
                                data,
                                success,
                                error: failure
                            });
                        },
                        data(params) {
                            return {
                                q: params.term,
                                page: params.page
                            };
                        },
                        cache: true
                    },
                    escapeMarkup(markup) {
                        return markup;
                    },
                    minimumInputLength: 1
                }
            );
        },

        // Fetch and render saved value titles
        getValueTitles() {
            const self = this,
                data = {},
                bcFormat = !_.isEmpty(this.model.get('filter_type'));

            let ids = this.getControlValue(),
                action = 'westio_query_control_value_titles',
                filterTypeName = 'autocomplete',
                filterType = {};

            if (bcFormat) {
                filterTypeName = 'filter_type';
                filterType = this.model.get(filterTypeName).object;
                data.filter_type = filterType;
                data.object_type = self.model.get('object_type');
                data.include_type = self.model.get('include_type');
                data.unique_id = '' + self.cid + filterType;
                action = 'query_control_value_titles_deprecated';
            } else {
                filterType = this.model.get(filterTypeName).object;
                data.get_titles = self.getQueryData().autocomplete;
                data.unique_id = '' + self.cid + filterType;
            }

            if (!ids || !filterType) {
                return;
            }

            if (!_.isArray(ids)) {
                ids = [ids];
            }

            elementorCommon.ajax.loadObjects({
                action,
                ids,
                data,
                before() {
                    self.addControlSpinner();
                },
                // success(ajaxData) {
                //      self.isTitlesReceived = true;
                //      self.model.set('options', ajaxData);
                //      self.render();
                // }
                success(ajaxData) {
                    self.isTitlesReceived = true;

                    const $select = self.$el.find('select');

                    // Clear old options
                    $select.find('option').remove();

                    // Append the saved values as options
                    Object.keys(ajaxData).forEach(id => {
                        const option = new Option(ajaxData[id], id, true, true);
                        $select.append(option);
                    });

                    // Trigger change so Select2 can render .select2-selection__rendered
                    $select.trigger('change');

                    // Remove loading spinner
                    self.removeControlSpinner();
                }
            });
        },

        // UI mapping for Backbone (maps "this.ui.select")
        ui: function () {
            return {
                select: 'select'
            };
        },

        // Show loading spinner and disable the select
        addControlSpinner() {
            this.ui.select.prop('disabled', true);

            if (!this.$el.find('.elementor-control-spinner').length) {
                this.$el.find('.elementor-control-title').after(
                    '<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>'
                );
            }
        },

        // Remove loading spinner and re-enable the select
        removeControlSpinner() {
            this.ui.select.prop('disabled', false);
            this.$el.find('.elementor-control-spinner').remove();
        },

        // Called when the control is ready in Elementor editor
        onReady() {
            if (!this.isTitlesReceived) {
                this.getValueTitles();
            }
        }
    });

    // Register the custom control type
    elementor.addControlView('query', ControlSelect2Query);

})(jQuery, window.elementor, window.elementorCommon);
