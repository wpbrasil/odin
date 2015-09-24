/*global tinymce */
(function() {

	/**
	 * Add the shortcodes downdown.
	 */
	tinymce.PluginManager.add( 'odin_shortcodes', function( editor ) {
		var ed      = tinymce.activeEditor;
		var odin_ui = new Odin_Shortcode_UI( editor, ed );

		editor.addButton(
			'odin', {
				text: ed.getLang( 'odin.shortcode_title' ),
				type: 'menubutton',
				menu: [ {
					text   : ed.getLang( 'odin.button' ),
					onclick: function() {
						odin_ui.button();
					}
				}, {
					text   : ed.getLang( 'odin.group_button' ),
					onclick: function() {
						odin_ui.group_button();
					}
				}, {
					text   : ed.getLang( 'odin.alert' ),
					onclick: function() {
						odin_ui.alert();
					}
				}, {
					text   : ed.getLang( 'odin.label' ),
					onclick: function() {
						odin_ui.label();
					}
				}, {
					text   : ed.getLang( 'odin.badge' ),
					onclick: function() {
						odin_ui.badge();
					}
				}, {
					text   : ed.getLang( 'odin.icon' ),
					onclick: function() {
						odin_ui.icon();
					}
				}, {
					text   : ed.getLang( 'odin.well' ),
					onclick: function() {
						odin_ui.well();
					}
				}, {
					text   : ed.getLang( 'odin.table' ),
					onclick: function() {
						odin_ui.table();
					}
				}, {
					text   : ed.getLang( 'odin.grid' ),
					onclick: function() {
						odin_ui.grids();
					}
				}, {
					text   : ed.getLang( 'odin.progress_bar' ),
					onclick: function() {
						odin_ui.progress();
					}
				}, {
					text   : ed.getLang( 'odin.panel' ),
					onclick: function() {
						odin_ui.panel();
					}
				}, {
					text   : ed.getLang( 'odin.tabs' ),
					onclick: function() {
						odin_ui.tabs();
					}
				}, {
					text   : ed.getLang( 'odin.accordion' ),
					onclick: function() {
						odin_ui.accordion();
					}
				}, {
					text   : ed.getLang( 'odin.tooltip' ),
					onclick: function() {
						odin_ui.tooltip();
					}
				}, {
					text   : ed.getLang( 'odin.map' ),
					onclick: function() {
						odin_ui.map();
					}
				}, {
					text   : ed.getLang( 'odin.clear' ),
					onclick: function() {
						odin_ui.clear();
					}
				}, {
					text   : ed.getLang( 'odin.qrcode' ),
					onclick: function() {
						odin_ui.qrcode();
					}
				} ]
			} );
	} );
})();

function Odin_Shortcode_UI( _editor, _ed ) {
	var editor = _editor;
	var ed     = _ed;

	this.button = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.button' ),
			body    : [ {
				type : 'textbox',
				name : 'text',
				label: ed.getLang( 'odin.text' )
			}, {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.default' ),
					value: 'default'
				}, {
					text : ed.getLang( 'odin.success' ),
					value: 'success'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning'
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger'
				}, {
					text : ed.getLang( 'odin.link' ),
					value: 'link'
				} ]
			}, {
				type  : 'listbox',
				name  : 'size',
				label : ed.getLang( 'odin.size' ),
				values: [ {
					text : ed.getLang( 'odin.lg' ),
					value: 'lg'
				}, {
					text : ed.getLang( 'odin.sm' ),
					value: 'sm'
				}, {
					text : ed.getLang( 'odin.xs' ),
					value: 'xs'
				} ]
			}, {
				type : 'textbox',
				name : 'link',
				id   : 'link_button_input',
				label: ed.getLang( 'odin.link' )
			}, {
				type : 'textbox',
				name : 'class_css',
				id   : 'class_button_input',
				label: ed.getLang( 'odin.class' )
			}, {
				type : 'textbox',
				name : 'tooltip',
				label: ed.getLang( 'odin.tooltip' )
			}, {
				type  : 'listbox',
				name  : 'direction',
				label : ed.getLang( 'odin.direction' ),
				values: [ {
					text : ed.getLang( 'odin.default' ),
					value: 'default'
				}, {
					text : ed.getLang( 'odin.top' ),
					value: 'top'
				}, {
					text : ed.getLang( 'odin.right' ),
					value: 'right'
				}, {
					text : ed.getLang( 'odin.left' ),
					value: 'left'
				}, {
					text : ed.getLang( 'odin.bottom' ),
					value: 'bottom'
				} ]
			} ],
			onsubmit: function( e ) {
				// From textfield fields
				var text      = isEmpty( e.data.text ) ? '' : e.data.text,
				    link      = isEmpty( e.data.link ) ? '' : 'link="' + e.data.link + '" ',
				    class_css = isEmpty( e.data.class_css ) ? '' : 'class="' + e.data.class_css + '" ',
				    tooltip   = isEmpty( e.data.tooltip ) ? '' : 'tooltip="' + e.data.tooltip + '" ';
				// From dropdown fields
				var type      = 'type="' + e.data.type + '" ',
				    size      = 'size="' + e.data.size + '" ',
				    direction = e.data.direction == 'default' ? '' : 'direction="' + e.data.direction + '" ';

				editor.insertContent( '[button ' + type + size + link + class_css + tooltip + direction + ']' + text + '[/button]' );
			}
		} );

		jQuery( '#class_button_input' ).attr( 'placeholder', 'hover' );
		jQuery( '#link_button_input' ).attr( 'placeholder', 'http://www.site.com' );

	};

	this.group_button = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.group_button' ),
			minWidth: 300,
			body    : [ {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.vertical' ),
					value: 'vertical'
				}, {
					text : ed.getLang( 'odin.group' ),
					value: 'group'
				} ]
			}, {
				type  : 'listbox',
				name  : 'size',
				label : ed.getLang( 'odin.size' ),
				values: [ {
					text : ed.getLang( 'odin.lg' ),
					value: 'lg'
				}, {
					text : ed.getLang( 'odin.sm' ),
					value: 'sm'
				}, {
					text : ed.getLang( 'odin.xs' ),
					value: 'xs'
				} ]
			}, {
				type   : 'checkbox',
				name   : 'justified',
				label  : ed.getLang( 'odin.justified' ),
				checked: false
			} ],
			onsubmit: function( e ) {
				var type      = 'type="' + e.data.type + '" ',
				    size      = 'size="' + e.data.size + '" ',
				    justified = 'justified="' + e.data.justified + '" ';
				editor.insertContent( '[button_group ' + type + size + justified + ']  #content  [/button_group]' );
			}
		} );
	};

	this.alert = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.alert' ),
			body    : [ {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			}, {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.success' ),
					value: 'success'
				}, {
					text : ed.getLang( 'odin.info' ),
					value: 'info'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning'
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger'
				} ]
			}, {
				type   : 'checkbox',
				name   : 'close',
				label  : ed.getLang( 'odin.close' ),
				checked: false
			} ],
			onsubmit: function( e ) {
				var type  = 'type="' + e.data.type + '" ',
				    close = true === e.data.close ? 'close="' + e.data.close + '" ' : '';

				editor.insertContent( '[alert ' + type + close + ']' + e.data.content + '[/alert]' );
			}
		} );
	};

	this.label = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.label' ),
			body    : [ {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			}, {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.default' ),
					value: 'default'
				}, {
					text : ed.getLang( 'odin.success' ),
					value: 'success'
				}, {
					text : ed.getLang( 'odin.info' ),
					value: 'info'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning'
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger'
				} ]
			} ],
			onsubmit: function( e ) {
				var type = 'type="' + e.data.type + '" ';
				editor.insertContent( '[label ' + type + ']' + e.data.content + '[/label]' );
			}
		} );
	};

	this.badge = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.badge' ),
			body    : [ {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			} ],
			onsubmit: function( e ) {
				var type = 'type="' + e.data.type + '" ';
				editor.insertContent( '[badge ]' + e.data.content + '[/badge]' );
			}
		} );
	};

	this.grids = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.grid' ),
			body    : [ {
				type : 'textbox',
				name : 'columns',
				label: ed.getLang( 'odin.columns' )
			}, {
				type : 'textbox',
				name : 'rows',
				label: ed.getLang( 'odin.rows' )
			} ],
			onsubmit: function( e ) {
				var rows          = e.data.rows,
				    columns       = e.data.columns > 12 ? 12 : e.data.columns,
				    final_content = '';

				for( var r = 0; r < rows; r ++ ) {
					final_content += '[row] \n';
					for( var c = 0; c < columns; c ++ ) {
						final_content += '[col class="col-md-' + Math.floor( 12 / columns ) + '"] Column# ' + c + ' Row# ' + r + ' [/col]\n';
					}
					final_content += '[/row] \n';
				}

				final_content = final_content.replace( /\n/ig, "<br>" );
				editor.insertContent( final_content );
			}
		} );
	};

	this.icon = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.icon' ),
			minWidth: 200,
			body    : [ {
				type : 'textbox',
				name : 'icon',
				label: ed.getLang( 'odin.icon' ),
			} ],

			onsubmit: function( e ) {
				var icon = 'type="' + e.data.icon + '" ';
				editor.insertContent( '[icon ' + icon + ']' );
			}
		} );
	};

	this.well = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.well' ),
			body    : [ {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			} ],
			onsubmit: function( e ) {
				var type = 'type="' + e.data.type + '" ';
				editor.insertContent( '[well]' + e.data.content + '[/well]' );
			}
		} );
	};

	this.table = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.table' ),
			minWidth: 500,
			body    : [ {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.striped' ),
					value: 'striped'
				}, {
					text : ed.getLang( 'odin.hover' ),
					value: 'hover'
				}, {
					text : ed.getLang( 'odin.condensed' ),
					value: 'condensed'
				}, {
					text : ed.getLang( 'odin.responsive' ),
					value: 'responsive'
				} ]
			}, {
				type   : 'checkbox',
				name   : 'border',
				label  : ed.getLang( 'odin.border' ),
				checked: false
			}, {
				type : 'textbox',
				name : 'cols',
				id   : 'cols_table_input',
				label: ed.getLang( 'odin.cols' ),
			}, {
				type : 'textbox',
				name : 'rows',
				id   : 'rows_table_input',
				label: ed.getLang( 'odin.rows' ),
			} ],
			onsubmit: function( e ) {
				var type   = 'type="' + e.data.type + '" ',
				    border = true === e.data.border ? 'border=true" ' : '',
				    cols   = 'cols="' + e.data.cols + '" ',
				    rows   = 'rows="' + e.data.rows + '" ';

				editor.insertContent( '[table ' + type + border + cols + rows + ' ] ' );
			}
		} );

		jQuery( '#cols_table_input' ).attr( 'placeholder', 'Column 1, Column 2, ...' );
		jQuery( '#rows_table_input' ).attr( 'placeholder', 'Column 1 row 1, Column 2 row1 | Column 1 row 2' );
	};

	this.progress = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.progress' ),
			body    : [ {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.success' ),
					value: 'striped'
				}, {
					text : ed.getLang( 'odin.info' ),
					value: 'info'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning '
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger'
				} ]
			}, {
				type  : 'listbox',
				name  : 'class_css',
				label : ed.getLang( 'odin.class' ),
				values: [ {
					text : ed.getLang( 'odin.progress_striped' ),
					value: 'progress-striped'
				}, {
					text : ed.getLang( 'odin.active' ),
					value: 'active'
				} ]
			}, {
				type : 'slider',
				name : 'value',
				label: ed.getLang( 'odin.value_progress' ),
			}, {
				type : 'textbox',
				name : 'max',
				label: ed.getLang( 'odin.max' ),
				value: '100'
			}, {
				type : 'textbox',
				name : 'min',
				label: ed.getLang( 'odin.min' ),
				value: '0'
			} ],
			onsubmit: function( e ) {
				var type      = 'type="' + e.data.type + '" ',
				    class_css = 'class="' + e.data.class + '" ',
				    value     = 'value="' +((e.data.value * 0.01) * e.data.max - e.data.min) + '" ',
				    max       = 'max="' + e.data.max + '" ',
				    min       = 'min="' + e.data.min + '" ';

				editor.insertContent( '[progress ' + type + class_css + value + max + min + ' ] ' );
			}
		} );
	};

	this.panel = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.panel' ),
			body    : [ {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			}, {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.default' ),
					value: 'default'
				}, {
					text : ed.getLang( 'odin.info' ),
					value: 'info'
				}, {
					text : ed.getLang( 'odin.primary' ),
					value: 'primary'
				}, {
					text : ed.getLang( 'odin.success' ),
					value: 'success'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning'
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger'
				} ]
			} ],
			onsubmit: function( e ) {
				var type = 'type="' + e.data.type + '" ';

				editor.insertContent( '[panel '+ type +'][panel_body]' + e.data.content + '[/panel_body][/panel]' );
			}
		} );
	};

	this.tabs = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.tabs' ),
			body    : [ {
				type : 'textbox',
				name : 'tabs',
				id   : 'childs_tabs_input',
				label: ed.getLang( 'odin.childs' ),
			} ],
			onsubmit: function( e ) {
				var tabs          = e.data.tabs,
				    tabs_title    = '',
				    tabs_content  = '',
				    final_content = '';

				for( var i = 0; i < tabs; i ++ ) {
					tabs_title += ' [tab id="tab_id_' + i + '" ' +( 0 === i ? 'active = "true"' : "") + ' ]Title #' + i + ' [/tab] \n ';
					tabs_content += ' [tab_content id="tab_id_' + i + '" ' +( 0 === i ? 'active = "true"' : "") + ' ]' + 'content #' + i + '[/tab_content] \n';
				}

				//formating the output to break line
				final_content += '[tabs]\n' + tabs_title + '[/tabs]\n';
				final_content += '[tab_contents]\n' + tabs_content + '[/tab_contents]\n';
				final_content = final_content.replace( /\n/ig, '<br>' );

				editor.insertContent( final_content );

			}
		} );
		jQuery( '#childs_tabs_input' ).attr( 'placeholder', '3' );
	};

	this.accordion = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.accordion' ),
			body    : [ {
				type : 'textbox',
				name : 'accordions_id',
				label: ed.getLang( 'odin.accordions_id' ),
				value: 'odin-accordion'
			}, {
				type : 'textbox',
				name : 'childs',
				id   : 'childs_accordion_input',
				label: ed.getLang( 'odin.childs' ),
			}, {
				type  : 'listbox',
				name  : 'type',
				label : ed.getLang( 'odin.type' ),
				values: [ {
					text : ed.getLang( 'odin.default' ),
					value: 'default'
				}, {
					text : ed.getLang( 'odin.info' ),
					value: 'info'
				}, {
					text : ed.getLang( 'odin.primary' ),
					value: 'primary'
				}, {
					text : ed.getLang( 'odin.success' ),
					value: 'success'
				}, {
					text : ed.getLang( 'odin.warning' ),
					value: 'warning '
				}, {
					text : ed.getLang( 'odin.danger' ),
					value: 'danger '
				} ]
			} ],
			onsubmit: function( e ) {
				var type          = ' type="' + e.data.type + '" ',
				    accordions_id = ' id="' + e.data.accordions_id + '" ',
				    childs        = e.data.childs <= 0 ? 1 : e.data.childs,
				    accordions    = '',
				    final_content = '';

				for( var i = 0; i < childs; i ++ ) {
					accordions += '[accordion id=accordion#' + i + ' title="title#' + i + '" ' + ( 0 === i ? " active='true' " : " " ) + ' ]' + 'content #' + i + ' [/accordion] \n';
				}

				final_content += ' [accordions' + accordions_id + ' ] \n';
				final_content += accordions;
				final_content += '[/accordions] \n';
				final_content = final_content.replace( /\n/ig, '<br>' );
				editor.insertContent( final_content );
			}
		} );
		jQuery( '#childs_accordion_input' ).attr( 'placeholder', '3' );
	};

	this.tooltip = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.tooltip' ),
			body    : [ {
				type : 'textbox',
				name : 'title',
				label: ed.getLang( 'odin.title' )
			}, {
				type : 'textbox',
				name : 'content',
				label: ed.getLang( 'odin.content' )
			}, {
				type : 'textbox',
				name : 'link',
				id   : 'link_tooltip_input',
				label: ed.getLang( 'odin.link' )
			}, {
				type  : 'listbox',
				name  : 'direction',
				label : ed.getLang( 'odin.direction' ),
				values: [ {
					text : ed.getLang( 'odin.top' ),
					value: 'top'
				}, {
					text : ed.getLang( 'odin.right' ),
					value: 'right'
				}, {
					text : ed.getLang( 'odin.left' ),
					value: 'left'
				}, {
					text : ed.getLang( 'odin.bottom' ),
					value: 'success'
				} ]
			} ],
			onsubmit: function( e ) {
				var direction = 'direction="' + e.data.direction + '" ',
				    title     = 'title="' + e.data.title + '" ',
				    link      = 'link="' + e.data.link + '" ';

				editor.insertContent( ' [tooltip ' + title + direction + link + ']' + e.data.content + '[/tooltip]' );

			}
		} );

		jQuery( '#link_tooltip_input' ).attr( 'placeholder', 'http://www.site.com' );
	};

	this.clear = function() {
		editor.insertContent( '[clear]' );
	};

	this.qrcode = function() {
		editor.windowManager.open( {
			title   : ed.getLang( 'odin.qrcode' ),
			body    : [ {
				type : 'textbox',
				name : 'data',
				id   : 'data_qr_input',
				label: ed.getLang( 'odin.data' )
			}, {
				type : 'textbox',
				name : 'size',
				label: ed.getLang( 'odin.size' ),
				value: '150x150'
			}, {
				type : 'textbox',
				name : 'title',
				label: ed.getLang( 'odin.title' )
			} ],
			onsubmit: function( e ) {
				var data  = 'data="' + e.data.data + '" ',
				    size  = 'size="' + e.data.size + '" ',
				    title = 'title="' + e.data.title + '" ';

				editor.insertContent( ' [qrcode ' + data + size + title + ']' );
			}
		} );

		jQuery( '#data_qr_input' ).attr( 'placeholder', 'http://www.site.com' );
	};

	this.map = function() {
		editor.windowManager.open( {
			maxHeight: 500,
			minHeight: 300,
			maxWidth : 700,
			minWidth : 450,
			title    : ed.getLang( 'odin.map' ),
			id       : 'map-shortcode-panel',
			body     : [ {

				type : 'textbox',
				name : 'id',
				value: 'odin_gmap',
				label: ed.getLang( 'odin.id' )
			}, {
				type : 'textbox',
				name : 'latitude',
				id   : 'lat_map_input',
				label: ed.getLang( 'odin.latitude' )
			}, {
				type : 'textbox',
				name : 'longitude',
				id   : 'long_map_input',
				label: ed.getLang( 'odin.longitude' )
			}, {
				type : 'textbox',
				name : 'zoom',
				value: '10',
				label: ed.getLang( 'odin.zoom' )
			}, {
				type : 'textbox',
				name : 'width',
				value: '600',
				label: ed.getLang( 'odin.width' )
			}, {
				type : 'textbox',
				name : 'height',
				value: '400',
				label: ed.getLang( 'odin.height' )
			}, {
				type  : 'listbox',
				name  : 'maptype',
				label : ed.getLang( 'odin.maptype' ),
				values: [ {
					text : ed.getLang( 'odin.ROADMAP' ),
					value: 'ROADMAP'
				}, {
					text : ed.getLang( 'odin.SATELLITE' ),
					value: 'SATELLITE'
				}, {
					text : ed.getLang( 'odin.HYBRID' ),
					value: 'HYBRID'
				}, {
					text : ed.getLang( 'odin.TERRAIN' ),
					value: 'TERRAIN'
				} ]
			}, {
				type : 'textbox',
				name : 'address',
				label: ed.getLang( 'odin.address' )
			}, {
				type : 'textbox',
				name : 'kml',
				id   : 'kml_map_input',
				label: ed.getLang( 'odin.kml' )
			}, {
				type   : 'checkbox',
				name   : 'kmlautofit',
				label  : ed.getLang( 'odin.kmlautofit' ),
				checked: false
			}, {
				type   : 'checkbox',
				name   : 'marker',
				label  : ed.getLang( 'odin.marker' ),
				checked: false
			}, {
				type : 'textbox',
				name : 'markerimage',
				id   : 'markerimg_map_input',
				label: ed.getLang( 'odin.markerimage' )
			}, {
				type   : 'checkbox',
				name   : 'traffic',
				label  : ed.getLang( 'odin.traffic' ),
				checked: false
			}, {
				type   : 'checkbox',
				name   : 'bike',
				label  : ed.getLang( 'odin.bike' ),
				checked: false
			}, {
				type : 'textbox',
				name : 'fusion',
				label: ed.getLang( 'odin.fusion' ),

			}, {
				type : 'textbox',
				name : 'infowindow',
				label: ed.getLang( 'odin.infowindow' ),

			}, {
				type   : 'checkbox',
				name   : 'infowindowdefault',
				label  : ed.getLang( 'odin.infowindowdefault' ),
				checked: false
			}, {
				type   : 'checkbox',
				name   : 'hidecontrols',
				label  : ed.getLang( 'odin.hidecontrols' ),
				checked: false
			}, {
				type   : 'checkbox',
				name   : 'scale',
				label  : ed.getLang( 'odin.scale' ),
				checked: false
			}, {
				type   : 'checkbox',
				name   : 'scrollwheel',
				label  : ed.getLang( 'odin.scrollwheel' ),
				checked: true
			} ],
			onsubmit : function( e ) {
				var id                = ' id="' + e.data.id + '" ',
				    latitude          = '' === e.data.latitude ? '' : ' latitude="' + e.data.latitude + '" ',
				    longitude         = '' === e.data.longitude ? '' : ' longitude="' + e.data.longitude + '" ',
				    zoom              = ' zoom="' + e.data.zoom + '" ',
				    width             = ' width="' + e.data.width + '" ',
				    height            = ' height="' + e.data.height + '" ',
				    maptype           = ' maptype="' + e.data.maptype + '" ',
				    address           = ' address="' + e.data.address + '" ',
				    kml               = ' kml="' + e.data.kml + '" ',
				    kmlautofit        = ' kmlautofit="' + e.data.kmlautofit + '" ',
				    marker            = ' marker="' + e.data.marker + '" ',
				    markerimage       = ' markerimage="' + e.data.markerimage + '" ',
				    traffic           = ' traffic="' + e.data.traffic + '" ',
				    fusion            = ' fusion="' + e.data.fusion + '" ',
				    bike              = ' bike="' + e.data.bike + '" ',
				    infowindow        = ' infowindow="' + e.data.infowindow + '" ',
				    infowindowdefault = ' infowindowdefault="' + e.data.infowindowdefault + '" ',
				    hidecontrols      = ' hidecontrols="' + e.data.hidecontrols + '" ',
				    scale             = ' scale="' + e.data.scale + '" ',
				    scrollwheel       = ' scrollwheel="' + e.data.scrollwheel + '" ';

				editor.insertContent( ' [map' + id + latitude + longitude + zoom + width + height + maptype + address +
					kml + kmlautofit + marker + markerimage + traffic + fusion + bike + infowindow + infowindowdefault + scale + scrollwheel + ']' );
			}
		} );

		jQuery( '#lat_map_input' ).attr( 'placeholder', '-25.363882' );
		jQuery( '#long_map_input' ).attr( 'placeholder', '131.044922' );
		jQuery( '#markerimg_map_input' ).attr( 'placeholder', 'http://.../beachflag.png' );
		jQuery( '#kml_map_input' ).attr( 'placeholder', 'http://.../ggeoxml/cta.kml' );
	};
}

/**
 * Check is empty.
 *
 * @param  {string} value
 * @return {bool}
 */
this.isEmpty = function( value ) {
	value = value.toString();

	if ( 0 !== value.length ) {
		return false;
	}

	return true;
};
