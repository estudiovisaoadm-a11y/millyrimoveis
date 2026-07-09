<?php
//Single Post

CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Single Post / Post Details', 'listihub' ),
	'id'     => 'single_post_options',
	'icon'   => 'fa fa-pencil',
	'fields' => array(

		array(
			'id'      => 'single_post_default_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Layout', 'listihub' ),
			'options' => array(
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'listihub' ),
				'full-width'    => esc_html__( 'Full Width', 'listihub' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'listihub' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select single post layout', 'listihub' ),
		),


		array(
			'id'         => 'single_post_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'listihub' ),
			'options'    => 'listihub_sidebars',
			'default' => 'listihub-sidebar',
			'dependency' => array( 'single_post_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all posts. You can override this settings on individual post.', 'listihub' ),
		),

		array(
			'id'      => 'hide_single_post_banner_title',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Post Banner Title', 'listihub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'listihub' ),
				'no'  => esc_html__( 'No', 'listihub' ),
			),
			'default' => 'no',
			'desc'    => esc_html__( 'Hide banner title. You can change this settings on individual post.', 'listihub' ),
		),

		array(
			'id'       => 'show_post_default_title',
			'type'     => 'switcher',
			'title'    => esc_html__('Show Post Title On Banner?', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Show post title on single post banner area. Default title is "Blog" for all single post.', 'listihub'),
			'default'  => false,
			'dependency' => array( 'hide_single_post_banner_title', '==', 'no' ),
		),

		array(
			'id'         => 'post_banner_title',
			'type'       => 'text',
			'title'      => esc_html__('Banner Default Title', 'listihub'),
			'desc'       => esc_html__('Default banner title for all post.', 'listihub'),
			'dependency' => array( 'show_post_default_title|hide_single_post_banner_title', '==|==', 'false|no' ),
		),

		array(
			'id'      => 'hide_single_post_breadcrumb',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Hide Post Breadcrumb', 'listihub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'listihub' ),
				'no'  => esc_html__( 'No', 'listihub' ),
			),
			'default' => 'yes',
			'desc'    => esc_html__( 'Show / Hide Post breadcrumb. You can change this settings on individual post.', 'listihub' ),
		),

		array(
			'id'       => 'single_post_author',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Author Name', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show author name on post details page.', 'listihub'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_date',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Date', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show date on post details page.', 'listihub'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_cmnt',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Comments Number', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show comments number on post details page.', 'listihub'),
			'default'  => true,
		),

		array(
			'id'       => 'single_post_cat',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Categories', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show categories on post details page.', 'listihub'),
			'default'  => true
		),

		array(
			'id'       => 'single_post_tag',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Tags', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show tags on post details page.', 'listihub'),
			'default'  => true
		),

		array(
			'id'       => 'post_share',
			'type'     => 'switcher',
			'title'    => esc_html__('Post Share icons', 'listihub'),
			'text_on'  => esc_html__('Yes', 'listihub'),
			'text_off' => esc_html__('No', 'listihub'),
			'desc'     => esc_html__('Hide or show social share icons on post details page.', 'listihub'),
			'default'  => true
		),
	)
) );