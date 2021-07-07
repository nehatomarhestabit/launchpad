<?php
/**
 * Plugin Name: HBF Form Addon
 * Plugin URI: https://hestabit.in/
 * Description:  This plugin is the addon for HB framework.
 * Version: 1.0.0-beta.1
 * Author: Naveen Sharma
 * Author URI: https://hestabit.in/
 * Requires at least: 5.4
 * Tested up to: 5.6
 * Requires PHP: 7.0
 * Text Domain: wp-hbf-form-addon
 * Domain Path: /languages/
 * License: GPL2+
 *
 * @package wp-hbf-engine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

add_action( 'plugins_loaded', function( ){

	if ( ! class_exists( 'HBF\Engine\Boot' ) || ! defined( 'HBF_ENGINE_VERSION' )  ) {
		return;
	}

	hbf_autoloader( 'HBF\Form\\', __DIR__ );

	HBF()->config->set("HBF_FORM_VERSION", '1.0.0-beta.1' );
	HBF()->config->set("HBF_FORM", 'hbf-form-addon' );
	
	HBF()->repository->set("form", HBF\Form\Form::instance() ); 

}, 10 );

add_action( 'admin_notices', function( ) {
	if ( ! class_exists( 'HBF\Engine\Boot' ) || ! defined( 'HBF_ENGINE_VERSION' ) ) {
		$screen = get_current_screen();
		if ( null !== $screen && 'plugins' === $screen->id ) {
			echo '<div class="error">';
			 	_e( '<em>HBF Form Addon</em> requires HB Engine to be installed and activated.', 'hbf-form-addon' );
			echo '</div>';
		}
	} 
} );
 
