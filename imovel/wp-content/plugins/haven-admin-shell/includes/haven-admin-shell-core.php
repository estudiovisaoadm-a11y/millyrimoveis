<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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
    if ( get_option( 'haven_options_reset_v5' ) ) return;
    $defaults1 = haven_get_defaults();
    $defaults2 = function_exists('haven_get_ui_defaults') ? haven_get_ui_defaults() : array();
    $keys = array_merge( array_keys($defaults1), array_keys($defaults2) );
    foreach ( $keys as $k ) {
        delete_option( $k );
    }
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
        return admin_url( 'admin.php?page=haven-gestao' );
    }

    return $redirect_to;
}
add_filter( 'login_redirect', 'haven_login_redirect_to_panel', 10, 3 );

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

    add_submenu_page( 'haven-gestao', 'Header e navegacao', 'Header e navegacao', 'manage_options', 'haven-header', 'haven_admin_header_render' );
    add_submenu_page( 'haven-gestao', 'Conteudo da landing', 'Conteudo da landing', 'manage_options', 'haven-secoes', 'haven_admin_sections_render' );
    add_submenu_page( 'haven-gestao', 'Galeria e imagens', 'Galeria e imagens', 'manage_options', 'haven-fotos', 'haven_admin_fotos_render' );
    add_submenu_page( 'haven-gestao', 'Tours e videos', 'Tours e videos', 'manage_options', 'haven-tours', 'haven_admin_tours_render' );
    add_submenu_page( 'haven-gestao', 'Depoimentos', 'Depoimentos', 'manage_options', 'haven-depoimentos', 'haven_admin_testimonials_render' );
    add_submenu_page( 'haven-gestao', 'Imovel e contato', 'Imovel e contato', 'manage_options', 'haven-textos', 'haven_admin_textos_render' );
    add_submenu_page( 'haven-gestao', 'Conversao e WhatsApp', 'Conversao e WhatsApp', 'manage_options', 'haven-cta-form', 'haven_admin_cta_form_render' );
    add_submenu_page( 'haven-gestao', 'Menus visuais', 'Menus visuais', 'manage_options', 'haven-menus', 'haven_admin_menus_render' );
    add_submenu_page( 'haven-gestao', 'Rodape e redes', 'Rodape e redes', 'manage_options', 'haven-footer', 'haven_admin_footer_render' );
    add_submenu_page( 'haven-gestao', 'Preloader', 'Preloader', 'manage_options', 'haven-preloader', 'haven_admin_preloader_render' );
    add_submenu_page( 'haven-gestao', 'Plugins do tema', 'Plugins do tema', 'manage_options', 'haven-theme-plugins', 'haven_admin_theme_plugins_render' );
    add_submenu_page( 'haven-gestao', 'Cores', 'Cores', 'manage_options', 'haven-cores', 'haven_admin_cores_render' );
    add_submenu_page( 'haven-gestao', 'Tipografia', 'Tipografia', 'manage_options', 'haven-tipografia', 'haven_admin_tipografia_render' );
    add_submenu_page( 'haven-gestao', 'Tela de login', 'Tela de login', 'manage_options', 'haven-login', 'haven_admin_login_render' );
    if ( haven_get_admin_mode() === 'native' ) {
        add_submenu_page( 'haven-gestao', 'Voltar ao painel', 'Voltar ao painel', 'manage_options', 'haven-simple-mode', 'haven_admin_simple_mode_render' );
    } else {
        add_submenu_page( 'haven-gestao', 'Abrir WordPress nativo', 'Abrir WordPress nativo', 'manage_options', 'haven-native-mode', 'haven_admin_native_mode_render' );
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
        'haven-theme-plugins',
        'haven-login',
        'haven-cores',
        'haven-tipografia',
        'haven-native-mode',
        'haven-simple-mode',
    );

    if ( $pagenow === 'options.php' || $pagenow === 'admin-ajax.php' || $pagenow === 'async-upload.php' ) {
        return;
    }

    if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && in_array( sanitize_key( wp_unslash( $_GET['page'] ) ), $allowed_pages, true ) ) {
        return;
    }

    if ( $pagenow === 'themes.php' && isset( $_GET['page'] ) && 'tgmpa-install-plugins' === sanitize_key( wp_unslash( $_GET['page'] ) ) ) {
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

function haven_get_editor_panel_url() {
    return admin_url( 'admin.php?page=haven-gestao' );
}

function haven_admin_bar_editor_redirects( $wp_admin_bar ) {
    if ( ! is_user_logged_in() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $panel_url = haven_get_editor_panel_url();

    if ( $wp_admin_bar->get_node( 'site-name' ) ) {
        $wp_admin_bar->add_node(
            array(
                'id'    => 'site-name',
                'href'  => $panel_url,
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
        array(
            'title' => 'Plugins do tema',
            'eyebrow' => 'Extensoes',
            'desc'  => 'Instale ou atualize os plugins complementares empacotados com o tema.',
            'url'   => admin_url( 'admin.php?page=haven-theme-plugins' ),
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
    wp_safe_redirect( admin_url( 'admin.php?page=haven-gestao' ) );
    exit;
}

function haven_admin_theme_plugins_render() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    wp_safe_redirect( admin_url( 'themes.php?page=tgmpa-install-plugins' ) );
    exit;
}

