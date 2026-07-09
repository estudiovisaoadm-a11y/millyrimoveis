<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_style('listfoliopro_listing_style_round', listfoliopro_ep_URLPATH . 'admin/files/css/archive-listing-grid-style-2-sharp.css');	

if(isset($no_map) AND $no_map=='no-map'){
	$grid_no_map='col-xl-4 col-md-6';
}else{
	$grid_no_map='col-xl-6 col-md-12';
}

$price=(get_post_meta( $id, 'discount', true )!=''? get_post_meta( $id, 'discount', true ): get_post_meta( $id, 'price', true ));
$data_not_for_middle_section=array();
$data_not_for_middle_section['title']='title';
$data_not_for_middle_section['price']='price';
$data_not_for_middle_section['top_search_form']='top_search_form';
$data_not_for_middle_section['image']='image';
$data_not_for_middle_section['location']='location';

$sort_data="";

if(is_array($fields_top_section_all)){
	foreach($fields_top_section_all  as $field_key => $field_value){
		if(in_array($field_key, $listfoliopro_top_sort_saved)){		
			if($field_key=='price'){
				$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($price) .' ' ; 
			}elseif($field_key==='category' OR  $field_key=='tag' OR $field_key=='locatins'){
				$terms = wp_get_post_terms($id, $listfoliopro_directory_url.'-'.$field_key);
				if (!empty($terms)) {
					$first_term='';
					$first_term = (isset($terms[0]->name)? $terms[0]->name:'');		
					if(!empty(trim($first_term))){ 
						$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($first_term) .' ' ;
					}
				}	
			}elseif($field_key=='title'){	
				$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($post->post_title) .' ' ; 
			}else{
				if(get_post_meta( $id, $field_key, true )!=''){
				$sort_data=$sort_data.'data-'.$field_key.'='.esc_html(get_post_meta( $id, $field_key, true )) .' ' ; 
				}
			}
		}
	}
}


?>


<div class="<?php echo esc_html($column_settings ); ?> mb-50 wow fadeInUp listingdata-col mix"   <?php echo esc_html($sort_data); ?>  id="<?php echo esc_html( $i ); ?>">
    <div class="listfoliopro-item-s2">
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
			<div class=" row location-date-wrapper mt-2 ">
				<?php
				
				
				foreach($active_archive_fields  as $field_key => $field_value){
					if(!in_array($field_key, $data_not_for_middle_section)){
						if($archive_field_label=='with_label'){
							$columns_fields="col-lg-6 col-md-6  col-6";
						}else{
							$columns_fields="col-lg-4 col-md-6  col-6";
						}
							
						if(get_post_meta( $id, $field_key, true )!=''){
						?>
						<div class="<?php echo esc_html($columns_fields); ?> location align-items-center no-gutter-right mb-2">
							<?php 
								$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, $field_key, 'archive' );
								
								if($saved_icon!=''){
									echo '<img class="property-icon-size" src="'.esc_url($saved_icon).'">';
								}?>	
								<?php
								if($archive_field_label=='with_label'){
									if(isset($field_set[$field_key])){
									?>
										<span class="pl-1"><?php echo esc_html($field_set[$field_key]); ?>.</span>
									<?php
									}
								}
								?>
								<?php echo esc_html(get_post_meta( $id, $field_key, true )); ?>								
								
								<?php if($field_key=='area'){ ?>
								<span class="pl-1">
									<?php echo esc_html(get_post_meta( $id, 'area_prefix_text', true )); ?>
								</span> 
								<?php
								}
								?>
								
						 </div>
						 <?php
						}
						 ?>
					<?php
					}
				}
				?>	 
			 </div>
           
			<div class="listfoliopro-listing-price listing-desc">
			<?php if ( isset( $active_archive_fields['price'] ) ) { ?>
            <?php
            if ( get_post_meta( $id, 'price', true ) != '' or get_post_meta( $id, 'discount', true ) != '' ) {
	            ?>
                
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
	            <?php
					}          
				} ?>
			
			<a  class="button-right"  href="#"><img src="<?php echo esc_url(listfoliopro_ep_URLPATH.'admin/files/css/images/arrow-up-right.svg');?> " alt="arrow up"></a>
			 </div>
        </div>

    </div>
</div>
