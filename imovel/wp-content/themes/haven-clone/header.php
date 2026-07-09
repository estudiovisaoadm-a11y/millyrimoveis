<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Residencia de alto padrao no Jardim Botanico de Brasilia.">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$haven_header_brand = haven_opt( 'haven_header_brand' );
$haven_header_logo  = haven_get_header_logo_image();
$haven_header_cta_text = haven_opt( 'haven_header_cta_text' );
$haven_header_cta_link = haven_opt( 'haven_header_cta_link' );
$haven_header_show_cta = haven_opt( 'haven_header_show_cta' ) === '1';
$haven_preloader_enabled = haven_opt( 'haven_preloader_enabled' ) === '1';
$haven_preloader_effect = haven_opt( 'haven_preloader_effect' );
$haven_preloader_logo_animation = haven_opt( 'haven_preloader_logo_animation' );
$haven_nav_classes = array( 'hv-nav' );

if ( is_front_page() ) {
    $haven_nav_classes[] = 'hv-nav-hero';
}

if ( function_exists( 'haven_normalize_matterport_inline_href' ) ) {
    $haven_header_cta_link = haven_normalize_matterport_inline_href( $haven_header_cta_link );
}
?>

<?php if ( $haven_preloader_enabled ) : ?>
<div class="hv-preloader">
  <div class="hv-preloader-inner hv-preloader-effect-<?php echo esc_attr( $haven_preloader_effect ); ?> hv-preloader-logo-anim-<?php echo esc_attr( $haven_preloader_logo_animation ); ?>">
    <div class="hv-preloader-logo">
      <?php if ( $haven_header_logo ) : ?>
        <img src="<?php echo esc_url( $haven_header_logo ); ?>" alt="<?php echo esc_attr( $haven_header_brand ); ?>" class="hv-preloader-logo-img">
      <?php else : ?>
        <?php echo esc_html( $haven_header_brand ); ?>
      <?php endif; ?>
    </div>
    <div class="hv-preloader-bar"></div>
  </div>
</div>
<script>
(function() {
  var hidePreloader = function() {
    var preloader = document.querySelector('.hv-preloader');
    if (!preloader || preloader.classList.contains('loaded')) {
      return;
    }
    preloader.classList.add('loaded');
    window.setTimeout(function() {
      if (preloader && preloader.parentNode) {
        preloader.parentNode.removeChild(preloader);
      }
    }, 900);
  };

  if (document.readyState === 'interactive' || document.readyState === 'complete') {
    window.setTimeout(hidePreloader, 150);
  } else {
    document.addEventListener('DOMContentLoaded', function() {
      window.setTimeout(hidePreloader, 150);
    }, { once: true });
  }

  window.addEventListener('load', function() {
    window.setTimeout(hidePreloader, 250);
  }, { once: true });

  window.setTimeout(hidePreloader, 3500);
})();
</script>
<?php endif; ?>

<nav class="<?php echo esc_attr( implode( ' ', $haven_nav_classes ) ); ?>">
  <div class="hv-nav-inner">
    <?php if ( $haven_header_logo ) : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hv-nav-logo hv-nav-logo-img"><img src="<?php echo esc_url( $haven_header_logo ); ?>" alt="<?php echo esc_attr( $haven_header_brand ); ?>" class="hv-header-logo-png"></a>
    <?php elseif ( has_custom_logo() ) : ?>
      <?php the_custom_logo(); ?>
    <?php else : ?>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hv-nav-logo"><?php echo esc_html( $haven_header_brand ); ?></a>
    <?php endif; ?>

    <?php if ( function_exists( 'haven_has_visual_menu_items' ) && haven_has_visual_menu_items( 'primary' ) ) : ?>
      <?php haven_render_visual_menu( 'primary', 'hv-nav-links' ); ?>
    <?php elseif ( has_nav_menu( 'primary' ) ) : ?>
      <?php wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'hv-nav-links',
          'fallback_cb'    => false,
      ) ); ?>
    <?php else : ?>
      <ul class="hv-nav-links">
        <li><a href="#sobre">A casa</a></li>
        <li><a href="#galeria">Galeria</a></li>
        <li><a href="#tour3d">Tour 3D</a></li>
        <li><a href="#detalhes">Detalhes</a></li>
        <li><a href="#localizacao">Localizacao</a></li>
        <li><a href="#contato">Contato</a></li>
      </ul>
    <?php endif; ?>

    <?php if ( $haven_header_show_cta ) : ?>
      <a href="<?php echo esc_url( $haven_header_cta_link ); ?>" class="hv-nav-cta"><?php echo esc_html( $haven_header_cta_text ); ?></a>
    <?php endif; ?>
    <button type="button" class="hv-nav-toggle" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
