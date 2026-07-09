<?php
namespace Elementor;

class HiJobs_Jobs_Grid_View_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_jobs_grid_view';
	}

	public function get_title() {
		return esc_html__( 'Jobs Grid View', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-text';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'jobs_filter_options',
			[
				'label' => esc_html__( 'Left Filter Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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

		$this->end_controls_section();

		$this->start_controls_section(
			'job_item_options',
			[
				'label' => esc_html__( 'Job Items', 'themedraft-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'job_per_page',
			[
				'label'   => __( 'Job Per PAge', 'hijobs-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 6,
			]
		);

		$this->add_control(
			'xl_column',
			[
				'label'   => __( 'Desktop', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-xl-4',
				'options' => [
					'col-xl-12'   => __( '1 Column', 'hijobs-core' ),
					'col-xl-6'    => __( '2 Column', 'hijobs-core' ),
					'col-xl-4'    => __( '3 Column', 'hijobs-core' ),
					'col-xl-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'lg_column',
			[
				'label'   => __( 'iPad Pro', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-6',
				'options' => [
					'col-lg-12'   => __( '1 Column', 'hijobs-core' ),
					'col-lg-6'    => __( '2 Column', 'hijobs-core' ),
					'col-lg-4'    => __( '3 Column', 'hijobs-core' ),
					'col-lg-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'md_column',
			[
				'label'   => __( 'iPad', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-md-6',
				'options' => [
					'col-md-12'   => __( '1 Column', 'hijobs-core' ),
					'col-md-6'    => __( '2 Column', 'hijobs-core' ),
					'col-md-4'    => __( '3 Column', 'hijobs-core' ),
					'col-md-3'    => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['xl_column'] .' '. $settings['lg_column']. ' '. $settings['md_column'];
		?>

		<?php
		wp_enqueue_script("jquery");
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-autocomplete');
		wp_enqueue_script('popper', ep_jobbank_URLPATH . 'admin/files/js/popper.min.js');
		wp_enqueue_script('bootstrap', ep_jobbank_URLPATH . 'admin/files/js/bootstrap.min-4.js');
		wp_enqueue_style('bootstrap', ep_jobbank_URLPATH . 'admin/files/css/iv-bootstrap.css');
		wp_enqueue_style('jobbank_listing_style_alphabet_sort', ep_jobbank_URLPATH . 'admin/files/css/archive-listing.css');
		wp_enqueue_style('colorbox', ep_jobbank_URLPATH . 'admin/files/css/colorbox.css');
		wp_enqueue_script('colorbox', ep_jobbank_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
		wp_enqueue_style('jquery-ui', ep_jobbank_URLPATH . 'admin/files/css/jquery-ui.css');
		wp_enqueue_style('font-awesome', ep_jobbank_URLPATH . 'admin/files/css/all.min.css');
		wp_enqueue_style('flaticon', ep_jobbank_URLPATH . 'admin/files/fonts/flaticon/flaticon.css');
		wp_enqueue_style('jobbank_post-paging', ep_jobbank_URLPATH . 'admin/files/css/post-paging.css');
		$main_class = new \eplugins_jobbank;
		global $post,$wpdb,$tag,$jobbank_query,$jobbank_filter_badge;
		$jobbank_directory_url=get_option('ep_jobbank_url');
		if($jobbank_directory_url==""){$jobbank_directory_url='job';}
		$current_post_type=$jobbank_directory_url;
		$dir_style5_perpage=get_option('jobbank_dir_perpage');
		if($dir_style5_perpage==""){$dir_style5_perpage=20;}
		$dirs_data =array();
		$tag_arr= array();
		$search_arg= array();
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => $jobbank_directory_url, // enter your custom post type
			'paged' => $paged,
			'post_status' => 'publish',
			'posts_per_page'=> $settings['job_per_page'],  // overrides posts per page in theme settings
		);
		$search_arg= jobbank_get_search_args($jobbank_directory_url);
		$args= array_merge( $args, $search_arg );
		$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
		// Add new shortcode only category
		if(isset($atts['category']) and $atts['category']!="" ){
			$postcats = $atts['category'];
			$args[$jobbank_directory_url.'-category']=$postcats;
		}
		if(isset($atts['locations']) and $atts['locations']!="" ){
			$postcats = $atts['locations'];
			$args[$jobbank_directory_url.'-locations']=$postcats;
		}
		if(isset($atts['tag']) and $atts['tag']!="" ){
			$postcats = $atts['tag'];
			$args[$jobbank_directory_url.'-tag']=$postcats;
		}
		if(get_query_var($jobbank_directory_url.'-category')!=''){
			$postcats = get_query_var($jobbank_directory_url.'-category');
			$args[$jobbank_directory_url.'-category']=$postcats;
			$selected=$postcats;
			$search_show=1;
		}
		if(get_query_var($jobbank_directory_url.'-tag')!=''){
			$postcats = get_query_var($jobbank_directory_url.'-tag');
			$args[$jobbank_directory_url.'-tag']=$postcats;
			$search_show=1;
		}
		if(get_query_var($jobbank_directory_url.'-locations')!=''){
			$postcats = get_query_var($jobbank_directory_url.'-locations');
			$args[$jobbank_directory_url.'-locations']=$postcats;
			$search_show=1;
		}
		if(get_query_var('employer')!=''){
			$author = get_query_var('employer');
			$args['author']=(int) sanitize_text_field($author);
		}
		if( isset($_REQUEST['employer'])){
			$author = $_REQUEST['employer'];
			$args['author']= (int)sanitize_text_field($author);
		}
		// For featrue listing***********
		$feature_listing_all =array();
		$feature_listing_all =$args;
		if(isset($search_arg['lng']) and $search_arg['lng']!=''){
			$jobbank_query = new \WP_GeoQuery( $args );
		}else{
			$jobbank_query = new \WP_Query( $args );
		}

		$active_archive_fields=jobbank_get_archive_fields_all();
		$active_archive_icon_saved=get_option('jobbank_archive_icon_saved' );
		$active_single_fields_saved=get_option('jobbank_single_fields_saved' );

		?>

        <div class="ep-recent-job-wrapper ep-job-listing-with-filter-wrapper job-grid-view">
            <div class="row">
                <div class="col-12 ep-home-banner-two-wrapper">
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

		                <?php echo do_shortcode( '[jobbank_search action="default_archive" field-name="'.$field_list.'" field-label="'.$field_label.'" field-type="'.$field_type_list.'" ]' );?>
                    </div>
                </div>
				<?php
				wp_enqueue_script('jobbank_single-listing', ep_jobbank_URLPATH . 'admin/files/js/single-listing.js');
				wp_localize_script('jobbank_single-listing', 'jobbank_data', array(
					'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
					'current_user_id'	=>get_current_user_id(),
					'Please_login'=>esc_html__('Please login', 'jobbank' ),
					'Add_to_Favorites'=>esc_html__('Save', 'jobbank' ),
					'Added_to_Favorites'=>esc_html__('Saved', 'jobbank' ),
					'contact'=> wp_create_nonce("contact"),
				) );

				while ( $jobbank_query->have_posts() ) : $jobbank_query->the_post();
					$job_id = get_the_ID();
					$company_image = wp_get_attachment_image_src( get_post_thumbnail_id( $job_id ), 'large' );
					?>

                    <div class="<?php echo esc_attr($ep_column); ?>">
                        <div class="ep-recent-job-item">
                            <div class="ep-save-job">
								<?php
								$active_archive_fields=jobbank_get_archive_fields_all();
								$active_archive_icon_saved=get_option('jobbank_archive_icon_saved' );

								if(isset($active_archive_fields['favorite'])){
									$saved_icon= jobbank_get_icon($active_archive_icon_saved, 'favorite','archive');
									if($saved_icon==''){
										$saved_icon='far fa-heart';
									}

									$user_ID = get_current_user_id();
									$favourites='no';
									if($user_ID>0){
										$my_favorite = get_post_meta($job_id,'_favorites',true);
										$all_users = explode(",", $my_favorite);
										if (in_array($user_ID, $all_users)) {
											$favourites='yes';
										}
									}
									if($favourites!='yes'){?>
                                        <label title='save' class="btn-add-favourites jobbookmark" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Save','jobbank'); ?></label>
										<?php
									}else{
										?>
                                        <label title='saved' class="btn-added-favourites jobbookmark" id="jobbookmark<?php echo esc_html($job_id); ?>"><?php  esc_html_e('Saved','jobbank'); ?></label>
										<?php
									}
								}
								?>
                            </div>

                            <div class="job-rating employer-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>



                            <div class="ep-job-top">
                                <div class="ep-company-logo" style="background-image: url(<?php echo esc_url($company_image[0]);?>)"></div>

                                <span class="ep-company-name ep-primary-color"><?php echo get_post_meta($job_id,'company_name',true);?></span>

                                <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-job-url">
                                    <h4 class="ep-job-title"><?php echo get_the_title($job_id);?></h4>
                                </a>

                                <div class="ep-job-location">
                                    <i class="fas fa-map-marker-alt"></i><?php echo get_the_term_list($job_id, 'job-locations', '', ', ', ''); ?>
                                </div>
                            </div>

                            <div class="ep-job-tags">
								<?php
								$all_job_tags = get_the_term_list($job_id, 'job-tag', '', ', ', '');
								$job_tags_array = explode(", ",$all_job_tags);
								$first_three_tags = array_slice($job_tags_array, 0, 3);
								$top_tag_item = implode(' ', $first_three_tags);

								echo wp_kses_post($top_tag_item);
								?>
                            </div>

                            <div class="ep-job-salary-and-deadline">
                                <span class="ep-job-salary"><i aria-hidden="true" class="fas fa-dollar-sign"></i><?php echo get_post_meta($job_id,'salary',true);?></span>
                                <div class="ep-job-deadline">
                                    <span class="deadline-text"><?php echo __('Deadline:', 'hijobs-core') ?></span>
									<?php
									$deadline= strtotime(get_post_meta($job_id, 'deadline', true));
									$deadline_format= date('jS M, Y',$deadline);

									echo  $deadline_format;?>
                                </div>
                            </div>

                            <div class="ep-job-apply-button">
                                <a class="ep-button" href="<?php echo esc_url( get_the_permalink() );?>">Apply This Job</a>
                            </div>
                        </div>
                    </div>
				<?php
				endwhile;
				wp_reset_query();
				?>

                <div class="col-12 text-center">
                    <div class="post-pagination">
		                <?php
		                $GLOBALS['wp_query']->max_num_pages = $jobbank_query->max_num_pages;
		                the_posts_pagination(array(
			                'next_text' => '<i class="fas fa-angle-double-right"></i>',
			                'prev_text' => '<i class="fas fa-angle-double-left"></i>',
			                'screen_reader_text' => ' ',
			                'type'                => 'list'
		                ));
		                ?>
                    </div>
                </div>
            </div>
        </div>

		<?php
		$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
		if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
		?>
		<?php
		wp_enqueue_script('jobbank_message', ep_jobbank_URLPATH . 'admin/files/js/user-message.js');
		wp_localize_script('jobbank_message', 'jobbank_data_message', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.ep_jobbank_URLPATH.'admin/files/images/loader.gif">',
			'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'jobbank' ),
			'contact'=> wp_create_nonce("contact"),
			'listing'=> wp_create_nonce("listing"),
		) );
		wp_enqueue_script('jobbank_single-listing', ep_jobbank_URLPATH . 'admin/files/js/single-listing.js');
		wp_localize_script('jobbank_single-listing', 'jobbank_data', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.ep_jobbank_URLPATH.'admin/files/images/loader.gif">',
			'current_user_id'	=>get_current_user_id(),
			'Please_login'=>esc_html__('Please login', 'jobbank' ),
			'Add_to_Favorites'=>esc_html__('Save', 'jobbank' ),
			'Added_to_Favorites'=>esc_html__('Saved', 'jobbank' ),
			'Please_put_your_message'=>esc_html__('Please put your name,email Cover letter & attached file', 'jobbank' ),
			'contact'=> wp_create_nonce("contact"),
			'dirwpnonce'=> wp_create_nonce("myaccount"),
			'listing'=> wp_create_nonce("listing"),
			'cv'=> wp_create_nonce("Doc/CV/PDF"),
			'ep_jobbank_URLPATH'=>ep_jobbank_URLPATH,
		) );

		?>
		<?php
		wp_reset_query();
		?>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Jobs_Grid_View_Widget );