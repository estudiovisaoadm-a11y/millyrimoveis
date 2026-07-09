<?php
/**
 * Plugin Name: Haven Media Suite
 * Description: Extrai galerias, tours, video principal e helpers de midia da landing.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_MEDIA_SUITE_VERSION' ) ) {
    define( 'HAVEN_MEDIA_SUITE_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_MEDIA_SUITE_PATH' ) ) {
    define( 'HAVEN_MEDIA_SUITE_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_media_suite_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_register_settings' ) ) {
        return;
    }

    require_once HAVEN_MEDIA_SUITE_PATH . 'includes/haven-media-core.php';
}

add_action( 'after_setup_theme', 'haven_media_suite_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_media_suite_bootstrap();
}
