<?php
/**
 * Template Name: Landing Page (Haven)
 */
get_header(); ?>

<!-- CÓDIGO HTML COMPLETO DA LANDING PAGE -->
<div class="haven-landing-wrap">
    <?php
    // Include the original landing page HTML here if Elementor is not actively overriding it
    // For now, we output the standard Elementor content area
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php get_footer(); ?>
