<?php
// Create Footer section

CSF::createSection( $listihub_theme_option, array(
	'title' => esc_html__( 'Footer Settings', 'listihub' ),
	'id'    => 'all_footer_options',
	'icon'  => 'fa fa-wordpress',
) );

CSF::createSection( $listihub_theme_option, array(
	'parent' => 'all_footer_options',
	'title'  => esc_html__( 'Footer Options', 'listihub' ),
	'id'     => 'footer_options',
	'icon'   => 'fa fa-wordpress',
	'fields' => array(
		array(
			'id'       => 'site_default_footer',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Footer Style', 'listihub' ),
			'options'  => array(
				'footer-style-one' => get_theme_file_uri( 'assets/images/footer-1.jpg' ),
				'footer-style-two' => get_theme_file_uri( 'assets/images/footer-2.jpg' ),
				'footer-style-three' => get_theme_file_uri( 'assets/images/footer-3.jpg' ),
			),
			'default'  => 'footer-style-one',
			'subtitle' => esc_html__( 'Select site default footer style. You can override this settings on individual page / Posts.', 'listihub' ),
		),

		array(
			'id'       => 'enable_footer_cta',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Footer CTA', 'listihub' ),
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable footer CTA.', 'listihub' ),
			'default'  => false,
		),

		array(
			'id'            => 'footer_cta_title',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Footer CTA Title', 'listihub' ),
			'desc'          => esc_html__( 'Type footer CTA title text here.', 'listihub' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
			'dependency'  => array( 'enable_footer_cta', '==', true ),
		),

		array(
			'id'            => 'footer_cta_desc',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Footer CTA Description', 'listihub' ),
			'desc'          => esc_html__( 'Type footer CTA description text here.', 'listihub' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
			'dependency' => array( 'enable_footer_cta|site_default_footer', '==|any', 'true|footer-style-two', 'all' ),
		),

		array(
			'id'    => 'footer_cta_btn_text',
			'type'  => 'text',
			'title' => esc_html__( 'CTA Button Text', 'listihub' ),
			'default'  => esc_html__( 'Post Your Ad Now', 'listihub' ),
			'desc'  => esc_html__( 'CTA button text here.', 'listihub' ),
			'dependency'  => array( 'enable_footer_cta', '==', true ),
		),

		array(
			'id'    => 'footer_cta_btn_url',
			'type'  => 'text',
			'title' => esc_html__( 'CTA Button URL', 'listihub' ),
			'default'  => '#',
			'desc'  => esc_html__( 'CTA button URL here.', 'listihub' ),
			'dependency'  => array( 'enable_footer_cta', '==', true ),
		),

		array(
			'id'           => 'footer_cta_image',
			'type'         => 'media',
			'title'        => esc_html__( 'CTA Image', 'listihub' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Image', 'listihub' ),
			'desc'         => esc_html__( 'Upload footer CTA image', 'listihub' ),
			'dependency' => array( 'enable_footer_cta|site_default_footer', '==|any', 'true|footer-style-two', 'all' ),

		),

		array(
			'id'                    => 'cta_area_background',
			'type'                  => 'background',
			'title'                 => esc_html__( 'CTA Area Background', 'listihub' ),
			'background_gradient'   => false,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => true,
			'background_size'       => true,
			'background_position'   => true,
			'background_repeat'     => true,
			'output'                => '.footer-style-one .footer-cta-area,.footer-style-two .footer-cta-area',
			'desc'                  => esc_html__( 'Select footer CTA area background color and image.', 'listihub' ),
			'dependency'  => array( 'enable_footer_cta', '==', true ),
		),

		array(
			'id'      => 'footer_widget_column',
			'type'    => 'select',
			'title'   => esc_html__( 'Widget Column', 'listihub' ),
			'desc'    => esc_html__( 'Select widget area column number.', 'listihub' ),
			'options' => array(
				'col-lg-12' => esc_html__( '1 Column', 'listihub' ),
				'col-lg-6'  => esc_html__( '2 Column', 'listihub' ),
				'col-lg-4'  => esc_html__( '3 Column', 'listihub' ),
				'col-lg-3'  => esc_html__( '4 Column', 'listihub' ),
			),
			'default' => 'col-lg-3',
		),

		array(
			'id'                    => 'widget_area_background',
			'type'                  => 'background',
			'title'                 => esc_html__( 'Widget Area Background', 'listihub' ),
			'background_gradient'   => false,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => true,
			'background_size'       => true,
			'background_position'   => true,
			'background_repeat'     => true,
			'output'                => '.footer-widget-area,.footer-style-two .footer-widget-area',
			'desc'                  => esc_html__( 'Select footer widget area background color and image.', 'listihub' ),
		),


		array(
			'id'                    => 'footer_bottom_background',
			'type'                  => 'background',
			'title'                 => esc_html__( 'Bottom Area Background', 'listihub' ),
			'background_gradient'   => false,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => true,
			'background_size'       => true,
			'background_position'   => true,
			'background_repeat'     => true,
			'output'                => '.footer-bottom-area,.footer-style-two .footer-bottom-area',
			'desc'                  => esc_html__( 'Select footer bottom area background color and image.', 'listihub' ),
		),

		array(
			'id'            => 'footer_info_left_text',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Footer Info Left Text', 'listihub' ),
			'desc'          => esc_html__( 'Type footer info left text here.', 'listihub' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
		),

		array(
			'id'            => 'copyright_text',
			'type'          => 'wp_editor',
			'title'         => esc_html__( 'Copyright Text', 'listihub' ),
			'desc'          => esc_html__( 'Type site copyright text here.', 'listihub' ),
			'tinymce'       => true,
			'quicktags'     => true,
			'media_buttons' => false,
			'height'        => '100px',
		),

		array(
			'id'       => 'go_to_top_button',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Go Top Button', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable go to top button.', 'listihub' ),
		),
	)
) );