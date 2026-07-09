<?php
// Create typography section
CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'Typography', 'listihub' ),
	'id'     => 'typography_options',
	'icon'   => 'fa fa-text-width',
	'fields' => array(

		array(
			'id'             => 'body_typo',
			'type'           => 'typography',
			'title'          => esc_html__( 'Body Font', 'listihub' ),
			'desc'           => esc_html__( 'Select primary ( body ) typography.', 'listihub' ),
			'output'         => 'body',
			'text_align'     => false,
			'text_transform' => false,
			'color'          => true,
			'extra_styles'   => true,
			'default'        => array(
				'font-family'  => 'Manrope',
				'type'         => 'google',
				'unit'         => 'px',
				'font-weight'  => '400',
				'extra-styles' => array('300','400','500'),
			),

		),

		array(
			'id'             => 'heading_typo',
			'type'           => 'typography',
			'title'          => esc_html__( 'Heading Font', 'listihub' ),
			'desc'           => esc_html__( 'Select Secondary ( heading & bold ) typography.', 'listihub' ),
			'output'         => 'h1,h2,h3,h4,h5,h6,.widget.widget_rss ul li a',
			'text_align'     => false,
			'text_transform' => false,
			'color'          => false,
			'extra_styles'   => true,
			'default'        => array(
				'font-family'  => 'Manrope',
				'type'         => 'google',
				'unit'         => 'px',
				'font-weight'  => '700',
				'extra-styles' => array('500','600','700'),
			),
		),
	),
) );