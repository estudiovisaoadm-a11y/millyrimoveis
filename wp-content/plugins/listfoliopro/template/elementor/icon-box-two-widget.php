<?php
namespace Elementor;

class ListfolioPro_Icon_Box_Two_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_icon_box_two';
	}

	public function get_title() {
		return esc_html__( 'Icon Box Two', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'icon_box_settings',
			[
				'label' => esc_html__( 'Service Box', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'listfoliopro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Convert Revenue',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'icon_type',
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
						'icon'  => 'far fa-image',
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
				'condition'        => [
					'icon_type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'icon_image',
			[
				'label'     => esc_html__( 'Icon Image', 'listfoliopro' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'icon_type' => 'image'
				],
				'dynamic'   => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'enable_border',
			[
				'label'     => esc_html__( 'Enable Border', 'listfoliopro' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
				'label_off' => esc_html__( 'No', 'listfoliopro' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'icon_boxes',
			[
				'label'       => __( 'Icon Box List', 'listfoliopro' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title' => 'Convert Revenue',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'icon_box_column',
			[
				'label' => esc_html__( 'Column', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_col',
			[
				'label'   => __( 'Columns On Desktop', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-4',
				'options' => [
					'col-xl-12' => __( '1 Column', 'listfoliopro' ),
					'col-xl-6'  => __( '2 Column', 'listfoliopro' ),
					'col-xl-4'  => __( '3 Column', 'listfoliopro' ),
					'col-xl-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'iPad_pro_col',
			[
				'label'   => __( 'Columns On iPad Pro', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12' => __( '1 Column', 'listfoliopro' ),
					'col-lg-6'  => __( '2 Column', 'listfoliopro' ),
					'col-lg-4'  => __( '3 Column', 'listfoliopro' ),
					'col-lg-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->add_control(
			'tab_col',
			[
				'label'   => __( 'Columns On Tablet', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-6',
				'options' => [
					'col-md-12' => __( '1 Column', 'listfoliopro' ),
					'col-md-6'  => __( '2 Column', 'listfoliopro' ),
					'col-md-4'  => __( '3 Column', 'listfoliopro' ),
					'col-md-3'  => __( '4 Column', 'listfoliopro' ),
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();

		$column = $settings['desktop_col'] . ' ' . $settings['iPad_pro_col'] . ' ' . $settings['tab_col'];
		?>

		<div class="icon-box-two-wrapper bootstrap-wrapper">
			<div class="container">
                <div class="row">
                    <?php if ( $settings['icon_boxes'] ) {
                        foreach ( $settings['icon_boxes'] as $icon_box ) {
                            ?>
                            <div class="<?php echo esc_attr($column); if ($icon_box['enable_border'] == 'yes'){echo ' icon-box-right-border';}?>">
                                <div class="single-icon-box-two-item">
                                    <div class="icon-box-two-icon">
                                        <?php if ( $icon_box['icon_type'] === 'image' && $icon_box['icon_image']['id'] ) : ?>
                                            <img src="<?php echo esc_url($icon_box['icon_image']['url']); ?>" alt="<?php echo get_post_meta( $icon_box['icon_image']['id'], '_wp_attachment_image_alt', true ); ?>">
                                        <?php elseif ( ! empty( $icon_box['icon'] ) || ! empty( $icon_box['selected_icon'] ) ) :
                                            listfoliopro_custom_icon_render( $icon_box, 'icon', 'selected_icon' );
                                        endif; ?>
                                    </div>

                                    <h4 class="icon-box-two-title"><?php echo esc_html($icon_box['title']);?></h4>
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

Plugin::instance()->widgets_manager->register( new ListfolioPro_Icon_Box_Two_Widget );