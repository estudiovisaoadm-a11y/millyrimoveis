<?php
namespace Elementor;

class ListfolioPro_Title_With_Text_Widget extends Widget_Base {

	public function get_name() {

		return 'listfoliopro_title_with_text';
	}

	public function get_title() {
		return esc_html__( 'Title With Text', 'listfoliopro' );
	}

	public function get_icon() {

		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'title_with_text_options',
			[
				'label' => esc_html__( 'Title With Text', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'listfoliopro' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'About Us',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'listfoliopro' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<h2>More About Our Company</h2>',
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'listfoliopro' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'listfoliopro' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => 'Synergistically visualize alternative content before cross functional core Rapidiously administra standardized value via focused benefits. Rapidly redefine highly efficient niche markets with plug-and-play materials professionally',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle', 'listfoliopro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
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
				'selector' => '{{WRAPPER}} .title-with-text-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'listfoliopro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-with-text-subtitle' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .title-with-text-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .title-with-text-title h1, {{WRAPPER}} .title-with-text-title h2, {{WRAPPER}} .title-with-text-title h3, {{WRAPPER}} .title-with-text-title h4, {{WRAPPER}} .title-with-text-title h5, {{WRAPPER}} .title-with-text-title h6',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'listfoliopro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-with-text-title h1, {{WRAPPER}} .title-with-text-title h2, {{WRAPPER}} .title-with-text-title h3, {{WRAPPER}} .title-with-text-title h4, {{WRAPPER}} .title-with-text-title h5, {{WRAPPER}} .title-with-text-title h6' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .title-with-text-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			[
				'label'     => esc_html__( 'Description', 'listfoliopro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Typography', 'listfoliopro' ),
				'selector' => '{{WRAPPER}} .title-with-text-desc',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'listfoliopro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .title-with-text-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin', 'listfoliopro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .title-with-text-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Width (%)', 'listfoliopro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .title-with-text-content' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'listfoliopro' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,

				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'listfoliopro' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'listfoliopro' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'listfoliopro' ),
						'icon'  => 'eicon-text-align-right',
					],
				],

				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .listfoliopro-title-with-text-wrapper' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'wrapper_margin',
			[
				'label'      => esc_html__( 'Margin', 'listfoliopro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .listfoliopro-title-with-text-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$sub_title   = $settings['subtitle'];
		$title       = $settings['title'];
		$description = $settings['description'];
		?>

		<div class="listfoliopro-title-with-text-wrapper">
			<div class="title-with-text-content">
				<?php if ( $sub_title ) : ?>
					<span class="title-with-text-subtitle"><?php echo esc_html( $sub_title ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<div class="title-with-text-title">
						<?php echo wp_kses_post( $title); ?>
					</div>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="title-with-text-desc">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Title_With_Text_Widget );