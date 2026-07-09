<?php
namespace Elementor;

class HiJobs_Job_Banner_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_job_banner';
	}

	public function get_title() {
		return esc_html__( 'Job Banner', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'job_banner',
			[
				'label' => esc_html__( 'Job Banner', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'banner_image',
		    [
		        'label'       => __( 'Banner Image', 'themedraft-core' ),
		        'type'        => Controls_Manager::MEDIA,
		        'label_block' => true,
		        'default'     => [
		            'url' => Utils::get_placeholder_image_src(),
		        ],
		    ]
		);

        $this->add_responsive_control(
            'banner_height',
            [
                'label' => esc_html__( 'Banner Height', 'themedraft-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 250,
                        'max' => 1000,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .banner-area.job-banner' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$topbanner = get_post_meta( get_the_ID(), 'topbanner', true );

        if(!empty($settings['banner_image']['url'])){
	        $default_image_banner = $settings['banner_image']['url'];
        }elseif (trim( $topbanner ) != ''){
	        $default_image_banner = wp_get_attachment_url( $topbanner );
        }else{
	        $default_image_banner = '';
        }
		?>

		<div class="banner-area job-banner ep-cover-bg" style="background-image: url(<?php echo esc_url($default_image_banner);?>)"></div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Job_Banner_Widget );