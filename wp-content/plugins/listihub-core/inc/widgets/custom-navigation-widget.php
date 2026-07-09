<?php

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	CSF::createWidget( 'listihub_navigation_menu', array(
		'title'       => esc_html__( 'Listihub : Navigation Menu', 'listihub-core' ),
		'classname'   => 'widget_nav_menu listihub_nav_menu_widget',
		'description' => esc_html__( 'listihub navigation menu.', 'listihub-core' ),
		'fields'      => array(

			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__( 'Title', 'listihub-core' ),
			),

			array(
				'id'          => 'listihub_widget_menu_list',
				'type'        => 'select',
				'title'       => esc_html__( 'Select Menu', 'listihub' ),
				'options'     => 'menus',
				'placeholder' => esc_html__( 'Select Menu', 'listihub' ),
			),
		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if (!function_exists('listihub_navigation_menu')) {
		function listihub_navigation_menu($args, $instance) {

			$selected_menu = $instance['listihub_widget_menu_list'];

			echo $args['before_widget'];

			if (!empty($instance['title'])) {
				echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
			}

			if ($selected_menu) {
				wp_nav_menu(array(
					'menu' => $selected_menu,
				));
			}

			echo $args['after_widget'];
		}
	}
}