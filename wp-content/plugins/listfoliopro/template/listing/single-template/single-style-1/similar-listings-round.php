<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	if(!isset($listingid)){$listingid=0;}
	if(!isset($single_page_icon_saved)){$single_page_icon_saved=get_option('listfoliopro_single_icon_saved' );}
	wp_enqueue_style('listfoliopro_listing_style_sharp', listfoliopro_ep_URLPATH . 'admin/files/css/archive-listing-grid-style-1.css');	
	$cat_slug= (isset($currentCategory[0]->slug) ? $currentCategory[0]->slug : '') ;
	
	
	$args = array(
	'post_type' => $listfoliopro_directory_url, // enter your custom post type
	'paged' => '1',
	'post_status' => 'publish',
	 'orderby'       => 'rand',
	'posts_per_page'=> '3',  // overrides posts per page in theme settings
	);
	
	$listfoliopro_similar = get_posts(array(
    'posts_per_page'   => 3,
    'post_type'     => $listfoliopro_directory_url,
    'post__not_in'  => array(esc_html($listingid)),
    'post_status'   => 'publish',
    'orderby'       => 'rand',
    'tax_query'     => array(
        array(
            'taxonomy' => $listfoliopro_directory_url.'-category', 
            'field'    => 'slug',
            'terms'    => $cat_slug,
        ),
    ),
));
$main_class = new listfoliopro_eplugins;
$defaul_feature_img= $main_class->listfoliopro_listing_default_image();	
$active_archive_fields=listfoliopro_get_archive_fields_all();
$listfoliopro_similar = new WP_Query( $args );
?>

	<?php
		
			$i=0;$company_logo_sim='';
			if ( $listfoliopro_similar->have_posts() ) :
				while ( $listfoliopro_similar->have_posts() ) : $listfoliopro_similar->the_post();
				 $similar_id = get_the_ID();				
				$feature_img='';
				if(has_post_thumbnail()){ 
					$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $similar_id ), 'large' );
					if(isset($feature_image[0])){
						$feature_img =$feature_image[0];
					}
					}else{ 
					$feature_img = $defaul_feature_img;
				}
				$post_author_id= get_post_field('post_author', $similar_id);
			$current_date=time();
			$dir_number_format=get_option('dir_number_format');	
			if($dir_number_format==""){$dir_number_format='usa';}
			?>	
			
<div class="col-md-12  mb-3" >
    <div class="listfoliopro-listing-item similar-block-round auto-height">
	   
		<?php
		$listing_contact_source = get_post_meta( $id, 'listing_contact_source', true );
		if ( $listing_contact_source == '' ) {
			$listing_contact_source = 'user_info';
		}
		if ( $listing_contact_source == 'new_value' ) {
			$company_name    = get_post_meta( $id, 'company_name', true );
			$company_address = get_post_meta( $id, 'address', true );
			$company_web     = get_post_meta( $id, 'contact_web', true );
			$company_phone   = get_post_meta( $id, 'phone', true );
			$company_email   = get_post_meta( $id, 'contact-email', true );

		} else {
			$company_name    = get_user_meta( $post_author_id, 'full_name', true );
			$company_address = get_user_meta( $post_author_id, 'address', true );
			$company_web     = get_user_meta( $post_author_id, 'website', true );
			$company_phone   = get_user_meta( $post_author_id, 'phone', true );
			$company_logo    = get_user_meta( $post_author_id, 'listfoliopro_profile_pic_thum', true );
			$user_info       = get_userdata( $post_author_id );
			$company_email   = $user_info->user_email;
		}
		
		
		if ( isset( $active_archive_fields['image'] ) ) {
			?>
            <div class="card-img-container">
                <a href="<?php echo get_the_permalink( $id ); ?>">
                    <img src="<?php echo esc_html( $feature_img ); ?>" class="card-img-top-listing">
                </a>
				<?php
				if ( get_post_meta( $id, 'property_status', true ) != '' ) {
					?>
                    <label class="btn-urgent-right"><?php echo esc_html(get_post_meta( $id, 'property_status', true )); ?> </label>
					<?php
				}
				?>
				<?php
				if ( isset( $active_archive_fields['favorite'] ) ) {
						$saved_icon = 'fa-regular fa-heart';
					$user_ID    = get_current_user_id();
					$favourites = 'no';
					if ( $user_ID > 0 ) {
						$my_favorite = get_post_meta( $id, '_favorites', true );
						$all_users   = explode( ",", $my_favorite );
						if ( in_array( $user_ID, $all_users ) ) {
							$favourites = 'yes';
						}
					}
					if ( $favourites != 'yes' ) {
						?>
                        <label class="btn-urgent-left btn-add-favourites listingbookmark"
                               id="listingbookmark<?php echo esc_html( $id ); ?>"><i
                                    class="fa-regular fa-heart"></i></label>
						<?php
					} else {
						?>
                        <label class="btn-urgent-left btn-added-favourites listingbookmark"
                               id="listingbookmark<?php echo esc_html( $id ); ?>"><i
                                    class="fa-solid fa-heart"></i></label>
						<?php
					}
				}
				?>
				<?php
					if ( get_post_meta( $id, 'listfoliopro_featured', true ) == 'featured' ) {
					?>
					<label class="btn-urgent-bottom"><?php esc_html_e( 'Featured', 'listfoliopro' ); ?></label>
					<?php
					}
				?>
            </div>
			<?php
		}
		?>
        <div class="card-body">		   
			<?php if ( isset( $active_archive_fields['title'] ) ) { ?>
            <div class="listing-title">
                <a href="<?php echo get_permalink( $id ); ?>" class="">
		            <?php echo esc_html( $post->post_title ); ?>
                </a>
            </div>
			<?php } ?>
            <div class="location-date-wrapper">
				<?php if ( isset( $active_archive_fields['location'] ) ) { ?>
                <div class="location">

	                <?php
	                $term_list = get_the_term_list($id, 'listing-locations', '', ', ', '');

	                if (!is_wp_error($term_list)) {
		                $terms = wp_get_post_terms($id, 'listing-locations');

		                if (!empty($terms)) {
			                $first_term = $terms[0]->name;
			                $term_link = get_term_link($terms[0]);

			                echo '<a href="' . esc_url($term_link) . '">' . esc_html($first_term) . '</a>';
		                }
	                }
	                ?>
                </div>
					<?php } ?>
				
            </div>
			<div class=" row location-date-wrapper mt-2">
				<?php
				if(get_post_meta( $id, 'area', true )!=''){
				?>
				<div class="col-lg-4 col-md-12  location align-items-center">
					<?php 
						$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, 'area', 'archive' );
						
						if($saved_icon!=''){
							echo '<img class="mr-1 property-icon-size" src="'.esc_url($saved_icon).'">';
						}?>
					
					<?php echo esc_html(get_post_meta( $id, 'area', true )); ?><span class="ml-1"><?php echo esc_html(get_post_meta( $id, 'area_prefix_text', true )); ?></span> 
				 </div>
				 <?php
				}
				 ?>
				 <?php
				if(get_post_meta( $id, 'bed', true )!=''){
				?>
				 <div class="col-lg-4 col-md-12 location align-items-center">
					<?php 
						$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, 'bed', 'archive' );
						if($saved_icon!=''){
							echo '<img class="mr-1 property-icon-size" src="'.esc_url($saved_icon).'">';
						}?>
					
					<?php echo esc_html(get_post_meta( $id, 'bed', true ));?><span class="ml-1"><?php echo esc_html((isset($field_set['bed'])? $field_set['bed']:''));?></span>
				 </div>
				 <?php
				}
				 ?>
				 <?php
				if(get_post_meta( $id, 'bath', true )!=''){
				?>
				<div class="col-lg-4 col-md-12 location align-items-center">
					<?php 
						$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, 'bath', 'archive' );
						if($saved_icon!=''){
							echo '<img class="mr-1 property-icon-size" src="'.esc_url($saved_icon).'">';
						}?>
					
					<?php echo esc_html(get_post_meta( $id, 'bath', true ));?><span class="ml-1"><?php echo esc_html((isset($field_set['bath'])? $field_set['bath']:''));?></span>
				 </div>
				<?php
				}
				?>
				 
			 </div>
           
			
			<?php if ( isset( $active_archive_fields['price'] ) ) { ?>
            <?php
            if ( get_post_meta( $id, 'price', true ) != '' or get_post_meta( $id, 'discount', true ) != '' ) {
	            ?>
                <div class="listfoliopro-listing-price listing-desc">
					<span class="pull-left">
		            <?php if ( get_post_meta( $id, 'discount', true ) != '' ) { ?>
                        <strike class="listfoliopro-main-price"><?php  echo esc_html( listfoliopro_get_price(get_post_meta( $id, 'price', true ),$id,$dir_number_format)); ?></strike>
                        <span class="listfoliopro-discount-price"><?php echo esc_html( listfoliopro_get_price(get_post_meta( $id, 'discount', true ),$id,$dir_number_format)); ?></span>
			            <?php
		            } else { ?>
			            <?php echo esc_html( listfoliopro_get_price(get_post_meta( $id, 'price', true ),$id, $dir_number_format));  ?>
			            <?php
		            }
		            ?>
					</span>
					
						
					
                </div>
	            <?php
					}
            ?>
			<?php } ?>
			
        </div>

    </div>
			</div>
		

			
			
			<?php
			endwhile;
		 endif; 
	
	wp_reset_query();
?>