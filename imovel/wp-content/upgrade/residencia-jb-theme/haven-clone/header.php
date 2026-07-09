<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Residência de altíssimo padrão no Jardim Botânico de Brasília. 730m², 5 suítes, piscina 25m.">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Preloader -->
<div class="hv-preloader">
  <div class="hv-preloader-inner">
    <div class="hv-preloader-logo">Residência<span>JB</span></div>
    <div class="hv-preloader-bar"></div>
  </div>
</div>

<!-- ==================== NAVIGATION ==================== -->
<nav class="hv-nav">
  <div class="hv-nav-inner">
    <?php if ( has_custom_logo() ) : ?>
      <?php the_custom_logo(); ?>
    <?php else : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hv-nav-logo">Residência<span>JB</span></a>
    <?php endif; ?>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>
      <?php wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'hv-nav-links',
          'fallback_cb'    => false,
      )); ?>
    <?php else : ?>
      <ul class="hv-nav-links">
        <li><a href="#sobre">A Casa</a></li>
        <li><a href="#galeria">Galeria</a></li>
        <li><a href="#tour">Tour Virtual</a></li>
        <li><a href="#detalhes">Detalhes</a></li>
        <li><a href="#localizacao">Localização</a></li>
      </ul>
    <?php endif; ?>

    <a href="#contato" class="hv-nav-cta">Agendar Visita</a>
    <button class="hv-nav-toggle" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
