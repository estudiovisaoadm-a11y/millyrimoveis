<?php
/* Template Name: MillyR - Lançamentos */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Lançamentos <span class="text-gold">Exclusivos</span></h1>
        <p>Os mais novos empreendimentos de alto padrão em Brasília.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <?php
        $lancamentos = new WP_Query([
            'post_type'      => 'imovel',
            'posts_per_page' => -1,
            'tax_query'      => [[
                'taxonomy' => 'finalidade',
                'field'    => 'slug',
                'terms'    => 'lancamento',
            ]],
            'meta_key'       => 'destaque',
            'meta_value'     => 'sim',
        ]);
        if ($lancamentos->have_posts()): ?>
            <div class="properties-grid">
                <?php while ($lancamentos->have_posts()): $lancamentos->the_post();
                    $preco = get_post_meta(get_the_ID(), 'preco', true);
                    $area = get_post_meta(get_the_ID(), 'area', true);
                    $quartos = get_post_meta(get_the_ID(), 'quartos', true);
                    $bairro = get_post_meta(get_the_ID(), 'bairro', true);
                    ?>
                    <div class="property-card">
                        <div class="property-card-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                <div style="width:100%;height:100%;background:var(--gray-200);"></div>
                            <?php endif; ?>
                            <span class="property-card-badge">Lançamento</span>
                        </div>
                        <div class="property-card-body">
                            <?php if ($preco): ?>
                                <div class="property-card-price">R$ <?php echo number_format((float)$preco, 0, ',', '.'); ?></div>
                            <?php endif; ?>
                            <h3 class="property-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php if ($bairro): ?>
                                <div class="property-card-location"><?php echo esc_html($bairro); ?>, Brasília - DF</div>
                            <?php endif; ?>
                            <div class="property-card-features">
                                <?php if ($area): ?><span><?php echo esc_html($area); ?> m²</span><?php endif; ?>
                                <?php if ($quartos): ?><span><?php echo esc_html($quartos); ?> quartos</span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <p style="text-align:center;color:var(--gray-400);">Em breve novos lançamentos exclusivos!</p>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
