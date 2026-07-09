<?php
namespace Elementor;

class Hijobs_Counter_Up_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_counter_up';
	}

	public function get_title() {
		return esc_html__( 'Counter Up', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	public function get_script_depends() {
		return ['counterup'];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'counter_up_options',
			[
				'label' => esc_html__( 'Counter Up', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'count_title',
			[
				'label'       => __( 'Count Title', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Counter Title',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'count_number',
			[
				'label'       => __( 'Count Number', 'hijobs-core' ),
				'label_block'       => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => '100',
			]
		);

		$repeater->add_control(
            'count_unit',
            [
                'label'       => __( 'Unit', 'themedraft-core' ),
                'label_block'       => false,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'K',
            ]
        );

		$this->add_control(
			'count_boxes',
			[
				'label'       => __('Count Box List', 'hijobs-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'count_title'        => 'Counter Title',
						'count_number' => '100',
						'count_unit' => 'K',
					],
				],
				'title_field' => '{{{ count_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'counter_column_options',
			[
				'label' => esc_html__( 'Column Settings', 'hijobs-core' ),
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
				'default' => 'col-lg-3',
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
				'default' => 'col-md-3',
				'options' => [
					'col-md-12'   => __( '1 Column', 'hijobs-core' ),
					'col-md-6'    => __( '2 Column', 'hijobs-core' ),
					'col-md-4'    => __( '3 Column', 'hijobs-core' ),
					'col-md-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'sm_column',
			[
				'label'   => __( 'Mobile', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-6',
				'options' => [
					'col-12'   => __( '1 Column', 'hijobs-core' ),
					'col-6'    => __( '2 Column', 'hijobs-core' ),
					'col-4'    => __( '3 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'count_up_style',
            [
                'label' => esc_html__( 'Counter Up', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => esc_html__( 'Background', 'themedraft-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .ep-count-box-wrapper',
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'       => esc_html__('Border Color', 'themedraft-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .count-box-column:not(:last-child):before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$count_id = rand(100, 100000);
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column']. ' '. $settings['sm_column'];
		?>
		<div class="ep-count-box-wrapper ep-primary-bg ep-counter-box-<?php echo esc_attr($count_id);?>">
			<div class="container">
                <div class="ep-counter-up-wrapper">
                    <div class="row">
	                    <?php if ( $settings['count_boxes'] ) {
	                    foreach ( $settings['count_boxes'] as $count_box ) {
	                    ?>
                            <div class="<?php echo esc_attr($ep_column); ?> count-box-column">
                                <div class="ep-single-counter-box">
                                    <div class="ep-count-content">
                                        <div class="count-number-and-unit">
                                            <span class="ep-count-number"><?php echo esc_html( $count_box['count_number'] ); ?></span>
                                            <span class="ep-count-unit"><?php echo esc_html( $count_box['count_unit'] ); ?></span>
                                        </div>
                                        <span class="ep-counter-title"><?php echo esc_html( $count_box['count_title'] ); ?></span>
                                    </div>
                                </div>
                            </div>
		                    <?php
	                    }
	                    } ?>
                    </div>
                </div>
			</div>
		</div>

		<script>
            (function ($) {
                "use strict";
                /*====  Document Ready Function =====*/
                jQuery(document).ready(function($){
                    $(".ep-counter-box-<?php echo esc_attr($count_id);?> .ep-count-number").counterUp({
                        delay: 10,
                        time: 2000
                    });
                });
            }(jQuery));
		</script>
		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new Hijobs_Counter_Up_Widget );