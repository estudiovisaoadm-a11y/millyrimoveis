<?php
namespace Elementor;

class HiJobs_Job_Category_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_job_category';
	}

	public function get_title() {
		return esc_html__( 'Job Categories', 'themedraft-core' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'categories_options',
			[
				'label' => esc_html__( 'Categories', 'themedraft-core' ),
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
            'btn_text',
            [
                'label'       => __( 'Button Text', 'themedraft-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Explore Jobs',
            ]
        );

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
        $taxonomy = 'job-category';
		?>

        <div class="ep-job-category-wrapper">
            <div class="container">
                <div class="row">
	                <?php
	                if ( $settings['job_categories'] ) {
		                foreach ( $settings['job_categories'] as $job_category ) {
			                $category_name = get_term_by( 'slug', $job_category, $taxonomy );
			                $category_url  = get_term_link( $job_category, $taxonomy );

			                $term_id      = get_term_by( 'slug', $job_category, $taxonomy )->term_id;
			                $term_icon = get_term_meta( $term_id, 'jobbank_term_icon', true );
			                $post_count_on_category = new \WP_Query( array( $taxonomy => $job_category ) );
			                ?>

                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="job-category-item">
                                    <div class="ep-job-cat-icon">
                                        <i class="<?php echo esc_attr($term_icon);?>"></i>
                                    </div>

                                    <h4 class="ep-job-cat-name"><?php echo esc_html($category_name->name); ?></h4>

                                    <div class="total-open-job">
                                        <?php echo __('Total ', 'hijobs-core') . $post_count_on_category->found_posts .__(' Jobs Open', 'hijobs-core'); ?>
                                    </div>

                                    <div class="ep-job-cat-btn-wrapper">
                                        <a href="<?php echo esc_url($category_url); ?>" class="ep-button"><?php echo esc_html($settings['btn_text']);?> <i class="fas fa-angle-double-right"></i>
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

Plugin::instance()->widgets_manager->register( new HiJobs_Job_Category_Widget );