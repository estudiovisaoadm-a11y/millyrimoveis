<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function haven_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'haven_register_elementor_locations' );

$haven_elementor_bridge_dir = defined( 'HAVEN_ELEMENTOR_BRIDGE_BASE_DIR' )
    ? untrailingslashit( HAVEN_ELEMENTOR_BRIDGE_BASE_DIR )
    : untrailingslashit( HAVEN_DIR . '/inc/elementor' );

if ( file_exists( $haven_elementor_bridge_dir . '/init.php' ) ) {
    require_once $haven_elementor_bridge_dir . '/init.php';
}
