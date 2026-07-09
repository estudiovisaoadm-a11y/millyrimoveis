<?php
/**
 * front-page.php
 * Landing page padrao com opcoes editaveis pelo painel do tema.
 */

get_header();

$is_elementor = false;
if ( class_exists( '\Elementor\Plugin' ) ) {
    $is_elementor = \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() );
}
if ( ! $is_elementor ) {
    $is_elementor = get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) === 'builder';
}

if ( $is_elementor ) {
    echo '<main id="primary" class="site-main">';
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    echo '</main>';
    get_footer();
    exit;
}

$hero_photos = get_option( 'haven_hero_photos', array() );
$gallery_photos = get_option( 'haven_gallery_photos', array() );
$details_gallery_photos = get_option( 'haven_details_gallery_photos', array() );

if ( ! is_array( $hero_photos ) ) {
    $hero_photos = array();
}

$hero_photos = array_values(
    array_filter(
        array_map(
            static function( $item ) {
                return is_string( $item ) ? esc_url_raw( $item ) : '';
            },
            $hero_photos
        )
    )
);

$gallery_photos = function_exists( 'haven_normalize_gallery_items' ) ? haven_normalize_gallery_items( $gallery_photos ) : array();
$details_gallery_photos = function_exists( 'haven_normalize_gallery_items' ) ? haven_normalize_gallery_items( $details_gallery_photos ) : array();

if ( empty( $hero_photos ) ) {
    $hero_photos[] = HAVEN_URI . '/assets/images/hero-exterior.png';
    $hero_photos[] = HAVEN_URI . '/assets/images/facade-night.png';
}

if ( empty( $gallery_photos ) ) {
    $gallery_photos = array(
        array(
            'url'   => HAVEN_URI . '/assets/images/living-room.png',
            'title' => 'Sala de Estar',
            'badge' => 'Destaque',
            'desc'  => 'Conceito aberto',
            'feat1' => '85m2',
            'feat2' => 'Design europeu',
            'feat3' => 'Vista panoramica',
        ),
        array(
            'url'   => HAVEN_URI . '/assets/images/kitchen.png',
            'title' => 'Cozinha Gourmet',
            'badge' => '',
            'desc'  => 'Equipamentos premium',
            'feat1' => 'Ilha central',
            'feat2' => 'Adega',
            'feat3' => 'Built-in',
        ),
        array(
            'url'   => HAVEN_URI . '/assets/images/master-suite.png',
            'title' => 'Suite Master',
            'badge' => 'Master',
            'desc'  => 'Conforto absoluto',
            'feat1' => 'Cama king',
            'feat2' => 'Banheira SPA',
            'feat3' => 'Closet integrado',
        ),
        array(
            'url'   => HAVEN_URI . '/assets/images/pool-area.png',
            'title' => 'Area Externa',
            'badge' => 'Lazer',
            'desc'  => 'Integracao total',
            'feat1' => 'Piscina 25m',
            'feat2' => 'Fogo de chao',
            'feat3' => 'Paisagismo',
        ),
    );
}

if ( empty( $details_gallery_photos ) ) {
    $details_gallery_photos = array_slice( $gallery_photos, 0, 4 );
}

// Randomize gallery order if setting enabled
if ( haven_opt( 'haven_gallery_random' ) === '1' && count( $gallery_photos ) > 1 ) {
    shuffle( $gallery_photos );
}

$video_bg = get_option( 'haven_video_bg', HAVEN_URI . '/assets/images/pool-area.png' );
if ( ! $video_bg ) {
    $video_bg = HAVEN_URI . '/assets/images/pool-area.png';
}
$video_format = haven_opt( 'haven_video_format' );
$video_autoplay = haven_opt( 'haven_video_autoplay' ) === '1';
$video_repeat = haven_opt( 'haven_video_repeat' ) === '1';
$video_hide_controls = haven_opt( 'haven_video_hide_controls' ) === '1';
$video_embed_url = haven_opt( 'haven_video_url' );

if ( $video_embed_url ) {
    $video_query = array(
        'autoplay'       => $video_autoplay ? '1' : '0',
        'controls'       => $video_hide_controls ? '0' : '1',
        'rel'            => '0',
        'modestbranding' => '1',
        'playsinline'    => '1',
    );

    $video_parts = wp_parse_url( $video_embed_url );
    $video_path = $video_parts['path'] ?? '';

    if ( $video_repeat ) {
        $video_query['loop'] = '1';

        if ( preg_match( '#/embed/([^/?]+)#', $video_path, $matches ) ) {
            $video_query['playlist'] = $matches[1];
        }
    }

    $video_embed_url = add_query_arg( $video_query, $video_embed_url );
}

$whatsapp = preg_replace( '/[^0-9]/', '', haven_opt( 'haven_whatsapp' ) );
$whatsapp_message = str_replace( '{imovel}', haven_opt( 'haven_property_name' ), haven_opt( 'haven_whatsapp_message' ) );
$whatsapp_link = 'https://wa.me/' . $whatsapp . '?text=' . urlencode( $whatsapp_message );
$cta_form_title = haven_opt( 'haven_cta_form_title' );
$cta_form_desc = haven_opt( 'haven_cta_form_desc' );
$cta_form_submit_text = haven_opt( 'haven_cta_form_submit_text' );
$cta_form_company_name = haven_opt( 'haven_cta_form_company_name' );
$cta_form_avatar = haven_opt( 'haven_cta_form_avatar' );
$cta_form_message_intro = str_replace( '{imovel}', haven_opt( 'haven_property_name' ), haven_opt( 'haven_cta_form_message_intro' ) );
$cta_form_fields = function_exists( 'haven_get_cta_lead_form_fields' ) ? haven_get_cta_lead_form_fields() : array();
$floating_cta_enabled = haven_opt( 'haven_floating_cta_enabled' ) === '1';
$floating_cta_corner = haven_opt( 'haven_floating_cta_corner' );
$floating_cta_show_delay = absint( haven_opt( 'haven_floating_cta_show_delay' ) );
$floating_cta_pulse_delay = absint( haven_opt( 'haven_floating_cta_pulse_delay' ) );
$floating_cta_message_delay = absint( haven_opt( 'haven_floating_cta_message_delay' ) );
$floating_cta_badge_message_delay = absint( haven_opt( 'haven_floating_cta_badge_message_delay' ) );
$floating_cta_badge_section = haven_opt( 'haven_floating_cta_badge_section' );
$floating_cta_badge_text = haven_opt( 'haven_floating_cta_badge_text' );
$floating_cta_message_text = haven_opt( 'haven_floating_cta_message_text' );

$show_gallery = haven_opt( 'haven_show_gallery' ) === '1';
$show_video = haven_opt( 'haven_show_video' ) === '1';
$show_location = haven_opt( 'haven_show_location' ) === '1';
$show_testimonials = haven_opt( 'haven_show_testimonials' ) === '1';
$show_cta = haven_opt( 'haven_show_cta' ) === '1';
$show_matterport = haven_opt( 'haven_show_matterport' ) === '1';
$matterport_url = haven_opt( 'haven_matterport_url' );
$matterport_title = haven_opt( 'haven_matterport_title' );
$matterport_subtitle = haven_opt( 'haven_matterport_subtitle' );
$matterport_sdk_key = trim( haven_opt( 'haven_matterport_sdk_key' ) );
$matterport_autotour = haven_opt( 'haven_matterport_autotour' ) === '1';
$matterport_autotour_mode = haven_opt( 'haven_matterport_autotour_mode' );
$matterport_autotour_delay = absint( haven_opt( 'haven_matterport_autotour_delay' ) );
$matterport_autotour_step_duration = max( 4, absint( haven_opt( 'haven_matterport_autotour_step_duration' ) ) );
$matterport_autotour_transition_ms = max( 500, absint( haven_opt( 'haven_matterport_autotour_transition_ms' ) ) );
$matterport_autotour_show_controls = haven_opt( 'haven_matterport_autotour_show_controls' ) === '1';
$matterport_embed_url = function_exists( 'haven_prepare_matterport_embed_url' )
    ? haven_prepare_matterport_embed_url( $matterport_url, $matterport_sdk_key, $matterport_autotour )
    : $matterport_url;
$matterport_sdk_bootstrap = function_exists( 'haven_get_matterport_sdk_bootstrap_url' )
    ? haven_get_matterport_sdk_bootstrap_url( $matterport_sdk_key )
    : '';

$hero_primary_text = haven_opt( 'haven_hero_primary_text' );
$hero_primary_link = haven_opt( 'haven_hero_primary_link' );

// Auto-correct old '#tour' link to '#tour3d' if standard video is disabled but matterport is active
if ( $hero_primary_link === '#tour' && ! $show_video && $show_matterport ) {
    $hero_primary_link = '#tour3d';
}

if ( function_exists( 'haven_normalize_matterport_inline_href' ) ) {
    $hero_primary_link = haven_normalize_matterport_inline_href( $hero_primary_link );
}

$hero_secondary_text = haven_opt( 'haven_hero_secondary_text' );
$hero_secondary_link = haven_opt( 'haven_hero_secondary_link' );

if ( function_exists( 'haven_normalize_matterport_inline_href' ) ) {
    $hero_secondary_link = haven_normalize_matterport_inline_href( $hero_secondary_link );
}
$about_label = haven_opt( 'haven_about_label' );
$about_title = haven_opt( 'haven_about_title' );
$about_button_text = haven_opt( 'haven_about_button_text' );
$about_button_link = haven_opt( 'haven_about_button_link' );
$gallery_label = haven_opt( 'haven_gallery_label' );
$gallery_title = haven_opt( 'haven_gallery_title' );
$gallery_subtitle = haven_opt( 'haven_gallery_subtitle' );
$video_title = haven_opt( 'haven_video_title' );
$video_subtitle = haven_opt( 'haven_video_subtitle' );
$location_label = haven_opt( 'haven_location_label' );
$location_title = haven_opt( 'haven_location_title' );
$location_map = haven_sanitize_embed_iframe( haven_opt( 'haven_location_map_embed' ) );
$testimonials_label = haven_opt( 'haven_testimonials_label' );
$testimonials_title = haven_opt( 'haven_testimonials_title' );
$cta_title = haven_opt( 'haven_cta_title' );
$cta_desc = haven_opt( 'haven_cta_desc' );
$cta_whatsapp_text = haven_opt( 'haven_cta_whatsapp_text' );
$cta_phone_text = haven_opt( 'haven_cta_phone_text' );

$testimonials = array();
for ( $index = 1; $index <= 3; $index++ ) {
    $quote = haven_opt( 'haven_testimonial_' . $index . '_quote' );
    $name = haven_opt( 'haven_testimonial_' . $index . '_name' );
    $role = haven_opt( 'haven_testimonial_' . $index . '_role' );
    $avatar = haven_opt( 'haven_testimonial_' . $index . '_avatar' );

    if ( ! $avatar && $name ) {
        $avatar = strtoupper( substr( $name, 0, 1 ) );
    }

    if ( $quote || $name || $role ) {
        $testimonials[] = array(
            'quote'  => $quote,
            'name'   => $name,
            'role'   => $role,
            'avatar' => $avatar,
        );
    }
}

$has_location_map = ! empty( trim( $location_map ) ) && stripos( $location_map, '<iframe' ) !== false;
$has_location_content = $show_location && $has_location_map;
$has_testimonials_content = $show_testimonials && ! empty( $testimonials );
?>

<section class="hv-hero" id="home">
  <div class="hv-hero-slider">
    <?php foreach ( $hero_photos as $index => $url ) : ?>
      <div class="hv-hero-slide <?php echo $index === 0 ? 'active' : ''; ?>">
        <img src="<?php echo esc_url( $url ); ?>" alt="Hero Slide <?php echo esc_attr( $index + 1 ); ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="hv-hero-overlay"></div>
  <div class="hv-hero-content">
    <div class="hv-hero-tag"><?php echo esc_html( haven_opt( 'haven_property_tagline' ) ); ?></div>
    <h1 class="hv-hero-heading"><?php echo wp_kses_post( haven_opt( 'haven_hero_title' ) ); ?></h1>
    <p class="hv-hero-desc"><?php echo esc_html( haven_opt( 'haven_hero_subtitle' ) ); ?></p>
    <div class="hv-hero-btns">
      <a href="<?php echo esc_url( $hero_primary_link ); ?>" class="hv-btn hv-btn-primary"><?php echo esc_html( $hero_primary_text ); ?></a>
      <a href="<?php echo esc_url( $hero_secondary_link ); ?>" class="hv-btn hv-btn-white"><?php echo esc_html( $hero_secondary_text ); ?></a>
    </div>
  </div>
  <div class="hv-hero-indicators">
    <?php foreach ( $hero_photos as $index => $url ) : ?>
      <button class="hv-hero-dot <?php echo $index === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo esc_attr( $index + 1 ); ?>"></button>
    <?php endforeach; ?>
  </div>
  <a href="#sobre" class="hv-hero-scroll">
    <span>Scroll</span>
    <div class="hv-hero-scroll-line"></div>
  </a>
</section>

<section class="hv-stats">
  <div class="hv-container">
    <div class="hv-stats-grid">
      <div class="hv-stat-item hv-reveal hv-reveal-delay-1">
        <div class="hv-stat-number" data-target="<?php echo esc_attr( haven_opt( 'haven_stat_area' ) ); ?>" data-suffix="m2">0</div>
        <div class="hv-stat-text">Area construida</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-2">
        <div class="hv-stat-number" data-target="<?php echo esc_attr( haven_opt( 'haven_stat_terreno' ) ); ?>" data-suffix="m2">0</div>
        <div class="hv-stat-text">Area do terreno</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-3">
        <div class="hv-stat-number" data-target="<?php echo esc_attr( haven_opt( 'haven_stat_suites' ) ); ?>">0</div>
        <div class="hv-stat-text">Quartos</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-4">
        <div class="hv-stat-number" data-target="<?php echo esc_attr( haven_opt( 'haven_stat_vagas' ) ); ?>">0</div>
        <div class="hv-stat-text">Vagas</div>
      </div>
    </div>
  </div>
</section>

<section class="hv-details-section" id="sobre" style="padding-top:8rem;">
  <div class="hv-container">
    <div class="hv-details-grid" style="align-items:center;">
      <div class="hv-details-info hv-reveal">
        <div class="hv-label"><?php echo esc_html( $about_label ); ?></div>
        <h2 class="hv-section-title"><?php echo esc_html( $about_title ); ?></h2>
        <div class="hv-details-desc">
          <?php echo wpautop( wp_kses_post( haven_opt( 'haven_property_description' ) ) ); ?>
        </div>
        <a href="<?php echo esc_url( $about_button_link ); ?>" class="hv-btn hv-btn-primary" style="margin-top:1rem;"><?php echo esc_html( $about_button_text ); ?></a>
      </div>
      <div class="hv-details-gallery-main hv-reveal hv-reveal-delay-2">
        <img src="<?php echo esc_url( $hero_photos[0] ); ?>" alt="Sobre o projeto" style="border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.1);">
      </div>
    </div>
  </div>
</section>

<?php
$section_order = haven_get_section_order();
foreach ( $section_order as $section_key ) :
    switch ( $section_key ) :

        case 'galeria':
            if ( $show_gallery ) : ?>
<section class="hv-carousel-section" id="galeria">
  <div class="hv-container">
    <div class="hv-carousel-header hv-reveal">
      <div>
        <div class="hv-label"><?php echo esc_html( $gallery_label ); ?></div>
        <h2 class="hv-section-title"><?php echo esc_html( $gallery_title ); ?></h2>
        <p class="hv-section-subtitle"><?php echo esc_html( $gallery_subtitle ); ?></p>
      </div>
      <div class="hv-carousel-controls">
        <button class="hv-carousel-btn hv-carousel-prev" aria-label="Anterior">&#8592;</button>
        <button class="hv-carousel-btn hv-carousel-next" aria-label="Proximo">&#8594;</button>
      </div>
    </div>
    <div class="hv-carousel-track-wrapper hv-reveal hv-reveal-delay-1">
      <div class="hv-carousel-track" data-autoplay="<?php echo esc_attr( haven_opt( 'haven_gallery_autoplay' ) ); ?>" data-speed="<?php echo esc_attr( haven_opt( 'haven_gallery_autoplay_speed' ) ); ?>">
        <?php foreach ( $gallery_photos as $item ) : ?>
        <div class="hv-carousel-card">
          <div class="hv-carousel-card-img">
            <img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ?? 'Ambiente' ); ?>">
            <?php if ( ! empty( $item['badge'] ) ) : ?>
              <span class="hv-carousel-card-badge"><?php echo esc_html( $item['badge'] ); ?></span>
            <?php endif; ?>
          </div>
          <div class="hv-carousel-card-body">
            <h3 class="hv-carousel-card-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
            <div class="hv-carousel-card-location"><?php echo esc_html( $item['desc'] ?? '' ); ?></div>
            <div class="hv-carousel-card-features">
              <?php if ( ! empty( $item['feat1'] ) ) : ?><span class="hv-carousel-card-feat"><?php echo esc_html( $item['feat1'] ); ?></span><?php endif; ?>
              <?php if ( ! empty( $item['feat2'] ) ) : ?><span class="hv-carousel-card-feat"><?php echo esc_html( $item['feat2'] ); ?></span><?php endif; ?>
              <?php if ( ! empty( $item['feat3'] ) ) : ?><span class="hv-carousel-card-feat"><?php echo esc_html( $item['feat3'] ); ?></span><?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
            <?php endif;
            break;

        case 'video':
            if ( $show_video ) : ?>
<section class="hv-video-section" id="tour">
  <div class="hv-video-bg">
    <img src="<?php echo esc_url( $video_bg ); ?>" alt="Virtual tour background">
  </div>
  <div class="hv-video-overlay"></div>
  <div class="hv-video-content hv-reveal">
    <div class="hv-video-play" aria-label="Play tour virtual">
      <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
    </div>
    <h2 class="hv-video-title"><?php echo esc_html( $video_title ); ?></h2>
    <div class="hv-video-subtitle"><?php echo wp_kses_post( wpautop( $video_subtitle ) ); ?></div>
  </div>
</section>

<div class="hv-modal <?php echo 'vertical' === $video_format ? 'is-vertical' : 'is-horizontal'; ?>" data-video-format="<?php echo esc_attr( $video_format ); ?>">
  <button class="hv-modal-close" aria-label="Fechar">&times;</button>
  <div class="hv-modal-body">
    <iframe data-src="<?php echo esc_url( $video_embed_url ); ?>" allow="autoplay; encrypted-media; picture-in-picture; fullscreen" allowfullscreen playsinline></iframe>
  </div>
</div>
            <?php endif;
            break;

        case 'matterport':
            if ( $show_matterport && $matterport_url ) : ?>
<section class="hv-matterport-section" id="tour3d">
  <div class="hv-matterport-frame">
    <div
      class="hv-matterport-player"
      data-sdk-key="<?php echo esc_attr( $matterport_sdk_key ); ?>"
      data-sdk-bootstrap="<?php echo esc_url( $matterport_sdk_bootstrap ); ?>"
      data-autotour="<?php echo $matterport_autotour ? '1' : '0'; ?>"
      data-autotour-mode="<?php echo esc_attr( $matterport_autotour_mode ); ?>"
      data-autotour-delay="<?php echo esc_attr( $matterport_autotour_delay ); ?>"
      data-autotour-step-duration="<?php echo esc_attr( $matterport_autotour_step_duration ); ?>"
      data-autotour-transition-ms="<?php echo esc_attr( $matterport_autotour_transition_ms ); ?>"
      data-model-id="<?php echo esc_attr( function_exists( 'haven_get_matterport_model_id_from_url' ) ? haven_get_matterport_model_id_from_url( $matterport_url ) : '' ); ?>"
      data-show-controls="<?php echo $matterport_autotour_show_controls ? '1' : '0'; ?>">
      <iframe src="<?php echo esc_url( $matterport_embed_url ); ?>" width="100%" height="100%" style="border:0;" allow="fullscreen; vr" allowfullscreen loading="lazy" title="Tour Virtual 3D"></iframe>
      <?php if ( $matterport_sdk_key && ( $matterport_autotour || $matterport_autotour_show_controls ) ) : ?>
      <div class="hv-matterport-controls" aria-label="Controles do tour 3D">
        <div class="hv-matterport-status" aria-live="polite">Autotour pronto</div>
        <div class="hv-matterport-buttons">
          <button type="button" class="hv-matterport-control-btn is-primary" data-action="toggle" aria-label="Play">
            <span class="hv-matterport-control-icon" aria-hidden="true">&#9654;</span>
            <span class="hv-matterport-control-text">Play</span>
          </button>
          <button type="button" class="hv-matterport-control-btn is-secondary" data-action="restart" aria-label="Reiniciar">
            <span class="hv-matterport-control-icon" aria-hidden="true">&#8635;</span>
            <span class="hv-matterport-control-text">Replay</span>
          </button>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="hv-matterport-topbar hv-reveal">
    <div class="hv-label">Tour imersivo</div>
    <h2 class="hv-matterport-title"><?php echo esc_html( $matterport_title ); ?></h2>
    <div class="hv-matterport-subtitle"><?php echo wp_kses_post( wpautop( $matterport_subtitle ) ); ?></div>
  </div>
</section>
            <?php endif;
            break;

        case 'detalhes': ?>
<section class="hv-details-section" id="detalhes">
  <div class="hv-container">
    <div class="hv-details-grid">
      <div class="hv-details-gallery hv-reveal hv-reveal-delay-1">
        <?php
        $detail_gallery_photos = $details_gallery_photos;
        if ( haven_opt( 'haven_details_gallery_random' ) === '1' && count( $detail_gallery_photos ) > 1 ) {
            shuffle( $detail_gallery_photos );
        }
        ?>
        <?php if ( ! empty( $detail_gallery_photos ) ) : ?>
          <div class="hv-details-gallery-main"><img id="detail-main-img" src="<?php echo esc_url( $detail_gallery_photos[0]['url'] ); ?>" alt="Ficha tecnica"></div>
          <div class="hv-details-gallery-thumbs" data-autoplay="<?php echo esc_attr( haven_opt( 'haven_details_gallery_autoplay' ) ); ?>" data-speed="<?php echo esc_attr( haven_opt( 'haven_details_gallery_autoplay_speed' ) ); ?>">
            <?php foreach ( array_slice( $detail_gallery_photos, 0, 4 ) as $index => $item ) : ?>
              <div class="hv-details-gallery-thumb <?php echo $index === 0 ? 'active' : ''; ?>"><img src="<?php echo esc_url( $item['url'] ); ?>" alt="Miniatura <?php echo esc_attr( $index + 1 ); ?>"></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="hv-details-info hv-reveal hv-reveal-delay-2">
        <div class="hv-details-price"><?php echo esc_html( haven_opt( 'haven_property_price' ) ); ?></div>
        <h2 class="hv-details-name"><?php echo esc_html( haven_opt( 'haven_property_name' ) ); ?></h2>
        <div class="hv-details-location"><?php echo esc_html( haven_opt( 'haven_property_address' ) ); ?></div>

        <div class="hv-details-specs">
          <div class="hv-details-spec" title="Area Construida">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M4 4v16h16M4 8h4M4 12h4M4 16h4M8 20v-4m4 4v-4m4 4v-4"/></svg>
            </div>
            <div class="hv-details-spec-val"><?php echo esc_html( haven_opt( 'haven_stat_area' ) ); ?></div>
            <div class="hv-details-spec-label">m² constr.</div>
          </div>
          <div class="hv-details-spec" title="Area do Terreno">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M12 22v-8m0-12l-7 8h4l-5 6h16l-5-6h4l-7-8M5 22h14"/></svg>
            </div>
            <div class="hv-details-spec-val"><?php echo esc_html( haven_opt( 'haven_stat_terreno' ) ); ?></div>
            <div class="hv-details-spec-label">m² lote</div>
          </div>
          <div class="hv-details-spec" title="Quartos / Suites">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M3 7v11m0-4h18m0 4v-8a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2z"/><circle cx="7" cy="10" r="1.5"/></svg>
            </div>
            <div class="hv-details-spec-val"><?php echo esc_html( haven_opt( 'haven_stat_suites' ) ); ?></div>
            <div class="hv-details-spec-label">Quartos</div>
          </div>
          <div class="hv-details-spec" title="Banheiros">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M12 22a5 5 0 0 0 5-5c0-4.5-5-11-5-11s-5 6.5-5 11a5 5 0 0 0 5 5z"/></svg>
            </div>
            <div class="hv-details-spec-val"><?php echo esc_html( haven_opt( 'haven_stat_banheiros' ) ); ?></div>
            <div class="hv-details-spec-label">Banheiros</div>
          </div>
          <div class="hv-details-spec" title="Vagas">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3m13 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0zM8 16a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/></svg>
            </div>
            <div class="hv-details-spec-val"><?php echo esc_html( haven_opt( 'haven_stat_vagas' ) ); ?></div>
            <div class="hv-details-spec-label">Vagas</div>
          </div>
          <div class="hv-details-spec" title="Piscina">
            <div class="hv-details-spec-icon" style="color:var(--hv-gold); margin-bottom:8px;">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="hv-icon-premium" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" style="width:34px;height:34px;"><path d="M22 12c-2.66 0-3.33-2-6-2s-3.33 2-6 2-3.33-2-6-2-3.33 2-6 2M22 18c-2.66 0-3.33-2-6-2s-3.33 2-6 2-3.33-2-6-2-3.33 2-6 2"/></svg>
            </div>
            <div class="hv-details-spec-val" style="font-size: clamp(1rem, 2vw, 1.3rem); line-height:36px;"><?php echo esc_html( haven_opt( 'haven_stat_piscina' ) ); ?></div>
            <div class="hv-details-spec-label">Piscina</div>
          </div>
        </div>

        <div class="hv-details-amenities">
          <?php
          $amenities = explode( ',', haven_opt( 'haven_amenities' ) );
          foreach ( $amenities as $amenity ) {
              if ( trim( $amenity ) !== '' ) {
                  echo '<span class="hv-details-amenity">' . esc_html( trim( $amenity ) ) . '</span>';
              }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
            <?php break;

        case 'localizacao':
            if ( $has_location_content ) : ?>
<section class="hv-testimonials" id="localizacao" style="background:#faf8f5;">
  <div class="hv-container">
    <div style="margin-bottom:6rem;">
      <div class="hv-label hv-reveal"><?php echo esc_html( $location_label ); ?></div>
      <h2 class="hv-section-title hv-reveal"><?php echo esc_html( $location_title ); ?></h2>
      <div style="border-radius:20px;overflow:hidden;margin-top:2rem;height:400px;box-shadow:0 15px 40px rgba(0,0,0,0.08);" class="hv-reveal">
        <?php echo $location_map; ?>
      </div>
    </div>
  </div>
</section>
            <?php endif;
            break;

        case 'depoimentos':
            if ( $has_testimonials_content ) : ?>
<section class="hv-testimonials" id="depoimentos" style="background:#faf8f5;">
  <div class="hv-container">
    <div class="hv-label hv-reveal"><?php echo esc_html( $testimonials_label ); ?></div>
    <h2 class="hv-section-title hv-reveal"><?php echo esc_html( $testimonials_title ); ?></h2>

    <div class="hv-testimonials-grid">
      <?php foreach ( $testimonials as $index => $testimonial ) : ?>
      <div class="hv-testimonial-card hv-reveal hv-reveal-delay-<?php echo esc_attr( min( $index + 1, 3 ) ); ?>">
        <div class="hv-testimonial-stars" aria-label="5 estrelas">
          <span class="hv-testimonial-star" aria-hidden="true">&#11088;</span>
          <span class="hv-testimonial-star" aria-hidden="true">&#11088;</span>
          <span class="hv-testimonial-star" aria-hidden="true">&#11088;</span>
          <span class="hv-testimonial-star" aria-hidden="true">&#11088;</span>
          <span class="hv-testimonial-star" aria-hidden="true">&#11088;</span>
        </div>
        <p class="hv-testimonial-text">"<?php echo esc_html( $testimonial['quote'] ); ?>"</p>
        <div class="hv-testimonial-author">
          <div class="hv-testimonial-avatar"><?php echo esc_html( $testimonial['avatar'] ); ?></div>
          <div>
            <div class="hv-testimonial-name"><?php echo esc_html( $testimonial['name'] ); ?></div>
            <div class="hv-testimonial-role"><?php echo esc_html( $testimonial['role'] ); ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
            <?php endif;
            break;

        case 'cta':
            if ( $show_cta ) : ?>
<section class="hv-cta" id="contato">
  <div class="hv-cta-bg-pattern"></div>
  <div class="hv-cta-inner hv-reveal">
    <h2 class="hv-cta-title"><?php echo wp_kses_post( $cta_title ); ?></h2>
  <div class="hv-cta-desc"><?php echo wp_kses_post( wpautop( $cta_desc ) ); ?></div>
    <div class="hv-cta-btns">
      <a href="<?php echo esc_url( $whatsapp_link ); ?>" target="_blank" class="hv-btn hv-btn-primary hv-lead-open"><?php echo esc_html( $cta_whatsapp_text ); ?></a>
      <a href="tel:+<?php echo esc_attr( $whatsapp ); ?>" class="hv-btn hv-btn-white"><?php echo esc_html( $cta_phone_text ); ?> <?php echo esc_html( haven_opt( 'haven_telefone' ) ); ?></a>
    </div>
  </div>
</section>
<?php
$lead_chat_questions = array();

foreach ( $cta_form_fields as $field ) {
    if ( empty( $field['enabled'] ) || '1' !== (string) $field['enabled'] ) {
        continue;
    }

    $question_label = trim( wp_strip_all_tags( $field['label'] ?? '' ) );
    $question_placeholder = trim( wp_strip_all_tags( $field['placeholder'] ?? 'Selecione uma opcao' ) );
    $question_options = array();

    if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
        foreach ( $field['options'] as $option ) {
            $option_label = trim( wp_strip_all_tags( $option['label'] ?? '' ) );

            if ( '' === $option_label ) {
                continue;
            }

            $question_options[] = array(
                'label' => $option_label,
            );
        }
    }

    if ( '' === $question_label || empty( $question_options ) ) {
        continue;
    }

    $lead_chat_questions[] = array(
        'label'       => $question_label,
        'placeholder' => $question_placeholder,
        'required'    => ! empty( $field['required'] ) && '1' === (string) $field['required'],
        'options'     => $question_options,
    );
}
?>
<div class="hv-lead-modal" aria-hidden="true">
  <div class="hv-lead-modal-dialog">
    <button type="button" class="hv-lead-modal-close" aria-label="Fechar">&times;</button>
    <div
      class="hv-lead-chat"
      data-phone="<?php echo esc_attr( $whatsapp ); ?>"
      data-message-intro="<?php echo esc_attr( $cta_form_message_intro ); ?>"
      data-title="<?php echo esc_attr( $cta_form_title ); ?>"
      data-description="<?php echo esc_attr( $cta_form_desc ); ?>"
      data-submit-label="<?php echo esc_attr( $cta_form_submit_text ); ?>"
      data-company-name="<?php echo esc_attr( $cta_form_company_name ); ?>"
    >
      <div class="hv-lead-chat-shell">
        <div class="hv-lead-chat-head">
          <div class="hv-lead-chat-head-main">
            <div class="hv-lead-chat-avatar" aria-hidden="true">
              <?php if ( $cta_form_avatar ) : ?>
                <img src="<?php echo esc_url( $cta_form_avatar ); ?>" alt="<?php echo esc_attr( $cta_form_company_name ?: 'Atendimento no WhatsApp' ); ?>">
              <?php else : ?>
                <svg viewBox="0 0 32 32" focusable="false" aria-hidden="true"><path d="M19.11 17.29c-.27-.14-1.58-.78-1.83-.87-.24-.09-.42-.14-.6.14-.18.27-.69.87-.84 1.04-.16.18-.31.2-.58.07-.27-.14-1.15-.42-2.18-1.34-.81-.72-1.35-1.61-1.51-1.88-.16-.27-.02-.42.12-.56.12-.12.27-.31.4-.47.14-.16.18-.27.27-.45.09-.18.04-.34-.02-.47-.07-.14-.6-1.45-.82-1.98-.22-.53-.44-.45-.6-.46h-.51c-.18 0-.47.07-.71.34-.24.27-.93.91-.93 2.21s.95 2.55 1.09 2.73c.13.18 1.86 2.84 4.51 3.98.63.27 1.13.43 1.52.56.64.2 1.22.17 1.68.1.51-.08 1.58-.65 1.8-1.28.22-.63.22-1.17.15-1.28-.07-.11-.24-.18-.51-.31z" fill="currentColor"></path><path d="M16.02 4.8c-6.13 0-11.09 4.96-11.09 11.08 0 1.95.51 3.86 1.47 5.53L4.8 27.2l5.95-1.56a11.02 11.02 0 0 0 5.27 1.34h.01c6.12 0 11.08-4.96 11.08-11.09 0-2.97-1.16-5.76-3.26-7.86a11.01 11.01 0 0 0-7.83-3.23zm0 20.31h-.01a9.2 9.2 0 0 1-4.69-1.28l-.34-.2-3.53.93.94-3.44-.22-.36a9.2 9.2 0 0 1-1.41-4.89c0-5.07 4.13-9.2 9.21-9.2 2.45 0 4.75.95 6.49 2.69a9.11 9.11 0 0 1 2.7 6.51c0 5.08-4.13 9.21-9.2 9.21z" fill="currentColor"></path></svg>
              <?php endif; ?>
            </div>
            <div class="hv-lead-chat-meta">
              <div class="hv-lead-chat-title-row">
                <strong><?php echo esc_html( $cta_form_company_name ?: 'Atendimento no WhatsApp' ); ?></strong>
                <span class="hv-lead-chat-verified" aria-label="Conta verificada">
                  <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path fill="currentColor" d="M12 2.2l2.06 1.56 2.56-.18 1.42 2.14 2.39.91-.2 2.56 1.55 2.05-1.55 2.05.2 2.56-2.39.91-1.42 2.14-2.56-.18L12 20.8l-2.06-1.56-2.56.18-1.42-2.14-2.39-.91.2-2.56L2.22 12l1.55-2.05-.2-2.56 2.39-.91 1.42-2.14 2.56.18L12 2.2z"></path><path fill="#fff" d="M10.52 15.68L6.9 12.05l1.14-1.13 2.48 2.47 5.46-5.45 1.13 1.13-6.59 6.61z"></path></svg>
                </span>
              </div>
              <span>online agora</span>
            </div>
          </div>
          <div class="hv-lead-chat-actions" aria-hidden="true">
            <span class="hv-lead-chat-action-dot"></span>
            <span class="hv-lead-chat-action-dot"></span>
            <span class="hv-lead-chat-action-dot"></span>
          </div>
        </div>
        <div class="hv-lead-chat-thread" aria-live="polite" aria-label="Conversa de atendimento"></div>
        <div class="hv-lead-chat-composer">
          <div class="hv-lead-chat-progress">Preparando atendimento</div>
          <div class="hv-lead-chat-input" hidden>
            <input type="text" class="hv-lead-name-input" placeholder="Digite seu nome" maxlength="80" autocomplete="name">
            <button type="button" class="hv-lead-name-submit" aria-label="Enviar nome">
              <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path fill="currentColor" d="M3.4 20.4l17.45-7.48c.81-.35.81-1.49 0-1.84L3.4 3.6c-.66-.28-1.35.3-1.19.99l1.3 5.59c.06.27.29.46.56.49l8.9 1.3-8.9 1.3a.65.65 0 0 0-.56.49l-1.3 5.59c-.16.69.53 1.27 1.19.99z"></path></svg>
            </button>
          </div>
          <div class="hv-lead-chat-choices"></div>
          <button type="button" class="hv-btn hv-btn-primary hv-lead-send" hidden><?php echo esc_html( $cta_form_submit_text ); ?></button>
        </div>
      </div>
      <script type="application/json" class="hv-lead-chat-data"><?php echo wp_json_encode( $lead_chat_questions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
    </div>
  </div>
</div>
<?php if ( $floating_cta_enabled ) : ?>
<div
  class="hv-floating-cta hv-floating-cta-<?php echo esc_attr( $floating_cta_corner ); ?>"
  data-show-delay="<?php echo esc_attr( $floating_cta_show_delay ); ?>"
  data-pulse-delay="<?php echo esc_attr( $floating_cta_pulse_delay ); ?>"
  data-message-delay="<?php echo esc_attr( $floating_cta_message_delay ); ?>"
  data-badge-message-delay="<?php echo esc_attr( $floating_cta_badge_message_delay ); ?>"
  data-badge-section="<?php echo esc_attr( $floating_cta_badge_section ); ?>"
>
  <button type="button" class="hv-floating-cta-button hv-lead-open" aria-label="<?php echo esc_attr( $cta_whatsapp_text ); ?>">
    <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M19.11 17.29c-.27-.14-1.58-.78-1.83-.87-.24-.09-.42-.14-.6.14-.18.27-.69.87-.84 1.04-.16.18-.31.2-.58.07-.27-.14-1.15-.42-2.18-1.34-.81-.72-1.35-1.61-1.51-1.88-.16-.27-.02-.42.12-.56.12-.12.27-.31.4-.47.14-.16.18-.27.27-.45.09-.18.04-.34-.02-.47-.07-.14-.6-1.45-.82-1.98-.22-.53-.44-.45-.6-.46h-.51c-.18 0-.47.07-.71.34-.24.27-.93.91-.93 2.21s.95 2.55 1.09 2.73c.13.18 1.86 2.84 4.51 3.98.63.27 1.13.43 1.52.56.64.2 1.22.17 1.68.1.51-.08 1.58-.65 1.8-1.28.22-.63.22-1.17.15-1.28-.07-.11-.24-.18-.51-.31z" fill="currentColor"></path><path d="M16.02 4.8c-6.13 0-11.09 4.96-11.09 11.08 0 1.95.51 3.86 1.47 5.53L4.8 27.2l5.95-1.56a11.02 11.02 0 0 0 5.27 1.34h.01c6.12 0 11.08-4.96 11.08-11.09 0-2.97-1.16-5.76-3.26-7.86a11.01 11.01 0 0 0-7.83-3.23zm0 20.31h-.01a9.2 9.2 0 0 1-4.69-1.28l-.34-.2-3.53.93.94-3.44-.22-.36a9.2 9.2 0 0 1-1.41-4.89c0-5.07 4.13-9.2 9.21-9.2 2.45 0 4.75.95 6.49 2.69a9.11 9.11 0 0 1 2.7 6.51c0 5.08-4.13 9.21-9.2 9.21z" fill="currentColor"></path></svg>
  </button>
  <span class="hv-floating-cta-badge" aria-label="Nova mensagem"><?php echo esc_html( $floating_cta_badge_text ); ?></span>
  <div class="hv-floating-cta-message"><?php echo esc_html( $floating_cta_message_text ); ?></div>
</div>
<?php endif; ?>
            <?php endif;
            break;
    endswitch;
endforeach;
?>

<?php get_footer(); ?>
