<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function listihub_default_theme_options() {
	return array(
		'footer_cta_title' => wp_kses(
			__('<h4>Ready to Start your business?</h4>', 'listihub'), listihub_allow_html()

		),
		'footer_cta_desc' => wp_kses(
			__('Haven\'t had a chance to explore the latest real estate offerings for a whole 5 minutes! We should catch up on the market trends and see what exciting properties are available in this listihib.', 'listihub'), listihub_allow_html()

		),
		'copyright_text' => wp_kses(
			__('&copy; Listihub 2024 | All Right Reserved', 'listihub'), listihub_allow_html()

		),

		'footer_info_left_text' => wp_kses(
			__('Listihub | Developed by: <a target="_blank" href="http://e-plugins.com/">e-plugins</a>', 'listihub'), listihub_allow_html()

		),

		'not_found_text' => wp_kses(
			__('<h2>Oops!</h2><p>Sorry, The page you are looking for no longer exists.</p>', 'listihub'), listihub_allow_html()
		),

		'post_banner_title'   => esc_html__('Blog', 'listihub'),
		'blog_title'          => esc_html__('Blog', 'listihub'),
		'blog_read_more_text' => esc_html__('Read More', 'listihub'),
		'error_page_title'    => esc_html__('Error 404', 'listihub'),
		'search_placeholder'  => esc_html__('Search...', 'listihub'),
		'cta_text'            => esc_html__('Contact Us', 'listihub'),
	);
}