<?php

// Create Page Options
CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Page Options', 'listihub' ),
	'id'     => 'page_options',
	'icon'   => 'fa fa-file-text-o',
	'fields' => array(
		array(
			'id'      => 'page_default_layout',
			'type'    => 'select',
			'title'   => esc_html__('Page Layout', 'listihub'),
			'options' => array(
				'full-width'  => esc_html__('Full Width', 'listihub'),
				'left-sidebar'  => esc_html__('Left Sidebar', 'listihub'),
				'right-sidebar' => esc_html__('Right Sidebar', 'listihub'),
			),
			'default' => 'full-width',
			'desc'    => esc_html__('Select page layout.', 'listihub'),
		),

		array(
			'id'         => 'page_default_sidebar',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'listihub' ),
			'options'    => 'listihub_sidebars',
			'default' => 'listihub-sidebar',
			'dependency' => array( 'page_default_layout', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select default sidebar for all pages. You can override this settings on individual page.', 'listihub' ),
		),
	)
) );