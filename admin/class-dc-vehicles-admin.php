<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://linkedin.com/in/dragipostolovski
 * @since      1.0.0
 *
 * @package    Dc_Vehicles
 * @subpackage Dc_Vehicles/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dc_Vehicles
 * @subpackage Dc_Vehicles/admin
 * @author     Dragi Postolovski <dpostolovskimk@gmail.com>
 */
class Dc_Vehicles_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_cpt();
		add_filter( 'page_template', array($this, 'oglasi_page_template' ));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dc_Vehicles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dc_Vehicles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dc-vehicles-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dc_Vehicles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dc_Vehicles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dc-vehicles-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function load_cpt()
	{
		require plugin_dir_path(__FILE__) . 'partials/dc-vehicles-cpt.php';
	}

	public function oglasi_page_template( $page_template )
	{
		if ( is_page( 'oglasi' ) ) {
			$page_template = dirname( __FILE__ ) . '/templates/oglasi.php';
		}
		return $page_template;
	}
}
