<?php
 
/**
 * Plugin Name: HB Engine
 * Plugin URI: https://hestabit.in/
 * Description:  This plugin is the heart of HB framework.
 * Version: 1.0.0-beta.1
 * Author: Naveen Sharma
 * Author URI: https://hestabit.in/
 * Requires at least: 5.4
 * Tested up to: 5.6
 * Requires PHP: 7.0
 * Text Domain: wp-hbf-engine
 * Domain Path: /languages/
 * License: GPL2+
 *
 * @package wp-hbf-engine
 */

if ( ! defined( 'ABSPATH' ) ) {
   exit;
}

if(!function_exists( 'd') ) :

   function d( $data ) {
      echo '<pre>', print_r( $data ), '</pre>';
   }

endif;

//hbf autoloader
function hbf_autoloader( $prefix, $dir ) {
    spl_autoload_register( function( $class ) use ( $prefix, $dir ) {
        $base_dir = $dir . '/src/';

        $len = strlen( $prefix );
      
        if ( strncmp($prefix, $class, $len) !== 0 ) {
            return;
        }

        $relative_class = substr( $class, $len );
 
        $file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
     
        // if the file exists, require it
        if ( file_exists( $file ) ) {
            require $file;
        }
    });
}

hbf_autoloader( 'HBF\Engine\\', __DIR__ );

function HBF() {
   return HBF\Engine\Boot::instance();
}

HBF()->config->set( "HBF_ENGINE", "hbf-engine" );
HBF()->config->set( "HBF_ENGINE_VERSION", "1.0.0-beta.1" );



