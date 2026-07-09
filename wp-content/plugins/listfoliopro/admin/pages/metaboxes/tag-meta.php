<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
	global 	$listfoliopro_directory_url;
$listfoliopro_directory_url=get_option('listfoliopro_ep_url');					
if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}	

	
function listfoliopro_taxonomy_add_tag_custom_field() {
	$nonce = wp_create_nonce('listfoliopro');
    ?>
    <div class="form-field term-image-wrap">
        <label for="cat-image"><?php esc_html_e('Image[Best: 250px X 380px]','listfoliopro');?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary" id="upload_image_btn"><?php esc_html_e('Upload Image','listfoliopro');?></a></p>
		<input type="hidden" name="listfoliopro_wpnonce" value="<?php echo esc_attr($nonce); ?>">
        <input type="text" name="category_image_url" id="category_image_url"  value="" size="40" />
    </div>
    <?php
}
add_action( $listfoliopro_directory_url.'-tag_add_form_fields', 'listfoliopro_taxonomy_add_tag_custom_field', 10, 2 );
 
function listfoliopro_taxonomy_edit_tag_custom_field($term) {
    $image = get_term_meta($term->term_id, 'listfoliopro_term_image', true);
	$nonce = wp_create_nonce('listfoliopro');
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="category_image_url"><?php esc_html_e('Image [Best: 30px X 30px]','listfoliopro');?></label></th>
        <td>
            <p><a href="#" class="aw_upload_image_button button button-secondary" id="upload_image_btn"><?php esc_html_e('Upload Image','listfoliopro');?> </a>
				
				<img src="<?php echo esc_url($image); ?>" id="listfoliopro_term_image_dis" width="100px">
			</p>
			
			<br/>
			
			<input type="hidden" name="listfoliopro_wpnonce" value="<?php echo esc_attr($nonce); ?>">
            <input type="text" name="category_image_url"  id="category_image_url" value="<?php echo esc_url($image); ?>" size="40" />
        </td>
    </tr>
    <?php
}
add_action( $listfoliopro_directory_url.'-tag_edit_form_fields', 'listfoliopro_taxonomy_edit_tag_custom_field', 10, 2 );

// Save data
add_action('created_'.$listfoliopro_directory_url.'-tag', 'listfoliopro_save_tag_term_image', 10, 2);
function listfoliopro_save_tag_term_image($term_id, $tt_id) {

    if (isset($_POST['category_image_url']) && '' !== $_POST['category_image_url']){
        $group = sanitize_url($_POST['category_image_url']);
        add_term_meta($term_id, 'listfoliopro_term_image', $group, true);
    }
}

///Now save the edited value
add_action('edited_'.$listfoliopro_directory_url.'-tag', 'listfoliopro_update_tag_image_upload', 10, 2);
function listfoliopro_update_tag_image_upload($term_id, $tt_id) {
	
    if (isset($_POST['category_image_url']) && '' !== $_POST['category_image_url']){
        $group = sanitize_url($_POST['category_image_url']);
        update_term_meta($term_id, 'listfoliopro_term_image', $group);
    }
}

// Js add
function listfoliopro_image_tag_uploader_enqueue() {
    global $typenow,$listfoliopro_directory_url;	
    if( ($typenow == $listfoliopro_directory_url) ) { 
		wp_enqueue_media();
        wp_register_script( 'listfoliopro_meta-image', listfoliopro_ep_URLPATH . 'admin/files/js/meta-media-uploader.js', array( 'jquery' ) );
        wp_localize_script( 'listfoliopro_meta-image', 'meta_image',
            array(
                'title' => 'Upload an Image',
                'button' => 'Use this Image',
            )
        );
        wp_enqueue_script( 'listfoliopro_meta-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'listfoliopro_image_tag_uploader_enqueue' );