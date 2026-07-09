<?php

function listihub_install_required_plugins() {

	$plugins = array(

		array(
			'name'     => esc_html__('Contact Form 7', 'listihub'),
			'slug'     => 'contact-form-7',
			'version'  => '5.8.6',
			'required' => false
		),

		array(
			'name'     => esc_html__('Elementor Page Builder', 'listihub'),
			'slug'     => 'elementor',
			'version'  => '3.18.3',
			'required' => true,
		),

		array(
			'name'     => esc_html__('MC4WP: Mailchimp for WordPress', 'listihub'),
			'slug'     => 'mailchimp-for-wp',
			'version'  => '4.9.11',
			'required' => false,
		),

		array(
			'name'     => esc_html__('One Click Demo Import', 'listihub'),
			'slug'     => 'one-click-demo-import',
			'version'  => '3.0.2',
			'required' => false,
		),

		array(
			'name'     => esc_html__('Listihub Core', 'listihub'),
			'slug'     => 'listihub-core',
			'source'   => get_template_directory(). '/inc/plugins/listihub-core.zip',
			'version'  => '1.0.0',
			'required' => true
		),

		array(
			'name'     => esc_html__('ListFolioPro', 'listihub'),
			'slug'     => 'listfoliopro',
			'source'   => get_template_directory(). '/inc/plugins/listfoliopro.zip',
			'version'  => '1.0.0',
			'required' => true
		),
	);

	$config = array(
		'id'           => 'listihub',
		'parent_slug'  => 'listihub',
		'menu'         => 'listihub-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
		'dismiss_msg'  => '',
		'message'      => '',
		'default_path' => '',
	);

	tgmpa($plugins, $config);
}

add_action('tgmpa_register', 'listihub_install_required_plugins');