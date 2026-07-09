<?php
/**
 * page.php — Template de páginas
 * O Elementor detecta e edita este arquivo automaticamente.
 */
get_header(); ?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>
