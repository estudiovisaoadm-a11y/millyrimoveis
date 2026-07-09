<?php
//Archive Options

CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Archive Page', 'listihub' ),
	'id'     => 'archive_page_options',
	'icon'   => 'fa fa-file-archive-o',
	'fields' => array(
		array(
			'id'      => 'archive_layout',
			'type'    => 'select',
			'title'   => esc_html__( 'Archive Layout', 'listihub' ),
			'options' => array(
				'full-width'    => esc_html__( 'Full Width', 'listihub' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'listihub' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'listihub' ),
				'grid'          => esc_html__( 'Grid Full', 'listihub' ),
				'grid-ls'       => esc_html__( 'Grid With Left Sidebar', 'listihub' ),
				'grid-rs'       => esc_html__( 'Grid With Right Sidebar', 'listihub' ),
			),
			'default' => 'right-sidebar',
			'desc'    => esc_html__( 'Select archive page layout.', 'listihub' ),
		),

		array(
			'id'       => 'archive_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Archive Banner', 'listihub' ),
			'default'  => true,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable archive page banner.', 'listihub' ),
		),

		array(
			'id'                    => 'archive_banner_background_options',
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
			'dependency'            => array( 'archive_banner', '==', true ),
			'output'                => '.banner-area.archive-banner',
			'desc'                  => esc_html__( 'If you want different banner background settings for archive page then select archive page banner background Options from here.', 'listihub' ),
		),
	)
) );