<?php
namespace Elementor;

class HiJobs_Cta_Two_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_cta_two';
	}

	public function get_title() {
		return esc_html__( 'CTA Two', 'hijobs-core' );
	}

	public function get_icon() {
		return 'fas fa-broadcast-tower';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'cta_options',
			[
				'label' => esc_html__( 'CTA Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'left_image',
            [
                'label'       => __( 'Left Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'right_content',
            [
                'label'       => __( 'Right Content', 'hijobs-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => '<h2>Get Your Matched Jobs in a Few Minutes</h2>
                                <p>Find your dream job & earn from world leading brands. Upload your CV now!</p>',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label'       => __( 'Button Text', 'themedraft-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Upload Your CV',
            ]
        );

        $this->add_control(
            'btn_url',
            [
                'label'         => __( 'Button Url', 'themedraft-core' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => __( 'https://your-link.com', 'themedraft-core' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
            'cta_style',
            [
                'label' => esc_html__( 'CTA Style', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'wrapper_background',
                'label' => esc_html__( 'Background', 'themedraft-core' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .cta-two-wrapper',
            ]
        );

        $this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$image_src = $settings['left_image']['url'];
        $image_alt = get_post_meta( $settings['left_image']['id'], '_wp_attachment_image_alt', true );
        $image_title = get_the_title( $settings['left_image']['id']);
		?>

		<div class="cta-two-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 order-xl-first order-last text-center">
						<div class="cta-two-image">
							<img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
						</div>
					</div>

					<div class="col-xl-6 my-auto">
                        <div class="cta-two-right-content">
                            <div class="cta-two-content">
                                <?php echo wp_kses_post($settings['right_content']);?>
                            </div>

                            <div class="cta-two-button">
                                <a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="ep-button"><?php echo esc_html($settings['btn_text']);?><i class="fas fa-angle-double-right"></i></a>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Cta_Two_Widget );