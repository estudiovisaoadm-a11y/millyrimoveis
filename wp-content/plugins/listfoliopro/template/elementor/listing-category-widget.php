<?php
namespace Elementor;

class ListfolioPro_Listing_Category_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_listing_category';
	}

	public function get_title() {
		return esc_html__( 'Listing Categories', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}

	public function get_script_depends() {
		return ['slick-slider'];
	}

	public function get_style_depends() {
		return ['slick-slider'];
	}
	protected function register_controls() {

		$this->start_controls_section(
			'categories_options',
			[
				'label' => esc_html__( 'Categories', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'listing_categories',
			[
				'label'       => __( 'Categories', 'listfoliopro-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_listing_categories(),
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
			'nav_arrow',
			[
				'label'       => esc_html__( 'Navigation Arrow', 'listfoliopro' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'desktop_column',
			[
				'label'       => esc_html__( 'Column On Desktop', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'listfoliopro' ),
					2 => __( '2 Column', 'listfoliopro' ),
					3 => __( '3 Column', 'listfoliopro' ),
					4 => __( '4 Column', 'listfoliopro' ),
				],
				'default'     => 4,
			]
		);

		$this->add_control(
			'ipad_pro_column',
			[
				'label'       => esc_html__( 'Column On iPad Pro', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'listfoliopro' ),
					2 => __( '2 Column', 'listfoliopro' ),
					3 => __( '3 Column', 'listfoliopro' ),
					4 => __( '4 Column', 'listfoliopro' ),
				],
				'default'     => 4,
			]
		);

		$this->add_control(
			'tab_column',
			[
				'label'       => __( 'Column On Tablet', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'listfoliopro' ),
					2 => __( '2 Column', 'listfoliopro' ),
					3 => __( '3 Column', 'listfoliopro' ),
					4 => __( '4 Column', 'listfoliopro' ),
				],
				'default'     => 3,
			]
		);

		$this->add_control(
			'mobile_column',
			[
				'label'       => __( 'Column On Mobile', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'listfoliopro' ),
					2 => __( '2 Column', 'listfoliopro' ),
					3 => __( '3 Column', 'listfoliopro' ),
					4 => __( '4 Column', 'listfoliopro' ),
				],
				'default'     => 2,
			]
		);

        $this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
		$taxonomy = $listfoliopro_directory_url.'-category';
		$slide_id = rand(100, 100000);
		?>

        <div class="listing-category-wrapper bootstrap-wrapper">
            <div class="container">
                <div class="row" id="listing-category-slider-<?php echo esc_attr($slide_id);?>">
					<?php
					if ( $settings['listing_categories'] ) {
						foreach ( $settings['listing_categories'] as $listing_category ) {
							$category_term = get_term_by( 'slug', $listing_category, $taxonomy );
							if ( ! $category_term || is_wp_error( $category_term ) ) {
								continue;
							}
							$category_name = $category_term;
							$category_url  = get_term_link( $listing_category, $taxonomy );
							$term_id      = $category_term->term_id;
							$term_icon = get_term_meta( $term_id, 'listfoliopro_term_icon', true );
							$term_image = get_term_meta($term_id, 'listfoliopro_term_image', true);
							if($term_icon==""){$term_icon= listfoliopro_ep_URLPATH.'/assets/images/building-07.png';}
							?>

                            <div class="col-12">
                                <div class="listing-category-item">
                                    <a href="<?php echo esc_url($category_url); ?>">
                                        <div class="listing-cat-icon">
	                                        <?php if (!empty($term_icon)) : ?>
                                                <img src="<?php echo esc_attr($term_icon);?>">
	                                        <?php endif; ?>
                                        </div>

                                        <h4 class="listing-cat-name"><?php echo esc_html($category_name->name); ?></h4>
                                    </a>
                                </div>
                            </div>
						<?php }
					}
					?>
                </div>

                <div class="slider-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <span class="slider__label screen-reader-text"></span>
                </div>
                
                <div class="slider-button-wrapper">
                    <a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="listfoliopro-button"><?php echo esc_html($settings['btn_text']);?>
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <script>
            (function ($) {
                "use strict";
                $(document).ready(function () {
                    var $slider = $('#listing-category-slider-<?php echo esc_attr($slide_id);?>');
                    var $progressBar = $('.slider-progress');
                    var $progressBarLabel = $( '.slider__label' );

                    $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                        var calc = ( (nextSlide) / (slick.slideCount-1) ) * 100;

                        $progressBar
                            .css('background-size', calc + '% 100%')
                            .attr('aria-valuenow', calc );

                        $progressBarLabel.text( calc + '% completed' );
                    });

                    $slider.slick({
                        slidesToShow: <?php echo json_encode( $settings['desktop_column'] )?>,
                        autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                        autoplaySpeed: 3000, //interval
                        speed: 1500, // slide speed
                        dots: false,
                        arrows: <?php echo json_encode( $settings['nav_arrow'] == 'yes' ? true : false ); ?>,
                        prevArrow: '<img class="slick-arrow rotate-arrow slick-prev" src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/arrow-narrow-right.svg'?>" alt="Slick Prev">',
                        nextArrow: '<img class="slick-arrow slick-next" src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/arrow-narrow-right.svg'?>" alt="Slick Next">',
                        fade: false,
                        infinite: true,
                        pauseOnHover: false,
                        centerMode: false,
                        responsive: [
                            {
                                breakpoint: 1025,
                                settings: {
                                    slidesToShow: <?php echo json_encode( $settings['ipad_pro_column'] )?>, // 992-1024
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
                                    slidesToShow: <?php echo json_encode( $settings['mobile_column'] )?>, // 0 -767
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


Plugin::instance()->widgets_manager->register( new ListfolioPro_Listing_Category_Widget );
