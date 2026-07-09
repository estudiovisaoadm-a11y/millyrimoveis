<?php
namespace Elementor;
use WP_Query;
use WP_User_Query;
class HiJobs_Recent_Job extends Widget_Base {

	public function get_name() {

		return 'hijobs_recent_job';
	}

	public function get_title() {
		return esc_html__( 'Recent Job', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'recent_job_settings',
			[
				'label' => esc_html__( 'Recent Jobs', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'job_count',
			[
				'label'   => __( 'Number Of Job To Show', 'hijobs-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 3,
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
			'exclude_job',
			[
				'label'       => __( 'Exclude Job', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => hijobs_get_job_title_as_list(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'column_options',
			[
				'label' => esc_html__( 'Column Settings', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'xl_column',
			[
				'label'   => __( 'Desktop', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-4',
				'options' => [
					'col-xl-12'   => __( '1 Column', 'hijobs-core' ),
					'col-xl-6'    => __( '2 Column', 'hijobs-core' ),
					'col-xl-4'    => __( '3 Column', 'hijobs-core' ),
					'col-xl-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'lg_column',
			[
				'label'   => __( 'iPad Pro', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-6',
				'options' => [
					'col-lg-12'   => __( '1 Column', 'hijobs-core' ),
					'col-lg-6'    => __( '2 Column', 'hijobs-core' ),
					'col-lg-4'    => __( '3 Column', 'hijobs-core' ),
					'col-lg-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'md_column',
			[
				'label'   => __( 'iPad', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-6',
				'options' => [
					'col-md-12'   => __( '1 Column', 'hijobs-core' ),
					'col-md-6'    => __( '2 Column', 'hijobs-core' ),
					'col-md-4'    => __( '3 Column', 'hijobs-core' ),
					'col-md-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column'];
		?>

        <div class="ep-recent-job-wrapper">
            <div class="row">
                <?php
                if ( ! empty( $settings['job_categories'] ) ) {
                    $job_query = new WP_Query( array(
                        'post_type'           => 'job',
                        'posts_per_page'      => $settings['job_count'],
                        'ignore_sticky_posts' => 1,
                        'post__not_in'        => $settings['exclude_job'],
                        'tax_query'           => array(
                            array(
                                'taxonomy' => 'job-category',
                                'terms'    => $settings['job_categories'],
                                'field'    => 'slug',
                            )
                        )
                    ) );
                } else {

                    $job_query = new WP_Query(
                        array(
                            'posts_per_page'      => $settings['job_count'],
                            'post_type'           => 'job',
                            'ignore_sticky_posts' => 1,
                            'post__not_in'        => $settings['exclude_job'],
                        )
                    );
                }

                wp_enqueue_script('jobbank_single-listing', ep_jobbank_URLPATH . 'admin/files/js/single-listing.js');
                wp_localize_script('jobbank_single-listing', 'jobbank_data', array(
                    'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
                    'current_user_id'	=>get_current_user_id(),
                    'Please_login'=>esc_html__('Please login', 'jobbank' ),
                    'Add_to_Favorites'=>esc_html__('Save', 'jobbank' ),
                    'Added_to_Favorites'=>esc_html__('Saved', 'jobbank' ),
                    'contact'=> wp_create_nonce("contact"),
                ) );

                while ( $job_query->have_posts() ) : $job_query->the_post();
                    $job_id = get_the_ID();
                    $company_image = wp_get_attachment_image_src( get_post_thumbnail_id( $job_id ), 'large' );
                ?>

                    <div class="<?php echo esc_attr($ep_column); ?>">
                        <div class="ep-recent-job-item">
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

                            <div class="job-rating employer-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>



                            <div class="ep-job-top">
                                <div class="ep-company-logo" style="background-image: url(<?php echo esc_url($company_image[0]);?>)"></div>

                                <span class="ep-company-name ep-primary-color"><?php echo get_post_meta($job_id,'company_name',true);?></span>

                                <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-job-url">
                                    <h4 class="ep-job-title"><?php echo get_the_title($job_id);?></h4>
                                </a>

                                <div class="ep-job-location">
                                    <i class="fas fa-map-marker-alt"></i><?php echo get_the_term_list($job_id, 'job-locations', '', ', ', ''); ?>
                                </div>
                            </div>

                            <div class="ep-job-tags">
                                <?php
                                $all_job_tags = get_the_term_list($job_id, 'job-tag', '', ', ', '');
                                $job_tags_array = explode(", ",$all_job_tags);
                                $first_three_tags = array_slice($job_tags_array, 0, 3);
                                $top_tag_item = implode(' ', $first_three_tags);

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

                                    echo  $deadline_format;?>
                                </div>
                            </div>

                            <div class="ep-job-apply-button">
                                <a class="ep-button" href="<?php echo esc_url( get_the_permalink() );?>">Apply This Job</a>
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

Plugin::instance()->widgets_manager->register( new HiJobs_Recent_Job );