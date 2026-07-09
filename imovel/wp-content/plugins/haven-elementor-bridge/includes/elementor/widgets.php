<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ==========================================================
 * HERO SECTION WIDGET
 * ==========================================================
 */
class Haven_Hero_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'haven_hero'; }
    public function get_title() { return '🌟 Haven - Banner Hero'; }
    public function get_icon() { return 'eicon-slider-full-screen'; }
    public function get_categories() { return [ 'haven-widgets' ]; }

    protected function _register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Conteúdo do Hero', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('tagline', [
            'label' => 'Tagline / Localização', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Exclusivo · Jardim Botânico',
        ]);
        $this->add_control('title_normal', [
            'label' => 'Título Normal', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Uma Residência ',
        ]);
        $this->add_control('title_italic', [
            'label' => 'Título Destaque (Itálico)', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Única',
        ]);
        $this->add_control('title_suffix', [
            'label' => 'Título Final', 'type' => \Elementor\Controls_Manager::TEXT,
            'default' => ' em Harmonia',
        ]);
        $this->add_control('description', [
            'label' => 'Descrição Curta', 'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '730m² de puro requinte no endereço mais nobre de Brasília.',
        ]);

        // REPEATER PARA AS FOTOS DO SLIDER
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('slide_image', [
            'label' => 'Imagem do Slide', 'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ]);
        $this->add_control('slides', [
            'label' => 'Fotos do Slider de Fundo',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [ 'slide_image' => [ 'url' => get_template_directory_uri() . '/assets/images/hero-exterior.png' ] ],
                [ 'slide_image' => [ 'url' => get_template_directory_uri() . '/assets/images/facade-night.png' ] ]
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'];
        ?>
        <section class="hv-hero" id="home">
            <div class="hv-hero-slider">
                <?php foreach ( $slides as $index => $slide ) : $active = ($index === 0) ? 'active' : ''; ?>
                <div class="hv-hero-slide <?php echo $active; ?>">
                    <img src="<?php echo esc_url($slide['slide_image']['url']); ?>" alt="Slide <?php echo $index; ?>">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="hv-hero-overlay"></div>
            <div class="hv-hero-content">
                <div class="hv-hero-tag"><?php echo esc_html($settings['tagline']); ?></div>
                <h1 class="hv-hero-heading"><?php echo esc_html($settings['title_normal']); ?> <em><?php echo esc_html($settings['title_italic']); ?></em> <?php echo esc_html($settings['title_suffix']); ?></h1>
                <p class="hv-hero-desc"><?php echo esc_html($settings['description']); ?></p>
                <div class="hv-hero-btns">
                    <a href="#detalhes" class="hv-btn hv-btn-primary">Conhecer a Casa</a>
                    <a href="#tour" class="hv-btn hv-btn-white">Tour Virtual</a>
                </div>
            </div>
            <div class="hv-hero-indicators">
                <?php foreach ( $slides as $index => $slide ) : $active = ($index === 0) ? 'active' : ''; ?>
                <button class="hv-hero-dot <?php echo $active; ?>" aria-label="Slide <?php echo $index; ?>"></button>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
}

/**
 * ==========================================================
 * STATS SECTION WIDGET
 * ==========================================================
 */
class Haven_Stats_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'haven_stats'; }
    public function get_title() { return '📊 Haven - Números Animados'; }
    public function get_icon() { return 'eicon-counter'; }
    public function get_categories() { return [ 'haven-widgets' ]; }

    protected function _register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Números e Estatísticas', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('number', [ 'label' => 'Número Alvo', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 100 ]);
        $repeater->add_control('suffix', [ 'label' => 'Sufixo (ex: m²)', 'type' => \Elementor\Controls_Manager::TEXT ]);
        $repeater->add_control('title', [ 'label' => 'Descrição / Título', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Área' ]);
        
        $this->add_control('stats', [
            'label' => 'Estatísticas', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [ 'number' => 730, 'suffix' => 'm²', 'title' => 'Área Construída' ],
                [ 'number' => 5, 'suffix' => '', 'title' => 'Suítes' ],
                [ 'number' => 6, 'suffix' => '', 'title' => 'Vagas' ],
            ]
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="hv-stats">
            <div class="hv-container">
                <div class="hv-stats-grid">
                    <?php foreach ( $settings['stats'] as $index => $stat ) : ?>
                    <div class="hv-stat-item hv-reveal hv-reveal-delay-<?php echo $index; ?>">
                        <div class="hv-stat-number" data-target="<?php echo esc_attr($stat['number']); ?>" data-suffix="<?php echo esc_attr($stat['suffix']); ?>">0</div>
                        <div class="hv-stat-text"><?php echo esc_html($stat['title']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

/**
 * ==========================================================
 * CAROUSEL GALLERY WIDGET
 * ==========================================================
 */
class Haven_Carousel_Widget extends \Elementor\Widget_Base {
    public function get_name() { return 'haven_carousel'; }
    public function get_title() { return '🎠 Haven - Carrossel Galeria'; }
    public function get_icon() { return 'eicon-carousel'; }
    public function get_categories() { return [ 'haven-widgets' ]; }

    protected function _register_controls() {
        $this->start_controls_section('content_section', [
            'label' => 'Galeria', 'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('title', [ 'label' => 'Título', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Conheça Cada Ambiente' ]);
        $this->add_control('subtitle', [ 'label' => 'Subtítulo', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Explore os detalhes luxuosos' ]);
        
        $repeater = new \Elementor\Repeater();
        $repeater->add_control('image', [ 'label' => 'Foto', 'type' => \Elementor\Controls_Manager::MEDIA ]);
        $repeater->add_control('name', [ 'label' => 'Nome do Ambiente', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Suíte Master' ]);
        $repeater->add_control('badge', [ 'label' => 'Badge / Etiqueta', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Destaque' ]);
        $repeater->add_control('desc', [ 'label' => 'Descrição / Detalhe', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Acabamento premium' ]);
        $repeater->add_control('feat1', [ 'label' => 'Atributo 1', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📐 65m²' ]);
        $repeater->add_control('feat2', [ 'label' => 'Atributo 2', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🛁 Spa privativo' ]);
        $repeater->add_control('feat3', [ 'label' => 'Atributo 3', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '🌅 Vista única' ]);

        $this->add_control('items', [
            'label' => 'Fotos', 'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
        ]);
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="hv-carousel-section" id="galeria">
          <div class="hv-container">
            <div class="hv-carousel-header hv-reveal">
              <div>
                <div class="hv-label">Galeria de Ambientes</div>
                <h2 class="hv-section-title"><?php echo esc_html($settings['title']); ?></h2>
                <p class="hv-section-subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
              </div>
              <div class="hv-carousel-controls">
                <button class="hv-carousel-btn hv-carousel-prev" aria-label="Anterior">&#8592;</button>
                <button class="hv-carousel-btn hv-carousel-next" aria-label="Próximo">&#8594;</button>
              </div>
            </div>
            <div class="hv-carousel-track-wrapper">
              <div class="hv-carousel-track">
                <?php foreach ( $settings['items'] as $item ) : ?>
                <div class="hv-carousel-card">
                  <div class="hv-carousel-card-img">
                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['name']); ?>">
                    <?php if($item['badge']) : ?><span class="hv-carousel-card-badge"><?php echo esc_html($item['badge']); ?></span><?php endif; ?>
                  </div>
                  <div class="hv-carousel-card-body">
                    <h3 class="hv-carousel-card-title"><?php echo esc_html($item['name']); ?></h3>
                    <div class="hv-carousel-card-location"><?php echo esc_html($item['desc']); ?></div>
                    <div class="hv-carousel-card-features">
                      <?php if($item['feat1']): ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat1']); ?></span><?php endif; ?>
                      <?php if($item['feat2']): ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat2']); ?></span><?php endif; ?>
                      <?php if($item['feat3']): ?><span class="hv-carousel-card-feat"><?php echo esc_html($item['feat3']); ?></span><?php endif; ?>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </section>
        <?php
    }
}
