<?php
/**
 * Residência JB — Theme Functions
 * Tema clássico compatível com Elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HAVEN_VERSION', '1.0.0' );
define( 'HAVEN_DIR', get_template_directory() );
define( 'HAVEN_URI', get_template_directory_uri() );

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
        'footer'  => 'Menu do Rodapé',
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
    // Google Fonts
    wp_enqueue_style( 'haven-google-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&family=Inter:wght@300;400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap',
        array(), null
    );

    // Theme stylesheet
    wp_enqueue_style( 'haven-style', get_stylesheet_uri(), array(), HAVEN_VERSION );

    // Premium CSS
    wp_enqueue_style( 'haven-premium', HAVEN_URI . '/assets/css/premium.css', array(), HAVEN_VERSION );

    // Premium JS
    wp_enqueue_script( 'haven-premium-js', HAVEN_URI . '/assets/js/premium.js', array(), HAVEN_VERSION, true );

    // Localize JS with theme data
    wp_localize_script( 'haven-premium-js', 'havenData', array(
        'themeUrl' => HAVEN_URI,
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
    ));
}
add_action( 'wp_enqueue_scripts', 'haven_enqueue_assets' );

// ===================================================================
// 3. ELEMENTOR SUPPORT — CRITICAL
// ===================================================================

// Declare Elementor locations support
function haven_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'haven_register_elementor_locations' );

// Load Elementor custom widgets
if ( file_exists( HAVEN_DIR . '/inc/elementor/init.php' ) ) {
    require_once HAVEN_DIR . '/inc/elementor/init.php';
}

// ===================================================================
// 4. ADMIN — ENQUEUE
// ===================================================================
function haven_admin_enqueue( $hook ) {
    if ( strpos( $hook, 'haven-' ) === false ) return;
    wp_enqueue_media();
    wp_enqueue_style( 'haven-admin-css', HAVEN_URI . '/assets/css/admin.css', array(), HAVEN_VERSION );
    wp_enqueue_script( 'haven-admin-js', HAVEN_URI . '/assets/js/admin.js', array( 'jquery' ), HAVEN_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'haven_admin_enqueue' );

// ===================================================================
// 5. ADMIN MENU — GESTÃO DE CONTEÚDO
// ===================================================================
function haven_admin_menu() {
    add_menu_page(
        'Gestão da Residência', '🏡 Residência JB', 'manage_options',
        'haven-gestao', 'haven_admin_fotos_render', 'dashicons-admin-home', 3
    );
    add_submenu_page( 'haven-gestao', 'Fotos & Vídeo', '📸 Fotos & Vídeo', 'manage_options', 'haven-gestao', 'haven_admin_fotos_render' );
    add_submenu_page( 'haven-gestao', 'Textos & Informações', '✏️ Textos & Info', 'manage_options', 'haven-textos', 'haven_admin_textos_render' );
}
add_action( 'admin_menu', 'haven_admin_menu' );

// ===================================================================
// 6. REGISTER SETTINGS
// ===================================================================
function haven_register_settings() {
    $media = array( 'haven_hero_photos', 'haven_gallery_photos', 'haven_video_url', 'haven_video_bg' );
    foreach ( $media as $key ) register_setting( 'haven_media_group', $key );

    $text = array(
        'haven_property_name', 'haven_property_tagline', 'haven_property_price',
        'haven_property_address', 'haven_property_description',
        'haven_hero_title', 'haven_hero_subtitle',
        'haven_stat_area', 'haven_stat_terreno', 'haven_stat_suites',
        'haven_stat_vagas', 'haven_stat_banheiros', 'haven_stat_construcao', 'haven_stat_piscina',
        'haven_amenities', 'haven_whatsapp', 'haven_telefone', 'haven_email', 'haven_creci',
    );
    foreach ( $text as $key ) register_setting( 'haven_text_group', $key );
}
add_action( 'admin_init', 'haven_register_settings' );

// ---- Default Values ----
function haven_get_defaults() {
    return array(
        'haven_property_name'        => 'Residência Jardim Botânico',
        'haven_property_tagline'     => 'Exclusivo · Jardim Botânico · Brasília – DF',
        'haven_property_price'       => 'R$ 8.500.000',
        'haven_property_address'     => 'SHIN QI 15, Jardim Botânico, Brasília – DF, 71680-150',
        'haven_property_description' => 'Residência de altíssimo padrão no setor mais exclusivo do Jardim Botânico de Brasília.',
        'haven_hero_title'           => 'Uma Residência <em>Única</em> em Harmonia com a Natureza',
        'haven_hero_subtitle'        => '730m² de puro requinte no endereço mais nobre de Brasília.',
        'haven_stat_area'            => '730',
        'haven_stat_terreno'         => '1200',
        'haven_stat_suites'          => '5',
        'haven_stat_vagas'           => '6',
        'haven_stat_banheiros'       => '7',
        'haven_stat_construcao'      => '2024',
        'haven_stat_piscina'         => '25m',
        'haven_amenities'            => 'Piscina Infinita, Automação Total, Adega Climatizada, Home Theater, Espaço Gourmet, Jardim Tropical, Energia Solar, Academia, Sauna Seca, Segurança 24h',
        'haven_whatsapp'             => '5561999999999',
        'haven_telefone'             => '(61) 99999-9999',
        'haven_email'                => 'contato@residenciajb.com.br',
        'haven_creci'                => 'CRECI-DF 00000',
        'haven_video_url'            => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
    );
}

function haven_opt( $key ) {
    $defaults = haven_get_defaults();
    $val = get_option( $key );
    return ( $val === false || $val === '' ) ? ( $defaults[ $key ] ?? '' ) : $val;
}

// ===================================================================
// 7. ADMIN PAGE RENDERS
// ===================================================================
function haven_admin_fotos_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    $hero_photos   = get_option( 'haven_hero_photos', array() );
    if ( ! is_array( $hero_photos ) ) $hero_photos = array();
    $gallery_photos = get_option( 'haven_gallery_photos', array() );
    if ( ! is_array( $gallery_photos ) ) $gallery_photos = array();
    $video_url = haven_opt( 'haven_video_url' );
    $video_bg  = get_option( 'haven_video_bg', '' );
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>📸 Gestão de Fotos & Vídeo</h1>
            <p>Gerencie todas as imagens e o vídeo da landing page.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_media_group' ); ?>
            <div class="haven-admin-card">
                <h2>🖼️ Fotos do Banner Principal (Hero Slider)</h2>
                <p class="description">Recomendamos pelo menos 3 fotos de alta resolução (1920×1080+).</p>
                <div id="haven-hero-photos" class="haven-photo-grid">
                    <?php foreach ( $hero_photos as $i => $url ) : ?>
                    <div class="haven-photo-item" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $url ); ?>" alt="Hero <?php echo $i + 1; ?>">
                        <div class="haven-photo-actions">
                            <button type="button" class="button haven-change-photo" data-target="hero" data-index="<?php echo $i; ?>">Trocar</button>
                            <button type="button" class="button haven-remove-photo" data-target="hero" data-index="<?php echo $i; ?>">✕</button>
                        </div>
                        <input type="hidden" name="haven_hero_photos[]" value="<?php echo esc_url( $url ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary haven-add-photo" data-target="hero" style="margin-top:12px;">+ Adicionar Foto ao Hero</button>
            </div>
            <div class="haven-admin-card">
                <h2>🏠 Fotos da Galeria de Ambientes</h2>
                <p class="description">Cada foto terá um card no carrossel e aparecerá no lightbox.</p>
                <div id="haven-gallery-photos" class="haven-photo-grid">
                    <?php foreach ( $gallery_photos as $i => $item ) : ?>
                    <div class="haven-photo-item" data-index="<?php echo $i; ?>">
                        <img src="<?php echo esc_url( $item['url'] ); ?>">
                        <div class="haven-photo-fields">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][title]" value="<?php echo esc_attr( $item['title'] ?? '' ); ?>" placeholder="Nome do ambiente">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][badge]" value="<?php echo esc_attr( $item['badge'] ?? '' ); ?>" placeholder="Badge (ex: Destaque)">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][desc]" value="<?php echo esc_attr( $item['desc'] ?? '' ); ?>" placeholder="Descrição curta">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat1]" value="<?php echo esc_attr( $item['feat1'] ?? '' ); ?>" placeholder="Feature 1">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat2]" value="<?php echo esc_attr( $item['feat2'] ?? '' ); ?>" placeholder="Feature 2">
                            <input type="text" name="haven_gallery_photos[<?php echo $i; ?>][feat3]" value="<?php echo esc_attr( $item['feat3'] ?? '' ); ?>" placeholder="Feature 3">
                        </div>
                        <div class="haven-photo-actions">
                            <button type="button" class="button haven-change-photo" data-target="gallery" data-index="<?php echo $i; ?>">Trocar</button>
                            <button type="button" class="button haven-remove-photo" data-target="gallery" data-index="<?php echo $i; ?>">✕</button>
                        </div>
                        <input type="hidden" name="haven_gallery_photos[<?php echo $i; ?>][url]" value="<?php echo esc_url( $item['url'] ); ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary haven-add-gallery-photo" style="margin-top:12px;">+ Adicionar Ambiente</button>
            </div>
            <div class="haven-admin-card">
                <h2>🎥 Vídeo Tour Virtual</h2>
                <table class="form-table">
                    <tr><th>URL Embed Vídeo</th><td><input type="url" name="haven_video_url" value="<?php echo esc_url( $video_url ); ?>" class="large-text"></td></tr>
                    <tr><th>Imagem de Fundo</th><td>
                        <div class="haven-single-photo">
                            <?php if ( $video_bg ) : ?><img src="<?php echo esc_url( $video_bg ); ?>" style="max-width:400px;border-radius:8px;"><?php endif; ?>
                            <input type="hidden" name="haven_video_bg" id="haven_video_bg" value="<?php echo esc_url( $video_bg ); ?>">
                            <button type="button" class="button haven-upload-single" data-field="haven_video_bg">Escolher Imagem</button>
                        </div>
                    </td></tr>
                </table>
            </div>
            <?php submit_button( '💾 Salvar Fotos & Vídeo' ); ?>
        </form>
    </div>
    <?php
}

function haven_admin_textos_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header"><h1>✏️ Textos & Informações</h1><p>Edite todas as informações textuais.</p></div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_text_group' ); ?>
            <div class="haven-admin-card"><h2>🏠 Banner Principal</h2>
                <table class="form-table">
                    <tr><th>Tagline</th><td><input type="text" name="haven_property_tagline" value="<?php echo esc_attr( haven_opt( 'haven_property_tagline' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Título</th><td><input type="text" name="haven_hero_title" value="<?php echo esc_attr( haven_opt( 'haven_hero_title' ) ); ?>" class="large-text"><p class="description">Use &lt;em&gt;palavra&lt;/em&gt; para itálico dourado.</p></td></tr>
                    <tr><th>Subtítulo</th><td><textarea name="haven_hero_subtitle" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_hero_subtitle' ) ); ?></textarea></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>📋 Dados do Imóvel</h2>
                <table class="form-table">
                    <tr><th>Nome</th><td><input type="text" name="haven_property_name" value="<?php echo esc_attr( haven_opt( 'haven_property_name' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Preço</th><td><input type="text" name="haven_property_price" value="<?php echo esc_attr( haven_opt( 'haven_property_price' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Endereço</th><td><input type="text" name="haven_property_address" value="<?php echo esc_attr( haven_opt( 'haven_property_address' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Descrição</th><td><textarea name="haven_property_description" rows="5" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_property_description' ) ); ?></textarea></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>📐 Especificações</h2>
                <table class="form-table">
                    <tr><th>Área (m²)</th><td><input type="text" name="haven_stat_area" value="<?php echo esc_attr( haven_opt( 'haven_stat_area' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Terreno (m²)</th><td><input type="text" name="haven_stat_terreno" value="<?php echo esc_attr( haven_opt( 'haven_stat_terreno' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Suítes</th><td><input type="text" name="haven_stat_suites" value="<?php echo esc_attr( haven_opt( 'haven_stat_suites' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Banheiros</th><td><input type="text" name="haven_stat_banheiros" value="<?php echo esc_attr( haven_opt( 'haven_stat_banheiros' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Vagas</th><td><input type="text" name="haven_stat_vagas" value="<?php echo esc_attr( haven_opt( 'haven_stat_vagas' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Construção</th><td><input type="text" name="haven_stat_construcao" value="<?php echo esc_attr( haven_opt( 'haven_stat_construcao' ) ); ?>" class="small-text"></td></tr>
                    <tr><th>Piscina</th><td><input type="text" name="haven_stat_piscina" value="<?php echo esc_attr( haven_opt( 'haven_stat_piscina' ) ); ?>" class="small-text"></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>✨ Amenidades</h2>
                <table class="form-table">
                    <tr><th>Lista</th><td><textarea name="haven_amenities" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_amenities' ) ); ?></textarea><p class="description">Separe por vírgula.</p></td></tr>
                </table>
            </div>
            <div class="haven-admin-card"><h2>📞 Contato</h2>
                <table class="form-table">
                    <tr><th>WhatsApp (números)</th><td><input type="text" name="haven_whatsapp" value="<?php echo esc_attr( haven_opt( 'haven_whatsapp' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>Telefone</th><td><input type="text" name="haven_telefone" value="<?php echo esc_attr( haven_opt( 'haven_telefone' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>E-mail</th><td><input type="email" name="haven_email" value="<?php echo esc_attr( haven_opt( 'haven_email' ) ); ?>" class="regular-text"></td></tr>
                    <tr><th>CRECI</th><td><input type="text" name="haven_creci" value="<?php echo esc_attr( haven_opt( 'haven_creci' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>
            <?php submit_button( '💾 Salvar Informações' ); ?>
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
