<?php

namespace Elementor;

class HiJobs_Brand_Image_Slider extends Widget_Base {

	public function get_name() {

		return "hijobs_brand_image_slider";
	}

	public function get_title() {
		return __( "Brand Image Slider", "hijobs-core" );
	}

	public function get_icon() {

		return "eicon-slider-push";
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		//Slider Images
		$this->start_controls_section(
			'brand_slider_images',
			[
				'label' => __( 'Images', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_image_link',
			[
				'label'     => esc_html__( 'Enable Image Link', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'no',
			]
		);

		//Repeater Start
		$repeater = new Repeater();

		$repeater->add_control(
			'brand_name',
			[
				'label'       => esc_html__( 'Brand Name', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'This field is optional.', 'hijobs-core' ),
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => esc_html__( 'Image', 'hijobs-core' ),
				'description' => esc_html__( '', 'hijobs-core' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'image_link',
			[
				'label'         => esc_html__( 'Image Link', 'hijobs-core' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_url( 'https://your-link.com' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'brands',
			[
				'label'       => esc_html__( 'Images', 'hijobs-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ brand_name }}}',
				'condition' => [
					'enable_image_link' => 'yes',
				],
			]
		);
		//Repeater End

		$this->add_control(
			'brand_images',
			[
				'label' => __( 'Add Images', 'hijobs-core' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'condition' => [
					'enable_image_link!' => 'yes',
				],
			]
		);


		$this->end_controls_section();

		//Slider Options
		$this->start_controls_section(
			'brand_slider_options',
			[
				'label' => __( 'Slider Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'       => __( 'Autoplay', 'hijobs-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'no',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'       => __( 'Autoplay Interval', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					'2000'  => __( '2 seconds', 'hijobs-core' ),
					'3000'  => __( '3 seconds', 'hijobs-core' ),
					'4000'  => __( '4 seconds', 'hijobs-core' ),
					'5000'  => __( '5 seconds', 'hijobs-core' ),
					'6000'  => __( '6 seconds', 'hijobs-core' ),
					'7000'  => __( '7 seconds', 'hijobs-core' ),
					'8000'  => __( '8 seconds', 'hijobs-core' ),
					'9000'  => __( '9 seconds', 'hijobs-core' ),
					'10000' => __( '10 seconds', 'hijobs-core' ),
				],
				'default'     => '4000',
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'infinity_loop',
			[
				'label'       => __( 'Loop', 'hijobs-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'   => __( 'Desktop Column', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 6,
				'options' => [
					1  => __( '1 Column', 'hijobs-core' ),
					2  => __( '2 Column', 'hijobs-core' ),
					3  => __( '3 Column', 'hijobs-core' ),
					4  => __( '4 Column', 'hijobs-core' ),
					5  => __( '5 Column', 'hijobs-core' ),
					6  => __( '6 Column', 'hijobs-core' ),
					7  => __( '7 Column', 'hijobs-core' ),
					8  => __( '8 Column', 'hijobs-core' ),
					9  => __( '9 Column', 'hijobs-core' ),
					10 => __( '10 Column', 'hijobs-core' ),
					11 => __( '11 Column', 'hijobs-core' ),
					12 => __( '12 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'ipad_pro_count',
			[
				'label'   => __( 'iPad Pro Column', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 5,
				'options' => [
					1  => __( '1 Column', 'hijobs-core' ),
					2  => __( '2 Column', 'hijobs-core' ),
					3  => __( '3 Column', 'hijobs-core' ),
					4  => __( '4 Column', 'hijobs-core' ),
					5  => __( '5 Column', 'hijobs-core' ),
					6  => __( '6 Column', 'hijobs-core' ),
					7  => __( '7 Column', 'hijobs-core' ),
					8  => __( '8 Column', 'hijobs-core' ),
					9  => __( '9 Column', 'hijobs-core' ),
					10 => __( '10 Column', 'hijobs-core' ),
					11 => __( '11 Column', 'hijobs-core' ),
					12 => __( '12 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'tab_count',
			[
				'label'   => __( 'Tablet Column', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 4,
				'options' => [
					1  => __( '1 Column', 'hijobs-core' ),
					2  => __( '2 Column', 'hijobs-core' ),
					3  => __( '3 Column', 'hijobs-core' ),
					4  => __( '4 Column', 'hijobs-core' ),
					5  => __( '5 Column', 'hijobs-core' ),
					6  => __( '6 Column', 'hijobs-core' ),
					7  => __( '7 Column', 'hijobs-core' ),
					8  => __( '8 Column', 'hijobs-core' ),
					9  => __( '9 Column', 'hijobs-core' ),
					10 => __( '10 Column', 'hijobs-core' ),
					11 => __( '11 Column', 'hijobs-core' ),
					12 => __( '12 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'mobile_count',
			[
				'label'   => __( 'Mobile Column', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 2,
				'options' => [
					1 => __( '1 Column', 'hijobs-core' ),
					2 => __( '2 Column', 'hijobs-core' ),
					3 => __( '3 Column', 'hijobs-core' ),
					4 => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_options',
			[
				'label' => esc_html__( 'Wrapper', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'wrapper_height',
			[
				'label'     => __( 'Wrapper Height', 'hijobs-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'description'   => __('Useful for different height\'s image.', 'hijobs-core' ),
				'selectors' => [
					'{{WRAPPER}} .ep-brand-item.slick-slide' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ep-brand-images' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'enable_grayscale',
			[
				'label'     => esc_html__( 'Enable Grayscale', 'hijobs-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'hijobs-core' ),
				'label_off' => esc_html__( 'No', 'hijobs-core' ),
				'default'   => 'no',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_style',
			[
				'label' => esc_html__( 'Slider Style', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__('Title Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .brand-slider-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}


	//Render In HTML
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_id = rand(100, 1000);

		?>

		<div class="ep-brand-img-wrapper">
			<div class="container <?php if($settings['enable_grayscale'] == 'yes'){echo 'ep-grayscale-enable';}?>">
				<div class="row">
					<div class="col-lg-12">
						<div id="ep-brand-slider-<?php echo esc_attr($slider_id);?>" class="ep-brand-images">
							<?php if($settings['enable_image_link'] == 'yes') : ?>

								<?php foreach ( $settings['brands'] as $brand ) :

									$target = $brand['image_link']['is_external'] ? ' target="_blank"' : '';
									$nofollow = $brand['image_link']['nofollow'] ? ' rel="nofollow"' : '';

									$image_src = $brand['image']['url'];
									$image_alt = get_post_meta( $brand['image']['id'], '_wp_attachment_image_alt', true );
									$image_title = get_the_title( $brand['image']['id']);

									$image_link = $brand['image_link']['url'];

									?>
									<div class="ep-brand-item">
										<div class="ep-table">
											<div class="ep-table-cell">
												<?php if ( $image_link ) : ?>
												<a href="<?php echo esc_url($image_link);?>" <?php echo esc_attr($target . $nofollow);?>>
													<?php endif; ?>

													<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">

													<?php if ( $image_link ) : ?>
												</a>
											<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endforeach;?>
							<?php else : ?>


								<?php foreach ($settings['brand_images'] as $brand ) :
									$image_src = $brand['url'];
									$image_alt = get_post_meta( $brand['id'], '_wp_attachment_image_alt', true );
									$image_title = get_the_title( $brand['id']);
									?>
									<div class="ep-brand-item">
										<div class="ep-table">
											<div class="ep-table-cell">
												<img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
											</div>
										</div>
									</div>
								<?php endforeach;?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    $("#ep-brand-slider-<?php echo esc_js($slider_id);?>").slick({
                        slidesToShow: <?php echo json_encode( $settings['desktop_count'] )?>,
                        autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                        autoplaySpeed: <?php echo json_encode( $settings['autoplay_interval'] )?>, //interval
                        speed: 1500, // slide speed
                        dots: false,
                        arrows: false,
                        prevArrow: '<i class="slick-arrow slick-prev eicon-chevron-left"></i>',
                        nextArrow: '<i class="slick-arrow slick-next eicon-chevron-right"></i>',
                        infinite: <?php echo json_encode( $settings['infinity_loop'] == 'yes' ? true : false ); ?>,
                        pauseOnHover: false,
                        centerMode: false,
                        responsive: [
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['ipad_pro_count'] )?>, // 992-1024
                                    arrows: false,
                                }
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['tab_count'] )?>, //768-991
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['mobile_count'] )?>, // 0 -767
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

Plugin::instance()->widgets_manager->register( new HiJobs_Brand_Image_Slider );