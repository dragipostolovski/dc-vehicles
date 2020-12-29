<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://linkedin.com/in/dragipostolovski
 * @since      1.0.0
 *
 * @package    Dc_Vehicles
 * @subpackage Dc_Vehicles/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dc_Vehicles
 * @subpackage Dc_Vehicles/includes
 * @author     Dragi Postolovski <dpostolovskimk@gmail.com>
 */
class Dc_Vehicles_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dc-vehicles',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
