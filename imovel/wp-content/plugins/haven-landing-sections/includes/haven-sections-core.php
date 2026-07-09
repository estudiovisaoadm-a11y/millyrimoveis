<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function haven_get_default_section_order() {
    return array( 'galeria', 'video', 'matterport', 'detalhes', 'localizacao', 'depoimentos', 'cta' );
}

function haven_get_section_order() {
    $order = get_option( 'haven_section_order', array() );
    if ( empty( $order ) || ! is_array( $order ) ) {
        return haven_get_default_section_order();
    }

    $default = haven_get_default_section_order();
    foreach ( $default as $section ) {
        if ( ! in_array( $section, $order, true ) ) {
            $order[] = $section;
        }
    }

    return $order;
}

function haven_get_section_labels() {
    return array(
        'galeria'      => 'Galeria de Ambientes',
        'video'        => 'Video Tour Virtual',
        'matterport'   => 'Tour Virtual 3D (Matterport)',
        'detalhes'     => 'Ficha Tecnica / Detalhes',
        'localizacao'  => 'Localizacao',
        'depoimentos'  => 'Depoimentos',
        'cta'          => 'CTA Final (Contato)',
    );
}

function haven_ajax_save_section_order() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Sem permissao.' );
    }

    check_ajax_referer( 'haven_section_order_nonce', 'nonce' );

    $order = isset( $_POST['order'] ) ? array_map( 'sanitize_key', (array) $_POST['order'] ) : array();
    $valid = haven_get_default_section_order();
    $order = array_filter(
        $order,
        function( $section ) use ( $valid ) {
            return in_array( $section, $valid, true );
        }
    );

    if ( ! empty( $order ) ) {
        update_option( 'haven_section_order', array_values( $order ) );
        wp_send_json_success( 'Ordem salva!' );
    }

    wp_send_json_error( 'Ordem invalida.' );
}
add_action( 'wp_ajax_haven_save_section_order', 'haven_ajax_save_section_order' );

function haven_enqueue_sortable_admin() {
    $page = isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '';
    if ( in_array( $page, array( 'haven-secoes', 'haven-menus' ), true ) ) {
        wp_enqueue_script( 'jquery-ui-sortable' );
    }
}
add_action( 'admin_enqueue_scripts', 'haven_enqueue_sortable_admin' );
