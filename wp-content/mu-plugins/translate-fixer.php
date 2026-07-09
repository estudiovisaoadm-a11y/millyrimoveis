<?php
/**
 * Plugin Name: Tradutor Supremo V2
 * Description: Tradução massiva e correção automática de layout/rodapé para Listihub.
 * Version: 2.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. DICIONÁRIO COMPLETO (BASEADO NA VARREDURA DO BROWSER)
function get_listfolio_translations_v2() {
    return array(
        // Hero & Header
        'Find You Perfect & Suitable Real Estate' => 'Encontre o Imóvel Perfeito e Ideal',
        'Discover'              => 'Descobrir',
        'Keywords'              => 'Palavras-chave',
        'Search Now'            => 'Buscar Agora',
        'Title'                 => 'Título',
        'Select Categories'     => 'Categorias',
        'select all'            => 'todos',
        
        // Seções da Home
        'Browse Our Featured Property Categories' => 'Explore Nossas Categorias de Imóveis em Destaque',
        'Browse Our Featured Property Categorias' => 'Explore Nossas Categorias de Imóveis em Destaque',
        'Recent Properties Listing of the Month' => 'Listagens Recentes do Mês',
        'Testimonials'          => 'Depoimentos',
        'Happy Homeowners Speak Out and Recommendations' => 'Proprietários Felizes Falam e Recomendações',
        'Happy Homeowners Speak Outu2028and Recommendations' => 'Proprietários Felizes Falam e Recomendações',
        'Happy Homeowners Speak Out' => 'Proprietários Felizes Falam',
        'and Recommendations' => 'e Recomendações',
        '10K+ Customers'        => 'Mais de 10mil Clientes',
        '99% Satisfaction'      => '99% de Satisfação',
        '85% Return'            => '85% de Retorno',
        
        // Rodapé (Widgets e Labels)
        'Archives'              => 'Arquivos',
        'Quick Links'           => 'Links Rápidos',
        'Information'           => 'Informações',
        'Newsletter'            => 'Newsletter',
        'Want to stay up to date with news? Please Subscribe.' => 'Quer ficar atualizado? Inscreva-se em nossa newsletter.',
        'By subscribing to our newsletter you agree to our privacy policy.' => 'Ao se inscrever, você concorda com nossa política de privacidade.',
        'All Right Reserved'    => 'Todos os direitos reservados',
        'Listihub | Developed by: e-plugins' => 'Listihub | Desenvolvido por: e-plugins',
        'By'                    => 'Por',
        
        // Pagina de Anúncio (Single Listing)
        'Overview'              => 'Visão Geral',
        'Details'               => 'Detalhes',
        'What’s Nearby'         => 'O que há por perto',
        'Attachments'           => 'Anexos',
        'Facilidades'           => 'Facilidades',
        'Amenities'             => 'Comodidades',
        'Rate us and Write a Review' => 'Avalie e escreva um comentário',
        'Your Review'           => 'Sua Avaliação',
        'Submit Review'         => 'Enviar Avaliação',
        'Similar Mansão'        => 'Mansões Semelhantes',
        'Similar'               => 'Semelhantes',
        'Sell all 5 Photos'     => 'Ver todas as 5 fotos',
        'Sell all'              => 'Ver todas as',
        'Listing Single'        => 'Página do Anúncio',
        'Listings'              => 'Anúncios',
        
        // Blog
        'Recent Posts'          => 'Posts Recentes',
        'Continue Reading'      => 'Continuar Lendo',
        
        // Geral
        'Home'                  => 'Início',
        'Listing'               => 'Anúncio',
        'Other Pages'           => 'Páginas',
        'About Us'              => 'Sobre Nós',
        'Blog'                  => 'Blog',
        'Contact'               => 'Contato',
        'Contact Us'            => 'Fale Conosco',
        'Post Your Ad'          => 'Anunciar',
        'My Account'            => 'Minha Conta',
        'Registration'          => 'Cadastro',
        'Log In'                => 'Entrar',
        'Register'              => 'Cadastrar',
        'Submit'                => 'Enviar',
        'Price'                 => 'Valor',
        'Reviews'               => 'Avaliações',
        'Exclusive'             => 'Exclusivo',
        'Browse All'            => 'Ver Tudo',
        'Browse All Listing'    => 'Ver Todas as Listagens',
        'Ver Tudo Listing'      => 'Ver Todas as Listagens',
        'Exploring Your Local Area' => 'Explore Sua Região',
        'Blogs & Articles'      => 'Blogs e Artigos',
        'Residential'           => 'Residencial',
        'Restaurant'            => 'Restaurante',
        'Apartment'             => 'Apartamento',
        'Building'              => 'Edifício',
        'Hotels'                => 'Hotéis',
        'Office Space'          => 'Escritórios',
        'Villa'                 => 'Mansão',
    );
}

// 2. INTERCEPTADOR GLOBAL DE TRADUÇÃO
add_filter( 'gettext', 'listfolio_ultimate_translate', 20, 3 );
function listfolio_ultimate_translate( $translated, $text, $domain ) {
    $words = get_listfolio_translations_v2();
    $trimmed_text = trim($text);
    if ( isset( $words[$trimmed_text] ) ) return $words[$trimmed_text];
    return $translated;
}

// 3. LIMPEZA DO RODAPÉ (ESCONDER WIDGETS EXTRAS PARA FICAR IGUAL AO DEMO)
add_action( 'widgets_init', 'listfolio_cleanup_footer_widgets', 99 );
function listfolio_cleanup_footer_widgets() {
    // Se quiser remover widgets específicos do rodapé via código
    // Para agora, vamos apenas garantir que os títulos sejam traduzidos
}

// 4. VARREDURA DO BANCO DE DADOS (UMA VEZ POR CARREGAMENTO NO ADMIN)
add_action( 'admin_init', 'listfolio_mega_db_sweep' );
function listfolio_mega_db_sweep() {
    global $wpdb;
    $translations = get_listfolio_translations_v2();

    // Traduzir Títulos de Páginas
    foreach ($translations as $eng => $pt) {
        if (strlen($eng) > 5) { // Evita palavras curtas que podem dar falso positivo
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_title = %s WHERE post_title = %s AND post_status = 'publish'", $pt, $eng));
            $wpdb->query($wpdb->prepare("UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $eng, $pt));
        }
    }

    // Forçar Configurações do Tema (Footer)
    $options = get_option('listihub_options');
    if (is_array($options)) {
        $options['footer_info_left_text'] = '© 2026 Listihub | Desenvolvido por e-plugins';
        $options['copyright_text'] = 'Todos os direitos reservados';
        update_option('listihub_options', $options);
    }
}

// 5. TRADUÇÃO VISUAL (JS) - COBRE ELEMENTOR E AJAX
add_action( 'wp_footer', 'listfolio_js_ultimate' );
add_action( 'admin_footer', 'listfolio_js_ultimate' );
function listfolio_js_ultimate() {
    $words = get_listfolio_translations_v2();
    ?>
    <script>
    (function($) {
        var translateMap = <?php echo json_encode($words); ?>;
        function translate() {
            // Seletor agressivo para todos os elementos de texto
            $('*').each(function() {
                if ($(this).children().length > 0) return;
                var t = $(this).text().trim();
                if (translateMap[t]) $(this).text(translateMap[t]);
            });
            // Placeholders e inputs
            $('input[placeholder], textarea[placeholder]').each(function() {
                var p = $(this).attr('placeholder').trim();
                if (translateMap[p]) $(this).attr('placeholder', translateMap[p]);
            });
            // Botões do Elementor e outros
            $('.elementor-button-text, .rt-label, .subtitle, .title').each(function() {
                var t = $(this).text().trim();
                if (translateMap[t]) $(this).text(translateMap[t]);
            });
            // Removido loop agressivo para evitar distorção de layout
        }
        $(document).ready(translate);
        $(window).on('load scroll', translate);
        $(document).ajaxComplete(translate);
    })(jQuery);
    </script>
    <style>
        /* Ajuste do Footer para evitar sobreposição */
        .site-footer { padding-bottom: 20px !important; }
        .footer-widget-area .widget_archive, .footer-widget-area .widget_categories { display: none !important; }
    </style>
    <?php
}
