<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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

// ===================================================================
// TOURS E VIDEOS ADMIN PAGE
// ===================================================================

function haven_get_login_background_image() {
    $image = haven_opt( 'haven_login_bg_image' );
    if ( $image ) {
        return $image;
    }

    $hero_photos = get_option( 'haven_hero_photos', array() );
    if ( is_array( $hero_photos ) && ! empty( $hero_photos[0] ) ) {
        return $hero_photos[0];
    }

    return defined( 'HAVEN_URI' ) ? HAVEN_URI . '/assets/images/hero-exterior.png' : '';
}


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

    $login_style_version = defined( 'HAVEN_VERSION' )
        ? HAVEN_VERSION
        : ( defined( 'HAVEN_WHITE_LABEL_LOGIN_VERSION' ) ? HAVEN_WHITE_LABEL_LOGIN_VERSION : null );

    wp_register_style( 'haven-login-style', false, array( 'haven-login-fonts' ), $login_style_version );
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

// ===================================================================
// TYPOGRAPHY â€” GOOGLE FONTS SELECTION
// ===================================================================
