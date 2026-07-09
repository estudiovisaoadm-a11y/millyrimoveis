<?php
/* Template Name: MillyR - Serviços */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Nossos <span class="text-accent">Serviços</span></h1>
        <p>Soluções completas em consultoria imobiliária de alto padrão.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">🏠</div>
                <h3>Compra e Venda</h3>
                <p>Assessoria completa na compra e venda de imóveis residenciais e comerciais de alto padrão.</p>
            </div>
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">🔑</div>
                <h3>Locação</h3>
                <p>Gestão completa de locação, desde a seleção de inquilinos até a administração do contrato.</p>
            </div>
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">📊</div>
                <h3>Avaliação</h3>
                <p>Avaliação técnica e mercadológica de imóveis com laudo detalhado e preciso.</p>
            </div>
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">📋</div>
                <h3>Consultoria</h3>
                <p>Consultoria personalizada para investidores e incorporadores no mercado de Brasília.</p>
            </div>
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">🏗️</div>
                <h3>Lançamentos</h3>
                <p>Pré-venda e comercialização de lançamentos imobiliários exclusivos.</p>
            </div>
            <div class="qualidade-card" style="text-align:left;">
                <div class="qualidade-icon">⚖️</div>
                <h3>Assessoria Jurídica</h3>
                <p>Suporte jurídico completo com especialistas em direito imobiliário.</p>
            </div>
        </div>
        <?php the_content(); ?>
    </div>
</section>
<?php get_footer(); ?>
