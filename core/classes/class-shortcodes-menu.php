<?php

/**
 * Odin_Shortcodes class.
 *
 * Built Shortcodes Menu on editor text.
 *
 * @package  Odin
 * @category Shortcodes
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Shortcodes_Menu
{
    public function __construct()
    {

        add_action('admin_head', array($this, 'add_shortcode_button'));
		add_filter( 'mce_external_languages', array( $this, 'add_tinymce_locales' ), 20, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
    }

    /**
     * Add a button for shortcodes to the WP editor.
     */
    public function add_shortcode_button()
    {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') == 'true') {
            add_filter('mce_external_plugins', array($this, 'add_shortcode_tinymce_plugin'));
            add_filter('mce_buttons', array($this, 'register_shortcode_button'));
        }
    }

    /**
     * Add the shortcode button to TinyMCE.
     *
     * @param  array $plugins TinyMCE plugins.
     *
     * @return array          Odin TinyMCE plugin.
     */
    public function add_shortcode_tinymce_plugin($plugins)
    {
        //$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        $plugins['odin_shortcodes'] = get_template_directory_uri() . "/core/assets/js/editor-shortcodes.js";

        return $plugins;

    }

    /**
     * Register the shortcode button.
     *
     * @param array $buttons
     * @return array
     */
    public function register_shortcode_button($buttons)
    {
        array_push($buttons, '|', 'odin_shortcodes');

        return $buttons;
    }

    /**
     * TinyMCE locales function.
     *
     * @param  array $locales TinyMCE locales.
     *
     * @return array
     */
    public function add_tinymce_locales($locales)
    {
        $locales['odin_shortcodes'] = get_template_directory() . 'shortcodes-editor-i18n.php';

        return $locales;
    }

    /**
     * Admin scripts.
     *
     * @param  string $hook Page slug.
     *
     * @return void
     */
    public function admin_scripts($hook)
    {
        wp_enqueue_style('odin-shortcodes', get_template_directory('assets/css/editor.css', get_template_directory()), array('odin_admin_menu_styles'), false, 'all');
    }
}

new Odin_Shortcodes_Menu;

class Odin_Shortcodes_Menu_Lang
{

    function __construct()
    {
        $strings = 'tinyMCE.addI18n({' . _WP_Editors::$mce_locale . ': {
	odin_shortcodes: {
		shortcode_title: "' . esc_js(__('Odin', 'odin_shortcodes')) . '",
		product: "' . esc_js(__('Product', 'odin_shortcodes')) . '",
		list: "' . esc_js(__('List', 'odin_shortcodes')) . '",
		add_to_cart: "' . esc_js(__('Price/cart button', 'odin_shortcodes')) . '",
		add_to_cart_url: "' . esc_js(__('Add to cart URL', 'odin_shortcodes')) . '",
		product_by_sku: "' . esc_js(__('By SKU/ID', 'odin_shortcodes')) . '",
		products_by_sku: "' . esc_js(__('Products by SKU/ID', 'odin_shortcodes')) . '",
		product_categories: "' . esc_js(__('Product categories', 'odin_shortcodes')) . '",
		products_by_cat_slug: "' . esc_js(__('Products by category slug', 'odin_shortcodes')) . '",
		products_by_attribute: "' . esc_js(__('Products by attributes', 'odin_shortcodes')) . '",
		recent_products: "' . esc_js(__('Recent products', 'odin_shortcodes')) . '",
		featured_products: "' . esc_js(__('Featured products', 'odin_shortcodes')) . '",
		sale_products: "' . esc_js(__('Sale products', 'odin_shortcodes')) . '",
		best_selling_products: "' . esc_js(__('Best selling products', 'odin_shortcodes')) . '",
		top_rated_products: "' . esc_js(__('Top rated products', 'odin_shortcodes')) . '",
		shop_messages: "' . esc_js(__('Shop Messages', 'odin_shortcodes')) . '",
		order_tracking: "' . esc_js(__('Order tracking', 'odin_shortcodes')) . '",
		id: "' . esc_js(__('ID', 'odin_shortcodes')) . '",
		ids: "' . esc_js(__('IDs', 'odin_shortcodes')) . '",
		sku: "' . esc_js(__('SKU', 'odin_shortcodes')) . '",
		skus: "' . esc_js(__('SKUs', 'odin_shortcodes')) . '",
		style: "' . esc_js(__('Inline Style', 'odin_shortcodes')) . '",
		show_price: "' . esc_js(__('Show Price', 'odin_shortcodes')) . '",
		comma_tooltip: "' . esc_js(__('Separate the values with comma', 'odin_shortcodes')) . '",
		number: "' . esc_js(__('Number', 'odin_shortcodes')) . '",
		orderby: "' . esc_js(__('Order By', 'odin_shortcodes')) . '",
		name: "' . esc_js(__('Name', 'odin_shortcodes')) . '",
		count: "' . esc_js(__('Count', 'odin_shortcodes')) . '",
		slug: "' . esc_js(__('Slug', 'odin_shortcodes')) . '",
		none: "' . esc_js(__('None', 'odin_shortcodes')) . '",
		order: "' . esc_js(__('Order', 'odin_shortcodes')) . '",
		asc: "' . esc_js(__('ASC', 'odin_shortcodes')) . '",
		desc: "' . esc_js(__('DESC', 'odin_shortcodes')) . '",
		columns: "' . esc_js(__('Columns', 'odin_shortcodes')) . '",
		hide_empty: "' . esc_js(__('Hide Empty', 'odin_shortcodes')) . '",
		parent_id: "' . esc_js(__('Parent ID', 'odin_shortcodes')) . '",
		category_slug: "' . esc_js(__('Category Slug', 'odin_shortcodes')) . '",
		default: "' . esc_js(__('Default', 'odin_shortcodes')) . '",
		rand: "' . esc_js(__('Random', 'odin_shortcodes')) . '",
		date: "' . esc_js(__('Date', 'odin_shortcodes')) . '",
		price: "' . esc_js(__('Price', 'odin_shortcodes')) . '",
		popularity: "' . esc_js(__('Popularity', 'odin_shortcodes')) . '",
		rating: "' . esc_js(__('Rating', 'odin_shortcodes')) . '",
		title: "' . esc_js(__('Title', 'odin_shortcodes')) . '",
		operator: "' . esc_js(__('Operator', 'odin_shortcodes')) . '",
		in: "' . esc_js(__('IN', 'odin_shortcodes')) . '",
		not_in: "' . esc_js(__('NOT IN', 'odin_shortcodes')) . '",
		and: "' . esc_js(__('AND', 'odin_shortcodes')) . '",
		attribute_slug: "' . esc_js(__('Attribute slug', 'odin_shortcodes')) . '",
		terms_slug: "' . esc_js(__('Terms slug', 'odin_shortcodes')) . '",
		categories_per_page: "' . esc_js(__('Categories Per Page', 'odin_shortcodes')) . '",
		products_per_page: "' . esc_js(__('Products Per Page', 'odin_shortcodes')) . '",
		need_id_or_sku: "' . esc_js(__('You need to use an ID or SKU!', 'odin_shortcodes')) . '",
		need_ids_or_skus: "' . esc_js(__('You need to use an IDs or SKUs!', 'odin_shortcodes')) . '",
		need_category_slug: "' . esc_js(__('You need enter with a category slug!', 'odin_shortcodes')) . '",
		need_attribute_and_terms_slugs: "' . esc_js(__('You need enter with an attribute and terms slugs!', 'odin_shortcodes')) . '"
	}
}});';
    }
}
