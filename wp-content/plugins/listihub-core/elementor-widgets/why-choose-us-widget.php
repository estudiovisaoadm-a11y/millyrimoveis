<?php
namespace Elementor;

class HiJobs_Why_Choose_Us_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_why_choose_us';
	}

	public function get_title() {
		return esc_html__( 'Why Choose Us', 'hijobs-core' );
	}

	public function get_icon() {
		return 'far fa-question-circle';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'why_choose_left_content',
			[
				'label' => esc_html__( 'Left Content', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'left_main_image',
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
            'available_job_text',
            [
                'label'       => __( 'Available Job Text', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => '<span>2.5M+</span><span>Jobs Available</span>',
            ]
        );

        $this->add_control(
            'candidate_img',
            [
                'label'       => __( 'Candidate Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

		$this->add_control(
			'happy_candidate_text',
			[
				'label'       => __( 'Happy Candidate Text', 'themedraft-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => '<span>4.5M+</span><span>Happy Candidates</span>',
			]
		);

		$this->end_controls_section();




        $this->start_controls_section(
            'right_content_options',
            [
                'label' => esc_html__( 'Right Content', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'hijobs-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Why Choose Us?',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'hijobs-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<h2>Get job that’s would right for you</h2>',
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'hijobs-core' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'box_title',
            [
                'label'       => __( 'Box Title', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Discover New Opportunities',
                'label_block' => true,
            ]
        );

		$repeater->add_control(
            'box_desc',
            [
                'label'       => __( 'Box Description', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'Sed ut perspiciatis unde omnis iste natus sit solution voluptatemec lifes accusantium.',
            ]
        );

		$repeater->add_control(
			'selected_icon',
			[
				'label'            => esc_html__( 'Select Icon', 'hijobs-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => true,
				'default'          => [
					'value'   => 'fas fa-check-circle',
					'library' => 'solid',
				],
			]
		);

        $this->add_control(
            'boxes',
            [
                'label'       => __( 'Box Item List', 'themedraft-core' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'author_name' => 'Discover New Opportunities',
                        'box_desc' => 'Sed ut perspiciatis unde omnis iste natus sit solution voluptatemec lifes accusantium.',
                        'selected_icon' => 'fas fa-check-circle',
                    ],
                ],
                'title_field' => '{{{ box_title }}}',
            ]
        );

        $this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="why-choose-us-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xl-6 left-image-column">
						<div class="why-choose-left-content">
							<div class="left-img">
                                <?php
                                    $main_image_alt = get_post_meta( $settings['left_main_image']['id'], '_wp_attachment_image_alt', true );
                                    $main_image_title = get_the_title( $settings['left_main_image']['id']);
                                    $main_image_src = $settings['left_main_image']['url'];
                                ?>
								<img src="<?php echo esc_url($main_image_src);?>" alt="<?php echo esc_attr($main_image_alt);?>" title="<?php echo esc_attr($main_image_title);?>">
							</div>

                            <div class="left-caption-one">
                                <div class="left-caption-one-text-wrapper">
                                    <div class="left-caption-one-text">
                                        <div>
                                            <?php echo wp_kses_post($settings['available_job_text']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="left-caption-two">
                                <div class="left-caption-two-image" style="background-image: url(<?php echo esc_url($settings['candidate_img']['url']);?>)"></div>
                                <div class="left-caption-two-text">
                                    <?php echo wp_kses_post($settings['happy_candidate_text']); ?>
                                </div>
                            </div>
						</div>
					</div>

					<div class="col-xl-6 my-auto">
						<div class="why-choose-right-content">
                            <div class="ep-section-title-wrapper">
                                <div class="ep-section-title-content">

                                    <span class="ep-section-subtitle ep-primary-color"><?php echo esc_html($settings['subtitle']); ?></span>

                                    <div class="ep-section-title">
		                                <?php echo wp_kses_post($settings['title']); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="right-box-wrapper">
	                            <?php if ( $settings['boxes'] ) {
		                            foreach ( $settings['boxes'] as $box ) { ?>
                                        <div class="right-box-item">
                                            <div class="icon-box-one-wrapper">
                                                <div class="icon-box-one-icon">
	                                                <?php hijobs_custom_icon_render( $box, 'icon', 'selected_icon' );?>
                                                </div>
                                                <h3 class="icon-box-one-title"><?php echo esc_html($box['box_title']);?></h3>

                                                <div class="icon-box-one-desc">
	                                                <?php echo wp_kses_post($box['box_desc']);?>
                                                </div>
                                            </div>
                                        </div>
		                            <?php }
	                            } ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Why_Choose_Us_Widget );