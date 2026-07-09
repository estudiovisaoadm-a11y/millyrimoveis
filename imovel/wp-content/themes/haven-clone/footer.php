<?php
$haven_footer_instagram = haven_opt( 'haven_footer_instagram' );
$haven_footer_facebook  = haven_opt( 'haven_footer_facebook' );
$haven_footer_youtube   = haven_opt( 'haven_footer_youtube' );
$haven_show_socials     = $haven_footer_instagram || $haven_footer_facebook || $haven_footer_youtube;
$haven_footer_logo      = haven_get_header_logo_image();
?>
<!-- ==================== FOOTER ==================== -->
<footer class="hv-footer">
  <div class="hv-container">
    <div class="hv-footer-grid">
      <div>
        <?php if ( $haven_footer_logo ) : ?>
          <div class="hv-footer-brand hv-footer-brand-logo"><img src="<?php echo esc_url( $haven_footer_logo ); ?>" alt="<?php echo esc_attr( haven_opt( 'haven_footer_brand' ) ); ?>" class="hv-footer-logo-img"></div>
        <?php else : ?>
          <div class="hv-footer-brand"><?php echo esc_html( haven_opt( 'haven_footer_brand' ) ); ?></div>
        <?php endif; ?>
        <p class="hv-footer-desc"><?php echo esc_html( haven_opt( 'haven_hero_subtitle' ) ); ?></p>
      </div>
      <div>
        <div class="hv-footer-title"><?php echo esc_html( haven_opt( 'haven_footer_menu_title' ) ); ?></div>
        <?php if ( function_exists( 'haven_has_visual_menu_items' ) && haven_has_visual_menu_items( 'footer' ) ) : ?>
          <?php haven_render_visual_menu( 'footer', 'hv-footer-links' ); ?>
        <?php elseif ( has_nav_menu( 'footer' ) ) : ?>
          <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'hv-footer-links' ) ); ?>
        <?php else : ?>
          <ul class="hv-footer-links">
            <li><a href="#sobre">Sobre</a></li>
            <li><a href="#galeria">Galeria</a></li>
            <li><a href="#tour">Tour Virtual</a></li>
            <li><a href="#detalhes">Ficha tecnica</a></li>
          </ul>
        <?php endif; ?>
      </div>
      <div>
        <div class="hv-footer-title"><?php echo esc_html( haven_opt( 'haven_footer_location_title' ) ); ?></div>
        <ul class="hv-footer-links">
          <li><a href="#localizacao"><?php echo esc_html( haven_opt( 'haven_location_title' ) ); ?></a></li>
          <li><a href="#"><?php echo esc_html( haven_opt( 'haven_location_region' ) ); ?></a></li>
          <li><a href="#"><?php echo esc_html( haven_opt( 'haven_property_address' ) ); ?></a></li>
        </ul>
      </div>
      <div>
        <div class="hv-footer-title"><?php echo esc_html( haven_opt( 'haven_footer_contact_title' ) ); ?></div>
        <ul class="hv-footer-links">
          <li><a href="mailto:<?php echo esc_attr( haven_opt( 'haven_email' ) ); ?>"><?php echo esc_html( haven_opt( 'haven_email' ) ); ?></a></li>
          <li><a href="tel:+<?php echo esc_attr( preg_replace( '/[^0-9]/', '', haven_opt( 'haven_telefone' ) ) ); ?>"><?php echo esc_html( haven_opt( 'haven_telefone' ) ); ?></a></li>
          <li><a href="#"><?php echo esc_html( haven_opt( 'haven_creci' ) ); ?></a></li>
        </ul>
      </div>
    </div>
    <div class="hv-footer-bottom">
      <div class="hv-footer-copy">&copy; <?php echo date( 'Y' ); ?> <?php echo esc_html( haven_opt( 'haven_footer_copyright' ) ); ?></div>
      <?php if ( $haven_show_socials ) : ?>
      <div class="hv-footer-socials">
        <?php if ( $haven_footer_instagram ) : ?><a href="<?php echo esc_url( $haven_footer_instagram ); ?>" class="hv-footer-social" aria-label="Instagram" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" ry="5"></rect><circle cx="12" cy="12" r="4"></circle><circle cx="17.5" cy="6.5" r="1"></circle></svg></a><?php endif; ?>
        <?php if ( $haven_footer_facebook ) : ?><a href="<?php echo esc_url( $haven_footer_facebook ); ?>" class="hv-footer-social" aria-label="Facebook" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v3H6v4h3v4h4v-4h3l1-4h-4V9c0-.7.3-1 1-1z" fill="currentColor" stroke="none"></path></svg></a><?php endif; ?>
        <?php if ( $haven_footer_youtube ) : ?><a href="<?php echo esc_url( $haven_footer_youtube ); ?>" class="hv-footer-social" aria-label="YouTube" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.9 2.9 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.9 2.9 0 0 0-2 2C2 9 2 12 2 12s0 3 .4 4.8a2.9 2.9 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.9 2.9 0 0 0 2-2C22 15 22 12 22 12s0-3-.4-4.8z" fill="currentColor" stroke="none" opacity="0.92"></path><path d="M10 15.5v-7l6 3.5-6 3.5z" fill="#0f0d0b" stroke="none"></path></svg></a><?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
