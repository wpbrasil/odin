<?php
/**
 * Odin_Post_Type_Form class.
 *
 * Built Front End Post Type Forms.
 *
 * @package  Odin
 * @category Post Type Form
 * @author   WPBrasil
 * @version  2.0.0
 */
class Odin_Post_Type_Form extends Odin_Front_End_Form {

    /**
     * Post type content field.
     *
     * @var array
     */
    var $content_field = '';

    /**
     * Post type title field.
     *
     * @var array
     */
    var $title_field = '';

    /**
     * Post type custom fields.
     *
     * @var array
     */
    var $custom_fields = array();

    /**
     * Post Type Form construct.
     *
     * @param string $id          Form id.
     * @param string $post_type   Post type ID/Slug.
     * @param string $post_status Post status.
     * @param array  $attributes  Form attributes.
     */
    public function __construct( $id, $post_type = 'post', $post_status = 'draft', $attributes = array() ) {
        $this->id          = $id;
        $this->post_type   = $post_type;
        $this->post_status = $post_status;
        $this->attributes  = $attributes;

        parent::__construct( $this->id, '', 'post', $this->attributes );

        // Hooks save_post.
        add_action( 'odin_front_end_form_submitted_data_' . $this->id, array( $this, 'save_post' ) );
    }

    /**
     * Set the post type content field.
     *
     * @param string $content_field Content field.
     */
    public function set_content_field( $content_field ) {
        $this->content_field = $content_field;
    }

    /**
     * Set the post type title field.
     *
     * @param string $title_field Title field.
     */
    public function set_title_field( $title_field ) {
        $this->title_field = $title_field;
    }

    /**
     * Set the post type custom fields.
     *
     * @param string $custom_fields Title field.
     */
    public function set_custom_fields( $custom_fields ) {
        $this->custom_fields = $custom_fields;
    }

    /**
     * Save custom fields.
     *
     * @param  int    $post_id        Post ID.
     * @param  array  $submitted_data Submitted form data.
     *
     * @return void
     */
    protected function save_custom_fields( $post_id, $submitted_data ) {
        if ( ! empty( $this->custom_fields ) ) {
            foreach ( $this->custom_fields as $key )
                update_post_meta( $post_id, $key, $submitted_data[ $key ] );
        }
    }

    /**
     * Save post.
     *
     * @param  array $submitted_data Submitted form data.
     *
     * @return void
     */
    public function save_post( $submitted_data ) {
        if ( ! empty( $submitted_data ) ) {
            $post_data = apply_filters( 'odin_post_type_form_insert_post_' . $this->id, array(
                'post_content' => $submitted_data[ $this->content_field ],
                'post_status'  => $this->post_status,
                'post_title'   => sanitize_text_field( $submitted_data[ $this->title_field ] ),
                'post_type'    => $this->post_type,
            ) );

            // Save post.
            $new_post = wp_insert_post( $post_data );

            // Save custom fields.
            $this->save_custom_fields( $new_post, $submitted_data );
        }
    }
}
