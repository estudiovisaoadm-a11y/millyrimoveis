<?php
namespace Elementor;

class ListfolioPro_Testimonial_One_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_testimonial_one';
	}

	public function get_title() {
		return esc_html__( 'Testimonial One', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

        $this->start_controls_section(
            'left_list',
            [
                'label' => esc_html__( 'Left List', 'listfoliopro' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$repeater = new Repeater();

		$repeater->add_control(
			'list_item_text',
			[
				'label'       => __('List Item', 'listfoliopro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('10K+ Customers', 'listfoliopro'),
				'label_block' => true,
			]
		);

		$this->add_control(
			'lists',
			[
				'label'       => __('Lists', 'listfoliopro'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'list_item_text'        => __('10K+ Customers', 'listfoliopro'),
					],
				],
				'title_field' => '{{{ list_item_text }}}',
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'testimonial_options',
			[
				'label' => esc_html__( 'Testimonials', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'person_image',
			[
				'label'       => __( 'Person Image', 'listfoliopro' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'person_name',
			[
				'label'       => __('Person Name', 'listfoliopro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Sarah Johnson', 'listfoliopro'),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'person_designation',
			[
				'label'       => __('Person Designation', 'listfoliopro'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Managing Director', 'listfoliopro'),
				'label_block' => true,
			]
		);


		$repeater->add_control(
			'testimonial_text',
			[
				'label'   => __('Testimonial Text', 'listfoliopro'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __('I\'ve been using this website for a while now, and it\'s become my go-to resource for finding investment auto. The user-friendly interface and comprehensive property listings make my job so much easier."', 'listfoliopro'),
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label'       => __('Testimonials List', 'listfoliopro'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'person_name'        => __('Sarah Johnson', 'listfoliopro'),
						'person_designation'        => __('Managing Director', 'listfoliopro'),
						'testimonial_text' => __('I\'ve been using this website for a while now, and it\'s become my go-to resource for finding investment cars. The user-friendly interface and comprehensive property listings make my job so much easier.', 'listfoliopro'),
					],
				],
				'title_field' => '{{{ person_name }}}',
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'listfoliopro' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Browse All', 'listfoliopro-core' ),
			]
		);

		$this->add_control(
			'btn_url',
			[
				'label'         => __( 'Button URL', 'listfoliopro' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'listfoliopro' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label'       => __( 'Autoplay', 'listfoliopro' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'       => __( 'Autoplay Interval', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					'2000'  => __( '2 seconds', 'listfoliopro' ),
					'3000'  => __( '3 seconds', 'listfoliopro' ),
					'4000'  => __( '4 seconds', 'listfoliopro' ),
					'5000'  => __( '5 seconds', 'listfoliopro' ),
					'6000'  => __( '6 seconds', 'listfoliopro' ),
					'7000'  => __( '7 seconds', 'listfoliopro' ),
					'8000'  => __( '8 seconds', 'listfoliopro' ),
					'9000'  => __( '9 seconds', 'listfoliopro' ),
					'10000' => __( '10 seconds', 'listfoliopro' ),
				],
				'default'     => '4000',
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'infinity_loop',
			[
				'label'       => __( 'Loop', 'listfoliopro' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'nav_arrow',
			[
				'label'       => __( 'Navigation Arrow', 'listfoliopro' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);
		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_id = rand(100, 100000);
		?>

		<div class="testimonial-one-section-wrapper bootstrap-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xl-3">
                        <div class="testimonial-left-list-wrapper">
                            <ul>
                                <?php if ($settings['lists']){
                                    foreach ($settings['lists'] as $list_item){ ?>
                                        <li>
                                            <img src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/check-circle-broken.svg'?>" alt="check">
                                            <?php echo esc_html($list_item['list_item_text']);?>
                                        </li>
                                <?php    }
                                } ?>
                            </ul>
                        </div>
					</div>

					<div class="col-xl-9">
                        <div class="testimonial-one-items-wrapper" id="listfoliopro-testimonial-slider-<?php echo esc_html($slider_id);?>">
	                        <?php if ( $settings['testimonials'] ) {
		                        foreach ( $settings['testimonials'] as $testimonial ) { ?>
                                    <div class="testimonial-one-item">
                                        <div class="testimonial-text">
	                                        <?php echo esc_html($testimonial['testimonial_text']);?>
                                        </div>

                                        <div class="testimonial-author-info">
                                            <div class="person-image" style="background-image: url(<?php echo esc_url($testimonial['person_image']['url']);?>)"></div>

                                            <div class="listfoliopro-person-name-designation">
                                                <h4 class="name"><?php echo esc_html($testimonial['person_name']);?></h4>
                                                <p class="designation"><?php echo esc_html($testimonial['person_designation']);?></p>
                                            </div>
                                        </div>
                                    </div>
			                        <?php
		                        }
	                        } ?>
                        </div>
					</div>

                    <div class="col-12">
                        <div class="testimonial-slider-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <span class="testimonial_slider_progress_label screen-reader-text"></span>
                        </div>

                        <div class="testimonial-slider-button-wrapper">
	                        <?php if ($settings['nav_arrow'] == 'yes') :?>
                                <div class="testimonial-one-slide-arrow">
                                    <div class="testimonial-prev-arrow">
                                        <img src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/arrow-narrow-right.svg'?>" alt="slick-arrow">
                                    </div>

                                    <div class="testimonial-next-arrow">
                                        <img src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/arrow-narrow-right.svg'?>" alt="slick-arrow">
                                    </div>
                                </div>
	                        <?php endif; ?>

                            <a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="listfoliopro-button"><?php echo esc_html($settings['btn_text']);?>
                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
				</div>
			</div>

            <script>
                (function ($) {
                    "use strict";
                    $(document).ready(function () {
                        var $testimonial_slider = $('#listfoliopro-testimonial-slider-<?php echo esc_html($slider_id);?>');
                        var $testimonial_progress_bar = $('.testimonial-slider-progress');
                        var $testimonial_progress_bar_label = $( '.testimonial_slider_progress_label' );

                        $testimonial_slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                            var calc = ( (nextSlide) / (slick.slideCount-1) ) * 100;

                            $testimonial_progress_bar
                                .css('background-size', calc + '% 100%')
                                .attr('aria-valuenow', calc );

                            $testimonial_progress_bar_label.text( calc + '% completed' );
                        });

                        $testimonial_slider.slick({
                            slidesToShow: 1,
                            autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                            autoplaySpeed: <?php echo json_encode( $settings['autoplay_interval'] )?>, //interval
                            speed: 1500, // slide speed
                            dots: false,
                            arrows: <?php echo json_encode( $settings['nav_arrow'] == 'yes' ? true : false ); ?>,
                            prevArrow: $('.testimonial-prev-arrow'),
                            nextArrow: $('.testimonial-next-arrow'),
                            infinite: <?php echo json_encode( $settings['infinity_loop'] == 'yes' ? true : false ); ?>,
                            pauseOnHover: false,
                            centerMode: false,
                            fade: false,
                        });
                    });
                })(jQuery);
            </script>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Testimonial_One_Widget );