<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Hijobs_ContactForm7_Layout_One_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_contact_form_one';
	}

	public function get_title() {
		return __( 'Contact Form7', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-mail';
	}
	public function get_categories() {
		return array( 'hijobs_elements' );
	}

	protected function register_controls() {


		$this->start_controls_section(
			'contact_form_accordion',
			[
				'label' => __( 'Contact Form', 'hijobs-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => __( 'Subtitle', 'hijobs-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Get In Touch',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'hijobs-core' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '<h2>Have Any Questions?</h2>',
				'label_block' => true,
				'description' => __( 'Use H1 - H6 for title.', 'hijobs-core' ),
			]
		);

		$this->add_control(
			'wpcf7_form_list',
			[
				'label' => __( 'Select Contact Form', 'hijobs-core' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => $this->hijobs_contact_form_layout_two(),
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
					'{{WRAPPER}} {{WRAPPER}} .ep-section-title h1, {{WRAPPER}} .ep-section-title h2, {{WRAPPER}} .ep-section-title h3, {{WRAPPER}} .ep-section-title h4, {{WRAPPER}} .ep-section-title h5, {{WRAPPER}} .ep-section-title h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		$this->add_control(
			'wrapper_bg_color',
			[
				'label'       => esc_html__('Background Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-contact-form-container' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_margin',
			[
				'label'      => esc_html__( 'Wrapper Margin', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-cf7-contact-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'      => esc_html__( 'Wrapper Padding', 'hijobs-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ep-contact-form-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'hijobs_contact_field_style',
			[
				'label' => __( 'Field Style', 'hijobs-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_bg_color',
			[
				'label'       => esc_html__('Field Background Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container select' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label'       => esc_html__('Field Border Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container select' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container textarea' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color_on_focus',
			[
				'label'       => esc_html__('Field Border Color On Focus', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container select:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input[type="text"]:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input[type="email"]:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_text_color',
			[
				'label'       => esc_html__('Field Text Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container ::placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container :-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container ::-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container select' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container input' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container textarea' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container .select-arrow:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => __( 'Textarea Height', 'hijobs-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .hijobs-contact-form-container textarea' => 'height: {{SIZE}}px;',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'hijobs_contact_submit_style',
			[
				'label' => __( 'Submit Button', 'hijobs-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		//Normal & hover option start
		$this->start_controls_tabs('ep_btn_styles');

		//Normal style start
		$this->start_controls_tab(
			'btn_normal_style',
			[
				'label' => esc_html__('Default', 'hijobs-core'),
			]
		);

		$this->add_control(
			'normal_txt_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hijobs-contact-form-container input[type="submit"]' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container button[type="submit"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'default_background',
			[
				'label'       => esc_html__('Background Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container input[type="submit"],{{WRAPPER}} .hijobs-contact-form-container button[type="submit"]' => 'background-color: {{VALUE}};border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		//Normal style end

		//Hover style start
		$this->start_controls_tab(
			'btn_hover_style',
			[
				'label' => esc_html__('Hover', 'hijobs-core'),
			]
		);

		$this->add_control(
			'hover_txt_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hijobs-contact-form-container input[type="submit"]:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .hijobs-contact-form-container button[type="submit"]:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label'       => esc_html__('Background Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .hijobs-contact-form-container input[type="submit"]:hover,{{WRAPPER}} .hijobs-contact-form-container button[type="submit"]:hover' => 'background-color: {{VALUE}};border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		//Hover style end
		$this->end_controls_tabs();
		//Normal & hover option end

		$this->end_controls_section();

	}

	protected function hijobs_contact_form_layout_two( ) {

		if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
			return array();
		}

		$forms = \WPCF7_ContactForm::find( array(
			'orderby' => 'title',
			'order'   => 'ASC',
		) );

		if ( empty( $forms ) ) {
			return array();
		}

		$result = array();

		foreach ( $forms as $item ) {
			$key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
			$result[ $key ] = $item->title();
		}

		return $result;
	}


	protected function render()  {
		$settings = $this->get_settings();

		$subtitle       = $settings['subtitle'];
		$title       = $settings['title'];

		$allowed_html = array(
			'h1'   => array(),
			'h2'   => array(),
			'h3'   => array(),
			'h4'   => array(),
			'h5'   => array(),
			'h6'   => array(),
			'span' => array( 'style' => array(), ),
		);

		?>
        <div class="ep-cf7-contact-form">
            <div class="ep-contact-form-container">
                <div class="ep-section-title-wrapper">
                    <div class="ep-section-title-content">

						<?php if ( $subtitle ) : ?>
                            <div class="ep-section-subtitle ep-primary-color">
								<?php echo wp_kses( $subtitle, $allowed_html ); ?>
                            </div>
						<?php endif; ?>

						<?php if ( $title ) : ?>
                            <div class="ep-section-title">
								<?php echo wp_kses( $title, $allowed_html ); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>

				<?php if ( ! empty( $settings['wpcf7_form_list'] ) ) {?>
                    <div class="hijobs-contact-form-container">
						<?php echo do_shortcode( '[contact-form-7 id="' . $settings['wpcf7_form_list'] . '" ]' );?>
                    </div>
				<?php } ?>
            </div>
        </div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Hijobs_ContactForm7_Layout_One_Widget );