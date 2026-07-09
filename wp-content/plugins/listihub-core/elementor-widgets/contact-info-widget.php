<?php
namespace Elementor;

class Hijobs_Contact_Info_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_contact_info';
	}

	public function get_title() {
		return esc_html__( 'Contact Info', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-alert';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		//Content tab start
		$this->start_controls_section(
			'contact_info_settings',
			[
				'label' => esc_html__( 'Contact Info', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __('Title', 'hijobs-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Call Us',
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'desc',
			[
				'label'   => __('Description', 'hijobs-core'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => 'Description Text Here',
			]
		);


		$repeater->add_control(
			'type',
			[
				'label'       => __( 'Icon Type', 'hijobs-core' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'icon'  => [
						'title' => __( 'Icon', 'hijobs-core' ),
						'icon'  => 'far fa-smile',
					],
					'image' => [
						'title' => __( 'Image', 'hijobs-core' ),
						'icon'  => 'fas fa-image',
					],
				],
				'default'     => 'icon',
				'toggle'      => false,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'       => __( 'Select Icon', 'hijobs-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => true,
				'default'          => [
					'value'   => 'fas fa-map-marker-alt',
					'library' => 'solid',
				],
				'condition'        => [
					'type' => 'icon'
				]
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'     => __( 'Image', 'hijobs-core' ),
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
			'info_list',
			[
				'label'       => __('Info List', 'hijobs-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'title'        => 'Call Us',
						'desc' => 'Description Text Here',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>
		<div class="ep-contact-info-container">
			<div class="row">
				<?php if ( $settings['info_list'] ) {
					foreach ( $settings['info_list'] as $info ) { ?>
						<div class="col-lg-4 col-md-6 info-item-column">
							<div class="ep-single-contact-info">
								<div class="ep-contact-info-icon">
									<?php if ( $info['type'] === 'image' ) :
										if ( $info['image']['url'] || $info['image']['id'] ) :
											?>
											<div class="ep-image-icon">
												<img src="<?php echo esc_url($info['image']['url']); ?>"
												     alt="<?php echo get_post_meta( $info['image']['id'], '_wp_attachment_image_alt', true ); ?>">
											</div>
										<?php endif;
									elseif ( ! empty( $info['icon'] ) || ! empty( $info['selected_icon'] ) ) : ?>
										<div class="ep-font-icon">
											<?php hijobs_custom_icon_render( $info, 'icon', 'selected_icon' ); ?>
										</div>
									<?php endif; ?>
								</div>

								<h6 class="contact-info-title"><?php echo esc_html($info['title']);?></h6>

								<div class="contact-info-content">
									<?php echo wp_kses_post($info['desc']);?>
								</div>
							</div>
						</div>

						<?php
					}
				} ?>
			</div>
		</div>
		<?php

	}
}

Plugin::instance()->widgets_manager->register( new Hijobs_Contact_Info_Widget );