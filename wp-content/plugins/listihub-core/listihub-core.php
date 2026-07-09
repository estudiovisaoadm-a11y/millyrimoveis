<?php
/*
Plugin Name: Listihub Core
Author: e-plugins
Author URI: http://e-plugins.com/
Version: 1.0.0
Description: This plugin is required for Listihub WordPress theme
Text Domain: listihub-core
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LISTIHUB_CORE_VERSION', '1.0.0' );

define( 'LISTIHUB_CORE', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) .'/');

/*
 * Translate direction
 */
load_plugin_textdomain( 'listihub-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*
 * HiJobs core functions
 */
require_once( 'inc/listihub-core-functions.php' );

/*
 *  Add CSF
 */

require_once('inc/library/codestar-framework/codestar-framework.php' );

/*
 * Register Custom Widget
 */

require_once('inc/widgets/custom-wp-widgets.php' );