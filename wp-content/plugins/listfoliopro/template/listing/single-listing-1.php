<?php
	if ( ! defined( 'ABSPATH' ) ) exit;
	get_header(); 
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_style('bootstrap', 	listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_style('fontawesome', listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome.css');
	wp_enqueue_style('jquery.fancybox', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.fancybox.css');
	wp_enqueue_style('colorbox', listfoliopro_ep_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_script('colorbox', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_script('jquery.fancybox',listfoliopro_ep_URLPATH . 'admin/files/js/jquery.fancybox.js');
	wp_enqueue_style('listfoliopro_single-listing', listfoliopro_ep_URLPATH . 'admin/files/css/single-listing-1.css');
	wp_enqueue_style( 'listing-elementor-widget', Property_Pro.'admin/files/css/listing-elementor-widget.css');
	$main_class = new listfoliopro_eplugins;
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$active_archive_icon_saved=get_option('listfoliopro_li_field_image' );
	$field_set=	get_option('listfoliopro_li_fields' );
	if($field_set==""){
		$field_set_all= listfoliopro_default_custom_fields_with_type();
		$field_set = $field_set_all[0];	
	}
	
	global $post,$wpdb, $current_user;
	$allowed_html = array(
	//formatting
    'strong' => array(),
    'em'     => array(),
    'b'      => array(),
    'i'      => array(),
    //links
    'a'     => array(
	'href' => array()
    )
	);
	$favorite_icon='';
	$listingid = get_the_ID();
	$post_id_1 = get_post($listingid);
	$post_id_1->post_title;
	$active_single_fields_saved=get_option('listfoliopro_single_fields_saved' );
	if(empty($active_single_fields_saved)){$active_single_fields_saved=listfoliopro_get_listing_fields_all_single();}
	$single_page_icon_saved=get_option('listfoliopro_single_icon_saved' );
	$wp_directory= new listfoliopro_eplugins();
	while ( have_posts() ) : the_post();
	$currentCategory = $main_class->listfoliopro_get_categories_caching($listingid,$listfoliopro_directory_url);
	$cat_name2='';
	if(isset($currentCategory[0]->slug)){
		foreach($currentCategory as $c){
			$cat_name2 = $cat_name2. $c->name.' / ';
		}
	}
	$listing_contact_source=get_post_meta($listingid,'listing_contact_source',true);
	if($listing_contact_source==''){$listing_contact_source='user_info';}
	if($listing_contact_source=='new_value'){
		$company_logo='';
		}else{
		$company_logo='';
	}
	// View Count***
	$current_count=get_post_meta($listingid,'listing_views_count',true);
	$current_count=(int)$current_count+1;
	update_post_meta($listingid,'listing_views_count',$current_count);
	$data_for_top=array();
	$data_for_top['category']='category';
	$data_for_top['post_date']='post_date';
	$data_not_for_all_section=array();
	$data_not_for_all_section['title']='title';
	$data_not_for_all_section['address']='address';
	$data_not_for_all_section['price']='price';
	$data_not_for_all_section['category']='category';
	$data_not_for_all_section['contact_button']='contact_button';
	$data_not_for_all_section['pdf_button']='pdf_button';
	$data_not_for_all_section['favorite']='favorite';
	$data_not_for_all_section['simillar_listing']='simillar_listing';
	$data_not_for_all_section['review']='review';
	$data_not_for_all_section['whatsapp']='whatsapp';
	$dir_detail= get_post($listingid);
	$author_id=$dir_detail->post_author;
	$user_info = get_userdata( $author_id);
	$company_email =$user_info->user_email;
	if($listing_contact_source=='new_value'){
		$company_name= get_post_meta($listingid, 'company_name',true);
		$company_address= get_post_meta($listingid, 'address',true);
		$company_web=get_post_meta($listingid, 'contact_web',true);
		$company_phone=get_post_meta($listingid, 'phone',true);
		$company_email= get_post_meta($listingid, 'contact-email',true);
		if(has_post_thumbnail()){
			$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $listingid ), 'large' );
			if(isset($feature_image[0])){
				$company_logo =$feature_image[0];
			}
		}
		}else{
		$company_name= get_user_meta($author_id,'full_name', true);
		$company_address= get_user_meta($author_id,'address', true);
		$company_web=get_user_meta($author_id,'website', true);
		$company_phone=get_user_meta($author_id,'phone', true);
		$company_logo=get_user_meta($author_id, 'listfoliopro_profile_pic_thum',true);
	}
	
	$not_show_sp_his=array('specialties','history');
	$custom_fields=$field_set;	
	if ( is_array( $custom_fields ) ) {
		foreach($not_show_sp_his as $delete_one_item ){
			unset($custom_fields[$delete_one_item]);
		}
	}	
	if($custom_fields==''){$custom_fields=array();}
	$listfoliopro_listing_d_color=get_option('listfoliopro_listing_d_color');	
	if($listfoliopro_listing_d_color==""){$listfoliopro_listing_d_color='#f5f5f5';}
?>

<div class="bootstrap-wrapper " >
	<div class="container mb-3 " >
		<div class="row box-white  mt-2 p-4 mt-5 mb-4 m-2">
			<div class="col-xl-8 col-md-12 mt-4">
				<?php					   
					if ( array_key_exists( 'image-gallery', $active_single_fields_saved ) ) {
					?>
					<div class="list-single-slider">							
						<?php include(listfoliopro_ep_template . '/listing/single-template/single-style-1/slider.php'); ?>
					</div>
					<?php
					}
				?>
								
				
				
					
			</div>	
			<?php
				
					$dir_number_format=get_option('dir_number_format');	
					if($dir_number_format==""){$dir_number_format='usa';}
				?>
				<div class="col-xl-4 col-md-12 mt-4 text-left ">
						<div class="col-md-12 flex-grow-1 ">
								<?php
								if(array_key_exists('title',$active_single_fields_saved)){
								?>
								
								<h1 class="text-break single-style-1-header">
									<?php echo get_the_title($listingid); ?>
								</h1>
								
								<?php
								}
							?>
							
								<h3 class="address mt-3 mb-3">	
								<?php
								if(get_post_meta( $listingid, 'property_status', true )!=''){
								?>
								<span class="listing-type"><?php echo esc_html(get_post_meta( $listingid, 'property_status', true )); ?></span>
								<?php
								}
								if(array_key_exists('address',$active_single_fields_saved)){
								?>
								<span class="dashicons dashicons-location mr-1 address-icon"></span> <?php echo esc_html($company_address); ?>
								<?php
								}
								?>
								</h3>
								<?php
								if(array_key_exists('price',$active_single_fields_saved)){ ?>
								<h1 class="single-style-1-sub-header mt-4">
								
									<?php  esc_html_e('Price: ','listfoliopro'); ?>
									
									<?php if ( get_post_meta( $listingid, 'discount', true ) != '' ) { ?>
										
										<strike class="listfoliopro-main-price "><?php  echo esc_html( listfoliopro_get_price(get_post_meta( $listingid, 'price', true ),$listingid,$dir_number_format)); ?></strike>
										<span class="listfoliopro-discount-price "><?php echo esc_html( listfoliopro_get_price(get_post_meta( $listingid, 'discount', true ),$listingid,$dir_number_format)); ?></span>
										<?php
										} else { ?>
										<?php echo esc_html( listfoliopro_get_price(get_post_meta( $listingid, 'price', true ),$listingid, $dir_number_format));  ?>
										
										<?php
										}
									?>
									
								</h1>
								<?php
									}
								?>
					
						<div class="single-listing-rating-count" >
								<?php
								if ( array_key_exists( 'favorite', $active_single_fields_saved ) ) {
								?>
									<?php include( listfoliopro_ep_template . '/listing/single-template/favorites.php'); ?>
								<?php
								}
								?>
							<?php
							if ( array_key_exists( 'pdf_button', $active_single_fields_saved ) ) {
							?>
							<a class="single-listing-pdf-button p-2" href="<?php echo get_permalink(); ?>?&listfoliopropdfpost=<?php echo esc_attr( $listingid ); ?>"
							target="_blank"> 
								<img class="pdf-link " src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/pdf.png'); ?>">
							</a>
							<?php
							}
							?>
							<?php
							if (array_key_exists('review', $active_single_fields_saved)) { ?>
							<?php
								$user_id=$listingid;
								$total_review_point=0;
								$one_review_total=0;
								$two_review_total=0;
								$three_review_total=0;
								$four_review_total=0;
								$five_review_total=0;
								$post_type='listfoliopro_review';
								$sql= $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type ='listfoliopro_review'  and post_author='%s' 	and post_status='publish' ORDER BY ID DESC",$user_id);
								$reg_page_user='';
								$iv_redirect_user = get_option( '_ep_ivproperty_profile_public_page');
								if($iv_redirect_user!='defult'){
									$reg_page_user= get_permalink( $iv_redirect_user) ;
								}
								$listing_author_link=get_option('listing_author_link');
								if($listing_author_link==""){$listing_author_link='author';}
								$author_reviews = $wpdb->get_results($sql);
								$total_reviews=count($author_reviews);
								if($total_reviews>0){
									foreach ( $author_reviews as $review )
									{
										$review_val=(int)get_post_meta($review->ID,'review_value',true);
										$review_val2=(float)get_post_meta($review->ID,'review_value',true);
										$total_review_point=$total_review_point+ $review_val2;
										if($review_val=='1'){
											$one_review_total=$one_review_total+1;
										}
										if($review_val=='2'){
											$two_review_total=$two_review_total+1;
										}
										if($review_val=='3'){
											$three_review_total=$three_review_total+1;
										}
										if($review_val=='4'){
											$four_review_total=$four_review_total+1;
										}
										if($review_val=='5'){
											$five_review_total=$five_review_total+1;
										}
									}
								}
								$avg_review=0;
								if($total_review_point>0){
									$avg_review= (float)$total_review_point/(float)$total_reviews;
								}
								$saved_listing_avg_rating=get_post_meta($listingid,'review',true);
								if($avg_review!=$saved_listing_avg_rating){
									update_post_meta($id,'review',$avg_review);
								}
							?>
							
							<div class="single-listing-review-star">
								<?php
								if($avg_review >=.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
								<?php
								if($avg_review >=1.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=1.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
								<?php
								if($avg_review >=2.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=2.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
								<?php
									if($avg_review >=3.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=3.1){ ?>
								<i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
								<?php
								if($avg_review >=4.75 ){ ?><i class="fas fa-star off-white"></i><?php }elseif($avg_review >=4.1){ ?><i class="fas fa-star-half-alt  half-off-white"></i> <?php }else{?> <i class="far fa-star off-white"></i><?php } ?>
							</div>
							
							
							<span class="total-review single-style-1-sub-header"><?php echo esc_html($total_reviews);?>&nbsp;</span>
							<?php if ($total_reviews <= 1){
								echo esc_html__('Review', 'listfoliopro');
								}else{
								echo esc_html__('Reviews','listfoliopro');
							} ?>
							<?php } ?>
						</div>
					
					</div>	
						
						<div class="col-md-12  booking-and-claim-button  mt-4">
						<?php
							if ( array_key_exists( 'booking_button', $active_single_fields_saved ) ) {
							?>
							<button class="pl-4 pr-4 mt-4 " type="button" onclick="listfoliopro_listing_booking_popup('<?php echo esc_html( $listingid ); ?>')"><?php esc_html_e( 'Schedule Visit', 'listfoliopro' ); ?></button>
							<?php
							}
						?>
						
						</div>
						
					
				</div>
				
			
			
		
	</div>
		<div class="row box-white  p-4 mt-5 mb-4 m-2">
				<ul class="horizontal-list  mt-1">
					<?php		
					// For top filter		
					$fields_top_section_all=listfoliopro_get_fields_top_section();
					$save_fields_top_section=get_option('listfoliopro_fields_top_saved' );
					if($save_fields_top_section==''){$save_fields_top_section=array();}
					// End top filter
					if(is_array($fields_top_section_all)){
						$i=1;
						foreach($fields_top_section_all  as $field_key => $field_value){
							if($field_key!=''){
								if(in_array($field_key, $save_fields_top_section)){
									if(get_post_meta( $listingid, $field_key, true )!='' AND  $field_key!='category'){										
									?>
									<li >
										<div class="mb-2">
											<?php 
												$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, $field_key, 'archive' );
												if($saved_icon!=''){
													echo '<img class="mr-1 field-icon-size" src="'.esc_url($saved_icon).'">';
												}?>
												<span class="mt-2 mb-2"><?php echo esc_html((isset($field_set[$field_key])? $field_set[$field_key].' . ':''));?>
												<?php echo esc_html(get_post_meta( $listingid, $field_key, true ));?></span>
										</div>
									</li>
									<?php  
										}elseif($field_key=='category'){
										$currentCategory = $main_class->listfoliopro_get_categories_caching($listingid, $listfoliopro_directory_url);
										$term_id=0;$cat_name='';											
										if (isset($currentCategory[0]->slug)) {
											foreach ($currentCategory as $c) {
												$cat_name = esc_html($c->name);
												$term_id=$c->term_id;
												break;
											}
										?>
										<li >
											<div class="mb-2">
												<?php 
													$saved_icon = listfoliopro_get_cat_icon( $term_id);
													if($saved_icon!=''){
														echo '<img class="mr-1 field-icon-size" src="'.esc_url($saved_icon).'">';
													}?>
													<span class="mt-2 mb-2"><?php echo esc_html__("Type.",'listfoliopro'); ?></span>
													<a href="<?php echo esc_url(get_category_link($term_id));?>" class="text-break"><?php echo esc_html($cat_name);?></a>
											</div>
										</li>
										<?php
										}
									}
									$i++;
								}					
							}
						}	
					}
				?>				
			</ul>
		</div>
		
		
		
		<div class="row mt-2"> 
			<div class="col-xl-8">
				<div class="box-white  p-4 mt-5 mb-4 m-2">
					<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Overview",'listfoliopro'); ?></h2>
					<div class="text-content  mt-3 m-2 ">
						<?php
							$content_post = get_post( $listingid );
							$content      = $content_post->post_content;
							$content      = apply_filters( 'the_content', $content );
							$content      = str_replace( ']]>', ']]&gt;', $content );
							echo wpautop( $content );
							
						?>
					</div>
					
					<h2 class="mt-4 mb-3 m-2"><?php echo esc_html__("Details",'listfoliopro'); ?></h2>
					<div class="text-content  mt-3 ">
						<?php
							if ( is_array( $custom_fields ) ) {
								echo '<ul class="list-style-custom-field row mb-2">';
								foreach ($custom_fields as $key => $one_field) { 
									if (array_key_exists($key, $active_single_fields_saved)) {
										if(get_post_meta($listingid, $key, true)!=''){
											if($key!='area_prefix_text'){
												if($key=='area'){
													echo '<li class="col-12 col-md-6 col-lg-6  mt-2 d-flex justify-content-between">';
													echo '<span class="text-left">' . esc_html($one_field) . esc_html__(' : ', 'listfoliopro') . '</span>';
													echo '<span class="text-right">' .  esc_html(get_post_meta($listingid, 'area_prefix_text', true)).'. '.esc_html(get_post_meta($listingid, $key, true)) . '</span>';
													echo '</li>';
													}else{
													echo '<li class="col-12 col-md-6 col-lg-6  mt-2 d-flex justify-content-between">';
													echo '<span class="text-left">' . esc_html($one_field) . esc_html__(' : ', 'listfoliopro') . '</span>';
													echo '<span class="text-right">' . esc_html(get_post_meta($listingid, $key, true)) . '</span>';
													echo '</li>';
												}
											}
										}	
									}
								}
								echo '</ul>';
							}
						?>
					</div>
					
					
					
				</div>
				<?php
					if (array_key_exists('tag', $active_single_fields_saved)) {
						
						$tag_array = wp_get_object_terms($listingid, $listfoliopro_directory_url . '-tag');
						$num_tags = count($tag_array);
						if($num_tags>0){
						?>
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Amenities",'listfoliopro'); ?></h2> 
							<div class="single-listing-facilities">
								<?php include(listfoliopro_ep_template . '/listing/single-template/tags.php'); ?>
							</div>
						</div>
						<?php
						}
					}
				?>
				<?php
					if (array_key_exists('near-to-me', $active_single_fields_saved)) {
						$facilities = get_post_meta($listingid,'public_facilities',true);
						if ( !empty( $facilities ) ) {
						?>
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("What’s Nearby",'listfoliopro'); ?></h2>
							
							<?php include( listfoliopro_ep_template . '/listing/single-template/near-to-me.php' ); ?>
							
						</div>
						<?php
						}
					}
				?>
				<?php
					if (array_key_exists('360-view', $active_single_fields_saved)) {						
						$image_360 = get_post_meta($listingid,'360_image',true);
						if($image_360!=''){
						?>
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("360 Image ",'listfoliopro'); ?></h2> 
								<div class="text-content  mt-3 ">
									<iframe src="<?php echo esc_url(get_post_meta($listingid,'360_image',true)); ?>" width="100%" height="500px" style="border: none;"></iframe>
								</div>
						</div>
						<?php
						}
					}
				?>
				<?php
					if (array_key_exists('video', $active_single_fields_saved)) {
						$video_vimeo_id= esc_attr(get_post_meta($listingid,'vimeo',true));
						$video_youtube_id=esc_attr(get_post_meta($listingid,'youtube',true));
						if($video_vimeo_id!='' || $video_youtube_id!=''){
						?>
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Video Tour",'listfoliopro'); ?></h2> 
							<?php
								if (array_key_exists('video', $active_single_fields_saved)) { ?>	
								<div class="text-content  mt-3 ">
									<?php include( listfoliopro_ep_template . '/listing/single-template/video.php' ); ?>
								</div>
							<?php } ?>	
						</div>
						<?php
						}
					}
				?>
				<?php
					if (array_key_exists('attachments', $active_single_fields_saved)) {
						$attached_ids       = get_post_meta( $listingid, 'attached_ids', true );
						$attached_ids_array = array_filter( explode( ",", $attached_ids ) );
						
						if ( !empty( $attached_ids_array ) ) { ?>
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Attachments",'listfoliopro'); ?></h2> 
							<?php
								if (array_key_exists('attachments', $active_single_fields_saved)) { ?>	
								<div class="text-content  mt-3 ">
									<?php include( listfoliopro_ep_template . '/listing/single-template/attachments.php' ); ?>
								</div>
							<?php } ?>	
						</div>
						<?php
						}
					}	
				?>
				<div class="box-white  p-4 mt-5 mb-4 m-2">
					<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Reviews",'listfoliopro'); ?></h2> 
					<?php
						if (array_key_exists('review', $active_single_fields_saved)) { ?>	
						<div class="text-content  mt-3 p-2 ">
							<?php include(listfoliopro_ep_template.'/listing/single-template/reviews.php'); ?>
						</div>
					<?php } ?>	
				</div>
				
				<?php
					if (array_key_exists('location', $active_single_fields_saved)) { 
						if ( $company_address != '') {
						?>	
						<div class="box-white  p-4 mt-5 mb-4 m-2">
							
							<h2 class="mt-3 mb-3 m-2"><?php echo esc_html__("Location",'listfoliopro'); ?></h2> 
							
                            <div class="location-wrap mt-3">
								<?php
									
								?>                                               
								<iframe src="https://maps.google.com/maps?q=<?php echo esc_attr( $company_address ); ?>&amp;ie=UTF8&amp;&amp;output=embed"></iframe>
								<?php
									
									
								?>
							</div>							
						</div>
						<?php } 
					}
				?>	
				<div class="single-listing-main-wrapper ">						
					<?php
						if(array_key_exists('social-share',$active_single_fields_saved)){
						?>
						<div class="social-share">
						
						<span class="single-list-share-title"><?php esc_html_e('Share:', 'listfoliopro'); ?> </span>
						<div class="single-list-share-icon-wrapper">
						<a class=" d-inline-block d-middle" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u='.get_the_permalink($listingid ));?>">
						<img alt="" src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/share-fb.svg'); ?>"></a>
						
						<a class=" d-inline-block d-middle" href="<?php echo esc_url('https://twitter.com/home?status='.get_the_permalink($listingid ));?>">
						<img alt="" src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/share-tw.svg'); ?>"></a>
						<a class=" d-inline-block d-middle" href="<?php echo esc_url('http://www.reddit.com/submit?url='. get_the_permalink($listingid ));?>">
						<img alt="" src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/share-red.svg'); ?>"></a>
						<a class="d-inline-block d-middle" href="<?php echo esc_url('https://api.whatsapp.com/send?text='.get_the_permalink($listingid ));?>">
						<img alt="" src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/share-whatsapp.svg'); ?>"></a>
						<?php
						if(array_key_exists('report_button',$active_single_fields_saved)){
						?>
						<a class=" d-inline-block d-middle" href="#" onclick="listfoliopro_claim_popup('<?php echo esc_html($listingid);?>')">
							<img alt="" src="<?php echo esc_url(listfoliopro_ep_URLPATH.'/assets/images/report.png'); ?>"></a>
						
						<?php
							
						}
						?>
						
						</div>
						</div>
						<?php
						}
						?>
					
					
                    </div>
				
				</div>
					
					<div class="col-xl-4 mb-2 ">
					
					<div class="listing-company-info-wrapper box-white  p-4 mt-5 mb-4 m-2">
						<div class=" row mt-3">
							<div class="col-md-12  d-flex justify-content-center text-center">
								
								<?php
									if ( array_key_exists( 'company-logo', $active_single_fields_saved ) ) {
										if ( trim( $company_logo ) != '' ) {
										?>
										<div class="company-logo " style="background-image: url(<?php echo esc_url( $company_logo ); ?>)"></div>
										<?php
											} else {
										?>
											<div class="blank-rounded-logo-"></div>
										<?php
										}
									}
								?>
							</div>
							<?php
								if(array_key_exists('company-name',$active_single_fields_saved)){
								?>								
								<div class="col-md-12  d-flex justify-content-center text-center mt-4 ">
									<span class="profile-header ">
									<?php echo esc_html($company_name); ?>
									</span>
								</span>
								</div>
							<?php } ?>
						<?php
						if(array_key_exists('social-profile',$active_single_fields_saved)){
						?>
						<div class="company-social-wrapper col-md-12  d-flex justify-content-center text-center ">
						<ul>
						<?php 
							if(get_post_meta($listingid ,'facebook',true)!=''){
							?>
							<li><a href="<?php echo esc_url(get_post_meta($listingid ,'facebook',true)); ?>"><i class="fab fa-facebook"></i></a></li>
							<?php  
							} ?>
							<?php 
							if(get_post_meta($listingid ,'twitter',true)!=''){
								?>
								<li><a href="<?php echo esc_url(get_post_meta($listingid ,'twitter',true)); ?>"><i class="fab fa-twitter"></i></a></li>
								<?php  
							} ?>
								<?php 
							if(get_post_meta($listingid ,'instagram',true)!=''){
									?>
									<li><a href="<?php echo esc_url(get_post_meta($listingid ,'instagram',true)); ?>"><i class="fab fa-instagram"></i></a></li>
									<?php 
							} ?>
									<?php
							if(get_post_meta($listingid ,'linkedin',true)!=''){
										?>
										<li><a href="<?php echo esc_url(get_post_meta($listingid ,'linkedin',true)); ?>"><i class="fab fa-linkedin"></i></a></li>
										<?php 
							} ?>
							<?php if(array_key_exists('whatsapp',$active_single_fields_saved)){ 
											if(get_post_meta($listingid ,'whatsapp',true)!=''){
											?>
											<li><a href="<?php echo esc_url('https://api.whatsapp.com/send?phone=');?><?php echo esc_html(get_post_meta($listingid ,'whatsapp',true)); ?>"><i class="fab fa-whatsapp"></i></a></li> 
											<?php } 
							} ?>		
							</ul>
							</div>
							<?php } ?>
							<?php
								if ( array_key_exists( 'open_status', $active_single_fields_saved ) ) {
									$openStatus = listfoliopro_check_time( $listingid );
								?>
								<span class="card-time col-md-12 justify-content-center text-center mt-2 "><strong
								class="small-heading  <?php echo( $openStatus == 'Open Now' ? " open-green" : ' close-red' ) ?>"><?php echo esc_html( $openStatus ); ?>
								</strong>
								</span>
								<?php
								}
							?>
								
							<div class="col-md-6  d-flex justify-content-center text-center separator mt-4 mb-4">	
							</div>	
							
							
							
						</div>
						<?php
						if(array_key_exists('location',$active_single_fields_saved)){
							$tag_array = wp_get_object_terms($listingid, $listfoliopro_directory_url . '-locations');
							$locations = '';
							if(!empty($tag_array)){
						?>		
						<div class=" row mt-3">
							<div class="col-md-4  text-left   mb-1">	
								<?php esc_html_e( 'Location:', 'listfoliopro' ); ?>
							</div>	
							<div class="col-md-8    mb-1">									
								<div class="company-location text-right ">
								<?php include(listfoliopro_ep_template . '/listing/single-template/locations.php'); ?>
								</div>

							</div>
						</div>	
					<?php 
							}
						} 
					
					?>
					<?php if($company_email!=''){  ?>		
						<div class=" row mt-3">
							<div class="col-md-4  text-left   mb-1">	
								<?php esc_html_e( 'Email:', 'listfoliopro' ); ?>
							</div>	
							<div class="col-md-8    mb-1">									
								<div class="company-location text-right ">
									<a href="mailto:<?php echo esc_html($company_email); ?>" target="_blank"><?php echo esc_html($company_email); ?></a>
								</div>

							</div>
						</div>	
					<?php } ?>
					<?php if($company_phone!=''){  ?>		
						<div class=" row mt-3">
							<div class="col-md-4  text-left   mb-1">	
								<?php esc_html_e( 'Phone:', 'listfoliopro' ); ?>
								</div>	
							<div class="col-md-8    mb-1">									
								<div class="company-location text-right ">
								<a href="tel:<?php echo esc_html($company_phone); ?>" >	<?php echo esc_html($company_phone); ?></a>
								</div>

							</div>
						</div>	
					<?php } ?>
					<?php if($company_web!=''){  ?>		
						<div class=" row mt-3">							
							<div class="col-md-12  mb-1">									
								<div class="company-location text-center text-break">
									<a href="<?php echo esc_url($company_web); ?>" target="_blank"><?php echo esc_html($company_web); ?></a>
								</div>

							</div>
						</div>	
					<?php } ?>
					
					
					
					
					
					
					
														
					<div class=" row mt-4 mb-4">	
						<div class="booking-and-claim-button col-md-12 text-center">
						<?php
							if ( array_key_exists( 'booking_button', $active_single_fields_saved ) ) {
							?>
							<button class="pl-4 pr-4" type="button" onclick="listfoliopro_listing_booking_popup('<?php echo esc_html( $listingid ); ?>')"><?php esc_html_e( 'Book a Visit', 'listfoliopro' ); ?></button>
							<?php
							}
							
							
						?>
						</div>
					</div>
					
					
					
					
					
                </div>
					<?php
						if(array_key_exists('contact_button',$active_single_fields_saved)){ ?>
					<div class="box-white  p-4 mt-5 mb-4 ">
						<h2 class="mt-2 mb-4 m-2"><?php echo esc_html__("Contact Us",'listfoliopro'); ?></h2> 
					
						<?php include(listfoliopro_ep_template . '/listing/contact-form.php'); ?>
					
					</div>
					<?php } ?>
					<?php
						if(array_key_exists('similar-listing',$active_single_fields_saved)){ 
						$currentCategory = $main_class->listfoliopro_get_categories_caching($listingid, $listfoliopro_directory_url);
							$cat_name= (isset($currentCategory[0]->name) ? $currentCategory[0]->name : '') ;
							?>
						<div class="box-white--   mt-5 mb-4 ">
							<h2 class="mt-2 mb-4 m-2 text-break"><?php echo esc_html__("Similar ",'listfoliopro'). esc_html(ucwords($cat_name)); ?></h2> 
							
							<?php include(listfoliopro_ep_template . '/listing/single-template/single-style-1/similar-listings-round.php'); ?>
						
						</div>
						
						
					<?php } ?>
					
			
			</div>
		</div>
	</div>
</div>
					
					
<?php
	endwhile;
	wp_enqueue_script('popper', listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	
	wp_enqueue_script('listfoliopro_single-listing', listfoliopro_ep_URLPATH . 'admin/files/js/single-listing.js');
	wp_localize_script('listfoliopro_single-listing', 'listfoliopro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'listfoliopro' ),
	'Add_to_Favorites'=>esc_html__('Save', 'listfoliopro' ),
	'Added_to_Favorites'=>esc_html__('Saved', 'listfoliopro' ),
	'Please_put_your_message'=>esc_html__('Please put your detail', 'listfoliopro' ),
	'contact'=> wp_create_nonce("contact"),
	'listing'=> wp_create_nonce("listing"),
	'cv'=> wp_create_nonce("Doc/CV/PDF"),
	'listfoliopro_ep_URLPATH'=>listfoliopro_ep_URLPATH,
	'favorite_icon'=>$favorite_icon,
	) );
	
	
?>
<?php
	wp_reset_query();
	get_footer();
?>
									