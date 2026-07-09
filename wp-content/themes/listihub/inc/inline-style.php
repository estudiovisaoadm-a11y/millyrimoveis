<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function listihub_inline_style() {

	wp_enqueue_style('listihub-inline-style', get_theme_file_uri('assets/css/inline-style.css'), array(), LISTIHUB_VERSION, 'all');

	$listihub_inline_css = '
        .elementor-inner {margin-left: -10px;margin-right: -10px;}.elementor-inner .elementor-section-wrap > section:first-of-type .elementor-editor-element-settings,.elementor-section-wrap > .elementor-element:first-of-type:not(:hover):not(.elementor-element-editable)>.elementor-element-overlay .elementor-editor-element-settings {display: block !important;}.elementor-inner .elementor-section-wrap > section:first-of-type .elementor-editor-element-settings li,.elementor-edit-area-active .elementor-editor-element-setting {display: inline-block !important;}.elementor-editor-active .elementor-editor-element-setting{height: 25px;line-height: 25px;text-align: center;}.elementor-section.elementor-section-boxed>.elementor-container {max-width: 1320px !important;}.elementor-section-stretched.elementor-section-boxed .elementor-row{padding-left: 5px;padding-right: 5px;}.elementor-section-stretched.elementor-section-boxed .elementor-container.elementor-column-gap-extended {margin-left: auto;margin-right: auto;}
    ';

	$logo_image_size = listihub_option('logo_image_size');
	if(!empty($logo_image_size['width'])){
		$listihub_inline_css .='
			.site-branding img {
			    max-width: inherit;
			}
		';
	}

	$custom_css = listihub_option('listihub_custom_css');

	$listihub_inline_css .= ''.$custom_css.'';

	wp_add_inline_style('listihub-inline-style', $listihub_inline_css);
}

add_action('wp_enqueue_scripts', 'listihub_inline_style');