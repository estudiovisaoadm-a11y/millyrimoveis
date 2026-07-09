<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php
	global 	$listfoliopro_directory_url;
$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}

wp_enqueue_script("jquery");	
wp_enqueue_style('fontawesome-browser', listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome-browser.css');
wp_enqueue_style('all-font-awesome', 			listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome.css');


function listfoliopro_taxonomy_add_category_custom_field() {
	$nonce = wp_create_nonce('listfoliopro');
    ?>	
	<div class="form-field ">
		<label for="cat-image"><?php esc_html_e('Select Icon','listfoliopro');?></label>
		<p>
		<input type="text" name="cat-icon"  id="caticon_url"  class="form-control" placeholder="<?php esc_html_e('Select Icon','listfoliopro');?>"  />
		 <a href="javascript:void(0);" onclick="listfoliopro_cat_icon_uploader_image('caticon_url');"  class="button button-secondary"><?php esc_html_e('Upload Icon','listfoliopro');?></a>
		</p>
	</div>
	
	 <div class="form-field term-image-wrap">
        <label for="cat-marker"><?php esc_html_e('Map Marker','listfoliopro');?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary" id="upload_marker_btn"><?php esc_html_e('Upload Marker','listfoliopro');?></a></p>
        <input type="text" name="category_marker_url" id="category_marker_url"  value="" size="40" />
    </div>	
    <div class="form-field term-image-wrap">
        <label for="cat-image"><?php esc_html_e('Image[Best: 300 X 200px]','listfoliopro');?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary" id="upload_image_btn"><?php esc_html_e('Upload Image','listfoliopro');?></a></p>
		 <input type="hidden" name="listfoliopro_wpnonce" value="<?php echo esc_attr($nonce); ?>">
        <input type="text" name="category_image_url" id="category_image_url"  value="" size="40" />
    </div>	
 <?php
}
add_action( $listfoliopro_directory_url.'-category_add_form_fields', 'listfoliopro_taxonomy_add_category_custom_field', 10, 2 );
 
function listfoliopro_taxonomy_edit_category_custom_field($term) {
    $image = get_term_meta($term->term_id, 'listfoliopro_term_image', true);
	$caticon= get_term_meta($term->term_id, 'listfoliopro_term_icon', true);
	$map_marker= get_term_meta($term->term_id, 'listfoliopro_term_mapmarker', true);
	$nonce = wp_create_nonce('listfoliopro');
    ?>
	 <tr class="form-field ">
        <th scope="row"><label ><?php esc_html_e('Select Icon','listfoliopro');?></label></th>
        <td>
		<p>
          
		  <a href="javascript:void(0);" onclick="listfoliopro_cat_icon_uploader_image('caticoninputedit');"  class="button button-secondary"><?php esc_html_e('Upload Icon','listfoliopro');?></a>
		  <img src="<?php echo esc_url($caticon); ?>" id="listfoliopro_term_icon_dis" width="100px">
		  <input type="text" name="cat-icon" id="caticoninputedit" value="<?php echo esc_attr($caticon); ?>"  class="form-control" placeholder="<?php esc_html_e('Select Icon','listfoliopro');?>"  />
		  </p>
          
        </td>
    </tr>
	 <tr class="form-field term-image-wrap">
        <th scope="row"><label for="category_marker_url"><?php esc_html_e('Map Marker','listfoliopro');?></label></th>
        <td>
            <p><a href="#" class="aw_upload_image_button button button-secondary" id="upload_marker_btn"><?php esc_html_e('Upload Map Marker','listfoliopro');?> </a>
				<img src="<?php echo esc_url($map_marker); ?>" id="listfoliopro_term_marker_dis" width="100px">
			</p>			
			<br/>
            <input type="text" name="category_marker_url"  id="category_marker_url" value="<?php echo esc_url($map_marker); ?>" size="40" />
        </td>
    </tr>
	
	 <tr class="form-field term-image-wrap">
        <th scope="row"><label for="category_image_url"><?php esc_html_e('Image [Best: 300px X 200px]','listfoliopro');?></label></th>
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
add_action( $listfoliopro_directory_url.'-category_edit_form_fields', 'listfoliopro_taxonomy_edit_category_custom_field', 10, 2 );

// Save data
add_action('created_'.$listfoliopro_directory_url.'-category', 'listfoliopro_save_term_category_image', 10, 2);
function listfoliopro_save_term_category_image($term_id, $tt_id) {

    if (isset($_POST['category_image_url']) && '' !== $_POST['category_image_url']){
        $group = sanitize_url($_POST['category_image_url']);
        add_term_meta($term_id, 'listfoliopro_term_image', $group, true);
    }
	if (isset($_POST['category_marker_url']) && '' !== $_POST['category_marker_url']){
        $group = sanitize_url($_POST['category_marker_url']);
        add_term_meta($term_id, 'listfoliopro_term_mapmarker', $group, true);
    }
	
	if (isset($_POST['cat-icon']) && '' !== $_POST['cat-icon']){
        $caticon = sanitize_text_field($_POST['cat-icon']);
        add_term_meta($term_id, 'listfoliopro_term_icon', $caticon, true);
    }
	
}

///Now save the edited value
add_action('edited_'.$listfoliopro_directory_url.'-category', 'listfoliopro_update_image_upload_category', 10, 2);
function listfoliopro_update_image_upload_category($term_id, $tt_id) {
	
    if (isset($_POST['category_image_url']) && '' !== $_POST['category_image_url']){
        $group = sanitize_url($_POST['category_image_url']);
        update_term_meta($term_id, 'listfoliopro_term_image', $group);
    }
	if (isset($_POST['category_marker_url']) && '' !== $_POST['category_marker_url']){
		 $group = sanitize_url($_POST['category_marker_url']);
        update_term_meta($term_id, 'listfoliopro_term_mapmarker', $group);
    }
	
	if (isset($_POST['cat-icon']) && '' !== $_POST['cat-icon']){	
         $caticon = sanitize_text_field($_POST['cat-icon']);
         update_term_meta($term_id, 'listfoliopro_term_icon', $caticon);
    }
}

// Js add
function listfoliopro_image_uploader_enqueue_category() {
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
add_action( 'admin_enqueue_scripts', 'listfoliopro_image_uploader_enqueue_category' );