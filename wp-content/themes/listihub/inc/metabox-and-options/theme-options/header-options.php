<?php
// Create header Settings section
CSF::createSection( $listihub_theme_option, array(
	'title' => esc_html__( 'Header Settings', 'listihub' ),
	'id'    => 'header_options',
	'icon'  => 'fa fa-header',
) );


CSF::createSection( $listihub_theme_option, array(
	'parent' => 'header_options',
	'title'  => esc_html__( 'Header General', 'listihub' ),
	'icon'   => 'fa fa-credit-card',
	'fields' => array(

		array(
			'id'       => 'site_default_header',
			'type'     => 'image_select',
			'title'    => esc_html__('Header Style', 'listihub'),
			'options'  => array(
				'header-style-one'   => get_theme_file_uri('assets/images/header-one.jpg'),
				'header-style-two'   => get_theme_file_uri('assets/images/header-two.jpg'),
				'header-style-three'   => get_theme_file_uri('assets/images/header-three.jpg'),
				'header-style-four'   => get_theme_file_uri('assets/images/header-four.jpg'),
			),
			'default'  => 'header-style-one',
			'subtitle' => esc_html__('Select site default header style. You can override this settings on individual page / Posts.', 'listihub'),
		),

		array(
			'id'           => 'header_default_logo',
			'type'         => 'media',
			'title'        => esc_html__( 'Header Logo', 'listihub' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Logo', 'listihub' ),
			'desc'         => esc_html__( 'Upload logo image', 'listihub' ),

		),

		array(
			'id'            => 'logo_image_size',
			'type'          => 'dimensions',
			'title'         => esc_html__( 'Logo Image Size', 'listihub' ),
			'output'        => '.site-branding img',
			'width'         => true,
			'height'        => true,
			'desc'          => esc_html__( 'Select logo image size.', 'listihub' ),
		),

		array(
			'id'       => 'sticky_header',
			'type'     => 'switcher',
			'title'    => esc_html__('Enable Sticky Header', 'listihub'),
			'default'  => true,
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Enable / Disable sticky header.', 'listihub'),
		),
	)
) );

// Header Button

CSF::createSection( $listihub_theme_option, array(
	'parent' => 'header_options',
	'title'  => esc_html__( 'Header Buttons', 'listihub' ),
	'icon'   => 'far fa-hand-pointer',
	'fields' => array(

		array(
			'type'       => 'notice',
			'style'      => 'info',
			'content'    => esc_html__( 'Header buttons are not available with selected header style.', 'listihub' ),
			'dependency' => array( 'site_default_header', 'any', 'header-style-one', 'all' ),
		),

		array(
			'id'         => 'enable_header_cta_btn',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable CTA Button', 'listihub' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'listihub' ),
			'text_off'   => esc_html__( 'No', 'listihub' ),
			'desc'       => esc_html__( 'Enable / Disable header CTA button.', 'listihub' ),
			'dependency' => array( 'site_default_header', 'any', 'header-style-two,header-style-three', 'all' ),
		),

		array(
			'id'    => 'header_cta_text',
			'type'  => 'text',
			'title' => esc_html__( 'CTA Button Text', 'listihub' ),
			'default'  => esc_html__( 'Post Your Ad', 'listihub' ),
			'desc'  => esc_html__( 'CTA button text here.', 'listihub' ),
			'dependency' => array( 'site_default_header|enable_header_cta_btn', 'any|==', 'header-style-two,header-style-three|true', 'all' ),
		),

		array(
			'id'    => 'header_cta_url',
			'type'  => 'text',
			'title' => esc_html__( 'CTA Button URL', 'listihub' ),
			'default'  => '#',
			'desc'  => esc_html__( 'CTA button URL here.', 'listihub' ),
			'dependency' => array( 'site_default_header|enable_header_cta_btn', 'any|==', 'header-style-two,header-style-three|true', 'all' ),
		),

		array(
			'id'         => 'enable_header_login',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Enable Login Button', 'listihub' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'listihub' ),
			'text_off'   => esc_html__( 'No', 'listihub' ),
			'desc'       => esc_html__( 'Enable / Disable header login button.', 'listihub' ),
			'dependency' => array( 'site_default_header', 'any', 'header-style-two,header-style-three', 'all' ),
		),

		array(
			'id'    => 'login_url',
			'type'  => 'text',
			'title' => esc_html__( 'Login Button URL', 'listihub' ),
			'default'  => '#',
			'desc'  => esc_html__( 'Login button URL here.', 'listihub' ),
			'dependency' => array( 'site_default_header|enable_header_login', 'any|==', 'header-style-two,header-style-three|true', 'all' ),
		),
	)
) );