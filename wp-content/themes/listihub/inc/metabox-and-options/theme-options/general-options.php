<?php

// Create general section
CSF::createSection( $listihub_theme_option, array(
	'title'  => esc_html__( 'General Options', 'listihub' ),
	'id'     => 'general_options',
	'icon'   => 'fa fa-google',
	'fields' => array(
		array(
			'id'       => 'theme_primary_color',
			'type'     => 'color',
			'title'    => esc_html__( 'Primary Color', 'listihub' ),
			'desc'     => esc_html__( 'Select theme primary color. Few colors not change from here. You can change them from individual Elementor widget.', 'listihub' ),
			'output'   => array(
				'color' => 'a:hover,.main-navigation ul li a:hover,.main-navigation ul li.current-menu-item > a, .main-navigation ul li.current_page_item > a,.main-navigation ul li.current-menu-ancestor > a,.main-navigation ul li.current_page_ancestor > a,.main-navigation ul ul li a:hover,.main-navigation ul ul li.current-menu-item > a,.main-navigation ul ul li.current_page_item > a, .main-navigation ul ul li.current-menu-ancestor > a,.main-navigation ul ul li.current_page_ancestor > a,.sticky .post-content-wrapper:before,.post-meta li i, .post-meta li a:hover,.ep-text-button,.sidebar-widget-area .widget .wp-block-categories li a:hover,.widget.widget_block a.wp-block-latest-comments__comment-author:hover,.sidebar-widget-area .widget.widget_archive li:hover a,.sidebar-widget-area .widget.widget_archive li:hover .post-count-number,.sidebar-widget-area .widget.widget_categories a:hover + .post-count-number,.sidebar-widget-area .widget .cat-item a:hover + .post-count-number,.sidebar-widget-area .widget.widget_pages li a:hover,.sidebar-widget-area .widget.widget_meta li a:hover,.sidebar-widget-area .widget.widget_nav_menu li a:hover,.widget.widget_rss .rss-date,.widget.widget_rss cite,.content-area button[type="submit"].search-submit, .widget.widget_search button[type="submit"],.comments-area .reply a:hover,.comment-metadata time,.wp-block-search button.wp-block-search__button:hover,.widget form.search-form button[type="submit"]:hover,.post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link,.post-details-wrapper .wp-block-search .wp-block-search__button,.comment-author.vcard .fn a:hover,.ep-recent-widget-date a,.ep-recent-widget-date i,.bypostauthor .comment-author.vcard .fn:after,.single-listing-item .star-icon,.single-listing-item .listfoliopro-listing-price,.single-listing-item .listing-location, .single-listing-item .listing-location a,.single-listing-two-item .star-icon,.single-listing-two-item .listing-location, .single-listing-two-item .listing-location a, .single-listing-two-item .listing-location a:hover,.single-listing-two-item .listfoliopro-listing-price, .single-listing-two-item .listfoliopro-discount-price,.listfoliopro-listing-item .first-category-and-rating .star-icon,.listfoliopro-listing-item .location, .listfoliopro-listing-item .location a, .listfoliopro-listing-item .location-date-wrapper .location a:hover,.listfoliopro-listing-item .location-date-wrapper .location, .listfoliopro-listing-item .location-date-wrapper .location a, .listfoliopro-listing-item .location-date-wrapper .location a:hover,.listfoliopro-listing-item .listfoliopro-listing-price .listfoliopro-discount-price,.leaflet-popup-content-wrapper .leaflet-popup-content .card-text,.widget-social-icons li a:hover,.single-listing-title a.single-listing-pdf-button:hover,.single-listing-main-wrapper .single-listing-review-star i,.single-listing-main-wrapper .listfoliopro-discount-price,.single-listing-main-wrapper .saved-percentage,.listing-company-info-wrapper .company-location i, .listing-company-info-wrapper .company-location a,.listing-company-info-wrapper .company-social-wrapper ul li a:hover,.title-with-text-subtitle,.ep-video-image .ep-video-button i,.listfoliopro-section-subtitle,.contact-info-content a,.contact-info-icon,.slicknav_nav a:hover,.slicknav_item.slicknav_row:hover a,.slicknav_item.slicknav_row:hover .slicknav_arrow,.slicknav_menu .current-menu-item>a,.slicknav_menu .current-menu-item .slicknav_row>a,.slicknav_menu .current-menu-ancestor>a,.slicknav_menu .current-menu-ancestor>.slicknav_row>a,.current-menu-ancestor>.slicknav_row .slicknav_arrow,.current-menu-item .slicknav_row .slicknav_arrow, .ep-button:hover ,.ep-button:hover, input[type="submit"]:hover, button[type="submit"]:hover, .post-details-wrapper article .entry-content .wp-block-button__link:hover, .post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button:hover',

				'background-color' => '.post-pagination ul li span.current,.post-pagination ul li a:hover,.widget_calendar .wp-calendar-table thead, .widget_calendar .wp-calendar-table tbody td a,.wp-block-search button.wp-block-search__button:after, .content-area button[type="submit"].search-submit:after, .widget.widget_search button[type="submit"]:after,.widget.widget_tag_cloud a:hover,.post-tags a:hover,button[type="submit"], input[type="submit"],.post-details-wrapper article .entry-content .wp-block-button__link,.post-details-wrapper article .entry-content .is-style-outline .wp-block-button__link:hover,.post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button,.wp-block-calendar table th,.page-links a:hover,.page-links .current,.ep-button,.banner-one-search-form-wrapper #listfoliopro_search_form button[type="submit"].btn.btn-big,a.listfoliopro-button,.scroll-to-top,.home-banner-two .banner-one-search-form-wrapper #listfoliopro_search_form button[type="submit"].btn.btn-big,.listfoliopro-location-wrapper .location-icon,.listfoliopro-search-wrapper #listfoliopro_search_form button[type="submit"].btn.btn-big,.listfoliopro-search-wrapper .ms-options-wrap > .ms-options > ul label.focused,.listfoliopro-search-wrapper .ms-options-wrap > .ms-options > ul label:hover,.listfoliopro-search-wrapper .ms-options-wrap > .ms-options > ul li.selected label,.listing-top-button-wrapper ul.listing-layout-btn li:hover,.listing-top-button-wrapper ul.listing-layout-btn li.active,.leaflet-popup-content-wrapper .leaflet-popup-content .card-text-map a,.leaflet-popup-content-wrapper .leaflet-popup-content .card-text-map a:hover,.single-listing-main-wrapper .listfoliopro-list-details-tab-wrapper .nav-tabs .nav-item .nav-link.active, .single-listing-main-wrapper .listfoliopro-list-details-tab-wrapper .nav-tabs .nav-item .nav-link:hover,.listing-company-info-wrapper .booking-and-claim-button button[type="button"],.listfoliopro-list-details-tab-wrapper .review-subject-and-comment button.listfoliopro-button, .listfoliopro-list-details-tab-wrapper .review-subject-and-comment button.listfoliopro-button:hover,.listfoliopro-list-details-tab-wrapper .listing-single-page-contact-form-wrapper .listfoliopro-button,.single-listing .bootstrap-wrapper .modal-header .close,.single-listing #popup-booking .listfoliopro-button,.single-listing .claim-form-wrapper .listfoliopro-button,.ep-accordion-wrapper .accordion-item:first-of-type .accordion-button:not(.collapsed), .ep-accordion-wrapper .accordion-item .accordion-button:not(.collapsed), .ep-accordion-wrapper .accordion-item .accordion-button:hover,.widget.widget_tag_cloud a:hover, .widget .wp-block-tag-cloud a:hover, .wp-block-tag-cloud a:hover',
				'border-color' => '.site-content, .ep-button , .ep-button:hover , .ep-button:hover, input[type="submit"]:hover, button[type="submit"]:hover, .post-details-wrapper article .entry-content .wp-block-button__link:hover, .post-details-wrapper article .entry-content .wp-block-file .wp-block-file__button:hover',
			),
		),
		array(
			'id'       => 'theme_second_color', 
			'type'     => 'color',
			'title'    => esc_html__( 'Second Color', 'listihub' ),
			'desc'     => esc_html__( 'Select theme primary color. Few colors not change from here. You can change them from individual Elementor widget.', 'listihub' ),
			'output'   => array(	
				'background-color' => '.footer-bottom-area',
			),
			
		),
		array(
			'id'       => 'theme_content_bg_color',
			'type'     => 'color',
			'title'    => esc_html__( 'Content Backround Color', 'listihub' ),
			'desc'     => esc_html__( 'Select theme primary color. Few colors not change from here. You can change them from individual Elementor widget.', 'listihub' ),
			'output'   => array(				
				'background-color' => '.site-content',
			),
		),


		array(
			'id'       => 'enable_preloader',
			'type'     => 'switcher',
			'title'    => esc_html__( 'Enable Pre Loader', 'listihub' ),
			'text_on'  => esc_html__( 'Yes', 'listihub' ),
			'text_off' => esc_html__( 'No', 'listihub' ),
			'desc'     => esc_html__( 'Enable or disable Site Preloader.', 'listihub' ),
			'default'  => true
		),


		array(
			'id'          => 'preloader_background_color',
			'type'        => 'color',
			'title'       => esc_html__( 'Preloader Background Color', 'listihub' ),
			'desc'        => esc_html__( 'Select preloader background color.', 'listihub' ),
			'dependency'  => array( 'enable_preloader', '==', true ),
			'output'      => '#loader-wrapper .loader-section',
			'output_mode' => 'background-color',
		),
	),
) );