<?php
namespace Elementor;

class HiJobs_Pricing_Table_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_pricing_table';
	}

	public function get_title() {
		return esc_html__( 'Pricing Table', 'hijobs-core' );
	}

	public function get_icon() {
		return 'fas fa-dollar-sign';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'pricing_options',
			[
				'label' => esc_html__( 'Pricing Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => __( 'Title', 'hijobs-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Regular Plan',
			]
		);

		$this->add_control(
			'desc',
			[
				'label'       => __( 'Description', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => 'A beautiful, simple website.',
			]
		);

		$this->add_control(
			'price',
			[
				'label'       => __( 'Price', 'hijobs-core' ),
				'label_block'       => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => '$19.99',
			]
		);

		$this->add_control(
			'time_duration',
			[
				'label'       => __( 'Duration', 'hijobs-core' ),
				'label_block'       => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => '/ Month',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'hijobs-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Choose Plan',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'         => __( 'Button Link', 'hijobs-core' ),
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
			'features_list_settings',
			[
				'label' => esc_html__( 'Pricing Features', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label'       => __( 'Text', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'List Item Text', 'hijobs-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label'            => __( 'Icon', 'hijobs-core' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block'      => true,
				'default'          => [
					'value'   => 'far fa-check-circle',
					'library' => 'regular',
				],
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label'         => __( 'Link', 'hijobs-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'hijobs-core' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'list_items',
			[
				'label'       => __( 'List', 'hijobs-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'text' => __( 'List Item Text', 'hijobs-core' ),
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);
		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>

        <div class="ep-pricing-table">
            <div class="ep-pricing-content-wrapper">
                <div class="pricing-top">
                    <span class="pricing-title"><?php echo esc_html($settings['title']);?></span>

                    <div class="ep-price-desc ep-last-p-0">
                        <?php echo wp_kses_post($settings['desc']);?>
                    </div>
                </div>

                <span class="ep-pricing-price"><?php echo esc_html($settings['price']);?></span>
                <span class="ep-pricing-subscription-period"><?php echo esc_html($settings['time_duration']);?></span>

                <div class="ep-pricing-button">
                    <a class="ep-button" href="<?php echo esc_url($settings['button_link']['url']); ?>" <?php echo esc_attr($target . $nofollow); ?>><?php echo esc_html($settings['btn_text']);?> <i class="fas fa-angle-double-right"></i></a>
                </div>

                <div class="ep-pricing-features">
                    <ul class="ep-list-style">
                        <?php
                        if ( $settings['list_items'] ) {
                            foreach ( $settings['list_items'] as $list_item ) { ?>
                                <li>
                                    <span class="ep-pricing-list-icon ep-primary-color">
                                        <?php hijobs_Custom_Icon_Render( $list_item, 'icon', 'selected_icon' ); ?>
                                    </span>

                                    <?php if ( ! empty( $list_item['item_link']['url'] ) ) :
                                    $target = $list_item['item_link']['is_external'] ? ' target="_blank"' : '';
                                    $nofollow = $list_item['item_link']['nofollow'] ? ' rel="nofollow"' : '';
                                    ?>
                                    <a href="<?php echo esc_url($list_item['item_link']['url']); ?>" <?php echo esc_attr($target . $nofollow); ?>>
                                        <?php endif;
                                        ?>
                                        <?php echo esc_html($list_item['text']); ?>
                                        <?php if ( ! empty( $list_item['item_link']['url'] ) ) : ?>
                                    </a>
                                <?php endif;
                                ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Pricing_Table_Widget );