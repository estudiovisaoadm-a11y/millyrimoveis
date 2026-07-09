<?php
namespace Elementor;

class HiJobs_Job_By_Location_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_job_by_location';
	}

	public function get_title() {
		return esc_html__( 'Job Locations', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'location_options',
			[
				'label' => esc_html__( 'Select Locations', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'job_locations',
			[
				'label'       => __( 'Locations', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => ep_hijobs_job_locations(),
			]
		);

        $this->add_control(
            'layout',
            [
                'label'   => __( 'Layout', 'themedraft-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout-one',
                'options' => [
                    'layout-one' => __( 'Layout One', 'themedraft-core' ),
                    'layout-two' => __( 'Layout Two', 'themedraft-core' ),
                ],
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
				'default' => 'col-lg-4',
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

		$this->add_control(
			'sm_column',
			[
				'label'   => __( 'Mobile', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-12',
				'options' => [
					'col-12'   => __( '1 Column', 'hijobs-core' ),
					'col-6'    => __( '2 Column', 'hijobs-core' ),
					'col-4'    => __( '3 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$taxonomy = 'job-locations';
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		?>

		<div class="ep-job-by-location-wrapper <?php echo esc_attr($settings['layout']);?>">
			<div class="containerr">
				<div class="row">
					<?php
					if ( $settings['job_locations'] ) {
						foreach ( $settings['job_locations'] as $job_location ) {
							$location_name = get_term_by( 'slug', $job_location, $taxonomy );
							$location_url  = get_term_link( $job_location, $taxonomy );

							$term_id      = get_term_by( 'slug', $job_location, $taxonomy )->term_id;
							$thumbnail_src = get_term_meta( $term_id, 'jobbank_term_image', true );
							$post_count_on_location = new \WP_Query( array( $taxonomy => $job_location ) );
							?>

							<div class="<?php echo esc_attr($ep_column); ?>">
                                <div class="job-by-location-wrapper">
                                    <div class="location-image ep-cover-bg" style="background-image: url(<?php echo esc_url($thumbnail_src);?>)"></div>

                                    <div class="job-location-and-count">
                                        <h4 class="ep-job-location-name"><?php echo esc_html($location_name->name); ?></h4>

                                        <div class="total-open-job-count">
		                                    <?php echo esc_html($post_count_on_location->found_posts) .__(' Listing', 'hijobs-core'); ?>
                                        </div>
                                    </div>

                                    <div class="ep-job-location-btn-wrapper">
                                        <a href="<?php echo esc_url($location_url); ?>" class="ep-location-button"><i class="fas fa-angle-double-right"></i>
                                        </a>
                                    </div>
                                </div>
							</div>
						<?php }
					}
					?>
				</div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Job_By_Location_Widget );