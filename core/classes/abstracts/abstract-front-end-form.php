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
     * @param array $fields form fields.
     *
     * @return void
     */
    public function set_fields( $fields = array() ) {
        $this->fields = $fields;
    }

    /**
     * Set form buttons.
     *
     * @param array $buttons form buttons.
     *
     * @return void
     */
    public function set_buttons( $buttons = array() ) {
        $this->buttons = $buttons;
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

                    switch ( $type ) {
                        case 'text':
                            $html .= $this->field_input( $id, $label, $description, $attributes );
                            break;
                        case 'email':
                            $html .= $this->field_input( $id, $label, $description, array_merge( array( 'type' => 'email' ), $attributes ) );
                            break;
                        case 'file':
                            $html .= $this->field_input( $id, $label, $description, array_merge( array( 'type' => 'file', 'class' => '' ), $attributes ) );
                            break;
                        case 'input':
                            $html .= $this->field_input( $id, $label, $description, $attributes );
                            break;
                        case 'textarea':
                            $html .= $this->field_textarea( $id, $label, $description, $attributes );
                            break;
                        case 'checkbox':
                            $html .= $this->field_checkbox( $id, $label, $description, $attributes );
                            break;
                        case 'select':
                            $html .= $this->field_select( $id, $label, $description, $attributes, $options );
                            break;
                        case 'radio':
                            $html .= $this->field_radio( $id, $description, $attributes, $options );
                            break;

                        default:

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
        $html = '';

        if ( ! empty( $this->buttons ) ) {
            foreach ( $this->buttons as $button ) {
                $attributes = isset( $button['attributes'] ) ? $button['attributes'] : array( 'class' => 'btn btn-primary' );

                $html .= sprintf(
                    '<button id="%s" type="%s"%s>%s</button> ',
                    $button['id'],
                    $button['type'],
                    $this->process_attributes( $attributes ),
                    $button['label']
                );
            }
        }

        return $html;
    }

    /**
     * Input field.
     *
     * @param  string $id          Field id.
     * @param  string $label       Field label.
     * @param  string $description Field description.
     * @param  array  $attributes  Array with field attributes.
     *
     * @return string              HTML of the field.
     */
    protected function field_input( $id, $label, $description, $attributes ) {
        // Set the default type.
        if ( ! isset( $attributes['type'] ) )
            $attributes['type'] = 'text';

        // Set the default class.
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s</label>', $id, $label );
        $html .= sprintf( '<input id="%1$s" name="%1$s"%2$s />', $id, $this->process_attributes( $attributes ) );
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
        $html .= '</div>';

        return $html;
    }

    /**
     * Textarea field.
     *
     * @param  string $id          Field id.
     * @param  string $label       Field label.
     * @param  string $description Field description.
     * @param  array  $attributes  Array with field attributes.
     *
     * @return string              HTML of the field.
     */
    protected function field_textarea( $id, $label, $description, $attributes ) {
        // Set the default class.
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s</label>', $id, $label );
        $html .= sprintf( '<textarea id="%1$s" name="%1$s" cols="60" rows="4"%2$s></textarea>', $id, $this->process_attributes( $attributes ) );
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
        $html .= '</div>';

        return $html;
    }

    /**
     * Checkbox field.
     *
     * @param  string $id          Field id.
     * @param  string $label       Field label.
     * @param  string $description Field description.
     * @param  array  $attributes  Array with field attributes.
     *
     * @return string              HTML of the field.
     */
    protected function field_checkbox( $id, $label, $description, $attributes ) {
        $html = '<div class="checkbox">';
        $html .= '<label>';
        $html .= sprintf( '<input type="checkbox" id="%1$s" name="%1$s" value="1"%2$s />', $id, $this->process_attributes( $attributes ) );
        $html .= ' ' . $label . '</label>';
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
        $html .= '</div>';

        return $html;
    }

    /**
     * Select field.
     *
     * @param  string $id          Field id.
     * @param  string $label       Field label.
     * @param  string $description Field description.
     * @param  array  $attributes  Array with field attributes.
     * @param  array  $options     Array with field options (value => name).
     *
     * @return string              HTML of the field.
     */
    protected function field_select( $id, $label, $description, $attributes, $options ) {
        // Set the default class.
        if ( ! isset( $attributes['class'] ) )
            $attributes['class'] = 'form-control';

        $html = '<div class="form-group">';
        $html .= sprintf( '<label for="%s">%s</label>', $id, $label );
        $html .= sprintf( '<select id="%1$s" name="%1$s"%2$s>', $id, $this->process_attributes( $attributes ) );

        foreach ( $options as $value => $name )
            $html .= sprintf( '<option value="%s">%s</option>', $value, $name );

        $html .= '</select>';
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';
        $html .= '</div>';

        return $html;
    }

    /**
     * Radio field.
     *
     * @param  string $id          Field id.
     * @param  string $description Field description.
     * @param  array  $attributes  Array with field attributes.
     * @param  array  $options     Array with field options (value => label).
     *
     * @return string              HTML of the field.
     */
    protected function field_radio( $id, $description, $attributes, $options ) {
        $html = '';

        foreach ( $options as $value => $label ) {
            $html .= '<div class="radio">';
            $html .= sprintf( '<label><input type="radio" id="%1$s-%2$s" name="%1$s" value="%2$s"%4$s /> %3$s</label>', $id, $value, $label, $this->process_attributes( $attributes ) );
            $html .= '</div>';
        }
        $html .= ! empty( $description ) ? '<span class="help-block">' . $description . '</span>' : '';

        return $html;
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

            $html .= do_action( 'odin_front_end_form_before_fields_' . $this->id );
            $html .= $this->process_fields();
            $html .= do_action( 'odin_front_end_form_after_fields_' . $this->id );
            $html .= $this->process_buttons();

        $html .= '</form>';

        return $html;
    }
}
