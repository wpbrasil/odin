<?php
/**
 * Odin_Post_Type class.
 *
 * Built Custom Post Types.
 *
 * @package  Odin
 * @category Post Types
 * @author   WPBrasil
 * @version  1.0
 */
class Odin_Post_Type {

    /**
     * Array of labels for the post type.
     *
     * @var array
     */
    protected $_labels = array();

    /**
     * Post type arguments.
     *
     * @var array
     */
    protected $_arguments = array();

    /**
     * Construct Post Type.
     *
     * @param string $name       Singular name.
     * @param string $slug       Post type slug.
     * @param string $textdomain Text Domain.
     */
    public function __construct( $name, $slug, $textdomain = 'odin' ) {
        $this->name = $name;
        $this->slug = $slug;
        $this->textdomain = $textdomain;

        // Register post type.
        add_action( 'init', array( &$this, 'register_post_type' ) );
    }

    /**
     * Set custom labels.
     *
     * @param array $labels Custom labels.
     */
    public function set_labels( $labels = array() ) {
        $this->_labels = $labels;
    }

    /**
     * Set custom arguments.
     *
     * @param array $arguments Custom arguments.
     */
    public function set_arguments( $arguments = array() ) {
        $this->_arguments = $arguments;
    }

    /**
     * Define Post Type labels.
     *
     * @return array Post Type labels.
     */
    protected function labels() {
        $default = array(
            'name'               => sprintf( __( '%ss', $this->textdomain ), $this->name ),
            'singular_name'      => __( $this->name, $this->textdomain ),
            'add_new'            => __( 'Adicionar Novo', $this->textdomain ),
            'add_new_item'       => sprintf( __( 'Adicionar %s', $this->textdomain ), $this->name ),
            'edit_item'          => sprintf( __( 'Editar %s', $this->textdomain ), $this->name ),
            'new_item'           => sprintf( __( 'Novo %s', $this->textdomain ), $this->name ),
            'all_items'          => sprintf( __( 'Todos %s', $this->textdomain ), $this->name ),
            'view_item'          => sprintf( __( 'Ver %s', $this->textdomain ), $this->name ),
            'search_items'       => sprintf( __( 'Procurar %s', $this->textdomain ), $this->name ),
            'update_item'        => sprintf( __( 'Atualizar %s', $this->textdomain ), $this->name ),
            'not_found'          => sprintf( __( 'Nenhum %s foi encontrando', $this->textdomain ), $this->name ),
            'not_found_in_trash' => sprintf( __( 'Nenhum %s encontrado na Lixeira', $this->textdomain ), $this->name ),
            'parent_item_colon'  => sprintf( __( 'Parente %s:', $this->textdomain ), $this->name ),
            'menu_name'          => __( $this->name, $this->textdomain ),
        );

        return array_merge( $default, $this->_labels );
    }

    /**
     * Define Post Type arguments.
     *
     * @return array Post Type arguments.
     */
    protected function arguments() {
        $default = array(
            'labels'              => $this->labels(),
            'hierarchical'        => false,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'has_archive'         => true,
            'query_var'           => true,
            'can_export'          => true,
            'rewrite'             => true,
            'capability_type'     => 'post'
        );

        return array_merge( $default, $this->_arguments );
    }

    /**
     * Register Post Type.
     *
     * @return void.
     */
    public function register_post_type() {
        register_post_type( $this->slug, $this->arguments() );
    }
}
