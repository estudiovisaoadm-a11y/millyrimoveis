<?php
/**
 * index.php — Template padrão do tema
 * O Elementor assume o controle total do conteúdo quando está ativo.
 */
get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    else : ?>
        <div class="hv-container" style="padding:6rem 2rem;text-align:center;">
            <h1 style="font-family:var(--font-display);font-size:2.5rem;color:var(--hv-text);">Nenhum conteúdo encontrado</h1>
            <p style="color:var(--hv-text-light);margin-top:1rem;">Crie uma página e edite com o Elementor.</p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
