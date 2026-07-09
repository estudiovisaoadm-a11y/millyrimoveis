<?php
namespace Elementor;

class Listfoloipro_How_It_Works_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_how_it_works';
	}

	public function get_title() {
		return esc_html__( 'How It Works', 'listfoliopro' );
	}

	public function get_icon() {
		return 'far fa-question-circle';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'hiw_options',
			[
				'label' => esc_html__( 'How It Works', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'listfoliopro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'Register Your Account',
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'       => __( 'Description', 'listfoliopro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'You need to create an account to find best preferred job.',
			]
		);

		$repeater->add_control(
            'type',
            [
                'label'       => esc_html__( 'Icon Type', 'listfoliopro' ),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'icon'  => [
                        'title' => esc_html__( 'Icon', 'listfoliopro' ),
                        'icon'  => 'fa fa-smile',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'listfoliopro' ),
                        'icon'  => 'fa fa-image',
                    ],
                ],
                'default'     => 'icon',
                'toggle'      => false,
            ]
        );

		$repeater->add_control(
            'selected_icon',
            [
                'label'            => esc_html__( 'Select Icon', 'listfoliopro' ),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block'      => true,
                'default'          => [
	                'value'   => 'solid',
	                'library' => 'fas fa-bezier-curve',
                ],
                'condition'        => [
                    'type' => 'icon'
                ]
            ]
        );

		$repeater->add_control(
            'image',
            [
                'label'     => esc_html__( 'Image', 'listfoliopro' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'type' => 'image'
                ],
                'dynamic'   => [
                    'active' => true,
                ]
            ]
        );

        $this->add_control(
            'boxes',
            [
                'label'       => __( 'Box List', 'listfoliopro' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title' => 'Register Your Account',
                        'desc' => 'You need to create an account to find best preferred job.',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'box_column_options',
			[
				'label' => esc_html__( 'Column Settings', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'xl_column',
			[
				'label'   => __( 'Desktop', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-3',
				'options' => [
					'col-xl-12'   => __( '1 Column', 'listfoliopro' ),
					'col-xl-6'    => __( '2 Column', 'listfoliopro' ),
					'col-xl-4'    => __( '3 Column', 'listfoliopro' ),
					'col-xl-3'    => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'lg_column',
			[
				'label'   => __( 'iPad Pro', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12'   => __( '1 Column', 'listfoliopro' ),
					'col-lg-6'    => __( '2 Column', 'listfoliopro' ),
					'col-lg-4'    => __( '3 Column', 'listfoliopro' ),
					'col-lg-3'    => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'md_column',
			[
				'label'   => __( 'iPad', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-6',
				'options' => [
					'col-md-12'   => __( '1 Column', 'listfoliopro' ),
					'col-md-6'    => __( '2 Column', 'listfoliopro' ),
					'col-md-4'    => __( '3 Column', 'listfoliopro' ),
					'col-md-3'    => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'sm_column',
			[
				'label'   => __( 'Mobile', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-12',
				'options' => [
					'col-12'   => __( '1 Column', 'listfoliopro' ),
					'col-6'    => __( '2 Column', 'listfoliopro' ),
					'col-4'    => __( '3 Column', 'listfoliopro' ),
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		?>

		<div class="how-it-works-wrapper bootstrap-wrapper">
			<div class="container">
				<div class="row">
					<?php if ( $settings['boxes'] ) {
						foreach ( $settings['boxes'] as $box ) { ?>
                            <div class="<?php echo esc_attr($ep_column); ?> hiw-item-column">
                                <div class="hiw-item">
                                    <div class="hiw-icon">
                                        <?php if ( $box['type'] === 'image' && $box['image']['id'] ) : ?>
                                        <img src="<?php echo esc_url($box['image']['url']); ?>"
                                        alt="<?php echo get_post_meta( $box['image']['id'], '_wp_attachment_image_alt', true ); ?>">
                                        <?php elseif ( ! empty( $box['icon'] ) || ! empty( $box['selected_icon'] ) ) :
	                                        listfoliopro_custom_icon_render( $box, 'icon', 'selected_icon' );
                                        endif; ?>
                                    </div>

                                    <h4 class="hiw-title"><?php echo esc_html($box['title']);?></h4>

                                    <div class="hiw-desc">
	                                    <?php echo wp_kses_post($box['desc']);?>
                                    </div>
                                </div>
                            </div>
						<?php }
					} ?>

				</div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Listfoloipro_How_It_Works_Widget );