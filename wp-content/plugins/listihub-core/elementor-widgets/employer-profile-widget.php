<?php
namespace Elementor;
class HiJobs_Employer_Widget_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_employer_widget';
	}

	public function get_title() {
		return esc_html__( 'Employer Directory One', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'employer_options',
			[
				'label' => esc_html__( 'Employer Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'profile_per_page',
            [
                'label'       => esc_html__('Employer Profile Per Page.', 'themedraft-core'),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 1,
                'max'         => 1000,
                'step'        => 1,
                'default'     => 8,
            ]
        );

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		global $post;

		$main_class  = new \eplugins_jobbank;

		$jobbank_directory_url = get_option( 'ep_jobbank_url' );
		if ( $jobbank_directory_url == "" ) {
			$jobbank_directory_url = 'job';
		}

        $users_per_page = $settings['profile_per_page'];

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		if ( $paged == 1 ) {
			$offset = 0;
		} else {
			$offset = ( $paged - 1 ) * $users_per_page;
		}

		$args            = array();
		$args['number']  = $users_per_page;
		$args['offset']  = $offset;
		$args['orderby'] = 'display_name';
		$args['order']   = 'ASC';

		$user_type = array(
			'relation' => 'AND',
			array(
				'key'     => 'user_type',
				'value'   => 'employer',
				'compare' => '='
			),
		);

		$args['meta_query'] = array(
			$user_type,
		);
		?>

		<div class="ep-job-employer-profile-wrapper">
            <div class="row" >
				<?php
				$user_query = new \WP_User_Query( $args );
				$total_users = $user_query->get_total();
				$i=0;
				// User Loop
				if ( ! empty( $user_query->results ) ) {
					foreach ( $user_query->results as $user ) {

						$profile_page=get_option('epjbjobbank_employer_public_page');
						$page_link= get_permalink( $profile_page).'?&id='.$user->ID;
						$employer_img = get_user_meta($user->ID, 'jobbank_profile_pic_thum',true);
                        ?>

                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">
                            <div class="ep-single-employer-item">
                                <div class="ep-employer-top-content">
                                    <a href="<?php echo esc_url($page_link); ?>" class="ep-employer-img" style="background-image: url(<?php echo esc_url($employer_img); ?>)">
                                    </a>

                                    <div class="top-right-content">
	                                    <div class="employer-locations">
		                                    <?php
		                                    $all_locations= str_replace(',',' ',get_user_meta($user->ID, 'all_locations', true));
		                                    if ( $all_locations != '' ) {
			                                    ?>

                                                <i class="fa-solid fa-location-dot"></i><?php echo esc_html( $all_locations ); ?>

			                                    <?php
		                                    }
		                                    ?>
                                        </div>

                                        <a href="<?php echo esc_url($page_link); ?>">
                                            <h4 class="ep-employer-name">
	                                            <?php echo (get_user_meta($user->ID,'full_name',true)!=''? get_user_meta($user->ID,'full_name',true) : $user->display_name ); ?>
                                            </h4>
                                        </a>

                                        <div class="employer-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="ep-employer-open-jobs-btn">
                                    <?php
                                    if(get_user_meta($user->ID, 'user_type', true)==='employer' ){
	                                    $total_jobs= $main_class->jobbank_total_job_count($user->ID, $allusers='no' );
	                                    ?>
                                        <a class="ep-button" href="<?php echo get_post_type_archive_link( $jobbank_directory_url ).'?employer='.esc_attr($user->ID); ?>"><?php echo esc_html($total_jobs);?> <?php esc_html_e('Open Jobs', 'jobbank'); ?></a>

	                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

					<?php	$i++;
					}
				}
				?>
            </div>

            <div class="col-12">
				<?php
				$params =array();
				$pages = paginate_links( array_merge( [
						'base'         => str_replace( $post->ID, '%#%', esc_url( get_pagenum_link( $post->ID ) ) ),
						'format'       => '?paged=%#%',
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'total'        => round((int)$total_users/$users_per_page),
						'type'         => 'array',
						'show_all'     => false,
						'end_size'     => 3,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => esc_html__( '« Prev','jobbank' ),
						'next_text'    => esc_html__( 'Next »','jobbank' ),
						'add_args'     => $args,
						'add_fragment' => ''
					], $params )
				);
				if ( is_array( $pages ) ) {
					$pagination = '<div class=" mt-3 pagination justify-content-center"><ul class="pagination">';
					foreach ( $pages as $page ) {
						$pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
					}
					$pagination .= '</ul></div>';
					echo wp_specialchars_decode($pagination);
				}
				?>
            </div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Employer_Widget_Widget );