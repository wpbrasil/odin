<?php
/**
 * Odin_Post_Status Class.
 *
 * Build Custom Post Status
 *
 * @package  Odin
 * @category Post Status
 * @author   WPBrasil
 * @version  2.1.4
 **/
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
	 *
	 * @return void
	 **/
	public function __construct( $post_status, $post_types, $args ) {
		$this->post_status   = $post_status;
		$this->post_types    = $post_types;
		$this->action_label  = isset( $args['label'] ) ? $args['label'] : $post_status;
		$this->applied_label = isset( $args['applied_label'] ) ? $args['applied_label'] : $this->action_label;
		$this->args          = $args;

		// removes the arguments that do not belong to register_post_type
		unset($this->args['applied_label']);

		if ( ! isset($this->args['label_count']) )
			$this->args['label_count'] = _n_noop( "$this->applied_label <span class='count'>(%s)</span>", "$this->applied_label <span class='count'>(%s)</span>" );

		add_action('init', array($this, 'register_post_status'));
		add_action('admin_footer-post.php', array($this, 'post_status_dropdown'));
		add_action('admin_footer-edit.php', array($this, 'inline_status_dropdown'));
		add_filter('display_post_states', array($this, 'update_post_status'));
	}

	/**
	 * Register the Custom Post Status with Wordpress ;)
	 *
	 * @param string $post_status The name of Custom Post Status.
	 * @param array $args Array of arguments to pass register_post_status()
	 *
	 * @return void
	 **/
	public function register_post_status() {
		register_post_status($this->post_status, $this->args);
	}

	/**
	 * Append Custom Post Status to dropdown on the edit pages of posts.
	 *
	 * @return void
	 **/
	public function post_status_dropdown() {
		global $post;
		$selected = "";
		$label    = "";

		if( in_array($post->post_type, $this->post_types) ) {

			if( $post->post_status === $this->post_status ) {
				$selected = " selected='selected'";
				$label    = "<span id='post-status-display'>$this->applied_label</span>";
			}

			echo "
				<script type='text/javascript'>
					jQuery(document).ready(function($) {
						$('select#post_status').append('<option value='$this->post_status' $selected>$this->action_label</option>');
						$('.misc-pub-section label').append('$label');
					});
				</script>";
		}
	}

	/**
	 * Append Custom Post Status to dropdown on
	 * the quick edit area of post listing pages.
	 *
	 * @return void
	 **/
	public function inline_status_dropdown() {
		global $post;

		if( ! $post )
			return;

		if( in_array( $post->post_type, $this->post_types ) ) {
			echo "
				<script type='text/javascript'>
					jQuery(document).ready(function($) {
						$('.inline-edit-status select').append('<option value='$this->post_status'>$this->action_label</option>');
					});
				</script>";
		}
	}

	/**
	 * Update the text on edit.php to be more
	 * descriptive of the type of post
	 *
	 * @param array $states An array of post display states.
	 * @return void
	 **/
	public function update_post_status( $states ) {
		global $post;

		$status = get_query_var('post_status');

		if( $status !== $this->post_status && $post->post_status === $this->post_status )
			return array($this->applied_label);

		return $states;
	}
}
