<?php
namespace Elementor;

class ListfolioPro_Team_One_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_team_one';
	}

	public function get_title() {
		return esc_html__( 'Team Member One', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'team_member_options',
			[
				'label' => esc_html__( 'Team Member', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'member_name',
			[
				'label'       => __( 'Member Name', 'listfoliopro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Arlene McCoy',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'listfoliopro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Head of Department',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => __( 'Member Image', 'listfoliopro' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'members',
			[
				'label'       => __( 'Member List', 'listfoliopro' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'member_name' => 'Arlene McCoy',
						'designation' => 'Head of Departments',
					],
				],
				'title_field' => '{{{ member_name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'team_member_column',
			[
				'label' => esc_html__( 'Column', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'       => __( 'Column On Desktop', 'listfoliopro' ),
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
				'label'       => __( 'Column On iPad Pro', 'listfoliopro' ),
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
		$slider_id = rand(100, 1000);
		?>

		<div class="bootstrap-wrapper">
            <div class="listfoliopro-team-one team-member-wrapper container">
                <div id="team-wrapper-<?php echo esc_attr($slider_id);?>" class="row listfoliopro-team-one-slide arrow-top-right">

                    <?php
                    if ( $settings['members'] ) {
                        $member_number = 0;
                        foreach ( $settings['members'] as $member ) {
                            $image_src   = $member['image']['url'];
                            $name        = $member['member_name'];
                            $designation = $member['designation'];
	                        $member_number++;
                            ?>

                            <div class="col-12">
                                <div class="single-team-member">
                                    <div class="member-image member-number-<?php echo esc_html($member_number);?>" style="background-image: url(<?php echo esc_url($image_src);?>)"></div>

                                    <div class="member-info">
                                        <h5 class="member-name"><?php echo esc_html($name); ?></h5>
                                        <span class="member-designation"><?php echo esc_html($designation); ?></span>
                                    </div>
                                </div>
                            </div>

                        <?php }
                    } ?>
                </div>

                <script>
                    (function ($) {
                        "use strict";
                        $(document).ready(function () {
                            $("#team-wrapper-<?php echo esc_js($slider_id);?>").slick({
                                slidesToShow: <?php echo json_encode( $settings['desktop_count'] )?>,
                                autoplay: <?php echo json_encode( $settings['autoplay'] == 'yes' ? true : false ); ?>,
                                autoplaySpeed: <?php echo json_encode( $settings['autoplay_interval'] )?>, //interval
                                speed: 1500, // slide speed
                                dots: false,
                                arrows: <?php echo json_encode( $settings['nav_arrow'] == 'yes' ? true : false ); ?>,
                                prevArrow: '<div class="slick-prev"><img class="arrow-image" src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/left-arrow-32.svg'?>" alt="Slick Prev"></div>',
                                nextArrow: '<div class="slick-next"><img class="arrow-image" src="<?php echo Property_Pro_ELEMENTOR_ASSETS.'images/right-arrow-32.svg'?>" alt="Slick Next"></div>',
                                infinite:  true,
                                pauseOnHover: false,
                                centerMode: false,
                                rows: 1,
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
                                            arrows: false,
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1, // 0 -767
                                            arrows: false,
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

Plugin::instance()->widgets_manager->register( new ListfolioPro_Team_One_Widget );