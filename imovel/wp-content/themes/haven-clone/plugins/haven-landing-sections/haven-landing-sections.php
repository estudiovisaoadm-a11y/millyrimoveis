<?php
/**
 * Plugin Name: Haven Landing Sections
 * Description: Extrai a ordenacao e a logica de secoes da landing para um plugin reutilizavel.
 * Version: 1.0.4
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_LANDING_SECTIONS_VERSION' ) ) {
    define( 'HAVEN_LANDING_SECTIONS_VERSION', '1.0.4' );
}

if ( ! defined( 'HAVEN_LANDING_SECTIONS_PATH' ) ) {
    define( 'HAVEN_LANDING_SECTIONS_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_landing_sections_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_get_default_section_order' ) ) {
        return;
    }

    require_once HAVEN_LANDING_SECTIONS_PATH . 'includes/haven-sections-core.php';
}

add_action( 'after_setup_theme', 'haven_landing_sections_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_landing_sections_bootstrap();
}
