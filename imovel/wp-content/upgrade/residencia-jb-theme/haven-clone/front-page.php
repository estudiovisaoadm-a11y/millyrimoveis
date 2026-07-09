<?php
/**
 * front-page.php — Página Inicial Padrão
 * Exibe a Landing Page completa com os dados configurados no Painel Admin.
 */
get_header();

// Se a página foi construída com Elementor, deixa o Elementor assumir!
if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor( get_the_ID() ) ) {
    echo '<main id="primary" class="site-main">';
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    echo '</main>';
    get_footer();
    exit;
}

// Obtém os dados do painel admin
$hero_photos   = get_option('haven_hero_photos', array());
$gallery_photos = get_option('haven_gallery_photos', array());


// Defaults caso não existam no DB
if (empty($hero_photos)) {
    $hero_photos[] = HAVEN_URI . '/assets/images/hero-exterior.png';
    $hero_photos[] = HAVEN_URI . '/assets/images/facade-night.png';
}
if (empty($gallery_photos)) {
    $gallery_photos = array(
        array('url' => HAVEN_URI . '/assets/images/living-room.png', 'title' => 'Sala de Estar', 'badge' => 'Destaque', 'desc' => 'Conceito aberto', 'feat1' => '📐 85m²', 'feat2' => '🛋️ Design Europeu', 'feat3' => '🌅 Vista Panorâmica'),
        array('url' => HAVEN_URI . '/assets/images/kitchen.png', 'title' => 'Cozinha Gourmet', 'badge' => '', 'desc' => 'Equipamentos Premium', 'feat1' => '🍳 Ilha Central', 'feat2' => '🍷 Adega', 'feat3' => '❄️ Equip. Built-in'),
        array('url' => HAVEN_URI . '/assets/images/master-suite.png', 'title' => 'Suíte Master', 'badge' => 'Master', 'desc' => 'Conforto Absoluto', 'feat1' => '🛏️ Cama King', 'feat2' => '🛁 Banheira SPA', 'feat3' => '👗 Closet Integrado'),
        array('url' => HAVEN_URI . '/assets/images/pool-area.png', 'title' => 'Área Externa', 'badge' => 'Lazer', 'desc' => 'Integração Total', 'feat1' => '🏊 Piscina 25m', 'feat2' => '🔥 Fogo de Chão', 'feat3' => '🌳 Paisagismo')
    );
}

$video_bg = get_option('haven_video_bg', HAVEN_URI . '/assets/images/pool-area.png');
if (!$video_bg) $video_bg = HAVEN_URI . '/assets/images/pool-area.png';

$whatsapp = preg_replace('/[^0-9]/', '', haven_opt('haven_whatsapp'));
$whatsapp_link = "https://wa.me/{$whatsapp}?text=" . urlencode("Olá! Gostaria de agendar uma visita na " . haven_opt('haven_property_name'));
?>

<!-- ==================== HERO SECTION ==================== -->
<section class="hv-hero" id="home">
  <div class="hv-hero-slider">
    <?php foreach ($hero_photos as $index => $url) : ?>
      <div class="hv-hero-slide <?php echo $index === 0 ? 'active' : ''; ?>">
        <img src="<?php echo esc_url($url); ?>" alt="Hero Slide <?php echo $index; ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="hv-hero-overlay"></div>
  <div class="hv-hero-content">
    <div class="hv-hero-tag"><?php echo esc_html(haven_opt('haven_property_tagline')); ?></div>
    <h1 class="hv-hero-heading"><?php echo wp_kses_post(haven_opt('haven_hero_title')); ?></h1>
    <p class="hv-hero-desc"><?php echo esc_html(haven_opt('haven_hero_subtitle')); ?></p>
    <div class="hv-hero-btns">
      <a href="#detalhes" class="hv-btn hv-btn-primary">Detalhes do Imóvel</a>
      <a href="#tour" class="hv-btn hv-btn-white">Tour Virtual</a>
    </div>
  </div>
  <div class="hv-hero-indicators">
    <?php foreach ($hero_photos as $index => $url) : ?>
      <button class="hv-hero-dot <?php echo $index === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $index; ?>"></button>
    <?php endforeach; ?>
  </div>
  <div class="hv-hero-scroll">
    <span>Scroll</span>
    <div class="hv-hero-scroll-line"></div>
  </div>
</section>

<!-- ==================== STATS SECTION ==================== -->
<section class="hv-stats">
  <div class="hv-container">
    <div class="hv-stats-grid">
      <div class="hv-stat-item hv-reveal hv-reveal-delay-1">
        <div class="hv-stat-number" data-target="<?php echo esc_attr(haven_opt('haven_stat_area')); ?>" data-suffix="m²">0</div>
        <div class="hv-stat-text">Área Construída</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-2">
        <div class="hv-stat-number" data-target="<?php echo esc_attr(haven_opt('haven_stat_terreno')); ?>" data-suffix="m²">0</div>
        <div class="hv-stat-text">Área do Terreno</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-3">
        <div class="hv-stat-number" data-target="<?php echo esc_attr(haven_opt('haven_stat_suites')); ?>">0</div>
        <div class="hv-stat-text">Suítes de Luxo</div>
      </div>
      <div class="hv-stat-item hv-reveal hv-reveal-delay-4">
        <div class="hv-stat-number" data-target="<?php echo esc_attr(haven_opt('haven_stat_vagas')); ?>">0</div>
        <div class="hv-stat-text">Vagas de Garagem</div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== ABOUT SECTION ==================== -->
<section class="hv-details-section" id="sobre" style="padding-top:8rem;">
  <div class="hv-container">
    <div class="hv-details-grid" style="align-items:center;">
      <div class="hv-details-info hv-reveal">
        <div class="hv-label">Sobre a Casa</div>
        <h2 class="hv-section-title">Design Contemporâneo em Harmonia com o Cerrado</h2>
        <p class="hv-details-desc">
          <?php echo nl2br(esc_html(haven_opt('haven_property_description'))); ?>
        </p>
        <a href="#galeria" class="hv-btn hv-btn-primary" style="margin-top:1rem;">Ver Ambientes</a>
      </div>
      <div class="hv-details-gallery-main hv-reveal hv-reveal-delay-2">
        <img src="<?php echo esc_url($hero_photos[0]); ?>" alt="Sobre o Projeto" style="border-radius:20px;box-shadow:0 20px 50px rgba(0,0,0,0.1);">
      </div>
    </div>
  </div>
</section>

<!-- ==================== CAROUSEL SECTION ==================== -->
<section class="hv-carousel-section" id="galeria">
  <div class="hv-container">
    <div class="hv-carousel-header hv-reveal">
      <div>
        <div class="hv-label">Galeria de Ambientes</div>
        <h2 class="hv-section-title">Conheça Cada Detalhe</h2>
        <p class="hv-section-subtitle">Explore a exclusividade e conforto dos ambientes internos e externos.</p>
      </div>
      <div class="hv-carousel-controls">
        <button class="hv-carousel-btn hv-carousel-prev" aria-label="Anterior">&#8592;</button>
        <button class="hv-carousel-btn hv-carousel-next" aria-label="Próximo">&#8594;</button>
      </div>
    </div>
    <div class="hv-carousel-track-wrapper hv-reveal hv-reveal-delay-1">
      <div class="hv-carousel-track">
        <?php foreach ($gallery_photos as $index => $item) : ?>
        <div class="hv-carousel-card">
          <div class="hv-carousel-card-img">
            <img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['title'] ?? 'Ambiente'); ?>">
            <?php if (!empty($item['badge'])) : ?>
              <span class="hv-carousel-card-badge"><?php echo esc_html($item['badge']); ?></span>
            <?php endif; ?>
          </div>
          <div class="hv-carousel-card-body">
            <h3 class="hv-carousel-card-title"><?php echo esc_html($item['title'] ?? ''); ?></h3>
            <div class="hv-carousel-card-location"><?php echo esc_html($item['desc'] ?? ''); ?></div>
            <div class="hv-carousel-card-features">
              <?php if (!empty($item['feat1'])) : ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat1']); ?></span><?php endif; ?>
              <?php if (!empty($item['feat2'])) : ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat2']); ?></span><?php endif; ?>
              <?php if (!empty($item['feat3'])) : ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat3']); ?></span><?php endif; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ==================== VIDEO SECTION ==================== -->
<section class="hv-video-section" id="tour">
  <div class="hv-video-bg">
    <img src="<?php echo esc_url($video_bg); ?>" alt="Virtual Tour Background">
  </div>
  <div class="hv-video-overlay"></div>
  <div class="hv-video-content hv-reveal">
    <div class="hv-video-play" aria-label="Play Tour Virtual">
      <!-- Play icon SVG -->
      <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
    </div>
    <h2 class="hv-video-title">Tour Virtual Cinematográfico</h2>
    <div class="hv-video-subtitle">Caminhe por todos os cômodos e encante-se com o melhor do Jardim Botânico.</div>
  </div>
</section>

<!-- VIDEO MODAL -->
<div class="hv-modal">
  <button class="hv-modal-close" aria-label="Fechar">&times;</button>
  <div class="hv-modal-body">
    <iframe data-src="<?php echo esc_url(haven_opt('haven_video_url')); ?>" allow="autoplay; encrypted-media" allowfullscreen></iframe>
  </div>
</div>

<!-- ==================== PROPERTY DETAILS ==================== -->
<section class="hv-details-section" id="detalhes">
  <div class="hv-container">
    <div class="hv-details-grid">
      <div class="hv-details-gallery hv-reveal hv-reveal-delay-1">
        <?php if (!empty($gallery_photos)) : ?>
          <div class="hv-details-gallery-main"><img id="detail-main-img" src="<?php echo esc_url($gallery_photos[0]['url']); ?>" alt="Ficha Técnica"></div>
          <div class="hv-details-gallery-thumbs">
            <?php foreach (array_slice($gallery_photos, 0, 4) as $index => $item) : ?>
              <div class="hv-details-gallery-thumb <?php echo $index === 0 ? 'active' : ''; ?>"><img src="<?php echo esc_url($item['url']); ?>" alt="Minitura <?php echo $index; ?>"></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="hv-details-info hv-reveal hv-reveal-delay-2">
        <div class="hv-details-price"><?php echo esc_html(haven_opt('haven_property_price')); ?></div>
        <h2 class="hv-details-name"><?php echo esc_html(haven_opt('haven_property_name')); ?></h2>
        <div class="hv-details-location">📍 <?php echo esc_html(haven_opt('haven_property_address')); ?></div>
        
        <div class="hv-details-specs">
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">🛏️</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_suites')); ?></div>
                <div class="hv-details-spec-label">Suítes</div>
            </div>
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">🚿</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_banheiros')); ?></div>
                <div class="hv-details-spec-label">Banheiros</div>
            </div>
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">📐</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_area')); ?></div>
                <div class="hv-details-spec-label">m² Constr.</div>
            </div>
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">🚗</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_vagas')); ?></div>
                <div class="hv-details-spec-label">Vagas</div>
            </div>
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">📅</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_construcao')); ?></div>
                <div class="hv-details-spec-label">Construção</div>
            </div>
            <div class="hv-details-spec">
                <div class="hv-details-spec-icon">🏊</div>
                <div class="hv-details-spec-val"><?php echo esc_html(haven_opt('haven_stat_piscina')); ?></div>
                <div class="hv-details-spec-label">Piscina</div>
            </div>
        </div>

        <div class="hv-details-amenities">
          <?php 
          $amenities = explode(',', haven_opt('haven_amenities'));
          foreach ($amenities as $amenity) {
             if (trim($amenity) !== '') {
                 echo '<span class="hv-details-amenity">' . esc_html(trim($amenity)) . '</span>';
             }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== LOCATION & TESTIMONIALS (COMBINED FOR FLOW) ==================== -->
<section class="hv-testimonials" id="localizacao" style="background:#faf8f5;">
  <div class="hv-container">
    
    <!-- Location Section within Testimonials wrap to match previous design flow -->
    <div style="margin-bottom:6rem;">
        <div class="hv-label hv-reveal">Localização Privilegiada</div>
        <h2 class="hv-section-title hv-reveal">Jardim Botânico, Brasília</h2>
        <div style="border-radius:20px;overflow:hidden;margin-top:2rem;height:400px;box-shadow:0 15px 40px rgba(0,0,0,0.08);" class="hv-reveal">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15354.896753068694!2d-47.8173!3d-15.8679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a2debc777a4eb%3A0xe549df9c26f0f512!2sJardim%20Bot%C3%A2nico%2C%20Bras%C3%ADlia%20-%20DF!5e0!3m2!1spt-BR!2sbr!4v1700000000000!5m2!1spt-BR!2sbr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="hv-label hv-reveal">Depoimentos</div>
    <h2 class="hv-section-title hv-reveal">O que dizem nossos clientes</h2>
    
    <div class="hv-testimonials-grid">
      <div class="hv-testimonial-card hv-reveal hv-reveal-delay-1">
        <div class="hv-testimonial-stars">★★★★★</div>
        <p class="hv-testimonial-text">"As áreas integradas são perfeitas para receber nossos amigos. Encontramos nosso oásis particular em Brasília."</p>
        <div class="hv-testimonial-author">
          <div class="hv-testimonial-avatar">A</div>
          <div>
            <div class="hv-testimonial-name">Ana Carolina T.</div>
            <div class="hv-testimonial-role">Moradora · Lago Sul</div>
          </div>
        </div>
      </div>
      <div class="hv-testimonial-card hv-reveal hv-reveal-delay-2">
        <div class="hv-testimonial-stars">★★★★★</div>
        <p class="hv-testimonial-text">"O acabamento e os detalhes arquitetônicos superaram todas as expectativas. O nível de automação impressiona."</p>
        <div class="hv-testimonial-author">
          <div class="hv-testimonial-avatar">C</div>
          <div>
            <div class="hv-testimonial-name">Carlos Henrique M.</div>
            <div class="hv-testimonial-role">Investidor · Asa Sul</div>
          </div>
        </div>
      </div>
      <div class="hv-testimonial-card hv-reveal hv-reveal-delay-3">
        <div class="hv-testimonial-stars">★★★★★</div>
        <p class="hv-testimonial-text">"Estar tão perto da natureza do Cerrado com toda a segurança e infraestrutura que o condomínio oferece, é formidável."</p>
        <div class="hv-testimonial-author">
          <div class="hv-testimonial-avatar">F</div>
          <div>
            <div class="hv-testimonial-name">Fernanda Lima</div>
            <div class="hv-testimonial-role">Médica · Jardim Botânico</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ==================== CTA SECTION ==================== -->
<section class="hv-cta" id="contato">
  <div class="hv-cta-bg-pattern"></div>
  <div class="hv-cta-inner hv-reveal">
    <h2 class="hv-cta-title">Descubra o Seu <em>Novo Estilo</em> de Vida</h2>
    <p class="hv-cta-desc">Atendimento exclusivo com hora marcada. Venha conhecer a residência mais deslumbrante do Jardim Botânico.</p>
    <div class="hv-cta-btns">
      <a href="<?php echo esc_url($whatsapp_link); ?>" target="_blank" class="hv-btn hv-btn-primary">Falar no WhatsApp</a>
      <a href="tel:+<?php echo esc_attr($whatsapp); ?>" class="hv-btn hv-btn-white">Ligue <?php echo esc_html(haven_opt('haven_telefone')); ?></a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
