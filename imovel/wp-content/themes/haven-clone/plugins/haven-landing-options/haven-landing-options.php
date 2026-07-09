<?php
/**
 * Plugin Name: Haven Landing Options
 * Description: Extrai defaults, sanitizacao e registro de configuracoes da landing para um plugin reutilizavel.
 * Version: 1.0.4
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_LANDING_OPTIONS_VERSION' ) ) {
    define( 'HAVEN_LANDING_OPTIONS_VERSION', '1.0.4' );
}

if ( ! defined( 'HAVEN_LANDING_OPTIONS_PATH' ) ) {
    define( 'HAVEN_LANDING_OPTIONS_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_landing_options_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_get_ui_defaults' ) ) {
        return;
    }

    require_once HAVEN_LANDING_OPTIONS_PATH . 'includes/haven-options-core.php';
}

add_action( 'after_setup_theme', 'haven_landing_options_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_landing_options_bootstrap();
}
