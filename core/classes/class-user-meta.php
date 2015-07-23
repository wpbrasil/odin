<?php
/**
 * Odin_User_Meta class.
 *
 * Built user meta fields.
 *
 * @package  Odin
 * @category User Meta
 * @author   WPBrasil
 * @version  2.2.5
 */
class Odin_User_Meta {

	/**
	 * User meta fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * User meta construct.
	 *
	 * @param string $id    Options ID.
	 * @param string $title Options title.
	 */
	public function __construct( $id, $title ) {
		$this->id    = $id;
		$this->title = $title;
		$this->nonce = $this->id . '_nonce';

		// View Additional User Fields.
		add_action( 'show_user_profile', array( $this, 'view' ) );
		add_action( 'edit_user_profile', array( $this, 'view' ) );

		// Update Additional User Fields.
		add_action( 'personal_options_update', array( $this, 'save' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save' ) );

		// Load scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Load user meta scripts.
	 *
	 * @return void
	 */
	public function scripts() {

		// Color Picker.
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		// Media Upload.
		wp_enqueue_media();

		// jQuery UI.
		wp_enqueue_script( 'jquery-ui-sortable' );

		// user_meta.
		wp_enqueue_script( 'odin-admin', get_template_directory_uri() . '/core/assets/js/admin.js', array( 'jquery' ), null, true );
		wp_enqueue_style( 'odin-admin', get_template_directory_uri() . '/core/assets/css/admin.css', array(), null, 'all' );

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

	/**
	 * Set user meta fields.
	 *
	 * @param array $fields User meta fields.
	 *
	 * @return void
	 */
	public function set_fields( $fields = array() ) {
		$this->fields = $fields;
	}

	/**
	 * User meta view.
	 *
	 * @param  object $post Post object.
	 *
	 * @return string       User meta HTML fields.
	 */
	public function view() {
		// Use nonce for verification.
		wp_nonce_field( basename( __FILE__ ), $this->nonce );

		echo '<h3>' . $this->title . '</h3>';

		echo '<table class="form-table">';

		foreach ( $this->fields as $field ) {

			echo '<tr>';

			$title = sprintf( '<th><label for="%s">%s</label></th>', $field['id'], $field['label'] );

			echo $title;

			echo apply_filters( 'odin_user_meta_field_before_' . $this->id, '<td>', $field );
			$this->process_fields( $field );

			if ( isset( $field['description'] ) ) {
				echo sprintf( '<span class="description">%s</span>', $field['description'] );
			}

			echo apply_filters( 'odin_user_meta_field_after_' . $this->id, '</td>', $field );

			echo '</tr>';

		}

		echo '</table>';

	}

	/**
	 * Process the user meta fields.
	 *
	 * @param  array $args    Field arguments
	 * @param  int   $user_id ID of the current post type.
	 *
	 * @return string          HTML of the field.
	 */
	protected function process_fields( $args ) {
		$id      = $args['id'];
		$type    = $args['type'];
		$options = isset( $args['options'] ) ? $args['options'] : '';
		$attrs   = isset( $args['attributes'] ) ? $args['attributes'] : array();

		// Gets current value or default.
		if ( defined( 'IS_PROFILE_PAGE' ) && IS_PROFILE_PAGE ) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
		// If is another user's profile page
		} elseif ( ! empty( $_GET['user_id'] ) && is_numeric( $_GET['user_id'] ) ) {
			$user_id = $_GET['user_id'];
		}

		$current = get_user_meta( $user_id, $id, true );

		if ( ! $current ) {
			$current = isset( $args['default'] ) ? $args['default'] : '';
		}

		switch ( $type ) {
			case 'text':
				$this->field_input( $id, $current, array_merge( array( 'class' => 'regular-text' ), $attrs ) );
				break;
			case 'input':
				$this->field_input( $id, $current, $attrs );
				break;
			case 'textarea':
				$this->field_textarea( $id, $current, $attrs );
				break;
			case 'checkbox':
				$this->field_checkbox( $id, $current, $attrs );
				break;
			case 'select':
				$this->field_select( $id, $current, $options, $attrs );
				break;
			case 'radio':
				$this->field_radio( $id, $current, $options, $attrs );
				break;
			case 'editor':
				$this->field_editor( $id, $current, $options );
				break;
			case 'color':
				$this->field_input( $id, $current, array_merge( array( 'class' => 'odin-color-field' ), $attrs ) );
				break;
			case 'upload':
				$this->field_upload( $id, $current, $attrs );
				break;
			case 'image':
				$this->field_image( $id, $current );
				break;
			case 'image_plupload':
				$this->field_image_plupload( $id, $current );
				break;

			default:
				do_action( 'odin_user_meta_field_' . $this->id, $type, $id, $current, $options, $attrs );
				break;
		}
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
	 * Input field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_input( $id, $current, $attrs ) {
		if ( ! isset( $attrs['type'] ) ) {
			$attrs['type'] = 'text';
		}

		echo sprintf( '<input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, esc_attr( $current ), $this->build_field_attributes( $attrs ) );
	}

	/**
	 * Textarea field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_textarea( $id, $current, $attrs ) {
		if ( ! isset( $attrs['cols'] ) ) {
			$attrs['cols'] = '60';
		}

		if ( ! isset( $attrs['rows'] ) ) {
			$attrs['rows'] = '5';
		}

		echo sprintf( '<textarea id="%1$s" name="%1$s"%3$s>%2$s</textarea><br />', $id, esc_attr( $current ), $this->build_field_attributes( $attrs ) );
	}

	/**
	 * Checkbox field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_checkbox( $id, $current, $attrs ) {
		echo sprintf( '<input type="checkbox" id="%1$s" name="%1$s" value="1"%2$s%3$s />', $id, checked( 1, $current, false ), $this->build_field_attributes( $attrs ) );
	}

	/**
	 * Select field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $options Array with select options.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_select( $id, $current, $options, $attrs ) {
		// If multiple add a array in the option.
		$multiple = ( in_array( 'multiple', $attrs ) ) ? '[]' : '';

		$html = sprintf( '<select id="%1$s" name="%1$s%2$s"%3$s>', $id, $multiple, $this->build_field_attributes( $attrs ) );

		foreach ( $options as $key => $label ) {
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
		}

		$html .= '</select>';

		echo $html;
	}

	/**
	 * Radio field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $options Array with input options.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_radio( $id, $current, $options, $attrs ) {
		$html = '';

		foreach ( $options as $key => $label ) {
			$html .= sprintf( '<input type="radio" id="%1$s_%2$s" name="%1$s" value="%2$s"%3$s%5$s /><label for="%1$s_%2$s"> %4$s</label><br />', $id, $key, checked( $current, $key, false ), $label, $this->build_field_attributes( $attrs ) );
		}

		echo $html;
	}

	/**
	 * Editor field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $options Array with wp_editor options.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_editor( $id, $current, $options ) {
		// Set default options.
		if ( empty( $options ) ) {
			$options = array( 'textarea_rows' => 10 );
		}

		$options[ 'textarea_name' ] = $id;

		echo '<div style="max-width: 600px;">';
			wp_editor( wpautop( $current ), $id, $options );
		echo '</div>';
	}

	/**
	 * Upload field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 * @param  array  $attrs   Array with field attributes.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_upload( $id, $current, $attrs ) {
		echo sprintf( '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text"%4$s /> <input class="button odin-upload-button" type="button" value="%3$s" /><br />', $id, esc_url( $current ), __( 'Select file', 'odin' ), $this->build_field_attributes( $attrs ) );
	}

	/**
	 * Image field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_image( $id, $current ) {

		// Gets placeholder image.
		$image = get_template_directory_uri() . '/core/assets/images/placeholder.png';
		$html  = '<div class="odin-upload-image">';
		$html  .= '<span class="default-image">' . $image . '</span>';

		if ( $current ) {
			$image = wp_get_attachment_image_src( $current, 'thumbnail' );
			$image = $image[0];
		}

		$html .= sprintf( '<input id="%1$s" name="%1$s" type="hidden" class="image" value="%2$s" /><img src="%3$s" class="preview" style="height: 150px; width: 150px;" alt="" /><input id="%1$s-button" class="button" type="button" value="%4$s" /><ul class="actions"><li><a href="#" class="delete" title="%5$s"><span class="dashicons dashicons-no"></span></a></li></ul>', $id, $current, $image, __( 'Select image', 'odin' ), __( 'Remove image', 'odin' ) );

		$html .= '<br class="clear" />';
		$html .= '</div>';

		echo $html;
	}

	/**
	 * Image plupload field.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 *
	 * @return string          HTML of the field.
	 */
	protected function field_image_plupload( $id, $current ) {
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
			$html .= sprintf( '<input type="hidden" class="odin-gallery-field" name="%s" value="%s" />', $id, $current );

			// Adds "adds images in gallery" url.
			$html .= sprintf( '<p class="odin-gallery-add hide-if-no-js"><a href="#">%s</a></p>', __( 'Add images in gallery', 'odin' ) );
		$html .= '</div>';

		echo $html;
	}

	/**
	 * Save user meta data.
	 *
	 * @param  string $id      Field id.
	 * @param  string $current Field current value.
	 *
	 * @return void
	 */
	public function save( $user_id ) {
		// Verify nonce.
		if ( ! isset( $_POST[ $this->nonce ] ) || ! wp_verify_nonce( $_POST[ $this->nonce ], basename( __FILE__ ) ) ) {
			return '';
		}

		// Only saves if the current user can edit user profiles.
		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return '';
		}

		foreach ( $this->fields as $field ) {
			$name = $field['id'];
			$old  = get_user_meta( $user_id, $name, true );
			$new  = apply_filters( 'odin_save_user_meta_' . $this->id, $_POST[ $name ], $name );

			if ( $new && $new != $old ) {
				update_user_meta( $user_id, $name, $new );
			} elseif ( '' == $new && $old ) {
				delete_user_meta( $user_id, $name, $old );
			}
		}
	}
}
