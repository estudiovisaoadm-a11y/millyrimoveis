<?php
namespace Elementor;
use WP_Query;
use WP_User_Query;
class HiJobs_Job_Of_The_Day extends Widget_Base {

	public function get_name() {

		return 'hijobs_job_of_the_day';
	}

	public function get_title() {
		return esc_html__( 'Job Of The Day', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'tab_content_settings',
			[
				'label' => esc_html__( 'Tabs', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'job_categories',
			[
				'label'       => __( 'Categories', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => ep_hijobs_job_categories(),
			]
		);

		$this->add_control(
			'open_by_default',
			[
				'label'       => esc_html__('Open By Default', 'hijobs-core'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 1,
				'description' => esc_html__('Which tab you want to open by default.', 'hijobs-core'),
			]
		);

		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Number Of Post To Show', 'hijobs-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 6,
			]
		);

        $this->add_control(
            'bottom_text',
            [
                'label'       => __( 'Bottom Text', 'themedraft-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => 'Do you want to post a job for your company? <a href="#">We can help. Click here</a>',
            ]
        );

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$td_tab_id = rand(10, 10000);
		$taxonomy = 'job-category';
		?>

		<div class="ep-job-of-the-day-wrapper">
            <div class="nav nav-tabs" role=tablist>
                <?php
                if ($settings['job_categories']) {
                    $menu_count = 0;
                    foreach ($settings['job_categories'] as $job_category) {
                        $menu_count++;
	                    $category_name = get_term_by( 'slug', $job_category, $taxonomy );
	                    $term_id      = get_term_by( 'slug', $job_category, $taxonomy )->term_id;
	                    $term_icon = get_term_meta( $term_id, 'jobbank_term_icon', true );
                        ?>
                        <button class="nav-link <?php if($menu_count == $settings['open_by_default']){ echo 'active';}?>" data-bs-toggle="tab" data-bs-target="#ep-tab-number-<?php echo esc_attr($td_tab_id.$menu_count);?>" type="button" role="tab">
                            <i class="<?php echo esc_attr($term_icon);?>"></i>
	                        <?php echo esc_html($category_name->name); ?>
                        </button>
                    <?php }
                }
                ?>
            </div>

            <div class="tab-content job-post-by-category-wrapper">
                <?php
                wp_enqueue_script('jobbank_single-listing', ep_jobbank_URLPATH . 'admin/files/js/single-listing.js');
                wp_localize_script('jobbank_single-listing', 'jobbank_data', array(
	                'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	                'current_user_id'	=>get_current_user_id(),
	                'Please_login'=>esc_html__('Please login', 'jobbank' ),
	                'Add_to_Favorites'=>esc_html__('Save', 'jobbank' ),
	                'Added_to_Favorites'=>esc_html__('Saved', 'jobbank' ),
	                'contact'=> wp_create_nonce("contact"),
                ) );
                if ($settings['job_categories']) {
                    $content_count = 0;
                    foreach ($settings['job_categories'] as $job_content) {
                        $content_count++;
                        $category_slug = get_term_by( 'slug', $job_content, $taxonomy );
                        ?>
                        <div class="ep-tab-item tab-pane fade <?php if($content_count == $settings['open_by_default'] ){ echo 'active show';}?>" id="ep-tab-number-<?php echo esc_attr($td_tab_id.$content_count);?>" role="tabpanel">
                            <?php
                            $post_query = new WP_Query( array(
                                'post_type'           => 'job',
                                'posts_per_page'      => $settings['post_count'],
                                'tax_query'           => array(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'terms'    => $category_slug->slug,
                                        'field'    => 'slug',
                                    )
                                )
                            ) );?>

                            <div class="row">
                                <?php
                                while ( $post_query->have_posts() ) : $post_query->the_post();
	                                $job_id = get_the_ID();
	                                $company_image = wp_get_attachment_image_src( get_post_thumbnail_id( $job_id ), 'large' );
                                ?>

                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="ep-single-job-by-category">

                                            <div class="ep-job-top-info">
                                                <div class="ep-save-job">
	                                                <?php
	                                                $active_archive_fields=jobbank_get_archive_fields_all();
	                                                $active_archive_icon_saved=get_option('jobbank_archive_icon_saved' );

                                                    if(isset($active_archive_fields['favorite'])){
		                                                $saved_icon= jobbank_get_icon($active_archive_icon_saved, 'favorite','archive');
		                                                if($saved_icon==''){
			                                                $saved_icon='far fa-heart';
		                                                }

		                                                $user_ID = get_current_user_id();
		                                                $favourites='no';
		                                                if($user_ID>0){
			                                                $my_favorite = get_post_meta($job_id,'_favorites',true);
			                                                $all_users = explode(",", $my_favorite);
			                                                if (in_array($user_ID, $all_users)) {
				                                                $favourites='yes';
			                                                }
		                                                }
		                                                if($favourites!='yes'){?>
                                                            <label title='save' class="btn-add-favourites jobbookmark" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Save','jobbank'); ?></label>
			                                                <?php
		                                                }else{
			                                                ?>
                                                            <label title='saved' class="btn-added-favourites jobbookmark" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Saved','jobbank'); ?></label>
			                                                <?php
		                                                }
	                                                }
	                                                ?>
                                                </div>

                                                <div class="company-logo" style="background-image: url(<?php echo esc_url($company_image[0]);?>)"></div>

                                                <div class="top-info-content">
	                                                <span class="ep-company-name ep-primary-color"><?php echo get_post_meta($job_id,'company_name',true);?></span>

                                                    <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-job-url">
                                                        <h4 class="ep-job-title"><?php echo get_the_title();?></h4>
                                                    </a>
                                                </div>

                                                <div class="ep-job-location">
	                                                <i class="fas fa-map-marker-alt"></i><?php echo get_the_term_list($job_id, 'job-locations', '', ', ', ''); ?>
                                                </div>
                                            </div>

                                            <div class="ep-job-tags">
		                                        <?php
                                                    $all_job_tags = get_the_term_list($job_id, 'job-tag', '', ', ', '');

                                                    $job_tags_array = explode(", ",$all_job_tags);
                                                    $first_four_tags = array_slice($job_tags_array, 0, 4);
                                                    $top_tag_item = implode(' ', $first_four_tags);

                                                    echo wp_kses_post($top_tag_item);
                                                ?>
                                            </div>

                                            <div class="ep-job-salary-and-deadline">
                                                <span class="ep-job-salary"><i aria-hidden="true" class="fas fa-dollar-sign"></i><?php echo get_post_meta($job_id,'salary',true);?></span>
                                                <div class="ep-job-deadline">
                                                    <span class="deadline-text"><?php echo __('Deadline:', 'hijobs-core') ?></span>
                                                    <?php
                                                    $deadline= strtotime(get_post_meta($job_id, 'deadline', true));
                                                    $deadline_format= date('jS M, Y',$deadline);

                                                    echo  esc_html($deadline_format);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                endwhile;
                                wp_reset_query();
                                ?>
                            </div>


                        </div>
                        <?php
                    }
                }
                ?>
            </div>

            <div class="ep-job-bottom-text-wrapper text-center">
                <div class="ep-job-bottom-text-content">
	                <?php echo wp_kses_post($settings['bottom_text']);?>
                </div>
            </div>

		</div>

		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Job_Of_The_Day );