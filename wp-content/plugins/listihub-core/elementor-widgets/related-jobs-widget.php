<?php
namespace Elementor;

class HiJobs_Related_Job_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_related_job';
	}

	public function get_title() {
		return esc_html__( 'Related Jobs', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'related_job',
			[
				'label' => esc_html__( 'Related Job', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'main_title',
            [
                'label'       => __( 'Main Title', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'Related Jobs',
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
				'default' => 3,
			]
		);

		$this->add_control(
			'enable_save',
			[
				'label'     => esc_html__( 'Enable Save Button', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'enable_tags',
			[
				'label'     => esc_html__( 'Enable Tags', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'enable_review',
			[
				'label'     => esc_html__( 'Enable Review', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'enable_deadline',
			[
				'label'     => esc_html__( 'Enable Deadline', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'yes',
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		wp_enqueue_script('jobbank_single-listing', ep_jobbank_URLPATH . 'admin/files/js/single-listing.js');
		wp_localize_script('jobbank_single-listing', 'jobbank_data', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'current_user_id'	=>get_current_user_id(),
			'Please_login'=>esc_html__('Please login', 'jobbank' ),
			'Add_to_Favorites'=>esc_html__('Save', 'jobbank' ),
			'Added_to_Favorites'=>esc_html__('Saved', 'jobbank' ),
			'contact'=> wp_create_nonce("contact"),
		) );

		global $post;
		$terms = wp_get_object_terms( $post->ID, 'job-category', array( 'fields' => 'ids' ) );
		$args  = array(
			'post_type'      => 'job',
			'post_status'    => 'publish',
			'posts_per_page' => $settings['post_count'],
			'orderby'        => 'rand',
			'tax_query'      => array(
				array(
					'taxonomy' => 'job-category',
					'field'    => 'id',
					'terms'    => $terms
				)
			),
			'post__not_in'   => array( $post->ID ),
		);

		$related_job = new \WP_Query( $args ); ?>

        <div class="related-job-wrapper">
            <h4 class="related-job-section-title"><?php echo esc_html($settings['main_title']);?></h4>
	        <?php
	        while ( $related_job->have_posts() ) : $related_job->the_post();
		        $job_id = get_the_ID();
		        $company_logo = wp_get_attachment_image_src( get_post_thumbnail_id( $job_id ), 'large' );
		        $active_single_fields_saved=get_option('jobbank_single_fields_saved' );
            ?>

            <div class="job-short-details-wrapper">
                <div class="job-company-info-and-buttons">
                    <div class="left-company-info">
                        <div class="company-logo" style="background-image: url(<?php echo esc_url($company_logo[0]);?>)"></div>
                        <span class="ep-company-name ep-primary-color"><?php echo get_post_meta($job_id,'company_name',true);?></span>
                        <a href="<?php the_permalink($job_id);?>" class="job-details-link">
                            <h3 class="job-title"><?php echo get_the_title();?></h3>
                        </a>
                        <div class="ep-job-location employer-locations">
                            <i class="fas fa-map-marker-alt"></i><?php echo get_the_term_list($job_id, 'job-locations', '', ', ', ''); ?>
                        </div>
                    </div>

                    <div class="right-apply-save-button">
			            <?php if($settings['enable_save'] == 'yes') :?>
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
                                        <label title='save' class="ep-button btn-add-favourites jobbookmark ep-transition" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Save','jobbank'); ?></label>
							            <?php
						            }else{
							            ?>
                                        <label title='saved' class="ep-button btn-added-favourites jobbookmark ep-transition" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Saved','jobbank'); ?></label>
							            <?php
						            }
					            }
					            ?>
                            </div>
			            <?php endif; ?>

                        <div class="job-apply-button">
				            <?php
				            $job_apply='no';
				            $user_ID = get_current_user_id();
				            $job_apply_all = get_user_meta($user_ID,'job_apply_all',true);
				            $job_apply_all = explode(",", $job_apply_all);
				            if (in_array($job_id, $job_apply_all)) {
					            $job_apply='yes';
				            }
				            ?>
				            <?php
				            if(array_key_exists('apply_button',$active_single_fields_saved)){
					            ?>
                                <button onclick="jobbank_apply_popup('<?php echo esc_attr($job_id);?>')" class="ep-button">
						            <?php
						            if($job_apply=='yes'){?>
                                        <i class="fa fa-check-circle"></i>
							            <?php
						            }
						            ?>
						            <?php esc_html_e('Apply Now','jobbank'); ?></button>
					            <?php
				            }
				            ?>
                        </div>
                    </div>
                </div>

                <div class="job-tags-and-review-button">
                    <div class="ep-job-tags">
			            <?php
			            if($settings['enable_tags'] == 'yes'){
				            $all_job_tags = get_the_term_list($job_id, 'job-tag', '', ' ', '');
				            echo wp_kses_post($all_job_tags);
			            }
			            ?>
			            <?php if($settings['enable_review'] == 'yes') :?>
                            <div class="employer-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
			            <?php endif; ?>
                    </div>
                </div>

                <div class="ep-job-salary-and-deadline">
                    <span class="ep-job-salary"><i aria-hidden="true" class="fas fa-dollar-sign"></i><?php echo get_post_meta($job_id,'salary',true);?></span>
		            <?php if($settings['enable_deadline'] == 'yes') : ?>
                        <div class="ep-job-deadline">
                            <span class="deadline-text"><?php echo __('Deadline:', 'hijobs-core') ?></span>
				            <?php
				            $deadline= strtotime(get_post_meta($job_id, 'deadline', true));
				            $deadline_format= date('jS M, Y',$deadline);

				            echo  $deadline_format;?>
                        </div>
		            <?php endif; ?>
                </div>
            </div>

	        <?php endwhile;
	        wp_reset_query();

	        ?>
        </div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Related_Job_Widget );