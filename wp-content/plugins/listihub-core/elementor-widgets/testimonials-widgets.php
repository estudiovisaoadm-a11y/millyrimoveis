<?php
namespace Elementor;

class HiJobs_Testimonials_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_testmonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'testimonial_settings',
			[
				'label' => esc_html__( 'Testimonials', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'label'       => esc_html__( 'Name', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Andrew D. Smith',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label'       => esc_html__( 'Designation', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Manager',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'hijobs-core' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>“According to the council supply chain professionals the council of the logistics management logistics is the process of planning, implanting & controlling for procedures and solving the life projects all over life boundaries and more peoples says.”</p>',
			]
		);

		$repeater->add_control(
			'person_image',
			[
				'label'       => __( 'Person Image', 'hijobs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'logo_image',
			[
				'label'       => __( 'Logo Image', 'hijobs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => esc_html__( 'Testimonials List', 'hijobs-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'name'        => 'Andrew D. Smith',
						'designation' => 'Manager',
						'description' => '<p>“According to the council supply chain professionals the council of the logistics management logistics is the process of planning, implanting & controlling for procedures and solving the life projects all over life boundaries and more peoples says.”</p>',
					],
				],
				'title_field' => '{{{ name }}}',
			]
		);

		$this->end_controls_section();

		// Slider Options
		$this->start_controls_section(
			'slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'       => esc_html__( 'Autoplay', 'hijobs-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'       => esc_html__( 'Navigation Dots', 'hijobs-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_column',
			[
				'label'       => esc_html__( 'Column On Desktop', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'hijobs-core' ),
					2 => __( '2 Column', 'hijobs-core' ),
					3 => __( '3 Column', 'hijobs-core' ),
					4 => __( '4 Column', 'hijobs-core' ),
				],
				'default'     => 2,
			]
		);

		$this->add_control(
			'ipadpro_column',
			[
				'label'       => __( 'Column On iPad Pro', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'hijobs-core' ),
					2 => __( '2 Column', 'hijobs-core' ),
					3 => __( '3 Column', 'hijobs-core' ),
					4 => __( '4 Column', 'hijobs-core' ),
				],
				'default'     => 2,
			]
		);

		$this->add_control(
			'tab_column',
			[
				'label'       => __( 'Column On Tablet', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'hijobs-core' ),
					2 => __( '2 Column', 'hijobs-core' ),
					3 => __( '3 Column', 'hijobs-core' ),
					4 => __( '4 Column', 'hijobs-core' ),
				],
				'default'     => 1,
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'testimonial_style_options',
            [
                'label' => esc_html__( 'Testimonial', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label'       => esc_html__('Item Background Color', 'themedraft-core'),
                'type'        => Controls_Manager::COLOR,
                'selectors'   => [
                    '{{WRAPPER}} .ep-testimonial-one-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$testimonial_id = rand(10, 10000);
		?>

        <div class="testimonial-one-wrapper">
            <div class="container">
                <div class="row" id="ep-testimonial-<?php echo esc_attr($testimonial_id);?>">
	                <?php
	                if ($settings['testimonials']) {
		                foreach ($settings['testimonials'] as $testimonial) {
			                $person_image_src   = $testimonial['person_image']['url'];
			                $logo_image_src   = $testimonial['logo_image']['url'];
                            $logo_image_alt = get_post_meta( $testimonial['logo_image']['id'], '_wp_attachment_image_alt', true );
			                ?>
                            <div class="col-12">
                                <div class="ep-testimonial-one-item">
                                    <div class="ep-testimonial-desc">
			                            <?php echo wp_kses_post($testimonial['description']); ?>
                                    </div>

                                    <div class="ep-testimonial-person-info">
                                        <div class="person-details">
                                            <div class="ep-testimonial-image ep-cover-bg" style="background-image: url(<?php echo esc_url($person_image_src);?>)"></div>
                                            <h6 class="person-name"><?php echo esc_html($testimonial['name']);?></h6>
                                            <span class="designation ep-primary-color"><?php echo esc_html($testimonial['designation']);?></span>
                                        </div>

                                        <div class="company-logo">
                                            <img src="<?php echo esc_url($logo_image_src);?>" alt="<?php echo esc_attr($logo_image_alt);?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
		                <?php }
	                } ?>
                </div>
            </div>
        </div>

        <script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    $("#ep-testimonial-<?php echo esc_js($testimonial_id);?>").slick({
                        slidesToShow: <?php echo json_encode( $settings['desktop_column'] )?>,
                        autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                        autoplaySpeed: 4000,
                        speed: 1500, // slide speed
                        dots: <?php echo json_encode( $settings['dots'] == 'yes' ? true : false ); ?>,
                        arrows: false,
                        prevArrow: '<i class="slick-arrow slick-prev flaticon-right-arrow"></i>',
                        nextArrow: '<i class="slick-arrow slick-next flaticon-right-arrow"></i>',
                        infinite:  true,
                        fade: false,
                        pauseOnHover: false,
                        centerMode: false,
                        responsive: [
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['ipadpro_column'] )?>, // 992-1024
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['tab_column'] )?>, //768-991
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1, // 0 -767
                                    dots: false,
                                }
                            }
                        ]
                    });
                });
            })(jQuery);
        </script>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new HiJobs_Testimonials_Widget );