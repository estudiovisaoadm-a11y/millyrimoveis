<?php
namespace Elementor;

class HiJobs_Job_Photo_Gallery_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_job_photo_gallery';
	}

	public function get_title() {
		return esc_html__( 'Job Photo Gallery', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function register_controls() {

        $this->start_controls_section(
            'job_photo_gallery',
            [
                'label' => esc_html__( 'Gallery', 'themedraft-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'gallery_title',
            [
                'label'       => __( 'Gallery Title', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'Photos',
            ]
        );

        $this->end_controls_section();

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

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Image Height', 'themedraft-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 500,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'selectors' => [
                    '{{WRAPPER}} .ep-job-photo-gallery-wrapper .ep-gallery-item' => 'height: {{SIZE}}px;',
                ],
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
				'default'     => 4,
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
				'default'     => 4,
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
				'default'     => 3,
			]
		);

		$this->add_control(
			'mobile_column',
			[
				'label'       => __( 'Column On Mobile', 'hijobs-core' ),
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

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$slider_id = rand(10, 10000);
		?>

		<div class="ep-job-photo-gallery-wrapper">
            <h3 class="ep-job-photo-gallery-title"><?php echo esc_html($settings['gallery_title']);?></h3>
            <div class="row" id="ep-gallery-slider-<?php echo esc_attr($slider_id); ?>">
                <?php
                $job_query = new \WP_Query( array(
                    'post_type' => 'job',
                    'p'         => get_the_ID(),
                ) );

                while ( $job_query->have_posts() ) : $job_query->the_post();
                    $job_id = get_the_ID();
                    $gallery_img_ids=get_post_meta($job_id ,'image_gallery_ids',true);
                    $gallery_img_ids_array = array_filter(explode(",", $gallery_img_ids));
                    ?>

                <?php
                    foreach($gallery_img_ids_array as $gallery_image){
                        ?>
                            <div class="col-12">
                                <div class="ep-gallery-item ep-cover-bg" style="background-image: url(<?php echo wp_get_attachment_image_url($gallery_image , 'large');?>)">

                                </div>
                            </div>
                <?php	}
                ?>


                <?php endwhile;
                wp_reset_query();
                ?>
            </div>

            <script>
                (function ($) {
                    "use strict";
                    $(document).ready(function () {
                        $("#ep-gallery-slider-<?php echo esc_attr($slider_id); ?>").slick({
                            slidesToShow: <?php echo json_encode( $settings['desktop_column'] )?>,
                            autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                            autoplaySpeed: 4000,
                            speed: 1500, // slide speed
                            dots: false,
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
                                        slidesToShow: <?php echo json_encode( $settings['mobile_column'] )?>, // 0 -767
                                        dots: false,
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

Plugin::instance()->widgets_manager->register( new HiJobs_Job_Photo_Gallery_Widget );