/*global tinymce */
(function () {

    /**
     * Add the shortcodes downdown.
     */
    tinymce.PluginManager.add('odin_shortcodes', function (editor) {
        var ed = tinymce.activeEditor;
        var odin_ui = new Odin_Shortcode_UI(editor, ed);


        editor.addButton('odin_shortcodes', {
            text: ed.getLang('odin_shortcodes.shortcode_title'),
            icon: 'odin-shortcodes',
            type: 'menubutton',
            menu: [
                {
                    text: ed.getLang('odin.buttons'),
                    menu: [
                        {
                            text: ed.getLang('odin.button'),
                            onclick: function () {
                                odin_ui.button();
                            }
                        },
                        {
                            text: ed.getLang('odin.group_button'),
                            onclick: function () {
                                odin_ui.group_button();
                            }
                        },
                        {
                            text: ed.getLang('odin.product_by_sku'),
                            onclick: function () {
                            }
                        }
                    ]
                },
                {
                    text: ed.getLang('odin.list'),
                    menu: [
                        {
                            text: ed.getLang('odin.products_by_sku'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.product_categories'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.products_by_cat_slug'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.products_by_attribute'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.recent_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.featured_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.sale_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.best_selling_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin.top_rated_products'),
                            onclick: function () {
                            }
                        }
                    ]
                },
                {
                    text: ed.getLang('odin.shop_messages'),
                    onclick: function () {
                        editor.insertContent('[' + ed.getLang('odin.shop_messages_shortcode') + ']');
                    }
                },
                {
                    text: ed.getLang('odin.order_tracking'),
                    onclick: function () {
                        editor.insertContent('[' + ed.getLang('odin.order_tracking_shortcode') + ']');
                    }
                }
            ]
        });


    });

})();

function Odin_Shortcode_UI(_editor, _ed) {
    var editor = _editor;
    var ed = _ed;

    this.button = function () {
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

    this.group_button = function() {
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
                var type = 'type="' + e.data.type + '" ',
                    size = 'size="' + e.data.size + '" ',
                    justified = 'justified="' + e.data.justified + '" ';

                editor.insertContent('[button_group ' + type + size + justified + '] #content [/button_group]');
            }
        });
    }
}

/**
 * Check is empty.
 *
 * @param  {string} value
 * @return {bool}
 */
this.isEmpty = function (value) {
    value = value.toString();

    if (0 !== value.length) {
        return false;
    }

    return true;
}