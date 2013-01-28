<?php
/**
 * Odin_Metabox class.
 *
 * Built Metaboxs.
 *
 * @package  Odin
 * @category Metabox
 * @author   WPBrasil
 * @version  1.0
 */
class Odin_Metabox {

    protected $fields = array();

    /**
     * Metaboxs construct.
     *
     * @param string $id        HTML 'id' attribute of the edit screen section.
     * @param string $title     Title of the edit screen section, visible to user.
     * @param string $post_type The type of Write screen on which to show the edit screen section.
     * @param string $context   The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
     * @param string $priority  The priority within the context where the boxes should show ('high', 'core', 'default' or 'low').
     */
    public function __construct( $id, $title, $post_type = 'post', $context = 'normal', $priority = 'high' ) {
        $this->id        = $id;
        $this->title     = $title;
        $this->post_type = $post_type;
        $this->context   = $context;
        $this->priority  = $priority;
        $this->nonce     = $id . '_nonce';

        // Add Metabox.
        add_action( 'add_meta_boxes', array( &$this, 'add' ) );

        // Save Metaboxs.
        add_action( 'save_post', array( &$this, 'save' ) );
    }

    /**
     * Add the metabox in edit screens.
     */
    public function add() {
        add_meta_box(
            $this->id,
            $this->title,
            array( &$this, 'metabox' ),
            $this->post_type,
            $this->context,
            $this->priority
        );
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
     * Metabox view.
     *
     * @param  object $post Post object.
     *
     * @return string       Metabox HTML fields.
     */
    public function metabox( $post ) {
        // Use nonce for verification.
        wp_nonce_field( basename( __FILE__ ), $this->nonce );

        $id = $post->ID;

        echo '<table class="form-table">';

        foreach ( $this->fields as $field ) {
            echo '<tr valign="top">';

            if ( 'title' == $field['type'] ) {
                echo sprintf( '<th colspan="2"><strong>%s</strong></th>', $field['name'] );
            } else {
                echo sprintf( '<th><label for="%s">%s</label></th>', $field['id'], $field['name'] );

                echo '<td>';
                $this->process_fields( $field, $id );

                if ( isset( $field['description'] ) ) {
                    echo sprintf( ' <span class="description">%s</span>', $field['description'] );
                }

                echo '</td>';
            }

            echo '</tr>';
        }

        echo '</table>';

    }

    /**
     * Process metabox fields.
     *
     * @param  array $args    Field arguments
     * @param  int   $post_id ID of the current post type.
     *
     * @return string          HTML field.
     */
    protected function process_fields( $args, $post_id ) {
        $id = $args['id'];
        $current = get_post_meta( $post_id, $id, true );
        $options = isset( $args['options'] ) ? $args['options'] : '';
        $type = $args['type'];

        switch ( $type ) {
            case 'text':
                echo $this->field_text( $id, $current );
                break;
            case 'textarea':
                echo $this->field_textarea( $id, $current );
                break;
            case 'checkbox':
                echo $this->field_checkbox( $id, $current );
                break;
            case 'select':
                echo $this->field_select( $id, $current, $options );
                break;
            case 'radio':
                echo $this->field_radio( $id, $current, $options );
                break;

            default:
                do_action( 'odin_metabox_' . $this->id, $type, $id, $current, $options );
                break;
        }
    }

    /**
     * Text field.
     *
     * @param  string $id      Field id.
     * @param  string $current Field current value.
     *
     * @return string          HTML field.
     */
    protected function field_text( $id, $current ) {
        return sprintf( '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="regular-text" />', $id, esc_attr( $current ) );
    }

    /**
     * Textarea field.
     *
     * @param  string $id      Field id.
     * @param  string $current Field current value.
     *
     * @return string          HTML field.
     */
    protected function field_textarea( $id, $current ) {
        return sprintf( '<textarea id="%1$s" name="%1$s" cols="60" rows="4">%2$s</textarea><br />', $id, esc_attr( $current ) );
    }

    /**
     * Checkbox field.
     *
     * @param  string $id      Field id.
     * @param  string $current Field current value.
     *
     * @return string          HTML field.
     */
    protected function field_checkbox( $id, $current ) {
        return sprintf( '<input type="checkbox" id="%1$s" name="%1$s" value="1"%2$s />', $id, checked( 1, $current, false ) );
    }

    /**
     * Select field.
     *
     * @param  string $id      Field id.
     * @param  string $current Field current value.
     * @param  array  $options Array with field options.
     *
     * @return string          HTML field.
     */
    protected function field_select( $id, $current, $options ) {
        $html = sprintf( '<select id="%1$s" name="%1$s">', $id );

        foreach( $options as $key => $label ) {
            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
        }

        $html .= '</select>';

        return $html;
    }

    /**
     * Radio field.
     *
     * @param  string $id      Field id.
     * @param  string $current Field current value.
     * @param  array  $options Array with field options.
     *
     * @return string          HTML field.
     */
    protected function field_radio( $id, $current, $options ) {
        $html = '';

        foreach( $options as $key => $label ) {
            $html .= sprintf( '<input type="radio" id="%1$s_%2$s" name="%1$s" value="%2$s"%3$s /><label for="%1$s_%2$s"> %4$s</label><br />', $id, $key, checked( $current, $key, false ), $label );
        }

        return $html;
    }

    /**
     * Save metabox data.
     *
     * @param  int $post_id Current post type ID.
     *
     * @return void
     */
    public function save( $post_id ) {
        // Verify nonce.
        if ( ! isset( $_POST[$this->nonce] ) || ! wp_verify_nonce( $_POST[$this->nonce], basename(__FILE__) ) ) {
            return $post_id;
        }

        // Verify if this is an auto save routine.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check permissions.
        if ( $this->post_type == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        foreach ( $this->fields as $field ) {
            $name = $field['id'];
            $old = get_post_meta( $post_id, $name, true );
            $new = $_POST[$name];

            if ( $new && $new != $old ) {
                update_post_meta( $post_id, $name, $new );
            } elseif ( '' == $new && $old ) {
                delete_post_meta( $post_id, $name, $old );
            }
        }

    }

}

// Testes:
// $box = new Odin_Metabox( 'test', 'Teste' );
// $box->set_fields(
//     array(
//         array(
//             'id' => 'test_text',
//             'name' => 'Test Text',
//             'description' => 'Descrição do campo text',
//             'type' => 'text'
//         ),
//         array(
//             'id' => 'test_textarea',
//             'name' => 'Test Textarea',
//             'description' => 'Descrição do campo textarea',
//             'type' => 'textarea'
//         ),
//         array(
//             'id' => 'test_checkbox',
//             'name' => 'Test Checkbox',
//             'description' => 'Descrição do campo checkbox',
//             'type' => 'checkbox'
//         ),
//         array(
//             'id' => 'test_select',
//             'name' => 'Test Select',
//             'description' => 'Descrição do campo Select',
//             'type' => 'select',
//             'options' => array(
//                 'opt1' => 'Opção 01',
//                 'opt2' => 'Opção 02',
//                 'opt3' => 'Opção 03',
//                 'opt4' => 'Opção 04',
//                 'opt5' => 'Opção 05',
//             )
//         ),
//         array(
//             'id' => 'test_radio',
//             'name' => 'Test Radio',
//             'description' => 'Descrição do campo Radio',
//             'type' => 'radio',
//             'options' => array(
//                 'opt1' => 'Opção 01',
//                 'opt2' => 'Opção 02',
//                 'opt3' => 'Opção 03',
//                 'opt4' => 'Opção 04',
//                 'opt5' => 'Opção 05',
//             )
//         )
//     )
// );

// function odin_custom_metabox_fields( $type, $id, $current, $options ) {
//     // Custom fields.
// }

// add_action( 'odin_metabox_test', 'odin_custom_metabox_fields', 1, 4 );
