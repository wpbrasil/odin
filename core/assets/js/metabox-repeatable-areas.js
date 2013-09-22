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

				$( 'a.button-add-repeater-area' ).on( 'click', this.add_new_repeatable_area );

			}, // init_events










			/*--------------------------------------------------------------------------------------
			 *
			 * @name: add_new_repeatable_area
			 * @description: Add new repeatable area
			 *
			 * @param {Object} e Event data
			 *-------------------------------------------------------------------------------------*/
			add_new_repeatable_area : function( e ) {

				var $this = $( this ),
					$repeatable_container = $this.closest( 'div.odin-repeater-container' ),
					$repeatable_area = $repeatable_container.find( 'div.odin-repeater-area' ).eq(0),
					$clone = $repeatable_area.clone();

				console.log( $clone );
				$this.before( $clone );

			} // add_new_repeatable_area

		}; // return
	})(); // repeatable_areas


	// DOM Loaded
	$(function() {
		repeatable_areas.init();
	});

})( window, document, jQuery );