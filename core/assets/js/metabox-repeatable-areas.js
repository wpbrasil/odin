/* global odin_admin_params, wp */

/**
 * Repeatable Areas
 */
;(function( window, document, $, undefined ) {

	var repeatable_areas = (function() {
		return {

			/*--------------------------------------------------------------------------------------
			 *
			 * @name: init
			 * @description: Prepare Environment
			 *
			 *-------------------------------------------------------------------------------------*/
			init : function() {

				// Init Vars
				this.init_vars();

				// Events
				this.init_events();

			},










			/*--------------------------------------------------------------------------------------
			 *
			 * @name: init_vars
			 * @description: Start variables declaration
			 *
			 *-------------------------------------------------------------------------------------*/
			init_vars : function() {



			}, // init_vars










			/*--------------------------------------------------------------------------------------
			 *
			 * @name: init_events
			 * @description: Events
			 *
			 *-------------------------------------------------------------------------------------*/
			init_events : function() {

				$( 'a.add-new-repeatable-area' ).on( 'click', this.add_new_repeatable_area );

			}, // init_events










			/*--------------------------------------------------------------------------------------
			 *
			 * @name: add_new_repeatable_area
			 * @description: Add new repeatable area
			 *
			 * @param {Object} e Event data
			 *-------------------------------------------------------------------------------------*/
			add_new_repeatable_area : function( e ) {

				var $this = $( this );

			} // add_new_repeatable_area

		}; // return
	})(); // repeatable_areas


	// DOM Loaded
	$(function() {
		repeatable_areas.init();
	});

})( window, document, jQuery );