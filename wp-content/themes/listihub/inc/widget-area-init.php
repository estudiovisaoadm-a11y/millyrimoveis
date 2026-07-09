<?php

//Register widget area
function listihub_widgets_init() {
	register_sidebar(array(
		'name'          => esc_html__('Sidebar', 'listihub'),
		'id'            => 'listihub-sidebar',
		'description'   => esc_html__('Add widgets here.', 'listihub'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	$footer_widget_column = listihub_option('footer_widget_column', 'col-lg-3');
	register_sidebar(array(
		'name'          => esc_html__('Footer Widget', 'listihub'),
		'id'            => 'listihub-footer-widget',
		'description'   => esc_html__('Add footer widgets here.', 'listihub'),
		'before_widget' => '<div id="%1$s" class="widget '.esc_attr($footer_widget_column).' col-md-6 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title"><span></span>',
		'after_title'   => '</h4>',
	));
}

add_action('widgets_init', 'listihub_widgets_init');