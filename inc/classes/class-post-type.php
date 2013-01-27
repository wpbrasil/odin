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
     * @param string $sex        Sex of Post Type ('m' for male and 'f' female).
     */
    public function __construct( $name, $slug, $sex = 'm' ) {
        $this->name = $name;
        $this->slug = $slug;
        $this->sex  = $sex;

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
            'name'               => sprintf( __( '%ss', 'odin' ), $this->name ),
            'singular_name'      => sprintf( __( '%s', 'odin' ), $this->name ),
            'view_item'          => sprintf( __( 'Ver %s', 'odin' ), $this->name ),
            'edit_item'          => sprintf( __( 'Editar %s', 'odin' ), $this->name ),
            'search_items'       => sprintf( __( 'Pesquisar %s', 'odin' ), $this->name ),
            'update_item'        => sprintf( __( 'Atualizar %s', 'odin' ), $this->name ),
            'parent_item_colon'  => sprintf( __( 'Parente %s:', 'odin' ), $this->name ),
            'menu_name'          => sprintf( __( '%s', 'odin' ), $this->name ),
        );

        if ( 'm' == $this->sex ) {
            $default['add_new'] = __( 'Adicionar Novo', 'odin' );
            $default['add_new_item'] =  sprintf( __( 'Adicionar novo %s', 'odin' ), $this->name );
            $default['new_item'] = sprintf( __( 'Novo %s', 'odin' ), $this->name );
            $default['all_items'] = sprintf( __( 'Todos os %s', 'odin' ), $this->name );
            $default['not_found'] =  sprintf( __( 'Nenhum %s foi encontrando', 'odin' ), $this->name );
            $default['not_found_in_trash'] = sprintf( __( 'Nenhum %s encontrado na Lixeira', 'odin' ), $this->name );
        } else {
            $default['add_new']  = __( 'Adicionar Nova', 'odin' );
            $default['add_new_item'] =  sprintf( __( 'Adicionar nova %s', 'odin' ), $this->name );
            $default['new_item'] = sprintf( __( 'Nova %s', 'odin' ), $this->name );
            $default['all_items'] = sprintf( __( 'Todas as %s', 'odin' ), $this->name );
            $default['not_found'] =  sprintf( __( 'Nenhuma %s foi encontranda', 'odin' ), $this->name );
            $default['not_found_in_trash'] = sprintf( __( 'Nenhuma %s encontrada na Lixeira', 'odin' ), $this->name );
        }

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
     * @return void
     */
    public function register_post_type() {
        register_post_type( $this->slug, $this->arguments() );
    }
}
