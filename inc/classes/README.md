# Settings Tutorial #

#### Include the settings class: ####

    require_once get_template_directory() . '/inc/classes/class-theme-options.php';

#### Menu example: ####

    $odin_theme_options = new Odin_Theme_Options( 'Titulo', 'slug' );

#### Settings tabs example: ####

    $odin_theme_options->set_tabs(
        array(
            array(
                'id' => 'odin_general',
                'title' => __( 'Configura&ccedil;&otilde;es', '_base' ),
                'validate' => false
            ),
            array(
                'id' => 'odin_adsense',
                'title' => __( 'Adsense', '_base' )
            )
        )
    );

#### Settings fields example: ####

    $odin_theme_options->set_fields(
        array(
            'general_section' => array(
                'tab'   => 'odin_general',
                'title' => __( 'Section Example', '_base' ),
                'options' => array(
                    array(
                        'id' => 'html',
                        'label' => __( '', '_base' ),
                        'type' => 'html',
                        'description' => __( 'HTML Example', '_base' ),
                    ),
                    array(
                        'id' => 'text',
                        'label' => __( 'Text Example', '_base' ),
                        'type' => 'text',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'textarea',
                        'label' => __( 'Textarea Example', '_base' ),
                        'type' => 'textarea',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'editor',
                        'label' => __( 'Editor example', '_base' ),
                        'type' => 'editor',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'checkbox',
                        'label' => __( 'Checkbox example', '_base' ),
                        'type' => 'checkbox',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'multicheckbox',
                        'label' => __( 'Multicheckbox Example', '_base' ),
                        'type' => 'multicheckbox',
                        'description' => __( 'Descrition Example', '_base' ),
                        'options' => array(
                            'one' => 'One',
                            'two' => 'Two',
                            'three' => 'Three',
                            'four' => 'Four'
                        )
                    ),
                    array(
                        'id' => 'radio',
                        'label' => __( 'Radio example', '_base' ),
                        'type' => 'radio',
                        'description' => __( 'Descrition Example', '_base' ),
                        'options' => array(
                            'one' => 'One',
                            'two' => 'Two',
                            'three' => 'Three',
                            'four' => 'Four'
                        ),
                        'default' => 'two'
                    ),
                    array(
                        'id' => 'select',
                        'label' => __( 'Select Example', '_base' ),
                        'type' => 'select',
                        'description' => __( 'Descrition Example', '_base' ),
                        'options' => array(
                            'one' => 'One',
                            'two' => 'Two',
                            'three' => 'Three',
                            'four' => 'Four'
                        ),
                        'default' => 'three'
                    ),
                    array(
                        'id' => 'color',
                        'label' => __( 'Color Example', '_base' ),
                        'type' => 'color',
                        'default' => '#ffffff',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'upload',
                        'label' => __( 'Upload Example', '_base' ),
                        'type' => 'upload',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                )
            ),
            'adsense_section_primary' => array(
                'tab'   => 'odin_adsense',
                'title' => __( 'Section 01 Example', '_base' ),
                'options' => array(
                    array(
                        'id' => 'text01',
                        'label' => __( 'Text 01 Example', '_base' ),
                        'type' => 'text',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'textarea01',
                        'label' => __( 'Textarea 01 Example', '_base' ),
                        'type' => 'textarea',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    )
                )
            ),
            'sessao_teste_legal' => array(
                'tab'   => 'odin_adsense',
                'title' => __( 'Section 02 Example', '_base' ),
                'options' => array(
                    array(
                        'id' => 'text02',
                        'label' => __( 'Text 02 Example', '_base' ),
                        'type' => 'text',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    ),
                    array(
                        'id' => 'textarea02',
                        'label' => __( 'Textarea 02 Example', '_base' ),
                        'type' => 'textarea',
                        'default' => 'Default text',
                        'description' => __( 'Descrition Example', '_base' )
                    )
                )
            )
        )
    );
