<?php
namespace Elementor;

class Hijobs_Section_Title_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_section_title';
	}

	public function get_title() {
		return esc_html__( 'Section Title', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-t-letter';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'section_title_options',
			[
				'label' => esc_html__( 'Section Title', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'hijobs-core' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'More About Our Company',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'hijobs-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<h2>World’s of talent at your fingertips</h2>',
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'hijobs-core' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'hijobs-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => 'Synergistically visualize alternative content before cross functional core Rapidiously administra standardized value via focused benefits. Rapidly redefine highly efficient niche markets with plug-and-play materials professionally',
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style',
			[
				'label'     => esc_html__( 'Subtitle', 'hijobs-core' ),
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
				'label'    => esc_html__( 'Typography', 'hijobs-core' ),
				'selector' => '{{WRAPPER}} .ep-section-subtitle',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Color', 'hijobs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_margin',
			[
				'label'      => esc_html__( 'Margin', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label'     => esc_html__( 'Title', 'hijobs-core' ),
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
				'label'    => esc_html__( 'Typography', 'hijobs-core' ),
				'selector' => '{{WRAPPER}} .ep-section-title h1, {{WRAPPER}} .ep-section-title h2, {{WRAPPER}} .ep-section-title h3, {{WRAPPER}} .ep-section-title h4, {{WRAPPER}} .ep-section-title h5, {{WRAPPER}} .ep-section-title h6',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'hijobs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-title h1, {{WRAPPER}} .ep-section-title h2, {{WRAPPER}} .ep-section-title h3, {{WRAPPER}} .ep-section-title h4, {{WRAPPER}} .ep-section-title h5, {{WRAPPER}} .ep-section-title h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style',
			[
				'label'     => esc_html__( 'Description', 'hijobs-core' ),
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
				'label'    => esc_html__( 'Typography', 'hijobs-core' ),
				'selector' => '{{WRAPPER}} .ep-section-description',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'hijobs-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ep-section-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'      => esc_html__( 'Margin', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style',
			[
				'label' => esc_html__( 'Wrapper', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Width (%)', 'hijobs-core' ),
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
					'{{WRAPPER}} .ep-section-title-content' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'hijobs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,

				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'hijobs-core' ),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => esc_html__( 'Center', 'hijobs-core' ),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => esc_html__( 'Right', 'hijobs-core' ),
						'icon'  => 'eicon-text-align-right',
					],
				],

				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .ep-section-title-wrapper' => 'text-align: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'wrapper_margin',
			[
				'label'      => esc_html__( 'Margin', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-section-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		<div class="ep-section-title-wrapper">
			<div class="ep-section-title-content">
				<?php if ( $sub_title ) : ?>
					<span class="ep-section-subtitle ep-primary-color"><?php echo esc_html( $sub_title ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<div class="ep-section-title">
						<?php echo wp_kses( $title, hijobs_allow_html() ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<div class="ep-section-description">
						<?php echo wp_kses_post( $description ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Hijobs_Section_Title_Widget );