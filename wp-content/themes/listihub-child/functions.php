<?php
add_action('wp_enqueue_scripts', 'millyr_enqueue_scripts');

function millyr_enqueue_scripts() {
    $parent_style = 'listihub-style';
    wp_dequeue_style($parent_style);
    wp_deregister_style($parent_style);
    wp_enqueue_style($parent_style, get_parent_theme_file_uri('style.css'));

    wp_enqueue_style('millyr-style', get_theme_file_uri('style.css'), [], filemtime(get_theme_file_path('style.css')));

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap', [], null);

    wp_enqueue_script('millyr-main', get_theme_file_uri('assets/js/main.js'), [], filemtime(get_theme_file_path('assets/js/main.js')), true);
}

add_action('after_setup_theme', 'millyr_setup');

function millyr_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Main Menu', 'listihub'),
        'footer'  => __('Footer Menu', 'listihub'),
    ]);
}

add_filter('use_block_editor_for_post', '__return_false');

add_action('init', 'millyr_register_imovel_post_type');

function millyr_register_imovel_post_type() {
    register_post_type('imovel', [
        'labels' => [
            'name'          => 'Imóveis',
            'singular_name' => 'Imóvel',
            'add_new'       => 'Adicionar Imóvel',
            'add_new_item'  => 'Adicionar Novo Imóvel',
            'edit_item'     => 'Editar Imóvel',
            'view_item'     => 'Ver Imóvel',
            'search_items'  => 'Buscar Imóveis',
            'not_found'     => 'Nenhum imóvel encontrado',
        ],
        'public'            => true,
        'has_archive'       => true,
        'rewrite'           => ['slug' => 'imovel'],
        'supports'          => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'menu_icon'         => 'dashicons-building',
        'menu_position'     => 5,
        'show_in_rest'      => true,
    ]);
}

add_action('init', 'millyr_register_taxonomies');

function millyr_register_taxonomies() {
    register_taxonomy('tipo', 'imovel', [
        'labels' => [
            'name'          => 'Tipos',
            'singular_name' => 'Tipo',
            'search_items'  => 'Buscar Tipos',
            'all_items'     => 'Todos os Tipos',
            'edit_item'     => 'Editar Tipo',
            'add_new_item'  => 'Adicionar Novo Tipo',
        ],
        'public'            => true,
        'rewrite'           => ['slug' => 'tipo'],
        'show_in_rest'      => true,
        'hierarchical'      => true,
    ]);

    register_taxonomy('regiao', 'imovel', [
        'labels' => [
            'name'          => 'Regiões',
            'singular_name' => 'Região',
            'search_items'  => 'Buscar Regiões',
            'all_items'     => 'Todas as Regiões',
            'edit_item'     => 'Editar Região',
            'add_new_item'  => 'Adicionar Nova Região',
        ],
        'public'            => true,
        'rewrite'           => ['slug' => 'regiao'],
        'show_in_rest'      => true,
        'hierarchical'      => true,
    ]);

    register_taxonomy('finalidade', 'imovel', [
        'labels' => [
            'name'          => 'Finalidades',
            'singular_name' => 'Finalidade',
            'search_items'  => 'Buscar Finalidades',
            'all_items'     => 'Todas as Finalidades',
            'edit_item'     => 'Editar Finalidade',
            'add_new_item'  => 'Adicionar Nova Finalidade',
        ],
        'public'            => true,
        'rewrite'           => ['slug' => 'finalidade'],
        'show_in_rest'      => true,
        'hierarchical'      => true,
    ]);
}

add_action('add_meta_boxes', 'millyr_imovel_metaboxes');

function millyr_imovel_metaboxes() {
    add_meta_box('millyr_imovel_dados', 'Dados do Imóvel', 'millyr_imovel_metabox_callback', 'imovel', 'normal', 'high');
}

function millyr_imovel_metabox_callback($post) {
    wp_nonce_field('millyr_imovel_meta', 'millyr_imovel_nonce');
    $fields = [
        'preco'          => 'Preço (R$)',
        'area'           => 'Área (m²)',
        'quartos'        => 'Quartos',
        'suites'         => 'Suítes',
        'banheiros'      => 'Banheiros',
        'vagas'          => 'Vagas de Garagem',
        'condominio'     => 'Condomínio (R$)',
        'iptu'           => 'IPTU (R$)',
        'destaque'       => 'Imóvel Destaque (sim/não)',
        'endereco'       => 'Endereço',
        'bairro'         => 'Bairro',
        'cep'            => 'CEP',
        'latitude'       => 'Latitude',
        'longitude'      => 'Longitude',
        'caracteristicas'=> 'Características (separadas por vírgula)',
    ];
    echo '<table style="width:100%;border-collapse:collapse;">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr>';
        echo '<td style="padding:8px;width:200px;font-weight:600;"><label for="' . esc_attr($key) . '">' . esc_html($label) . '</label></td>';
        echo '<td style="padding:8px;"><input type="text" id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" style="width:100%;padding:8px;" /></td>';
        echo '</tr>';
    }
    echo '</table>';
}

add_action('save_post', 'millyr_save_imovel_meta');

function millyr_save_imovel_meta($post_id) {
    if (!isset($_POST['millyr_imovel_nonce']) || !wp_verify_nonce($_POST['millyr_imovel_nonce'], 'millyr_imovel_meta')) return;

    $fields = ['preco', 'area', 'quartos', 'suites', 'banheiros', 'vagas', 'condominio', 'iptu', 'destaque', 'endereco', 'bairro', 'cep', 'latitude', 'longitude', 'caracteristicas'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}

function millyr_option($key, $default = '') {
    return function_exists('listihub_option') ? listihub_option($key, $default) : $default;
}

add_action('admin_post_nopriv_millyr_contact', 'millyr_handle_contact');
add_action('admin_post_millyr_contact', 'millyr_handle_contact');

function millyr_handle_contact() {
    $nome = sanitize_text_field($_POST['nome'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $telefone = sanitize_text_field($_POST['telefone'] ?? '');
    $assunto = sanitize_text_field($_POST['assunto'] ?? 'contato');
    $mensagem = sanitize_textarea_field($_POST['mensagem'] ?? '');
    $imovel = sanitize_text_field($_POST['imovel'] ?? '');

    $to = get_option('admin_email');
    $subject = $imovel ? "Interesse no imóvel: $imovel" : "Contato via site - $assunto";
    $body = "Nome: $nome\nE-mail: $email\nTelefone: $telefone\n";
    if ($imovel) $body .= "Imóvel: $imovel\n";
    $body .= "\nMensagem:\n$mensagem";
    wp_mail($to, $subject, $body, ["Reply-To: $email"]);

    $redirect = home_url('/contato?enviado=1');
    wp_safe_redirect($redirect);
    exit;
}
