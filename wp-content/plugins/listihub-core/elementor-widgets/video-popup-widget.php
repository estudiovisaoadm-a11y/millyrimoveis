<?php
namespace Elementor;

class HiJobs_Video_Popup_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_video_popup';
	}

	public function get_title() {
		return esc_html__( 'Video Popup', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-youtube';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'video_popup_options',
			[
				'label' => esc_html__( 'Video Popup', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'video_image',
		    [
		        'label'       => __( 'Image', 'hijobs-core' ),
		        'type'        => Controls_Manager::MEDIA,
		        'label_block' => true,
		        'default'     => [
		            'url' => Utils::get_placeholder_image_src(),
		        ],
		    ]
		);

		$this->add_control(
		    'video_url',
		    [
		        'label'       => __( 'Video URL', 'hijobs-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'https://vimeo.com/100902001',
		    ]
		);

        $this->add_control(
            'enable_overlay',
            [
                'label'     => esc_html__( 'Enable Overlay', 'hijobs-core' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
                'label_off' => esc_html__( 'No', 'hijobs-core' ),
                'default'   => 'no',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
		    'video_popup_style',
		    [
		        'label' => esc_html__( 'Video Popup', 'hijobs-core' ),
		        'tab'   => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'video_height',
		    [
		        'label' => esc_html__( 'Height', 'hijobs-core' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 1000,
		            ],
		        ],
		        'devices' => [ 'desktop', 'tablet', 'mobile' ],

		        'selectors' => [
		            '{{WRAPPER}} .ep-video-image' => 'height: {{SIZE}}px;',
		        ],
		    ]
		);


		$this->add_responsive_control(
			'btn_size',
			[
				'label' => esc_html__( 'Button Size', 'hijobs-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 150,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],

				'selectors' => [
					'{{WRAPPER}} .ep-video-button:before,{{WRAPPER}} .ep-video-button:after' => 'height: {{SIZE}}px;width: {{SIZE}}px;',
				],
			]
		);

        $this->add_control(
            'btn_bg_color',
            [
                'label'       => esc_html__('Button Background Color', 'hijobs-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ep-video-button:before,{{WRAPPER}} .ep-video-button:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_control(
			'btn_color',
			[
				'label'       => esc_html__('Button Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-video-button i' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'overlay_color',
            [
                'label'       => esc_html__('Overlay Color', 'hijobs-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ep-video-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_overlay' => 'yes',
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
		            '{{WRAPPER}} .ep-img-with-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="ep-img-with-video">
            <?php if($settings['enable_overlay'] == 'yes') :?>
            <div class="ep-video-overlay"></div>
            <?php endif; ?>
			<div class="ep-video-image ep-cover-bg" style="background-image: url(<?php echo esc_url($settings['video_image']['url']);?>);">
				<a href="<?php echo esc_url($settings['video_url']);?>" class="ep-video-button mfp-iframe">
					<i class="fas fa-play"></i>
				</a>
			</div>
		</div>

        <script>
            jQuery(document).ready(function ($) {
                $(".ep-video-button").magnificPopup({
                    type: 'video',
                });
            });
        </script>

		<?php

	}

	//Template
	protected function content_template() { ?>
        <div class="ep-img-with-video">
            <# if ( settings.enable_overlay == 'yes' ) { #>
            <div class="ep-video-overlay"></div>
            <# } #>
            <div class="ep-video-image ep-cover-bg" style="background-image: url({{{settings.video_image.url}}});">
                <a href="{{{settings.video_url}}}" class="ep-video-button mfp-iframe">
                    <i class="fas fa-play"></i>
                </a>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                $(".ep-video-button").magnificPopup({
                    type: 'video',
                });
            });
        </script>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Video_Popup_Widget );