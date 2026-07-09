<?php
namespace Elementor;

class HiJobs_Images_One_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_images_one';
	}

	public function get_title() {
		return esc_html__( 'Images One', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-image';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'image_options',
			[
				'label' => esc_html__( 'Images', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'img_one',
            [
                'label'       => __( 'Image One', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

		$this->add_control(
			'img_two',
			[
				'label'       => __( 'Image Two', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__( 'Images Style', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'       => esc_html__('Border Color', 'themedraft-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .hijobs-images-one-wrapper .img-one-circle' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .hijobs-images-one-wrapper .img-two-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
        $image_src = $settings['img_one']['url'];
        $image_alt = get_post_meta( $settings['img_one']['id'], '_wp_attachment_image_alt', true );
        $image_title = get_the_title( $settings['img_one']['id']);

		$image_two_src = $settings['img_two']['url'];
		?>

		<div class="hijobs-images-one-main-container">
            <div class="hijobs-images-one-wrapper">
                <div class="img-one">
                    <div class="img-one-circle"></div>
                    <img src="<?php echo esc_url($image_src)?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
                </div>

                <div class="img-two-wrapper">
                    <div class="img-two" style="background-image: url(<?php echo esc_url($image_two_src);?>)"></div>
                </div>
            </div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Images_One_Widget );