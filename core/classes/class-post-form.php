<?php
/**
 * Odin_Post_Form class.
 *
 * Built Front End Post Forms.
 *
 * @package  Odin
 * @category Post Form
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Post_Form extends Odin_Front_End_Form {

	/**
	 * Post content field.
	 *
	 * @var array
	 */
	protected $content_field = '';

	/**
	 * Post title field.
	 *
	 * @var array
	 */
	protected $title_field = '';

	/**
	 * Post custom fields.
	 *
	 * @var array
	 */
	protected $custom_fields = array();

	/**
	 * Post terms.
	 *
	 * @var array
	 */
	protected $terms = array();

	/**
	 * Post Form construct.
	 *
	 * @param string $id          Form id.
	 * @param string $post_type   Post type Slug/Name.
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
	 * Set the post content field.
	 *
	 * @param string $content_field Content field.
	 */
	public function set_content_field( $content_field ) {
		$this->content_field = $content_field;
	}

	/**
	 * Set the post title field.
	 *
	 * @param string $title_field Title field.
	 */
	public function set_title_field( $title_field ) {
		$this->title_field = $title_field;
	}

	/**
	 * Set the post custom fields.
	 *
	 * @param string $custom_fields Title field.
	 */
	public function set_custom_fields( $custom_fields = array() ) {
		$this->custom_fields = $custom_fields;
	}

	/**
	 * Set the post terms.
	 *
	 * @param string $terms Terms.
	 */
	public function set_terms( $terms = array() ) {
		$this->terms = $terms;
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
			foreach ( $this->custom_fields as $key ) {
				// Apply filter to sanitization.
				$data = apply_filters( 'odin_post_form_custom_field_data_' . $this->id, $submitted_data[ $key ] );

				// Save custom field.
				update_post_meta( $post_id, $key, $data );
			}
		}
	}

	/**
	 * Save terms.
	 *
	 * @param  int    $post_id        Post ID.
	 * @param  array  $submitted_data Submitted form data.
	 *
	 * @return void
	 */
	protected function save_terms( $post_id, $submitted_data ) {
		if ( ! empty( $this->terms ) ) {
			foreach ( $this->terms as $taxonomy => $term ) {
				// Apply filter to sanitization.
				$term = apply_filters( 'odin_post_form_term_data_' . $this->id, $submitted_data[ $term ] );

				// Save term.
				wp_set_post_terms( $post_id, $term, $taxonomy );
			}
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
			$post_data = apply_filters( 'odin_post_form_insert_data_' . $this->id, array(
				'post_content' => $submitted_data[ $this->content_field ],
				'post_status'  => $this->post_status,
				'post_title'   => sanitize_text_field( $submitted_data[ $this->title_field ] ),
				'post_type'    => $this->post_type,
			), $submitted_data );

			// Save post.
			$post_id = wp_insert_post( $post_data );

			// Save custom fields.
			$this->save_custom_fields( $post_id, $submitted_data );

			// Save terms.
			$this->save_terms( $post_id, $submitted_data );

			do_action( 'odin_post_form_after_save_' . $this->id, $post_id, $submitted_data );
		}
	}
}
