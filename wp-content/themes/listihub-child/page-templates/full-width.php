<?php
/* Template Name: MillyR - Full Width */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <?php if (has_excerpt()): ?>
            <p><?php echo get_the_excerpt(); ?></p>
        <?php endif; ?>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <?php while (have_posts()): the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</section>
<?php get_footer(); ?>
