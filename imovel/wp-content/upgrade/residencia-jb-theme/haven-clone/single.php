<?php
/**
 * single.php — Template de post único
 */
get_header(); ?>

<main id="primary" class="site-main">
    <div class="hv-container" style="padding:6rem 2rem;">
        <?php
        while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 style="font-family:var(--font-display);font-size:2.5rem;color:var(--hv-text);margin-bottom:1.5rem;"><?php the_title(); ?></h1>
                <div style="color:var(--hv-text-light);line-height:1.8;">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
