<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

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

        if ( function_exists( 'haven_normalize_matterport_inline_href' ) ) {
            $href = haven_normalize_matterport_inline_href( $href );
        }

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

    if ( ! preg_match( '/Ã.|Â.|â.|ðŸ|�/u', $value ) ) {
        return $value;
    }

    if ( ! function_exists( 'mb_convert_encoding' ) ) {
        return $value;
    }

    $converted = mb_convert_encoding( $value, 'UTF-8', 'Windows-1252' );
    return is_string( $converted ) && '' !== $converted ? $converted : $value;
}

function haven_repair_mojibake_options() {
    if ( get_option( 'haven_options_mojibake_repaired_v1' ) ) {
        return;
    }

    $option_keys = array_keys( array_merge( haven_get_defaults(), haven_get_ui_defaults() ) );
    $option_keys = array_merge(
        $option_keys,
        array(
            'haven_gallery_photos',
            'haven_details_gallery_photos',
            'haven_cta_form_fields',
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

    update_option( 'haven_options_mojibake_repaired_v1', '1' );
}
add_action( 'init', 'haven_repair_mojibake_options', 5 );

// ===================================================================
// 7. ADMIN PAGE RENDERS
// ===================================================================
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

