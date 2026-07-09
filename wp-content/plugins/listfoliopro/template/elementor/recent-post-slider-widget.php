<?php
namespace Elementor;
use WP_Query;
class ListfolioPro_Recent_Posts_Slider_Widget extends Widget_Base {

	public function get_name() {

		return 'listfoliopro_recent_post_slider';
	}

	public function get_title() {
		return esc_html__( 'Recent Posts Slider', 'listfoliopro' );
	}

	public function get_icon() {

		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'recent_post_settings',
			[
				'label' => __( 'Post Settings', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Number Of Post To Show', 'listfoliopro' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => __( 'Categories', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoloipro_post_categories(),
			]
		);

		$this->add_control(
			'exclude_post',
			[
				'label'       => __( 'Exclude Posts', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_get_post_title_as_list(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'recent_post_layout_settings',
			[
				'label' => __( 'Post Layout & Slide Options', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'autoplay',
            [
                'label'     => esc_html__( 'Autoplay', 'listfoliopro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
                'label_off' => esc_html__( 'No', 'listfoliopro' ),
                'default'   => 'yes',
            ]
        );

		$this->add_control(
			'title_word',
			[
				'label'   => __( 'Title Word Count', 'listfoliopro' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => '',
				'step'    => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => __( 'Show Date', 'listfoliopro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'       => __( 'Item Show On Desktop', 'listfoliopro' ),
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
			'ipad_pro_count',
			[
				'label'       => __( 'Item Show On iPad Pro', 'listfoliopro' ),
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
			'tab_count',
			[
				'label'       => __( 'Item Show On Tablet', 'listfoliopro' ),
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
        $slider_id = rand(100, 10000);
		?>

		<div class="bootstrap-wrapper listfoliopro-recent-post-slider">
            <div class="container">
                <div class="row" id="resent-post-slider-<?php echo esc_attr($slider_id);?>">
                    <?php
                    if ( ! empty( $settings['category'] ) ) {
                        $post_query = new WP_Query( array(
                            'post_type'           => 'post',
                            'posts_per_page'      => $settings['post_count'],
                            'ignore_sticky_posts' => 1,
                            'post__not_in'        => $settings['exclude_post'],
                            'tax_query'           => array(
                                array(
                                    'taxonomy' => 'category',
                                    'terms'    => $settings['category'],
                                    'field'    => 'slug',
                                )
                            )
                        ) );
                    } else {

                        $post_query = new WP_Query(
                            array(
                                'posts_per_page'      => $settings['post_count'],
                                'post_type'           => 'post',
                                'ignore_sticky_posts' => 1,
                                'post__not_in'        => $settings['exclude_post'],
                            )
                        );
                    }

                    if ( $post_query->have_posts() ) {
	                    $post_number = 0;
                        while ( $post_query->have_posts() ) {
	                        $post_number++;
                            $post_query->the_post(); ?>
                            <div class="col-12">
                                <div class="single-post-item post-number-<?php echo esc_attr($post_number);?>">
                                    <a href="<?php echo get_the_permalink();?>" class="recent-post-thumbnail-wrapper">
                                        <div class="recent-post-thumbnail" style="background-image: url(<?php the_post_thumbnail_url( 'large' ); ?>)"></div>
                                    </a>

                                    <a href="<?php echo get_the_permalink();?>">
                                        <h4 class="recent-post-title"><?php echo wp_trim_words(get_the_title(), $settings['title_word'], ' ...');?></h4>
                                    </a>

		                            <?php if ($settings['show_date'] == 'yes') :?>
                                        <div class="date-and-time">
				                            <?php listfoliopro_posted_on();?>
                                            <span> | <?php the_time('g:i a');?></span>
                                        </div>
		                            <?php endif; ?>
                                </div>
                            </div>

                        <?php }
                        wp_reset_postdata();
                    }
                    ?>
                </div>

                <script>
                    (function ($) {
                        "use strict";
                        $(document).ready(function () {
                            $("#resent-post-slider-<?php echo esc_attr($slider_id);?>").slick({
                                slidesToShow: <?php echo json_encode( $settings['desktop_count'] )?>,
                                autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                                autoplaySpeed: 4000,
                                speed: 1500, // slide speed
                                dots: false,
                                arrows: false,
                                infinite: true,
                                pauseOnHover: false,
                                centerMode: false,
                                centerPadding: 30,
                                responsive: [
                                    {
                                        breakpoint: 1025,
                                        settings: {
                                            slidesToShow: <?php echo json_encode( $settings['ipad_pro_count'] )?>,
                                        }
                                    },
                                    {
                                        breakpoint: 992,
                                        settings: {
                                            slidesToShow: <?php echo json_encode( $settings['tab_count'] )?>,
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1,
                                        }
                                    }
                                ]
                            });
                        });
                    })(jQuery);
                </script>
            </div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Recent_Posts_Slider_Widget );