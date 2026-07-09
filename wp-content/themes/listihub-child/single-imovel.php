<?php get_header(); ?>

<?php while (have_posts()): the_post();
    $preco = get_post_meta(get_the_ID(), 'preco', true);
    $area = get_post_meta(get_the_ID(), 'area', true);
    $quartos = get_post_meta(get_the_ID(), 'quartos', true);
    $suites = get_post_meta(get_the_ID(), 'suites', true);
    $banheiros = get_post_meta(get_the_ID(), 'banheiros', true);
    $vagas = get_post_meta(get_the_ID(), 'vagas', true);
    $condominio = get_post_meta(get_the_ID(), 'condominio', true);
    $iptu = get_post_meta(get_the_ID(), 'iptu', true);
    $endereco = get_post_meta(get_the_ID(), 'endereco', true);
    $bairro = get_post_meta(get_the_ID(), 'bairro', true);
    $cep = get_post_meta(get_the_ID(), 'cep', true);
    $caracteristicas = get_post_meta(get_the_ID(), 'caracteristicas', true);
    $termos = wp_get_post_terms(get_the_ID(), 'tipo', ['fields' => 'names']);
    $finalidades = wp_get_post_terms(get_the_ID(), 'finalidade', ['fields' => 'names']);
    $regioes = wp_get_post_terms(get_the_ID(), 'regiao', ['fields' => 'names']);
    $finalidade_label = !empty($finalidades) ? $finalidades[0] : '';
?>
<section style="padding:140px 0 60px;background:var(--dark);">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;">
            <div>
                <?php if (has_post_thumbnail()): ?>
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>" style="width:100%;border-radius:var(--radius);">
                <?php endif; ?>
            </div>
            <div>
                <?php if ($finalidade_label): ?>
                    <span class="hero-tag"><?php echo esc_html(ucfirst($finalidade_label)); ?></span>
                <?php endif; ?>
                <h1 style="font-family:var(--font-heading);font-size:2.5rem;color:var(--white);margin:16px 0;"><?php the_title(); ?></h1>
                <?php if ($preco): ?>
                    <div style="font-family:var(--font-heading);font-size:2.2rem;color:var(--primary);font-weight:700;margin:16px 0;">R$ <?php echo number_format((float)$preco, 0, ',', '.'); ?></div>
                <?php endif; ?>
                <?php if ($bairro): ?>
                    <p style="color:var(--gray-300);font-size:1.05rem;"><?php echo esc_html($bairro); ?>, Brasília - DF</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:48px;">
            <div>
                <h2 style="font-family:var(--font-heading);margin-top:0;">Detalhes do Imóvel</h2>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;">
                    <?php if ($area): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.3rem;color:var(--primary);"><?php echo esc_html($area); ?></strong>m²</div><?php endif; ?>
                    <?php if ($quartos): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.3rem;color:var(--primary);"><?php echo esc_html($quartos); ?></strong>Quartos</div><?php endif; ?>
                    <?php if ($suites): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.3rem;color:var(--primary);"><?php echo esc_html($suites); ?></strong>Suítes</div><?php endif; ?>
                    <?php if ($vagas): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.3rem;color:var(--primary);"><?php echo esc_html($vagas); ?></strong>Vagas</div><?php endif; ?>
                    <?php if ($banheiros): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.3rem;color:var(--primary);"><?php echo esc_html($banheiros); ?></strong>Banheiros</div><?php endif; ?>
                    <?php if ($condominio): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.1rem;color:var(--primary);">R$ <?php echo number_format((float)$condominio, 0, ',', '.'); ?></strong>Condomínio</div><?php endif; ?>
                    <?php if ($iptu): ?><div class="qualidade-card" style="padding:20px;"><strong style="display:block;font-size:1.1rem;color:var(--primary);">R$ <?php echo number_format((float)$iptu, 0, ',', '.'); ?></strong>IPTU</div><?php endif; ?>
                </div>

                <div style="background:var(--off-white);padding:32px;border-radius:var(--radius);margin-bottom:32px;">
                    <h3 style="font-family:var(--font-heading);margin:0 0 16px;">Descrição</h3>
                    <?php the_content(); ?>
                </div>

                <?php if ($caracteristicas): ?>
                    <div style="background:var(--off-white);padding:32px;border-radius:var(--radius);">
                        <h3 style="font-family:var(--font-heading);margin:0 0 16px;">Características</h3>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                            <?php foreach (explode(',', $caracteristicas) as $carac): ?>
                                <div style="display:flex;align-items:center;gap:8px;padding:8px 0;">
                                    <span style="color:var(--primary);">✓</span>
                                    <span><?php echo esc_html(trim($carac)); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <div style="background:var(--off-white);padding:32px;border-radius:var(--radius);position:sticky;top:100px;">
                    <h3 style="font-family:var(--font-heading);margin:0 0 24px;">Tem interesse?</h3>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                        <input type="hidden" name="action" value="millyr_contact">
                        <input type="hidden" name="imovel" value="<?php the_title(); ?>">
                        <div class="form-group">
                            <input type="text" name="nome" placeholder="Seu nome" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Seu e-mail" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="telefone" placeholder="Seu telefone" required>
                        </div>
                        <div class="form-group">
                            <textarea name="mensagem" rows="4" placeholder="Quero saber mais sobre este imóvel...">Olá, tenho interesse no imóvel: <?php the_title(); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endwhile; ?>
<?php get_footer(); ?>
