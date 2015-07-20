<?php
/**
 * Odin_Metabox class.
 *
 * Built Metaboxs.
 *
 * @package  Odin
 * @category Metabox
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Metabox {

	/**
	 * Metaboxs fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Metaboxs construct.
	 *
	 * @param string       $id        HTML 'id' attribute of the edit screen section.
	 * @param string       $title     Title of the edit screen section, visible to user.
	 * @param string|array $post_type The type of Write screen on which to show the edit screen section.
	 * @param string       $context   The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
	 * @param string       $priority  The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
	 */
	public function __construct( $id, $title, $post_type = 'post', $context = 'normal', $priority = 'high' ) {
		$this->id        = $id;
		$this->title     = $title;
		$this->post_type = $post_type;
		$this->context   = $context;
		$this->priority  = $priority;
		$this->nonce     = $id . '_nonce';

		// Add Metabox.
		add_action( 'add_meta_boxes', array( $this, 'add' ) );

		// Save Metaboxs.
		add_action( 'save_post', array( $this, 'save' ) );

		// Load scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

		// Add post type columns
        add_filter( 'manage_edit-' . $post_type . '_columns', array($this, 'add_columns' ));
        // Set post type columns value
        add_action( 'manage_' . $post_type . '_posts_custom_column', array($this, 'set_columns_value'), 10,2);
	}

	/**
	 * Get the post typea.
	 *
	 * @return array
	 */
	protected function get_post_type() {
		return is_array( $this->post_type ) ? $this->post_type : array( $this->post_type );
	}

	/**
	 * Load metabox scripts.
	 */
	public function scripts() {
		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->get_post_type() ) ) {
			// Color Picker.
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			// Media Upload.
			wp_enqueue_media();

			// jQuery UI.
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Metabox.
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
	}

	/**
	 * Add the metabox in edit screens.
	 */
	public function add() {
		foreach ( $this->get_post_type() as $post_type ) {
			add_meta_box(
				$this->id,
				$this->title,
				array( $this, 'metabox' ),
				$post_type,
				$this->context,
				$this->priority
			);
		}
	}

	/**
	 * Set metabox fields.
	 *
	 * @param array $fields Metabox fields.
	 */
	public function set_fields( $fields = array() ) {
		$this->fields = $fields;
	}

    /**
	 * Get field type by field ID
	 *
	 * @param  string $field_id  Field ID
	 *
	 * @return string            Field type
	 */
    protected function get_field_type_by_id( $field_id ) {
        foreach ( $this->fields as $field ) {
            if ( $field['id'] == $field_id ) {
                return $field['type'];
            }
        }

        return '';
    }

    /**
	 * Check if index add_column is true
	 *
	 *
	 * @return bool Field type
	 */
    protected function check_field_is_column() {
        foreach ( $this->fields as $field ) {
            if ( isset( $field['add_column'] ) && $field['add_column'] ) {
                return true;
            }
        }

        return false;
    }

	/**
	 * Metabox view.
	 *
	 * @param  object $post Post object.
	 *
	 * @return string       Metabox HTML fields.
	 */
	public function metabox( $post ) {
		// Use nonce for verification.
		wp_nonce_field( basename( __FILE__ ), $this->nonce );

		$post_id = $post->ID;

		do_action( 'odin_metabox_header_' . $this->id, $post_id );

		echo apply_filters( 'odin_metabox_container_before_' . $this->id, '<table class="form-table odin-form-table">' );

		foreach ( $this->fields as $field ) {
			echo apply_filters( 'odin_metabox_wrap_before_' . $this->id, '<tr valign="top">', $field );

			if ( 'title' == $field['type'] ) {
				$title = sprintf( '<th colspan="2"><strong>%s</strong></th>', $field['label'] );
			} elseif ( 'separator' == $field['type'] ) {
				$title = sprintf( '<td colspan="2"><span id="odin-metabox-separator-%s" class="odin-metabox-separator"></span></td>', $field['id'] );
			} else {
				$title = sprintf( '<th><label for="%s">%s</label></th>', $field['id'], $field['label'] );
			}

			echo apply_filters( 'odin_metabox_field_title_' . $this->id, $title, $field );

			echo apply_filters( 'odin_metabox_field_before_' . $this->id, '<td>', $field );
			$this->process_fields( $field, $post_id );

			if ( isset( $field['description'] ) ) {
				echo sprintf( '<span class="description">%s</span>', $field['description'] );
			}


			echo apply_filters( 'odin_metabox_field_after_' . $this->id, '</td>', $field );

			echo apply_filters( 'odin_metabox_wrap_after_' . $this->id, '</tr>', $field );
		}

		echo apply_filters( 'odin_metabox_container_after_' . $this->id, '</table>' );

		do_action( 'odin_metabox_footer_' . $this->id, $post_id );

	}

	/**
	 * Process the metabox fields.
	 *
	 * @param  array $args    Field arguments
	 * @param  int   $post_id ID of the current post type.
	 *
	 * @return string          HTML of the field.
	 */
	protected function process_fields( $args, $post_id ) {
		$id      = $args['id'];
		$type    = $args['type'];
		$options = isset( $args['options'] ) ? $args['options'] : '';
		$attrs   = isset( $args['attributes'] ) ? $args['attributes'] : array();

		// Gets current value or default.
		$current = get_post_meta( $post_id, $id, true );
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
				do_action( 'odin_metabox_field_' . $this->id, $type, $id, $current, $options, $attrs );
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
	 * Add post columns
	 *
	 * @param  array $columns    Default WordPress Columns
	 *
	 * @return array             Columns
	 */
	public function add_columns( $columns ) {
        foreach ( $this->fields as $key => $field ) {
            if ( isset( $field['add_column'] ) && $field['add_column'] ) {
                $columns[ $field['id'] ] = $field['label'];
            }
        }

        return $columns;
    }

    /**
	 * Set value for each column
	 *
	 * @param  string $column    $column
	 * @param  int $column       $post_id
	 *
	 * @return string            Value
	 */
    public function set_columns_value( $column , $post_id ) {
    	$type      = $this->get_field_type_by_id( $column );
    	$is_column = $this->check_field_is_column();
    	if ( ! $is_column ) {
            return;
    	}

        switch ( $type ) {
            case 'image' :
            case 'image_plupload' :
                $value = wp_get_attachment_image( get_post_meta( $post_id, $column, true ) , array( 50, 50 ) );
                break;
            default :
                $value = apply_filters( 'admin_post_column_value_' . $this->post_type . '_' . $column, get_post_meta( $post_id, $column, true ) );
                break;
        }

        echo $value;
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

		echo sprintf( '<textarea id="%1$s" name="%1$s"%3$s>%2$s</textarea>', $id, esc_attr( $current ), $this->build_field_attributes( $attrs ) );
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
			$selected = $this->is_selected( $current, $key );
			$html .= sprintf( '<option value="%s"%s>%s</option>', $key, $selected, $label );
		}

		$html .= '</select>';

		echo $html;
	}

	/**
	 * Current value is selected.
	 *
	 * @param  array/string $current Field current value.
	 * @param  string       $key     Actual option value.
	 *
	 * @return boolean               $current is selected or not.
	 */
	protected function is_selected( $current, $key ) {
		$selected = false;
		if ( is_array( $current ) ) {
			for ( $i = 0; $i < count( $current ); $i++ ) {
				if ( selected( $current[ $i ], $key, false ) ) {
					$selected = selected( $current[ $i ], $key, false );
					break 1;
				}
			}
		} else {
			$selected = selected( $current, $key, false );
		}

		return $selected;
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
		echo sprintf( '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text"%4$s /> <input class="button odin-upload-button" type="button" value="%3$s" />', $id, esc_url( $current ), __( 'Select file', 'odin' ), $this->build_field_attributes( $attrs ) );
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
	 * Save metabox data.
	 *
	 * @param  int $post_id Current post type ID.
	 */
	public function save( $post_id ) {
		// Verify nonce.
		if ( ! isset( $_POST[ $this->nonce ] ) || ! wp_verify_nonce( $_POST[ $this->nonce ], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// Verify if this is an auto save routine.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check permissions.
		if ( isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $this->get_post_type() ) ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		foreach ( $this->fields as $field ) {
			$name  = $field['id'];
			$value = isset( $_POST[ $name ] ) ? $_POST[ $name ] : null;

			if ( ! in_array( $field['type'], array( 'separator', 'title' ) ) ) {
				$old = get_post_meta( $post_id, $name, true );

				$new = apply_filters( 'odin_save_metabox_' . $this->id, $value, $name );

				if ( $new && $new != $old ) {
					update_post_meta( $post_id, $name, $new );
				} elseif ( '' == $new && $old ) {
					delete_post_meta( $post_id, $name, $old );
				}
			}
		}

	}

}
