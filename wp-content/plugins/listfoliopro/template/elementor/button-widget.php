<?php
namespace Elementor;

class ListfolioPro_Button_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_button';
	}

	public function get_title() {
		return esc_html__( 'LFP Button', 'listihub-core' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'button_options',
			[
				'label' => esc_html__( 'Button Options', 'listihub-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'listihub-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Browse All', 'listfoliopro-core' ),
			]
		);

		$this->add_control(
			'btn_url',
			[
				'label'         => __( 'Button URL', 'listihub-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'listihub-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

        $this->add_responsive_control(
            'text_align',
            [
                'label'       => esc_html__('Text Align', 'listihub-core'),
                'description' => esc_html__('', 'listihub-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,

                'options' => [
                    'left' => [
                        'title' => __('Left', 'listihub-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],

                    'center' => [
                        'title' => __('Center', 'listihub-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],

                    'right' => [
                        'title' => __('Right', 'listihub-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],

                'devices' => ['desktop', 'tablet', 'mobile'],

                'selectors' => [
                    '{{WRAPPER}} .listfoliopro-button-wrapper' => 'text-align: {{VALUE}};',
                ],

            ]
        );

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="listfoliopro-button-wrapper">
			<a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="listfoliopro-button"><?php echo esc_html($settings['btn_text']);?>
				<svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</a>
		</div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Button_Widget );