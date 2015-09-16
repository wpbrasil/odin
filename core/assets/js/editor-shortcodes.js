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
            //O que fazer???
        });
    }

    this.well = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.well'),
            body: [{
                type: 'textbox',
                name: 'content',
                label: ed.getLang('odin_shortcodes.content')
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[well]' + e.data.content + '[/well]');
            }
        });
    }

    this.table = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.well'),
            body: [{
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.striped'),
                    value: 'striped'
                }, {
                    text: ed.getLang('odin_shortcodes.hover'),
                    value: 'hover'
                }, {
                    text: ed.getLang('odin_shortcodes.condensed '),
                    value: 'condensed '
                }, {
                    text: ed.getLang('odin_shortcodes.responsive'),
                    value: 'responsive'
                }]
            }, {
                type: 'checkbox',
                name: 'border',
                label: ed.getLang('odin_shortcodes.border'),
                checked: false
            },
                {
                    type: 'textbox',
                    name: 'cols',
                    label: ed.getLang('odin_shortcodes.cols'),
                },
                {
                    type: 'textbox',
                    name: 'rows',
                    label: ed.getLang('odin_shortcodes.rows'),
                }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ',
                    border = e.data.border == true ? 'border=true" ' : '',
                    cols = 'cols="' + e.data.cols + '" ',
                    rows = 'rows="' + e.data.rows + '" ';

                editor.insertContent('[table ' + type + border + cols + rows + ' ] ');
            }
        });
    }

    this.progress = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.well'),
            body: [{
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'striped'
                }, {
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.warning '),
                    value: 'warning '
                }, {
                    text: ed.getLang('odin_shortcodes.danger'),
                    value: 'danger'
                }]
            }, {
                type: 'listbox',
                name: 'class_css',
                label: ed.getLang('odin_shortcodes.class'),
                values: [{
                    text: ed.getLang('odin_shortcodes.progress-striped'),
                    value: 'progress-striped'
                }, {
                    text: ed.getLang('odin_shortcodes.active'),
                    value: 'active'
                }]
            },
                {
                    type: 'slider',
                    name: 'value',
                    label: ed.getLang('odin_shortcodes.value'),
                },
                {
                    type: 'textbox',
                    name: 'max',
                    label: ed.getLang('odin_shortcodes.max'),
                    value: '100'
                },
                {
                    type: 'textbox',
                    name: 'min',
                    label: ed.getLang('odin_shortcodes.min'),
                    value: '0'
                }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ',
                    class_css = 'class="' + e.data.class + '" ',
                    value = 'value="' + ((e.data.value * 0.01) * e.data.max - e.data.min) + '" ',
                    max = 'max="' + e.data.max + '" ',
                    min = 'min="' + e.data.min + '" ';

                editor.insertContent('[progress ' + type + class_css + value + max + min + ' ] ');
            }
        });
    }

    this.panel = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.panel'),
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
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.primary '),
                    value: 'primary'
                }, {
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.warning '),
                    value: 'warning '
                }, {
                    text: ed.getLang('odin_shortcodes.danger '),
                    value: 'danger '
                }]
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[panel][panel_body]' + e.data.content + '[/panel_body][/panel]');
            }
        });
    }
    //TODO rever esse shortcode (DEVE SER DINAMICO)
    this.tabs = function () {
    }
    //TODO rever esse shortcode (DEVE SER DINAMICO)
    this.accordion = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.panel'),
            body: [{
                type: 'textbox',
                name: 'accordions_id',
                label: ed.getLang('odin_shortcodes.accordions_id'),
                value: 'odin-accordion'
            }, {
                type: 'textbox',
                name: 'accordion_id',
                label: ed.getLang('odin_shortcodes.accordion_id'),
                value: 'odin-accordion'
            }, {
                type: 'textbox',
                name: 'title',
                label: ed.getLang('odin_shortcodes.title'),
            }, {
                type: 'listbox',
                name: 'type',
                label: ed.getLang('odin_shortcodes.type'),
                values: [{
                    text: ed.getLang('odin_shortcodes.default'),
                    value: 'default'
                }, {
                    text: ed.getLang('odin_shortcodes.info'),
                    value: 'info'
                }, {
                    text: ed.getLang('odin_shortcodes.primary '),
                    value: 'primary'
                }, {
                    text: ed.getLang('odin_shortcodes.success'),
                    value: 'success'
                }, {
                    text: ed.getLang('odin_shortcodes.warning '),
                    value: 'warning '
                }, {
                    text: ed.getLang('odin_shortcodes.danger '),
                    value: 'danger '
                }]
            }],
            onsubmit: function (e) {
                var type = 'type="' + e.data.type + '" ';

                editor.insertContent('[panel][panel_body]' + e.data.content + '[/panel_body][/panel]');
            }
        });
    }

    this.tooltip = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.tooltip'),
            body: [{
                type: 'textbox',
                name: 'title',
                label: ed.getLang('odin_shortcodes.title')
            },{
                type: 'textbox',
                name: 'content',
                label: ed.getLang('odin_shortcodes.content')
            },{
                type: 'textbox',
                name: 'link',
                label: ed.getLang('odin_shortcodes.link')
            }, {
                type: 'listbox',
                name: 'direction',
                label: ed.getLang('odin_shortcodes.direction'),
                values: [{
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
                    value: 'success'
                }]
            }],
            onsubmit: function (e) {
                var direction = 'direction="' + e.data.direction + '" ',
                    title = 'title="' + e.data.title + '" ',
                    link = 'link="' + e.data.link + '" ';

                editor.insertContent(' [tooltip '+ title + direction + link + ']'+ e.data.content +'[/tooltip]');

            }
        });
    }

    this.clear = function () {
        editor.insertContent('[clear]');
    }

    this.qrcode = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.qrcode'),
            body: [{
                type: 'textbox',
                name: 'data',
                label: ed.getLang('odin_shortcodes.data')
            },{
                type: 'textbox',
                name: 'size',
                label: ed.getLang('odin_shortcodes.size'),
                value: '150x150'
            },{
                type: 'textbox',
                name: 'title',
                label: ed.getLang('odin_shortcodes.title')
            }
            ],
            onsubmit: function (e) {
                var data = 'data="' + e.data.data + '" ',
                    size = 'size="' + e.data.size + '" ',
                    title = 'title="' + e.data.title + '" ';

                editor.insertContent(' [qrcode '+ data + size + title + ']');

            }
        });
    }

    this.map = function () {
        editor.windowManager.open({
            title: ed.getLang('odin_shortcodes.map'),
            body: [{
                type: 'textbox',
                name: 'id',
                value: 'odin_gmap',
                label: ed.getLang('odin_shortcodes.id')
            },{
                type: 'textbox',
                name: 'latitude',
                label: ed.getLang('odin_shortcodes.latitude')
            },{
                type: 'textbox',
                name: 'longitude',
                label: ed.getLang('odin_shortcodes.longitude')
            },{
                type: 'textbox',
                name: 'zoom',
                value: '10',
                label: ed.getLang('odin_shortcodes.zoom')
            },{
                type: 'textbox',
                name: 'width',
                value: '600',
                label: ed.getLang('odin_shortcodes.width')
            },{
                type: 'textbox',
                name: 'height',
                value: '400',
                label: ed.getLang('odin_shortcodes.height')
            },{
                type: 'listbox',
                name: 'maptype',
                label: ed.getLang('odin_shortcodes.maptype'),
                values: [{
                text: ed.getLang('odin_shortcodes.ROADMAP'),
                value: 'ROADMAP'
                }, {
                    text: ed.getLang('odin_shortcodes.SATELLITE'),
                    value: 'SATELLITE'
                }, {
                    text: ed.getLang('odin_shortcodes.HYBRID'),
                    value: 'HYBRID'
                }, {
                    text: ed.getLang('odin_shortcodes.TERRAIN'),
                    value: 'TERRAIN'
                }, {
                    text: ed.getLang('odin_shortcodes.TERRAIN'),
                    value: 'TERRAIN'
                }]},
            {
                type: 'textbox',
                name: 'adress',
                label: ed.getLang('odin_shortcodes.adress')
            },
            {
                type: 'textbox',
                name: 'kml',
                label: ed.getLang('odin_shortcodes.kml')
            },
            {
                type: 'checkbox',
                name: 'kmlautofit',
                label: ed.getLang('odin_shortcodes.kmlautofit'),
                checked: false
            },
            {
                type: 'checkbox',
                name: 'marker',
                label: ed.getLang('odin_shortcodes.marker'),
                checked: false
            },
            {
                type: 'textbox',
                name: 'markerimage',
                label: ed.getLang('odin_shortcodes.markerimage')
            },
            {
                type: 'checkbox',
                name: 'traffic',
                label: ed.getLang('odin_shortcodes.traffic'),
                checked: false
            },
            {
                type: 'checkbox',
                name: 'bike',
                label: ed.getLang('odin_shortcodes.bike'),
                checked: false
            },
            {
                type: 'textbox',
                name: 'fusion',
                label: ed.getLang('odin_shortcodes.fusion'),

            },
            {
                type: 'textbox',
                name: 'infowindow',
                label: ed.getLang('odin_shortcodes.infowindow'),

            },
            {
                type: 'checkbox',
                name: 'infowindowdefault',
                label: ed.getLang('odin_shortcodes.infowindowdefault'),
                checked: false
            },
            {
                type: 'checkbox',
                name: 'hidecontrols',
                label: ed.getLang('odin_shortcodes.hidecontrols'),
                checked: false
            },
            {
                type: 'checkbox',
                name: 'scale',
                label: ed.getLang('odin_shortcodes.scale'),
                checked: false
            },
            {
                type: 'checkbox',
                name: 'scrollwheel',
                label: ed.getLang('odin_shortcodes.scrollwheel'),
                checked: true
            }],
            onsubmit: function (e) {
                var data = 'data="' + e.data.data + '" ',
                    size = 'size="' + e.data.size + '" ',
                    title = 'title="' + e.data.title + '" ';

                editor.insertContent(' [map ]');

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