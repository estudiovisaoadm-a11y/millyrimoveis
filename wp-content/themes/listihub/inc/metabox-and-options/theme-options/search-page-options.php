<?php
//Search Options

CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Search Page', 'listihub' ),
	'id'     => 'search_page_options',
	'icon'   => 'fa fa-search',
	'fields' => array(

		array(
			'id'      => 'search_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Search Layout', 'listihub' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'listihub' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'listihub' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'listihub' ),
				'grid'          => esc_html__( 'Grid Full', 'listihub' ),
				'grid-ls'       => esc_html__( 'Grid With Left Sidebar', 'listihub' ),
				'grid-rs'       => esc_html__( 'Grid With Right Sidebar', 'listihub' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select search page layout.', 'listihub' ),
		),

		array(
			'id'       => 'search_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Search Banner', 'listihub' ),
			'default'  => false,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable search page banner.', 'listihub' ),
		),

		array(
			'id'                    => 'search_banner_background_options',
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
			'dependency'            => array( 'search_banner', '==', true ),
			'output'                => '.banner-area.search-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for search page then select search page banner background options from here.', 'listihub' ),
		),

		array(
			'id'    => 'search_placeholder',
			'type'  => 'text',
			'title' => esc_html__( 'Search Field Placeholder', 'listihub' ),
			'desc'  => esc_html__( 'Type search placeholder here.', 'listihub' ),
		),
	)
) );