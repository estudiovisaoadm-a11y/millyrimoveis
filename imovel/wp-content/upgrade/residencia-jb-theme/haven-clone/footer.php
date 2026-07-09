<!-- ==================== FOOTER ==================== -->
<footer class="hv-footer">
  <div class="hv-container">
    <div class="hv-footer-grid">
      <div>
        <div class="hv-footer-brand">Residência<span>JB</span></div>
        <p class="hv-footer-desc"><?php echo esc_html( haven_opt( 'haven_property_description' ) ); ?></p>
      </div>
      <div>
        <div class="hv-footer-title">A Casa</div>
        <?php if ( has_nav_menu( 'footer' ) ) : ?>
          <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'hv-footer-links' ) ); ?>
        <?php else : ?>
          <ul class="hv-footer-links">
            <li><a href="#sobre">Sobre</a></li>
            <li><a href="#galeria">Galeria</a></li>
            <li><a href="#tour">Tour Virtual</a></li>
            <li><a href="#detalhes">Ficha Técnica</a></li>
          </ul>
        <?php endif; ?>
      </div>
      <div>
        <div class="hv-footer-title">Localização</div>
        <ul class="hv-footer-links">
          <li><a href="#localizacao">Jardim Botânico</a></li>
          <li><a href="#">Brasília – DF</a></li>
          <li><a href="#"><?php echo esc_html( haven_opt( 'haven_property_address' ) ); ?></a></li>
        </ul>
      </div>
      <div>
        <div class="hv-footer-title">Contato</div>
        <ul class="hv-footer-links">
          <li><a href="mailto:<?php echo esc_attr( haven_opt( 'haven_email' ) ); ?>"><?php echo esc_html( haven_opt( 'haven_email' ) ); ?></a></li>
          <li><a href="tel:+<?php echo esc_attr( preg_replace( '/[^0-9]/', '', haven_opt( 'haven_telefone' ) ) ); ?>"><?php echo esc_html( haven_opt( 'haven_telefone' ) ); ?></a></li>
          <li><a href="#"><?php echo esc_html( haven_opt( 'haven_creci' ) ); ?></a></li>
        </ul>
      </div>
    </div>
    <div class="hv-footer-bottom">
      <div class="hv-footer-copy">&copy; <?php echo date( 'Y' ); ?> Residência Jardim Botânico. Todos os direitos reservados.</div>
      <div class="hv-footer-socials">
        <a href="#" class="hv-footer-social" aria-label="Instagram">📷</a>
        <a href="#" class="hv-footer-social" aria-label="Facebook">📘</a>
        <a href="#" class="hv-footer-social" aria-label="YouTube">▶️</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
