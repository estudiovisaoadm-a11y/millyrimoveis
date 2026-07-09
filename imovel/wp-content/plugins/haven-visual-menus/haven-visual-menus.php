<?php
/**
 * Plugin Name: Haven Visual Menus
 * Description: Extrai o CRUD e os helpers dos menus visuais do header e do rodape.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_VISUAL_MENUS_VERSION' ) ) {
    define( 'HAVEN_VISUAL_MENUS_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_VISUAL_MENUS_PATH' ) ) {
    define( 'HAVEN_VISUAL_MENUS_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_visual_menus_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_get_menu_link_type_options' ) ) {
        return;
    }

    require_once HAVEN_VISUAL_MENUS_PATH . 'includes/haven-visual-menus-core.php';
}

add_action( 'after_setup_theme', 'haven_visual_menus_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_visual_menus_bootstrap();
}
