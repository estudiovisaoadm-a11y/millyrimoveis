<?php
namespace Elementor;

class HiJobs_Text_Button_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_text_button_widget';
	}

	public function get_title() {
		return esc_html__( 'Text Button', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'button_one_option',
			[
				'label' => esc_html__( 'Button One', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_one_text',
			[
				'label'       => __( 'Text', 'hijobs-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Click Here'
			]
		);

		$this->add_control(
			'btn_one_url',
			[
				'label'         => __( 'URL', 'hijobs-core' ),
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

		$this->end_controls_section();

		$this->start_controls_section(
			'button_one_style_options',
			[
				'label' => esc_html__( 'Button One', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('td_btn_one_style_tabs');

		//Default style tab start
		$this->start_controls_tab(
			'td_btn_one_style_default',
			[
				'label' => esc_html__('Default', 'hijobs-core'),
			]
		);

		$this->add_control(
			'btn_one_default_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hijobs-button.hijobs-button-one' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();//Default style tab end

		//Hover style tab start
		$this->start_controls_tab(
			'td_btn_one_style_hover',
			[
				'label' => esc_html__('Hover', 'hijobs-core'),
			]
		);

		$this->add_control(
			'btn_one_hover_text_color',
			[
				'label'     => esc_html__('Text Color', 'hijobs-core'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a.hijobs-button.hijobs-button-one:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tabs();//Hover style tab end
		$this->end_controls_section();

		$this->start_controls_section(
			'button_wrapper_style_options',
			[
				'label' => esc_html__( 'Wrapper', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'       => esc_html__('Alignment', 'hijobs-core'),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,

				'options' => [
					'left' => [
						'title' => __('Left', 'hijobs-core'),
						'icon'  => 'eicon-text-align-left',
					],

					'center' => [
						'title' => __('Center', 'hijobs-core'),
						'icon'  => 'eicon-text-align-center',
					],

					'right' => [
						'title' => __('Right', 'hijobs-core'),
						'icon'  => 'eicon-text-align-right',
					],
				],

				'devices' => ['desktop', 'tablet', 'mobile'],

				'selectors' => [
					'{{WRAPPER}} .hijobs-button-wrapper' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .hijobs-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$btn_one_text = $settings['btn_one_text'];
		$btn_one_url   = $settings['btn_one_url']['url'];
		$btn_one_target   = $settings['btn_one_url']['is_external'] ? ' target="_blank"' : '';
		$btn_one_nofollow = $settings['btn_one_url']['nofollow'] ? ' rel="nofollow"' : '';
		?>

		<div class="hijobs-button-wrapper ep-button-el-widget">
			<a href="<?php echo esc_url($btn_one_url);?>" class="hijobs-button ep-text-button hijobs-button-one" <?php echo esc_attr($btn_one_target . $btn_one_nofollow);?>><?php echo esc_html($btn_one_text);?>
                <i class="fas fa-angle-double-right"></i>
            </a>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Text_Button_Widget );