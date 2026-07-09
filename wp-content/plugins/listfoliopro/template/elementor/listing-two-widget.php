<?php
namespace Elementor;

class ListfolioPro_Listing_Two_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_listing_two_widget';
	}

	public function get_title() {
		return esc_html__( 'Listing Two', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'listing_options',
			[
				'label' => esc_html__( 'Listing Options', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'listing_count',
			[
				'label'   => __( 'Number Of Listing To Show', 'listfoliopro' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => __( 'Categories', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_listing_categories(),
			]
		);

        $this->add_control(
            'pagination',
            [
                'label'     => esc_html__( 'Enable Pagination', 'listfoliopro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
                'label_off' => esc_html__( 'No', 'listfoliopro' ),
                'default'   => 'no',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'listing_layout_settings',
			[
				'label' => __( 'Layout', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_col',
			[
				'label'   => __( 'Columns On Desktop', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-4',
				'options' => [
					'col-xl-12' => __( '1 Column', 'listfoliopro' ),
					'col-xl-6'  => __( '2 Column', 'listfoliopro' ),
					'col-xl-4'  => __( '3 Column', 'listfoliopro' ),
					'col-xl-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'iPad_pro_col',
			[
				'label'   => __( 'Columns On iPad Pro', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-6',
				'options' => [
					'col-lg-12' => __( '1 Column', 'listfoliopro' ),
					'col-lg-6'  => __( '2 Column', 'listfoliopro' ),
					'col-lg-4'  => __( '3 Column', 'listfoliopro' ),
					'col-lg-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'tab_col',
			[
				'label'   => __( 'Columns On Tab', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-sm-6',
				'options' => [
					'col-sm-12' => __( '1 Column', 'listfoliopro' ),
					'col-sm-6'  => __( '2 Column', 'listfoliopro' ),
					'col-sm-4'  => __( '3 Column', 'listfoliopro' ),
					'col-sm-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => __( 'Show First Category Name', 'listfoliopro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label'   => __( 'Excerpt', 'listfoliopro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'     => __( 'Excerpt Lenth', 'listfoliopro' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => '',
				'step'      => 1,
				'default'   => 14,
				'condition' => [
					'show_excerpt' => 'yes',
				]
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$column = $settings['desktop_col'] . ' ' . $settings['iPad_pro_col'] . ' ' . $settings['tab_col'];
		$main_class = new \listfoliopro_eplugins;
		$active_archive_icon_saved=get_option('listfoliopro_archive_icon_saved' );
		global $post,$wpdb;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
		?>

        <div class="bootstrap-wrapper listing-wrapper">
            <div class="container">
                <div class="row">
	                <?php
	                if ( ! empty( $settings['category'] ) ) {
		                $listing_query = new \WP_Query( array(
			                'post_type'           => $listfoliopro_directory_url,
			                'posts_per_page'      => $settings['listing_count'],
			                'ignore_sticky_posts' => 1,
			                'paged' => $paged,
			                'tax_query'           => array(
				                array(
					                'taxonomy' => $listfoliopro_directory_url.'-category',
					                'terms'    => $settings['category'],
					                'field'    => 'slug',
				                )
			                )
		                ) );
	                } else {

		                $listing_query = new \WP_Query(
			                array(
				                'posts_per_page'      => $settings['listing_count'],
				                'post_type'           => 'listing',
				                'paged' => $paged,
			                )
		                );
	                }
	                while ( $listing_query->have_posts() ) : $listing_query->the_post();
		                $id = get_the_ID();
		                $post_author_id= get_post_field( 'post_author', $id );

		                if(has_post_thumbnail()){
			                $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
			                if(isset($feature_image[0])){
				                $feature_img =$feature_image[0];
			                }
		                }else{
			                $feature_img= '';
		                }
		                ?>
                        <div class="listingdata-col <?php echo esc_attr($column);?>">

                            <div class="single-listing-two-item">
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

		                        ?>
                                <div class="listing-image-wrapper">
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
                                        <label class="fev-btn btn-add-favourites listingbookmark"
                                               id="listingbookmark<?php echo esc_html( $id ); ?>"><i class="fa-regular fa-heart"></i></label>
		                                <?php
	                                } else {
		                                ?>
                                        <label class="fev-btn btn-added-favourites listingbookmark"
                                               id="listingbookmark<?php echo esc_html( $id ); ?>"><i class="fa-solid fa-heart"></i></label>
		                                <?php
	                                }
	                                ?>
                                </div>

                                <div class="card-body">
                                    <div class="first-category-and-rating">
                                        <?php if ($settings['show_category'] == 'yes') : ?>
                                        <div class="list-fast-cat">
					                        <?php

					                        $categories = get_the_terms(get_the_ID(), $listfoliopro_directory_url.'-category');

					                        if (!empty($categories)) {
						                        // Display only the first category
						                        $first_category = $categories[0];
						                        echo '<a href="' . esc_url(get_term_link($first_category)) . '"><img src="' . listfoliopro_ep_URLPATH . 'assets/images/building-07.svg" alt="icon">' . esc_html($first_category->name) . '</a>';

					                        }
					                        ?>
                                        </div>
                                        <?php endif; ?>

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
                                                    <i class="fas fa-star"></i>
                                                </div>

                                                <div class="listing-review">
                                                    <div class="review-point"><?php echo esc_html__($avg_review);?></div>
                                                    <div class="total-review">( <?php echo esc_html__($total_reviews);?> )</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="listing-title">
                                        <a href="<?php echo get_permalink( $id ); ?>" class="">
					                        <?php echo esc_html( $post->post_title ); ?>
                                        </a>
                                    </div>

                                    <div class="location-date-wrapper">
                                        <div class="listing-location">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8.00002 14.6666C8.66669 11.3333 13.3334 10.9455 13.3334 6.66665C13.3334 3.72113 10.9455 1.33331 8.00002 1.33331C5.0545 1.33331 2.66669 3.72113 2.66669 6.66665C2.66669 10.9455 7.33335 11.3333 8.00002 14.6666Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.00002 8.66665C9.10459 8.66665 10 7.77122 10 6.66665C10 5.56208 9.10459 4.66665 8.00002 4.66665C6.89545 4.66665 6.00002 5.56208 6.00002 6.66665C6.00002 7.77122 6.89545 8.66665 8.00002 8.66665Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
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

                                        <div class="listing-date">
                                            <i class="fa fa-clock"></i><?php echo get_the_date( 'd F Y ', $id ); ?>
                                        </div>
                                    </div>

                                    <?php if($settings['show_excerpt'] == 'yes') :?>
                                    <div class="listing-desc">
				                        <?php echo wp_trim_words(get_the_content($id), $settings['excerpt_length'], '...');?>
                                    </div>
                                    <?php endif; ?>

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

                                </div>

                            </div>

                        </div>
	                <?php
	                endwhile;
	                wp_reset_query();
	                ?>
                </div>

                <?php if($settings['pagination'] == 'yes') : ?>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="post-pagination">
			                <?php
			                $GLOBALS['wp_query']->max_num_pages = $listing_query->max_num_pages;
			                the_posts_pagination(array(
				                'next_text' => '<i class="fas fa-angle-double-right"></i>',
				                'prev_text' => '<i class="fas fa-angle-double-left"></i>',
				                'screen_reader_text' => ' ',
				                'type'                => 'list'
			                ));
			                ?>
                        </div>
                    </div>
                </div>

                <?php endif; ?>
            </div>



	        <?php
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
		        'dirwpnonce'=> wp_create_nonce("myaccount"),
		        'listing'=> wp_create_nonce("listing"),
		        'cv'=> wp_create_nonce("Doc/CV/PDF"),
		        'listfoliopro_ep_URLPATH'=>listfoliopro_ep_URLPATH,
	        ) );

	        ?>
        </div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Listing_Two_Widget );