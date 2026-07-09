<?php
/**
 * Plugin Name: Haven Leads and WhatsApp
 * Description: Extrai o formulario de lead e o painel de conversao/WhatsApp da landing.
 * Version: 1.0.1
 * Author: Codex
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'HAVEN_LEADS_WHATSAPP_VERSION' ) ) {
    define( 'HAVEN_LEADS_WHATSAPP_VERSION', '1.0.1' );
}

if ( ! defined( 'HAVEN_LEADS_WHATSAPP_PATH' ) ) {
    define( 'HAVEN_LEADS_WHATSAPP_PATH', plugin_dir_path( __FILE__ ) );
}

function haven_leads_whatsapp_bootstrap() {
    if ( ! defined( 'HAVEN_DIR' ) || function_exists( 'haven_admin_cta_form_render' ) ) {
        return;
    }

    require_once HAVEN_LEADS_WHATSAPP_PATH . 'includes/haven-leads-core.php';
}

add_action( 'after_setup_theme', 'haven_leads_whatsapp_bootstrap', 1 );

if ( did_action( 'after_setup_theme' ) ) {
    haven_leads_whatsapp_bootstrap();
}
