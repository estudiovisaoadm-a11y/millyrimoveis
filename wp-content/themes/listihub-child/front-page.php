<?php get_header(); ?>

<section class="hero">
    <div class="hero-bg">
        <?php
        $hero_image = get_theme_mod('millyr_hero_image');
        if ($hero_image): ?>
            <img src="<?php echo esc_url($hero_image); ?>" alt="MillyR Imóveis">
        <?php else: ?>
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1a1a 0%,#2a2a2a 100%);"></div>
        <?php endif; ?>
    </div>
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative;z-index:2;width:100%;">
        <div class="hero-content">
            <span class="hero-tag">Consultoria Imobiliária Premium</span>
            <h1 class="hero-title">O melhor lugar para <span>viver</span> em Brasília</h1>
            <p class="hero-desc">Há mais de 15 anos realizando sonhos. Especialistas em imóveis de alto padrão no Jardim Botânico, Lago Sul e Asa Sul.</p>
            <div class="hero-actions">
                <a href="<?php echo esc_url(home_url('/comprar')); ?>" class="btn btn-primary">Ver Imóveis</a>
                <a href="<?php echo esc_url(home_url('/quem-somos')); ?>" class="btn btn-outline">Conheça a MillyR</a>
            </div>
        </div>
    </div>
</section>

<div class="container" style="margin-top:-60px;position:relative;z-index:3;">
    <form class="hero-search" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="post_type" value="imovel">
        <div class="search-group">
            <label>Finalidade</label>
            <select name="finalidade">
                <option value="">Todos</option>
                <option value="venda">Venda</option>
                <option value="aluguel">Aluguel</option>
            </select>
        </div>
        <div class="search-group">
            <label>Tipo</label>
            <?php wp_dropdown_categories([
                'taxonomy'      => 'tipo',
                'name'          => 'tipo',
                'show_option_none' => 'Todos',
                'value_field'   => 'slug',
                'option_none_value' => '',
                'class'         => '',
            ]); ?>
        </div>
        <div class="search-group">
            <label>Região</label>
            <?php wp_dropdown_categories([
                'taxonomy'      => 'regiao',
                'name'          => 'regiao',
                'show_option_none' => 'Todas',
                'value_field'   => 'slug',
                'option_none_value' => '',
                'class'         => '',
            ]); ?>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>

<section class="section">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <h2 class="section-title">Imóveis em <span class="text-accent">Destaque</span></h2>
            <p class="section-subtitle">Selecionamos as melhores propriedades para você</p>
        </div>

        <div class="destaques-grid">
            <?php
            $destaques = new WP_Query([
                'post_type'      => 'imovel',
                'posts_per_page' => 6,
                'meta_key'       => 'destaque',
                'meta_value'     => 'sim',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);

            if ($destaques->have_posts()):
                while ($destaques->have_posts()): $destaques->the_post();
                    $preco = get_post_meta(get_the_ID(), 'preco', true);
                    $area = get_post_meta(get_the_ID(), 'area', true);
                    $quartos = get_post_meta(get_the_ID(), 'quartos', true);
                    $vagas = get_post_meta(get_the_ID(), 'vagas', true);
                    $bairro = get_post_meta(get_the_ID(), 'bairro', true);
                    $finalidade = wp_get_post_terms(get_the_ID(), 'finalidade', ['fields' => 'names']);
                    $finalidade_label = !empty($finalidade) ? $finalidade[0] : '';
                    $termos = wp_get_post_terms(get_the_ID(), 'tipo', ['fields' => 'names']);
                    $tipo_label = !empty($termos) ? $termos[0] : 'Imóvel';
                    ?>
                    <div class="property-card">
                        <div class="property-card-image">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large'); ?>
                            <?php else: ?>
                                <div style="width:100%;height:100%;background:var(--gray-200);display:flex;align-items:center;justify-content:center;color:var(--gray-400);">Sem imagem</div>
                            <?php endif; ?>
                            <?php if ($finalidade_label): ?>
                                <span class="property-card-badge"><?php echo esc_html(ucfirst($finalidade_label)); ?></span>
                            <?php endif; ?>
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
                                <?php if ($vagas): ?><span><?php echo esc_html($vagas); ?> vagas</span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata();
            else: ?>
                <p style="grid-column:1/-1;text-align:center;color:var(--gray-400);">Nenhum imóvel em destaque no momento.</p>
            <?php endif; ?>
        </div>

        <div class="text-center" style="margin-top:40px;">
            <a href="<?php echo esc_url(home_url('/comprar')); ?>" class="btn btn-primary">Ver Todos os Imóveis</a>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <h2 class="section-title">Regiões <span class="text-accent">Exclusivas</span></h2>
            <p class="section-subtitle">As regiões mais valorizadas de Brasília</p>
        </div>

        <div class="regioes-grid">
            <?php
            $regioes = get_terms(['taxonomy' => 'regiao', 'hide_empty' => false]);
            $regiao_images = [
                'jardim-botanico'      => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9',
                'lago-sul'             => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c',
                'asa-sul'              => 'https://images.unsplash.com/photo-1600573472550-8090b5e0745e',
                'park-way'             => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c',
            ];
            foreach ($regioes as $regiao):
                $count = $regiao->count;
                $slug = $regiao->slug;
                $image_url = isset($regiao_images[$slug]) ? $regiao_images[$slug] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c';
                ?>
                <a href="<?php echo esc_url(get_term_link($regiao)); ?>" class="regiao-card">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($regiao->name); ?>">
                    <div class="regiao-card-overlay"></div>
                    <div class="regiao-card-content">
                        <h3 class="regiao-card-name"><?php echo esc_html($regiao->name); ?></h3>
                        <span class="regiao-card-count"><?php echo esc_html($count); ?> imóveis</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="text-center" style="margin-bottom:48px;">
            <h2 class="section-title">Qualidade de <span class="text-accent">Vida</span></h2>
            <p class="section-subtitle">Por que escolher Brasília para viver?</p>
        </div>

        <div class="qualidade-grid">
            <div class="qualidade-card">
                <div class="qualidade-icon">🌳</div>
                <h3>Áreas Verdes</h3>
                <p>Mais de 30 m² de área verde por habitante, a maior do Brasil.</p>
            </div>
            <div class="qualidade-card">
                <div class="qualidade-icon">🏛️</div>
                <h3>Arquitetura</h3>
                <p>Patrimônio Cultural da Humanidade com arquitetura única.</p>
            </div>
            <div class="qualidade-card">
                <div class="qualidade-icon">🔒</div>
                <h3>Segurança</h3>
                <p>Uma das cidades mais seguras do país, especialmente nos bairros nobres.</p>
            </div>
            <div class="qualidade-card">
                <div class="qualidade-icon">📈</div>
                <h3>Valorização</h3>
                <p>Mercado imobiliário em constante valorização com ótimo retorno.</p>
            </div>
        </div>
    </div>
</section>

<section class="newsletter">
    <div class="container">
        <h2>Receba Novidades</h2>
        <p>Cadastre-se e receba os melhores imóveis diretamente no seu e-mail.</p>
        <form class="newsletter-form" method="post" action="#">
            <input type="email" name="email" placeholder="Seu melhor e-mail" required>
            <button type="submit" class="btn">Inscrever</button>
        </form>
    </div>
</section>

<?php get_footer(); ?>
