<?php
/**
 * Odin_Front_End_Form class.
 *
 * Built Front-end Forms.
 *
 * @package  Odin
 * @category Front-end Form
 * @author   WPBrasil
 * @version  2.3.0
 */
abstract class Odin_Front_End_Form {

	/**
	 * Form fields.
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Form buttons.
	 *
	 * @var array
	 */
	protected $buttons = array();

	/**
	 * Form errors.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Form success.
	 *
	 * @var string
	 */
	protected $success = '';

	/**
	 * Form construct.
	 *
	 * @param string $id         Form id.
	 * @param string $action     Form action.
	 * @param string $method     Form method.
	 * @param array  $attributes Form attributes.
	 */
	public function __construct( $id, $action = '', $method = 'post', $attributes = array() ) {
		$this->id         = $id;
		$this->action     = $action;
		$this->method     = $method;
		$this->attributes = $attributes;
	}

	/**
	 * Set form fields.
	 *
	 * @param array $fields Form fields.
	 *
	 * @return void
	 */
	public function set_fields( $fields = array() ) {
		$this->fields = $fields;
	}

	/**
	 * Set form buttons.
	 *
	 * @param array $buttons Form buttons.
	 *
	 * @return void
	 */
	public function set_buttons( $buttons = array() ) {
		$this->buttons = $buttons;
	}

	/**
	 * Set errors.
	 *
	 * @param array $errors Form errors.
	 *
	 * @return void
	 */
	protected function set_errors( $errors = array() ) {
		$this->errors[] = $errors;
	}

	/**
	 * Set success message.
	 *
	 * @param string $success Form success message.
	 *
	 * @return void
	 */
	public function set_success_message( $success = '' ) {
		$this->success = $success;
	}

	/**
	 * Get submitted data.
	 *
	 * @return array Submitted data.
	 */
	public function get_submitted_data() {
		$data = $this->submitted_form_data();

		return $data;
	}

	/**
	 * Get submitted attachments.
	 *
	 * @return array Submitted attachments.
	 */
	public function get_attachments() {
		$attachments = $this->uploaded_files();

		return $attachments;
	}

	/**
	 * Get current page.
	 *
	 * @return string Currente Page URL.
	 */
	protected function get_current_page() {
		$url = 'http';
		if ( isset( $_SERVER['HTTPS'] ) && 'on' == $_SERVER['HTTPS'] ) {
			$url .= 's';
		}

		$url .= '://';

		if ( '80' != $_SERVER['SERVER_PORT'] ) {
			$url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
		} else {
			$url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		return $url;
	}

	/**
	 * Get field label via ID.
	 *
	 * @param  string $id Field ID.
	 *
	 * @return string     Field label.
	 */
	protected function get_field_label( $id ) {
		foreach ( $this->fields as $fieldset ) {
			foreach ( $fieldset['fields'] as $field ) {
				if ( $field['id'] == $id ) {
					return $field['label'];
				}
			}
		}

		return '';
	}

	/**
	 * Process form and fields attributes.
	 *
	 * @param  array  $attributes Attributes as array.
	 *
	 * @return string             Attributes as string.
	 */
	protected function process_attributes( $attributes = array() ) {
		$attrs = '';

		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $key => $attribute ) {
				$attrs .= ' ' . $key . '="' . $attribute . '"';
			}
		}

		return $attrs;
	}

	/**
	 * Sets the field default value.
	 *
	 * @return string Default value.
	 */
	protected function default_field( $id, $default ) {
		if ( 'get' == $this->method ) {
			return isset( $_GET[ $id ] ) ? sanitize_text_field( $_GET[ $id ] ) : $default;
		} else {
			return isset( $_POST[ $id ] ) ? sanitize_text_field( $_POST[ $id ] ) : $default;
		}
	}

	/**
	 * Process form fields.
	 *
	 * @return string Form fields HTML.
	 */
	protected function process_fields() {
		$html = '';

		if ( ! empty( $this->fields ) ) {
			foreach ( $this->fields as $key => $fieldset ) {
				$fieldset_attributes  = isset( $fieldset['attributes'] ) ? $fieldset['attributes'] : array();

				$html .= sprintf( '<fieldset id="odin-form-fieldset-%s" %s>', $key, $this->process_attributes( $fieldset_attributes ) );
				$html .= isset( $fieldset['legend'] ) ? '<legend>' . $fieldset['legend'] . '</legend>' : '';

				foreach ( $fieldset['fields'] as $field ) {
					$id          = $field['id'];
					$type        = $field['type'];
					$label       = isset( $field['label'] ) ? $field['label'] : '';
					$description = isset( $field['description'] ) ? $field['description'] : '';
					$attributes  = isset( $field['attributes'] ) ? $field['attributes'] : array();
					$options     = isset( $field['options'] ) ? $field['options'] : '';
					$required    = isset( $field['required'] ) && $field['required'] ? true : false;
					$default     = isset( $field['default'] ) ? $field['default'] : '';
					$default     = $this->default_field( $id, $default );

					if ( $required ) {
						$attributes = array_merge( array( 'required' => 'required' ), $attributes );
					}

					switch ( $type ) {
						case 'text':
							$html .= $this->field_input( $id, $label, $default, $description, $attributes );
							break;
						case 'hidden':
							$html .= $this->field_hidden( $id, $default, $attributes );
							break;
						case 'email':
							$html .= $this->field_input( $id, $label, $default, $description, array_merge( array( 'type' => 'email' ), $attributes ) );
							break;
						case 'file':
							$html .= $this->field_input( $id, $label, $default, $description, array_merge( array( 'type' => 'file', 'class' => 'form-file' ), $attributes ) );
							$this->attributes = array_merge( array( 'enctype' => 'multipart/form-data' ), $this->attributes );
							break;
						case 'input':
							$html .= $this->field_input( $id, $label, $default, $description, $attributes );
							break;
						case 'textarea':
							$html .= $this->field_textarea( $id, $label, $default, $description, $attributes );
							break;
						case 'checkbox':
							$html .= $this->field_checkbox( $id, $label, $default, $description, $attributes );
							break;
						case 'select':
							$html .= $this->field_select( $id, $label, $default, $description, $attributes, $options );
							break;
						case 'radio':
							$html .= $this->field_radio( $id, $label, $default, $description, $attributes, $options );
							break;

						default:
							$html .= do_action( 'odin_front_end_form_field_' . $this->id, $id, $label, $default, $description, $attributes, $options );
							break;
					}
				}

				$html .= '</fieldset>';
			}
		}

		return $html;
	}

	/**
	 * Process form buttons.
	 *
	 * @return string Form buttons HTML.
	 */
	protected function process_buttons() {
		$html = '<div class="btn-group">';

		if ( ! empty( $this->buttons ) ) {
			foreach ( $this->buttons as $button ) {
				$attributes = isset( $button['attributes'] ) ? $button['attributes'] : array( 'class' => 'btn btn-primary' );

				$html .= sprintf(
					'<button id="%s" type="%s"%s>%s</button>',
					$button['id'],
					$button['type'],
					$this->process_attributes( $attributes ),
					$button['label']
				);
			}
		} else {
			$html .= '<button type="submit" class="btn btn-primary">' . __( 'Submit', 'odin' ) . '</button>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Display error messages.
	 *
	 * @param string $html Form HTML.
	 *
	 * @return string      Error messages.
	 */
	public function display_error_messages( $html ) {
		if ( ! empty( $this->errors ) ) {

			$html .= '<div class="alert alert-danger">';

			foreach ( $this->errors as $error ) {
				$html .= '<p>' . $error . '</p>';
			}

			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Display success message.
	 *
	 * @return string      Success message.
	 */
	protected function display_success_message() {
		$html = '';

		if ( isset( $_GET['success'] ) && 1 == $_GET['success'] ) {
			$html .= '<div class="alert alert-success">';
			if ( ! empty( $this->success ) ) {
				$html .= '<p>' . $this->success . '</p>';
			} else {
				$html .= '<p>' . __( 'Form submitted successfully!', 'odin' ) . '</p>';
			}
			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Required field HTML.
	 *
	 * @param  array  $attributes Array with field attributes.
	 *
	 * @return string             Alert for required field.
	 */
	protected function required_field_alert( $attributes ) {
		if ( isset( $attributes['required'] ) ) {
			return ' <span class="text-danger">*</span>';
		}
	}

	/**
	 * Input field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $label       Field label.
	 * @param  string $default     Default value.
	 * @param  string $description Field description.
	 * @param  array  $attributes  Array with field attributes.
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_input( $id, $label, $default, $description, $attributes ) {
		// Set the default type.
		if ( ! isset( $attributes['type'] ) ) {
			$attributes['type'] = 'text';
		}

		// Set the default class.
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = 'form-control';
		}
		
		$html = sprintf( '<div class="form-group odin-form-group-%s">', $id );
		$html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
		$html .= sprintf( '<input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, $default, $this->process_attributes( $attributes ) );
		$html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Hidden field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $default     Default value.
	 * @param  array  $attributes  Array with field attributes.
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_hidden( $id, $default, $attributes ) {
		// Set the default type.
		if ( ! isset( $attributes['type'] ) ) {
			$attributes['type'] = 'hidden';
		}

		$html = sprintf( '<input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, $default, $this->process_attributes( $attributes ) );

		return $html;
	}

	/**
	 * Textarea field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $label       Field label.
	 * @param  string $default     Default value.
	 * @param  string $description Field description.
	 * @param  array  $attributes  Array with field attributes.
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_textarea( $id, $label, $default, $description, $attributes ) {
		// Set the default class.
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = 'form-control';
		}

		if ( ! isset( $attributes['cols'] ) ) {
			$attributes['cols'] = '60';
		}

		if ( ! isset( $attributes['rows'] ) ) {
			$attributes['rows'] = '4';
		}

		$html = sprintf( '<div class="form-group odin-form-group-%s">', $id );
		$html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
		$html .= sprintf( '<textarea id="%1$s" name="%1$s"%2$s>%3$s</textarea>', $id, $this->process_attributes( $attributes ), $default );
		$html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Checkbox field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $label       Field label.
	 * @param  string $default     Default value.
	 * @param  string $description Field description.
	 * @param  array  $attributes  Array with field attributes.
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_checkbox( $id, $label, $default, $description, $attributes ) {
		// Set the checked attribute
		if ( ! empty( $default ) ) {
			$attributes['checked'] = 'checked';
		}

		$html = sprintf( '<div class="checkbox odin-form-group-%s">', $id );
		$html .= '<label>';
		$html .= sprintf( '<input type="checkbox" id="%1$s" name="%1$s" value="1"%2$s />', $id, $this->process_attributes( $attributes ) );
		$html .= ' ' . $label . $this->required_field_alert( $attributes ) . '</label>';
		$html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Select field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $label       Field label.
	 * @param  string $default     Default value.
	 * @param  string $description Field description.
	 * @param  array  $attributes  Array with field attributes.
	 * @param  array  $options     Array with field options (value => name).
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_select( $id, $label, $default, $description, $attributes, $options ) {
		// Set the default class.
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = 'form-control';
		}

		// If multiple add a array in the option.
		$multiple = ( in_array( 'multiple', $attributes ) ) ? '[]' : '';

		$html = sprintf( '<div class="form-group odin-form-group-%s">', $id );
		$html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
		$html .= sprintf( '<select id="%1$s" name="%1$s%2$s"%3$s>', $id, $multiple, $this->process_attributes( $attributes ) );

		foreach ( $options as $value => $name ) {
			// Set the selected attribute.
			$selected = ( $value == $default ) ? ' selected="selected"' : '';

			$html .= sprintf( '<option value="%s"%s>%s</option>', $value, $selected, $name );
		}

		$html .= '</select>';
		$html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Radio field.
	 *
	 * @param  string $id          Field id.
	 * @param  string $label       Field label.
	 * @param  string $default     Default value.
	 * @param  string $description Field description.
	 * @param  array  $attributes  Array with field attributes.
	 * @param  array  $options     Array with field options (value => label).
	 *
	 * @return string              HTML of the field.
	 */
	protected function field_radio( $id, $label, $default, $description, $attributes, $options ) {
		$html = sprintf( '<div class="form-group odin-form-group-%s">', $id );
		$html .= '<label>' . $label . $this->required_field_alert( $attributes ) . '</label>';
		$html .= '<div class="form-radio-group">';

		foreach ( $options as $value => $label ) {
			// Set the checked attribute.
			if ( $value == $default ) {
				$attributes['checked'] = 'checked';
			} else if ( isset( $attributes['checked'] ) ) {
				unset( $attributes['checked'] );
			}

			$html .= '<div class="radio">';
			$html .= sprintf( '<label><input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s"%4$s /> %3$s</label>', $id, $value, $label, $this->process_attributes( $attributes ) );
			$html .= '</div>';
		}
		$html .= '</div>';

		$html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';

		$html .= '</div>';

		return $html;
	}

	/**
	 * Checks if the form data is valid.
	 *
	 * @return bool
	 */
	protected function is_valid() {
		$valid = empty( $this->errors ) ? true : false;

		return $valid;
	}

	/**
	 * Gests the form submitted data.
	 *
	 * @return array Form submitted data.
	 */
	protected function submitted_form_data() {
		// Checks the form method.
		if ( 'get' == $this->method ) {
			$data = $_GET;
		} else {
			$data = $_POST;
		}

		return $data;
	}

	/**
	 * Gests the form submitted files.
	 *
	 * @return array Form submitted files.
	 */
	protected function submitted_form_files() {
		$files = array();

		// Checks the form method.
		if ( 0 < count( $_FILES ) ) {
			$files = $_FILES;
		}

		return $files;
	}

	/**
	 * Validates the form data.
	 *
	 * @return void
	 */
	protected function validate_form_data() {
		$errors = array();

		// Sets the data.
		$data  = $this->submitted_form_data();
		$files = $this->submitted_form_files();

		if ( ! empty( $this->fields ) && ! empty( $data ) ) {
			foreach ( $this->fields as $fieldset ) {
				foreach ( $fieldset['fields'] as $field ) {
					$id       = $field['id'];
					$type     = $field['type'];
					$label    = isset( $field['label'] ) ? $field['label'] : '';
					$value    = ! empty( $data[ $id ] ) ? $data[ $id ] : '';
					$required = isset( $field['required'] ) && $field['required'] ? true : false;

					if ( $type != 'file' && $required && empty( $data[ $id ] ) ) {
						$this->set_errors( sprintf( __( '%s is required.', 'odin' ), '<strong>' . $label . '</strong>' ) );
					}

					switch ( $type ) {
						case 'email':
							if ( ! is_email( $value ) ) {
								$this->set_errors( sprintf( __( '%s must be an email address valid.', 'odin' ), '<strong>' . $label . '</strong>' ) );
							}
							break;
						case 'file':
							if ( $files ) {
								if ( $required && empty( $files[ $id ]['name'] ) ) {
									$this->set_errors( sprintf( __( '%s is required.', 'odin' ), '<strong>' . $label . '</strong>' ) );
								}
							}
							break;

						default:
							$custom_message = apply_filters( 'odin_front_end_form_valid_' . $this->id . '_' . $id, '', $label, $value );
							if ( $custom_message ) {
								$this->set_errors( $custom_message );
							}
							break;
					}
				}
			}
		}

		// Sets the errors.
		if ( ! empty( $this->errors ) ) {

			// Remove valid param.
			if ( isset( $_GET['success'] ) && 1 == $_GET['success'] ) {
				unset( $_GET['success'] );
			}
		}
	}

	/**
	 * Redirect to current page.
	 *
	 * @return void
	 */
	protected function redirect() {
		@ob_clean();

		$url = $this->get_current_page();
		$url = apply_filters( 'odin_front_end_form_redirect_' . $this->id, add_query_arg( 'success', '1', $url ) );

		wp_redirect( $url, 303 );

		exit;
	}

	/**
	 * Process the send form files.
	 *
	 * @return array
	 */
	protected function uploaded_files() {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachments = array();

		foreach ( $this->fields as $fieldset ) {
			foreach ( $fieldset['fields'] as $field ) {
				$id = $field['id'];
				if ( 'file' == $field['type'] && isset( $_FILES[ $id ] ) ) {
					$attachment_id = media_handle_upload( $id, 0 );

					if ( is_wp_error( $attachment_id ) ) {
						$error = apply_filters( 'odin_front_end_form_upload_error_' . $this->id, sprintf( '%s %s.', '<strong>' . $this->get_field_label( $id ) . '</strong>', $attachment_id->get_error_message() ) );
						$this->set_errors( $error );
					} else {
						$attachments[ $id ] = array(
							'file' => get_attached_file( $attachment_id ),
							'url'  => wp_get_attachment_url( $attachment_id )
						);
					}
				}
			}
		}

		return $attachments;
	}

	/**
	 * Form init.
	 * Hook this in the WordPress init action.
	 *
	 * @return void.
	 */
	public function init() {
		$submitted_data = $this->submitted_form_data();
		$uploaded_files = $this->get_attachments();

		if ( ! empty( $submitted_data ) && isset( $submitted_data['odin_form_action'] ) && $this->id == $submitted_data['odin_form_action'] ) {
			// Validates the form data.
			$this->validate_form_data();

			if ( $this->is_valid() ) {
				// Hook to process submitted form data.
				do_action( 'odin_front_end_form_submitted_data_' . $this->id, $submitted_data, $uploaded_files );

				// Redirect after submit.
				$this->redirect();
			} else {
				add_filter( 'odin_front_end_form_messages_' . $this->id, array( $this, 'display_error_messages' ) );
			}
		}
	}

	/**
	 * Render the form.
	 *
	 * @return string Form HTML.
	 */
	public function render() {

		$html = '';

		// Display error messages.
		$html .= apply_filters( 'odin_front_end_form_messages_' . $this->id, $html );

		// Display success message.
		$html .= $this->display_success_message();

		// Process the fields.
		$fields = $this->process_fields();

		// Generate the form.
		$html .= sprintf(
			'<form id="%s" action="%s" method="%s"%s>',
			$this->id,
			$this->action,
			$this->method,
			$this->process_attributes( array_merge( array( 'class' => 'form' ), $this->attributes ) )
		);

			$html .= do_action( 'odin_front_end_form_before_fields_' . $this->id );
			$html .= $fields;
			$html .= do_action( 'odin_front_end_form_after_fields_' . $this->id );
			$html .= $this->process_buttons();
			$html .= sprintf( '<input type="hidden" name="odin_form_action" value="%s" />', $this->id );
		$html .= '</form>';

		return $html;
	}

}
