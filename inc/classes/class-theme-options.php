<?php
/**
 * Odin_Theme_Options class.
 *
 * Built settings page.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Theme_Options {

	/**
	 * Settings tabs.
	 *
	 * @var array
	 */
	protected $tabs = array();

	/**
	 * Settings fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Settings construct.
	 *
	 * @param string $id         Page id.
	 * @param string $title      Page title.
	 * @param string $capability User capability.
	 */
	public function __construct( $id, $title, $capability = 'manage_options' ) {
		$this->id         = $id;
		$this->title      = $title;
		$this->capability = $capability;

		// Actions.
		add_action( 'admin_menu', array( &$this, 'add_page' ) );
		add_action( 'admin_init', array( &$this, 'create_settings' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'scripts' ) );
	}

	/**
	 * Add Settings Theme page.
	 */
	public function add_page() {
		add_theme_page(
			$this->title,
			$this->title,
			$this->capability,
			$this->id,
			array( &$this, 'settings_page' )
		);
	}

	/**
	 * Load options scripts.
	 */
	function scripts() {
		// Checks if is the settings page.
		if ( isset( $_GET['page'] ) && $this->id == $_GET['page'] ) {

			// Color Picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// Media Upload.
			wp_enqueue_media();

			// jQuery UI.
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Theme Options.
			wp_enqueue_style( 'odin-admin', get_template_directory_uri() . '/core/assets/css/admin.css', array(), null, 'all' );
			wp_enqueue_script( 'odin-admin', get_template_directory_uri() . '/core/assets/js/admin.js', array( 'jquery' ), null, true );

			// Localize strings.
			wp_localize_script(
				'odin-admin',
				'odinAdminParams',
				array(
					'galleryTitle'  => __( 'Add images in gallery', 'odin' ),
					'galleryButton' => __( 'Add in gallery', 'odin' ),
					'galleryRemove' => __( 'Remove image', 'odin' ),
					'uploadTitle'   => __( 'Choose a file', 'odin' ),
					'uploadButton'  => __( 'Add file', 'odin' ),
				)
			);
		}
	}

	/**
	 * Set settings tabs.
	 *
	 * @param array $tabs Settings tabs.
	 */
	public function set_tabs( $tabs ) {
		$this->tabs = $tabs;
	}

	/**
	 * Set settings fields
	 *
	 * @param array $fields Settings fields.
	 */
	public function set_fields( $fields ) {
		$this->fields = $fields;
	}

	/**
	 * Get current tab.
	 *
	 * @return string Current tab ID.
	 */
	protected function get_current_tab() {
		if ( isset( $_GET['tab'] ) ) {
			$current_tab = $_GET['tab'];
		} else {
			$current_tab = $this->tabs[0]['id'];
		}

		return $current_tab;
	}

	/**
	 * Get the menu current URL.
	 *
	 * @return string Current URL.
	 */
	private function get_current_url() {
		$url = 'http';
		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
			$url .= 's';
		}

		$url .= '://';

		if ( '80' != $_SERVER['SERVER_PORT'] ) {
			$url .= $_SERVER['SERVER_NAME'] . ' : ' . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];
		} else {
			$url .= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
		}

		return esc_url( $url );
	}

	/**
	 * Get tab navigation.
	 *
	 * @param  string $current_tab Current tab ID.
	 *
	 * @return string              Tab Navigation.
	 */
	protected function get_navigation( $current_tab ) {

		$html = '<h2 class="nav-tab-wrapper">';

		foreach ( $this->tabs as $tab ) {

			$current = ( $current_tab == $tab['id'] ) ? ' nav-tab-active' : '';

			$html .= sprintf( '<a href="?page=%s&amp;tab=%s" class="nav-tab%s">%s</a>', $this->id, $tab['id'], $current, $tab['title'] );
		}

		$html .= '</h2>';

		echo $html;
	}

	/**
	 * Built settings page.
	 */
	public function settings_page() {
		// Get current tag.
		$current_tab = $this->get_current_tab();

		// Opens the wrap.
		echo '<div class="wrap">';

			// Display the navigation menu.
			$this->get_navigation( $current_tab );

			// Display erros.
			settings_errors();

			// Creates the option form.
			echo '<form method="post" action="options.php">';
				foreach ( $this->tabs as $tabs ) {
					if ( $current_tab == $tabs['id'] ) {

						// Prints nonce, action and options_page fields.
						settings_fields( $tabs['id'] );

						// Prints settings sections and settings fields.
						do_settings_sections( $tabs['id'] );

						break;
					}
				}

				// Display submit button.
				submit_button();

			// Closes the form.
			echo '</form>';

		// Closes the wrap.
		echo '</div>';
	}

	/**
	 * Create settings.
	 */
	public function create_settings() {

		// Register settings fields.
		foreach ( $this->fields as $section => $items ) {

			// Register settings sections.
			add_settings_section(
				$section,
				$items['title'],
				'__return_false',
				$items['tab']
			);

			foreach ( $items['fields'] as $option ) {

				$type = isset( $option['type'] ) ? $option['type'] : 'text';

				$args = array(
					'id'          => $option['id'],
					'tab'         => $items['tab'],
					'section'     => $section,
					'options'     => isset( $option['options'] ) ? $option['options'] : '',
					'default'     => isset( $option['default'] ) ? $option['default'] : '',
					'attributes'  => isset( $option['attributes'] ) ? $option['attributes'] : array(),
					'description' => isset( $option['description'] ) ? $option['description'] : ''
				);

				add_settings_field(
					$option['id'],
					$option['label'],
					array( &$this, 'callback_' . $type ),
					$items['tab'],
					$section,
					$args
				);
			}
		}

		// Register settings.
		foreach ( $this->tabs as $tabs ) {
			register_setting( $tabs['id'], $tabs['id'], array( &$this, 'validate_input' ) );
		}
	}

	/**
	 * Get Option.
	 *
	 * @param  string $tab     Tab that the option belongs
	 * @param  string $id      Option ID.
	 * @param  string $default Default option.
	 *
	 * @return array           Item options.
	 */
	protected function get_option( $tab, $id, $default = '' ) {
		$options = get_option( $tab );

		if ( isset( $options[ $id ] ) ) {
			$default = $options[ $id ];
		}

		return $default;

	}

	/**
	 * Build field attributes.
	 *
	 * @param  array $attrs Attributes as array.
	 *
	 * @return string       Attributes as string.
	 */
	protected function build_field_attributes( $attrs ) {
		$attributes = '';

		if ( ! empty( $attrs ) ) {
			foreach ( $attrs as $key => $attr ) {
				$attributes .= ' ' . $key . '="' . $attr . '"';
			}
		}

		return $attributes;
	}

	/**
	 * Input field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Input field HTML.
	 */
	public function callback_input( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets default type.
		if ( ! isset( $attrs['type'] ) ) {
			$attrs['type'] = 'text';
		}

		// Sets current option.
		$current = esc_html( $this->get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<input id="%1$s" name="%2$s[%1$s]" value="%3$s"%4$s />', $id, $tab, $current, $this->build_field_attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Text field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Text field HTML.
	 */
	public function callback_text( $args ) {
		// Sets regular text class.
		$args['attributes']['class'] = 'regular-text';

		$this->callback_input( $args );
	}

	/**
	 * Textarea field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Textarea field HTML.
	 */
	public function callback_textarea( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		if ( ! isset( $attrs['cols'] ) ) {
			$attrs['cols'] = '60';
		}

		if ( ! isset( $attrs['rows'] ) ) {
			$attrs['rows'] = '5';
		}

		// Sets current option.
		$current = esc_textarea( $this->get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<textarea id="%1$s" name="%2$s[%1$s]"%4$s>%3$s</textarea>', $id, $tab, $current, $this->build_field_attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Editor field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Editor field HTML.
	 */
	public function callback_editor( $args ) {
		$tab     = $args['tab'];
		$id      = $args['id'];
		$options = $args['options'];

		// Sets current option.
		$current = wpautop( $this->get_option( $tab, $id, $args['default'] ) );

		// Set default options.
		if ( empty( $options ) ) {
			$options = array( 'textarea_rows' => 10 );
		}

		$options[ 'textarea_name' ] = $tab . '[' . $id . ']';

		echo '<div style="width: 600px;">';

			wp_editor( $current, $id, $options );

		echo '</div>';

		// Displays the description.
		if ( $args['description'] ) {
			echo sprintf( '<p class="description">%s</p>', $args['description'] );
		}
	}

	/**
	 * Checkbox field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Checkbox field HTML.
	 */
	public function callback_checkbox( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = $this->get_option( $tab, $id, $args['default'] );

		$html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s%4$s />', $id, $tab, checked( 1, $current, false ), $this->build_field_attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<label for="%s"> %s</label>', $id, $args['description'] );
		}

		echo $html;
	}

	/**
	 * Radio field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Radio field HTML.
	 */
	public function callback_radio( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = $this->get_option( $tab, $id, $args['default'] );

		$html = '';
		foreach( $args['options'] as $key => $label ) {
			$item_id = $id . '_' . $key;
			$key = sanitize_title( $key );

			$html .= sprintf( '<input type="radio" id="%1$s_%3$s" name="%2$s[%1$s]" value="%3$s"%4$s%5$s />', $id, $tab, $key, checked( $current, $key, false ), $this->build_field_attributes( $attrs ) );
			$html .= sprintf( '<label for="%s"> %s</label><br />', $item_id, $label );
		}

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Select field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Select field HTML.
	 */
	public function callback_select( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = $this->get_option( $tab, $id, $args['default'] );

		// If multiple add a array in the option.
		$multiple = ( in_array( 'multiple', $attrs ) ) ? '[]' : '';

		$html = sprintf( '<select id="%1$s" name="%2$s[%1$s]%3$s"%4$s>', $id, $tab, $multiple, $this->build_field_attributes( $attrs ) );
		foreach( $args['options'] as $key => $label ) {
			$key = sanitize_title( $key );

			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
		}
		$html .= '</select>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Color field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Color field HTML.
	 */
	public function callback_color( $args ) {
		// Sets color class.
		$args['attributes']['class'] = 'odin-color-field';

		$this->callback_input( $args );
	}

	/**
	 * Upload field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Upload field HTML.
	 */
	public function callback_upload( $args ) {
		$tab   = $args['tab'];
		$id    = $args['id'];
		$attrs = $args['attributes'];

		// Sets current option.
		$current = esc_url( $this->get_option( $tab, $id, $args['default'] ) );

		$html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text"%5$s /> <input class="button odin-upload-button" id="%1$s-button" type="button" value="%4$s" />', $id, $tab, $current, __( 'Select file', 'odin' ), $this->build_field_attributes( $attrs ) );

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Image field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Image field HTML.
	 */
	public function callback_image( $args ) {
		$tab = $args['tab'];
		$id  = $args['id'];

		// Sets current option.
		$current = $this->get_option( $tab, $id, $args['default'] );

		// Gets placeholder image.
		$image = get_template_directory_uri() . '/core/assets/images/placeholder.png';
		$html  = '<div class="odin-upload-image">';
		$html  .= '<span class="default-image">' . $image . '</span>';

		if ( ! empty( $current ) ) {
			$image = wp_get_attachment_image_src( $current, 'thumbnail' );
			$image = $image[0];
		}

		$html .= sprintf( '<input id="%1$s" name="%2$s[%1$s]" type="hidden" class="image" value="%3$s" /><img src="%4$s" class="preview" style="height: 150px; width: 150px;" alt="" /><input id="%1$s-button" class="button" type="button" value="%5$s" /><ul class="actions"><li><a href="#" class="delete" title="%6$s"><span class="dashicons dashicons-no"></span></a></li></ul>', $id, $tab, $current, $image, __( 'Select image', 'odin' ), __( 'Remove image', 'odin' ) );

		$html .= '<br class="clear" />';
		$html .= '</div>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * Image Plupload field callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string Image Plupload field HTML.
	 */
	public function callback_image_plupload( $args ) {
		$tab = $args['tab'];
		$id  = $args['id'];

		// Sets current option.
		$current = $this->get_option( $tab, $id, $args['default'] );

		$html = '<div class="odin-gallery-container">';
			$html .= '<ul class="odin-gallery-images">';
				if ( ! empty( $current ) ) {
					// Gets the current images.
					$attachments = array_filter( explode( ',', $current ) );

					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							$html .= sprintf( '<li class="image" data-attachment_id="%1$s">%2$s<ul class="actions"><li><a href="#" class="delete" title="%3$s"><span class="dashicons dashicons-no"></span></a></li></ul></li>',
								$attachment_id,
								wp_get_attachment_image( $attachment_id, 'thumbnail' ),
								__( 'Remove image', 'odin' )
							);
						}
					}
				}
			$html .= '</ul><div class="clear"></div>';

			// Adds the hidden input.
			$html .= sprintf( '<input type="hidden" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="odin-gallery-field" />', $id, $tab, $current );

			// Adds "adds images in gallery" url.
			$html .= sprintf( '<p class="odin-gallery-add hide-if-no-js"><a href="#">%s</a></p>', __( 'Add images in gallery', 'odin' ) );
		$html .= '</div>';

		// Displays the description.
		if ( $args['description'] ) {
			$html .= sprintf( '<p class="description">%s</p>', $args['description'] );
		}

		echo $html;
	}

	/**
	 * HTML callback.
	 *
	 * @param array $args Arguments from the option.
	 *
	 * @return string HTML.
	 */
	public function callback_html( $args ) {
		echo $args['description'];
	}

	/**
	 * Sanitization fields callback.
	 *
	 * @param  string $input The unsanitized collection of options.
	 *
	 * @return string        The collection of sanitized values.
	 */
	public function validate_input( $input ) {

		// Create our array for storing the validated options.
		$output = array();

		// Loop through each of the incoming options.
		foreach ( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = apply_filters( 'odin_theme_options_validate_' . $this->id, $value, $key );
			}

		}

		return $output;
	}
}
