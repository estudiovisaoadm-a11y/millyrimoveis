<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(isset($no_map) AND $no_map=='no-map'){
	$grid_no_map='col-xl-4 col-md-6';
}else{
	$grid_no_map='col-xl-6 col-md-12';
}

?>
<div class="<?php echo esc_html($grid_no_map); ?>   col-sm-12 col-12 listingdata-col" id="<?php echo esc_html( $i ); ?>">
    <div class="listfoliopro-listing-item">
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
				if ( get_post_meta( $id, 'listfoliopro_featured', true ) == 'featured' ) {
					?>
                    <label class="btn-urgent-right"><?php esc_html_e( 'Featured', 'listfoliopro' ); ?></label>
					<?php
				}
				?>
				<?php
				if ( isset( $active_archive_fields['favorite'] ) ) {
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
				}
				?>
            </div>
			<?php
		}
		?>
        <div class="card-body">
            <div class="first-category-and-rating">
				<?php
				if ( isset( $active_archive_fields['category'] ) ) { ?>
                <div class="list-fast-cat">
	                <?php

	                $categories = get_the_terms(get_the_ID(), 'listing-category');

	                if (!empty($categories)) {
		                // Display only the first category
		                $first_category = $categories[0];
		                echo '<a href="' . esc_url(get_term_link($first_category)) . '"><img src="' . listfoliopro_ep_URLPATH . 'assets/images/building-07.svg" alt="icon">' . esc_html($first_category->name) . '</a>';

	                }
	                ?>
                </div>
				<?php
				}
				?>
				<?php
				if ( isset( $active_archive_fields['review'] ) ) { ?>
                <div class="review-count">
	                <?php
	                $post_type = 'listfoliopro_review';
	                $total_review_point = 0;
	                $sql = $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type ='listfoliopro_review' and post_author='%s' and post_status='publish' ORDER BY ID DESC", $id);
	                $author_reviews = $wpdb->get_results($sql);
	                $total_reviews = count($author_reviews);

	                $avg_review = 0;
	                if ($total_reviews > 0) {
		                foreach ($author_reviews as $review) {
			                $review_val2 = (float) get_post_meta($review->ID, 'review_value', true);
			                $total_review_point += $review_val2;
		                }

		                $avg_review = number_format($total_review_point / $total_reviews, 2, '.', '');
	                }

	                // Ensure it always displays two decimal places, even if they are zeros
	                $avg_review = sprintf("%.2f", $avg_review);

	                $saved_listing_avg_rating = get_post_meta($id, 'review', true);
	                if ($avg_review != $saved_listing_avg_rating) {
		                update_post_meta($id, 'review', $avg_review);
	                }
	                ?>

                    <div class="review-wrapper">
                        <div class="star-icon">
                            <i class="fas fa-star line-height2"></i>
                        </div>

                        <div class="listing-review">
                            <div class="review-point"><?php echo esc_html__($avg_review);?></div>
                            <div class="total-review">( <?php echo esc_html__($total_reviews);?> )</div>
                        </div>
                    </div>
                </div>
				<?php
				}
				?>
		   
		   </div>
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
				<?php if ( isset( $active_archive_fields['post_date'] ) ) { ?>	
                <div class="listing-date">
                    <i class="fa fa-clock"></i><?php echo get_the_date( 'd M-Y ', $id ); ?>
                </div>
				<?php } ?>
            </div>

			<?php if ( isset( $active_archive_fields['description'] ) ) { ?>	
            <div class="listing-desc">
                <?php echo wp_trim_words(get_the_content($id), 15, '...');?>
            </div>
			<?php } ?>
			<?php if ( isset( $active_archive_fields['price'] ) ) { ?>
            <?php
            if ( get_post_meta( $id, 'price', true ) != '' or get_post_meta( $id, 'discount', true ) != '' ) {
	            ?>
                <div class="listfoliopro-listing-price">
		            <?php if ( get_post_meta( $id, 'discount', true ) != '' ) { ?>
                        <strike class="listfoliopro-main-price"><?php echo esc_html( get_post_meta( $id, 'price', true ) ); ?></strike>
                        <span class="listfoliopro-discount-price"><?php echo esc_html( get_post_meta( $id, 'discount', true ) ); ?></span>
			            <?php
		            } else { ?>
			            <?php echo esc_html( get_post_meta( $id, 'price', true ) ); ?>
			            <?php
		            }
		            ?>
                </div>
	            <?php
					}
            ?>
			<?php } ?>
			<?php if ( isset( $active_archive_fields['open_status'] ) ) { 
					$openStatus='';
					$openStatus = listfoliopro_check_time($id);
				?>	
					<strong class="small-heading  <?php echo($openStatus=='Open Now'?" open-green":' close-red') ?>"><?php echo esc_html($openStatus) ; ?></strong>
		   <?php } ?>
        </div>

    </div>
</div>
