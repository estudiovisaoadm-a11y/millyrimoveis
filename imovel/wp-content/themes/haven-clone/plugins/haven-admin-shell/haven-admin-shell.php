<?php
/**
 * Plugin Name: Haven Admin Shell
 * Description: Extrai o painel simplificado, dashboard e shell administrativo da landing.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_ADMIN_SHELL_VERSION' ) ) {
    define( 'HAVEN_ADMIN_SHELL_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_ADMIN_SHELL_PATH' ) ) {
    define( 'HAVEN_ADMIN_SHELL_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_admin_shell_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_can_use_simplified_admin' ) ) {
        return;
    }

    require_once HAVEN_ADMIN_SHELL_PATH . 'includes/haven-admin-shell-core.php';
}

add_action( 'after_setup_theme', 'haven_admin_shell_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_admin_shell_bootstrap();
}
