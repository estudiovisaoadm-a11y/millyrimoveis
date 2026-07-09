<?php
/* Template Name: MillyR - Revista */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Revista <span class="text-accent">MillyR</span></h1>
        <p>Conteúdo exclusivo sobre mercado imobiliário, tendências e lifestyle em Brasília.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $revista = new WP_Query([
            'post_type'      => 'post',
            'posts_per_page' => 9,
            'paged'          => $paged,
        ]);
        if ($revista->have_posts()): ?>
            <div class="posts-grid">
                <?php while ($revista->have_posts()): $revista->the_post(); ?>
                    <div class="post-card">
                        <div class="post-card-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                <div style="width:100%;height:100%;background:var(--gray-200);"></div>
                            <?php endif; ?>
                        </div>
                        <div class="post-card-body">
                            <div class="post-card-meta"><?php echo get_the_date('d/m/Y'); ?></div>
                            <h3 class="post-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <p class="post-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links([
                    'total'   => $revista->max_num_pages,
                    'current' => $paged,
                    'mid_size' => 2,
                ]); ?>
            </div>
        <?php else: ?>
            <p style="text-align:center;color:var(--gray-400);">Em breve novos artigos!</p>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
