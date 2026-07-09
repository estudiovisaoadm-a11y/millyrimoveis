<?php
namespace Elementor;

class ListfolioPro_Section_Title_One_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_section_title_one';
	}

	public function get_title() {
		return esc_html__( 'Section Title One', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'section_title_options',
			[
				'label' => esc_html__( 'Section Title', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'listfoliopro' ),
				'default'       => __( 'Categories', 'listfoliopro' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'listfoliopro' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => __('<h2>Browse Our Featured Property Categories</h2>', 'listfoliopro'),
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'listfoliopro' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			[
				'label' => esc_html__( 'Subtitle', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'subtitle!' => '',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Typography', 'listfoliopro' ),
				'selector' => '{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'       => esc_html__('Color', 'listfoliopro'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin', 'listfoliopro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'subtitle_col_width',
            [
                'label' => esc_html__( 'Width', 'listfoliopro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],

                'selectors' => [
                    '{{WRAPPER}} .subtitle-col' => 'flex: 0 0 {{SIZE}}%;max-width:{{SIZE}}%;',
                ],
            ]
        );
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label'     => esc_html__( 'Title', 'listfoliopro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'listfoliopro' ),
				'selector' => '{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h1,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h2,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h3,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h4,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h5,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h6',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'listfoliopro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h1,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h2,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h3,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h4,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h5,{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'listfoliopro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h1,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h2,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h3,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h4,
				{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h5,{{WRAPPER}} .listfoliopro-section-title-one-wrapper .section-title h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_col_width',
			[
				'label' => esc_html__( 'Width', 'listfoliopro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .title-col' => 'flex: 0 0 {{SIZE}}%;max-width:{{SIZE}}%;',
				],
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="bootstrap-wrapper">
			<div class="listfoliopro-section-title-one-wrapper ">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 subtitle-col">
                            <div class="section-subtitle">
                                <?php echo esc_html($settings['subtitle']);?>
                            </div>
                        </div>
                        <div class="col-xl-7 title-col">
                            <div class="section-title">
                                <?php echo wp_kses_post($settings['title']);?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Section_Title_One_Widget );