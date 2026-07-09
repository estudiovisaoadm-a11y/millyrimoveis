<?php
namespace Elementor;
class HiJobs_Candidate_Directory_Widget extends Widget_Base {

	public function get_name() {
		return 'hijobs_candidate_directory';
	}

	public function get_title() {
		return esc_html__( 'Candidate Directory', 'hijobs-core' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'candidate_options',
			[
				'label' => esc_html__( 'Candidate Options', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'candidate_per_page',
			[
				'label'       => esc_html__('Candidate Per Page.', 'themedraft-core'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 8,
			]
		);

		$this->end_controls_section();
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $post;
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_style('fontawesome', ep_jobbank_URLPATH . 'admin/files/css/all.min.css');
		wp_enqueue_script('bootstrap', ep_jobbank_URLPATH . 'admin/files/js/bootstrap.min-4.js');
		wp_enqueue_style('bootstrap', ep_jobbank_URLPATH . 'admin/files/css/iv-bootstrap.css');
		wp_enqueue_style('jobbank_directory', ep_jobbank_URLPATH . 'admin/files/css/directory.css');
		wp_enqueue_style('colorbox', ep_jobbank_URLPATH . 'admin/files/css/colorbox.css');
		wp_enqueue_script('colorbox', ep_jobbank_URLPATH . 'admin/files/js/jquery.colorbox-min.js');

		$main_class = new \eplugins_jobbank;

		$jobbank_directory_url=get_option('ep_jobbank_url');
		if($jobbank_directory_url==""){$jobbank_directory_url='job';}
		/*if(isset($atts['per_page'])){
			$users_per_page=$atts['per_page'];
		}else{
			$users_per_page=8;
		}*/
		$users_per_page= $settings['candidate_per_page'];
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if($paged==1){
			$offset=0;
		}else {
			$offset= ($paged-1)*$users_per_page;
		}
		$args = array();
		$args['number']=$users_per_page;
		$args['offset']= $offset;
		$args['orderby']='display_name';
		$args['order']='ASC';

		$location_city_arr= array();
		$location_input_array= array();

		if(isset($_REQUEST['location_input'])){
			$location_input_array = array_map( 'sanitize_text_field', $_REQUEST['location_input'] );
			foreach($location_input_array as $one_value){
				$city_counrty= explode(',',$one_value);
				$location_city_arr[]=$city_counrty[0];
			}

		}

		$user_name_search='';
		if( isset($_REQUEST['user_name_search'])){
			if($_REQUEST['user_name_search']!=""){
				$user_name_search = array(
					'relation' => 'AND',
					array(
						'key'     => 'full_name',
						'value'   => sanitize_text_field($_REQUEST['user_name_search']),
						'compare' => 'LIKE'
					),
				);
			}
		}
		$categories_search='';
		if( isset($_REQUEST['category_input'])){
			if($_REQUEST['category_input']!=""){
				$categories_arr = array_map( 'sanitize_text_field', $_REQUEST['category_input'] );
				$categories_search = array(
					'relation' => 'AND',
					array(
						'key'     => 'company_type',
						'value'   => $categories_arr,
						'compare' => 'IN'
					),
				);
			}
		}
		$city_search='';
		if( isset($_REQUEST['location_input'])){
			if($_REQUEST['location_input']!=""){
				$city_search = array(
					'relation' => 'AND',
					array(
						'key'     => 'city',
						'value'   => $location_city_arr,
						'compare' => 'IN'
					),
				);
			}
		}
		$user_type = array(
			'relation' => 'AND',
			array(
				'key'     => 'user_type',
				'value'   => 'employer',
				'compare' => '!='
			),
		);


		$args['meta_query'] = array(
			$user_name_search,$city_search, $categories_search,$user_type,
		);

		?>

		<div class="hijobs-candidate-list">
            <div class="row">
	            <?php
	            $user_query = new \WP_User_Query( $args );
	            $total_users = $user_query->get_total();
	            $i=0;
	            // User Loop
	            if ( ! empty( $user_query->results ) ) {
		            foreach ( $user_query->results as $user ) {

			            $profile_page=get_option('epjbjobbank_candidate_public_page');
			            $page_link= get_permalink( $profile_page).'?&id='.$user->ID;
			            $candidate_img = get_user_meta($user->ID, 'jobbank_profile_pic_thum',true);
			            ?>

                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6">

                            <div class="hijobs-single-candidate">
                                <div>
                                    <a href="<?php echo esc_url($page_link); ?>" class="ep-candidate-img" style="background-image: url(<?php echo esc_url($candidate_img); ?>);">
                                    </a>
                                </div>

                                <a href="<?php echo esc_url($page_link); ?>">
                                    <h4 class="ep-candidate-name">
			                            <?php echo (get_user_meta($user->ID,'full_name',true)!=''? get_user_meta($user->ID,'full_name',true) : $user->display_name ); ?>
                                    </h4>
                                </a>

                                <div class="candidate-skill">
		                            <?php
                                        if(get_user_meta($user->ID,'company_type',true)!='' ){
                                             echo get_user_meta($user->ID,'company_type',true);
                                        }
		                            ?>
                                </div>

                                <div class="candidate-tags">
		                            <?php
		                            $tags_user= get_user_meta($user->ID,'professional_skills',true);
		                            $tags_user_arr=  array_filter( explode(",", $tags_user), 'strlen' );
		                            foreach ( $tags_user_arr as $tag ) {
			                            ?>
                                        <span><?php echo esc_html(ucwords(str_replace('-',' ',$tag)));?></span>
			                            <?php
		                            }
		                            ?>
                                </div>

                                <div class="candidate-location-and-rate">

	                                <?php
	                                //$all_locations= str_replace(',',' ',get_user_meta($user->ID, 'all_locations', true));
	                                $all_locations= get_user_meta($user->ID, 'all_locations', true);
	                                if($all_locations!=''){
		                                ?>
                                        <span class="card-location ">
                                            <i class="fa-solid fa-location-dot mr-1"></i><?php echo esc_html($all_locations); ?>
                                        </span>
		                                <?php
	                                }
	                                ?>


	                                <?php
	                                if(!empty(get_user_meta($user->ID,'city',true))){
		                                ?>
                                        <div class="candidate-location"><i class="fa-solid fa-location-dot mr-2"></i><?php echo get_user_meta($user->ID,'city',true); ?>
                                        </div>
		                                <?php
	                                }
	                                if(get_user_meta($user->ID,'hourly_rate',true)!=""){
		                                ?>
                                        <div class="candidate-currency"><i class="fas fa-dollar-sign"></i><?php echo get_user_meta($user->ID,'hourly_rate',true); ?>
                                        </div>
		                                <?php
	                                }

	                                ?>
                                </div>

                                <div class="single-candidate-profile-btn">
                                    <a class="candidate-btn" href="<?php echo esc_url($page_link); ?>"><?php esc_html_e('View Profile', 'jobbank'); ?></a>
                                </div>

                                <div class="btn-feature text-right">
                                    <button class="candidate-btn candidate-msg-btn" onclick="jobbank_candidate_email_popup('<?php echo esc_attr($user->ID);?>')">
			                            <?php esc_html_e('Message', 'jobbank'); ?></button>
                                </div>
                            </div>
                        </div>

			            <?php	$i++;
		            }
	            }
	            ?>

                <div class="col-12 post-pagination">
		            <?php
		            $params =array();
		            $pages = paginate_links( array_merge( [
				            'base'         => str_replace( $post->ID, '%#%', esc_url( get_pagenum_link( $post->ID ) ) ),
				            'format'       => '?paged=%#%',
				            'current'      => max( 1, get_query_var( 'paged' ) ),
				            'total'        => round((int)$total_users/$users_per_page),
				            'type'         => 'array',
				            'show_all'     => false,
				            'end_size'     => 3,
				            'mid_size'     => 1,
				            'prev_next'    => true,
				            'prev_text'    => '<i class="fas fa-angle-double-left"></i>',
				            'next_text'    => '<i class="fas fa-angle-double-right"></i>',
				            'add_args'     => $args,
				            'add_fragment' => ''
			            ], $params )
		            );
		            if ( is_array( $pages ) ) {
			            $pagination = '<div class="navigation pagination justify-content-center"><ul class="pagination">';
			            foreach ( $pages as $page ) {
				            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
			            }
			            $pagination .= '</ul></div>';
			            echo wp_specialchars_decode($pagination);
		            }
		            ?>
                </div>
            </div>
		</div>

		<?php
		$currencyCode = get_option('jobbank_api_currency');
		wp_enqueue_script('jobbank_public-profile', ep_jobbank_URLPATH . 'admin/files/js/public-profile.js');
		wp_localize_script('jobbank_public-profile', 'jobbank1', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.ep_jobbank_URLPATH.'admin/files/images/loader.gif">',
			'wp_iv_directories_URLPATH'		=> ep_jobbank_URLPATH,
			'current_user_id'	=>get_current_user_id(),
			'dirwpnonce'=> wp_create_nonce("myaccount"),
			"Please_login"=>  esc_html__('Please Login','jobbank'),
			'Add_to_Boobmark'=>esc_html__('Add to Boobmark', 'jobbank' ),
			'Added_to_Boobmark'=>esc_html__('Added to Boobmark', 'jobbank' ),

		) );

		wp_enqueue_script('jobbank_message', ep_jobbank_URLPATH . 'admin/files/js/user-message.js');
		wp_localize_script('jobbank_message', 'jobbank_data_message', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.ep_jobbank_URLPATH.'admin/files/images/loader.gif">',
			'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'jobbank' ),
			'contact'=> wp_create_nonce("contact"),
			'listing'=> wp_create_nonce("listing"),
		) );
		wp_enqueue_script('jobbank_user-directory', ep_jobbank_URLPATH . 'admin/files/js/user-directory.js');
	}
}

Plugin::instance()->widgets_manager->register( new HiJobs_Candidate_Directory_Widget );