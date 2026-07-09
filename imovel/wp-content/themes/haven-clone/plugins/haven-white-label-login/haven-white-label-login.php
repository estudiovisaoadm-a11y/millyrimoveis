<?php
/**
 * Plugin Name: Haven White Label Login
 * Description: Extrai a tela de login customizada e os helpers de branding do acesso.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_WHITE_LABEL_LOGIN_VERSION' ) ) {
    define( 'HAVEN_WHITE_LABEL_LOGIN_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_WHITE_LABEL_LOGIN_PATH' ) ) {
    define( 'HAVEN_WHITE_LABEL_LOGIN_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_white_label_login_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_admin_login_render' ) ) {
        return;
    }

    require_once HAVEN_WHITE_LABEL_LOGIN_PATH . 'includes/haven-login-core.php';
}

add_action( 'after_setup_theme', 'haven_white_label_login_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_white_label_login_bootstrap();
}
