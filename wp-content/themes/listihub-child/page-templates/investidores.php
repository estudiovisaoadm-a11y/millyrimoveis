<?php
/* Template Name: MillyR - Investidores */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Para <span class="text-gold">Investidores</span></h1>
        <p>Oportunidades de investimento imobiliário em Brasília com retorno garantido.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <div style="max-width:800px;margin:0 auto;">
            <h2>Por que investir em <span class="text-gold">Brasília</span>?</h2>
            <p>Brasília é a terceira cidade mais rica do Brasil e oferece um mercado imobiliário estável e em constante valorização. Com a maior renda per capita do país, a capital federal atrai investidores de todo o mundo.</p>

            <div class="about-stats">
                <div class="stat-card">
                    <div class="stat-number">3ª</div>
                    <p class="stat-label">Cidade mais rica do Brasil</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">+12%</div>
                    <p class="stat-label">Valorização anual média</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <p class="stat-label">Ocupação imóveis comerciais</p>
                </div>
                <div class="stat-card">
                    <div class="stat-number">+8%</div>
                    <p class="stat-label">Retorno locação anual</p>
                </div>
            </div>

            <h2>Nossos <span class="text-gold">Serviços</span> para Investidores</h2>
            <ul>
                <li>Análise de viabilidade de investimento</li>
                <li>Gestão de carteira imobiliária</li>
                <li>Assessoria jurídica completa</li>
                <li>Administração de aluguéis</li>
                <li>Relatórios mensais de desempenho</li>
                <li>Indicação de oportunidades exclusivas</li>
            </ul>

            <?php the_content(); ?>

            <div style="text-align:center;margin-top:48px;">
                <a href="<?php echo esc_url(home_url('/contato')); ?>" class="btn btn-primary">Fale com um Consultor</a>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
