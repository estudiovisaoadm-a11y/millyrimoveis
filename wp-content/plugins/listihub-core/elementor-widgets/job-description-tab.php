<?php
namespace Elementor;

class HiJobs_Job_Description_Tab_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_job_description_tab';
	}

	public function get_title() {
		return esc_html__( 'Job Description', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {
		
		$this->start_controls_section(
			'job_description',
			[
				'label' => esc_html__( 'Job Description Tabs', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'menu_text',
			[
				'label'       => esc_html__('Menu Text', 'hijobs-core'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'About',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content_text',
			[
				'label'   => esc_html__('Content Text', 'hijobs-core'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => '<p>It is a long established fact that is reader will be then distracted buy then thing and readable content off page when looking at that page layout. It is a long fact that on readable content of page. It is a long established fact that is reader will be the then distracted by the thing and readable content then page when looking at our and on established fact that page layout and more.</p>',
			]
		);

		$this->add_control(
			'tab_items',
			[
				'label'       => esc_html__('Tab List', 'hijobs-core'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'menu_text'        => 'About',
						'content_text' => '<p>It is a long established fact that is reader will be then distracted by the thing and readable content off page when looking at that page layout. It is a long fact that a readable content of page. It is a long established fact that is reader will be the then distracted by the thing and readable content then page when looking at our established fact that page layout.</p>',
					],
				],
				'title_field' => '{{{ menu_text }}}',
			]
		);

		$this->add_control(
			'open_by_default',
			[
				'label'       => esc_html__('Open By Default', 'hijobs-core'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 1,
				'description' => esc_html__('Which tab you want to open by default.', 'hijobs-core'),
			]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_tab_id = rand(10, 10000);
		?>

		<div class="ep-job-description-tab-main-wrapper">
			<div class="row">
				<div class="col-xl-8">
					<div class="ep-job-desc-tab-wrapper">
						<div class="ep-tab-btns-wrapper">
                            <div class="nav nav-tabs" role=tablist>
								<?php
								if ($settings['tab_items']) {
									$menu_count = 0;
									foreach ($settings['tab_items'] as $tab_menu) {
										$menu_count++;
										?>
                                        <button class="nav-link <?php if($menu_count == $settings['open_by_default']){ echo 'active';}?>" data-bs-toggle="tab" data-bs-target="#ep-tab-number-<?php echo esc_attr($ep_tab_id.$menu_count);?>" type="button" role="tab">
											<?php echo esc_html($tab_menu['menu_text']);?>
                                        </button>
									<?php }
								}
								?>
                            </div>
                        </div>

						<div class="tab-content">
							<?php
							if ($settings['tab_items']) {
								$content_count = 0;
								foreach ($settings['tab_items'] as $tab_content) {
									$content_count++;
									?>
									<div class="ep-tab-item tab-pane fade <?php if($content_count == $settings['open_by_default'] ){ echo 'active show';}?>" id="ep-tab-number-<?php echo esc_attr($ep_tab_id.$content_count);?>" role="tabpanel">
										<div class="ep-text-wrapper">
											<?php echo wp_kses_post($tab_content['content_text']);?>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>

					</div>
				</div>

				<div class="col-xl-4">
                    <div class="ep-job-desc-right-content-wrapper">
                        <div class="ep-job-desc-right-content">
                            <?php
                                $job_query = new \WP_Query( array(
                                    'post_type' => 'job',
                                    'p'         => get_the_ID(),
                                ) );

                            while ( $job_query->have_posts() ) : $job_query->the_post();
                                $job_id                     = get_the_ID();
                                $company_address= get_post_meta($job_id, 'address',true);
                                $company_phone=get_post_meta($job_id, 'phone',true);
                                $company_email= get_post_meta($job_id, 'contact-email',true);
                                $company_web=get_post_meta($job_id, 'contact_web',true);
                            ?>

                            <div class="job-location-map">
                                <iframe width="100%" height="325" src="https://maps.google.com/maps?q=<?php echo esc_attr($company_address); ?>&amp;ie=UTF8&amp;&amp;output=embed"></iframe>
                            </div>

                            <div class="company-details">
                                <ul class="ep-list-style">
                                    <?php if($company_address!=''){  ?>
                                        <li><?php esc_html_e('Address','jobbank'); ?> : <?php echo esc_html($company_address); ?></li>
                                        <?php
                                    }
                                    ?>
                                    <?php if($company_phone!=''){  ?>
                                        <li><?php esc_html_e('Phone','jobbank'); ?> : <?php echo esc_html($company_phone); ?></li>
                                        <?php
                                    }
                                    ?>
                                    <?php if($company_email!=''){  ?>
                                        <li><?php esc_html_e('Email','jobbank'); ?> : <?php echo esc_html($company_email); ?></li>
                                        <?php
                                    }
                                    ?>

                                    <?php if($company_web!=''){  ?>
                                        <li><?php esc_html_e('Website','jobbank'); ?> : <?php echo esc_html($company_web); ?></li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </div>

                            <?php endwhile;
                            wp_reset_query();
                            ?>
                        </div>
                    </div>
				</div>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Job_Description_Tab_Widget );