<?php
/**
 * Odin_Taxonomy class.
 *
 * Built Custom Taxonomies.
 *
 * @package  Odin
 * @category Taxonomy
 * @author   WPBrasil
 * @version  1.0
 */
class Odin_Taxonomy {

    /**
     * Array of labels for the Taxonomy.
     *
     * @var array
     */
    protected $labels = array();

    /**
     * Taxonomy arguments.
     *
     * @var array
     */
    protected $arguments = array();

    /**
     * Construct Taxonomy.
     *
     * @param string $name        The singular name of the taxonomy.
     * @param string $slug        Taxonomy slug.
     * @param string $object_type Name of the object type for the taxonomy object.
     * @param string $sex         Sex of taxonomy ('m' for male and 'f' female).
     */
    public function __construct( $name, $slug, $object_type, $sex = 'm' ) {
        $this->name        = $name;
        $this->slug        = $slug;
        $this->object_type = $object_type;
        $this->sex         = $sex;

        // Register Taxonomy.
        add_action( 'init', array( &$this, 'register_taxonomy' ) );
    }

    /**
     * Set custom labels.
     *
     * @param array $labels Custom labels.
     */
    public function set_labels( $labels = array() ) {
        $this->labels = $labels;
    }

    /**
     * Set custom arguments.
     *
     * @param array $arguments Custom arguments.
     */
    public function set_arguments( $arguments = array() ) {
        $this->arguments = $arguments;
    }

    /**
     * Define Taxonomy labels.
     *
     * @return array Taxonomy labels.
     */
    protected function labels() {
        $default = array(
            'name'                => sprintf( __( '%ss', 'odin' ), $this->name ),
            'singular_name'       => sprintf( __( '%s', 'odin' ), $this->name ),
            'add_or_remove_items' => sprintf( __( 'Adicionar ou remover %ss', 'odin' ), $this->name ),
            'view_item'           => sprintf( __( 'Ver %s', 'odin' ), $this->name ),
            'edit_item'           => sprintf( __( 'Editar %s', 'odin' ), $this->name ),
            'search_items'        => sprintf( __( 'Pesquisar %s', 'odin' ), $this->name ),
            'update_item'         => sprintf( __( 'Atualizar %s', 'odin' ), $this->name ),
            'parent_item'         => sprintf( __( 'Parente %s:', 'odin' ), $this->name ),
            'parent_item_colon'   => sprintf( __( 'Parente %s:', 'odin' ), $this->name ),
            'menu_name'           => sprintf( __( '%ss', 'odin' ), $this->name ),
        );

        if ( 'm' == $this->sex ) {
            $default['add_new_item'] =  sprintf( __( 'Adicionar novo %s', 'odin' ), $this->name );
            $default['new_item_name'] = sprintf( __( 'Novo %s', 'odin' ), $this->name );
            $default['all_items'] = sprintf( __( 'Todos os %ss', 'odin' ), $this->name );
            $default['separate_items_with_commas'] = sprintf( __( 'Separe os %ss com v&iacute;rgulas', 'odin' ), $this->name );
            $default['choose_from_most_used'] = sprintf( __( 'Escolha entre os %ss mais utilizados', 'odin' ), $this->name );
        } else {
            $default['add_new_item'] =  sprintf( __( 'Adicionar nova %s', 'odin' ), $this->name );
            $default['new_item_name'] = sprintf( __( 'Nova %s', 'odin' ), $this->name );
            $default['all_items'] = sprintf( __( 'Todas as %ss', 'odin' ), $this->name );
            $default['separate_items_with_commas'] = sprintf( __( 'Separe as %ss com v&iacute;rgulas', 'odin' ), $this->name );
            $default['choose_from_most_used'] = sprintf( __( 'Escolha entre as %ss mais utilizadas', 'odin' ), $this->name );
        }

        return array_merge( $default, $this->labels );
    }

    /**
     * Define Taxonomy arguments.
     *
     * @return array Taxonomy arguments.
     */
    protected function arguments() {
        $default = array(
            'labels'            => $this->labels(),
            'hierarchical'      => true, // Like categories.
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
        );

        return array_merge( $default, $this->arguments );
    }

    /**
     * Register Taxonomy.
     *
     * @return void
     */
    public function register_taxonomy() {
        register_taxonomy( $this->slug, $this->object_type, $this->arguments() );
    }
}
