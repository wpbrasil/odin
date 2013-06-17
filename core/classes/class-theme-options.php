<?php
/**
 * Odin_Theme_Options class.
 *
 * Built settings page.
 *
 * @package  Odin
 * @category Options
 * @author   WPBrasil
 * @version  1.0
 */
class Odin_Theme_Options {

    /**
     * Settings tabs.
     *
     * @var array
     */
    protected $tabs = array();

    /**
     * Settings fields.
     *
     * @var array
     */
    protected $fields = array();

    /**
     * Settings construct.
     *
     * @param string $page_title Page title.
     * @param string $slug       Page slug.
     * @param string $capability User capability.
     */
    public function __construct(
        $page_title = 'Theme Settings',
        $slug       = 'odin-settings',
        $capability = 'manage_options'
    ) {
        $this->page_title = $page_title;
        $this->slug       = $slug;
        $this->capability = $capability;

        // Actions.
        add_action( 'admin_menu', array( &$this, 'add_page' ) );
        add_action( 'admin_init', array( &$this, 'create_settings' ) );

        if ( isset( $_GET['page'] ) && $_GET['page'] == $slug )
            add_action( 'admin_enqueue_scripts', array( &$this, 'scripts' ) );

    }

    /**
     * Add Settings Theme page.
     *
     * @return void
     */
    public function add_page() {
        add_theme_page(
            $this->page_title,
            $this->page_title,
            $this->capability,
            $this->slug,
            array( &$this, 'settings_page' )
        );
    }

    /**
     * Load options scripts.
     *
     * @return void
     */
    function scripts() {
        // Color Picker.
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );

        // Media Upload.
        wp_enqueue_media();
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_style( 'thickbox' );

        // jQuery UI.
        wp_enqueue_script( 'jquery-ui-sortable' );

        // Theme Options.
        wp_register_style( 'odin-admin', get_template_directory_uri() . '/core/css/admin.css', array(), null, 'all' );
        wp_enqueue_style( 'odin-admin' );
        wp_register_script( 'odin-admin', get_template_directory_uri() . '/core/js/admin.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'odin-admin' );

        // Localize strings.
        wp_localize_script(
            'odin-admin',
            'odin_admin_params',
            array(
                'gallery_title'  => __( 'Add images in gallery', 'odin' ),
                'gallery_button' => __( 'Add in gallery', 'odin' ),
                'gallery_remove' => __( 'Remove image', 'odin' ),
                'upload_title'   => __( 'Choose a file', 'odin' ),
                'upload_button'  => __( 'Add file', 'odin' ),
            )
        );
    }

    /**
     * Set settings tabs.
     *
     * @param array $tabs Settings tabs.
     */
    public function set_tabs( $tabs ) {
        $this->tabs = $tabs;
    }

    /**
     * Set settings fields
     *
     * @param array $fields Settings fields.
     */
    public function set_fields( $fields ) {
        $this->fields = $fields;
    }

    /**
     * Get current tab.
     *
     * @return string Current tab ID.
     */
    protected function get_current_tab() {
        if ( isset( $_GET['tab'] ) )
            $current_tab = $_GET['tab'];
        else
            $current_tab = $this->tabs[0]['id'];

        return $current_tab;
    }

    private function get_current_url() {
        $url = 'http';
        if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' )
            $url .= 's';

        $url .= '://';

        if ( '80' != $_SERVER['SERVER_PORT'] )
            $url .= $_SERVER['SERVER_NAME'] . ' : ' . $_SERVER['SERVER_PORT'] . $_SERVER['PHP_SELF'];
        else
            $url .= $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];

        return esc_url( $url );
    }

    /**
     * Get tab navigation.
     *
     * @param  string $current_tab Current tab ID.
     *
     * @return string              Tab Navigation.
     */
    protected function get_navigation( $current_tab ) {

        $html = '<h2 class="nav-tab-wrapper">';

        foreach ( $this->tabs as $tab ) {

            $current = ( $current_tab == $tab['id'] ) ? ' nav-tab-active' : '';

            $html .= sprintf( '<a href="%s?page=%s&amp;tab=%s" class="nav-tab%s">%s</a>', $this->get_current_url(), $this->slug, $tab['id'], $current, $tab['title'] );
        }

        $html .= '</h2>';

        echo $html;
    }

    /**
     * Built settings page.
     *
     * @return void
     */
    public function settings_page() {
        ?>

        <div class="wrap">

            <?php
                // Display themes screen icon.
                screen_icon( 'themes' );

                // Get current tag.
                $current_tab = $this->get_current_tab();

                // Display the navigation menu.
                $this->get_navigation( $current_tab );

                // Display erros.
                settings_errors();
            ?>

            <form method="post" action="options.php">

                <?php
                    foreach ( $this->tabs as $tabs ) {
                        if ( $current_tab == $tabs['id'] ) {

                            // Prints nonce, action and options_page fields.
                            settings_fields( $tabs['id'] );

                            // Prints settings sections and settings fields.
                            do_settings_sections( $tabs['id'] );
                        }
                    }

                    // Display submit button.
                    submit_button();
                ?>

            </form>

        </div>

        <?php
    }

    /**
     * Create settings.
     *
     * @return void
     */
    public function create_settings() {

        // Register settings fields.
        foreach ( $this->fields as $section => $items ) {

            // Register settings sections.
            add_settings_section(
                $section,
                $items['title'],
                '__return_false',
                $items['tab']
            );

            foreach ( $items['options'] as $option ) {

                $type = isset( $option['type'] ) ? $option['type'] : 'text';

                $args = array(
                    'id'          => $option['id'],
                    'tab'         => $items['tab'],
                    'description' => isset( $option['description'] ) ? $option['description'] : '',
                    'name'        => $option['label'],
                    'section'     => $section,
                    'size'        => isset( $option['size'] ) ? $option['size'] : null,
                    'options'     => isset( $option['options'] ) ? $option['options'] : '',
                    'default'     => isset( $option['default'] ) ? $option['default'] : ''
                );

                add_settings_field(
                    $option['id'],
                    $option['label'],
                    array( &$this, 'callback_' . $type ),
                    $items['tab'],
                    $section,
                    $args
                );
            }
        }

        // Register settings.
        foreach ( $this->tabs as $tabs ) {
            register_setting( $tabs['id'], $tabs['id'], array( &$this, 'validate_input' ) );
        }
    }

    /**
     * Get Option.
     *
     * @param  string $tab     Tab that the option belongs
     * @param  string $id      Option ID.
     * @param  string $default Default option.
     *
     * @return array           Item options.
     */
    protected function get_option( $tab, $id, $default = '' ) {
        $options = get_option( $tab );

        if ( isset( $options[$id] ) )
            $default = $options[$id];

        return $default;

    }

    /**
     * Text field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Text field HTML.
     */
    public function callback_text( $args ) {
        $this->callback_input( $args );
    }

    /**
     * Input field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Input field HTML.
     */
    public function callback_input( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = esc_html( $this->get_option( $tab, $id, $args['default'] ) );

        // Sets input size.
        $size = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

        // Sets input type.
        $type = isset( $args['options']['type'] ) ? $args['options']['type'] : 'text';

        // Sets input class.
        $class = isset( $args['options']['class'] ) ? ' ' . $args['options']['class'] : '';

        // Sets input styles.
        $styles = isset( $args['options']['styles'] ) ? ' style="' . $args['options']['styles'] . '"' : '';

        $html = sprintf(
            '<input type="%5$s" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="%4$s-text%6$s"%7$s />',
            $id, $tab, $current, $size, $type, $class, $styles
        );

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Textarea field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Textarea field HTML.
     */
    public function callback_textarea( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = esc_textarea( $this->get_option( $tab, $id, $args['default'] ) );

        $html = sprintf( '<textarea id="%1$s" name="%2$s[%1$s]" rows="5" cols="50">%3$s</textarea>', $id, $tab, $current );

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Editor field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Editor field HTML.
     */
    public function callback_editor( $args ) {
        $tab     = $args['tab'];
        $id      = $args['id'];
        $options = $args['options'];

        // Sets current option.
        $current = wpautop( $this->get_option( $tab, $id, $args['default'] ) );

        // Sets input size.
        $size = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : '600px';

        // Set default options.
        if ( empty( $options ) )
            $options = array( 'textarea_rows' => 10 );

        echo '<div style="width: ' . $size . ';">';

            wp_editor( $current, $tab . '[' . $id . ']', $options );

        echo '</div>';

        // Displays the description.
        if ( $args['description'] )
            echo sprintf( '<p class="description">%s</p>', $args['description'] );
    }

    /**
     * Checkbox field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Checkbox field HTML.
     */
    public function callback_checkbox( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = $this->get_option( $tab, $id, $args['default'] );

        $html = sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s />', $id, $tab, checked( 1, $current, false ) );

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<label for="%s"> %s</label>', $id, $args['description'] );

        echo $html;
    }

    /**
     * Multicheckbox field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Multicheckbox field HTML.
     */
    public function callback_multicheckbox( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        $html = '';
        foreach( $args['options'] as $key => $label ) {
            $item_id = $id . '_' . $key;

            // Sets current option.
            $current = $this->get_option( $tab, $item_id, $args['default'] );

            $html .= sprintf( '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1"%3$s />', $item_id, $tab, checked( $current, 1, false ) );
            $html .= sprintf( '<label for="%s"> %s</label><br />', $item_id, $label );
        }

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Radio field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Radio field HTML.
     */
    public function callback_radio( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = $this->get_option( $tab, $id, $args['default'] );

        $html = '';
        foreach( $args['options'] as $key => $label ) {
            $item_id = $id . '_' . $key;
            $key = sanitize_title( $key );

            $html .= sprintf( '<input type="radio" id="%1$s_%3$s" name="%2$s[%1$s]" value="%3$s"%4$s />', $id, $tab, $key, checked( $current, $key, false ) );
            $html .= sprintf( '<label for="%s"> %s</label><br />', $item_id, $label );
        }

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Select field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Select field HTML.
     */
    public function callback_select( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = $this->get_option( $tab, $id, $args['default'] );

        $html = sprintf( '<select id="%1$s" name="%2$s[%1$s]">', $id, $tab );
        foreach( $args['options'] as $key => $label ) {
            $key = sanitize_title( $key );

            $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $current, $key, false ), $label );
        }
        $html .= '</select>';

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Color field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Color field HTML.
     */
    public function callback_color( $args ) {
        $args['size'] = 'custom';
        $args['options'] = array( 'class' => 'odin-color-field' );
        $this->callback_input( $args );
    }

    /**
     * Upload field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Upload field HTML.
     */
    public function callback_upload( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = esc_url( $this->get_option( $tab, $id, $args['default'] ) );

        $html = sprintf( '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text" /> <input class="button odin-upload-button" id="%1$s-button" type="button" value="%4$s" />', $id, $tab, $current, __( 'Select file', 'odin' ) );

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Image field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Image field HTML.
     */
    public function callback_image( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = $this->get_option( $tab, $id, $args['default'] );

        // Gets placeholder image.
        $image = get_template_directory_uri() . '/core/images/placeholder.png';
        $html  = '<span class="odin-default-image" style="display: none;">' . $image . '</span>';

        if ( $current ) {
            $image = wp_get_attachment_image_src( $current, 'thumbnail' );
            $image = $image[0];
        }

        $html .= sprintf( '<input id="%1$s" name="%2$s[%1$s]" type="hidden" class="odin-upload-image" value="%3$s" /><img src="%4$s" class="odin-preview-image" style="height: 150px; width: 150px;" alt="" /><br /><input id="%1$s-button" class="odin-upload-image-button button" type="button" value="%5$s" /><small> <a href="#" class="odin-clear-image-button">%6$s</a></small>', $id, $tab, $current, $image, __( 'Select image', 'odin' ), __( 'Remove image', 'odin' ) );

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * Image Plupload field callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string Image Plupload field HTML.
     */
    public function callback_image_plupload( $args ) {
        $tab = $args['tab'];
        $id  = $args['id'];

        // Sets current option.
        $current = $this->get_option( $tab, $id, $args['default'] );

        $html = '<div class="odin-gallery-container">';
            $html .= '<ul class="odin-gallery-images">';
                if ( ! empty( $current ) ) {
                    // Gets the current images.
                    $attachments = array_filter( explode( ',', $current ) );

                    if ( $attachments ) {
                        foreach ( $attachments as $attachment_id ) {
                            $html .= sprintf( '<li class="image" data-attachment_id="%1$s">%2$s<ul class="actions"><li><a href="#" class="delete" title="%3$s">X</a></li></ul></li>',
                                $attachment_id,
                                wp_get_attachment_image( $attachment_id, 'thumbnail' ),
                                __( 'Remove image', 'odin' )
                            );
                        }
                    }
                }
            $html .= '</ul><div class="clear"></div>';

            // Adds the hidden input.
            $html .= sprintf( '<input type="hidden" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="odin-gallery-field" />', $id, $tab, $current );

            // Adds "adds images in gallery" url.
            $html .= sprintf( '<p class="odin-gallery-add hide-if-no-js"><a href="#">%s</a></p>', __( 'Add images in gallery', 'odin' ) );
        $html .= '</div>';

        // Displays the description.
        if ( $args['description'] )
            $html .= sprintf( '<p class="description">%s</p>', $args['description'] );

        echo $html;
    }

    /**
     * HTML callback.
     *
     * @param array $args Arguments from the option.
     *
     * @return string HTML.
     */
    public function callback_html( $args ) {
        echo $args['description'];
    }

    /**
     * Sanitization fields callback.
     *
     * @param  string $input The unsanitized collection of options.
     *
     * @return string        The collection of sanitized values.
     */
    public function validate_input( $input ) {

        // Create our array for storing the validated options
        $output = array();

        // Loop through each of the incoming options
        foreach ( $input as $key => $value ) {

            // Check to see if the current option has a value. If so, process it.
            if ( isset( $input[$key] ) )
                $output[$key] = apply_filters( 'odin_theme_options_validate_' . $this->slug, $value );

        }

        return $output;
    }
}
