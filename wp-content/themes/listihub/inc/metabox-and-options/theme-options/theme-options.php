<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Remove CSF welcome page
add_filter( 'csf_welcome_page', '__return_false' );

/*
 *  Create theme options
 */

$listihub_theme_option = 'listihub_theme_options';

CSF::createOptions($listihub_theme_option, array(
	'framework_title' => wp_kses(
		sprintf(__("listihub Options <small>V %s</small>", 'listihub'), $listihub_theme_data->get('Version')),
		array('small' => array())
	),
	'menu_title'      => esc_html__('Theme Options', 'listihub'),
	'menu_slug'       => 'listihub-options',
	'menu_type'       => 'submenu',
	'menu_parent'     => 'listihub',
	'class'           => 'listihub-theme-option-wrapper',
	'footer_credit'      => wp_kses(
		__( 'Developed by: <a target="_blank" href="#">e-plugins</a>', 'listihub' ),
		array(
			'a'      => array(
				'href'   => array(),
				'target' => array()
			),
		)
	),
	'async_webfont' => false,
	'defaults'        => listihub_default_theme_options(),
));

/*
 * General options
 */
require_once 'general-options.php';

/*
 * Header options
 */
require_once 'typography-options.php';

/*
 * Header options
 */
require_once 'header-options.php';

/*
 * Page options
 */
require_once 'banner-options.php';


/*
 * Page options
 */
require_once 'page-options.php';

/*
 * Page options
 */
require_once 'blog-page-options.php';

/*
 * Post options
 */
require_once 'single-post-options.php';

/*
 * Search Page options
 */
require_once 'search-page-options.php';

/*
 * Error 404 Page options
 */
require_once 'error-page-options.php';

/*
 * Footer options
 */
require_once 'footer-options.php';



// Custom Css section
CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Custom Css', 'listihub' ),
	'id'     => 'custom_css_options',
	'icon'   => 'fa fa-css3',
	'fields' => array(

		array(
			'id'       => 'listihub_custom_css',
			'type'     => 'code_editor',
			'title'    => esc_html__( 'Custom Css', 'listihub' ),
			'settings' => array(
				'theme'  => 'mbo',
				'mode'   => 'css',
			),
			'sanitize' => false,
		),
	)
) );


/*
 * Backup options
 */
CSF::createSection($listihub_theme_option, array(
	'title'  => esc_html__('Backup', 'listihub'),
	'id'     => 'backup_options',
	'icon'   => 'fa fa-window-restore',
	'fields' => array(
		array(
			'type' => 'backup',
		),
	)
));