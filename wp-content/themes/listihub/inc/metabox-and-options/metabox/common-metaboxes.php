<?php
$listihub_common_meta = 'listihub_common_meta';

// Create a metabox
CSF::createMetabox( $listihub_common_meta, array(
	'title'     => esc_html__( 'Settings', 'listihub' ),
	'post_type' => array( 'page', 'post','listihub_team','listihub_service','listihub_project','product' ),
	'data_type' => 'serialize',
) );

// Create layout section
CSF::createSection( $listihub_common_meta, array(
	'title'  => esc_html__( 'Layout Settings ', 'listihub' ),
	'icon'   => 'fa fa-calculator',
	'fields' => array(

		array(
			'id'      => 'layout_meta',
			'type'    => 'select',
			'title'   => esc_html__( 'Layout', 'listihub' ),
			'options' => array(
				'default'       => esc_html__( 'Default', 'listihub' ),
				'left-sidebar'  => esc_html__( 'Left Sidebar', 'listihub' ),
				'full-width'    => esc_html__( 'Full Width', 'listihub' ),
				'right-sidebar' => esc_html__( 'Right Sidebar', 'listihub' ),
			),
			'default' => 'default',
			'desc'    => esc_html__( 'Select layout', 'listihub' ),
		),

		array(
			'id'         => 'sidebar_meta',
			'type'       => 'select',
			'title'      => esc_html__( 'Sidebar', 'listihub' ),
			'options'    => 'listihub_sidebars',
			'dependency' => array( 'layout_meta', '!=', 'full-width' ),
			'desc'       => esc_html__( 'Select sidebar you want to show with this page.', 'listihub' ),
		),
	)
) );

// Create layout section
CSF::createSection( $listihub_common_meta, array(
	'title'  => esc_html__( 'Header Settings ', 'listihub' ),
	'icon'   => 'fa fa-header',
	'fields' => array(

		array(
			'id'      => 'header_meta',
			'type'    => 'select',
			'title'   => esc_html__('Header Style', 'listihub'),
			'options' => array(
				'default'          => esc_html__('Default', 'listihub'),
				'header-style-one' => esc_html__('Header Style One', 'listihub'),
				'header-style-two' => esc_html__('Header Style Two', 'listihub'),
				'header-style-three' => esc_html__('Header Style Three', 'listihub'),
				'header-style-four' => esc_html__('Header Style Four', 'listihub'),
			),
			'default' => 'default',
			'desc'    => esc_html__('Select header style', 'listihub'),
		),

		array(
			'id'           => 'header_logo_meta',
			'type'         => 'media',
			'title'        => esc_html__( 'Header Logo', 'listihub' ),
			'library'      => 'image',
			'url'          => false,
			'button_title' => esc_html__( 'Upload Logo', 'listihub' ),
			'desc'         => esc_html__( 'Upload logo image', 'listihub' ),

		),

		array(
			'id'          => 'main_menu_meta',
			'type'        => 'select',
			'title'       => esc_html__( 'Header Menu', 'listihub' ),
			'options'     => 'menus',
			'placeholder' => esc_html__( 'Default', 'listihub' ),
			'desc'        => esc_html__( 'You can select a different menu for this page from here.', 'listihub' ),
		),
	)
) );

// Create a section
CSF::createSection( $listihub_common_meta, array(
	'title'  => esc_html__( 'Banner Settings', 'listihub' ),
	'icon'   => 'fa fa-flag-o',
	'fields' => array(
		array(
			'id'       => 'enable_banner',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Banner', 'listihub' ),
			'default'  => false,
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable banner.', 'listihub' ),
		),

		array(
			'id'                    => 'banner_background_meta',
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
			'dependency'            => array( 'enable_banner', '==', true ),
			'output'                => '.banner-area.post-banner,.banner-area.page-banner,.banner-area.service-banner,.banner-area.team-banner,.banner-area.project-banner,.banner-area.job-banner',
			'desc'                  => esc_html__( 'Select banner background color and image', 'listihub' ),
		),

		array(
			'id'         => 'hide_banner_title_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Hide Title', 'listihub' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'listihub' ),
				'yes'     => esc_html__( 'Yes', 'listihub' ),
				'no'      => esc_html__( 'No', 'listihub' ),
			),
			'default'    => 'default',
			'desc'       => esc_html__( 'Hide or show banner title.', 'listihub' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),

		array(
			'id'         => 'custom_title',
			'type'       => 'text',
			'title'      => esc_html__( 'Banner Custom Title', 'listihub' ),
			'dependency' => array( 'enable_banner|hide_banner_title_meta', '==|!=', 'true|yes' ),
			'desc'       => esc_html__( 'If you want to use custom title write title here.If you don\'t, leave it empty.', 'listihub' )
		),


		array(
			'id'         => 'hide_banner_breadcrumb_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Hide Breadcrumb', 'listihub' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'listihub' ),
				'yes'     => esc_html__( 'Yes', 'listihub' ),
				'no'      => esc_html__( 'No', 'listihub' ),
			),
			'default'    => 'default',
			'desc'       => esc_html__( 'Hide or show banner breadcrumb.', 'listihub' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),

		array(
			'id'         => 'banner_text_align_meta',
			'type'       => 'button_set',
			'title'      => esc_html__( 'Banner Text Align', 'listihub' ),
			'options'    => array(
				'default' => esc_html__( 'Default', 'listihub' ),
				'start'   => esc_html__( 'Left', 'listihub' ),
				'center' => esc_html__( 'Center', 'listihub' ),
				'end'  => esc_html__( 'Right', 'listihub' ),
			),
			'default'    => 'default',
			'dependency' => array( 'enable_banner', '==', true ),
			'desc'       => esc_html__( 'Select page banner text align.', 'listihub' ),
		),

		array(
			'id'         => 'banner_height_meta',
			'type'       => 'dimensions',
			'title'      => esc_html__( 'Banner Height', 'listihub' ),
			'output'     => '.banner-area.post-banner,.banner-area.page-banner,.banner-area.service-banner,.banner-area.team-banner,.banner-area.project-banner,.banner-area.job-banner',
			'width'      => false,
			'height'     => true,
			'desc'       => esc_html__( 'Select banner height.', 'listihub' ),
			'dependency' => array( 'enable_banner', '==', true ),
		),
	)
) );

// Create Footer section
CSF::createSection( $listihub_common_meta, array(
	'title'  => esc_html__( 'Footer Settings ', 'listihub' ),
	'icon'   => 'fa fa-wordpress',
	'fields' => array(

		array(
			'id'      => 'footer_style_meta',
			'type'    => 'select',
			'title'   => esc_html__( 'Select Footer Style', 'listihub' ),
			'options' => array(
				'default'       => esc_html__( 'Default', 'listihub' ),
				'footer-style-one'  => esc_html__( 'Footer Style One', 'listihub' ),
				'footer-style-two'    => esc_html__( 'Footer Style Two', 'listihub' ),
			),
			'default' => 'default',
			'desc'    => esc_html__( 'Select Footer Style', 'listihub' ),
		),
	),
) );