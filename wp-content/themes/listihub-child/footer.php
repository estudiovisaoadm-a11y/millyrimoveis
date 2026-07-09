    </div>
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="site-logo-text">MillyR <span>Imóveis</span></div>
                    <p>Consultoria imobiliária de alto padrão em Brasília. Especialistas nos melhores bairros e regiões do Distrito Federal.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Instagram">IG</a>
                        <a href="#" aria-label="Facebook">FB</a>
                        <a href="#" aria-label="WhatsApp">WA</a>
                        <a href="#" aria-label="YouTube">YT</a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Navegação</h4>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ]); ?>
                </div>
                <div class="footer-col">
                    <h4>Imóveis</h4>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/comprar')); ?>">Comprar</a></li>
                        <li><a href="<?php echo esc_url(home_url('/alugar')); ?>">Alugar</a></li>
                        <li><a href="<?php echo esc_url(home_url('/lancamentos')); ?>">Lançamentos</a></li>
                        <li><a href="<?php echo esc_url(home_url('/condominios')); ?>">Condomínios</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contato</h4>
                    <ul>
                        <li><a href="tel:+5561999999999">(61) 99999-9999</a></li>
                        <li><a href="mailto:contato@millyrimoveis.com.br">contato@millyrimoveis.com.br</a></li>
                        <li><a href="<?php echo esc_url(home_url('/contato')); ?>">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> MillyR Imóveis. Todos os direitos reservados.</span>
                <span>Desenvolvido por <a href="#">MillyR</a></span>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
