<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function haven_get_ui_defaults() {
    return array(
        'haven_header_brand'         => 'Residencia JB',
        'haven_header_logo_image'    => '',
        'haven_header_cta_text'      => 'Agendar visita',
        'haven_header_cta_link'      => '#contato',
        'haven_header_show_cta'      => '1',
        'haven_hero_primary_text'    => 'Iniciar tour virtual',
        'haven_hero_primary_link'    => '#tour3d',
        'haven_hero_secondary_text'  => 'Agende uma visita',
        'haven_hero_secondary_link'  => '#contato',
        'haven_about_label'          => 'Sobre a casa',
        'haven_about_title'          => 'Bem-vindo(a) ao Seu Novo Lar de Alto Padrão',
        'haven_about_button_text'    => 'Ver mais ambientes',
        'haven_about_button_link'    => '#galeria',
        'haven_gallery_label'        => 'Galeria de ambientes',
        'haven_gallery_title'        => 'Conheça cada detalhe',
        'haven_gallery_subtitle'     => 'Explore o conforto dos ambientes internos e o refúgio espetacular da área de lazer.',
        'haven_video_title'          => 'Tour virtual cinematografico',
        'haven_video_subtitle'       => 'Caminhe por todos os comodos e encante-se com o melhor do Condomínio Verde no Jardim Botânico.',
        'haven_location_label'       => 'Localizacao privilegiada',
        'haven_location_title'       => 'Condomínio Verde: Tranquilidade Absoluta',
        'haven_location_region'      => 'Brasilia - DF',
        'haven_location_map_embed'   => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15354.896753068694!2d-47.8173!3d-15.8679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a2debc777a4eb%3A0xe549df9c26f0f512!2sJardim%20Botanico%2C%20Brasilia%20-%20DF!5e0!3m2!1spt-BR!2sbr!4v1700000000000!5m2!1spt-BR!2sbr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
        'haven_testimonials_label'   => 'Infraestrutura de Comunidade',
        'haven_testimonials_title'   => 'Lazer, Conveniência e Segurança 24h a passos de casa',
        'haven_testimonial_1_quote'  => 'Aqui você tem tudo ao seu alcance: administração ágil, correio interno no condomínio e até uma prática mini mercearia aberta todos os dias.',
        'haven_testimonial_1_name'   => 'Comodidade Otimizada',
        'haven_testimonial_1_role'   => 'Praticidade diária',
        'haven_testimonial_1_avatar' => '★',
        'haven_testimonial_2_quote'  => 'Segurança é prioridade máxima. O condomínio oferece portaria permanente, rondas e segurança motorizadas 24h com moderno reconhecimento facial.',
        'haven_testimonial_2_name'   => 'Privacidade e Paz',
        'haven_testimonial_2_role'   => 'Segurança 24h',
        'haven_testimonial_2_avatar' => '🛡️',
        'haven_testimonial_3_quote'  => 'Momentos em família muito mais divertidos com a quadra de esportes, o campo de futebol, a moderna academia ao ar livre, o lindo lago e as encantadoras trilhas.',
        'haven_testimonial_3_name'   => 'Resort Particular',
        'haven_testimonial_3_role'   => 'Esporte & Lazer',
        'haven_testimonial_3_avatar' => '🌳',
        'haven_cta_title'            => 'Já consegue se imaginar <em>vivendo</em> aqui?',
        'haven_cta_desc'             => 'Casas exclusivas recém-construídas com Habite-se raramente ficam disponíveis no mercado. (Condomínio: R$ 660,00 | IPTU: R$ 447,39 6x | Cód: 1162567). Agende sua visita.',
        'haven_cta_whatsapp_text'    => 'Agendar Visita Agora',
        'haven_cta_phone_text'       => 'Ligar para Corretor',
        'haven_whatsapp_message'     => 'Ola! Gostaria de agendar uma visita na incrível casa à venda no Condomínio Verde.',
        'haven_cta_form_title'       => 'Antes de agendar, conte um pouco do seu perfil',
        'haven_cta_form_desc'        => 'Preencha as opcoes abaixo para enviarmos um atendimento mais rapido e direcionado no WhatsApp.',
        'haven_cta_form_message_intro' => 'Ola! Quero agendar uma visita no imovel {imovel}. Seguem minhas respostas:',
        'haven_cta_form_submit_text' => 'Enviar no WhatsApp',
        'haven_cta_form_company_name' => 'Atendimento no WhatsApp',
        'haven_cta_form_avatar'      => '',
        'haven_floating_cta_enabled' => '1',
        'haven_floating_cta_corner'  => 'bottom-right',
        'haven_floating_cta_show_delay' => '6',
        'haven_floating_cta_pulse_delay' => '10',
        'haven_floating_cta_message_delay' => '14',
        'haven_floating_cta_badge_message_delay' => '2',
        'haven_floating_cta_badge_section' => 'galeria',
        'haven_floating_cta_badge_text' => '1',
        'haven_floating_cta_message_text' => 'Quer agilizar seu atendimento? Responda em 30 segundos e eu preparo sua mensagem no WhatsApp.',
        'haven_footer_brand'         => 'Residencia JB',
        'haven_footer_menu_title'    => 'A casa',
        'haven_footer_location_title'=> 'Localizacao',
        'haven_footer_contact_title' => 'Contato',
        'haven_footer_copyright'     => 'Residencia Jardim Botanico. Todos os direitos reservados.',
        'haven_footer_instagram'     => '',
        'haven_footer_facebook'      => '',
        'haven_footer_youtube'       => '',
        'haven_login_title'          => 'Acesso exclusivo',
        'haven_login_subtitle'       => 'Entre para gerenciar a experiencia digital da Residencia JB.',
        'haven_login_bg_image'       => '',
        'haven_login_logo_image'     => '',
        'haven_show_gallery'         => '1',
        'haven_show_video'           => '1',
        'haven_show_location'        => '1',
        'haven_show_testimonials'    => '1',
        'haven_show_cta'             => '1',
        'haven_show_matterport'      => '1',
        'haven_matterport_url'       => 'https://my.matterport.com/show/?m=g6XUyG8xhtk',
        'haven_matterport_title'     => 'Tour Virtual 3D',
        'haven_matterport_sdk_key'   => '',
        'haven_matterport_autotour'  => '0',
        'haven_matterport_autotour_mode' => 'auto',
        'haven_matterport_autotour_delay' => '2',
        'haven_matterport_autotour_step_duration' => '7',
        'haven_matterport_autotour_transition_ms' => '2200',
        'haven_matterport_autotour_show_controls' => '1',
        'haven_matterport_subtitle'  => 'Explore cada comodo da residencia em uma experiencia imersiva 360°.',
        'haven_gallery_autoplay'         => '1',
        'haven_gallery_autoplay_speed'   => '4000',
        'haven_gallery_random'           => '1',
        'haven_details_gallery_autoplay'       => '1',
        'haven_details_gallery_autoplay_speed'  => '5000',
        'haven_details_gallery_random'          => '1',
        'haven_font_heading'     => 'Playfair Display',
        'haven_font_body'        => 'Inter',
        'haven_font_alt'         => 'DM Sans',
        'haven_logo_size_desktop' => '48',
        'haven_logo_size_tablet'  => '40',
        'haven_logo_size_mobile'  => '32',
        'haven_hero_title_size_desktop' => '88',
        'haven_hero_title_size_tablet'  => '64',
        'haven_hero_title_size_mobile'  => '44',
        'haven_hero_title_width'        => '750',
        'haven_hero_desc_width'         => '500',
        'haven_hero_desc_size_desktop'  => '18',
        'haven_hero_desc_size_mobile'   => '16',
        'haven_preloader_enabled'       => '1',
        'haven_preloader_bg_color'      => '#ffffff',
        'haven_preloader_accent_color'  => '#c8a45e',
        'haven_preloader_logo_size'     => '64',
        'haven_preloader_effect'        => 'slide',
        'haven_preloader_logo_animation'=> 'fade',
    );
}

function haven_get_cta_lead_form_defaults() {
    return array(
        array(
            'label'       => 'Voce tem carta de credito?',
            'placeholder' => 'Selecione uma opcao',
            'required'    => '1',
            'enabled'     => '1',
            'options'     => array(
                array( 'label' => 'Sim' ),
                array( 'label' => 'Nao' ),
            ),
        ),
        array(
            'label'       => 'Como sera a entrada?',
            'placeholder' => 'Selecione uma opcao',
            'required'    => '1',
            'enabled'     => '1',
            'options'     => array(
                array( 'label' => 'Com entrada' ),
                array( 'label' => 'Sem entrada' ),
            ),
        ),
        array(
            'label'       => 'Faixa de investimento',
            'placeholder' => 'Selecione uma faixa',
            'required'    => '0',
            'enabled'     => '1',
            'options'     => array(
                array( 'label' => 'Ate R$ 1,5 milhao' ),
                array( 'label' => 'Entre R$ 1,5 e R$ 2 milhoes' ),
                array( 'label' => 'Acima de R$ 2 milhoes' ),
            ),
        ),
        array(
            'label'       => 'Quando pretende comprar?',
            'placeholder' => 'Selecione um prazo',
            'required'    => '0',
            'enabled'     => '1',
            'options'     => array(
                array( 'label' => 'Imediatamente' ),
                array( 'label' => 'Nos proximos 3 meses' ),
                array( 'label' => 'Ainda estou pesquisando' ),
            ),
        ),
        array(
            'label'       => 'Melhor horario para contato',
            'placeholder' => 'Selecione um horario',
            'required'    => '0',
            'enabled'     => '1',
            'options'     => array(
                array( 'label' => 'Manha' ),
                array( 'label' => 'Tarde' ),
                array( 'label' => 'Noite' ),
            ),
        ),
    );
}

function haven_sanitize_toggle( $value ) {
    return $value === '1' ? '1' : '0';
}

function haven_sanitize_matterport_autotour_mode( $value ) {
    $allowed = array( 'auto', 'guided', 'sweeps' );
    $value   = sanitize_key( $value );

    return in_array( $value, $allowed, true ) ? $value : 'auto';
}

function haven_sanitize_basic_html( $value ) {
    return wp_kses(
        $value,
        array(
            'em'     => array(),
            'strong' => array(),
            'br'     => array(),
            'span'   => array( 'class' => array() ),
        )
    );
}

function haven_sanitize_rich_text( $value ) {
    return wp_kses_post( $value );
}

function haven_sanitize_video_format( $value ) {
    return 'vertical' === $value ? 'vertical' : 'horizontal';
}

function haven_sanitize_video_url( $value ) {
    $value = trim( (string) $value );

    if ( '' === $value ) {
        return '';
    }

    $value = esc_url_raw( $value );

    if ( '' === $value ) {
        return '';
    }

    $parts = wp_parse_url( $value );
    if ( ! is_array( $parts ) || empty( $parts['host'] ) ) {
        return $value;
    }

    $host = strtolower( $parts['host'] );

    if ( false !== strpos( $host, 'youtu.be' ) ) {
        $path = trim( $parts['path'] ?? '', '/' );
        if ( $path ) {
            return 'https://www.youtube.com/embed/' . rawurlencode( $path );
        }
    }

    if ( false !== strpos( $host, 'youtube.com' ) ) {
        $path = trim( $parts['path'] ?? '', '/' );

        if ( 0 === strpos( $path, 'embed/' ) ) {
            return $value;
        }

        if ( 0 === strpos( $path, 'shorts/' ) ) {
            $video_id = trim( substr( $path, 7 ), '/' );
            if ( $video_id ) {
                return 'https://www.youtube.com/embed/' . rawurlencode( $video_id );
            }
        }

        if ( ! empty( $parts['query'] ) ) {
            parse_str( $parts['query'], $query_args );
            if ( ! empty( $query_args['v'] ) ) {
                return 'https://www.youtube.com/embed/' . rawurlencode( (string) $query_args['v'] );
            }
        }
    }

    return $value;
}

function haven_sanitize_cta_lead_form_fields( $value ) {
    if ( ! is_array( $value ) ) {
        return haven_get_cta_lead_form_defaults();
    }

    $clean_fields = array();

    foreach ( $value as $field ) {
        if ( ! is_array( $field ) ) {
            continue;
        }

        $label       = sanitize_text_field( $field['label'] ?? '' );
        $placeholder = sanitize_text_field( $field['placeholder'] ?? '' );
        $enabled     = ! empty( $field['enabled'] ) && '1' === (string) $field['enabled'] ? '1' : '0';
        $required    = ! empty( $field['required'] ) && '1' === (string) $field['required'] ? '1' : '0';

        $options = array();
        if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
            foreach ( $field['options'] as $option ) {
                if ( ! is_array( $option ) ) {
                    continue;
                }

                $option_label = sanitize_text_field( $option['label'] ?? '' );
                if ( '' === $option_label ) {
                    continue;
                }

                $options[] = array( 'label' => $option_label );
            }
        }

        if ( '' === $label || empty( $options ) ) {
            continue;
        }

        $clean_fields[] = array(
            'label'       => $label,
            'placeholder' => $placeholder ?: 'Selecione uma opcao',
            'enabled'     => $enabled,
            'required'    => $required,
            'options'     => $options,
        );
    }

    return empty( $clean_fields ) ? haven_get_cta_lead_form_defaults() : array_values( $clean_fields );
}

function haven_get_cta_lead_form_fields() {
    $fields = get_option( 'haven_cta_form_fields', array() );

    if ( empty( $fields ) || ! is_array( $fields ) ) {
        return haven_get_cta_lead_form_defaults();
    }

    return haven_sanitize_cta_lead_form_fields( $fields );
}

function haven_sanitize_embed_iframe( $value ) {
    return wp_kses(
        $value,
        array(
            'iframe' => array(
                'src'             => array(),
                'width'           => array(),
                'height'          => array(),
                'style'           => array(),
                'allow'           => array(),
                'allowfullscreen' => array(),
                'loading'         => array(),
                'referrerpolicy'  => array(),
                'title'           => array(),
            ),
        )
    );
}

function haven_register_option_set( $group, $keys, $sanitize_callback ) {
    foreach ( $keys as $key ) {
        register_setting( $group, $key, array( 'sanitize_callback' => $sanitize_callback ) );
    }
}

function haven_register_ui_settings() {
    $plain_text = array(
        'haven_header_brand',
        'haven_header_cta_text',
        'haven_header_cta_link',
        'haven_hero_primary_text',
        'haven_hero_primary_link',
        'haven_hero_secondary_text',
        'haven_hero_secondary_link',
        'haven_about_label',
        'haven_about_title',
        'haven_about_button_text',
        'haven_about_button_link',
        'haven_gallery_label',
        'haven_gallery_title',
        'haven_video_title',
        'haven_location_label',
        'haven_location_title',
        'haven_location_region',
        'haven_testimonials_label',
        'haven_testimonials_title',
        'haven_testimonial_1_name',
        'haven_testimonial_1_role',
        'haven_testimonial_1_avatar',
        'haven_testimonial_2_name',
        'haven_testimonial_2_role',
        'haven_testimonial_2_avatar',
        'haven_testimonial_3_name',
        'haven_testimonial_3_role',
        'haven_testimonial_3_avatar',
        'haven_cta_whatsapp_text',
        'haven_cta_phone_text',
        'haven_footer_brand',
        'haven_footer_menu_title',
        'haven_footer_location_title',
        'haven_footer_contact_title',
        'haven_login_title',
        'haven_matterport_title',
    );
    haven_register_option_set( 'haven_ui_group', $plain_text, 'sanitize_text_field' );

    $textareas = array(
        'haven_gallery_subtitle',
        'haven_testimonial_1_quote',
        'haven_testimonial_2_quote',
        'haven_testimonial_3_quote',
        'haven_whatsapp_message',
        'haven_footer_copyright',
        'haven_login_subtitle',
    );
    haven_register_option_set( 'haven_ui_group', $textareas, 'sanitize_textarea_field' );

    $urls = array(
        'haven_footer_instagram',
        'haven_footer_facebook',
        'haven_footer_youtube',
        'haven_login_bg_image',
        'haven_login_logo_image',
        'haven_header_logo_image',
        'haven_matterport_url',
    );
    haven_register_option_set( 'haven_ui_group', $urls, 'esc_url_raw' );

    $html = array(
        'haven_video_subtitle',
        'haven_cta_title',
        'haven_cta_desc',
        'haven_matterport_subtitle',
    );
    haven_register_option_set( 'haven_ui_group', $html, 'haven_sanitize_rich_text' );

    register_setting( 'haven_ui_group', 'haven_location_map_embed', array( 'sanitize_callback' => 'haven_sanitize_embed_iframe' ) );

    $toggles = array(
        'haven_header_show_cta',
        'haven_show_gallery',
        'haven_show_video',
        'haven_show_location',
        'haven_show_testimonials',
        'haven_show_cta',
        'haven_show_matterport',
        'haven_gallery_autoplay',
        'haven_gallery_random',
        'haven_details_gallery_autoplay',
        'haven_details_gallery_random',
    );
    haven_register_option_set( 'haven_ui_group', $toggles, 'haven_sanitize_toggle' );

    $numbers = array(
        'haven_gallery_autoplay_speed',
        'haven_details_gallery_autoplay_speed',
        'haven_logo_size_desktop',
        'haven_logo_size_tablet',
        'haven_logo_size_mobile',
        'haven_hero_title_size_desktop',
        'haven_hero_title_size_tablet',
        'haven_hero_title_size_mobile',
        'haven_hero_title_width',
        'haven_hero_desc_width',
        'haven_hero_desc_size_desktop',
        'haven_hero_desc_size_mobile',
    );
    haven_register_option_set( 'haven_ui_group', $numbers, 'absint' );

    haven_register_option_set(
        'haven_header_group',
        array(
            'haven_header_brand',
            'haven_header_cta_text',
            'haven_header_cta_link',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_header_group', 'haven_header_logo_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_header_group', 'haven_header_show_cta', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_header_group', 'haven_logo_size_desktop', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_header_group', 'haven_logo_size_tablet', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_header_group', 'haven_logo_size_mobile', array( 'sanitize_callback' => 'absint' ) );

    haven_register_option_set(
        'haven_sections_group',
        array(
            'haven_hero_primary_text',
            'haven_hero_primary_link',
            'haven_hero_secondary_text',
            'haven_hero_secondary_link',
            'haven_about_label',
            'haven_about_title',
            'haven_about_button_text',
            'haven_about_button_link',
            'haven_gallery_label',
            'haven_gallery_title',
            'haven_video_title',
            'haven_location_label',
            'haven_location_title',
            'haven_location_region',
            'haven_cta_whatsapp_text',
            'haven_cta_phone_text',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_sections_group', 'haven_gallery_subtitle', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    register_setting( 'haven_sections_group', 'haven_video_subtitle', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    register_setting( 'haven_sections_group', 'haven_cta_title', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    register_setting( 'haven_sections_group', 'haven_cta_desc', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    register_setting( 'haven_sections_group', 'haven_location_map_embed', array( 'sanitize_callback' => 'haven_sanitize_embed_iframe' ) );
    register_setting( 'haven_sections_group', 'haven_show_gallery', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_show_video', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_show_matterport', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_show_location', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_show_testimonials', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_show_cta', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_sections_group', 'haven_hero_title_size_desktop', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_title_size_tablet', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_title_size_mobile', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_title_width', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_desc_width', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_desc_size_desktop', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_sections_group', 'haven_hero_desc_size_mobile', array( 'sanitize_callback' => 'absint' ) );

    haven_register_option_set(
        'haven_tours_video_group',
        array(
            'haven_video_title',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_tours_video_group', 'haven_video_subtitle', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );

    haven_register_option_set(
        'haven_testimonials_group',
        array(
            'haven_testimonials_label',
            'haven_testimonials_title',
            'haven_testimonial_1_name',
            'haven_testimonial_1_role',
            'haven_testimonial_1_avatar',
            'haven_testimonial_2_name',
            'haven_testimonial_2_role',
            'haven_testimonial_2_avatar',
            'haven_testimonial_3_name',
            'haven_testimonial_3_role',
            'haven_testimonial_3_avatar',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_testimonials_group', 'haven_testimonial_1_quote', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_testimonials_group', 'haven_testimonial_2_quote', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_testimonials_group', 'haven_testimonial_3_quote', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );

    haven_register_option_set(
        'haven_footer_group',
        array(
            'haven_footer_brand',
            'haven_footer_menu_title',
            'haven_footer_location_title',
            'haven_footer_contact_title',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_footer_group', 'haven_footer_copyright', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_footer_group', 'haven_whatsapp_message', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_footer_group', 'haven_footer_instagram', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_footer_group', 'haven_footer_facebook', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_footer_group', 'haven_footer_youtube', array( 'sanitize_callback' => 'esc_url_raw' ) );

    haven_register_option_set(
        'haven_cta_form_group',
        array(
            'haven_cta_form_title',
            'haven_cta_form_submit_text',
            'haven_cta_form_company_name',
            'haven_floating_cta_corner',
            'haven_floating_cta_badge_text',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_cta_form_group', 'haven_cta_form_desc', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_cta_form_group', 'haven_cta_form_message_intro', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_cta_form_group', 'haven_cta_form_avatar', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_cta_form_group', 'haven_cta_form_fields', array( 'sanitize_callback' => 'haven_sanitize_cta_lead_form_fields' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_enabled', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_show_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_pulse_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_message_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_badge_message_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_badge_section', array( 'sanitize_callback' => 'sanitize_key' ) );
    register_setting( 'haven_cta_form_group', 'haven_floating_cta_message_text', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );

    haven_register_option_set(
        'haven_login_group',
        array(
            'haven_login_title',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_login_group', 'haven_login_subtitle', array( 'sanitize_callback' => 'sanitize_textarea_field' ) );
    register_setting( 'haven_login_group', 'haven_login_bg_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_login_group', 'haven_login_logo_image', array( 'sanitize_callback' => 'esc_url_raw' ) );

    haven_register_option_set(
        'haven_matterport_group',
        array(
            'haven_matterport_title',
            'haven_matterport_sdk_key',
        ),
        'sanitize_text_field'
    );
    register_setting( 'haven_matterport_group', 'haven_matterport_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_subtitle', array( 'sanitize_callback' => 'haven_sanitize_rich_text' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_show_controls', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_mode', array( 'sanitize_callback' => 'haven_sanitize_matterport_autotour_mode' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_delay', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_step_duration', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_matterport_group', 'haven_matterport_autotour_transition_ms', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_menus_group', 'haven_visual_menus', array( 'sanitize_callback' => 'haven_sanitize_visual_menus' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_enabled', array( 'sanitize_callback' => 'haven_sanitize_toggle' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_bg_color', array( 'sanitize_callback' => 'sanitize_hex_color' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_accent_color', array( 'sanitize_callback' => 'sanitize_hex_color' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_logo_size', array( 'sanitize_callback' => 'absint' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_effect', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    register_setting( 'haven_preloader_group', 'haven_preloader_logo_animation', array( 'sanitize_callback' => 'sanitize_text_field' ) );
}
add_action( 'admin_init', 'haven_register_ui_settings' );
