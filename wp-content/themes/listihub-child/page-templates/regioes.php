<?php
/* Template Name: MillyR - Regiões */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Regiões <span class="text-accent">Exclusivas</span></h1>
        <p>Conheça as regiões mais valorizadas de Brasília.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <?php
        $regioes = get_terms(['taxonomy' => 'regiao', 'hide_empty' => false]);
        $regiao_images = [
            'jardim-botanico' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9',
            'lago-sul'        => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
            'asa-sul'         => 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e',
            'park-way'        => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
        ];
        foreach ($regioes as $regiao):
            $count = $regiao->count;
            $image_url = isset($regiao_images[$regiao->slug])
                ? $regiao_images[$regiao->slug]
                : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c';
            ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center;margin-bottom:48px;">
                <div style="border-radius:var(--radius);overflow:hidden;">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($regiao->name); ?>" style="width:100%;height:300px;object-fit:cover;">
                </div>
                <div>
                    <h2 style="margin-top:0;"><?php echo esc_html($regiao->name); ?></h2>
                    <p><?php echo esc_html($regiao->description ?: "Uma das regiões mais exclusivas de Brasília, perfeita para quem busca qualidade de vida e sofisticação."); ?></p>
                    <p><strong><?php echo esc_html($count); ?></strong> imóveis disponíveis</p>
                    <a href="<?php echo esc_url(home_url('/comprar/?regiao=' . $regiao->slug)); ?>" class="btn btn-primary">Ver Imóveis</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php get_footer(); ?>
