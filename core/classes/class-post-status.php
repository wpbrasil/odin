<?php
/**
 * Odin_Post_Status Class.
 *
 * Build Custom Post Status
 *
 * @package  Odin
 * @category Metabox
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Post_Status {

	 /**
	 * The name of Custom Post Status.
	 *
	 * @var string
	 **/
	protected $post_status;

	/**
	 * Array of Post Types will applied to.
	 *
	 * @var arrays
	 **/
	protected $post_types = array();

	/**
	 * Text used to display the custom post status
	 * when it can be applied to a post.
	 *
	 * @var string
	 **/
	protected $action_label;

	/**
	 * Text used to display the custom post status
	 * when it has been applied to a post.
	 *
	 * @var string
	 **/
	protected $applied_label;

	/**
	 * Array of arguments to pass register_post_status();
	 *
	 * @var array
	 **/
	protected $args = array();

	/**
	 * Constructor
	 *
	 * @param string $post_status Name of the Custom Post Status
	 * @param array $post_types Array of Posts Types to apply the Custom Post Status
	 * @param array $args Array of arguments to pass register_post_status() function
	 **/
	public function __construct( $post_status, $post_types, $args ) {
		$this->post_status		= $post_status;
		$this->post_types		= $post_types;
		$this->action_label		= isset( $args['label'] ) ? $args['label'] : $post_status;
		$this->applied_label	= isset( $args['applied_label'] ) ? $args['applied_label'] : $this->action_label;
		$this->args				= $args;

		// Removes the arguments that do not belong to register_post_type
		unset( $this->args['applied_label'] );

		if( ! isset( $this->args['label_count'] ) ) {
			$this->args['label_count'] = _n_noop( $this->applied_label . '&nbsp;<span class="count">(%s)</span>', $this->applied_label . '&nbsp;<span class="count">(%s)</span>' );
		}

		// Register post status
		add_action( 'init', array( $this, 'register_post_status' ) );

		// Add meta tags to pass args
		add_action( 'admin_head', array( $this, 'meta_tags' ) );

		// Load scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

	}

	/**
	 * Register the Custom Post Status with Wordpress ;)
	 *
	 * @param string $post_status The name of Custom Post Status.
	 * @param array $args Array of arguments to pass register_post_status()
	 **/
	public function register_post_status() {
		register_post_status( $this->post_status, $this->args );
	}

	/**
	 * Add meta tags to JS
	 */
	public function meta_tags() {
		$screen = get_current_screen();
		if( ! in_array( $screen->post_type, $this->post_types ) ) {
			return;
		}

		$args = array(
			'postTypes'     => $this->post_types,
			'appliedLabel'  => $this->applied_label,
			'slug'			=> $this->post_status,
		);
		if( $screen->base === 'post' ) {
			global $post;
			if( is_object( $post ) && $post->post_status === $this->post_status ) {
				$args['select'] = true;
			}
		}
		printf( '<meta class="odin-custom-status-meta" value="%s" />', esc_attr( json_encode( $args ) ) );
	}

	/**
	 * Load post status scripts and inject JS vars
	 */
	public function scripts() {
		// Load admin JS
		wp_enqueue_script( 'odin-custom-status', get_template_directory_uri() . '/core/assets/js/admin-custom-status.js', array( 'jquery' ), null, true );

	}
}
