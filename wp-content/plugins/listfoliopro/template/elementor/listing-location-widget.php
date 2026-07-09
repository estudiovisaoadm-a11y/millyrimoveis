<?php
namespace Elementor;

class ListfolioPro_Listing_Location_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_listing_location';
	}

	public function get_title() {
		return esc_html__( 'Listing Locations', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'location_options',
			[
				'label' => esc_html__( 'Select Locations', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'listing_locations',
			[
				'label'       => __( 'Locations', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_listing_locations(),
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
					5 => __( '5 Column', 'listfoliopro' ),
				],
				'default'     => 5,
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
				'default'     => 3,
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
				'default'     => 2,
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$taxonomy = 'listing-locations';
		$slider_id = rand(100, 100000);
		?>

		<div class="listfoliopro-listing-location-wrapper">
            <div class="row" id="location-slider-<?php echo esc_attr($slider_id);?>">
                <?php
                if ( $settings['listing_locations'] ) {
                    foreach ( $settings['listing_locations'] as $listing_location ) {
                        $location_name = get_term_by( 'slug', $listing_location, $taxonomy );
                        $location_url  = get_term_link( $listing_location, $taxonomy );

                        $term_id      = get_term_by( 'slug', $listing_location, $taxonomy )->term_id;
                         $thumbnail_src = get_term_meta( $term_id, 'listfoliopro_term_image', true );
						 if(empty($thumbnail_src)){
						 $thumbnail_src=listfoliopro_ep_URLPATH."/assets/images/location.jpg";
						 }
                        $post_count_on_location = new \WP_Query( array( $taxonomy => $listing_location ) );
                        ?>

                        <div class="col-12">
                            <div class="listfoliopro-location-wrapper">
                                <div class="location-image ep-cover-bg" style="background-image: url(<?php echo esc_url($thumbnail_src);?>)">
                                    <div class="location-icon-and-name">
                                        <div class="location-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8.00002 14.6666C8.66669 11.3333 13.3334 10.9455 13.3334 6.66665C13.3334 3.72113 10.9455 1.33331 8.00002 1.33331C5.0545 1.33331 2.66669 3.72113 2.66669 6.66665C2.66669 10.9455 7.33335 11.3333 8.00002 14.6666Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M8.00002 8.66665C9.10459 8.66665 10 7.77122 10 6.66665C10 5.56208 9.10459 4.66665 8.00002 4.66665C6.89545 4.66665 6.00002 5.56208 6.00002 6.66665C6.00002 7.77122 6.89545 8.66665 8.00002 8.66665Z" stroke="#C57B57" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <div class="location-name-wrapper">
                                            <a href="<?php echo esc_url($location_url); ?>" class="location-name">
			                                    <?php echo esc_html($location_name->name); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    <?php }
                }
                ?>
            </div>


            <script>
                (function ($) {
                    "use strict";
                   jQuery(document).ready(function () {
                        var $slider = jQuery('#location-slider-<?php echo esc_attr($slider_id);?>');

                        $slider.slick({
                            slidesToShow: <?php echo json_encode( $settings['desktop_column'] )?>,
                            autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                            autoplaySpeed: 3000, //interval
                            speed: 1500, // slide speed
                            dots: false,
                            arrows: false,
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
                                        slidesToShow: 1, // 0 -767
                                    }
                                }
                            ]
                        });
                    });
                })(jQuery);
            </script>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Listing_Location_Widget );