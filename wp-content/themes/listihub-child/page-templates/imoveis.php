<?php
/* Template Name: MillyR - Lista de Imóveis */
get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$finalidade = isset($_GET['finalidade']) ? sanitize_text_field($_GET['finalidade']) : '';
$tipo = isset($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : '';
$regiao = isset($_GET['regiao']) ? sanitize_text_field($_GET['regiao']) : '';
$ordem = isset($_GET['ordem']) ? sanitize_text_field($_GET['ordem']) : 'date_desc';

$meta_query = [];
if ($finalidade) {
    $meta_query[] = [
        'key'     => 'finalidade',
        'value'   => $finalidade,
        'compare' => '=',
    ];
}

$tax_query = ['relation' => 'AND'];
if ($tipo) $tax_query[] = ['taxonomy' => 'tipo', 'field' => 'slug', 'terms' => $tipo];
if ($regiao) $tax_query[] = ['taxonomy' => 'regiao', 'field' => 'slug', 'terms' => $regiao];

$orderby = 'date';
$order = 'DESC';
switch ($ordem) {
    case 'price_asc': $orderby = 'meta_value_num'; $meta_query['preco_clause'] = ['key' => 'preco', 'type' => 'NUMERIC']; $order = 'ASC'; break;
    case 'price_desc': $orderby = 'meta_value_num'; $meta_query['preco_clause'] = ['key' => 'preco', 'type' => 'NUMERIC']; $order = 'DESC'; break;
    case 'date_asc': $order = 'ASC'; break;
    case 'date_desc': $order = 'DESC'; break;
}

$args = [
    'post_type'      => 'imovel',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'tax_query'      => $tax_query,
    'meta_query'     => !empty($meta_query) ? $meta_query : [],
    'orderby'        => $orderby,
    'order'          => $order,
];
if ($orderby === 'meta_value_num') {
    $args['orderby'] = ['preco_clause' => $order];
}

$query = new WP_Query($args);

$page_title = get_the_title();
$page_subtitle = get_the_excerpt();
if (!$page_subtitle) {
    $page_subtitle = 'Encontre o imóvel perfeito para você em Brasília';
}
?>
<section class="page-banner">
    <div class="container">
        <h1><?php echo esc_html($page_title); ?></h1>
        <p><?php echo esc_html($page_subtitle); ?></p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <div class="properties-header">
            <div class="properties-count">
                <strong><?php echo $query->found_posts; ?></strong> imóveis encontrados
            </div>
            <form class="properties-filters" method="get">
                <input type="hidden" name="post_type" value="imovel">
                <select name="finalidade" onchange="this.form.submit()">
                    <option value="">Todas finalidades</option>
                    <option value="venda" <?php selected($finalidade, 'venda'); ?>>Venda</option>
                    <option value="aluguel" <?php selected($finalidade, 'aluguel'); ?>>Aluguel</option>
                </select>
                <?php wp_dropdown_categories([
                    'taxonomy'      => 'tipo',
                    'name'          => 'tipo',
                    'show_option_none' => 'Todos tipos',
                    'value_field'   => 'slug',
                    'option_none_value' => '',
                    'selected'      => $tipo,
                    'class'         => '',
                ]); ?>
                <?php wp_dropdown_categories([
                    'taxonomy'      => 'regiao',
                    'name'          => 'regiao',
                    'show_option_none' => 'Todas regiões',
                    'value_field'   => 'slug',
                    'option_none_value' => '',
                    'selected'      => $regiao,
                    'class'         => '',
                ]); ?>
                <select name="ordem" onchange="this.form.submit()">
                    <option value="date_desc" <?php selected($ordem, 'date_desc'); ?>>Mais recentes</option>
                    <option value="date_asc" <?php selected($ordem, 'date_asc'); ?>>Mais antigos</option>
                    <option value="price_asc" <?php selected($ordem, 'price_asc'); ?>>Menor preço</option>
                    <option value="price_desc" <?php selected($ordem, 'price_desc'); ?>>Maior preço</option>
                </select>
            </form>
        </div>

        <?php if ($query->have_posts()): ?>
            <div class="properties-grid">
                <?php while ($query->have_posts()): $query->the_post();
                    $preco = get_post_meta(get_the_ID(), 'preco', true);
                    $area = get_post_meta(get_the_ID(), 'area', true);
                    $quartos = get_post_meta(get_the_ID(), 'quartos', true);
                    $vagas = get_post_meta(get_the_ID(), 'vagas', true);
                    $bairro = get_post_meta(get_the_ID(), 'bairro', true);
                    $finalidades = wp_get_post_terms(get_the_ID(), 'finalidade', ['fields' => 'names']);
                    $finalidade_label = !empty($finalidades) ? $finalidades[0] : '';
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
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="pagination">
                <?php echo paginate_links([
                    'total'   => $query->max_num_pages,
                    'current' => $paged,
                    'mid_size' => 2,
                ]); ?>
            </div>
        <?php else: ?>
            <p style="text-align:center;color:var(--gray-400);font-size:1.1rem;">Nenhum imóvel encontrado com os filtros selecionados.</p>
        <?php endif; ?>
    </div>
</section>
<?php get_footer(); ?>
