<?php
/**
 * search.php — Template de busca
 */
get_header(); ?>

<main id="primary" class="site-main">
    <div class="hv-container" style="padding:6rem 2rem;">
        <h1 style="font-family:var(--font-display);font-size:2.5rem;color:var(--hv-text);margin-bottom:2rem;">
            Resultados para: "<?php echo get_search_query(); ?>"
        </h1>
        <?php if ( have_posts() ) :
            while ( have_posts() ) : the_post(); ?>
                <article style="margin-bottom:2rem;padding-bottom:2rem;border-bottom:1px solid var(--hv-sand);">
                    <h2 style="font-family:var(--font-display);font-size:1.6rem;"><a href="<?php the_permalink(); ?>" style="color:var(--hv-text);"><?php the_title(); ?></a></h2>
                    <div style="color:var(--hv-text-light);margin-top:0.5rem;"><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile;
        else : ?>
            <p style="color:var(--hv-text-light);">Nenhum resultado encontrado.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
