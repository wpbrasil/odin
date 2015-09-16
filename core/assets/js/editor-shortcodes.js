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
                    text: ed.getLang('odin_shortcodes.buttons'),
                    menu: [
                        {
                            text: ed.getLang('odin_shortcodes.button'),
                            onclick: function () {
                                odin_ui.button();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.group_button'),
                            onclick: function () {
                                odin_ui.group_button();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.alert'),
                            onclick: function () {
                                odin_ui.alert();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.label'),
                            onclick: function () {
                                odin_ui.label();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.badge'),
                            onclick: function () {
                                odin_ui.badge();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.icon'),
                            onclick: function () {
                                odin_ui.icon();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.well'),
                            onclick: function () {
                                odin_ui.well();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.table'),
                            onclick: function () {
                                odin_ui.table();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.grid'),
                            onclick: function () {
                                odin_ui.grid();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.progress_bar'),
                            onclick: function () {
                                odin_ui.progress();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.panel'),
                            onclick: function () {
                                odin_ui.panel();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.tabs'),
                            onclick: function () {
                                odin_ui.tabs();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.accordions'),
                            onclick: function () {
                                odin_ui.accordions();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.tooltip'),
                            onclick: function () {
                                odin_ui.tooltip();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.map'),
                            onclick: function () {
                                odin_ui.map();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.clear'),
                            onclick: function () {
                                odin_ui.clear();
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.qrcode'),
                            onclick: function () {
                                odin_ui.qrcode();
                            }
                        }

                    ]
                },
                {
                    text: ed.getLang('odin_shortcodes.label'),
                    menu: [
                        {
                            text: ed.getLang('odin_shortcodes.products_by_sku'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.product_categories'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.products_by_cat_slug'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.products_by_attribute'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.recent_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.featured_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.sale_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.best_selling_products'),
                            onclick: function () {
                            }
                        },
                        {
                            text: ed.getLang('odin_shortcodes.top_rated_products'),
                            onclick: function () {
                            }
                        }
                    ]
                },
                {
                    text: ed.getLang('odin_shortcodes.shop_messages'),
                    onclick: function () {
                        editor.insertContent('[' + ed.getLang('odin_shortcodes.shop_messages_shortcode') + ']');
                    }
                },
                {
                    text: ed.getLang('odin_shortcodes.order_tracking'),
                    onclick: function () {
                        editor.insertContent('[' + ed.getLang('odin_shortcodes.order_tracking_shortcode') + ']');
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
            title: ed.getLang('odin_shortcodes.button'),
            body: [{
                type: 'textbox',
                name: 'text',
                label: ed.getLang('odin_shortcodes.text')
            }, {
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.default'),
                    value: 'default'
                }, {
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.warning'),
                    value: 'warning'
                }, {
                    text: ed.getLang('odin_shortcodes.danger'),
                    value: 'danger'
                }, {
                    text: ed.getLang('odin_shortcodes.link'),
                    value: 'link'
                }]
            }, {
                type: 'listbox',
                name: 'size',
                label: ed.getLang('odin_shortcodes.size'),
                values: [{
                    text: ed.getLang('odin_shortcodes.lg'),
                    value: 'lg'
                }, {
                    text: ed.getLang('odin_shortcodes.sm'),
                    value: 'sm'
                }, {
                    text: ed.getLang('odin_shortcodes.xs'),
                    value: 'xs'
                }]
            }, {
                type: 'textbox',
                name: 'link',
                label: ed.getLang('odin_shortcodes.link')
            }, {
                type: 'textbox',
                name: 'class_css',
                label: ed.getLang('odin_shortcodes.class')
            }, {
                type: 'textbox',
                name: 'tooltip',
                label: ed.getLang('odin_shortcodes.tooltip')
            }, {
                type: 'listbox',
                name: 'direction',
                label: ed.getLang('odin_shortcodes.direction'),
                values: [{
                    text: ed.getLang('odin_shortcodes.default'),
                    value: 'default'
                }, {
                    text: ed.getLang('odin_shortcodes.top'),
                    value: 'top'
                }, {
                    text: ed.getLang('odin_shortcodes.right'),
                    value: 'right'
                }, {
                    text: ed.getLang('odin_shortcodes.left'),
                    value: 'left'
                }, {
                    text: ed.getLang('odin_shortcodes.bottom'),
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
                    editor.windowManager.alert(ed.getLang('odin_shortcodes.need_text'));
                }
            }
        });
    }

    this.group_button = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.group_button'),
            body: [{
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.vertical'),
                    value: 'vertical'
                }, {
                    text: ed.getLang('odin_shortcodes.group'),
                    value: 'group'
                }]
            }, {
                type: 'listbox',
                name: 'size',
                label: ed.getLang('odin_shortcodes.size'),
                values: [{
                    text: ed.getLang('odin_shortcodes.lg'),
                    value: 'lg'
                }, {
                    text: ed.getLang('odin_shortcodes.sm'),
                    value: 'sm'
                }, {
                    text: ed.getLang('odin_shortcodes.xs'),
                    value: 'xs'
                }]
            },
                {
                    type: 'checkbox',
                    name: 'justified',
                    label: ed.getLang('odin_shortcodes.justified'),
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

    this.alert = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.alert'),
            body: [{
                type: 'textbox',
                name: 'content',
                label: ed.getLang('odin_shortcodes.content')
            }, {
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.warning'),
                    value: 'warning'
                }, {
                    text: ed.getLang('odin_shortcodes.danger'),
                    value: 'danger'
                }]
            },
                {
                    type: 'checkbox',
                    name: 'close',
                    label: ed.getLang('odin_shortcodes.close'),
                    checked: false
                }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ',
                    close = e.data.close == true ? 'close="' + e.data.close + '" ' : '';

                editor.insertContent('[alert ' + type + close + ']' + e.data.content + '[/alert]');
            }
        });
    }

    this.label = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.label'),
            body: [{
                type: 'textbox',
                name: 'content',
                label: ed.getLang('odin_shortcodes.content')
            }, {
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.default'),
                    value: 'default'
                }, {
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.warning'),
                    value: 'warning'
                }, {
                    text: ed.getLang('odin_shortcodes.danger'),
                    value: 'danger'
                }]
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[label ' + type + ']' + e.data.content + '[/label]');
            }
        });
    }

    this.badge = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.badge'),
            body: [{
                type: 'textbox',
                name: 'content',
                label: ed.getLang('odin_shortcodes.content')
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[badge ]' + e.data.content + '[/badge]');
            }
        });
    }

    this.icon = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.icon'),
            body: [{
                type: 'container',
                html: '<span class="glyphicon glyphicon-adjust"> </span>',
                name: 'type',
                label: ed.getLang('odin_shortcodes.icon'),
                values: [{
                    inline: '<span class="glyphicon glyphicon-adjust"> </span>',
                    value: 'default',
                    html: '<span class="glyphicon glyphicon-adjust"> </span>'
                }, {
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.warning'),
                    value: 'warning'
                }, {
                    text: ed.getLang('odin_shortcodes.danger'),
                    value: 'danger'
                }]
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[badge ]' + e.data.content + '[/badge]');
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