<?php	
function listfoliopro_loadMyBlock() {
  wp_enqueue_script(
    'listfoliopro-block',
    listfoliopro_ep_URLPATH . 'admin/files/js/gutenberg-block.js',
    array('wp-blocks','wp-editor'),
    true
  );
}
   
add_action('enqueue_block_editor_assets', 'listfoliopro_loadMyBlock');

// Block Category
function listfoliopro_filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'listfoliopro-category',
				'icon'  => 'dashicons-before dashicons-universal-access-alt',
                'title' => esc_html__( 'listfoliopro', 'listfoliopro' ),
            )
        );
    }
    return $block_categories;
}
 
add_filter( 'block_categories_all', 'listfoliopro_filter_block_categories_when_post_provided', 10, 2 );
