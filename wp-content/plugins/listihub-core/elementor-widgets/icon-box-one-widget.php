<?php
namespace Elementor;

class HiJobs_Icon_Box_One_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_icon_box_one';
	}

	public function get_title() {
		return esc_html__( 'Icon Box One', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-favorite';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'icon_box_options',
			[
				'label' => esc_html__( 'Icon Box', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $repeater = new Repeater();

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

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'Perfect Search Lists',
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'       => __( 'Description', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'Seamlessly envisioneer tactical data through services.',
			]
		);

        $this->add_control(
            'icon_boxes',
            [
                'label'       => __( 'Icon Box List', 'themedraft-core' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title' => 'Perfect Search Lists',
                        'desc' => 'Seamlessly envisioneer tactical data through services.',
                    ],
                ],

                'title_field' => '{{{ title }}}',
            ]
        );



		$this->end_controls_section();

		$this->start_controls_section(
			'column_options',
			[
				'label' => esc_html__( 'Column', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'xl_column',
			[
				'label'   => __( 'Desktop', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-3',
				'options' => [
					'col-xl-12'   => __( '1 Column', 'hijobs-core' ),
					'col-xl-6'    => __( '2 Column', 'hijobs-core' ),
					'col-xl-4'    => __( '3 Column', 'hijobs-core' ),
					'col-xl-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'lg_column',
			[
				'label'   => __( 'iPad Pro', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12'   => __( '1 Column', 'hijobs-core' ),
					'col-lg-6'    => __( '2 Column', 'hijobs-core' ),
					'col-lg-4'    => __( '3 Column', 'hijobs-core' ),
					'col-lg-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'md_column',
			[
				'label'   => __( 'iPad', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-6',
				'options' => [
					'col-md-12'   => __( '1 Column', 'hijobs-core' ),
					'col-md-6'    => __( '2 Column', 'hijobs-core' ),
					'col-md-4'    => __( '3 Column', 'hijobs-core' ),
					'col-md-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column'];
		?>

		<div class="row">
			<?php if ( $settings['icon_boxes'] ) {
				foreach ( $settings['icon_boxes'] as $icon_box ) { ?>
                    <div class="<?php echo esc_attr($ep_column);?>">
                        <div class="icon-box-one-wrapper">
                            <div class="icon-box-one-icon ep-primary-color">
								<?php hijobs_custom_icon_render( $icon_box, 'icon', 'selected_icon' );?>
                            </div>

                            <h3 class="icon-box-one-title"><?php echo esc_html($icon_box['title']);?></h3>

                            <div class="icon-box-one-desc">
								<?php echo wp_kses_post($icon_box['desc']);?>
                            </div>
                        </div>
                    </div>
				<?php }
			} ?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Icon_Box_One_Widget );