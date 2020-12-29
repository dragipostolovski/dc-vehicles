<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://linkedin.com/in/dragipostolovski
 * @since      1.0.0
 *
 * @package    Dc_Vehicles
 * @subpackage Dc_Vehicles/admin/partials
 */

if ( ! function_exists( 'vehicles_custom_posts' ) ) :
	function vehicles_custom_posts() {

		/* Portfolio Custom Post*/
		$portfolio_label = array(
			'name' => esc_html_x('Vehicles', 'Post Type General Name', 'dc-vehicles'),
			'singular_name' => esc_html_x('Vehicle', 'Post Type Singular Name', 'dc-vehicles'),
			'menu_name' => esc_html__('Vehicle', 'intrinsic'),
			'parent_item_colon' => esc_html__('Parent Vehicle:', 'dc-vehicles'),
			'all_items' => esc_html__('All Vehicle', 'dc-vehicles'),
			'view_item' => esc_html__('View Vehicle', 'dc-vehicles'),
			'add_new_item' => esc_html__('Add New Vehicle', 'dc-vehicles'),
			'add_new' => esc_html__('New Vehicle', 'dc-vehicles'),
			'edit_item' => esc_html__('Edit Vehicle', 'dc-vehicles'),
			'update_item' => esc_html__('Update Vehicle', 'dc-vehicles'),
			'search_items' => esc_html__('Search Vehicle', 'dc-vehicles'),
			'not_found' => esc_html__('No vehicle found', 'dc-vehicles'),
			'not_found_in_trash' => esc_html__('No vehicle found in Trash', 'dc-vehicles'),
		);
		$portfolio_args = array(
			'label' => esc_html__('Vehicle', 'dc-vehicles'),
			'description' => esc_html__('Vehicle', 'dc-vehicles'),
			'labels' => $portfolio_label,
			'supports' => array('title', 'thumbnail', 'editor'),
			'taxonomies' => array('locations'),
			'hierarchical' => true,
			'show_in_rest' => true,
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 20,
			'menu_icon' => 'dashicons-screenoptions',
			'can_export' => true,
			'has_archive' => true,
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'capability_type' => 'page',
			'rewrite' => array('slug' => 'vehicle'),
		);
		register_post_type('vehicle', $portfolio_args);

		// Add new taxonomy, make it hierarchical (like categories)
		$portfolio_cat_taxonomy_labels = array(
			'name'              => esc_html__( 'Locations','dc-vehicles' ),
			'singular_name'     => esc_html__( 'Locations','dc-vehicles' ),
			'search_items'      => esc_html__( 'Search Location','dc-vehicles' ),
			'all_items'         => esc_html__( 'All Location','dc-vehicles' ),
			'parent_item'       => esc_html__( 'Parent Location','dc-vehicles' ),
			'parent_item_colon' => esc_html__( 'Parent Location:','dc-vehicles' ),
			'edit_item'         => esc_html__( 'Edit Location','dc-vehicles' ),
			'update_item'       => esc_html__( 'Update Location','dc-vehicles' ),
			'add_new_item'      => esc_html__( 'Add New Location','dc-vehicles' ),
			'new_item_name'     => esc_html__( 'New Location Name','dc-vehicles' ),
			'menu_name'         => esc_html__( 'Location','dc-vehicles' ),
		);

		// Now register the portfolio taxonomy
		register_taxonomy('locations', 'vehicle', array(
			'hierarchical' => true,
			'labels' => $portfolio_cat_taxonomy_labels,
			'query_var' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'locations' ),
		));
	}
endif;
add_action('init', 'vehicles_custom_posts', 9);

/**
 * Add a meta box custom field for pages and posts / related links text.
 */
function dc_price_meta_box()
{
    add_meta_box(
        'dc-price',
        __( 'Price', 'dc-vehicles' ),
        'dc_price_meta_box_callback',
        'vehicle'
    );
}
add_action('add_meta_boxes', 'dc_price_meta_box');

function dc_price_meta_box_callback($post)
{
	// Add a nonce field so we can check for it later.
	wp_nonce_field('dc_price_nonce', 'dc_price_nonce');
	$price = get_post_meta($post->ID, '_dc_price', true);
    $currency = get_post_meta($post->ID, '_dc_currency', true); ?>

	<label for="dc_price">Price</label>
    <input type="text" style="width:100%" id="dc_price" name="dc_price" value="<?= esc_attr($price) ?>">

    <label for="dc_currency">Currency</label>
    <select style="width:100%" id="dc_currency" name="dc_currency">
        <option value=""></option>
        <option <?php selected( $currency, 'eur' ); ?> value="eur">€</option>
        <option <?php selected( $currency, 'usd' ); ?> value="usd">$</option>
    </select>
    <?php
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_dc_price_meta_box_data($post_id)
{

	// Check if our nonce is set.
	if (! isset($_POST['dc_price_nonce'])) {
		return;
	}

	// Verify that the nonce is valid.
	if (! wp_verify_nonce($_POST['dc_price_nonce'], 'dc_price_nonce')) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Check the user's permissions.
	if ( isset($_POST['post_type']) && 'vehicle' == $_POST['post_type'] ) {
		if (! current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if (! current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if (! isset($_POST['dc_price'])) {
		return;
	}

	if (! isset($_POST['dc_currency'])) {
		return;
	}

	// Sanitize user input.
	$price = sanitize_text_field($_POST['dc_price']);
	$currency = $_POST['dc_currency'];

	// Update the meta field in the database.
	update_post_meta($post_id, '_dc_price', $price);
	update_post_meta($post_id, '_dc_currency', $currency);
}
add_action('save_post', 'save_dc_price_meta_box_data');

?>