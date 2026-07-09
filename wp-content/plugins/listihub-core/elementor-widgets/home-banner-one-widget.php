<?php
namespace Elementor;

class HiJobs_Home_Banner_One_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_home_banner_one';
	}

	public function get_title() {
		return esc_html__( 'Home Banner One', 'hijobs-core' );
	}

	public function get_icon() {
		return 'far fa-flag';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'banner_left_options',
			[
				'label' => esc_html__( 'Banner Left Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'subtitle',
            [
                'label'       => __( 'Subtitle', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => 'We delivered blazing fast work Solution',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'themedraft-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => '<h2>Find & Hire Top 3% of expert on hi’Jobs.</h2>',
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

		$repeater->add_control(
			'field_label',
			[
				'label'       => __( 'Label', 'themedraft-core' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Field Label', 'themedraft-core' ),
			]
		);

		$repeater->add_control(
			'field_name',
			[
				'label'   => __( 'Select Form Field', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'title'                    => __( 'Title', 'hijobs-core' ),
					'job-category'             => __( 'Job Categories', 'hijobs-core' ),
					'job-tag'                  => __( 'Job Tags', 'hijobs-core' ),
					'job-locations'            => __( 'Job Locations', 'hijobs-core' ),
					'gender'                   => __( 'Gender', 'hijobs-core' ),
					'sort_listing'             => __( 'Short Listing', 'hijobs-core' ),
					'jobbank_experience_range' => __( 'Experience Range', 'hijobs-core' ),
					'near_to_me'               => __( 'Near To Me', 'hijobs-core' ),
					'educational_requirements' => __( 'Educational Requirement', 'hijobs-core' ),
					'experience'               => __( 'Experience', 'hijobs-core' ),
					'salary'                   => __( 'Salary', 'hijobs-core' ),
					'post_date'                => __( 'Post Date', 'hijobs-core' ),
					'age_range'                => __( 'Age Range', 'hijobs-core' ),
					'jobbank_job_level'        => __( 'Job Level', 'hijobs-core' ),
					'job_type'                 => __( 'Job Type', 'hijobs-core' ),
					'deadline'                 => __( 'Dadeline', 'hijobs-core' ),
				],
			]
		);

		$repeater->add_control(
			'field_type',
			[
				'label'   => __( 'Form Field Type', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text-field',
				'options' => [
					'text-field'           => __( 'Text', 'hijobs-core' ),
					'drop-down'            => __( 'DropDown', 'hijobs-core' ),
					'multi-checkbox'       => __( 'Multi Checkbox', 'hijobs-core' ),
					'multi-checkbox-group' => __( 'Multi Checkbox Group', 'hijobs-core' ),
					'datefield'            => __( 'Date', 'hijobs-core' ),

				],
			]
		);

        $this->add_control(
            'form_fields',
            [
                'label'       => __( 'Form Fields', 'hijobs-core' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'field_label' => 'Field Label',
                        'field_name' => '',
                        'field_type' => 'text-field',
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
            ]
        );

		$this->add_control(
			'enable_popular_cat',
			[
				'label'     => esc_html__( 'Enable Popular Category', 'themedraft-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'themedraft-core' ),
				'label_off' => esc_html__( 'No', 'themedraft-core' ),
				'default'   => 'yes',
			]
		);

        $this->add_control(
            'popular_cat_title',
            [
                'label'       => __( 'Category Title', 'themedraft-core' ),
                'label_block'       => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Popular:',
                'condition' => [
                    'enable_popular_cat' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'user_img',
            [
                'label'       => __( 'User Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'user_img_text',
            [
                'label'       => __( 'User Image Text', 'themedraft-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 5,
                'default'     => '<span>18K+</span><span>Individual Freelancers</span>'
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'banner_right_options',
			[
				'label' => esc_html__( 'Banner Right Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'right_image',
            [
                'label'       => __( 'Right Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

		$this->add_control(
			'brand_image_1',
			[
				'label'       => __( 'Brand Image One', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'brand_image_2',
			[
				'label'       => __( 'Brand Image Two', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'brand_image_3',
			[
				'label'       => __( 'Brand Image Three', 'themedraft-core' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
				'default'     => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'banner_wrapper_options',
			[
				'label' => esc_html__( 'Banner Wrapper Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'wrapper_bg',
            [
                'label'       => __( 'Background Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_height',
            [
                'label' => esc_html__( 'Wrapper Height', 'themedraft-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 1500,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],

                'selectors' => [
                    '{{WRAPPER}} .ep-home-banner-one-wrapper' => 'height: {{SIZE}}px;',
                ],
            ]
        );
		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

        <div class="ep-home-banner-one-wrapper ep-cover-bg" style="background-image: url(<?php echo esc_url($settings['wrapper_bg']['url']);?>)">
            <div class="ep-table">
                <div class="ep-table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-7 col-lg-9 col-sm-10">
                                <div class="ep-home-banner-content">
                                    <div class="home-banner-subtitle"><?php echo esc_html($settings['subtitle']);?></div>

                                    <div class="ep-home-banner-title">
                                        <?php echo wp_kses_post($settings['title']);?>
                                    </div>

                                    <div class="ep-banner-search-form-wrapper">
						                <?php if($settings['form_fields']){
							                $form_fields = array();
							                $form_field_types = array();
							                foreach ($settings['form_fields'] as $form_field){
								                $form_field_label[] = $form_field['field_label'];
								                $form_fields[] = $form_field['field_name'];
								                $form_field_types[] = $form_field['field_type'];
							                }
							                $field_label= implode(",",$form_field_label);
							                $field_list= implode(",",$form_fields);
							                $field_type_list= implode(",",$form_field_types);
						                } ?>

						                <?php echo do_shortcode( '[jobbank_search action="default_archive" field-label="'.$field_label.'" field-name="'.$field_list.'" field-type="'.$field_type_list.'" ]' );?>
                                    </div>

                                    <?php if($settings['enable_popular_cat'] == 'yes') :?>
                                    <div class="ep-popular-category">
                                        <span class="popular-category"><?php echo esc_html($settings['popular_cat_title']);?></span>
						                <?php
						                $args = array(
							                'taxonomy' => 'job-category',
							                'orderby' => 'name',
							                'order'   => 'ASC'
						                );

						                $job_categories = get_categories($args);

						                $job_cat_list = array();
						                foreach($job_categories as $job_category) {
							                $job_cat_list[] = '<a href="'.get_category_link( $job_category->term_id ).'">'.$job_category->name.'</a>';
						                }

						                // Get First 3 Category
						                $first_three_cat = array_slice($job_cat_list, 0, 3);

						                $top_cat_item = implode(',', $first_three_cat);

						                echo wp_kses_post($top_cat_item);
						                ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="ep-job-users-wrapper">
                                        <div class="user-img">
                                            <?php
                                            $user_image_src = $settings['user_img']['url'];
                                            $user_image_alt = get_post_meta( $settings['user_img']['id'], '_wp_attachment_image_alt', true );
                                            $user_image_title = get_the_title( $settings['user_img']['id']);
                                            ?>
                                            <img src="<?php echo esc_url($user_image_src);?>" alt="<?php echo esc_attr($user_image_alt);?>" title="<?php echo esc_attr($user_image_title);?>">
                                        </div>
                                        <div class="user-text">
                                            <?php echo wp_kses_post($settings['user_img_text']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="banner-right-img-wrapper">
                <div class="right-main-img">
                    <?php
                        $right_image_src = $settings['right_image']['url'];
                        $right_image_alt = get_post_meta( $settings['right_image']['id'], '_wp_attachment_image_alt', true );
                        $right_image_title = get_the_title( $settings['right_image']['id']);
                    ?>
                    <img src="<?php echo esc_url($right_image_src);?>" alt="<?php echo esc_attr($right_image_alt);?>" title="<?php echo esc_attr($right_image_title);?>">
                </div>

                <div class="banner-brand-1">
	                <?php
	                $brand_image_1_src = $settings['brand_image_1']['url'];
	                $brand_image_1_alt = get_post_meta( $settings['brand_image_1']['id'], '_wp_attachment_image_alt', true );
	                $brand_image_1_title = get_the_title( $settings['brand_image_1']['id']);
	                ?>
                    <img src="<?php echo esc_url($brand_image_1_src);?>" alt="<?php echo esc_attr($brand_image_1_alt);?>" title="<?php echo esc_attr($brand_image_1_title);?>">
                </div>

                <div class="banner-brand-2">
	                <?php
	                $brand_image_2_src = $settings['brand_image_2']['url'];
	                $brand_image_2_alt = get_post_meta( $settings['brand_image_2']['id'], '_wp_attachment_image_alt', true );
	                $brand_image_2_title = get_the_title( $settings['brand_image_2']['id']);
	                ?>
                    <img src="<?php echo esc_url($brand_image_2_src);?>" alt="<?php echo esc_attr($brand_image_2_alt);?>" title="<?php echo esc_attr($brand_image_2_title);?>">
                </div>

                <div class="banner-brand-3">
	                <?php
	                $brand_image_3_src = $settings['brand_image_3']['url'];
	                $brand_image_3_alt = get_post_meta( $settings['brand_image_3']['id'], '_wp_attachment_image_alt', true );
	                $brand_image_3_title = get_the_title( $settings['brand_image_3']['id']);
	                ?>
                    <img src="<?php echo esc_url($brand_image_3_src);?>" alt="<?php echo esc_attr($brand_image_3_alt);?>" title="<?php echo esc_attr($brand_image_3_title);?>">
                </div>
            </div>

        </div>

        <script>
            (function ($) {
                "use strict";
                jQuery(".header-area").addClass("home-banner-one-activate");
            })(jQuery);
        </script>
		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Home_Banner_One_Widget );