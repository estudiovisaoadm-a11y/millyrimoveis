<?php

// Create blog page options
CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Blog Page', 'listihub' ),
	'id'     => 'blog_page_options',
	'icon'   => 'fa fa-pencil-square-o',
	'fields' => array(

		array(
			'id'      => 'blog_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Blog Layout', 'listihub' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'listihub' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'listihub' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'listihub' ),
				'grid'          => esc_html__( 'Grid Full', 'listihub' ),
				'grid-ls'       => esc_html__( 'Grid With Left Sidebar', 'listihub' ),
				'grid-rs'       => esc_html__( 'Grid With Right Sidebar', 'listihub' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select blog page layout.', 'listihub' ),
		),

		array(
			'id'       => 'blog_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Blog Banner', 'listihub' ),
			'default'  => false,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable blog page banner.', 'listihub' ),
		),

		array(
			'id'                    => 'blog_banner_background_options',
			'type'                  => 'background',
			'title'                 => esc_html__( 'Banner Background', 'listihub' ),
			'background_gradient'   => true,
			'background_origin'     => false,
			'background_clip'       => false,
			'background_blend-mode' => false,
			'background_attachment' => false,
			'background_size'       => false,
			'background_position'   => false,
			'background_repeat'     => false,
			'dependency'            => array( 'blog_banner', '==', true ),
			'output'                => '.banner-area.blog-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for blog page then select blog page banner background Options from here.', 'listihub' ),
		),

		array(
			'id'       => 'enable_blog_banner_title',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner Title', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Hide / Show blog banner title.', 'listihub' ),
			'dependency' => array( 'blog_banner', '==', true ),
		),

		array(
			'id'         => 'blog_title',
			'type'       => 'text',
			'title'      => esc_html__( 'Banner Title', 'listihub' ),
			'desc'       => esc_html__( 'Type blog banner title here.', 'listihub' ),
			'dependency' => array( 'blog_banner|enable_blog_banner_title', '==|==', 'true|true' ),
		),

		array(
			'id'       => 'enable_blog_banner_breadcrumb',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner Breadcrumb', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Hide / Show blog banner title.', 'listihub' ),
			'dependency' => array( 'blog_banner', '==', true ),
		),

		array(
			'id'       => 'post_author',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Author Name', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Hide / Show post author name.', 'listihub' ),
		),

		array(
			'id'       => 'post_date',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Post Date', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Hide / Show post date.', 'listihub' ),
		),

		array(
			'id'         => 'cmnt_number',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Show Comment Number', 'listihub' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'listihub' ),
			'text_off'   => esc_html__( 'No', 'listihub' ),
			'desc'       => esc_html__( 'Hide / Show post comment number.', 'listihub' ),
			'dependency' => array( 'blog_layout', 'any', 'full-width,right-sidebar,left-sidebar' ),
		),

		array(
			'id'         => 'show_category',
			'type'       => 'switcher',
			'title'      => esc_html__( 'Show Category Name', 'listihub' ),
			'default'    => true,
			'text_on'    => esc_html__( 'Yes', 'listihub' ),
			'text_off'   => esc_html__( 'No', 'listihub' ),
			'desc'       => esc_html__( 'Hide / Show post category name.', 'listihub' ),
			'dependency' => array( 'blog_layout', 'any', 'full-width,right-sidebar,left-sidebar' ),
		),

		array(
			'id'       => 'read_more_button',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Show Read More Button', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Hide / Show post read more button.', 'listihub' ),
		),

		array(
			'id'         => 'blog_read_more_text',
			'type'       => 'text',
			'title'      => esc_html__( 'Read More Button Text', 'listihub' ),
			'desc'       => esc_html__( 'Type blog read more button here.', 'listihub' ),
			'dependency' => array( 'read_more_button', '==', true ),
		),
	)
) );