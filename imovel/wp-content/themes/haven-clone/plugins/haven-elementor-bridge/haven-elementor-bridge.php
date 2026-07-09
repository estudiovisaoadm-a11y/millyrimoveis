<?php
/**
 * Plugin Name: Haven Elementor Bridge
 * Description: Extrai a ponte com Elementor, locations e widgets customizados reutilizaveis.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_ELEMENTOR_BRIDGE_VERSION' ) ) {
    define( 'HAVEN_ELEMENTOR_BRIDGE_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_ELEMENTOR_BRIDGE_PATH' ) ) {
    define( 'HAVEN_ELEMENTOR_BRIDGE_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'HAVEN_ELEMENTOR_BRIDGE_BASE_DIR' ) ) {
    define( 'HAVEN_ELEMENTOR_BRIDGE_BASE_DIR', HAVEN_ELEMENTOR_BRIDGE_PATH . 'includes/elementor' );
}

function haven_elementor_bridge_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_register_elementor_locations' ) ) {
        return;
    }

    require_once HAVEN_ELEMENTOR_BRIDGE_PATH . 'includes/haven-elementor-bridge-core.php';
}

add_action( 'after_setup_theme', 'haven_elementor_bridge_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_elementor_bridge_bootstrap();
}
