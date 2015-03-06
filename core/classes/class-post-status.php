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
class Odin_Post_Status
{
	 /**
     * The name of Custom Post Status.
     *
     * @var string
     **/
    protected $post_status;

    /**
     * Array of Post Types will applied to.
     *
     * @var array
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
    public function __construct($post_status, $post_types, $args)
    {
        $this->post_status   = $post_status;
        $this->post_types    = $post_types;
        $this->action_label  = isset($args['label']) ? $args['label'] : $post_status;
        $this->applied_label = isset($args['applied_label']) : $args['applied_label'] : $this->action_label;
        $this->args          = $args;

        // removes the arguments that do not belong to register_post_type
        unset($this->args['applied_label']);

        if(! isset($this->args['label_count']))
            $this->args['label_count'] = _n_noop("{$this->applied_label} <span class=\"count\">(%s)</span>", "{$this->applied_label} <span class=\"count\">(%s)</span>");

        add_action('init', array($this, 'register_post_status'));
        add_action('admin_footer-post.php', array($this, 'posts_status_dropdown'));
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
    public function register_post_status()
    {
        register_post_status($this->post_status, $this->args);
    }

    /**
     * undocumented function
     *
     * @return void
     **/
    public function posts_status_dropdown()
    {
        // do something
    }

    /**
     * undocumented function
     *
     * @return void
     **/
    public function inline_status_dropdown()
    {
        // do something
    }

    /**
     * undocumented function
     *
     * @return void
     **/
    public function update_post_status()
    {
        // do something
    }
}
