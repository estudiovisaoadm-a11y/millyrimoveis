<?php

function listfoliopro_elementor_version( $operator = '<', $version = '2.6.0' ) {
	return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/*
 * Render Icons
 */

function listfoliopro_custom_icon_render( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	// Check if its already migrated
	$migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
	// Check if its a new widget without previously selected icon using the old Icon control
	$is_new = empty( $settings[ $old_icon_id ] );

	$attributes['aria-hidden'] = 'true';

	if ( listfoliopro_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
		\Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
	} else {
		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = $settings[ $old_icon_id ];
		} else {
			if ( is_array( $attributes['class'] ) ) {
				$attributes['class'][] = $settings[ $old_icon_id ];
			} else {
				$attributes['class'] .= ' ' . $settings[ $old_icon_id ];
			}
		}
		printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
	}
}