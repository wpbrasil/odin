<?php
/**
 * Odin_Front_End_Form class.
 *
 * Built Front-end Forms.
 *
 * @package  Odin
 * @category Front-end Form
 * @author   WPBrasil
 * @version  2.0.0
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
        $this->errors = $errors;
    }

    /**
     * Set success message.
     *
     * @param array $success Form success message.
     *
     * @return void
     */
    protected function set_success_message( $success = array() ) {
        $this->success = $success;
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
            foreach ( $attributes as $key => $attribute )
                $attrs .= ' ' . $key . '="' . $attribute . '"';
        }

        return $attrs;
    }

    /**
     * Sets the field default value.
     *
     * @return string Default value.
     */
    protected function default_field( $id, $default ) {
        if ( 'get' == $this->method )
            return isset( $_GET[ $id ] ) ? sanitize_text_field( $_GET[ $id ] ) : $default;
        else
            return isset( $_POST[ $id ] ) ? sanitize_text_field( $_POST[ $id ] ) : $default;
    }

    /**
     * Process form fields.
     *
     * @return string Form fields HTML.
     */
    protected function process_fields() {
        $html = '';

        if ( ! empty( $this->fields ) ) {
            foreach ( $this->fields as $fieldset ) {
                $fieldset_attributes  = isset( $fieldset['attributes'] ) ? $fieldset['attributes'] : array();

                $html .= sprintf( '<fieldset %s>', $this->process_attributes( $fieldset_attributes ) );
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

                    if ( $required )
                        $attributes = array_merge( array( 'required' => 'required' ), $attributes );

                    switch ( $type ) {
                        case 'text':
                            $html .= $this->field_input( $id, $label, $default, $description, $attributes );
                            break;
                        case 'email':
                            $html .= $this->field_input( $id, $label, $default, $description, array_merge( array( 'type' => 'email' ), $attributes ) );
                            break;
                        case 'file':
                            $html .= $this->field_input( $id, $label, $default, $description, array_merge( array( 'type' => 'file', 'class' => '' ), $attributes ) );
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
     * @return string Error messages.
     */
    protected function display_error_messages() {
        $html = '';

        if ( ! empty( $this->errors ) ) {
            $html .= '<div class="alert alert-danger">';

            foreach ( $this->errors as $error )
                $html .= '<p>' . $error . '</p>';

            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Display success message.
     *
     * @return string Error messages.
     */
    protected function display_success_message() {
        $html = '<div class="alert alert-success">';
        if ( ! empty( $this->success ) )
            $html .= '<p>' . $this->success . '</p>';
        else
            $html .= '<p>' . __( 'Form submitted successfully!', 'odin' ) . '</p>';
        $html .= '</div>';

        return $html;
    }

    protected function required_field_alert( $attributes ) {
        if ( isset( $attributes['required'] ) )
            return ' <span class="text-danger">*</span>';
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
        if ( ! isset( $attributes['type'] ) )
            $attributes['type'] = 'text';

        // Set the default class.
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
        $html .= sprintf( '<input id="%1$s" name="%1$s" value="%2$s"%3$s />', $id, $default, $this->process_attributes( $attributes ) );
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
        $html .= '</div>';

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
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
        $html .= sprintf( '<textarea id="%1$s" name="%1$s" cols="60" rows="4"%2$s>%3$s</textarea>', $id, $this->process_attributes( $attributes ), $default );
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
        if ( ! empty( $default ) )
            $attributes['checked'] = 'checked';

        $html = '<div class="checkbox">';
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
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s%s</label>', $id, $label, $this->required_field_alert( $attributes ) );
        $html .= sprintf( '<select id="%1$s" name="%1$s"%2$s>', $id, $this->process_attributes( $attributes ) );

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
        $html = '<div class="form-group">';
        $html .= '<label>' . $label . $this->required_field_alert( $attributes ) . '</label>';
        $html .= '<div class="form-radio-group">';

        foreach ( $options as $value => $label ) {
            // Set the checked attribute.
            if ( $value == $default )
                $attributes['checked'] = 'checked';
            else if ( isset( $attributes['checked'] ) )
                unset( $attributes['checked'] );

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
        if ( 'get' == $this->method )
            $data = $_GET;
        else
            $data = $_POST;

        return $data;
    }

    /**
     * Validates the form data.
     *
     * @return void
     */
    protected function validate_form_data() {
        $errors = array();

        // Sets the data.
        $data = $this->submitted_form_data();

        if ( ! empty( $this->fields ) && ! empty( $data ) ) {
            foreach ( $this->fields as $fieldset ) {
                foreach ( $fieldset['fields'] as $field ) {
                    $id       = $field['id'];
                    $type     = $field['type'];
                    $label    = isset( $field['label'] ) ? $field['label'] : '';
                    $required = isset( $field['required'] ) && $field['required'] ? true : false;

                    if ( $required && empty( $data[ $id ] ) )
                        $errors[] = sprintf( __( '%s is required.', 'odin' ), '<strong>' . $label . '</strong>' );
                }
            }
        }

        // Sets the errors.
        if ( ! empty( $errors ) )
            $this->set_errors( $errors );
    }

    /**
     * Render the form.
     *
     * @return string Form HTML.
     */
    public function render() {
        $html = sprintf(
            '<form id="%s" action="%s" method="%s"%s>',
            $this->id,
            $this->action,
            $this->method,
            $this->process_attributes( array_merge( array( 'class' => 'form' ), $this->attributes ) )
        );

            // Validates the form data.
            $this->validate_form_data();

            // Set messages.
            $submitted_data = $this->submitted_form_data();
            if ( ! empty( $submitted_data ) ) {
                if ( $this->is_valid() )
                    $html .= $this->display_success_message();
                else
                    $html .= $this->display_error_messages();
            }

            $html .= do_action( 'odin_front_end_form_before_fields_' . $this->id );
            $html .= $this->process_fields();
            $html .= do_action( 'odin_front_end_form_after_fields_' . $this->id );
            $html .= $this->process_buttons();

        $html .= '</form>';

        return $html;
    }

}
