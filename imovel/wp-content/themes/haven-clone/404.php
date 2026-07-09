<?php
/**
 * 404.php — Página não encontrada
 */
get_header(); ?>

<main id="primary" class="site-main">
    <div class="hv-container" style="padding:10rem 2rem;text-align:center;">
        <h1 style="font-family:var(--font-display);font-size:8rem;font-weight:700;color:var(--hv-gold);line-height:1;">404</h1>
        <h2 style="font-family:var(--font-display);font-size:2rem;color:var(--hv-text);margin:1rem 0;">Página não encontrada</h2>
        <p style="color:var(--hv-text-light);font-size:1.1rem;margin-bottom:2rem;">O conteúdo que você procura não está disponível.</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hv-btn hv-btn-primary">Voltar ao Início</a>
    </div>
</main>

<?php get_footer(); ?>
