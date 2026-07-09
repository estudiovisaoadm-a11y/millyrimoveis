<div class="<?php echo esc_attr($column);?> listingdata-col mix" <?php echo esc_html($sort_data); ?>id="<?php echo esc_html( $i ); ?>">
<div class="listfoliopro-listing-item">													
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
			$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, 'favorite', 'archive' );
			if ( $saved_icon == '' ) {
				$saved_icon = 'fa-regular fa-heart';
			}
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
		?>
		<?php
			if ( get_post_meta( $id, 'listfoliopro_featured', true ) == 'featured' ) {
			?>
			<label class="btn-urgent-bottom"><?php esc_html_e( 'Featured', 'listfoliopro' ); ?></label>
			<?php
			}
		?>
	</div>
	<div class="card-body">		   
		<div class="listing-title">
			<a href="<?php echo get_permalink( $id ); ?>" class="">
				<?php echo esc_html( $post->post_title ); ?>
			</a>
		</div>
		<div class="location-date-wrapper">
			<?php if ( isset( $settings['enable_location'] ) AND $settings['enable_location']=='yes' ) { ?>
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
																	
				if(isset($settings['grid_fields_name']) ){
					foreach ($settings['grid_fields_name'] as $form_field){
						if(!empty($form_field['field_name_grid'])){
						
						$field_key= $form_field['field_name_grid'];
						if(get_post_meta( $id, $field_key, true )!=''){																
						if($form_field['enable_label']=='yes'){
							$columns_fields="col-lg-6 col-md-6  col-6";
						}else{
							$columns_fields="col-lg-4 col-md-6  col-6";
						}
						?>
						<div class="<?php echo esc_html($columns_fields); ?> location align-items-center no-gutter-right mb-2">
							<?php 
								$saved_icon = listfoliopro_get_icon( $active_archive_icon_saved, $field_key, 'archive' );
								
								if($saved_icon!=''){
									echo '<img class="property-icon-size " src="'.esc_url($saved_icon).'">';
								}?>
								<?php
								if($form_field['enable_label']=='yes'){
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
						}	
						
					}
				}
		?>	
		</div>
		<?php 
		
		
		if ( isset( $settings['enable_price'] ) And $settings['enable_price']=='yes' ) { ?>
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
					<a  class="button-right"  href="<?php echo esc_url(get_the_permalink($id)); ?>"><img src="<?php echo esc_url(listfoliopro_ep_URLPATH.'admin/files/css/images/arrow-up-right.svg');?> " alt="arrow up"></a>
				</div>
				<?php
				}
			?>
		<?php } ?>
	</div>
</div>
</div>
