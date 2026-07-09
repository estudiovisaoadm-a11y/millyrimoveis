<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function haven_register_settings() {
    $media = array( 'haven_hero_photos', 'haven_gallery_photos', 'haven_details_gallery_photos', 'haven_video_bg' );
    foreach ( $media as $key ) register_setting( 'haven_media_group', $key );
    register_setting( 'haven_media_group', 'haven_video_url', array( 'sanitize_callback' => 'haven_sanitize_video_url' ) );
    register_setting( 'haven_media_group', 'haven_video_format', array( 'sanitize_callback' => 'haven_sanitize_video_format' ) );
    register_setting( 'haven_media_group', 'haven_video_autoplay', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_media_group', 'haven_video_repeat', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_media_group', 'haven_video_hide_controls', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );

    $media_gallery_toggles = array(
        'haven_gallery_autoplay',
        'haven_gallery_random',
        'haven_details_gallery_autoplay',
        'haven_details_gallery_random',
    );
    foreach ( $media_gallery_toggles as $key ) {
        register_setting( 'haven_media_group', $key, array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    }

    $media_gallery_numbers = array(
        'haven_gallery_autoplay_speed',
        'haven_details_gallery_autoplay_speed',
    );
    foreach ( $media_gallery_numbers as $key ) {
        register_setting( 'haven_media_group', $key, array( 'sanitize_callback' => 'absint' ) );
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
            <?php settings_fields( 'haven_media_group' ); ?>
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
            <?php settings_fields( 'haven_media_group' ); ?>
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
                    <tr><th>Titulo da secao</th><td><input type="text" name="haven_matterport_title" value="<?php echo esc_attr( haven_opt( 'haven_matterport_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Subtitulo</th><td><?php wp_editor( haven_opt( 'haven_matterport_subtitle' ), 'haven_matterport_subtitle_tours', array( 'textarea_name' => 'haven_matterport_subtitle', 'textarea_rows' => 4, 'media_buttons' => false, 'teeny' => true, 'quicktags' => true ) ); ?></td></tr>
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

