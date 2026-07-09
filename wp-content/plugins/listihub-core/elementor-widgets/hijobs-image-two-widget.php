<?php
namespace Elementor;

class HiJobs_Images_Two_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_images_two';
	}

	public function get_title() {
		return esc_html__( 'Images Two', 'hijobs-core' );
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
			'main_img',
			[
				'label'       => __( 'Main Image', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'user_img',
			[
				'label'       => __( 'User Image', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
            'shape_img',
            [
                'label'       => __( 'Shape Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'user_count',
            [
                'label'       => __( 'User Count', 'themedraft-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => '18K+',
            ]
        );

        $this->add_control(
            'user_text',
            [
                'label'       => __( 'User Text', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'Individual Freelancers',
            ]
        );

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$main_image_src = $settings['main_img']['url'];


		$user_img_src = $settings['user_img']['url'];
		$user_image_alt = get_post_meta( $settings['user_img']['id'], '_wp_attachment_image_alt', true );
		$user_image_title = get_the_title( $settings['user_img']['id']);


		$shape_img_src = $settings['shape_img']['url'];
		$shape_image_alt = get_post_meta( $settings['shape_img']['id'], '_wp_attachment_image_alt', true );
		$shape_image_title = get_the_title( $settings['shape_img']['id']);

		?>

		<div class="hijobs-images-two-main-container">
            <div class="ep-img-two-shape">
                <img src="<?php echo esc_url($shape_img_src);?>" alt="<?php echo esc_attr($shape_image_alt);?>" title="<?php echo esc_attr($shape_image_title);?>">
            </div>
            
            <div class="ep-main-image" style="background-image: url(<?php echo esc_url($main_image_src);?>)">
                <div class="text-with-user-image">
                    <span class="user-count"><?php echo esc_html($settings['user_count']);?></span>
                    <span class="user-text"><?php echo esc_html($settings['user_text']);?></span>

                    <img src="<?php echo esc_url($user_img_src);?>" alt="<?php echo esc_attr($user_image_alt);?>" title="<?php echo esc_attr($user_image_title);?>">
                </div>
            </div>


		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Images_Two_Widget );