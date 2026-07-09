<?php
namespace Elementor;

class HiJobs_Team_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_team';
	}

	public function get_title() {
		return esc_html__( 'Team Member', 'hijobs-core' );
	}

	public function get_icon() {
		return 'far fa-user';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'team_widget',
			[
				'label' => esc_html__( 'Team Member Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'member_name',
			[
				'label'       => __( 'Member Name', 'themedraft-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Andrew Smith',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'designation',
			[
				'label'       => __( 'Designation', 'themedraft-core' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Technical Officer',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'       => __( 'Member Image', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
            'fb_link',
            [
                'label'       => __( 'Facebook Profile', 'themedraft-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => '#'
            ]
        );

		$repeater->add_control(
			'twitter_link',
			[
				'label'       => __( 'Twitter Profile', 'themedraft-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '#'
			]
		);

		$repeater->add_control(
			'linkedin_link',
			[
				'label'       => __( 'LinkedIn Profile', 'themedraft-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '#'
			]
		);

		$repeater->add_control(
			'insta_link',
			[
				'label'       => __( 'Instagram Profile', 'themedraft-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => '#'
			]
		);

		$this->add_control(
			'members',
			[
				'label'       => __( 'Member List', 'themedraft-core' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'member_name' => 'Andrew Smith',
						'designation' => 'Technical Officer',
					],
				],
				'title_field' => '{{{ member_name }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'team_member_column',
			[
				'label' => esc_html__( 'Column', 'themedraft-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'desktop_count',
			[
				'label'       => __( 'Column On Desktop', 'themedraft-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'themedraft-core' ),
					2 => __( '2 Column', 'themedraft-core' ),
					3 => __( '3 Column', 'themedraft-core' ),
					4 => __( '4 Column', 'themedraft-core' ),
				],
				'default'     => 4,
			]
		);

		$this->add_control(
			'ipad_pro_count',
			[
				'label'       => __( 'Column On iPad Pro', 'themedraft-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'themedraft-core' ),
					2 => __( '2 Column', 'themedraft-core' ),
					3 => __( '3 Column', 'themedraft-core' ),
					4 => __( '4 Column', 'themedraft-core' ),
				],
				'default'     => 3,
			]
		);

		$this->add_control(
			'tab_count',
			[
				'label'       => __( 'Column On Tablet', 'themedraft-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					1 => __( '1 Column', 'themedraft-core' ),
					2 => __( '2 Column', 'themedraft-core' ),
					3 => __( '3 Column', 'themedraft-core' ),
					4 => __( '4 Column', 'themedraft-core' ),
				],
				'default'     => 2,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'slider_options',
			[
				'label' => esc_html__( 'Slider Options', 'themedraft-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'       => __( 'Autoplay', 'themedraft-core' ),
				'type'        => Controls_Manager::SWITCHER,
				'show_label'  => true,
				'label_block' => false,
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[
				'label'       => __( 'Autoplay Interval', 'themedraft-core' ),
				'type'        => Controls_Manager::SELECT,
				'show_label'  => true,
				'label_block' => false,
				'options'     => [
					'2000'  => __( '2 seconds', 'themedraft-core' ),
					'3000'  => __( '3 seconds', 'themedraft-core' ),
					'4000'  => __( '4 seconds', 'themedraft-core' ),
					'5000'  => __( '5 seconds', 'themedraft-core' ),
					'6000'  => __( '6 seconds', 'themedraft-core' ),
					'7000'  => __( '7 seconds', 'themedraft-core' ),
					'8000'  => __( '8 seconds', 'themedraft-core' ),
					'9000'  => __( '9 seconds', 'themedraft-core' ),
					'10000' => __( '10 seconds', 'themedraft-core' ),
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
				'label'       => __( 'Navigation Arrow', 'themedraft-core' ),
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

		<div class="ep-team-member-wrapper">
			<div id="team-wrapper-<?php echo esc_attr($slider_id);?>" class="row">

				<?php
				if ( $settings['members'] ) {
					foreach ( $settings['members'] as $member ) {
						$image_src   = $member['image']['url'];
						$name        = $member['member_name'];
						$designation = $member['designation'];
				?>

					<div class="col-12">
						<div class="ep-single-team-member">
                            <div class="ep-member-image" style="background-image: url(<?php echo esc_url($image_src);?>)">
                                <div class="ep-member-img-shape"></div>

                                <div class="ep-member-social-buttons">
                                    <ul class="ep-list-style">
                                        <li>
                                            <a class="member-social-icon" href="<?php echo esc_url($member['fb_link']);?>">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="member-social-icon" href="<?php echo esc_url($member['twitter_link']);?>">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="member-social-icon" href="<?php echo esc_url($member['linkedin_link']);?>">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="member-social-icon" href="<?php echo esc_url($member['insta_link']);?>">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>

                                        <li  class="expand-icon">
                                            <a href="javascript:;">
                                                <i class="fas fa-share-alt"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="ep-member-info">
                                <h5 class="member-name"><?php echo esc_html($name); ?></h5>
                                <span class="member-designation ep-primary-color"><?php echo esc_html($designation); ?></span>
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
                            prevArrow: '<i class="slick-arrow slick-prev fas fa-angle-double-left"></i>',
                            nextArrow: '<i class="slick-arrow slick-next fas fa-angle-double-right"></i>',
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

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Team_Widget );