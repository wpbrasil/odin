/*global tinymce */
(function () {

    /**
     * Check is empty.
     *
     * @param  {string} value
     * @return {bool}
     */
    function isEmpty(value) {
        value = value.toString();

        if (0 !== value.length) {
            return false;
        }

        return true;
    }

    /**
     * Add the shortcodes downdown.
     */
    tinymce.PluginManager.add('odin_shortcodes', function (editor) {
        var ed = tinymce.activeEditor;
        editor.addButton('odin_shortcodes', {
            text: ed.getLang('odin_shortcodes.shortcode_title'),
            icon: 'odin-shortcodes',
            type: 'menubutton',
            menu: [{
                text: ed.getLang('odin.buttons'),
                menu: [{
                    text: ed.getLang('odin.button'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.button'),
                            body: [{
                                type: 'textbox',
                                name: 'text',
                                label: ed.getLang('odin.text')
                            }, {
                                type: 'listbox',
                                name: 'type',
                                label: ed.getLang('odin.type'),
                                values: [{
                                    text: ed.getLang('odin.default'),
                                    value: 'default'
                                }, {
                                    text: ed.getLang('odin.success'),
                                    value: 'success'
                                }, {
                                    text: ed.getLang('odin.warning'),
                                    value: 'warning'
                                }, {
                                    text: ed.getLang('odin.danger'),
                                    value: 'danger'
                                }, {
                                    text: ed.getLang('odin.link'),
                                    value: 'link'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'size',
                                label: ed.getLang('odin.size'),
                                values: [{
                                    text: ed.getLang('odin.lg'),
                                    value: 'lg'
                                }, {
                                    text: ed.getLang('odin.sm'),
                                    value: 'sm'
                                }, {
                                    text: ed.getLang('odin.xs'),
                                    value: 'xs'
                                }]
                            }, {
                                type: 'textbox',
                                name: 'link',
                                label: ed.getLang('odin.link')
                            }, {
                                type: 'textbox',
                                name: 'class_css',
                                label: ed.getLang('odin.class')
                            }, {
                                type: 'textbox',
                                name: 'tooltip',
                                label: ed.getLang('odin.tooltip')
                            }, {
                                type: 'listbox',
                                name: 'direction',
                                label: ed.getLang('odin.direction'),
                                values: [{
                                    text: ed.getLang('odin.default'),
                                    value: 'default'
                                }, {
                                    text: ed.getLang('odin.top'),
                                    value: 'top'
                                }, {
                                    text: ed.getLang('odin.right'),
                                    value: 'right'
                                }, {
                                    text: ed.getLang('odin.left'),
                                    value: 'left'
                                }, {
                                    text: ed.getLang('odin.bottom'),
                                    value: 'bottom'
                                }]
                            }],
                            onsubmit: function (e) {
                                //fron textfield fields
                                var text = isEmpty(e.data.text) ? '' : e.data.text,
                                    link = isEmpty(e.data.link) ? '' : 'link="' + e.data.link + '" ',
                                    class_css = isEmpty(e.data.class_css) ? '' : 'class="' + e.data.class_css + '" ',
                                    tooltip = isEmpty(e.data.tooltip) ? '' : 'tooltip="' + e.data.tooltip + '" ';
                                //from dropdown fields
                                var type = 'type="' + e.data.type + '" ',
                                    size = 'size="' + e.data.size + '" ',
                                    direction = e.data.direction == 'default' ? '' : 'direction="' + e.data.direction + '" ';

                                if (!isEmpty(e.data.text)) {
                                    editor.insertContent('[button ' + type + size + link + class_css + tooltip + direction + ']' + text + '[/button]');
                                } else {
                                    editor.windowManager.alert(ed.getLang('odin.need_text'));
                                }
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.button_group'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.group_button'),
                            body: [{
                                type: 'listbox',
                                name: 'type',
                                label: ed.getLang('odin.type'),
                                values: [{
                                    text: ed.getLang('odin.vertical'),
                                    value: 'vertical'
                                }, {
                                    text: ed.getLang('odin.group'),
                                    value: 'group'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'size',
                                label: ed.getLang('odin.size'),
                                values: [{
                                    text: ed.getLang('odin.lg'),
                                    value: 'lg'
                                }, {
                                    text: ed.getLang('odin.sm'),
                                    value: 'sm'
                                }, {
                                    text: ed.getLang('odin.xs'),
                                    value: 'xs'
                                }]
                            },
                                {
                                    type: 'checkbox',
                                    name: 'justified',
                                    label: ed.getLang('odin.justified'),
                                    checked: false
                                }],
                            onsubmit: function (e) {
                                var type = 'type="'+ e.data.type + '" ',
                                    size = 'size="' + e.data.size + '" ',
                                    justified = 'justified="' + e.data.justified + '" ';

                                editor.insertContent('[button_group ' + type + size + justified + '] #content [/button_group]');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.product_by_sku'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.product') + ' ' + ed.getLang('odin.product_by_sku'),
                            body: [{
                                type: 'textbox',
                                name: 'id',
                                label: ed.getLang('odin.id')
                            }, {
                                type: 'textbox',
                                name: 'sku',
                                label: ed.getLang('odin.sku')
                            }],
                            onsubmit: function (e) {
                                var id = isEmpty(e.data.id) ? '' : ' id="' + e.data.id + '"',
                                    sku = isEmpty(e.data.sku) ? '' : ' sku="' + e.data.sku + '"';

                                if (!isEmpty(e.data.id) || !isEmpty(e.data.sku)) {
                                    editor.insertContent('[product' + id + sku + ']');
                                } else {
                                    editor.windowManager.alert(ed.getLang('odin.need_id_or_sku'));
                                }
                            }
                        });
                    }
                }]
            }, {
                text: ed.getLang('odin.list'),
                menu: [{
                    text: ed.getLang('odin.products_by_sku'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.product_by_sku'),
                            body: [{
                                type: 'textbox',
                                name: 'ids',
                                label: ed.getLang('odin.ids'),
                                tooltip: ed.getLang('odin.comma_tooltip')
                            }, {
                                type: 'textbox',
                                name: 'skus',
                                label: ed.getLang('odin.skus'),
                                tooltip: ed.getLang('odin.comma_tooltip')
                            }],
                            onsubmit: function (e) {
                                var ids = isEmpty(e.data.ids) ? '' : ' ids="' + e.data.ids + '"',
                                    skus = isEmpty(e.data.skus) ? '' : ' skus="' + e.data.skus + '"';

                                if (!isEmpty(e.data.ids) || !isEmpty(e.data.skus)) {
                                    editor.insertContent('[products' + ids + skus + ']');
                                } else {
                                    editor.windowManager.alert(ed.getLang('odin.need_id_or_sku'));
                                }
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.product_categories'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.product_categories'),
                            body: [{
                                type: 'textbox',
                                name: 'number',
                                label: ed.getLang('odin.number')
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.name'),
                                    value: 'name'
                                }, {
                                    text: ed.getLang('odin.id'),
                                    value: 'id'
                                }, {
                                    text: ed.getLang('odin.count'),
                                    value: 'count'
                                }, {
                                    text: ed.getLang('odin.slug'),
                                    value: 'slug'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns')
                            }, {
                                type: 'checkbox',
                                name: 'hide_empty',
                                label: ed.getLang('odin.hide_empty'),
                                checked: true
                            }, {
                                type: 'textbox',
                                name: 'parent_id',
                                label: ed.getLang('odin.parent_id')
                            }, {
                                type: 'textbox',
                                name: 'ids',
                                label: ed.getLang('odin.ids'),
                                tooltip: ed.getLang('odin.comma_tooltip')
                            }],
                            onsubmit: function (e) {
                                var number = isEmpty(e.data.number) ? '' : ' number="' + e.data.number + '"',
                                    columns = isEmpty(e.data.columns) ? '' : ' columns="' + e.data.columns + '"',
                                    hide_empty = e.data.hide_empty ? '' : ' hide_empty="' + e.data.hide_empty + '"',
                                    parent_id = isEmpty(e.data.parent_id) ? '' : ' parent="' + e.data.parent_id + '"',
                                    ids = isEmpty(e.data.ids) ? '' : ' ids="' + e.data.ids + '"';

                                editor.insertContent('[product_categories' + number + columns + ' orderby="' + e.data.orderby + '" order="' + e.data.order + '"' + hide_empty + parent_id + ids + ']');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.products_by_cat_slug'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.products_by_cat_slug'),
                            body: [{
                                type: 'textbox',
                                name: 'category_slug',
                                label: ed.getLang('odin.category_slug')
                            }, {
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.categories_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.default'),
                                    value: 'default'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.price'),
                                    value: 'price'
                                }, {
                                    text: ed.getLang('odin.popularity'),
                                    value: 'popularity'
                                }, {
                                    text: ed.getLang('odin.rating'),
                                    value: 'rating'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'operator',
                                label: ed.getLang('odin.operator'),
                                values: [{
                                    text: ed.getLang('odin.in'),
                                    value: 'IN'
                                }, {
                                    text: ed.getLang('odin.not_in'),
                                    value: 'NOT IN'
                                }, {
                                    text: ed.getLang('odin.and'),
                                    value: 'AND'
                                }]
                            }],
                            onsubmit: function (e) {
                                var category = isEmpty(e.data.category_slug) ? '' : ' category="' + e.data.category_slug + '"';

                                if (!isEmpty(e.data.category_slug)) {
                                    editor.insertContent('[product_category' + category + ' per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '" operator="' + e.data.operator + '"]');
                                } else {
                                    editor.windowManager.alert(ed.getLang('odin.need_category_slug'));
                                }
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.products_by_attribute'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.products_by_attribute'),
                            body: [{
                                type: 'textbox',
                                name: 'attribute_slug',
                                label: ed.getLang('odin.attribute_slug')
                            }, {
                                type: 'textbox',
                                name: 'terms_slug',
                                label: ed.getLang('odin.terms_slug'),
                                tooltip: ed.getLang('odin.comma_tooltip')
                            }, {
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                if (!isEmpty(e.data.attribute_slug) && !isEmpty(e.data.terms_slug)) {
                                    editor.insertContent('[product_attribute attribute="' + e.data.attribute_slug + '" filter="' + e.data.terms_slug + '" per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                                } else {
                                    editor.windowManager.alert(ed.getLang('odin.need_attribute_and_terms_slugs'));
                                }
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.recent_products'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.recent_products'),
                            body: [{
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                editor.insertContent('[recent_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.featured_products'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.featured_products'),
                            body: [{
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                editor.insertContent('[featured_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.sale_products'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.sale_products'),
                            body: [{
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                editor.insertContent('[sale_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.best_selling_products'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.best_selling_products'),
                            body: [{
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                editor.insertContent('[best_selling_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                            }
                        });
                    }
                }, {
                    text: ed.getLang('odin.top_rated_products'),
                    onclick: function () {
                        editor.windowManager.open({
                            title: ed.getLang('odin.top_rated_products'),
                            body: [{
                                type: 'textbox',
                                name: 'per_page',
                                label: ed.getLang('odin.products_per_page'),
                                value: '12'
                            }, {
                                type: 'textbox',
                                name: 'columns',
                                label: ed.getLang('odin.columns'),
                                value: '4'
                            }, {
                                type: 'listbox',
                                name: 'orderby',
                                label: ed.getLang('odin.orderby'),
                                values: [{
                                    text: ed.getLang('odin.date'),
                                    value: 'date'
                                }, {
                                    text: ed.getLang('odin.rand'),
                                    value: 'rand'
                                }, {
                                    text: ed.getLang('odin.title'),
                                    value: 'title'
                                }, {
                                    text: ed.getLang('odin.none'),
                                    value: 'none'
                                }]
                            }, {
                                type: 'listbox',
                                name: 'order',
                                label: ed.getLang('odin.order'),
                                values: [{
                                    text: ed.getLang('odin.asc'),
                                    value: 'ASC'
                                }, {
                                    text: ed.getLang('odin.desc'),
                                    value: 'DESC'
                                }]
                            }],
                            onsubmit: function (e) {
                                editor.insertContent('[top_rated_products per_page="' + e.data.per_page + '" columns="' + e.data.columns + '" orderby="' + e.data.orderby + '" order="' + e.data.order + '"]');
                            }
                        });
                    }
                }]
            }, {
                text: ed.getLang('odin.shop_messages'),
                onclick: function () {
                    editor.insertContent('[' + ed.getLang('odin.shop_messages_shortcode') + ']');
                }
            }, {
                text: ed.getLang('odin.order_tracking'),
                onclick: function () {
                    editor.insertContent('[' + ed.getLang('odin.order_tracking_shortcode') + ']');
                }
            }]
        });
    });
})();
