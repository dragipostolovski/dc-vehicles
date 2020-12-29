<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://linkedin.com/in/dragipostolovski
 * @since             1.0.0
 * @package           Dc_Vehicles
 *
 * @wordpress-plugin
 * Plugin Name:       dc-vehicles
 * Plugin URI:        http://linkedin.com/in/dragipostolovski
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Dragi Postolovski
 * Author URI:        http://linkedin.com/in/dragipostolovski
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dc-vehicles
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DC_VEHICLES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dc-vehicles-activator.php
 */
function activate_dc_vehicles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dc-vehicles-activator.php';
	Dc_Vehicles_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dc-vehicles-deactivator.php
 */
function deactivate_dc_vehicles() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dc-vehicles-deactivator.php';
	Dc_Vehicles_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dc_vehicles' );
register_deactivation_hook( __FILE__, 'deactivate_dc_vehicles' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dc-vehicles.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dc_vehicles() {

	$plugin = new Dc_Vehicles();
	$plugin->run();

}
run_dc_vehicles();
