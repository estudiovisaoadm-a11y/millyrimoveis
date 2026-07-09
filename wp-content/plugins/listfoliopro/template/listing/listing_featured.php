<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	wp_enqueue_script("jquery");	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-autocomplete');
	wp_enqueue_script('popper', listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('listfoliopro_listing_style_alphabet_sort', listfoliopro_ep_URLPATH . 'admin/files/css/archive-listing.css');
	wp_enqueue_style('colorbox', listfoliopro_ep_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_style('font-awesome', listfoliopro_ep_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('flaticon', listfoliopro_ep_URLPATH . 'admin/files/fonts/flaticon/flaticon.css');
	wp_enqueue_style('listfoliopro_post-paging', listfoliopro_ep_URLPATH . 'admin/files/css/post-paging.css');
	$main_class = new listfoliopro_eplugins;
	global $post,$wpdb,$tag,$listfoliopro_filter_badge;
	$defaul_feature_img= $this->listfoliopro_listing_default_image();
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$current_post_type=$listfoliopro_directory_url;
	$dir_style5_perpage=get_option('listfoliopro_dir_perpage');
	$dirs_data =array();
	$tag_arr= array();
	$post_limit='999999';
	if(isset($atts['post_limit']) and $atts['post_limit']!="" ){
		$post_limit=$atts['post_limit'];
	}	
	$dirs_data =array();
	$tag_arr= array();
	$args = array(
	'post_type' => $listfoliopro_directory_url, // enter your custom post type
	'post_status' => 'publish',		
	'posts_per_page'=> $post_limit,  // overrides posts per page in theme settings
	);
	$features = array(
	'relation' => 'AND',
	array(
	'key'     => 'listfoliopro_featured',
	'value'   => 'featured',
	'compare' => '='
	),
	);
	$args['meta_query'] = array(
	$features,
	);
	$listfoliopro_query = new WP_Query( $args );
	$active_archive_fields=listfoliopro_get_archive_fields_all();
	$active_archive_icon_saved=get_option('listfoliopro_archive_icon_saved' );
?>
<!-- wrap everything for our isolated bootstrap -->
<div class="bootstrap-wrapper">
	<!-- archieve page own design font and others -->
	<section class=" py-5">
		<div class="container "  >			
			<div class="row" id="full_grid"> 
				<img class="col-md-12" src="<?php echo listfoliopro_ep_URLPATH."assets/images/astra.png"; ?>">
				<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12  " id="dirpro_directories" >	
					<div class="row justify-content-center" >
						<?php
							$i=0;
							if ( $listfoliopro_query->have_posts() ) :
							while ( $listfoliopro_query->have_posts() ) : $listfoliopro_query->the_post();
							$id = get_the_ID();
							if(get_post_meta($id, 'listfoliopro_featured', true)=='featured'){
								$feature_img='';
								if(has_post_thumbnail()){ 
									$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
									if($feature_image[0]!=""){
										$feature_img =$feature_image[0];
									}
									}else{ 
									$feature_img= $defaul_feature_img;
								}
								$dir_data['title']=esc_html($post->post_title);
								$dir_data['dlink']=get_permalink($id);
								$dir_data['address']= get_post_meta($id,'address',true);										
								$dir_data['image']=  $feature_img;	
								$dir_data['locations']= '';								
								$dir_data['lat']=get_post_meta($id,'latitude',true);
								$dir_data['lng']=get_post_meta($id,'longitude',true);
								$dir_data['marker_icon']= $main_class->listfoliopro_get_categories_mapmarker($id,$listfoliopro_directory_url);
								$ins_lat=get_post_meta($id,'latitude',true);
								$ins_lng=get_post_meta($id,'longitude',true);
								$cat_link='';$cat_name='';$cat_slug='';
								// VIP
								$post_author_id= $listfoliopro_query->post->post_author;
								$current_date=time();
							?>		
							<?php
								include( listfoliopro_ep_template. 'listing/single-template/archive-grid-block.php');
							?>	
							<?php
								$i++;
							}
							endwhile;
						endif;	?>
					</div>						
				</div>
			</div>
		</div>
	</section>
	<!-- end of arhiece page -->
</div>
<!-- end of bootstrap wrapper -->
<?php
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
?>
<?php
	wp_enqueue_script('listfoliopro_message', listfoliopro_ep_URLPATH . 'admin/files/js/user-message.js');
	wp_localize_script('listfoliopro_message', 'listfoliopro_data_message', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'listfoliopro' ),
	'contact'=> wp_create_nonce("contact"),
	'listing'=> wp_create_nonce("listing"),
	) );
	wp_enqueue_script('listfoliopro_single-listing', listfoliopro_ep_URLPATH . 'admin/files/js/single-listing.js');
	wp_localize_script('listfoliopro_single-listing', 'listfoliopro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'listfoliopro' ),
	'Add_to_Favorites'=>esc_html__('Save', 'listfoliopro' ),
	'Added_to_Favorites'=>esc_html__('Saved', 'listfoliopro' ),
	'Please_put_your_message'=>esc_html__('Please put your name,email Cover letter & attached file', 'listfoliopro' ),
	'contact'=> wp_create_nonce("contact"),
	'dirwpnonce'=> wp_create_nonce("myaccount"),
	'listing'=> wp_create_nonce("listing"),
	'cv'=> wp_create_nonce("Doc/CV/PDF"),
	'listfoliopro_ep_URLPATH'=>listfoliopro_ep_URLPATH,
	) );
	
?>
<?php
	wp_reset_query();
?>