<?php
namespace Elementor;

class HiJobs_CTA_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_cta_widget';
	}

	public function get_title() {
		return esc_html__( 'CTA One', 'hijobs-core' );
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
            'title',
            [
                'label'       => __( 'Title', 'hijobs-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'Start hiring your top talent’s here!',
            ]
        );

        $this->add_control(
            'desc',
            [
                'label'       => __( 'Description', 'hijobs-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => 'Congue malesuada nascetur lacus aliquet mattis, porta justo a pharetra orci himenaeos',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'btn_text',
            [
                'label'       => __( 'Button Text', 'hijobs-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Get Started',
            ]
        );

        $this->add_control(
            'btn_url',
            [
                'label'         => __( 'Button URL', 'hijobs-core' ),
                'type'          => Controls_Manager::URL,
                'placeholder'   => __( 'https://your-link.com', 'hijobs-core' ),
                'show_external' => true,
                'default'       => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

		$this->add_control(
			'btn_2_text',
			[
				'label'       => __( 'Button Two Text', 'hijobs-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'btn_2_url',
			[
				'label'         => __( 'Button Two URL', 'hijobs-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'hijobs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
                'condition' => [
                    'btn_2_text!' => '',
                ],
			]
		);
		$this->end_controls_section();

        // CTA Style
        $this->start_controls_section(
            'cta_style_options',
            [
                'label' => esc_html__('CTA', 'hijobs-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'title_color',
            [
                'label'       => esc_html__('Title Color', 'hijobs-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .cta-title' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'desc_color',
			[
				'label'       => esc_html__('Description Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .cta-desc' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_color',
                'label' => esc_html__( 'Background', 'themedraft-core' ),
                'types' => [ 'classic', 'gradient'],
                'selector' => '{{WRAPPER}} .cta-area-wrapper',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__( 'Wrapper Padding', 'themedraft-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .cta-area-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'themedraft-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],

                'selectors' => [
                    '{{WRAPPER}} .cta-area-wrapper' => 'border-radius: {{SIZE}}px;',
                ],
            ]
        );


        $this->end_controls_section();// End Button section

        $this->start_controls_section(
            'btn_one_style',
            [
                'label' => esc_html__( 'Button One', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->start_controls_tabs('td_button_style_tabs');

		//Default style tab start
		$this->start_controls_tab(
			'td_btn_style_default',
			[
				'label' => esc_html__('Default', 'hijobs-core'),
			]
		);

		$this->add_control(
			'button_default_bg',
			[
				'label'     => esc_html__('Background Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_default_border',
			[
				'label'     => esc_html__('Border Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_default_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();//Default style tab end

		//Hover style tab start
		$this->start_controls_tab(
			'td_btn_style_hover',
			[
				'label' => esc_html__('Hover', 'hijobs-core'),
			]
		);

		$this->add_control(
			'button_hover_bg',
			[
				'label'     => esc_html__('Background Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_border',
			[
				'label'     => esc_html__('Border Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-one:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();//Hover style tab end

        $this->end_controls_section();

		$this->start_controls_section(
			'btn_two_style',
			[
				'label' => esc_html__( 'Button Two', 'themedraft-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('td_button_two_style_tabs');

		//Default style tab start
		$this->start_controls_tab(
			'td_btn_two_style_default',
			[
				'label' => esc_html__('Default', 'hijobs-core'),
			]
		);

		$this->add_control(
			'button_two_default_bg',
			[
				'label'     => esc_html__('Background Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_default_border',
			[
				'label'     => esc_html__('Border Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_default_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();//Default style tab end

		//Hover style tab start
		$this->start_controls_tab(
			'td_btn_two_style_hover',
			[
				'label' => esc_html__('Hover', 'hijobs-core'),
			]
		);

		$this->add_control(
			'button_two_hover_bg',
			[
				'label'     => esc_html__('Background Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_two_hover_border',
			[
				'label'     => esc_html__('Border Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_two_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta-button-wrapper .ep-button.hijobs-button-two:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();//Hover style tab end

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="cta-area-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xl-7 col-lg-12">
						<div class="cta-content">
							<h4 class="cta-title"><?php echo esc_html($settings['title']);?></h4>
							<div class="cta-desc">
								<?php echo wp_kses_post($settings['desc']);?>
							</div>
						</div>
					</div>

					<div class="col-xl-5  col-lg-12 my-auto">
						<div class="cta-button-wrapper">
                            <a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="ep-button  hijobs-button-one"><?php echo esc_html($settings['btn_text']);?><i class="fas fa-angle-double-right"></i></a>
							<?php if($settings['btn_2_text']) :
								$btn_two_text = $settings['btn_2_text'];
								$btn_two_url   = $settings['btn_2_url']['url'];
								?>
                                <a href="<?php echo esc_url($btn_two_url);?>" class="hijobs-button ep-button hijobs-button-two"><?php echo esc_html($btn_two_text);?>
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
							<?php endif; ?>
                        </div>
					</div>
				</div>
			</div>
		</div>
        <?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_CTA_Widget );