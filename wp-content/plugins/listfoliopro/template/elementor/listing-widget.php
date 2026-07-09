<?php
namespace Elementor;

class ListfolioPro_Listing_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_listing_widget';
	}

	public function get_title() {
		return esc_html__( 'Listing', 'listfoliopro' );
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
			'listingtype',
			[
				'label'       => __( 'Listing Type', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_listing_type(),
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
			'excerpt_lenth',
			[
				'label'     => __( 'Excerpt Lenth', 'listfoliopro' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => '',
				'step'      => 1,
				'default'   => 16,
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
		$active_archive_icon_saved=get_option('listfoliopro_archive_icon_saved' );
		global $wpdb;
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
		if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
		?>

        <div class="bootstrap-wrapper listing-wrapper">
            <div class="container">
                <div class="row">
	                <?php
					$args = array(
					'post_type' 		=> $listfoliopro_directory_url, 
					'paged' 			=> $paged,
					'post_status' 		=> 'publish',
					'posts_per_page'  	=> $settings['listing_count'],				
					);
					$listing_categories=null;
	                if ( ! empty( $settings['category'] ) ) {
						$args[$listfoliopro_directory_url.'-category']=$settings['category'];
	                }
					if ( ! empty( $settings['listingtype'] ) ) {
						$args[$listfoliopro_directory_url.'-type']=$settings['listingtype'];
	                }
					
					$listing_query = new \WP_Query($args);
	                while ( $listing_query->have_posts() ) : $listing_query->the_post();
		                $id = get_the_ID();

		                if(has_post_thumbnail()){
			                $feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
			                if(isset($feature_image[0])){
				                $feature_img =$feature_image[0];
			                }
		                }else{
			                $feature_img= '';
		                }
		                ?>
                        <div class="<?php echo esc_attr($column);?>">
                            <div class="single-listing-item">
                                <div class="listing-thumb-features-fav-icon-wrapper">
                                    <a class="listing-thumbnail-image" href="<?php echo get_the_permalink( get_the_ID() ); ?>" style="background-image: url(<?php echo esc_url( $feature_img );?>)"></a>

                                    <div class="features-fav-info">
		                                <?php
		                                if ( get_post_meta( $id, 'listfoliopro_featured', true ) == 'featured' ) {
			                                ?>
                                            <label class="featured-text"><?php esc_html_e( 'Featured', 'listfoliopro' ); ?></label>
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
                                </div>

                                <div class="listing-content-wrapper">
                                    <a href="<?php echo get_permalink( $id ); ?>" class="listing-title">
                                        <?php echo get_the_title(); ?>
                                    </a>

                                    <div class="rating-price-category">
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

                                        <div class="price">
		                                    <?php
		                                    if ( get_post_meta( $id, 'price', true ) != '' or get_post_meta( $id, 'discount', true ) != '' ) {
			                                    ?>
                                                <div class="listfoliopro-listing-price">
                                                    <div class="price-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M14.6666 6.66665H1.33331M7.33331 9.33331H3.99998M1.33331 5.46665L1.33331 10.5333C1.33331 11.28 1.33331 11.6534 1.47864 11.9386C1.60647 12.1895 1.81044 12.3935 2.06133 12.5213C2.34654 12.6666 2.71991 12.6666 3.46665 12.6666L12.5333 12.6666C13.2801 12.6666 13.6534 12.6666 13.9386 12.5213C14.1895 12.3935 14.3935 12.1895 14.5213 11.9386C14.6666 11.6534 14.6666 11.28 14.6666 10.5333V5.46665C14.6666 4.71991 14.6666 4.34654 14.5213 4.06133C14.3935 3.81044 14.1895 3.60647 13.9386 3.47864C13.6534 3.33331 13.2801 3.33331 12.5333 3.33331L3.46665 3.33331C2.71991 3.33331 2.34654 3.33331 2.06133 3.47864C1.81044 3.60647 1.60647 3.81044 1.47864 4.06133C1.33331 4.34654 1.33331 4.71991 1.33331 5.46665Z" stroke="#7D946A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
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

                                        <div class="list-fast-cat">
                                            <div class="cat-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                    <path d="M5.00001 7.33333H3.06668C2.69331 7.33333 2.50662 7.33333 2.36402 7.406C2.23858 7.46991 2.13659 7.5719 2.07267 7.69734C2.00001 7.83995 2.00001 8.02663 2.00001 8.4V14M11 7.33333H12.9333C13.3067 7.33333 13.4934 7.33333 13.636 7.406C13.7614 7.46991 13.8634 7.5719 13.9273 7.69734C14 7.83995 14 8.02663 14 8.4V14M11 14V4.13333C11 3.3866 11 3.01323 10.8547 2.72801C10.7269 2.47713 10.5229 2.27316 10.272 2.14532C9.98678 2 9.61341 2 8.86668 2H7.13334C6.38661 2 6.01324 2 5.72802 2.14532C5.47714 2.27316 5.27317 2.47713 5.14533 2.72801C5.00001 3.01323 5.00001 3.3866 5.00001 4.13333V14M14.6667 14H1.33334M7.33334 4.66667H8.66668M7.33334 7.33333H8.66668M7.33334 10H8.66668" stroke="#7D946A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
		                                    <?php

		                                    $categories = get_the_terms(get_the_ID(), $listfoliopro_directory_url.'-category');

		                                    if (!empty($categories)) {
			                                    // Display only the first category
			                                    $first_category = $categories[0];
			                                    echo '<a href="' . get_term_link($first_category) . '">' . $first_category->name . '</a>';
		                                    }
		                                    ?>
                                        </div>
                                    </div>

                                    <div class="listing-excerpt">
		                                <?php echo wp_trim_words(get_the_content($id), 23, '...');?>
                                    </div>

                                    <div class="listing-location">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M8.00002 14.6666C8.66669 11.3333 13.3334 10.9455 13.3334 6.66665C13.3334 3.72113 10.9455 1.33331 8.00002 1.33331C5.0545 1.33331 2.66669 3.72113 2.66669 6.66665C2.66669 10.9455 7.33335 11.3333 8.00002 14.6666Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.00002 8.66665C9.10459 8.66665 10 7.77122 10 6.66665C10 5.56208 9.10459 4.66665 8.00002 4.66665C6.89545 4.66665 6.00002 5.56208 6.00002 6.66665C6.00002 7.77122 6.89545 8.66665 8.00002 8.66665Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
		                                <?php echo get_the_term_list($id, $listfoliopro_directory_url.'-locations', '', ', ', ''); ?>
                                    </div>
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

Plugin::instance()->widgets_manager->register( new ListfolioPro_Listing_Widget );