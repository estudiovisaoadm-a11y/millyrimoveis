<?php
/**
 * ResidÃªncia JB â€” Theme Functions
 * Tema clÃ¡ssico compatÃ­vel com Elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HAVEN_VERSION', '1.0.0' );
define( 'HAVEN_DIR', get_template_directory() );
define( 'HAVEN_URI', get_template_directory_uri() );

if ( ! function_exists( 'haven_get_ui_defaults' ) && ! defined( 'HAVEN_LANDING_OPTIONS_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-options-core.php';
}

if ( ! function_exists( 'haven_get_default_section_order' ) && ! defined( 'HAVEN_LANDING_SECTIONS_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-sections-core.php';
}

if ( ! function_exists( 'haven_register_elementor_locations' ) && ! defined( 'HAVEN_ELEMENTOR_BRIDGE_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-elementor-bridge-core.php';
}

if ( ! function_exists( 'haven_get_menu_link_type_options' ) && ! defined( 'HAVEN_VISUAL_MENUS_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-visual-menus-core.php';
}

if ( ! function_exists( 'haven_register_settings' ) && ! defined( 'HAVEN_MEDIA_SUITE_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-media-core.php';
}

if ( ! function_exists( 'haven_admin_cta_form_render' ) && ! defined( 'HAVEN_LEADS_WHATSAPP_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-leads-core.php';
}

if ( ! function_exists( 'haven_admin_login_render' ) && ! defined( 'HAVEN_WHITE_LABEL_LOGIN_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-login-core.php';
}

if ( ! function_exists( 'haven_can_use_simplified_admin' ) && ! defined( 'HAVEN_ADMIN_SHELL_PATH' ) ) {
    require_once HAVEN_DIR . '/inc/haven-admin-shell-core.php';
}

function haven_get_asset_version( $relative_path ) {
    $full_path = HAVEN_DIR . $relative_path;

    if ( file_exists( $full_path ) ) {
        return (string) filemtime( $full_path );
    }

    return HAVEN_VERSION;
}

function haven_get_admin_page_slug() {
    if ( empty( $_GET['page'] ) ) {
        return '';
    }

    return sanitize_key( wp_unslash( $_GET['page'] ) );
}

function haven_is_custom_admin_page( $hook = '' ) {
    $page = haven_get_admin_page_slug();

    if ( strpos( $page, 'haven-' ) === 0 ) {
        return true;
    }

    return $hook && strpos( $hook, 'haven-' ) !== false;
}

// ===================================================================
// 1. THEME SETUP
// ===================================================================
function haven_theme_setup() {
    // Elementor requirements
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'widgets' );
    add_theme_support( 'menus' );

    // Register nav menus
    register_nav_menus( array(
        'primary' => 'Menu Principal',
        'footer'  => 'Menu do Rodape',
    ));

    // Image sizes
    add_image_size( 'haven-hero', 1920, 1080, true );
    add_image_size( 'haven-gallery', 800, 600, true );
    add_image_size( 'haven-thumb', 400, 300, true );
}
add_action( 'after_setup_theme', 'haven_theme_setup' );

// ===================================================================
// 2. ENQUEUE ASSETS
// ===================================================================
function haven_enqueue_assets() {
    // Google Fonts â€” dynamic based on admin settings
    $font_heading = haven_opt( 'haven_font_heading' );
    $font_body    = haven_opt( 'haven_font_body' );
    $font_alt     = haven_opt( 'haven_font_alt' );

    $families = array();
    if ( $font_heading ) $families[] = str_replace( ' ', '+', $font_heading ) . ':ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700';
    if ( $font_body )    $families[] = str_replace( ' ', '+', $font_body ) . ':wght@300;400;500;600;700;800';
    if ( $font_alt )     $families[] = str_replace( ' ', '+', $font_alt ) . ':wght@400;500;700';

    $families = array_unique( $families );
    if ( ! empty( $families ) ) {
        $google_fonts_url = 'https://fonts.googleapis.com/css2?' . implode( '&', array_map( function( $f ) { return 'family=' . $f; }, $families ) ) . '&display=swap';
        wp_enqueue_style( 'haven-google-fonts', $google_fonts_url, array(), null );
    }

    // Theme stylesheet
    wp_enqueue_style( 'haven-style', get_stylesheet_uri(), array(), haven_get_asset_version( '/style.css' ) );

    // Premium CSS
    wp_enqueue_style( 'haven-premium', HAVEN_URI . '/assets/css/premium.css', array(), haven_get_asset_version( '/assets/css/premium.css' ) );

    // Premium JS
    wp_enqueue_script( 'haven-premium-js', HAVEN_URI . '/assets/js/premium.js', array(), haven_get_asset_version( '/assets/js/premium.js' ), true );

    // Localize JS with theme data
    wp_localize_script( 'haven-premium-js', 'havenData', array(
        'themeUrl' => HAVEN_URI,
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'galleryAutoplay'       => haven_opt( 'haven_gallery_autoplay' ),
        'galleryAutoplaySpeed'  => haven_opt( 'haven_gallery_autoplay_speed' ),
        'galleryRandom'         => haven_opt( 'haven_gallery_random' ),
        'detailsAutoplay'       => haven_opt( 'haven_details_gallery_autoplay' ),
        'detailsAutoplaySpeed'  => haven_opt( 'haven_details_gallery_autoplay_speed' ),
        'detailsRandom'         => haven_opt( 'haven_details_gallery_random' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'haven_enqueue_assets' );

// ===================================================================
// 3. ELEMENTOR SUPPORT â€” CRITICAL
// ===================================================================

// Declare Elementor locations support
if ( ! function_exists( 'haven_register_elementor_locations' ) ) {
    function haven_register_elementor_locations( $elementor_theme_manager ) {
        $elementor_theme_manager->register_all_core_location();
    }
    add_action( 'elementor/theme/register_locations', 'haven_register_elementor_locations' );

    // Load Elementor custom widgets
    if ( file_exists( HAVEN_DIR . '/inc/elementor/init.php' ) ) {
        require_once HAVEN_DIR . '/inc/elementor/init.php';
    }
}

// ===================================================================
// 4. ADMIN â€” ENQUEUE
// ===================================================================
function haven_admin_enqueue( $hook ) {
    if ( ! haven_is_custom_admin_page( $hook ) ) return;
    wp_enqueue_media();
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'haven-admin-css', HAVEN_URI . '/assets/css/admin.css', array(), haven_get_asset_version( '/assets/css/admin.css' ) );
    wp_enqueue_script( 'haven-admin-js', HAVEN_URI . '/assets/js/admin.js', array( 'jquery', 'wp-color-picker' ), haven_get_asset_version( '/assets/js/admin.js' ), true );
}
add_action( 'admin_enqueue_scripts', 'haven_admin_enqueue' );

// ===================================================================
// 5. ADMIN MENU â€” GESTÃƒO DE CONTEÃšDO
// ===================================================================
function haven_admin_menu() {
    // Legacy menu bootstrap kept only to avoid breaking references.
}

// Active admin menu is defined in haven_admin_menu_rebuild().





// ===================================================================
// 6. REGISTER SETTINGS
// ===================================================================
if ( ! function_exists( 'haven_register_settings' ) ) {
    function haven_register_settings() {
        $media = array( 'haven_hero_photos', 'haven_gallery_photos', 'haven_details_gallery_photos', 'haven_video_bg' );
        foreach ( $media as $key ) {
            register_setting( 'haven_gallery_media_group', $key );
        }
        register_setting( 'haven_video_media_group', 'haven_video_url', array( 'sanitize_callback' => 'haven_sanitize_video_url' ) );
        register_setting( 'haven_video_media_group', 'haven_video_format', array( 'sanitize_callback' => 'haven_sanitize_video_format' ) );
        register_setting( 'haven_video_media_group', 'haven_video_autoplay', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
        register_setting( 'haven_video_media_group', 'haven_video_repeat', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
        register_setting( 'haven_video_media_group', 'haven_video_hide_controls', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );

        $media_gallery_toggles = array(
            'haven_gallery_autoplay',
            'haven_gallery_random',
            'haven_details_gallery_autoplay',
            'haven_details_gallery_random',
        );
        foreach ( $media_gallery_toggles as $key ) {
            register_setting( 'haven_gallery_media_group', $key, array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
        }

        $media_gallery_numbers = array(
            'haven_gallery_autoplay_speed',
            'haven_details_gallery_autoplay_speed',
        );
        foreach ( $media_gallery_numbers as $key ) {
            register_setting( 'haven_gallery_media_group', $key, array( 'sanitize_callback' => 'absint' ) );
        }

        $text = array(
            'haven_property_name', 'haven_property_tagline', 'haven_property_price',
            'haven_property_address',
            'haven_hero_title', 'haven_hero_subtitle',
            'haven_stat_area', 'haven_stat_terreno', 'haven_stat_suites',
            'haven_stat_vagas', 'haven_stat_banheiros', 'haven_stat_construcao', 'haven_stat_piscina',
            'haven_amenities', 'haven_whatsapp', 'haven_telefone', 'haven_email', 'haven_creci',
        );
        foreach ( $text as $key ) register_setting( 'haven_text_group', $key );
        register_setting( 'haven_text_group', 'haven_property_description', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    }
    add_action( 'admin_init', 'haven_register_settings' );
}

if ( ! function_exists( 'haven_get_menu_link_type_options' ) ) {
    function haven_get_menu_link_type_options() {
        return array(
            'section' => 'Secao do site',
            'page'    => 'Pagina do WordPress',
            'url'     => 'URL personalizada',
            'email'   => 'E-mail',
            'phone'   => 'Telefone',
        );
    }

    function haven_get_menu_section_targets() {
        return array(
            '#home'        => 'Home',
            '#sobre'       => 'Sobre',
            '#galeria'     => 'Galeria',
            '#tour'        => 'Tour em video',
            '#tour3d'      => 'Tour 3D',
            '#detalhes'    => 'Detalhes',
            '#localizacao' => 'Localizacao',
            '#depoimentos' => 'Depoimentos',
            '#contato'     => 'Contato',
        );
    }
}

function haven_get_preloader_effect_options() {
    return array(
        'slide' => 'Barra deslizante',
        'pulse' => 'Pulso suave',
        'spin'  => 'Ponto girando',
    );
}

function haven_get_preloader_logo_animation_options() {
    return array(
        'none'   => 'Sem animacao',
        'fade'   => 'Fade suave',
        'float'  => 'Flutuar',
        'pulse'  => 'Pulso',
        'zoom'   => 'Zoom leve',
    );
}

if ( ! function_exists( 'haven_get_visual_menu_defaults' ) ) {
function haven_get_visual_menu_defaults() {
    return array(
        'primary' => array(
            array( 'label' => 'A casa', 'type' => 'section', 'value' => '#sobre', 'new_tab' => '0' ),
            array( 'label' => 'Galeria', 'type' => 'section', 'value' => '#galeria', 'new_tab' => '0' ),
            array( 'label' => 'Tour 3D', 'type' => 'section', 'value' => '#tour3d', 'new_tab' => '0' ),
            array( 'label' => 'Detalhes', 'type' => 'section', 'value' => '#detalhes', 'new_tab' => '0' ),
            array( 'label' => 'Localizacao', 'type' => 'section', 'value' => '#localizacao', 'new_tab' => '0' ),
            array( 'label' => 'Contato', 'type' => 'section', 'value' => '#contato', 'new_tab' => '0' ),
        ),
        'footer' => array(
            array( 'label' => 'Sobre', 'type' => 'section', 'value' => '#sobre', 'new_tab' => '0' ),
            array( 'label' => 'Galeria', 'type' => 'section', 'value' => '#galeria', 'new_tab' => '0' ),
            array( 'label' => 'Tour Virtual', 'type' => 'section', 'value' => '#tour3d', 'new_tab' => '0' ),
            array( 'label' => 'Ficha tecnica', 'type' => 'section', 'value' => '#detalhes', 'new_tab' => '0' ),
        ),
    );
}

function haven_resolve_visual_menu_href( $item ) {
    $type  = $item['type'] ?? 'url';
    $value = trim( (string) ( $item['value'] ?? '' ) );

    if ( '' === $value ) {
        return '';
    }

    switch ( $type ) {
        case 'section':
            return strpos( $value, '#' ) === 0 ? $value : '#' . ltrim( $value, '#' );
        case 'page':
            return get_permalink( absint( $value ) );
        case 'email':
            return 'mailto:' . sanitize_email( $value );
        case 'phone':
            return 'tel:+' . preg_replace( '/[^0-9]/', '', $value );
        case 'url':
        default:
            return $value;
    }
}

function haven_sanitize_visual_menus( $value ) {
    $defaults = haven_get_visual_menu_defaults();
    $clean = array(
        'primary' => array(),
        'footer'  => array(),
    );

    if ( ! is_array( $value ) ) {
        return $defaults;
    }

    foreach ( array_keys( $clean ) as $location ) {
        if ( empty( $value[ $location ] ) || ! is_array( $value[ $location ] ) ) {
            continue;
        }

        foreach ( $value[ $location ] as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $label = sanitize_text_field( $item['label'] ?? '' );
            $type  = sanitize_key( $item['type'] ?? 'url' );
            $raw   = trim( (string) ( $item['value'] ?? '' ) );

            if ( '' === $label || '' === $raw ) {
                continue;
            }

            if ( ! array_key_exists( $type, haven_get_menu_link_type_options() ) ) {
                $type = 'url';
            }

            if ( 'page' === $type ) {
                $value_clean = (string) absint( $raw );
            } elseif ( 'email' === $type ) {
                $value_clean = sanitize_email( $raw );
            } elseif ( 'phone' === $type ) {
                $value_clean = preg_replace( '/[^0-9+()\\-\\s]/', '', $raw );
            } elseif ( 'section' === $type ) {
                $value_clean = strpos( $raw, '#' ) === 0 ? $raw : '#' . ltrim( $raw, '#' );
            } else {
                $value_clean = esc_url_raw( $raw );
            }

            if ( '' === $value_clean ) {
                continue;
            }

            $clean[ $location ][] = array(
                'label'   => $label,
                'type'    => $type,
                'value'   => $value_clean,
                'new_tab' => ! empty( $item['new_tab'] ) && '1' === (string) $item['new_tab'] ? '1' : '0',
            );
        }
    }

    return $clean;
}

function haven_get_visual_menu_items( $location ) {
    $menus = get_option( 'haven_visual_menus', array() );
    if ( ! is_array( $menus ) ) {
        $menus = array();
    }

    if ( ! empty( $menus[ $location ] ) && is_array( $menus[ $location ] ) ) {
        $valid_items = array();

        foreach ( $menus[ $location ] as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $label = trim( (string) ( $item['label'] ?? '' ) );
            $href  = haven_resolve_visual_menu_href( $item );

            if ( '' === $label || '' === $href ) {
                continue;
            }

            $valid_items[] = $item;
        }

        if ( 'primary' === $location && count( $valid_items ) < 2 ) {
            $valid_items = array();
        }

        if ( ! empty( $valid_items ) ) {
            return $valid_items;
        }
    }

    $defaults = haven_get_visual_menu_defaults();
    return $defaults[ $location ] ?? array();
}

function haven_get_visual_menu_editor_items( $location ) {
    $items = haven_get_visual_menu_items( $location );
    if ( ! empty( $items ) ) {
        return $items;
    }

    $defaults = haven_get_visual_menu_defaults();
    return $defaults[ $location ] ?? array();
}

function haven_has_visual_menu_items( $location ) {
    $items = haven_get_visual_menu_items( $location );
    foreach ( $items as $item ) {
        if ( ! empty( $item['label'] ) && haven_resolve_visual_menu_href( $item ) ) {
            return true;
        }
    }

    return false;
}

function haven_render_visual_menu( $location, $class_name = '', $echo = true ) {
    $items = haven_get_visual_menu_items( $location );
    if ( empty( $items ) ) {
        return '';
    }

    $class_attr = trim( $class_name );
    $html = '<ul' . ( $class_attr ? ' class="' . esc_attr( $class_attr ) . '"' : '' ) . '>';

    foreach ( $items as $item ) {
        $href = haven_resolve_visual_menu_href( $item );
        if ( ! $href ) {
            continue;
        }

        $href = haven_normalize_matterport_inline_href( $href );

        $target = ! empty( $item['new_tab'] ) && '1' === (string) $item['new_tab'] && '#tour3d' !== $href ? ' target="_blank" rel="noopener"' : '';
        $html .= '<li><a href="' . esc_url( $href ) . '"' . $target . '>' . esc_html( $item['label'] ?? '' ) . '</a></li>';
    }

    $html .= '</ul>';

    if ( $echo ) {
        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    return $html;
}

// ---- Default Values ----
function haven_get_defaults() {
    return array(
        'haven_property_name'        => 'Magnifica Casa Terrea',
        'haven_property_tagline'     => 'Condominio Verde, Jardim Botanico, Brasilia',
        'haven_property_price'       => 'R$ 1.640.000,00',
        'haven_property_address'     => 'Condominio Verde, Jardim Botanico - DF',
        'haven_property_description' => "Projetada para quem nao abre mao da elegancia e do verdadeiro descanso, esta deslumbrante casa terrea - ja com Habite-se - esta pronta para acolher as suas melhores memorias.\n\nCom arquitetura contemporanea e foco na iluminacao natural, a residencia exibe um amplo living imponente de pe direito duplo, perfeitamente emoldurado e integrado a cozinha gourmet para voce receber com perfeicao.\n\nPara o dia a dia, 4 dormitorios planejados (sendo 2 confortaveis suites master) se encarregam da mais sublime privacidade. O refugio coroa-se em uma deslumbrante area exterior privativa e cercada, onde a piscina aquecida em meio a exuberancia do pomar com dezenas de arvores frutiferas compoe o seu clube particular e inigualavel.",
        'haven_hero_title'           => 'O Seu Novo Refugio de Natureza e <em>Modernidade</em> no Condominio Verde',
        'haven_hero_subtitle'        => 'Casa terrea impecavel com Habite-se, lazer privativo incrivel e seguranca 24h no Jardim Botanico. Onde o conforto da sua familia encontra o cenario perfeito.',
        'haven_stat_area'            => '250',
        'haven_stat_terreno'         => '956',
        'haven_stat_suites'          => '4',
        'haven_stat_vagas'           => '2',
        'haven_stat_banheiros'       => '5',
        'haven_stat_construcao'      => 'Com Habite-se',
        'haven_stat_piscina'         => 'Aquecida (Com Cascata)',
        'haven_amenities'            => 'Piscina aquecida, Ar condicionado, 5 banheiros, Varanda gourmet, 2 vagas cobertas, Portaria 24h, 4 quartos, 4 suites, DCE, Sala dupla, Forno de pizza a lenha, Quadras poliesportivas, Aquecimento solar, Pomar com 20 arvores',
        'haven_whatsapp'             => '5561999999999',
        'haven_telefone'             => '(61) 99999-9999',
        'haven_email'                => 'contato@imob.com.br',
        'haven_creci'                => 'CRECI-DF 00000',
        'haven_video_url'            => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'haven_video_format'         => 'horizontal',
        'haven_video_autoplay'       => '1',
        'haven_video_repeat'         => '0',
        'haven_video_hide_controls'  => '0',
    );
}

function haven_opt( $key ) {
    $defaults = haven_get_defaults();
    if ( function_exists( 'haven_get_color_defaults' ) ) {
        $defaults = array_merge( $defaults, haven_get_color_defaults() );
    }
    if ( function_exists( 'haven_get_ui_defaults' ) ) {
        $defaults = array_merge( $defaults, haven_get_ui_defaults() );
    }
    $defaults = apply_filters( 'haven_opt_defaults', $defaults );
    $val = get_option( $key );
    $val = ( $val === false || $val === '' ) ? ( $defaults[ $key ] ?? '' ) : $val;
    return haven_maybe_fix_mojibake_value( $val, $key );
}

function haven_get_matterport_sdk_bootstrap_url( $sdk_key ) {
    $sdk_key = trim( (string) $sdk_key );

    if ( '' === $sdk_key ) {
        return '';
    }

    return 'https://api.matterport.com/sdk/bootstrap/3.0.0-0-g0517b8d76c/sdk.es6.js?applicationKey=' . rawurlencode( $sdk_key );
}

function haven_prepare_matterport_embed_url( $url, $sdk_key = '', $autotour_enabled = false ) {
    $url = esc_url_raw( $url );

    if ( '' === $url ) {
        return '';
    }

    $query_args = array();

    if ( '' !== trim( (string) $sdk_key ) ) {
        $query_args['applicationKey'] = trim( (string) $sdk_key );
    }

    if ( $autotour_enabled ) {
        $query_args['play'] = '1';
    }

    if ( empty( $query_args ) ) {
        return $url;
    }

    return add_query_arg( $query_args, remove_query_arg( array( 'applicationKey' ), $url ) );
}

function haven_get_matterport_model_id_from_url( $url ) {
    $url = trim( (string) $url );

    if ( '' === $url ) {
        return '';
    }

    $parts = wp_parse_url( $url );
    if ( empty( $parts['host'] ) || false === stripos( $parts['host'], 'matterport.com' ) ) {
        return '';
    }

    if ( empty( $parts['query'] ) ) {
        return '';
    }

    parse_str( $parts['query'], $query );

    return ! empty( $query['m'] ) ? sanitize_text_field( (string) $query['m'] ) : '';
}

function haven_normalize_matterport_inline_href( $href ) {
    $href = trim( (string) $href );

    if ( '' === $href ) {
        return '';
    }

    if ( '#tour3d' === $href || '#tour' === $href ) {
        return '#tour3d';
    }

    if ( ! is_front_page() ) {
        return $href;
    }

    $current_model_id = haven_get_matterport_model_id_from_url( haven_opt( 'haven_matterport_url' ) );
    $target_model_id  = haven_get_matterport_model_id_from_url( $href );

    if ( $current_model_id && $target_model_id && strtolower( $current_model_id ) === strtolower( $target_model_id ) ) {
        return '#tour3d';
    }

    return $href;
}

if ( ! function_exists( 'haven_sanitize_matterport_autotour_mode' ) ) {
    function haven_sanitize_matterport_autotour_mode( $value ) {
        $allowed = array( 'auto', 'guided', 'sweeps' );
        $value   = sanitize_key( $value );

        return in_array( $value, $allowed, true ) ? $value : 'auto';
    }
}

function haven_register_matterport_autotour_settings_fallback() {
    register_setting( 'haven_matterport_group', 'haven_matterport_sdk_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_show_controls', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_mode', array( 'sanitize_callback' => 'haven_sanitize_matterport_autotour_mode' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_step_duration', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_transition_ms', array( 'sanitize_callback' => 'absint' ) );
}
add_action( 'admin_init', 'haven_register_matterport_autotour_settings_fallback', 30 );

function haven_has_mojibake_markers( $value ) {
    return is_string( $value ) && preg_match( '/Ã.|Â.|â.|ðŸ|�/u', $value );
}

function haven_apply_mojibake_roundtrip( $value ) {
    if ( ! is_string( $value ) || '' === $value || ! function_exists( 'iconv' ) ) {
        return $value;
    }

    $latin1 = @iconv( 'UTF-8', 'ISO-8859-1//IGNORE', $value );
    if ( false === $latin1 || '' === $latin1 ) {
        return $value;
    }

    $utf8 = @iconv( 'ISO-8859-1', 'UTF-8//IGNORE', $latin1 );
    if ( false === $utf8 || '' === $utf8 ) {
        return $value;
    }

    return $utf8;
}

function haven_get_mojibake_replacements() {
    return array(
        'ÃƒÂ¡' => 'á',
        'ÃƒÂ ' => 'à',
        'ÃƒÂ¢' => 'â',
        'ÃƒÂ£' => 'ã',
        'ÃƒÂ¤' => 'ä',
        'ÃƒÂ©' => 'é',
        'ÃƒÂ¨' => 'è',
        'ÃƒÂª' => 'ê',
        'ÃƒÂ«' => 'ë',
        'ÃƒÂ­' => 'í',
        'ÃƒÂ¬' => 'ì',
        'ÃƒÂ®' => 'î',
        'ÃƒÂ¯' => 'ï',
        'ÃƒÂ³' => 'ó',
        'ÃƒÂ²' => 'ò',
        'ÃƒÂ´' => 'ô',
        'ÃƒÂµ' => 'õ',
        'ÃƒÂ¶' => 'ö',
        'ÃƒÂº' => 'ú',
        'ÃƒÂ¹' => 'ù',
        'ÃƒÂ»' => 'û',
        'ÃƒÂ¼' => 'ü',
        'ÃƒÂ§' => 'ç',
        'ÃƒÂ' => 'Á',
        'ÃƒÂ€' => 'À',
        'ÃƒÂ‚' => 'Â',
        'ÃƒÂƒ' => 'Ã',
        'ÃƒÂ‰' => 'É',
        'ÃƒÂŠ' => 'Ê',
        'ÃƒÂ' => 'Í',
        'ÃƒÂ“' => 'Ó',
        'ÃƒÂ”' => 'Ô',
        'ÃƒÂ•' => 'Õ',
        'ÃƒÂš' => 'Ú',
        'ÃƒÂ‡' => 'Ç',
        'Ã¡'   => 'á',
        'Ã '   => 'à',
        'Ã¢'   => 'â',
        'Ã£'   => 'ã',
        'Ã¤'   => 'ä',
        'Ã©'   => 'é',
        'Ã¨'   => 'è',
        'Ãª'   => 'ê',
        'Ã«'   => 'ë',
        'Ã­'   => 'í',
        'Ã¬'   => 'ì',
        'Ã®'   => 'î',
        'Ã¯'   => 'ï',
        'Ã³'   => 'ó',
        'Ã²'   => 'ò',
        'Ã´'   => 'ô',
        'Ãµ'   => 'õ',
        'Ã¶'   => 'ö',
        'Ãº'   => 'ú',
        'Ã¹'   => 'ù',
        'Ã»'   => 'û',
        'Ã¼'   => 'ü',
        'Ã§'   => 'ç',
        'Ã'   => 'Á',
        'Ã€'   => 'À',
        'Ã‚'   => 'Â',
        'Ãƒ'   => 'Ã',
        'Ã‰'   => 'É',
        'ÃŠ'   => 'Ê',
        'Ã'   => 'Í',
        'Ã“'   => 'Ó',
        'Ã”'   => 'Ô',
        'Ã•'   => 'Õ',
        'Ãš'   => 'Ú',
        'Ã‡'   => 'Ç',
        'Âº'   => 'º',
        'Âª'   => 'ª',
        'Â°'   => '°',
        'Â²'   => '²',
        'Â³'   => '³',
        'Â§'   => '§',
        'Â·'   => '·',
        'Â'    => '',
        'â€“'  => '–',
        'â€”'  => '—',
        'â€˜'  => '‘',
        'â€™'  => '’',
        'â€œ'  => '“',
        'â€'  => '”',
        'â€¦'  => '…',
        'â€¢'  => '•',
        'â„¢'  => '™',
        'mÂ²'  => 'm²',
    );
}

function haven_maybe_fix_mojibake_value( $value, $path = '' ) {
    if ( is_array( $value ) ) {
        foreach ( $value as $child_key => $child_value ) {
            $child_path         = '' === $path ? (string) $child_key : $path . '.' . $child_key;
            $value[ $child_key ] = haven_maybe_fix_mojibake_value( $child_value, $child_path );
        }
        return $value;
    }

    if ( ! is_string( $value ) || '' === $value ) {
        return $value;
    }

    if ( preg_match( '/(^|\.)(url|link|embed|image|bg|logo)$/i', $path ) ) {
        return $value;
    }

    if ( ! haven_has_mojibake_markers( $value ) ) {
        return $value;
    }

    $fixed = $value;

    for ( $i = 0; $i < 3; $i++ ) {
        if ( ! haven_has_mojibake_markers( $fixed ) ) {
            break;
        }

        $candidate = haven_apply_mojibake_roundtrip( $fixed );
        if ( ! is_string( $candidate ) || '' === $candidate || $candidate === $fixed ) {
            break;
        }

        $fixed = $candidate;
    }

    $fixed = strtr( $fixed, haven_get_mojibake_replacements() );

    return $fixed;
}

function haven_repair_mojibake_options() {
    if ( get_option( 'haven_options_mojibake_repaired_v2' ) ) {
        return;
    }

    $option_keys = array_keys( array_merge( haven_get_defaults(), haven_get_ui_defaults() ) );
    $option_keys = array_merge(
        $option_keys,
        array(
            'haven_gallery_photos',
            'haven_details_gallery_photos',
            'haven_cta_form_fields',
            'haven_visual_menus',
        )
    );

    foreach ( array_unique( $option_keys ) as $option_key ) {
        $current_value = get_option( $option_key, null );
        if ( null === $current_value || false === $current_value ) {
            continue;
        }

        $fixed_value = haven_maybe_fix_mojibake_value( $current_value, $option_key );
        if ( $fixed_value !== $current_value ) {
            update_option( $option_key, $fixed_value );
        }
    }

    update_option( 'haven_options_mojibake_repaired_v2', '1' );
}
add_action( 'init', 'haven_repair_mojibake_options', 5 );

// ===================================================================
// 7. ADMIN PAGE RENDERS
// ===================================================================
if ( ! function_exists( 'haven_admin_fotos_render' ) ) {
function haven_admin_fotos_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $hero_photos   = get_option( 'haven_hero_photos', array() );
    if ( ! is_array( $hero_photos ) ) $hero_photos = array();
    $gallery_photos = get_option( 'haven_gallery_photos', array() );
    if ( ! is_array( $gallery_photos ) ) $gallery_photos = array();
    $details_gallery_photos = get_option( 'haven_details_gallery_photos', array() );
    if ( ! is_array( $details_gallery_photos ) ) $details_gallery_photos = array();
    if ( empty( $details_gallery_photos ) && ! empty( $gallery_photos ) ) {
        $details_gallery_photos = array_slice( $gallery_photos, 0, 4 );
    }
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Galeria e imagens</h1>
            <p>Gerencie o slider principal, a galeria de ambientes e as fotos de detalhe da landing page.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_gallery_media_group' ); ?>
            <div class="haven-admin-card">
                <h2>Fotos do banner principal</h2>
                <p class="description">Recomendamos pelo menos 3 fotos de alta resolucao (1920x1080 ou maior).</p>
                <div id="haven-hero-photos" class="haven-photo-grid">
                    <?php foreach ( $hero_photos as $i => $url ) : ?>
                    <div class="haven-photo-item" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $url ); ?>" alt="Hero <?php echo $i + 1; ?>">
                        <div class="haven-photo-actions">
                            <button type="button" class="button haven-change-photo" data-target="hero" data-index="<?php echo $i; ?>">Trocar</button>
                            <button type="button" class="button haven-remove-photo" data-target="hero" data-index="<?php echo $i; ?>">×</button>
                        </div>
                        <input type="hidden" name="haven_hero_photos[]" value="<?php echo esc_url( $url ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary haven-add-photo" data-target="hero" style="margin-top:12px;">+ Adicionar Foto ao Hero</button>
            </div>
            <div class="haven-admin-card">
                <h2>Fotos da galeria de ambientes</h2>
                <p class="description">Cada foto tera um card no carrossel e aparecera no lightbox.</p>
                <div id="haven-gallery-photos" class="haven-photo-grid">
                    <?php foreach ( $gallery_photos as $i => $item ) : ?>
                    <div class="haven-photo-item haven-photo-item-gallery" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $item['url'] ?? '' ); ?>" alt="<?php echo esc_attr( $item['title'] ?? 'Ambiente' ); ?>">
                        <div class="haven-photo-fields">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="Nome do ambiente">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][badge]" value="<?php echo esc_attr( $item['badge'] ?? '' ); ?>" placeholder="Badge (ex: Destaque)">
                            <textarea name="haven_gallery_photos[<?php echo $i; ?>][desc]" rows="3" placeholder="Descricao curta do ambiente"><?php echo esc_textarea( $item['desc'] ?? '' ); ?></textarea>
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat1]" value="<?php echo esc_attr( $item['feat1'] ?? '' ); ?>" placeholder="Feature 1">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat2]" value="<?php echo esc_attr( $item['feat2'] ?? '' ); ?>" placeholder="Feature 2">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat3]" value="<?php echo esc_attr( $item['feat3'] ?? '' ); ?>" placeholder="Feature 3">
                        </div>
                        <div class="haven-photo-actions">
                            <button type="button" class="button haven-change-photo" data-target="gallery" data-index="<?php echo $i; ?>">Trocar</button>
                            <button type="button" class="button haven-remove-photo" data-target="gallery" data-index="<?php echo $i; ?>">×</button>
                        </div>
                        <input type="hidden" name="haven_gallery_photos[<?php echo $i; ?>][url]" value="<?php echo esc_url( $item['url'] ?? '' ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary haven-add-gallery-photo" style="margin-top:12px;">+ Adicionar Ambiente</button>
            </div>
            <div class="haven-admin-card">
                <h2>Galeria de Detalhes (4 fotos)</h2>
                <p class="description">Essas miniaturas alimentam a galeria de 4 fotos da ficha tecnica. Se nada for definido aqui, o tema usa as 4 primeiras imagens da galeria de ambientes.</p>
                <div id="haven-details-gallery-photos" class="haven-photo-grid">
                    <?php foreach ( $details_gallery_photos as $i => $item ) : ?>
                    <div class="haven-photo-item haven-photo-item-details" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $item['url'] ?? '' ); ?>" alt="<?php echo esc_attr( $item['title'] ?? 'Detalhe' ); ?>">
                        <div class="haven-photo-fields">
                            <input type="text" name="haven_details_gallery_photos[<?php echo $i; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="Titulo opcional">
                            <textarea name="haven_details_gallery_photos[<?php echo $i; ?>][desc]" rows="2" placeholder="Legenda opcional"><?php echo esc_textarea( $item['desc'] ?? '' ); ?></textarea>
                        </div>
                        <div class="haven-photo-actions">
                            <button type="button" class="button haven-change-photo" data-target="details" data-index="<?php echo $i; ?>">Trocar</button>
                            <button type="button" class="button haven-remove-photo" data-target="details" data-index="<?php echo $i; ?>">x</button>
                        </div>
                        <input type="hidden" name="haven_details_gallery_photos[<?php echo $i; ?>][url]" value="<?php echo esc_url( $item['url'] ?? '' ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary haven-add-gallery-photo" data-target="details" style="margin-top:12px;">+ Adicionar Foto de Detalhe</button>
            </div>
            <div class="haven-admin-card">
                <h2>Controles da galeria principal</h2>
                <table class="form-table">
                    <tr>
                        <th>Auto-deslizar</th>
                        <td>
                            <input type="hidden" name="haven_gallery_autoplay" value="0">
                            <label><input type="checkbox" name="haven_gallery_autoplay" value="1" <?php checked( haven_opt( 'haven_gallery_autoplay' ), '1' ); ?>> Deslizar automaticamente para a direita</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Velocidade (ms)</th>
                        <td>
                            <input type="number" name="haven_gallery_autoplay_speed" value="<?php echo esc_attr( haven_opt( 'haven_gallery_autoplay_speed' ) ); ?>" class="small-text" min="1000" max="15000" step="500">
                            <p class="description">Tempo entre cada transicao em milissegundos (ex: 4000 = 4 segundos).</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Ordem aleatoria</th>
                        <td>
                            <input type="hidden" name="haven_gallery_random" value="0">
                            <label><input type="checkbox" name="haven_gallery_random" value="1" <?php checked( haven_opt( 'haven_gallery_random' ), '1' ); ?>> Embaralhar ordem dos cards a cada carregamento</label>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="haven-admin-card">
                <h2>Controles da galeria de detalhes</h2>
                <table class="form-table">
                    <tr>
                        <th>Auto-deslizar</th>
                        <td>
                            <input type="hidden" name="haven_details_gallery_autoplay" value="0">
                            <label><input type="checkbox" name="haven_details_gallery_autoplay" value="1" <?php checked( haven_opt( 'haven_details_gallery_autoplay' ), '1' ); ?>> Trocar foto automaticamente</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Velocidade (ms)</th>
                        <td>
                            <input type="number" name="haven_details_gallery_autoplay_speed" value="<?php echo esc_attr( haven_opt( 'haven_details_gallery_autoplay_speed' ) ); ?>" class="small-text" min="1000" max="15000" step="500">
                            <p class="description">Tempo entre cada troca de foto em milissegundos.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Ordem aleatoria</th>
                        <td>
                            <input type="hidden" name="haven_details_gallery_random" value="0">
                            <label><input type="checkbox" name="haven_details_gallery_random" value="1" <?php checked( haven_opt( 'haven_details_gallery_random' ), '1' ); ?>> Embaralhar ordem das fotos de detalhe a cada carregamento</label>
                        </td>
                    </tr>
                </table>
            </div>
            <?php submit_button( 'Salvar galerias e imagens' ); ?>
        </form>
    </div>
    <?php
}
}

function haven_render_visual_menu_rows( $location, $items, $pages, $sections, $types ) {
    if ( empty( $items ) ) {
        $items = array( array( 'label' => '', 'type' => 'section', 'value' => '', 'new_tab' => '0' ) );
    }

    foreach ( $items as $index => $item ) :
        $type = $item['type'] ?? 'section';
        ?>
        <div class="haven-menu-item" data-location="<?php echo esc_attr( $location ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
            <div class="haven-menu-item-handle" aria-hidden="true">↕</div>
            <div class="haven-menu-item-grid">
                <label>
                    <span>Texto</span>
                    <input type="text" name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][label]" value="<?php echo esc_attr( $item['label'] ?? '' ); ?>" placeholder="Ex: Galeria">
                </label>
                <label>
                    <span>Destino</span>
                    <select name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][type]" class="haven-menu-type">
                        <?php foreach ( $types as $type_key => $type_label ) : ?>
                            <option value="<?php echo esc_attr( $type_key ); ?>" <?php selected( $type, $type_key ); ?>><?php echo esc_html( $type_label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="haven-menu-value-section <?php echo 'section' === $type ? '' : 'is-hidden'; ?>">
                    <span>Secao</span>
                    <select name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][value]">
                        <?php foreach ( $sections as $section_value => $section_label ) : ?>
                            <option value="<?php echo esc_attr( $section_value ); ?>" <?php selected( $item['value'] ?? '', $section_value ); ?>><?php echo esc_html( $section_label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="haven-menu-value-page <?php echo 'page' === $type ? '' : 'is-hidden'; ?>">
                    <span>Pagina</span>
                    <select name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][value]">
                        <option value="">Selecione uma pagina</option>
                        <?php foreach ( $pages as $page ) : ?>
                            <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( (string) ( $item['value'] ?? '' ), (string) $page->ID ); ?>><?php echo esc_html( $page->post_title ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="haven-menu-value-url <?php echo 'url' === $type ? '' : 'is-hidden'; ?>">
                    <span>URL</span>
                    <input type="url" name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][value]" value="<?php echo 'url' === $type ? esc_attr( $item['value'] ?? '' ) : ''; ?>" placeholder="https://site.com/pagina">
                </label>
                <label class="haven-menu-value-email <?php echo 'email' === $type ? '' : 'is-hidden'; ?>">
                    <span>E-mail</span>
                    <input type="email" name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][value]" value="<?php echo 'email' === $type ? esc_attr( $item['value'] ?? '' ) : ''; ?>" placeholder="contato@site.com">
                </label>
                <label class="haven-menu-value-phone <?php echo 'phone' === $type ? '' : 'is-hidden'; ?>">
                    <span>Telefone</span>
                    <input type="text" name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][value]" value="<?php echo 'phone' === $type ? esc_attr( $item['value'] ?? '' ) : ''; ?>" placeholder="(61) 99999-9999">
                </label>
            </div>
            <div class="haven-menu-item-side">
                <label class="haven-switch-label">
                    <input type="checkbox" name="haven_visual_menus[<?php echo esc_attr( $location ); ?>][<?php echo esc_attr( $index ); ?>][new_tab]" value="1" <?php checked( $item['new_tab'] ?? '0', '1' ); ?>>
                    <span class="haven-switch-ui"></span>
                    <span class="haven-switch-text">Nova aba</span>
                </label>
                <button type="button" class="button haven-remove-menu-item">Remover</button>
            </div>
        </div>
        <?php
    endforeach;
}

function haven_admin_menus_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $types = haven_get_menu_link_type_options();
    $sections = haven_get_menu_section_targets();
    $pages = get_pages( array( 'sort_column' => 'menu_order,post_title', 'sort_order' => 'ASC' ) );
    $primary_items = haven_get_visual_menu_editor_items( 'primary' );
    $footer_items = haven_get_visual_menu_editor_items( 'footer' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Menus visuais</h1>
            <p>Edite os links do header e do rodape visualmente, escolhendo se cada item leva a uma secao, pagina do site, URL externa, e-mail ou telefone.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_menus_group' ); ?>
            <div class="haven-admin-card">
                <h2>Menu principal</h2>
                <p class="description">Esse menu aparece no topo do site. Arraste para reordenar os itens.</p>
                <div class="haven-visual-menu-list" data-location="primary">
                    <?php haven_render_visual_menu_rows( 'primary', $primary_items, $pages, $sections, $types ); ?>
                </div>
                <button type="button" class="button button-primary haven-add-menu-item" data-location="primary">+ Adicionar item ao header</button>
            </div>
            <div class="haven-admin-card">
                <h2>Menu do rodape</h2>
                <p class="description">Esse menu aparece na coluna principal do rodape.</p>
                <div class="haven-visual-menu-list" data-location="footer">
                    <?php haven_render_visual_menu_rows( 'footer', $footer_items, $pages, $sections, $types ); ?>
                </div>
                <button type="button" class="button button-primary haven-add-menu-item" data-location="footer">+ Adicionar item ao rodape</button>
            </div>
            <?php submit_button( 'Salvar menus visuais' ); ?>
        </form>
        <script type="text/template" id="haven-menu-item-template">
            <div class="haven-menu-item" data-location="__LOCATION__" data-index="__INDEX__">
                <div class="haven-menu-item-handle" aria-hidden="true">↕</div>
                <div class="haven-menu-item-grid">
                    <label>
                        <span>Texto</span>
                        <input type="text" name="haven_visual_menus[__LOCATION__][__INDEX__][label]" value="" placeholder="Ex: Galeria">
                    </label>
                    <label>
                        <span>Destino</span>
                        <select name="haven_visual_menus[__LOCATION__][__INDEX__][type]" class="haven-menu-type">
                            <?php foreach ( $types as $type_key => $type_label ) : ?>
                                <option value="<?php echo esc_attr( $type_key ); ?>"><?php echo esc_html( $type_label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="haven-menu-value-section">
                        <span>Secao</span>
                        <select name="haven_visual_menus[__LOCATION__][__INDEX__][value]">
                            <?php foreach ( $sections as $section_value => $section_label ) : ?>
                                <option value="<?php echo esc_attr( $section_value ); ?>"><?php echo esc_html( $section_label ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="haven-menu-value-page is-hidden">
                        <span>Pagina</span>
                        <select name="haven_visual_menus[__LOCATION__][__INDEX__][value]">
                            <option value="">Selecione uma pagina</option>
                            <?php foreach ( $pages as $page ) : ?>
                                <option value="<?php echo esc_attr( $page->ID ); ?>"><?php echo esc_html( $page->post_title ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="haven-menu-value-url is-hidden">
                        <span>URL</span>
                        <input type="url" name="haven_visual_menus[__LOCATION__][__INDEX__][value]" value="" placeholder="https://site.com/pagina">
                    </label>
                    <label class="haven-menu-value-email is-hidden">
                        <span>E-mail</span>
                        <input type="email" name="haven_visual_menus[__LOCATION__][__INDEX__][value]" value="" placeholder="contato@site.com">
                    </label>
                    <label class="haven-menu-value-phone is-hidden">
                        <span>Telefone</span>
                        <input type="text" name="haven_visual_menus[__LOCATION__][__INDEX__][value]" value="" placeholder="(61) 99999-9999">
                    </label>
                </div>
                <div class="haven-menu-item-side">
                    <label class="haven-switch-label">
                        <input type="checkbox" name="haven_visual_menus[__LOCATION__][__INDEX__][new_tab]" value="1">
                        <span class="haven-switch-ui"></span>
                        <span class="haven-switch-text">Nova aba</span>
                    </label>
                    <button type="button" class="button haven-remove-menu-item">Remover</button>
                </div>
            </div>
        </script>
    </div>
    <?php
}
}

function haven_admin_preloader_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $header_logo = haven_get_header_logo_image();
    $effects = haven_get_preloader_effect_options();
    $animations = haven_get_preloader_logo_animation_options();
    $bg = haven_opt( 'haven_preloader_bg_color' );
    $accent = haven_opt( 'haven_preloader_accent_color' );
    $logo_size = haven_opt( 'haven_preloader_logo_size' );
    $effect = haven_opt( 'haven_preloader_effect' );
    $animation = haven_opt( 'haven_preloader_logo_animation' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Preloader</h1>
            <p>Personalize a tela inicial de carregamento com cores, efeito da barra e animacao da logo.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_preloader_group' ); ?>
            <div class="haven-admin-card">
                <h2>Configuracoes do preloader</h2>
                <table class="form-table">
                    <tr>
                        <th>Ativar preloader</th>
                        <td>
                            <input type="hidden" name="haven_preloader_enabled" value="0">
                            <label class="haven-switch-label">
                                <input type="checkbox" name="haven_preloader_enabled" value="1" <?php checked( haven_opt( 'haven_preloader_enabled' ), '1' ); ?>>
                                <span class="haven-switch-ui"></span>
                                <span class="haven-switch-text">Exibir tela de abertura antes do site</span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th>Cor de fundo</th>
                        <td><input type="text" name="haven_preloader_bg_color" value="<?php echo esc_attr( $bg ); ?>" class="haven-color-field haven-preloader-live" data-preview-prop="backgroundColor" data-preview-target="haven-preloader-preview"></td>
                    </tr>
                    <tr>
                        <th>Cor do efeito</th>
                        <td><input type="text" name="haven_preloader_accent_color" value="<?php echo esc_attr( $accent ); ?>" class="haven-color-field haven-preloader-live" data-preview-prop="accentColor" data-preview-target="haven-preloader-preview"></td>
                    </tr>
                    <tr>
                        <th>Tamanho da logo</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_preloader_logo_size" min="36" max="140" step="2" value="<?php echo esc_attr( $logo_size ); ?>" class="haven-live-range haven-preloader-live" data-value-target="preloader-logo-size" data-preview-target="haven-preloader-logo-preview" data-preview-prop="maxHeight" data-preview-suffix="px">
                                <span class="haven-range-val" id="preloader-logo-size"><?php echo esc_html( $logo_size ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Efeito de carregamento</th>
                        <td>
                            <select name="haven_preloader_effect" class="haven-preloader-select" data-preview-class-target="haven-preloader-preview" data-preview-class-prefix="effect-">
                                <?php foreach ( $effects as $key => $label ) : ?>
                                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $effect, $key ); ?>><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Animacao da logo</th>
                        <td>
                            <select name="haven_preloader_logo_animation" class="haven-preloader-select" data-preview-class-target="haven-preloader-preview" data-preview-class-prefix="logo-anim-">
                                <?php foreach ( $animations as $key => $label ) : ?>
                                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $animation, $key ); ?>><?php echo esc_html( $label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="haven-admin-card">
                <h2>Preview</h2>
                <div id="haven-preloader-preview" class="haven-range-preview haven-preloader-preview effect-<?php echo esc_attr( $effect ); ?> logo-anim-<?php echo esc_attr( $animation ); ?>" style="background-color:<?php echo esc_attr( $bg ); ?>;--haven-preloader-preview-accent:<?php echo esc_attr( $accent ); ?>;">
                    <div class="haven-preloader-preview-inner">
                        <div class="haven-preloader-preview-logo">
                            <?php if ( $header_logo ) : ?>
                                <img id="haven-preloader-logo-preview" src="<?php echo esc_url( $header_logo ); ?>" alt="Logo preloader" style="max-height:<?php echo esc_attr( $logo_size ); ?>px;">
                            <?php else : ?>
                                <div id="haven-preloader-logo-preview" class="haven-preloader-preview-text" style="max-height:<?php echo esc_attr( $logo_size ); ?>px;"><?php echo esc_html( haven_opt( 'haven_header_brand' ) ); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="haven-preloader-preview-loader">
                            <span class="haven-preloader-preview-bar"></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php submit_button( 'Salvar preloader' ); ?>
        </form>
    </div>
    <?php
}

function haven_admin_textos_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header"><h1>Imovel e contato</h1><p>Edite os dados do imovel, textos de apoio, amenidades e informacoes de contato.</p></div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_text_group' ); ?>
            <div class="haven-admin-card"><h2>Banner Principal</h2>
                <table class="form-table">
                    <tr><th>Tagline</th><td><input type="text" name="haven_property_tagline" value="<?php echo esc_attr( haven_opt( 'haven_property_tagline' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Titulo</th><td><input type="text" name="haven_hero_title" value="<?php echo esc_attr( haven_opt( 'haven_hero_title' ) ); ?>" class="large-text"><p class="description">Use &lt;em&gt;palavra&lt;/em&gt; para italico dourado.</p></td></tr>
                    <tr><th>Subtitulo</th><td><textarea name="haven_hero_subtitle" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_hero_subtitle' ) ); ?></textarea></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>Dados do Imovel</h2>
                <table class="form-table">
                    <tr><th>Nome</th><td><input type="text" name="haven_property_name" value="<?php echo esc_attr( haven_opt( 'haven_property_name' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Preco</th><td><input type="text" name="haven_property_price" value="<?php echo esc_attr( haven_opt( 'haven_property_price' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Endereco</th><td><input type="text" name="haven_property_address" value="<?php echo esc_attr( haven_opt( 'haven_property_address' ) ); ?>" class="large-text"></td></tr>
                    <tr>
                        <th>Descricao</th>
                        <td>
                            <?php
                            wp_editor(
                                haven_opt( 'haven_property_description' ),
                                'haven_property_description',
                                array(
                                    'textarea_name' => 'haven_property_description',
                                    'textarea_rows' => 10,
                                    'media_buttons' => false,
                                    'teeny'         => false,
                                    'quicktags'     => true,
                                )
                            );
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>Especificacoes</h2>
                <table class="form-table">
                    <tr><th>Area (m²)</th><td><input type="text" name="haven_stat_area" value="<?php echo esc_attr( haven_opt( 'haven_stat_area' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Terreno (m²)</th><td><input type="text" name="haven_stat_terreno" value="<?php echo esc_attr( haven_opt( 'haven_stat_terreno' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Suites</th><td><input type="text" name="haven_stat_suites" value="<?php echo esc_attr( haven_opt( 'haven_stat_suites' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Banheiros</th><td><input type="text" name="haven_stat_banheiros" value="<?php echo esc_attr( haven_opt( 'haven_stat_banheiros' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Vagas</th><td><input type="text" name="haven_stat_vagas" value="<?php echo esc_attr( haven_opt( 'haven_stat_vagas' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Construcao</th><td><input type="text" name="haven_stat_construcao" value="<?php echo esc_attr( haven_opt( 'haven_stat_construcao' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Piscina</th><td><input type="text" name="haven_stat_piscina" value="<?php echo esc_attr( haven_opt( 'haven_stat_piscina' ) ); ?>" class="small-text"></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>Amenidades</h2>
                <table class="form-table">
                    <tr><th>Lista</th><td><textarea name="haven_amenities" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_amenities' ) ); ?></textarea><p class="description">Separe por virgula.</p></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>Contato</h2>
                <table class="form-table">
                    <tr><th>WhatsApp (numeros)</th><td><input type="text" name="haven_whatsapp" value="<?php echo esc_attr( haven_opt( 'haven_whatsapp' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Telefone</th><td><input type="text" name="haven_telefone" value="<?php echo esc_attr( haven_opt( 'haven_telefone' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>E-mail</th><td><input type="email" name="haven_email" value="<?php echo esc_attr( haven_opt( 'haven_email' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>CRECI</th><td><input type="text" name="haven_creci" value="<?php echo esc_attr( haven_opt( 'haven_creci' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>
            <?php submit_button( 'Salvar Informacoes' ); ?>
        </form>
    </div>
    <?php
}

// ===================================================================
// 8. REQUIRED PLUGINS (TGM Plugin Activation)
// ===================================================================
require_once HAVEN_DIR . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'haven_register_required_plugins' );
function haven_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Elementor',
            'slug'      => 'elementor',
            'required'  => true,
            'force_activation' => false,
            'force_deactivation' => false,
        ),
    );

    $bundled_plugins = array(
        array(
            'name'     => 'Haven Landing Options',
            'slug'     => 'haven-landing-options',
            'source'   => HAVEN_DIR . '/dist/haven-landing-options-1.0.4.zip',
            'required' => false,
            'version'  => '1.0.4',
        ),
        array(
            'name'     => 'Haven Landing Sections',
            'slug'     => 'haven-landing-sections',
            'source'   => HAVEN_DIR . '/dist/haven-landing-sections-1.0.4.zip',
            'required' => false,
            'version'  => '1.0.4',
        ),
        array(
            'name'     => 'Haven Media Suite',
            'slug'     => 'haven-media-suite',
            'source'   => HAVEN_DIR . '/dist/haven-media-suite-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
        array(
            'name'     => 'Haven Visual Menus',
            'slug'     => 'haven-visual-menus',
            'source'   => HAVEN_DIR . '/dist/haven-visual-menus-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
        array(
            'name'     => 'Haven Leads and WhatsApp',
            'slug'     => 'haven-leads-whatsapp',
            'source'   => HAVEN_DIR . '/dist/haven-leads-whatsapp-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
        array(
            'name'     => 'Haven White Label Login',
            'slug'     => 'haven-white-label-login',
            'source'   => HAVEN_DIR . '/dist/haven-white-label-login-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
        array(
            'name'     => 'Haven Elementor Bridge',
            'slug'     => 'haven-elementor-bridge',
            'source'   => HAVEN_DIR . '/dist/haven-elementor-bridge-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
        array(
            'name'     => 'Haven Admin Shell',
            'slug'     => 'haven-admin-shell',
            'source'   => HAVEN_DIR . '/dist/haven-admin-shell-1.0.1.zip',
            'required' => false,
            'version'  => '1.0.1',
        ),
    );

    foreach ( $bundled_plugins as $bundled_plugin ) {
        if ( ! empty( $bundled_plugin['source'] ) && file_exists( $bundled_plugin['source'] ) ) {
            $plugins[] = $bundled_plugin;
        }
    }

    $config = array(
        'id'           => 'haven-clone',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );
    tgmpa( $plugins, $config );
}

// ===================================================================
// 9. GLOBAL COLORS (CSS VARIABLES)
// ===================================================================
function haven_get_color_defaults() {
    return array(
        'haven_color_white'        => '#ffffff',
        'haven_color_cream'        => '#faf8f5',
        'haven_color_sand'         => '#f3efe8',
        'haven_color_warm_gray'    => '#b8b0a4',
        'haven_color_text'         => '#2c2824',
        'haven_color_text_light'   => '#6b6560',
        'haven_color_gold'         => '#c8a45e',
        'haven_color_gold_light'   => '#e8d5a0',
        'haven_color_gold_dark'    => '#a07d3a',
        'haven_color_dark'         => '#1a1714',
        'haven_color_accent'       => '#3a6b5e',
        'haven_color_accent_light' => '#e8f0ed',
    );
}

function haven_register_color_settings() {
    $keys = array_keys( haven_get_color_defaults() );
    foreach ( $keys as $key ) {
        register_setting( 'haven_color_group', $key, array( 'sanitize_callback' => 'sanitize_hex_color' ) );
    }
}
add_action( 'admin_init', 'haven_register_color_settings' );

function haven_admin_menu_colors() {
    add_submenu_page(
        'haven-gestao',
        'Cores Globais',
        'Cores',
        'manage_options',
        'haven-cores',
        'haven_admin_cores_render'
    );
}
add_action( 'admin_menu', 'haven_admin_menu_colors' );

function haven_add_inline_color_vars() {
    $defaults = haven_get_color_defaults();
    $pairs = array(
        '--hv-white'        => haven_opt( 'haven_color_white' ),
        '--hv-cream'        => haven_opt( 'haven_color_cream' ),
        '--hv-sand'         => haven_opt( 'haven_color_sand' ),
        '--hv-warm-gray'    => haven_opt( 'haven_color_warm_gray' ),
        '--hv-text'         => haven_opt( 'haven_color_text' ),
        '--hv-text-light'   => haven_opt( 'haven_color_text_light' ),
        '--hv-gold'         => haven_opt( 'haven_color_gold' ),
        '--hv-gold-light'   => haven_opt( 'haven_color_gold_light' ),
        '--hv-gold-dark'    => haven_opt( 'haven_color_gold_dark' ),
        '--hv-dark'         => haven_opt( 'haven_color_dark' ),
        '--hv-accent'       => haven_opt( 'haven_color_accent' ),
        '--hv-accent-light' => haven_opt( 'haven_color_accent_light' ),
    );

    $css = ':root{';
    foreach ( $pairs as $var => $val ) {
        $san = sanitize_hex_color( $val );
        if ( ! $san ) {
            $san = sanitize_hex_color( $defaults[ str_replace( '--hv-', 'haven_color_', $var ) ] ?? '' );
        }
        if ( ! $san ) continue;
        $css .= $var . ':' . $san . ';';
    }
    $css .= '}';

    wp_add_inline_style( 'haven-premium', $css );
}
add_action( 'wp_enqueue_scripts', 'haven_add_inline_color_vars', 30 );

function haven_admin_cores_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $defaults = haven_get_color_defaults();
    $fields = array(
        array( 'key' => 'haven_color_gold', 'label' => 'Dourado (primario)', 'desc' => 'Botoes, destaques e labels.' ),
        array( 'key' => 'haven_color_accent', 'label' => 'Accent', 'desc' => 'Acentos secundarios.' ),
        array( 'key' => 'haven_color_text', 'label' => 'Texto', 'desc' => 'Texto principal.' ),
        array( 'key' => 'haven_color_text_light', 'label' => 'Texto suave', 'desc' => 'Subtitulos e textos secundarios.' ),
        array( 'key' => 'haven_color_white', 'label' => 'Branco (base)', 'desc' => 'Fundo base.' ),
        array( 'key' => 'haven_color_cream', 'label' => 'Creme', 'desc' => 'Fundos suaves.' ),
        array( 'key' => 'haven_color_sand', 'label' => 'Areia', 'desc' => 'Fundos e separadores.' ),
        array( 'key' => 'haven_color_warm_gray', 'label' => 'Cinza quente', 'desc' => 'Bordas e contornos.' ),
        array( 'key' => 'haven_color_gold_light', 'label' => 'Dourado claro', 'desc' => 'Realces e variacoes.' ),
        array( 'key' => 'haven_color_gold_dark', 'label' => 'Dourado escuro', 'desc' => 'Hover/contraste do dourado.' ),
        array( 'key' => 'haven_color_dark', 'label' => 'Escuro', 'desc' => 'Fundos escuros/contraste.' ),
        array( 'key' => 'haven_color_accent_light', 'label' => 'Accent claro', 'desc' => 'Fundos suaves do accent.' ),
    );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Cores Globais</h1>
            <p>Altere a paleta global do tema (variaveis CSS usadas no layout).</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_color_group' ); ?>
            <div class="haven-admin-card">
                <table class="form-table">
                    <?php foreach ( $fields as $f ) : $key = $f['key']; ?>
                        <tr>
                            <th><?php echo esc_html( $f['label'] ); ?></th>
                            <td>
                                <input
                                    type="text"
                                    name="<?php echo esc_attr( $key ); ?>"
                                    value="<?php echo esc_attr( haven_opt( $key ) ); ?>"
                                    class="haven-color-field"
                                    data-default-color="<?php echo esc_attr( $defaults[ $key ] ?? '' ); ?>"
                                />
                                <?php if ( ! empty( $f['desc'] ) ) : ?>
                                    <p class="description"><?php echo esc_html( $f['desc'] ); ?></p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php submit_button( 'Salvar Cores' ); ?>
        </form>
    </div>
    <?php
}
// ===================================================================
// 10. ADMIN IA + UI SETTINGS
// ===================================================================
// Loaded from /inc/haven-options-core.php

if ( ! function_exists( 'haven_can_use_simplified_admin' ) ) {
function haven_can_use_simplified_admin() {
    return is_user_logged_in() && current_user_can( 'manage_options' );
}

function haven_get_admin_mode() {
    if ( ! haven_can_use_simplified_admin() ) {
        return 'native';
    }

    $mode = get_user_meta( get_current_user_id(), 'haven_admin_mode', true );
    return $mode === 'native' ? 'native' : 'simple';
}

function haven_set_admin_mode( $mode, $user_id = 0 ) {
    $user_id = $user_id ? absint( $user_id ) : get_current_user_id();
    if ( ! $user_id ) {
        return;
    }

    update_user_meta( $user_id, 'haven_admin_mode', $mode === 'native' ? 'native' : 'simple' );
}

function haven_force_reset_options() {
    if ( get_option( 'haven_options_reset_v5' ) ) {
        return;
    }

    // This hook used to delete all saved landing options on first boot after
    // the marker was missing, which made custom videos fall back to defaults.
    // Keep the migration flag for backward compatibility, but never wipe data
    // automatically during runtime.
    update_option( 'haven_options_reset_v5', true );
}
add_action( 'init', 'haven_force_reset_options' );

function haven_reset_admin_mode_on_login( $user_login, $user ) {
    if ( $user instanceof WP_User && user_can( $user, 'manage_options' ) ) {
        haven_set_admin_mode( 'simple', $user->ID );
    }
}
add_action( 'wp_login', 'haven_reset_admin_mode_on_login', 10, 2 );

function haven_login_redirect_to_panel( $redirect_to, $requested_redirect_to, $user ) {
    if ( $user instanceof WP_User && user_can( $user, 'manage_options' ) ) {
        return haven_get_editor_panel_url();
    }

    return $redirect_to;
}
add_filter( 'login_redirect', 'haven_login_redirect_to_panel', 10, 3 );

function haven_admin_menu_item_label( $icon_class, $label ) {
    return sprintf(
        '<span class="haven-menu-label"><span class="dashicons %1$s" aria-hidden="true"></span><span class="haven-menu-label-text">%2$s</span></span>',
        esc_attr( $icon_class ),
        esc_html( $label )
    );
}

function haven_admin_dock_icon_from_post_type( $post_type, $post_type_object = null ) {
    $map = array(
        'post'              => 'dashicons-admin-post',
        'page'              => 'dashicons-admin-page',
        'attachment'        => 'dashicons-format-image',
        'elementor_library' => 'dashicons-layout',
    );

    if ( isset( $map[ $post_type ] ) ) {
        return $map[ $post_type ];
    }

    if ( $post_type_object && ! empty( $post_type_object->menu_icon ) && str_starts_with( $post_type_object->menu_icon, 'dashicons-' ) ) {
        return $post_type_object->menu_icon;
    }

    return 'dashicons-admin-post';
}

function haven_get_quick_create_links() {
    $links = array();

    if ( post_type_exists( 'post' ) ) {
        $post_type_object = get_post_type_object( 'post' );
        if ( $post_type_object && current_user_can( $post_type_object->cap->create_posts ) ) {
            $links[] = array(
                'url'   => admin_url( 'post-new.php' ),
                'label' => $post_type_object->labels->singular_name,
                'icon'  => haven_admin_dock_icon_from_post_type( 'post', $post_type_object ),
            );
        }
    }

    if ( current_user_can( 'upload_files' ) ) {
        $links[] = array(
            'url'   => admin_url( 'media-new.php' ),
            'label' => 'Midia',
            'icon'  => 'dashicons-format-image',
        );
    }

    if ( post_type_exists( 'page' ) ) {
        $page_type_object = get_post_type_object( 'page' );
        if ( $page_type_object && current_user_can( $page_type_object->cap->create_posts ) ) {
            $links[] = array(
                'url'   => admin_url( 'post-new.php?post_type=page' ),
                'label' => $page_type_object->labels->singular_name,
                'icon'  => haven_admin_dock_icon_from_post_type( 'page', $page_type_object ),
            );
        }
    }

    $excluded_types = array( 'post', 'page', 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'wp_navigation' );
    $post_types     = get_post_types( array( 'show_ui' => true ), 'objects' );

    foreach ( $post_types as $post_type => $post_type_object ) {
        if ( in_array( $post_type, $excluded_types, true ) ) {
            continue;
        }

        if ( empty( $post_type_object->cap->create_posts ) || ! current_user_can( $post_type_object->cap->create_posts ) ) {
            continue;
        }

        $links[] = array(
            'url'   => admin_url( 'post-new.php?post_type=' . $post_type ),
            'label' => $post_type_object->labels->singular_name,
            'icon'  => haven_admin_dock_icon_from_post_type( $post_type, $post_type_object ),
        );
    }

    if ( current_user_can( 'create_users' ) ) {
        $links[] = array(
            'url'   => admin_url( 'user-new.php' ),
            'label' => 'Usuario',
            'icon'  => 'dashicons-admin-users',
        );
    }

    return $links;
}

function haven_admin_menu_rebuild() {
    global $menu, $submenu;

    remove_menu_page( 'haven-gestao' );
    unset( $submenu['haven-gestao'] );

    add_menu_page(
        'Painel da Residencia',
        'Residencia JB',
        'manage_options',
        'haven-gestao',
        'haven_admin_dashboard_render',
        'dashicons-admin-home',
        3
    );

    add_submenu_page( 'haven-gestao', 'Header e navegacao', haven_admin_menu_item_label( 'dashicons-layout', 'Header e navegacao' ), 'manage_options', 'haven-header', 'haven_admin_header_render' );
    add_submenu_page( 'haven-gestao', 'Conteudo da landing', haven_admin_menu_item_label( 'dashicons-screenoptions', 'Conteudo da landing' ), 'manage_options', 'haven-secoes', 'haven_admin_sections_render' );
    add_submenu_page( 'haven-gestao', 'Galeria e imagens', haven_admin_menu_item_label( 'dashicons-format-gallery', 'Galeria e imagens' ), 'manage_options', 'haven-fotos', 'haven_admin_fotos_render' );
    add_submenu_page( 'haven-gestao', 'Tours e videos', haven_admin_menu_item_label( 'dashicons-video-alt3', 'Tours e videos' ), 'manage_options', 'haven-tours', 'haven_admin_tours_render' );
    add_submenu_page( 'haven-gestao', 'Depoimentos', haven_admin_menu_item_label( 'dashicons-format-quote', 'Depoimentos' ), 'manage_options', 'haven-depoimentos', 'haven_admin_testimonials_render' );
    add_submenu_page( 'haven-gestao', 'Imovel e contato', haven_admin_menu_item_label( 'dashicons-admin-home', 'Imovel e contato' ), 'manage_options', 'haven-textos', 'haven_admin_textos_render' );
    add_submenu_page( 'haven-gestao', 'Conversao e WhatsApp', haven_admin_menu_item_label( 'dashicons-email-alt', 'Conversao e WhatsApp' ), 'manage_options', 'haven-cta-form', 'haven_admin_cta_form_render' );
    add_submenu_page( 'haven-gestao', 'Menus visuais', haven_admin_menu_item_label( 'dashicons-menu', 'Menus visuais' ), 'manage_options', 'haven-menus', 'haven_admin_menus_render' );
    add_submenu_page( 'haven-gestao', 'Rodape e redes', haven_admin_menu_item_label( 'dashicons-editor-kitchensink', 'Rodape e redes' ), 'manage_options', 'haven-footer', 'haven_admin_footer_render' );
    add_submenu_page( 'haven-gestao', 'Preloader', haven_admin_menu_item_label( 'dashicons-update', 'Preloader' ), 'manage_options', 'haven-preloader', 'haven_admin_preloader_render' );
    add_submenu_page( 'haven-gestao', 'Cores', haven_admin_menu_item_label( 'dashicons-art', 'Cores' ), 'manage_options', 'haven-cores', 'haven_admin_cores_render' );
    add_submenu_page( 'haven-gestao', 'Tipografia', haven_admin_menu_item_label( 'dashicons-editor-textcolor', 'Tipografia' ), 'manage_options', 'haven-tipografia', 'haven_admin_tipografia_render' );
    add_submenu_page( 'haven-gestao', 'Tela de login', haven_admin_menu_item_label( 'dashicons-lock', 'Tela de login' ), 'manage_options', 'haven-login', 'haven_admin_login_render' );
    if ( haven_get_admin_mode() === 'native' ) {
        add_submenu_page( 'haven-gestao', 'Voltar ao painel', haven_admin_menu_item_label( 'dashicons-arrow-left-alt2', 'Voltar ao painel' ), 'manage_options', 'haven-simple-mode', 'haven_admin_simple_mode_render' );
    } else {
        add_submenu_page( 'haven-gestao', 'Abrir WordPress nativo', haven_admin_menu_item_label( 'dashicons-admin-site-alt3', 'Abrir WordPress nativo' ), 'manage_options', 'haven-native-mode', 'haven_admin_native_mode_render' );
    }

    if ( isset( $submenu['haven-gestao'] ) ) {
        foreach ( $submenu['haven-gestao'] as $index => $item ) {
            if ( isset( $item[2] ) && $item[2] === 'haven-gestao' ) {
                unset( $submenu['haven-gestao'][ $index ] );
            }
        }
        $submenu['haven-gestao'] = array_values( $submenu['haven-gestao'] );
    }
}

remove_action( 'admin_menu', 'haven_admin_menu' );
remove_action( 'admin_menu', 'haven_admin_menu_colors' );
add_action( 'admin_menu', 'haven_admin_menu_rebuild', 99 );

function haven_hide_default_admin_menus() {
    global $menu;

    if ( ! haven_can_use_simplified_admin() || haven_get_admin_mode() === 'native' ) {
        return;
    }

    if ( ! is_array( $menu ) ) {
        return;
    }

    foreach ( $menu as $item ) {
        if ( empty( $item[2] ) ) {
            continue;
        }

        if ( $item[2] === 'haven-gestao' ) {
            continue;
        }

        remove_menu_page( $item[2] );
    }
}
add_action( 'admin_menu', 'haven_hide_default_admin_menus', 1000 );

function haven_redirect_dashboard_to_panel() {
    if ( ! haven_can_use_simplified_admin() || haven_get_admin_mode() === 'native' ) {
        return;
    }

    if ( wp_doing_ajax() ) {
        return;
    }

    global $pagenow;

    $allowed_pages = array(
        'haven-gestao',
        'haven-header',
        'haven-secoes',
        'haven-depoimentos',
        'haven-fotos',
        'haven-tours',
        'haven-preloader',
        'haven-menus',
        'haven-matterport',
        'haven-textos',
        'haven-cta-form',
        'haven-footer',
        'haven-login',
        'haven-cores',
        'haven-tipografia',
        'haven-native-mode',
        'haven-simple-mode',
    );

    if ( $pagenow === 'options.php' || $pagenow === 'admin-ajax.php' || $pagenow === 'async-upload.php' ) {
        return;
    }

    if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && 'haven-theme-plugins' === sanitize_key( wp_unslash( $_GET['page'] ) ) ) {
        wp_safe_redirect( admin_url( 'admin.php?page=haven-gestao' ) );
        exit;
    }

    if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && in_array( sanitize_key( wp_unslash( $_GET['page'] ) ), $allowed_pages, true ) ) {
        return;
    }

    if ( $pagenow === 'index.php' || $pagenow !== 'admin.php' ) {
        wp_safe_redirect( admin_url( 'admin.php?page=haven-gestao' ) );
        exit;
    }
}
add_action( 'admin_init', 'haven_redirect_dashboard_to_panel' );

function haven_admin_mode_toggle_styles() {
    if ( ! haven_can_use_simplified_admin() ) {
        return;
    }

    $target = haven_get_admin_mode() === 'native' ? 'haven-simple-mode' : 'haven-native-mode';
    ?>
    <style>
        #adminmenu .toplevel_page_haven-gestao .wp-submenu a[href*="page=<?php echo esc_attr( $target ); ?>"] {
            margin-top: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #c8a45e, #a07d3a);
            color: #1a1714 !important;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 8px 18px rgba(200, 164, 94, 0.28);
        }

        #adminmenu .toplevel_page_haven-gestao .wp-submenu a[href*="page=<?php echo esc_attr( $target ); ?>"]:hover {
            color: #1a1714 !important;
            filter: brightness(1.03);
        }
    </style>
    <?php
}
add_action( 'admin_head', 'haven_admin_mode_toggle_styles' );

function haven_admin_dashboard_fallback_styles() {
    if ( haven_get_admin_page_slug() !== 'haven-gestao' ) {
        return;
    }
    ?>
    <style>
        .toplevel_page_haven-gestao .haven-admin-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) !important;
            gap: 1rem !important;
            align-items: stretch;
        }

        .toplevel_page_haven-gestao .haven-admin-linkcard {
            display: flex !important;
            flex-direction: column;
            min-height: 100%;
            background: #fff;
            border: 1px solid #e5e0d8;
            border-radius: 14px;
            padding: 1.4rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        }

        .toplevel_page_haven-gestao .haven-admin-linkcard-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
            margin-top: auto;
            padding: 0.65rem 1rem;
            border-radius: 999px;
            background: rgba(200, 164, 94, 0.12);
            color: #a07d3a;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
    <?php
}
add_action( 'admin_head', 'haven_admin_dashboard_fallback_styles', 20 );

function haven_get_editor_panel_url( $compact = false ) {
    return admin_url( 'admin.php?page=haven-gestao' );
}

function haven_get_admin_mode_switch_url( $mode, $compact = false ) {
    $target = $mode === 'native' ? 'haven-native-mode' : 'haven-simple-mode';
    return admin_url( 'admin.php?page=' . $target );
}

function haven_is_compact_admin_request() {
    return false;
}

function haven_admin_body_class( $classes ) {
    if ( ! haven_can_use_simplified_admin() ) {
        return $classes;
    }

    $classes = trim( preg_replace( '/\bfolded\b/', '', $classes ) );
    $classes .= ' haven-admin-shell';

    if ( haven_get_admin_mode() !== 'native' ) {
        $classes .= ' haven-simple-admin';
    }

    return $classes;
}
add_filter( 'admin_body_class', 'haven_admin_body_class' );

function haven_admin_bar_editor_redirects( $wp_admin_bar ) {
    if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    foreach ( array( 'new-content', 'customize', 'updates', 'comments', 'view-site', 'dashboard', 'themes', 'widgets', 'menus', 'site-editor', 'my-account' ) as $node_id ) {
        $wp_admin_bar->remove_node( $node_id );
    }

    $panel_url      = haven_get_editor_panel_url();
    $visit_site_url = home_url( '/' );
    $site_name_url  = is_admin() ? $visit_site_url : $panel_url;

    if ( $wp_admin_bar->get_node( 'site-name' ) ) {
        $wp_admin_bar->add_node(
            array(
                'id'    => 'site-name',
                'href'  => $site_name_url,
                'meta'  => array(
                    'class' => 'ab-item haven-admin-bar-link haven-admin-bar-site-name',
                ),
            )
        );
    }

    $wp_admin_bar->add_node(
        array(
            'id'    => 'haven-editor',
            'title' => 'Editor Haven',
            'href'  => $panel_url,
            'meta'  => array( 'class' => 'haven-admin-bar-link' ),
        )
    );
}
add_action( 'admin_bar_menu', 'haven_admin_bar_editor_redirects', 80 );

function haven_admin_dashboard_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $featured_pages = array(
        array(
            'title' => 'Header e navegacao',
            'eyebrow' => 'Identidade',
            'desc'  => 'Logo, marca de fallback, CTA do topo e comportamento do botao principal.',
            'url'   => admin_url( 'admin.php?page=haven-header' ),
        ),
        array(
            'title' => 'Conteudo da landing',
            'eyebrow' => 'Estrutura',
            'desc'  => 'Botoes do hero, secoes do site, localizacao e CTA final sem misturar tours.',
            'url'   => admin_url( 'admin.php?page=haven-secoes' ),
        ),
        array(
            'title' => 'Galeria e imagens',
            'eyebrow' => 'Midia',
            'desc'  => 'Slider do hero, galeria de ambientes e imagens de detalhe.',
            'url'   => admin_url( 'admin.php?page=haven-fotos' ),
        ),
    );

    $support_pages = array(
        array(
            'title' => 'Menus visuais',
            'eyebrow' => 'Navegacao',
            'desc'  => 'Crie, edite, reordene e remova links do header e do rodape com destinos visuais.',
            'url'   => admin_url( 'admin.php?page=haven-menus' ),
        ),
        array(
            'title' => 'Preloader',
            'eyebrow' => 'Abertura',
            'desc'  => 'Edite visualmente a tela inicial de carregamento, efeito e animacao da logo.',
            'url'   => admin_url( 'admin.php?page=haven-preloader' ),
        ),
        array(
            'title' => 'Depoimentos',
            'eyebrow' => 'Prova social',
            'desc'  => 'Gerencie a secao de depoimentos em uma area dedicada e mais organizada.',
            'url'   => admin_url( 'admin.php?page=haven-depoimentos' ),
        ),
        array(
            'title' => 'Tours e videos',
            'eyebrow' => 'Imersao',
            'desc'  => 'YouTube, Matterport, titulos, subtitulos e exibicao das secoes de tour.',
            'url'   => admin_url( 'admin.php?page=haven-tours' ),
        ),
        array(
            'title' => 'Imovel e contato',
            'eyebrow' => 'Conteudo',
            'desc'  => 'Dados do imovel, metricas, amenidades e informacoes de contato.',
            'url'   => admin_url( 'admin.php?page=haven-textos' ),
        ),
        array(
            'title' => 'Conversao e WhatsApp',
            'eyebrow' => 'Conversao',
            'desc'  => 'Monte o formulario do botao de agendamento com perguntas e opcoes personalizaveis.',
            'url'   => admin_url( 'admin.php?page=haven-cta-form' ),
        ),
        array(
            'title' => 'Rodape e redes',
            'eyebrow' => 'Fechamento',
            'desc'  => 'Marca do rodape, copyright, links sociais e mensagem do WhatsApp.',
            'url'   => admin_url( 'admin.php?page=haven-footer' ),
        ),
        array(
            'title' => 'Tela de login',
            'eyebrow' => 'Acesso',
            'desc'  => 'Imagem de fundo, logo e textos da experiencia de login.',
            'url'   => admin_url( 'admin.php?page=haven-login' ),
        ),
        array(
            'title' => 'Cores',
            'eyebrow' => 'Visual',
            'desc'  => 'Paleta global usada no layout inteiro do tema.',
            'url'   => admin_url( 'admin.php?page=haven-cores' ),
        ),
        array(
            'title' => 'Tipografia',
            'eyebrow' => 'Visual',
            'desc'  => 'Selecione fontes do Google Fonts para titulos, corpo e auxiliares.',
            'url'   => admin_url( 'admin.php?page=haven-tipografia' ),
        ),
    );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Painel de edicao</h1>
            <p>Organizamos o tema por areas de trabalho para manter o menu lateral claro e no padrao nativo do WordPress.</p>
        </div>
        <div class="haven-admin-toolbar">
            <a class="haven-admin-toolbar-chip" href="<?php echo esc_url( admin_url( 'admin.php?page=haven-secoes' ) ); ?>">Conteudo da landing</a>
            <a class="haven-admin-toolbar-chip" href="<?php echo esc_url( admin_url( 'admin.php?page=haven-fotos' ) ); ?>">Galeria e imagens</a>
            <a class="haven-admin-toolbar-chip" href="<?php echo esc_url( admin_url( 'admin.php?page=haven-menus' ) ); ?>">Menus visuais</a>
            <a class="haven-admin-toolbar-chip" href="<?php echo esc_url( admin_url( 'admin.php?page=haven-tours' ) ); ?>">Tours e videos</a>
        </div>
        <section class="haven-admin-section">
            <div class="haven-admin-section-head">
                <h2>Edicoes principais</h2>
                <p>Os ajustes mais usados para atualizar a landing logo apos o login.</p>
            </div>
            <div class="haven-admin-grid haven-admin-grid-featured">
                <?php foreach ( $featured_pages as $page ) : ?>
                    <section class="haven-admin-linkcard haven-admin-linkcard-featured">
                        <span class="haven-admin-linkcard-eyebrow"><?php echo esc_html( $page['eyebrow'] ); ?></span>
                        <h2><?php echo esc_html( $page['title'] ); ?></h2>
                        <p><?php echo esc_html( $page['desc'] ); ?></p>
                        <a class="haven-admin-linkcard-action" href="<?php echo esc_url( $page['url'] ); ?>">Abrir editor</a>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="haven-admin-section">
            <div class="haven-admin-section-head">
                <h2>Complementos</h2>
                <p>Configuracoes de apoio para acabamento visual, contato e experiencia complementar.</p>
            </div>
            <div class="haven-admin-grid">
                <?php foreach ( $support_pages as $page ) : ?>
                    <section class="haven-admin-linkcard">
                        <span class="haven-admin-linkcard-eyebrow"><?php echo esc_html( $page['eyebrow'] ); ?></span>
                        <h2><?php echo esc_html( $page['title'] ); ?></h2>
                        <p><?php echo esc_html( $page['desc'] ); ?></p>
                        <a class="haven-admin-linkcard-action" href="<?php echo esc_url( $page['url'] ); ?>">Editar</a>
                    </section>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    <?php
}
}

function haven_admin_header_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $header_logo = haven_opt( 'haven_header_logo_image' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Header e navegacao</h1>
            <p>Controle a logo, marca de fallback e o botao de destaque do topo.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_header_group' ); ?>
            <div class="haven-admin-card">
                <h2>Logo do Site</h2>
                <p class="description">A logo escolhida aqui sera usada no header, no rodape e na tela de login. Use uma imagem PNG com fundo transparente para melhores resultados.</p>
                <table class="form-table">
                    <tr>
                        <th>Logo (PNG)</th>
                        <td>
                            <div class="haven-single-photo haven-login-photo">
                                <?php if ( $header_logo ) : ?><img src="<?php echo esc_url( $header_logo ); ?>" alt="Logo do site" style="max-height:80px;"><?php endif; ?>
                                <input type="hidden" name="haven_header_logo_image" id="haven_header_logo_image" value="<?php echo esc_url( $header_logo ); ?>">
                                <button type="button" class="button haven-upload-single" data-field="haven_header_logo_image">Escolher logo</button>
                                <?php if ( $header_logo ) : ?>
                                    <button type="button" class="button" onclick="document.getElementById('haven_header_logo_image').value=''; this.closest('.haven-single-photo').querySelector('img')?.remove(); this.remove();">Remover logo</button>
                                <?php endif; ?>
                            </div>
                            <p class="description">A mesma logo aparecera no header, rodape e tela de login automaticamente.</p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="haven-admin-card">
                <h2>Tamanho da Logo</h2>
                <p class="description">Ajuste a altura maxima da logo para cada tamanho de tela. A proporcao original e mantida automaticamente.</p>
                <table class="form-table">
                    <tr>
                        <th>Desktop <span style="font-weight:400;color:#999;">(> 1024px)</span></th>
                        <td>
                            <div style="display:flex;align-items:center;gap:16px;">
                                <input type="range" name="haven_logo_size_desktop" min="24" max="120" step="2" value="<?php echo esc_attr( haven_opt( 'haven_logo_size_desktop' ) ); ?>" class="haven-logo-range" data-preview="logo-preview-desktop" style="flex:1;max-width:300px;">
                                <span class="haven-range-val" id="val-logo-preview-desktop"><?php echo esc_html( haven_opt( 'haven_logo_size_desktop' ) ); ?>px</span>
                            </div>
                            <?php if ( $header_logo ) : ?>
                            <div id="logo-preview-desktop" style="margin-top:12px;background:#f5f5f5;border-radius:10px;padding:16px;display:inline-block;">
                                <img src="<?php echo esc_url( $header_logo ); ?>" alt="Preview desktop" style="height:<?php echo esc_attr( haven_opt( 'haven_logo_size_desktop' ) ); ?>px;width:auto;">
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tablet <span style="font-weight:400;color:#999;">(768-1024px)</span></th>
                        <td>
                            <div style="display:flex;align-items:center;gap:16px;">
                                <input type="range" name="haven_logo_size_tablet" min="20" max="100" step="2" value="<?php echo esc_attr( haven_opt( 'haven_logo_size_tablet' ) ); ?>" class="haven-logo-range" data-preview="logo-preview-tablet" style="flex:1;max-width:300px;">
                                <span class="haven-range-val" id="val-logo-preview-tablet"><?php echo esc_html( haven_opt( 'haven_logo_size_tablet' ) ); ?>px</span>
                            </div>
                            <?php if ( $header_logo ) : ?>
                            <div id="logo-preview-tablet" style="margin-top:12px;background:#f5f5f5;border-radius:10px;padding:16px;display:inline-block;">
                                <img src="<?php echo esc_url( $header_logo ); ?>" alt="Preview tablet" style="height:<?php echo esc_attr( haven_opt( 'haven_logo_size_tablet' ) ); ?>px;width:auto;">
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Celular <span style="font-weight:400;color:#999;">(< 768px)</span></th>
                        <td>
                            <div style="display:flex;align-items:center;gap:16px;">
                                <input type="range" name="haven_logo_size_mobile" min="16" max="80" step="2" value="<?php echo esc_attr( haven_opt( 'haven_logo_size_mobile' ) ); ?>" class="haven-logo-range" data-preview="logo-preview-mobile" style="flex:1;max-width:300px;">
                                <span class="haven-range-val" id="val-logo-preview-mobile"><?php echo esc_html( haven_opt( 'haven_logo_size_mobile' ) ); ?>px</span>
                            </div>
                            <?php if ( $header_logo ) : ?>
                            <div id="logo-preview-mobile" style="margin-top:12px;background:#f5f5f5;border-radius:10px;padding:16px;display:inline-block;">
                                <img src="<?php echo esc_url( $header_logo ); ?>" alt="Preview celular" style="height:<?php echo esc_attr( haven_opt( 'haven_logo_size_mobile' ) ); ?>px;width:auto;">
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
                <style>
                    .haven-logo-range {
                        -webkit-appearance: none;
                        appearance: none;
                        height: 8px;
                        border-radius: 4px;
                        background: linear-gradient(90deg, #e5e0d8 0%, #c8a45e 100%);
                        outline: none;
                        cursor: pointer;
                    }
                    .haven-logo-range::-webkit-slider-thumb {
                        -webkit-appearance: none;
                        appearance: none;
                        width: 22px;
                        height: 22px;
                        border-radius: 50%;
                        background: #c8a45e;
                        border: 3px solid #fff;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                        cursor: grab;
                    }
                    .haven-logo-range::-moz-range-thumb {
                        width: 22px;
                        height: 22px;
                        border-radius: 50%;
                        background: #c8a45e;
                        border: 3px solid #fff;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
                        cursor: grab;
                    }
                    .haven-range-val {
                        min-width: 48px;
                        text-align: center;
                        font-weight: 600;
                        font-size: 14px;
                        color: #2c2824;
                        background: #f3efe8;
                        padding: 6px 12px;
                        border-radius: 8px;
                    }
                </style>
                <script>
                document.querySelectorAll('.haven-logo-range').forEach(function(range){
                    range.addEventListener('input', function(){
                        var previewId = this.dataset.preview;
                        var valEl = document.getElementById('val-' + previewId);
                        var previewEl = document.getElementById(previewId);
                        if(valEl) valEl.textContent = this.value + 'px';
                        if(previewEl){
                            var img = previewEl.querySelector('img');
                            if(img) img.style.height = this.value + 'px';
                        }
                    });
                });
                </script>
            </div>
            <div class="haven-admin-card">
                <h2>Marca e CTA</h2>
                <table class="form-table">
                    <tr>
                        <th>Marca fallback</th>
                        <td>
                            <input type="text" name="haven_header_brand" value="<?php echo esc_attr( haven_opt( 'haven_header_brand' ) ); ?>" class="regular-text">
                            <p class="description">Aparece quando nao houver logo definida.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Mostrar CTA</th>
                        <td>
                            <input type="hidden" name="haven_header_show_cta" value="0">
                            <label><input type="checkbox" name="haven_header_show_cta" value="1" <?php checked( haven_opt( 'haven_header_show_cta' ), '1' ); ?>> Exibir botao no header</label>
                        </td>
                    </tr>
                    <tr>
                        <th>Texto do CTA</th>
                        <td><input type="text" name="haven_header_cta_text" value="<?php echo esc_attr( haven_opt( 'haven_header_cta_text' ) ); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th>Link do CTA</th>
                        <td>
                            <input type="text" name="haven_header_cta_link" value="<?php echo esc_attr( haven_opt( 'haven_header_cta_link' ) ); ?>" class="regular-text">
                            <p class="description">Aceita ancora interna como #contato ou URL completa.</p>
                        </td>
                    </tr>
                </table>
            </div>
            <?php submit_button( 'Salvar Header' ); ?>
        </form>
    </div>
    <?php
}

function haven_admin_sections_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Conteudo da landing</h1>
            <p>Edite os botoes do hero, a exibicao das secoes, a localizacao e o CTA final sem misturar tours e videos.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_sections_group' ); ?>
            <div class="haven-admin-layout haven-admin-layout-sections">
            <div class="haven-admin-card">
                <h2>Botoes do hero</h2>
                <table class="form-table">
                    <tr><th>Botao principal</th><td><input type="text" name="haven_hero_primary_text" value="<?php echo esc_attr( haven_opt( 'haven_hero_primary_text' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Link principal</th><td><input type="text" name="haven_hero_primary_link" value="<?php echo esc_attr( haven_opt( 'haven_hero_primary_link' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Botao secundario</th><td><input type="text" name="haven_hero_secondary_text" value="<?php echo esc_attr( haven_opt( 'haven_hero_secondary_text' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Link secundario</th><td><input type="text" name="haven_hero_secondary_link" value="<?php echo esc_attr( haven_opt( 'haven_hero_secondary_link' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>
            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Quebra de texto do hero</h2>
                <p class="description">Use os controles abaixo para definir em que ponto o titulo e o subtitulo quebram linha no hero, alem do tamanho do texto em cada tela.</p>
                <table class="form-table">
                    <tr>
                        <th>Titulo desktop</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_title_size_desktop" min="48" max="120" step="2" value="<?php echo esc_attr( haven_opt( 'haven_hero_title_size_desktop' ) ); ?>" class="haven-live-range" data-value-target="hero-title-size-desktop" data-preview-target="hero-title-preview" data-preview-prop="fontSize" data-preview-suffix="px">
                                <span class="haven-range-val" id="hero-title-size-desktop"><?php echo esc_html( haven_opt( 'haven_hero_title_size_desktop' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Titulo tablet</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_title_size_tablet" min="40" max="96" step="2" value="<?php echo esc_attr( haven_opt( 'haven_hero_title_size_tablet' ) ); ?>" class="haven-live-range" data-value-target="hero-title-size-tablet">
                                <span class="haven-range-val" id="hero-title-size-tablet"><?php echo esc_html( haven_opt( 'haven_hero_title_size_tablet' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Titulo mobile</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_title_size_mobile" min="28" max="72" step="2" value="<?php echo esc_attr( haven_opt( 'haven_hero_title_size_mobile' ) ); ?>" class="haven-live-range" data-value-target="hero-title-size-mobile">
                                <span class="haven-range-val" id="hero-title-size-mobile"><?php echo esc_html( haven_opt( 'haven_hero_title_size_mobile' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Largura do titulo</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_title_width" min="420" max="1100" step="10" value="<?php echo esc_attr( haven_opt( 'haven_hero_title_width' ) ); ?>" class="haven-live-range" data-value-target="hero-title-width" data-preview-target="hero-title-preview" data-preview-prop="maxWidth" data-preview-suffix="px">
                                <span class="haven-range-val" id="hero-title-width"><?php echo esc_html( haven_opt( 'haven_hero_title_width' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Subtitulo desktop</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_desc_size_desktop" min="14" max="28" step="1" value="<?php echo esc_attr( haven_opt( 'haven_hero_desc_size_desktop' ) ); ?>" class="haven-live-range" data-value-target="hero-desc-size-desktop" data-preview-target="hero-desc-preview" data-preview-prop="fontSize" data-preview-suffix="px">
                                <span class="haven-range-val" id="hero-desc-size-desktop"><?php echo esc_html( haven_opt( 'haven_hero_desc_size_desktop' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Subtitulo mobile</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_desc_size_mobile" min="12" max="22" step="1" value="<?php echo esc_attr( haven_opt( 'haven_hero_desc_size_mobile' ) ); ?>" class="haven-live-range" data-value-target="hero-desc-size-mobile">
                                <span class="haven-range-val" id="hero-desc-size-mobile"><?php echo esc_html( haven_opt( 'haven_hero_desc_size_mobile' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Largura do subtitulo</th>
                        <td>
                            <div class="haven-range-row">
                                <input type="range" name="haven_hero_desc_width" min="320" max="900" step="10" value="<?php echo esc_attr( haven_opt( 'haven_hero_desc_width' ) ); ?>" class="haven-live-range" data-value-target="hero-desc-width" data-preview-target="hero-desc-preview" data-preview-prop="maxWidth" data-preview-suffix="px">
                                <span class="haven-range-val" id="hero-desc-width"><?php echo esc_html( haven_opt( 'haven_hero_desc_width' ) ); ?>px</span>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="haven-range-preview">
                    <div class="haven-range-preview-label">Preview do hero</div>
                    <div class="haven-hero-text-preview">
                        <div class="haven-hero-text-preview-kicker"><?php echo esc_html( haven_opt( 'haven_property_tagline' ) ); ?></div>
                        <div id="hero-title-preview" class="haven-hero-text-preview-title" style="font-size:<?php echo esc_attr( haven_opt( 'haven_hero_title_size_desktop' ) ); ?>px;max-width:<?php echo esc_attr( haven_opt( 'haven_hero_title_width' ) ); ?>px;">
                            <?php echo wp_kses_post( haven_opt( 'haven_hero_title' ) ); ?>
                        </div>
                        <div id="hero-desc-preview" class="haven-hero-text-preview-desc" style="font-size:<?php echo esc_attr( haven_opt( 'haven_hero_desc_size_desktop' ) ); ?>px;max-width:<?php echo esc_attr( haven_opt( 'haven_hero_desc_width' ) ); ?>px;">
                            <?php echo esc_html( haven_opt( 'haven_hero_subtitle' ) ); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="haven-admin-card">
                <h2>Sobre e galeria</h2>
                <table class="form-table">
                    <tr><th>Label sobre</th><td><input type="text" name="haven_about_label" value="<?php echo esc_attr( haven_opt( 'haven_about_label' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo sobre</th><td><input type="text" name="haven_about_title" value="<?php echo esc_attr( haven_opt( 'haven_about_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Botao sobre</th><td><input type="text" name="haven_about_button_text" value="<?php echo esc_attr( haven_opt( 'haven_about_button_text' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Link botao sobre</th><td><input type="text" name="haven_about_button_link" value="<?php echo esc_attr( haven_opt( 'haven_about_button_link' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Label galeria</th><td><input type="text" name="haven_gallery_label" value="<?php echo esc_attr( haven_opt( 'haven_gallery_label' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo galeria</th><td><input type="text" name="haven_gallery_title" value="<?php echo esc_attr( haven_opt( 'haven_gallery_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Subtitulo galeria</th><td><?php wp_editor( haven_opt( 'haven_gallery_subtitle' ), 'haven_gallery_subtitle', array( 'textarea_name' => 'haven_gallery_subtitle', 'textarea_rows' => 4, 'media_buttons' => false, 'teeny' => true, 'quicktags' => true ) ); ?></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Exibicao de secoes</h2>
                <table class="form-table">
                    <tr>
                        <th>Galeria</th>
                        <td><input type="hidden" name="haven_show_gallery" value="0"><label><input type="checkbox" name="haven_show_gallery" value="1" <?php checked( haven_opt( 'haven_show_gallery' ), '1' ); ?>> Exibir galeria</label></td>
                    </tr>
                    <tr>
                        <th>Tour em video</th>
                        <td><input type="hidden" name="haven_show_video" value="0"><label><input type="checkbox" name="haven_show_video" value="1" <?php checked( haven_opt( 'haven_show_video' ), '1' ); ?>> Exibir secao de video</label></td>
                    </tr>
                    <tr>
                        <th>Tour 3D</th>
                        <td><input type="hidden" name="haven_show_matterport" value="0"><label><input type="checkbox" name="haven_show_matterport" value="1" <?php checked( haven_opt( 'haven_show_matterport' ), '1' ); ?>> Exibir secao Matterport</label></td>
                    </tr>
                    <tr>
                        <th>Localizacao</th>
                        <td><input type="hidden" name="haven_show_location" value="0"><label><input type="checkbox" name="haven_show_location" value="1" <?php checked( haven_opt( 'haven_show_location' ), '1' ); ?>> Exibir mapa</label></td>
                    </tr>
                    <tr>
                        <th>Depoimentos</th>
                        <td><input type="hidden" name="haven_show_testimonials" value="0"><label><input type="checkbox" name="haven_show_testimonials" value="1" <?php checked( haven_opt( 'haven_show_testimonials' ), '1' ); ?>> Exibir secao de depoimentos</label></td>
                    </tr>
                    <tr>
                        <th>CTA final</th>
                        <td><input type="hidden" name="haven_show_cta" value="0"><label><input type="checkbox" name="haven_show_cta" value="1" <?php checked( haven_opt( 'haven_show_cta' ), '1' ); ?>> Exibir secao final de contato</label></td>
                    </tr>
                </table>
            </div>

            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Ordem das secoes</h2>
                <p class="description" style="margin-bottom:1rem;">Arraste para reordenar as secoes do site. Este e o unico lugar do painel que controla ordem e visibilidade das secoes.</p>
                <?php
                $section_order = haven_get_section_order();
                $section_labels = haven_get_section_labels();
                ?>
                <ul id="haven-section-sortable" class="haven-sortable-list">
                    <?php foreach ( $section_order as $section_key ) : ?>
                        <li class="haven-sortable-item" data-section="<?php echo esc_attr( $section_key ); ?>">
                            <span class="haven-sortable-handle">&#9776;</span>
                            <span class="haven-sortable-label"><?php echo esc_html( $section_labels[ $section_key ] ?? $section_key ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div id="haven-sort-status" style="margin-top:0.75rem;font-size:13px;color:#3a6b5e;display:none;">&#10003; Ordem salva!</div>
                <input type="hidden" id="haven-section-order-nonce" value="<?php echo esc_attr( wp_create_nonce( 'haven_section_order_nonce' ) ); ?>">
            </div>
            <style>
                .haven-sortable-list { list-style:none; padding:0; margin:0; }
                .haven-sortable-item { display:flex; align-items:center; gap:12px; padding:14px 18px; margin-bottom:6px; background:#fff; border:1px solid #e5e0d8; border-radius:12px; cursor:grab; transition:all 0.2s; font-size:14px; font-weight:500; color:#2c2824; }
                .haven-sortable-item:hover { border-color:#c8a45e; box-shadow:0 4px 12px rgba(200,164,94,0.12); }
                .haven-sortable-item.ui-sortable-helper { box-shadow:0 8px 24px rgba(0,0,0,0.15); transform:scale(1.02); z-index:100; }
                .haven-sortable-item.ui-sortable-placeholder { background:rgba(200,164,94,0.08); border:2px dashed #c8a45e; visibility:visible !important; height:50px; }
                .haven-sortable-handle { font-size:16px; opacity:0.4; cursor:grab; }
                .haven-sortable-item:hover .haven-sortable-handle { opacity:0.8; }
            </style>
            <script>
            jQuery(function($){
                $('#haven-section-sortable').sortable({
                    handle: '.haven-sortable-handle',
                    placeholder: 'ui-sortable-placeholder',
                    tolerance: 'pointer',
                    update: function(){
                        var order = [];
                        $('#haven-section-sortable .haven-sortable-item').each(function(){
                            order.push($(this).data('section'));
                        });
                        $.post(ajaxurl, {
                            action: 'haven_save_section_order',
                            nonce: $('#haven-section-order-nonce').val(),
                            order: order
                        }, function(res){
                            if(res.success){
                                $('#haven-sort-status').fadeIn().delay(2000).fadeOut();
                            }
                        });
                    }
                });
            });
            </script>
            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Localizacao</h2>
                <table class="form-table">
                    <tr><th>Label localizacao</th><td><input type="text" name="haven_location_label" value="<?php echo esc_attr( haven_opt( 'haven_location_label' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo localizacao</th><td><input type="text" name="haven_location_title" value="<?php echo esc_attr( haven_opt( 'haven_location_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Regiao</th><td><input type="text" name="haven_location_region" value="<?php echo esc_attr( haven_opt( 'haven_location_region' ) ); ?>" class="regular-text"></td></tr>
                    <tr>
                        <th>Mapa embed</th>
                        <td>
                            <textarea name="haven_location_map_embed" rows="6" class="large-text code"><?php echo esc_textarea( haven_opt( 'haven_location_map_embed' ) ); ?></textarea>
                            <p class="description">Cole o iframe do Google Maps.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>CTA final</h2>
                <table class="form-table">
                    <tr><th>Titulo CTA</th><td><input type="text" name="haven_cta_title" value="<?php echo esc_attr( haven_opt( 'haven_cta_title' ) ); ?>" class="large-text"><p class="description">Aceita a tag &lt;em&gt; para destaque.</p></td></tr>
                    <tr><th>Descricao CTA</th><td><?php wp_editor( haven_opt( 'haven_cta_desc' ), 'haven_cta_desc', array( 'textarea_name' => 'haven_cta_desc', 'textarea_rows' => 4, 'media_buttons' => false, 'teeny' => true, 'quicktags' => true ) ); ?></td></tr>
                    <tr><th>Texto WhatsApp</th><td><input type="text" name="haven_cta_whatsapp_text" value="<?php echo esc_attr( haven_opt( 'haven_cta_whatsapp_text' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Texto telefone</th><td><input type="text" name="haven_cta_phone_text" value="<?php echo esc_attr( haven_opt( 'haven_cta_phone_text' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>
            </div>
            <?php submit_button( 'Salvar secoes' ); ?>
        </form>
    </div>
    <?php
}

function haven_admin_testimonials_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $testimonial_items = array(
        1 => array(
            'quote'  => haven_opt( 'haven_testimonial_1_quote' ),
            'name'   => haven_opt( 'haven_testimonial_1_name' ),
            'role'   => haven_opt( 'haven_testimonial_1_role' ),
            'avatar' => haven_opt( 'haven_testimonial_1_avatar' ),
        ),
        2 => array(
            'quote'  => haven_opt( 'haven_testimonial_2_quote' ),
            'name'   => haven_opt( 'haven_testimonial_2_name' ),
            'role'   => haven_opt( 'haven_testimonial_2_role' ),
            'avatar' => haven_opt( 'haven_testimonial_2_avatar' ),
        ),
        3 => array(
            'quote'  => haven_opt( 'haven_testimonial_3_quote' ),
            'name'   => haven_opt( 'haven_testimonial_3_name' ),
            'role'   => haven_opt( 'haven_testimonial_3_role' ),
            'avatar' => haven_opt( 'haven_testimonial_3_avatar' ),
        ),
    );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Depoimentos</h1>
            <p>Gerencie os comentarios e a secao de depoimentos em uma area dedicada, sem misturar com o hero e as secoes principais.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_testimonials_group' ); ?>
            <div class="haven-admin-layout haven-admin-layout-testimonials">
            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Conteudo da secao</h2>
                <table class="form-table">
                    <tr><th>Label da secao</th><td><input type="text" name="haven_testimonials_label" value="<?php echo esc_attr( haven_opt( 'haven_testimonials_label' ) ); ?>" class="regular-text" data-testimonial-preview-target="section-label"></td></tr>
                    <tr><th>Titulo da secao</th><td><input type="text" name="haven_testimonials_title" value="<?php echo esc_attr( haven_opt( 'haven_testimonials_title' ) ); ?>" class="large-text" data-testimonial-preview-target="section-title"></td></tr>
                </table>
                <p class="description">Para exibir, ocultar ou reordenar depoimentos, use apenas a tela Conteudo da landing.</p>
            </div>

            <div class="haven-admin-card haven-admin-card-span-2 haven-testimonial-preview-panel">
                <h2>Preview da secao</h2>
                <p class="description">Acompanhe como os depoimentos aparecem no site enquanto voce edita textos, iniciais e contexto.</p>
                <div class="haven-testimonial-admin-preview">
                    <div class="haven-testimonial-admin-preview-label" data-testimonial-preview="section-label"><?php echo esc_html( haven_opt( 'haven_testimonials_label' ) ); ?></div>
                    <h3 class="haven-testimonial-admin-preview-title" data-testimonial-preview="section-title"><?php echo esc_html( haven_opt( 'haven_testimonials_title' ) ); ?></h3>
                    <div class="haven-testimonial-admin-preview-grid">
                        <?php foreach ( $testimonial_items as $index => $testimonial_item ) : ?>
                            <article class="haven-testimonial-admin-card-preview">
                                <div class="haven-testimonial-admin-stars" aria-hidden="true">
                                    <span>&#11088;</span>
                                    <span>&#11088;</span>
                                    <span>&#11088;</span>
                                    <span>&#11088;</span>
                                    <span>&#11088;</span>
                                </div>
                                <p class="haven-testimonial-admin-quote" data-testimonial-preview="quote-<?php echo esc_attr( $index ); ?>">
                                    "<?php echo esc_html( $testimonial_item['quote'] ); ?>"
                                </p>
                                <div class="haven-testimonial-admin-author">
                                    <div class="haven-testimonial-admin-avatar" data-testimonial-preview="avatar-<?php echo esc_attr( $index ); ?>"><?php echo esc_html( $testimonial_item['avatar'] ); ?></div>
                                    <div>
                                        <div class="haven-testimonial-admin-name" data-testimonial-preview="name-<?php echo esc_attr( $index ); ?>"><?php echo esc_html( $testimonial_item['name'] ); ?></div>
                                        <div class="haven-testimonial-admin-role" data-testimonial-preview="role-<?php echo esc_attr( $index ); ?>"><?php echo esc_html( $testimonial_item['role'] ); ?></div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="haven-admin-card">
                <h2>Depoimento 1</h2>
                <table class="form-table">
                    <tr><th>Texto</th><td><textarea name="haven_testimonial_1_quote" rows="4" class="large-text" data-testimonial-preview-target="quote-1"><?php echo esc_textarea( haven_opt( 'haven_testimonial_1_quote' ) ); ?></textarea></td></tr>
                    <tr><th>Nome</th><td><input type="text" name="haven_testimonial_1_name" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_1_name' ) ); ?>" class="regular-text" data-testimonial-preview-target="name-1"></td></tr>
                    <tr><th>Cargo / contexto</th><td><input type="text" name="haven_testimonial_1_role" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_1_role' ) ); ?>" class="regular-text" data-testimonial-preview-target="role-1"></td></tr>
                    <tr><th>Avatar</th><td><input type="text" name="haven_testimonial_1_avatar" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_1_avatar' ) ); ?>" class="small-text" maxlength="2" data-testimonial-preview-target="avatar-1"><p class="description">Use 1 ou 2 letras.</p></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Depoimento 2</h2>
                <table class="form-table">
                    <tr><th>Texto</th><td><textarea name="haven_testimonial_2_quote" rows="4" class="large-text" data-testimonial-preview-target="quote-2"><?php echo esc_textarea( haven_opt( 'haven_testimonial_2_quote' ) ); ?></textarea></td></tr>
                    <tr><th>Nome</th><td><input type="text" name="haven_testimonial_2_name" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_2_name' ) ); ?>" class="regular-text" data-testimonial-preview-target="name-2"></td></tr>
                    <tr><th>Cargo / contexto</th><td><input type="text" name="haven_testimonial_2_role" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_2_role' ) ); ?>" class="regular-text" data-testimonial-preview-target="role-2"></td></tr>
                    <tr><th>Avatar</th><td><input type="text" name="haven_testimonial_2_avatar" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_2_avatar' ) ); ?>" class="small-text" maxlength="2" data-testimonial-preview-target="avatar-2"><p class="description">Use 1 ou 2 letras.</p></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Depoimento 3</h2>
                <table class="form-table">
                    <tr><th>Texto</th><td><textarea name="haven_testimonial_3_quote" rows="4" class="large-text" data-testimonial-preview-target="quote-3"><?php echo esc_textarea( haven_opt( 'haven_testimonial_3_quote' ) ); ?></textarea></td></tr>
                    <tr><th>Nome</th><td><input type="text" name="haven_testimonial_3_name" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_3_name' ) ); ?>" class="regular-text" data-testimonial-preview-target="name-3"></td></tr>
                    <tr><th>Cargo / contexto</th><td><input type="text" name="haven_testimonial_3_role" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_3_role' ) ); ?>" class="regular-text" data-testimonial-preview-target="role-3"></td></tr>
                    <tr><th>Avatar</th><td><input type="text" name="haven_testimonial_3_avatar" value="<?php echo esc_attr( haven_opt( 'haven_testimonial_3_avatar' ) ); ?>" class="small-text" maxlength="2" data-testimonial-preview-target="avatar-3"><p class="description">Use 1 ou 2 letras.</p></td></tr>
                </table>
            </div>
            </div>
            <?php submit_button( 'Salvar depoimentos' ); ?>
        </form>
    </div>
    <?php
}

if ( ! function_exists( 'haven_admin_cta_form_render' ) ) {
function haven_admin_cta_form_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $fields = haven_get_cta_lead_form_fields();
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Conversao e WhatsApp</h1>
            <p>Configure a frase inicial, as perguntas e as opcoes exibidas antes de abrir o WhatsApp.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_cta_form_group' ); ?>
            <div class="haven-admin-card">
                <h2>Textos do formulario</h2>
                <table class="form-table">
                    <tr><th>Titulo do modal</th><td><input type="text" name="haven_cta_form_title" value="<?php echo esc_attr( haven_opt( 'haven_cta_form_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Frase de apoio</th><td><textarea name="haven_cta_form_desc" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_cta_form_desc' ) ); ?></textarea></td></tr>
                    <tr><th>Mensagem enviada</th><td><textarea name="haven_cta_form_message_intro" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_cta_form_message_intro' ) ); ?></textarea><p class="description">Use {imovel} para inserir automaticamente o nome do imovel antes das respostas.</p></td></tr>
                    <tr><th>Texto do botao</th><td><input type="text" name="haven_cta_form_submit_text" value="<?php echo esc_attr( haven_opt( 'haven_cta_form_submit_text' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Botao flutuante</h2>
                <table class="form-table">
                    <tr>
                        <th>Ativar botao</th>
                        <td><input type="hidden" name="haven_floating_cta_enabled" value="0"><label><input type="checkbox" name="haven_floating_cta_enabled" value="1" <?php checked( haven_opt( 'haven_floating_cta_enabled' ), '1' ); ?>> Exibir botao flutuante com o mesmo formulario</label></td>
                    </tr>
                    <tr>
                        <th>Canto da tela</th>
                        <td>
                            <select name="haven_floating_cta_corner">
                                <option value="bottom-right" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'bottom-right' ); ?>>Inferior direito</option>
                                <option value="bottom-left" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'bottom-left' ); ?>>Inferior esquerdo</option>
                                <option value="top-right" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'top-right' ); ?>>Superior direito</option>
                                <option value="top-left" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'top-left' ); ?>>Superior esquerdo</option>
                            </select>
                        </td>
                    </tr>
                    <tr><th>Aparecer apos</th><td><input type="number" name="haven_floating_cta_show_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_show_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Pulsar apos</th><td><input type="number" name="haven_floating_cta_pulse_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_pulse_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Mensagem estilizada apos</th><td><input type="number" name="haven_floating_cta_message_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_message_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Mensagem apos badge</th><td><input type="number" name="haven_floating_cta_badge_message_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_badge_message_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos<p class="description">Esse tempo passa a contar somente depois que o badge vermelho aparecer.</p></td></tr>
                    <tr>
                        <th>Secao para badge</th>
                        <td>
                            <select name="haven_floating_cta_badge_section">
                                <option value="">Nao usar badge por secao</option>
                                <?php foreach ( haven_get_menu_section_targets() as $section_value => $section_label ) : ?>
                                    <option value="<?php echo esc_attr( ltrim( $section_value, '#' ) ); ?>" <?php selected( haven_opt( 'haven_floating_cta_badge_section' ), ltrim( $section_value, '#' ) ); ?>><?php echo esc_html( $section_label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr><th>Numero do badge</th><td><input type="number" name="haven_floating_cta_badge_text" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_badge_text' ) ); ?>" min="1" step="1" class="small-text"><p class="description">Exibe a bolinha vermelha com este numero de nova mensagem.</p></td></tr>
                    <tr><th>Mensagem estilizada</th><td><textarea name="haven_floating_cta_message_text" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_floating_cta_message_text' ) ); ?></textarea></td></tr>
                </table>
            </div>

            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Perguntas e opcoes</h2>
                <p class="description">Edite as perguntas padrao, adicione novas e inclua quantas opcoes precisar em cada uma.</p>
                <div class="haven-cta-fields-list" id="haven-cta-fields-list">
                    <?php foreach ( $fields as $field_index => $field ) : ?>
                        <div class="haven-cta-field-card" data-index="<?php echo esc_attr( $field_index ); ?>">
                            <div class="haven-cta-field-head">
                                <strong>Pergunta</strong>
                                <button type="button" class="button-link-delete haven-remove-cta-field">Remover</button>
                            </div>
                            <div class="haven-cta-field-grid">
                                <label>
                                    <span>Rotulo</span>
                                    <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][label]" value="<?php echo esc_attr( $field['label'] ?? '' ); ?>" class="large-text">
                                </label>
                                <label>
                                    <span>Placeholder</span>
                                    <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][placeholder]" value="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>" class="regular-text">
                                </label>
                            </div>
                            <div class="haven-cta-field-toggles">
                                <label><input type="hidden" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][enabled]" value="0"><input type="checkbox" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][enabled]" value="1" <?php checked( $field['enabled'] ?? '1', '1' ); ?>> Exibir campo</label>
                                <label><input type="hidden" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][required]" value="0"><input type="checkbox" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][required]" value="1" <?php checked( $field['required'] ?? '0', '1' ); ?>> Obrigatorio</label>
                            </div>
                            <div class="haven-cta-options-list">
                                <?php foreach ( $field['options'] as $option_index => $option ) : ?>
                                    <div class="haven-cta-option-row" data-option-index="<?php echo esc_attr( $option_index ); ?>">
                                        <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][options][<?php echo esc_attr( $option_index ); ?>][label]" value="<?php echo esc_attr( $option['label'] ?? '' ); ?>" class="regular-text" placeholder="Opcao">
                                        <button type="button" class="button-link-delete haven-remove-cta-option">Remover opcao</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="button haven-add-cta-option">Adicionar opcao</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p><button type="button" class="button button-secondary" id="haven-add-cta-field">Adicionar pergunta</button></p>
            </div>
            <?php submit_button( 'Salvar formulario WhatsApp' ); ?>
        </form>
    </div>
    <script type="text/html" id="haven-cta-field-template">
        <div class="haven-cta-field-card" data-index="__INDEX__">
            <div class="haven-cta-field-head">
                <strong>Pergunta</strong>
                <button type="button" class="button-link-delete haven-remove-cta-field">Remover</button>
            </div>
            <div class="haven-cta-field-grid">
                <label>
                    <span>Rotulo</span>
                    <input type="text" name="haven_cta_form_fields[__INDEX__][label]" value="" class="large-text">
                </label>
                <label>
                    <span>Placeholder</span>
                    <input type="text" name="haven_cta_form_fields[__INDEX__][placeholder]" value="Selecione uma opcao" class="regular-text">
                </label>
            </div>
            <div class="haven-cta-field-toggles">
                <label><input type="hidden" name="haven_cta_form_fields[__INDEX__][enabled]" value="0"><input type="checkbox" name="haven_cta_form_fields[__INDEX__][enabled]" value="1" checked> Exibir campo</label>
                <label><input type="hidden" name="haven_cta_form_fields[__INDEX__][required]" value="0"><input type="checkbox" name="haven_cta_form_fields[__INDEX__][required]" value="1"> Obrigatorio</label>
            </div>
            <div class="haven-cta-options-list">
                <div class="haven-cta-option-row" data-option-index="0">
                    <input type="text" name="haven_cta_form_fields[__INDEX__][options][0][label]" value="" class="regular-text" placeholder="Opcao">
                    <button type="button" class="button-link-delete haven-remove-cta-option">Remover opcao</button>
                </div>
            </div>
            <button type="button" class="button haven-add-cta-option">Adicionar opcao</button>
        </div>
    </script>
    <style>
        .haven-cta-field-card{border:1px solid #e5e0d8;border-radius:16px;padding:18px;margin-bottom:16px;background:#fff7ec}
        .haven-cta-field-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
        .haven-cta-field-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px}
        .haven-cta-field-grid label,.haven-cta-field-toggles label{display:flex;flex-direction:column;gap:6px}
        .haven-cta-field-toggles{display:flex;gap:24px;flex-wrap:wrap;margin-bottom:12px}
        .haven-cta-options-list{display:flex;flex-direction:column;gap:10px;margin-bottom:12px}
        .haven-cta-option-row{display:flex;gap:10px;align-items:center}
        .haven-cta-option-row input{flex:1}
        @media (max-width: 782px){.haven-cta-field-grid{grid-template-columns:1fr}.haven-cta-option-row{flex-direction:column;align-items:stretch}}
    </style>
    <?php
}
}

function haven_admin_footer_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Rodape e redes</h1>
            <p>Edite a assinatura do site, os links sociais e a mensagem padrao do WhatsApp.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_footer_group' ); ?>
            <div class="haven-admin-card">
                <h2>Rodape</h2>
                <table class="form-table">
                    <tr><th>Marca do rodape</th><td><input type="text" name="haven_footer_brand" value="<?php echo esc_attr( haven_opt( 'haven_footer_brand' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo coluna menu</th><td><input type="text" name="haven_footer_menu_title" value="<?php echo esc_attr( haven_opt( 'haven_footer_menu_title' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo coluna localizacao</th><td><input type="text" name="haven_footer_location_title" value="<?php echo esc_attr( haven_opt( 'haven_footer_location_title' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Titulo coluna contato</th><td><input type="text" name="haven_footer_contact_title" value="<?php echo esc_attr( haven_opt( 'haven_footer_contact_title' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Copyright</th><td><textarea name="haven_footer_copyright" rows="2" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_footer_copyright' ) ); ?></textarea></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>WhatsApp e redes sociais</h2>
                <table class="form-table">
                    <tr>
                        <th>Mensagem WhatsApp</th>
                        <td>
                            <textarea name="haven_whatsapp_message" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_whatsapp_message' ) ); ?></textarea>
                            <p class="description">Use {imovel} para inserir automaticamente o nome do imovel.</p>
                        </td>
                    </tr>
                    <tr><th>Instagram</th><td><input type="url" name="haven_footer_instagram" value="<?php echo esc_attr( haven_opt( 'haven_footer_instagram' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Facebook</th><td><input type="url" name="haven_footer_facebook" value="<?php echo esc_attr( haven_opt( 'haven_footer_facebook' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>YouTube</th><td><input type="url" name="haven_footer_youtube" value="<?php echo esc_attr( haven_opt( 'haven_footer_youtube' ) ); ?>" class="large-text"></td></tr>
                </table>
            </div>
            <?php submit_button( 'Salvar rodape' ); ?>
        </form>
    </div>
    <?php
}

if ( ! function_exists( 'haven_admin_login_render' ) ) {
function haven_admin_login_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $bg_image = haven_opt( 'haven_login_bg_image' );
    $logo_image = haven_opt( 'haven_login_logo_image' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Tela de login</h1>
            <p>Personalize a entrada do WordPress com visual premium, imagem de fundo e identidade da marca.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_login_group' ); ?>
            <div class="haven-admin-card">
                <h2>Conteudo</h2>
                <table class="form-table">
                    <tr>
                        <th>Titulo</th>
                        <td><input type="text" name="haven_login_title" value="<?php echo esc_attr( haven_opt( 'haven_login_title' ) ); ?>" class="large-text"></td>
                    </tr>
                    <tr>
                        <th>Subtitulo</th>
                        <td><textarea name="haven_login_subtitle" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_login_subtitle' ) ); ?></textarea></td>
                    </tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Imagens</h2>
                <table class="form-table">
                    <tr>
                        <th>Imagem de fundo</th>
                        <td>
                            <div class="haven-single-photo haven-login-photo">
                                <?php if ( $bg_image ) : ?><img src="<?php echo esc_url( $bg_image ); ?>" alt="Fundo login"><?php endif; ?>
                                <input type="hidden" name="haven_login_bg_image" id="haven_login_bg_image" value="<?php echo esc_url( $bg_image ); ?>">
                                <button type="button" class="button haven-upload-single" data-field="haven_login_bg_image">Escolher imagem</button>
                            </div>
                            <p class="description">Se ficar vazio, usamos a imagem principal do hero como fallback.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Logo opcional</th>
                        <td>
                            <div class="haven-single-photo haven-login-photo">
                                <?php if ( $logo_image ) : ?><img src="<?php echo esc_url( $logo_image ); ?>" alt="Logo login"><?php endif; ?>
                                <input type="hidden" name="haven_login_logo_image" id="haven_login_logo_image" value="<?php echo esc_url( $logo_image ); ?>">
                                <button type="button" class="button haven-upload-single" data-field="haven_login_logo_image">Escolher logo</button>
                            </div>
                            <p class="description">Se nao definir uma logo, o login usa a logo personalizada do tema ou o nome da marca.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="haven-admin-card haven-login-preview">
                <h2>Preview conceitual</h2>
                <div class="haven-login-preview-frame" <?php if ( $bg_image ) : ?>style="background-image:url('<?php echo esc_url( $bg_image ); ?>');"<?php endif; ?>>
                    <div class="haven-login-preview-overlay"></div>
                    <div class="haven-login-preview-card">
                        <div class="haven-login-preview-kicker">Area restrita</div>
                        <h3><?php echo esc_html( haven_opt( 'haven_login_title' ) ); ?></h3>
                        <p><?php echo esc_html( haven_opt( 'haven_login_subtitle' ) ); ?></p>
                        <div class="haven-login-preview-fields">
                            <span>E-mail ou usuario</span>
                            <span>Senha</span>
                        </div>
                        <button type="button" class="button button-primary" disabled>Entrar</button>
                    </div>
                </div>
            </div>

            <?php submit_button( 'Salvar tela de login' ); ?>
        </form>
    </div>
    <?php
}
}

// ===================================================================
// TOURS E VIDEOS ADMIN PAGE
// ===================================================================
if ( ! function_exists( 'haven_admin_tours_render' ) ) {
function haven_admin_tours_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $video_url = haven_opt( 'haven_video_url' );
    $video_bg  = get_option( 'haven_video_bg', '' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Tours e videos</h1>
            <p>Centralizamos aqui tudo que pertence ao YouTube e ao Matterport, para evitar campos espalhados em menus diferentes.</p>
        </div>

        <form method="post" action="options.php" style="margin-bottom:1.5rem;">
            <?php settings_fields( 'haven_video_media_group' ); ?>
            <div class="haven-admin-card">
                <h2>YouTube / Video principal</h2>
                <table class="form-table">
                    <tr>
                        <th>URL do video</th>
                        <td>
                            <input type="url" name="haven_video_url" value="<?php echo esc_url( $video_url ); ?>" class="large-text" placeholder="https://www.youtube.com/watch?v=...">
                            <p class="description">Aceita link normal do YouTube, Shorts, youtu.be ou embed.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Formato do video</th>
                        <td>
                            <select name="haven_video_format">
                                <option value="horizontal" <?php selected( haven_opt( 'haven_video_format' ), 'horizontal' ); ?>>Horizontal (16:9)</option>
                                <option value="vertical" <?php selected( haven_opt( 'haven_video_format' ), 'vertical' ); ?>>Vertical (9:16)</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Autoplay</th>
                        <td><input type="hidden" name="haven_video_autoplay" value="0"><label><input type="checkbox" name="haven_video_autoplay" value="1" <?php checked( haven_opt( 'haven_video_autoplay' ), '1' ); ?>> Iniciar automaticamente ao abrir</label></td>
                    </tr>
                    <tr>
                        <th>Repeat</th>
                        <td><input type="hidden" name="haven_video_repeat" value="0"><label><input type="checkbox" name="haven_video_repeat" value="1" <?php checked( haven_opt( 'haven_video_repeat' ), '1' ); ?>> Repetir em loop</label></td>
                    </tr>
                    <tr>
                        <th>Ocultar controles</th>
                        <td><input type="hidden" name="haven_video_hide_controls" value="0"><label><input type="checkbox" name="haven_video_hide_controls" value="1" <?php checked( haven_opt( 'haven_video_hide_controls' ), '1' ); ?>> Esconder barra e controles do player</label></td>
                    </tr>
                    <tr>
                        <th>Imagem de fundo</th>
                        <td>
                            <div class="haven-single-photo">
                                <?php if ( $video_bg ) : ?><img src="<?php echo esc_url( $video_bg ); ?>" style="max-width:400px;border-radius:8px;"><?php endif; ?>
                                <input type="hidden" name="haven_video_bg" id="haven_video_bg" value="<?php echo esc_url( $video_bg ); ?>">
                                <button type="button" class="button haven-upload-single" data-field="haven_video_bg">Escolher imagem</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php submit_button( 'Salvar video do YouTube' ); ?>
        </form>

        <form method="post" action="options.php" style="margin-bottom:1.5rem;">
            <?php settings_fields( 'haven_tours_video_group' ); ?>
            <div class="haven-admin-card">
                <h2>Textos do tour em video</h2>
                <table class="form-table">
                    <tr><th>Titulo da secao</th><td><input type="text" name="haven_video_title" value="<?php echo esc_attr( haven_opt( 'haven_video_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Subtitulo</th><td><?php wp_editor( haven_opt( 'haven_video_subtitle' ), 'haven_video_subtitle_tours', array( 'textarea_name' => 'haven_video_subtitle', 'textarea_rows' => 4, 'media_buttons' => false, 'teeny' => true, 'quicktags' => true ) ); ?></td></tr>
                </table>
                <p class="description">A visibilidade e a ordem desta secao agora ficam centralizadas em Conteudo da landing.</p>
            </div>
            <?php submit_button( 'Salvar textos do tour em video' ); ?>
        </form>

        <form method="post" action="options.php">
            <?php settings_fields( 'haven_matterport_group' ); ?>
            <div class="haven-admin-card">
                <h2>Matterport / Tour Virtual 3D</h2>
                <table class="form-table">
                    <tr>
                        <th>URL do Matterport</th>
                        <td>
                            <input type="url" name="haven_matterport_url" value="<?php echo esc_attr( haven_opt( 'haven_matterport_url' ) ); ?>" class="large-text">
                            <p class="description">Cole o link completo do Matterport (ex: https://my.matterport.com/show/?m=XXXXXXX).</p>
                        </td>
                    </tr>
                    <tr>
                        <th>SDK Key do Matterport</th>
                        <td>
                            <input type="text" name="haven_matterport_sdk_key" value="<?php echo esc_attr( haven_opt( 'haven_matterport_sdk_key' ) ); ?>" class="large-text code">
                            <p class="description">Necessaria para conectar o SDK oficial do player e ativar o autotour. No Matterport Developer Tools, inclua o dominio do site na allow list.</p>
                        </td>
                    </tr>
                    <tr><th>Titulo da secao</th><td><input type="text" name="haven_matterport_title" value="<?php echo esc_attr( haven_opt( 'haven_matterport_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Subtitulo</th><td><?php wp_editor( haven_opt( 'haven_matterport_subtitle' ), 'haven_matterport_subtitle_tours', array( 'textarea_name' => 'haven_matterport_subtitle', 'textarea_rows' => 4, 'media_buttons' => false, 'teeny' => true, 'quicktags' => true ) ); ?></td></tr>
                    <tr>
                        <th>Ativar autotour</th>
                        <td><input type="hidden" name="haven_matterport_autotour" value="0"><label><input type="checkbox" name="haven_matterport_autotour" value="1" <?php checked( haven_opt( 'haven_matterport_autotour' ), '1' ); ?>> Iniciar o percurso automatico quando o player carregar</label></td>
                    </tr>
                    <tr>
                        <th>Modo do percurso</th>
                        <td>
                            <select name="haven_matterport_autotour_mode">
                                <option value="auto" <?php selected( haven_opt( 'haven_matterport_autotour_mode' ), 'auto' ); ?>>Automatico (Highlight Reel primeiro)</option>
                                <option value="guided" <?php selected( haven_opt( 'haven_matterport_autotour_mode' ), 'guided' ); ?>>Somente Guided Tour / Highlight Reel</option>
                                <option value="sweeps" <?php selected( haven_opt( 'haven_matterport_autotour_mode' ), 'sweeps' ); ?>>Percorrer pontos internos</option>
                            </select>
                            <p class="description">No modo automatico, o tema usa o Guided Tour oficial quando houver paradas configuradas e cai para a navegacao pelos pontos internos quando nao houver.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Iniciar apos</th>
                        <td><input type="number" name="haven_matterport_autotour_delay" value="<?php echo esc_attr( haven_opt( 'haven_matterport_autotour_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td>
                    </tr>
                    <tr>
                        <th>Tempo por parada</th>
                        <td>
                            <input type="number" name="haven_matterport_autotour_step_duration" value="<?php echo esc_attr( haven_opt( 'haven_matterport_autotour_step_duration' ) ); ?>" min="4" step="1" class="small-text"> segundos
                            <p class="description">Usado quando o tema precisar percorrer os pontos internos automaticamente.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Duracao da transicao</th>
                        <td><input type="number" name="haven_matterport_autotour_transition_ms" value="<?php echo esc_attr( haven_opt( 'haven_matterport_autotour_transition_ms' ) ); ?>" min="500" step="100" class="small-text"> ms</td>
                    </tr>
                    <tr>
                        <th>Controles externos</th>
                        <td><input type="hidden" name="haven_matterport_autotour_show_controls" value="0"><label><input type="checkbox" name="haven_matterport_autotour_show_controls" value="1" <?php checked( haven_opt( 'haven_matterport_autotour_show_controls' ), '1' ); ?>> Exibir botoes de pausar, retomar e reiniciar sobre o player</label></td>
                    </tr>
                </table>
                <p class="description">A visibilidade e a ordem desta secao agora ficam centralizadas em Conteudo da landing.</p>
            </div>
            <?php submit_button( 'Salvar Matterport' ); ?>
        </form>
    </div>
    <?php
}

// ===================================================================
// LEGACY MATTERPORT PAGE REDIRECT
// ===================================================================
function haven_admin_matterport_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    wp_safe_redirect( admin_url( 'admin.php?page=haven-tours' ) );
    exit;
}
}

if ( ! function_exists( 'haven_admin_native_mode_render' ) ) {
function haven_admin_native_mode_render() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    haven_set_admin_mode( 'native' );
    wp_safe_redirect( admin_url() );
    exit;
}

function haven_admin_simple_mode_render() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    haven_set_admin_mode( 'simple' );
    wp_safe_redirect( haven_get_editor_panel_url() );
    exit;
}

function haven_admin_theme_plugins_render() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    wp_safe_redirect( admin_url( 'admin.php?page=haven-gestao' ) );
    exit;
}

function haven_admin_sidebar_dock_render() {
    if ( ! haven_can_use_simplified_admin() || haven_get_admin_mode() === 'native' ) {
        return;
    }
    $quick_create_links = haven_get_quick_create_links();
    $logout_url         = wp_logout_url( home_url( '/' ) );
    ?>
    <a class="haven-admin-dock-logout" href="<?php echo esc_url( $logout_url ); ?>" title="Sair do site" aria-label="Sair do site">
        <span class="dashicons dashicons-arrow-right-alt2" aria-hidden="true"></span>
    </a>
    <div class="haven-admin-dock" aria-label="Acoes rapidas do editor">
        <?php if ( ! empty( $quick_create_links ) ) : ?>
        <div class="haven-admin-dock-panel" hidden data-haven-dock-panel="create">
            <?php foreach ( $quick_create_links as $quick_link ) : ?>
            <a class="haven-admin-dock-panel-link" href="<?php echo esc_url( $quick_link['url'] ); ?>">
                <span class="dashicons <?php echo esc_attr( $quick_link['icon'] ); ?>" aria-hidden="true"></span>
                <span><?php echo esc_html( $quick_link['label'] ); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <button type="button" class="haven-admin-dock-btn haven-admin-dock-btn-create" data-haven-dock-toggle="create" title="Criar novo" aria-label="Criar novo">
            <span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span>
        </button>
        <?php endif; ?>
        <a class="haven-admin-dock-btn haven-admin-dock-btn-native" href="<?php echo esc_url( haven_get_admin_mode_switch_url( 'native' ) ); ?>" title="Abrir WordPress nativo" aria-label="Abrir WordPress nativo">
            <span class="dashicons dashicons-admin-site-alt3" aria-hidden="true"></span>
        </a>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggle = document.querySelector('[data-haven-dock-toggle="create"]');
            var panel = document.querySelector('[data-haven-dock-panel="create"]');
            if (!toggle || !panel) return;

            var closePanel = function () {
                panel.hidden = true;
                toggle.setAttribute('aria-expanded', 'false');
            };

            toggle.setAttribute('aria-expanded', 'false');

            toggle.addEventListener('click', function (event) {
                event.preventDefault();
                var shouldOpen = panel.hidden;
                panel.hidden = !shouldOpen;
                toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (event) {
                if (panel.hidden) return;
                if (panel.contains(event.target) || toggle.contains(event.target)) return;
                closePanel();
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') closePanel();
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'haven_admin_sidebar_dock_render' );
}

function haven_get_header_logo_image() {
    $image = haven_opt( 'haven_header_logo_image' );
    if ( $image ) {
        return $image;
    }
    return '';
}

if ( ! function_exists( 'haven_get_login_background_image' ) ) {
function haven_get_login_background_image() {
    $image = haven_opt( 'haven_login_bg_image' );
    if ( $image ) {
        return $image;
    }

    $hero_photos = get_option( 'haven_hero_photos', array() );
    if ( is_array( $hero_photos ) && ! empty( $hero_photos[0] ) ) {
        return $hero_photos[0];
    }

    return HAVEN_URI . '/assets/images/hero-exterior.png';
}
}

if ( ! function_exists( 'haven_normalize_gallery_items' ) ) {
function haven_normalize_gallery_items( $items ) {
    if ( ! is_array( $items ) ) {
        return array();
    }

    $normalized = array();

    foreach ( $items as $item ) {
        if ( is_string( $item ) ) {
            $url = esc_url_raw( $item );
            if ( '' === $url ) {
                continue;
            }

            $normalized[] = array(
                'url'   => $url,
                'title' => '',
                'badge' => '',
                'desc'  => '',
                'feat1' => '',
                'feat2' => '',
                'feat3' => '',
            );
            continue;
        }

        if ( ! is_array( $item ) ) {
            continue;
        }

        $url = esc_url_raw( $item['url'] ?? '' );
        if ( '' === $url ) {
            continue;
        }

        $normalized[] = array(
            'url'   => $url,
            'title' => sanitize_text_field( $item['title'] ?? '' ),
            'badge' => sanitize_text_field( $item['badge'] ?? '' ),
            'desc'  => sanitize_textarea_field( $item['desc'] ?? '' ),
            'feat1' => sanitize_text_field( $item['feat1'] ?? '' ),
            'feat2' => sanitize_text_field( $item['feat2'] ?? '' ),
            'feat3' => sanitize_text_field( $item['feat3'] ?? '' ),
        );
    }

    return $normalized;
}
}

if ( ! function_exists( 'haven_get_login_logo_image' ) ) {
function haven_get_login_logo_image() {
    // First try login-specific logo
    $image = haven_opt( 'haven_login_logo_image' );
    if ( $image ) {
        return $image;
    }

    // Then try header logo (shared logo)
    $header_logo = haven_get_header_logo_image();
    if ( $header_logo ) {
        return $header_logo;
    }

    $custom_logo_id = get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $custom_logo = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $custom_logo ) {
            return $custom_logo;
        }
    }

    return '';
}

function haven_login_enqueue_assets() {
    $background = esc_url_raw( haven_get_login_background_image() );
    $logo = esc_url_raw( haven_get_login_logo_image() );
    $brand = haven_opt( 'haven_header_brand' );
    $gold = haven_opt( 'haven_color_gold' );
    $gold_dark = haven_opt( 'haven_color_gold_dark' );
    $dark = haven_opt( 'haven_color_dark' );
    $white = haven_opt( 'haven_color_white' );
    $brand_content = wp_json_encode( $brand ? $brand : 'Residencia JB' );

    wp_enqueue_style(
        'haven-login-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );

    wp_register_style( 'haven-login-style', false, array( 'haven-login-fonts' ), HAVEN_VERSION );
    wp_enqueue_style( 'haven-login-style' );

    $css = '
    body.login{
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:flex-end;
        padding:clamp(24px,4vw,48px);
        background:
            linear-gradient(120deg, rgba(10,8,7,0.35), rgba(10,8,7,0.78)),
            radial-gradient(circle at left center, rgba(255,255,255,0.12), transparent 42%),
            url("' . $background . '") center center / cover no-repeat fixed;
        font-family:"Inter", sans-serif;
    }
    body.login::before{
        content:"";
        position:fixed;
        inset:0;
        background:linear-gradient(90deg, rgba(0,0,0,0.08) 0%, rgba(0,0,0,0.45) 48%, rgba(0,0,0,0.8) 100%);
        pointer-events:none;
    }
    body.login #login{
        width:min(460px, 100%);
        margin:0;
        padding:0;
        position:relative;
        z-index:1;
    }
    body.login #login h1{
        margin:0 0 18px;
    }
    body.login #login h1 a{
        display:block;
        width:100%;
        max-width:220px;
        height:80px;
        margin:0 auto 24px;
        background-position:center;
        background-size:contain;
        background-repeat:no-repeat;
        ' . ( $logo ? 'background-image:url("' . $logo . '") !important; font-size:0 !important; color:transparent !important; text-indent:-9999px !important; filter: brightness(0) invert(1); opacity: 0.9;' : 'background-image:none !important; font-size:0; text-indent:0; width:auto; height:auto; min-height:72px; display:flex; align-items:center; justify-content:center;' ) . '
    }
    ' . ( $logo ? '' : 'body.login #login h1 a::before{content:' . $brand_content . '; color:' . $white . '; font:600 34px/1.1 "Playfair Display", serif; letter-spacing:-0.03em;}' ) . '
    body.login .language-switcher { display: none !important; }
    body.login #loginform,
    body.login #lostpasswordform,
    body.login #resetpassform{
        margin:0;
        padding:32px;
        border:1px solid rgba(255,255,255,0.12);
        border-radius:28px;
        background:linear-gradient(180deg, rgba(33,27,24,0.84), rgba(16,13,11,0.94));
        box-shadow:0 28px 70px rgba(0,0,0,0.35);
        backdrop-filter:blur(18px);
    }
    body.login .haven-login-intro{
        margin:0 0 20px;
        padding:24px 26px;
        border:1px solid rgba(255,255,255,0.14);
        border-radius:28px;
        background:linear-gradient(180deg, rgba(24,20,18,0.72), rgba(24,20,18,0.4));
        box-shadow:0 18px 50px rgba(0,0,0,0.2);
        color:' . $white . ';
        backdrop-filter:blur(16px);
    }
    body.login .haven-login-kicker{
        display:inline-block;
        margin-bottom:10px;
        color:' . $gold . ';
        font:600 12px/1 "Inter", sans-serif;
        letter-spacing:0.22em;
        text-transform:uppercase;
    }
    body.login .haven-login-intro h2{
        margin:0 0 10px;
        color:' . $white . ';
        font:600 clamp(30px, 4vw, 40px)/1.05 "Playfair Display", serif;
        letter-spacing:-0.03em;
    }
    body.login .haven-login-intro p{
        margin:0;
        color:rgba(255,255,255,0.72);
        font-size:14px;
        line-height:1.6;
    }
    body.login label{
        color:rgba(255,255,255,0.82);
        font-weight:500;
    }
    body.login form .input,
    body.login input[type="text"],
    body.login input[type="password"]{
        min-height:50px;
        border:none;
        border-radius:16px;
        background:rgba(255,255,255,0.08);
        box-shadow:inset 0 0 0 1px rgba(255,255,255,0.08);
        color:' . $white . ';
        font-size:15px;
    }
    body.login form .input:focus,
    body.login input[type="text"]:focus,
    body.login input[type="password"]:focus{
        box-shadow:0 0 0 2px rgba(200,164,94,0.18), inset 0 0 0 1px ' . $gold . ';
    }
    body.login .button.wp-hide-pw{
        color:rgba(255,255,255,0.82);
    }
    body.login .button-primary{
        min-height:50px;
        padding:0 26px;
        border:none;
        border-radius:999px;
        background:linear-gradient(135deg, ' . $gold . ', ' . $gold_dark . ');
        color:' . $dark . ';
        font-weight:700;
        box-shadow:0 14px 32px rgba(200,164,94,0.28);
    }
    body.login .button-primary:hover,
    body.login .button-primary:focus{
        background:linear-gradient(135deg, ' . $gold_dark . ', ' . $gold . ');
        color:' . $dark . ';
    }
    body.login .forgetmenot,
    body.login p#nav,
    body.login p#backtoblog{
        color:rgba(255,255,255,0.7);
    }
    body.login p#nav a,
    body.login p#backtoblog a{
        color:rgba(255,255,255,0.82);
    }
    body.login p#nav a:hover,
    body.login p#backtoblog a:hover{
        color:' . $gold . ';
    }
    body.login .message,
    body.login .success,
    body.login #login_error{
        border:none;
        border-radius:18px;
        background:rgba(255,255,255,0.92);
        box-shadow:none;
    }
    @media (max-width: 900px){
        body.login{
            justify-content:center;
            padding:20px;
        }
        body.login::before{
            background:linear-gradient(180deg, rgba(0,0,0,0.45), rgba(0,0,0,0.8));
        }
        body.login #loginform,
        body.login #lostpasswordform,
        body.login #resetpassform,
        body.login .haven-login-intro{
            padding:24px;
        }
    }';

    wp_add_inline_style( 'haven-login-style', $css );
}
add_action( 'login_enqueue_scripts', 'haven_login_enqueue_assets' );

function haven_login_message( $message ) {
    $title = haven_opt( 'haven_login_title' );
    $subtitle = haven_opt( 'haven_login_subtitle' );

    $intro = '<div class="haven-login-intro">';
    $intro .= '<span class="haven-login-kicker">Area restrita</span>';
    $intro .= '<h2>' . esc_html( $title ) . '</h2>';
    $intro .= '<p>' . esc_html( $subtitle ) . '</p>';
    $intro .= '</div>';

    return $intro . $message;
}
add_filter( 'login_message', 'haven_login_message' );

function haven_login_header_url() {
    return home_url( '/' );
}
add_filter( 'login_headerurl', 'haven_login_header_url' );

function haven_login_header_text() {
    return haven_opt( 'haven_header_brand' );
}
add_filter( 'login_headertext', 'haven_login_header_text' );

// Remove language switcher on login screen
add_filter( 'login_display_language_dropdown', '__return_false' );
}

// ===================================================================
// TYPOGRAPHY â€” GOOGLE FONTS SELECTION
// ===================================================================
function haven_get_google_fonts_list() {
    return array(
        'Playfair Display',
        'Inter',
        'DM Sans',
        'Roboto',
        'Open Sans',
        'Lato',
        'Montserrat',
        'Poppins',
        'Raleway',
        'Nunito',
        'Outfit',
        'Work Sans',
        'Source Sans 3',
        'Merriweather',
        'Libre Baskerville',
        'Cormorant Garamond',
        'Lora',
        'Josefin Sans',
        'Oswald',
        'Crimson Text',
        'EB Garamond',
        'Bitter',
        'Cabin',
        'Quicksand',
        'Rubik',
        'Mulish',
        'Manrope',
        'Space Grotesk',
        'Sora',
        'Albert Sans',
    );
}

function haven_get_font_defaults() {
    return array(
        'haven_font_heading' => 'Playfair Display',
        'haven_font_body'    => 'Inter',
        'haven_font_alt'     => 'DM Sans',
    );
}

function haven_register_font_settings() {
    $keys = array_keys( haven_get_font_defaults() );
    foreach ( $keys as $key ) {
        register_setting( 'haven_ui_group', $key, array( 'sanitize_callback' => 'sanitize_text_field' ) );
    }
}
add_action( 'admin_init', 'haven_register_font_settings' );

// Merge font defaults into haven_opt
function haven_merge_font_defaults( $defaults ) {
    return array_merge( $defaults, haven_get_font_defaults() );
}
add_filter( 'haven_opt_defaults', 'haven_merge_font_defaults', 10, 1 );

// Override haven_opt to also check font defaults
function haven_opt_with_fonts( $key ) {
    $font_defaults = haven_get_font_defaults();
    if ( isset( $font_defaults[ $key ] ) ) {
        $val = get_option( $key );
        return ( $val === false || $val === '' ) ? $font_defaults[ $key ] : $val;
    }
    return null;
}

// Patch haven_opt to include font defaults â€” we update haven_get_ui_defaults
// Since haven_opt already checks haven_get_ui_defaults, we add font defaults there

// Add inline CSS to override font variables AND responsive logo sizes
function haven_add_inline_font_vars() {
    $font_heading = haven_opt( 'haven_font_heading' );
    $font_body    = haven_opt( 'haven_font_body' );
    $font_alt     = haven_opt( 'haven_font_alt' );

    $defaults = haven_get_font_defaults();
    if ( ! $font_heading ) $font_heading = $defaults['haven_font_heading'];
    if ( ! $font_body )    $font_body = $defaults['haven_font_body'];
    if ( ! $font_alt )     $font_alt = $defaults['haven_font_alt'];

    $logo_desktop = intval( haven_opt( 'haven_logo_size_desktop' ) ) ?: 48;
    $logo_tablet  = intval( haven_opt( 'haven_logo_size_tablet' ) ) ?: 40;
    $logo_mobile  = intval( haven_opt( 'haven_logo_size_mobile' ) ) ?: 32;
    $hero_title_desktop = intval( haven_opt( 'haven_hero_title_size_desktop' ) ) ?: 88;
    $hero_title_tablet  = intval( haven_opt( 'haven_hero_title_size_tablet' ) ) ?: 64;
    $hero_title_mobile  = intval( haven_opt( 'haven_hero_title_size_mobile' ) ) ?: 44;
    $hero_title_width   = intval( haven_opt( 'haven_hero_title_width' ) ) ?: 750;
    $hero_desc_width    = intval( haven_opt( 'haven_hero_desc_width' ) ) ?: 500;
    $hero_desc_desktop  = intval( haven_opt( 'haven_hero_desc_size_desktop' ) ) ?: 18;
    $hero_desc_mobile   = intval( haven_opt( 'haven_hero_desc_size_mobile' ) ) ?: 16;
    $preloader_bg       = haven_opt( 'haven_preloader_bg_color' ) ?: '#ffffff';
    $preloader_accent   = haven_opt( 'haven_preloader_accent_color' ) ?: '#c8a45e';
    $preloader_logo_size= intval( haven_opt( 'haven_preloader_logo_size' ) ) ?: 64;
    $footer_desktop = round( $logo_desktop * 1.1 );

    $css = ':root{';
    $css .= "--font-display:'" . esc_attr( $font_heading ) . "', Georgia, serif;";
    $css .= "--font-body:'" . esc_attr( $font_body ) . "', -apple-system, sans-serif;";
    $css .= "--font-alt:'" . esc_attr( $font_alt ) . "', sans-serif;";
    $css .= '}';

    // Responsive logo sizing
    $css .= '.hv-header-logo-png{max-height:' . $logo_desktop . 'px;}';
    $css .= '.hv-footer-logo-img{max-height:' . $footer_desktop . 'px;}';
    $css .= '.hv-hero-heading{font-size:min(6vw,' . $hero_title_desktop . 'px);max-width:' . $hero_title_width . 'px;}';
    $css .= '.hv-hero-desc{font-size:' . $hero_desc_desktop . 'px;max-width:' . $hero_desc_width . 'px;}';
    $css .= '.hv-preloader{background:' . esc_attr( $preloader_bg ) . ';}';
    $css .= '.hv-preloader-logo span{color:' . esc_attr( $preloader_accent ) . ';}';
    $css .= '.hv-preloader-bar::after{background:' . esc_attr( $preloader_accent ) . ';}';
    $css .= '.hv-preloader-logo-img{max-height:' . $preloader_logo_size . 'px;}';
    $css .= '@media(max-width:1024px){';
    $css .= '.hv-header-logo-png{max-height:' . $logo_tablet . 'px;}';
    $css .= '.hv-footer-logo-img{max-height:' . round( $logo_tablet * 1.1 ) . 'px;}';
    $css .= '.hv-hero-heading{font-size:min(7vw,' . $hero_title_tablet . 'px);}';
    $css .= '}';
    $css .= '@media(max-width:768px){';
    $css .= '.hv-header-logo-png{max-height:' . $logo_mobile . 'px;}';
    $css .= '.hv-footer-logo-img{max-height:' . round( $logo_mobile * 1.1 ) . 'px;}';
    $css .= '.hv-hero-heading{font-size:min(10vw,' . $hero_title_mobile . 'px);}';
    $css .= '.hv-hero-desc{font-size:' . $hero_desc_mobile . 'px;max-width:min(100%,' . $hero_desc_width . 'px);}';
    $css .= '}';

    wp_add_inline_style( 'haven-premium', $css );
}
add_action( 'wp_enqueue_scripts', 'haven_add_inline_font_vars', 31 );

// Typography admin page render
function haven_admin_tipografia_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $fonts = haven_get_google_fonts_list();
    $defaults = haven_get_font_defaults();
    $current_heading = haven_opt( 'haven_font_heading' ) ?: $defaults['haven_font_heading'];
    $current_body    = haven_opt( 'haven_font_body' ) ?: $defaults['haven_font_body'];
    $current_alt     = haven_opt( 'haven_font_alt' ) ?: $defaults['haven_font_alt'];
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Tipografia</h1>
            <p>Escolha as fontes do Google Fonts para titulos, corpo de texto e elementos auxiliares.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_typography_group' ); ?>
            <div class="haven-admin-card">
                <h2>Fontes do Site</h2>
                <p class="description" style="margin-bottom:1.5rem;">As fontes sao carregadas automaticamente do Google Fonts. A alteracao e aplicada em todo o site.</p>
                <table class="form-table">
                    <tr>
                        <th>Titulos (Display)</th>
                        <td>
                            <select name="haven_font_heading" class="haven-font-select" data-preview="heading">
                                <?php foreach ( $fonts as $font ) : ?>
                                    <option value="<?php echo esc_attr( $font ); ?>" <?php selected( $current_heading, $font ); ?>><?php echo esc_html( $font ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description">Usada em h1, h2, h3 e titulos de secoes.</p>
                            <div class="haven-font-preview" id="preview-heading" style="font-family:'<?php echo esc_attr( $current_heading ); ?>'; font-size:28px; font-weight:700; margin-top:12px; color:#2c2824;">
                                Residencia Jardim Botanico
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Corpo (Body)</th>
                        <td>
                            <select name="haven_font_body" class="haven-font-select" data-preview="body">
                                <?php foreach ( $fonts as $font ) : ?>
                                    <option value="<?php echo esc_attr( $font ); ?>" <?php selected( $current_body, $font ); ?>><?php echo esc_html( $font ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description">Usada em paragrafos, botoes e texto geral.</p>
                            <div class="haven-font-preview" id="preview-body" style="font-family:'<?php echo esc_attr( $current_body ); ?>'; font-size:15px; margin-top:12px; color:#6b6560; line-height:1.7;">
                                Residencia de altissimo padrao no setor mais exclusivo do Jardim Botanico de Brasilia, com 730m2 de area construida em terreno integrado a natureza.
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Auxiliar (Alt)</th>
                        <td>
                            <select name="haven_font_alt" class="haven-font-select" data-preview="alt">
                                <?php foreach ( $fonts as $font ) : ?>
                                    <option value="<?php echo esc_attr( $font ); ?>" <?php selected( $current_alt, $font ); ?>><?php echo esc_html( $font ); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="description">Usada em labels, badges e subtitulos.</p>
                            <div class="haven-font-preview" id="preview-alt" style="font-family:'<?php echo esc_attr( $current_alt ); ?>'; font-size:12px; letter-spacing:0.15em; text-transform:uppercase; margin-top:12px; color:#c8a45e; font-weight:600;">
                                Galeria de ambientes · Exclusivo
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php submit_button( 'Salvar Tipografia' ); ?>
        </form>
    </div>
    <script>
    (function(){
        var loadedFonts = {};
        document.querySelectorAll('.haven-font-select').forEach(function(sel){
            sel.addEventListener('change', function(){
                var font = this.value;
                var previewId = this.dataset.preview;
                var previewEl = document.getElementById('preview-' + previewId);
                if(previewEl) previewEl.style.fontFamily = "'" + font + "', sans-serif";
                if(!loadedFonts[font]){
                    var link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = 'https://fonts.googleapis.com/css2?family=' + font.replace(/ /g, '+') + ':wght@400;500;600;700&display=swap';
                    document.head.appendChild(link);
                    loadedFonts[font] = true;
                }
            });
        });
    })();
    </script>
    <?php
}


// Tipografia submenu already added in haven_admin_menu_rebuild


// ===================================================================
// SECTION ORDERING - DRAG & DROP
// ===================================================================
// Loaded from /inc/haven-sections-core.php


// Add font defaults to UI defaults
function haven_merge_font_ui_defaults() {
    // This is handled by haven_opt checking haven_get_font_defaults
}

// Make sure haven_opt also checks font defaults
// We need to update haven_opt or add font defaults to haven_get_ui_defaults
// Easiest: add to haven_get_ui_defaults â€” but since we already modified it, let's hook into haven_opt

// Font defaults are merged into the option check via a wrapper approach:
// Since we already have haven_opt checking haven_get_ui_defaults, let's add font keys there

// Allowed pages update for tipografia
function haven_add_tipografia_allowed_page( $allowed_pages ) {
    $allowed_pages[] = 'haven-tipografia';
    return $allowed_pages;
}

// Add tipografia to dashboard cards dynamically
function haven_tipografia_dashboard_card() {
    // This is handled via the admin_menu_rebuild hook below
}
