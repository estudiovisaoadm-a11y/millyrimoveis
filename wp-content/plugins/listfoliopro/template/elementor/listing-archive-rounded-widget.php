<?php
	namespace Elementor;
	class ListfolioPro_Listing_Archive_Rounded_Widget extends Widget_Base {
		public function get_name() {
			return 'listfoliopro_listing_archive__rounded_widget';
		}
		public function get_title() {
			return esc_html__( 'Listing All Rounded', 'listfoliopro' );
		}
		public function get_icon() {
			return 'eicon-post-excerpt';
		}
		public function get_categories() {
			return [ 'listfoliopro_elements' ];
		}
		protected function register_controls() {
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
			$this->start_controls_section(
            'top_search_form',
            [
			'label' => esc_html__( 'Top Search', 'listfoliopro' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
            ]
			);
			$repeater = new Repeater();
			$this->add_control(
			'searchoption',
			[
			'label'     => esc_html__( 'Enable Search', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'no',
			]
			);
			$this->add_control(
			'search_form_style',
			[
			'label'   => __( 'Style', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'top-bar',
			'options' => [
			'top-bar' => __( 'Top Search Form', 'listfoliopro' ),
			'side-bar'  => __( 'Sidebar Search Form', 'listfoliopro' ),			
			],
			]
			);	
			$this->add_control(
			'result_counter',
			[
			'label'     => esc_html__( 'Enable Counter+ Switcher', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'yes',
			]
			);	
			$repeater->add_control(
			'field_label',
			[
			'label'       => __( 'Label', 'listfoliopro' ),
			'label_block'       => true,
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Field Label', 'listfoliopro' ),
			]
			);
			$repeater->add_control(
			'field_name',
			[
			'label'   => __( 'Select Form Field', 'listfoliopro' ),
			'label_block' => true,
			'multiple'    => false,
			'type'    => Controls_Manager::SELECT,
			'default' => '',
			'options' => listfoliopro_get_available_search_fields_elementor(),
			]
			);
			
			$repeater->add_control(
			'field_type',
			[
			'label'   => __( 'Form Field Type', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'text-field',
			'options' => [
			'text-field'           => __( 'Text', 'listfoliopro' ),
			'drop-down'            => __( 'DropDown', 'listfoliopro' ),
			'multi-checkbox'       => __( 'Multi Checkbox', 'listfoliopro' ),
			'multi-checkbox-group' => __( 'Multi Checkbox Group', 'listfoliopro' ),
			'datefield'            => __( 'Date', 'listfoliopro' ),
			],
			]
			);
			$this->add_control(
			'form_fields',
			[
			'label'       => __( 'Form Fields', 'listfoliopro' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => [
			[
			'field_name' => '',
			'field_type' => 'text-field',
			],
			],
			'title_field' => '{{{ field_label }}}',
			]
			);
			$this->end_controls_section();
			//**********Filter*************************************
			$this->start_controls_section(
            'top_filter_form',
            [
			'label' => esc_html__( 'Top Filter', 'listfoliopro' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
            ]
			);
			$repeater_filter = new Repeater();			
			$repeater_filter->add_control( 
			'field_label_filter',
			[
			'label'       => __( 'Label', 'listfoliopro' ),
			'label_block'       => true,
			'type'        => Controls_Manager::TEXT,
			'default'     => __( 'Sort By Label', 'listfoliopro' ),
			]
			);
			$repeater_filter->add_control(
			'field_name_filter',
			[
			'label'       => __( 'Select Filter Field', 'listfoliopro' ),
			'type'        => Controls_Manager::SELECT,
			'label_block' => true,
			'multiple'    => false,
			'options'     => listfoliopro_listing_filter_fields(),
			]
			);
			$this->add_control( 
			'top_fields_filter',
			[
			'label'       => __( 'Filter Fields', 'listfoliopro' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater_filter->get_controls(),
			'default'     => [
			[
			'title_field' => '{{{field_label_filter}}}',	
			],
			],
			]
			);
			$this->end_controls_section();
			// ********End Filter**************
			$this->start_controls_section(
			'listing_option',
			[
			'label' => esc_html__( 'Listing Option', 'listfoliopro' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
			]
			);
			$this->add_control(
			'listing_count',
			[
			'label'   => __( 'Number Of Listing To Show', 'listfoliopro' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => - 1,
			'max'     => '',
			'step'    => 1,
			'default' => 4,
			]
			);
			$this->add_control(
			'category',
			[
			'label'       => __( 'Categories', 'listfoliopro' ),
			'type'        => Controls_Manager::SELECT2,
			'label_block' => true,
			'multiple'    => true,
			'options'     => listfoliopro_listing_categories(),
			]
			);
			$this->add_control(			
			'listingtype',
			[
			'label'       => __( 'Listing Type', 'listfoliopro' ),
			'type'        => Controls_Manager::SELECT2,
			'label_block' => true,
			'multiple'    => true,
			'options'     => listfoliopro_listing_type(),
			]
			);
			$this->add_control(
			'pagination',
			[
			'label'     => esc_html__( 'Enable Pagination', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'no',
			]
			);	        
			$this->add_control(
			'enable_location',
			[
			'label'     => esc_html__( 'Enable Location', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'yes',
			]
			);
			//**********Add Fileds*************************************
			$repeater_fields = new Repeater();			
			$repeater_fields->add_control( 
			'enable_label', 
			[
			'label'     => esc_html__( 'Enable Label', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'yes',
			]
			);
			$repeater_fields->add_control(
			'field_name_grid',
			[
			'label'       => __( 'Select Field', 'listfoliopro' ),
			'type'        => Controls_Manager::SELECT,
			'label_block' => true,
			'multiple'    => false,
			'options'     => listfoliopro_listing_archive_fields(),
			]
			);			
			$this->add_control(
			'grid_fields_name',
			[
			'label'       => __( 'Fields', 'listfoliopro' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater_fields->get_controls(),
			'default'     => [
			[
			'title_field' => '{{{ field_name_grid }}}',	
			],
			],
			]
			);
			// ********End Fileds**************
			$this->add_control(
			'enable_price',
			[
			'label'     => esc_html__( 'Enable Price', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'yes',
			]
			);
			$this->add_control(
			'listing_style',
			[
			'label'   => __( 'Default Listing Style ', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'listing-grid-view',
			'options' => [
			'listing-list-view' => __( 'List View', 'listfoliopro' ),
			'listing-grid-view'  => __( 'Grid View', 'listfoliopro' ),			
			],
			]
			);
			$this->add_control(
			'desktop_col',
			[
			'label'   => __( 'Columns On Desktop', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'col-xl-6',
			'options' => [
			'col-xl-12' => __( '1 Column', 'listfoliopro' ),
			'col-xl-6'  => __( '2 Column', 'listfoliopro' ),
			'col-xl-4'  => __( '3 Column', 'listfoliopro' ),
			'col-xl-3'  => __( '4 Column', 'listfoliopro' ),
			],
			]
			);
			$this->add_control(
			'iPad_pro_col',
			[
			'label'   => __( 'Columns On iPad Pro', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'col-lg-6',
			'options' => [
			'col-lg-12' => __( '1 Column', 'listfoliopro' ),
			'col-lg-6'  => __( '2 Column', 'listfoliopro' ),
			'col-lg-4'  => __( '3 Column', 'listfoliopro' ),
			'col-lg-3'  => __( '4 Column', 'listfoliopro' ),
			],
			]
			);
			$this->add_control(
			'tab_col',
			[
			'label'   => __( 'Columns On Tab', 'listfoliopro' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'col-sm-6',
			'options' => [
			'col-sm-12' => __( '1 Column', 'listfoliopro' ),
			'col-sm-6'  => __( '2 Column', 'listfoliopro' ),
			'col-sm-4'  => __( '3 Column', 'listfoliopro' ),
			'col-sm-3'  => __( '4 Column', 'listfoliopro' ),
			],
			]
			);
			$this->add_control(
            'enable_map',
            [
			'label'     => esc_html__( 'Enable Map', 'listfoliopro' ),
			'type'      => Controls_Manager::SWITCHER,
			'label_on'  => esc_html__( 'Yes', 'listfoliopro' ),
			'label_off' => esc_html__( 'No', 'listfoliopro' ),
			'default'   => 'yes',
            ]
			);
			$this->end_controls_section();
		}
		
		//Render
		protected function render() {
			$settings = $this->get_settings_for_display();
		?>
		<?php
			if ( ! defined( 'ABSPATH' ) ) exit;
			wp_enqueue_script("jquery");
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-datepicker');
			wp_enqueue_script('jquery-ui-autocomplete');
			wp_enqueue_script('popper', listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js');
			wp_enqueue_script('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');
			wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
			wp_enqueue_style('listfoliopro_listing_style_round', listfoliopro_ep_URLPATH . 'admin/files/css/archive-listing-grid-style-1.css');	
			wp_enqueue_style('colorbox', listfoliopro_ep_URLPATH . 'admin/files/css/colorbox.css');
			wp_enqueue_script('colorbox', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
			wp_enqueue_script('jquery.fancybox',listfoliopro_ep_URLPATH . 'admin/files/js/jquery.fancybox.js');
			wp_enqueue_script('mixitup.min',listfoliopro_ep_URLPATH . 'admin/files/js/mixitup.min.js'); 
			wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');
			wp_enqueue_style('font-awesome', listfoliopro_ep_URLPATH . 'admin/files/css/all.min.css');
			wp_enqueue_style('flaticon', listfoliopro_ep_URLPATH . 'admin/files/fonts/flaticon/flaticon.css');
			wp_enqueue_style('listfoliopro_post-paging', listfoliopro_ep_URLPATH . 'admin/files/css/post-paging.css');
			$main_class = new \listfoliopro_eplugins;
			global $post,$wpdb,$tag,$listfoliopro_query,$listfoliopro_filter_badge;
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
			$ins_lat='';$ins_lng='';$dirs_json_map='';
			$defaul_feature_img= $main_class->listfoliopro_listing_default_image();
			$dirs_data =array();
			$tag_arr= array();
			$search_arg= array();
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
			'post_type' => $listfoliopro_directory_url, // enter your custom post type
			'paged' => $paged,
			'post_status' => 'publish',
			'posts_per_page'=> $settings['listing_count'],  // overrides posts per page in theme settings
			);
			$search_arg= listfoliopro_get_search_args($listfoliopro_directory_url);
			$args= array_merge( $args, $search_arg );
			$lat='';$long='';$keyword_post='';$address='';$postcats ='';$selected='';
			// Add new shortcode only category
			if ( ! empty( $settings['category'] ) ) {
				$args[$listfoliopro_directory_url.'-category']=$settings['category'];
			}
			if ( ! empty( $settings['listingtype'] ) ) {
				$args[$listfoliopro_directory_url.'-type']=$settings['listingtype'];
			}
			if( isset($_REQUEST['listing-author'])){
				$author = sanitize_text_field($_REQUEST['listing-author']);
				$args['author']= (int)sanitize_text_field($author);
			}
			// For featrue listing***********
			$feature_listing_all =array();
			$feature_listing_all =$args;
			if(isset($search_arg['lng']) and $search_arg['lng']!=''){
				$listfoliopro_query = new \WP_GeoQuery( $args );
				}else{
				$listfoliopro_query = new \WP_Query( $args );
			}
			$active_archive_icon_saved=get_option('listfoliopro_archive_icon_saved' );	
			if(isset($settings['search_form_style'])){
				$search_bar_style= $settings['search_form_style'];				
				}else{
				$search_bar_style='top-bar';
			}
			$column = $settings['desktop_col'] . ' ' . $settings['iPad_pro_col'] . ' ' . $settings['tab_col'];
			$listing_style = $settings['listing_style'];
			$searchoption = ($settings['searchoption']!=""? $settings['searchoption']  :'no' );
			if( $searchoption == 'yes'  AND $search_bar_style=='top-bar'){
				if($settings['enable_map'] == 'yes') {
					$item_wrapper = 'col-xl-8 col-lg-12  archivescroll';
					$map_wrapper = 'col-xl-4 col-lg-12 ';
					$search_wrapper='col-xl-12 col-lg-12';
					}else{
					$item_wrapper = 'col-xl-12 col-lg-12  ';
					$map_wrapper = 'col-xl-12 col-lg-12 ';
					$search_wrapper='col-xl-12 col-lg-12';					
				}
				}elseif ( $searchoption == 'yes'  AND $search_bar_style=='side-bar'){
				if($settings['enable_map'] == 'yes') {
					$item_wrapper = 'col-xl-6 col-lg-12  archivescroll';
					$map_wrapper = 'col-xl-4 col-lg-12 ';
					$search_wrapper='col-xl-2 col-lg-12';
					}else{
					$search_wrapper='col-xl-3 col-lg-12';
					$item_wrapper = 'col-xl-9 col-lg-12  ';
					$map_wrapper = 'col-xl-12 col-lg-12 ';											
				}
				}elseif ( $searchoption == 'no' AND $settings['enable_map'] == 'yes' ){				
				$search_wrapper='col-xl-12 col-lg-12';
				$item_wrapper = 'col-xl-8 col-lg-12  archivescroll';
				$map_wrapper = 'col-xl-4 col-lg-12 ';						
				}else{		
				$search_wrapper='col-xl-12 col-lg-12';
				$item_wrapper = 'col-xl-12 col-lg-12  ';
				$map_wrapper = 'col-xl-12 col-lg-12 ';
			}	
			$dir_number_format=get_option('dir_number_format');	
			if($dir_number_format==""){$dir_number_format='usa';}
			$field_set=			get_option('listfoliopro_li_fields' );
			if($field_set==""){
				$field_set_all= listfoliopro_default_custom_fields_with_type();
				$field_set = $field_set_all[0];	
			}
			
			if($settings['form_fields']){
				$form_fields = array();
				$form_field_types = array();
				foreach ($settings['form_fields'] as $form_field){
					$form_fields[] = $form_field['field_name'];
					$form_field_types[] = $form_field['field_type'];
				}
				$field_list= implode(",",$form_fields);
				$field_type_list= implode(",",$form_field_types);
			}
			if($settings['search_form_style']){
				$search_form_style=$settings['search_form_style'];
				}else{
				$search_form_style=$settings['top-bar'];
			}
		?>
        <!-- wrap everything for our isolated bootstrap -->
        <div class="bootstrap-wrapper listfoliopro-archive-page ">
            <!-- archieve page own design font and others -->
            <section class="">
                <div class="container-fluid <?php echo esc_attr($listing_style); ?>" id="listfoliopro_main" >
                    <!-- Search Form -->
                    <div class="row" id="full_grid">
						<?php if( $settings['searchoption'] == 'yes'){
							if ($settings['search_form_style'] == 'top-bar') {?>								
							<div class="col-md-12 col-lg-12 col-xl-12 col-sm-12 " >
								<?php
									echo do_shortcode( '[listfoliopro_search action="same_page" style="'.$search_form_style.'" field-name="'.$field_list.'" field-type="'.$field_type_list.'" ]' );
								?>
							</div>
							<?php
							}
						}
						?>
                        <!-- end of search form -->
						<?php if ($settings['searchoption'] == 'yes'){ 
							if ($settings['search_form_style'] == 'side-bar'){ 
							?>
							<div class="<?php echo esc_html($search_wrapper);?>" id="archivemap">
								<?php 	echo do_shortcode( '[listfoliopro_search action="same_page" style="'.$search_form_style.'" field-name="'.$field_list.'" field-type="'.$field_type_list.'" ]' );
								?>
							</div>
							<?php
							}
						} ?>
                        <div class="<?php echo esc_html($item_wrapper);?>" id="dirpro_directories" >
							<?php if( $settings['result_counter'] == 'yes'){ ?>
								<div class="row listing-top-button-wrapper">
									<div class="col-xl-3 col-lg-3 col-md-3  col-sm-6 col-6 ">
										<div class="pull-left clearfix">
											
										</div>
									</div>
									<div class="col-xl-9 col-lg-9 col-md-9  col-sm-6 col-6 ">
										<div class="listing-top-layout d-flex align-items-center">
										<?php
										if(isset($settings['top_fields_filter']) AND !empty($settings['top_fields_filter'])){
										?>
											<select class="form-dropdown" id="sort-options">	
												<?php
														$form_fields = array();
														$form_field_types = array();
														$sort_data='';
														foreach ($settings['top_fields_filter'] as $form_field){
														if(isset($form_field['field_name_filter']) AND !empty($form_field['field_name_filter'])){
														
														?>
														<option value="<?php echo esc_attr($form_field['field_name_filter']); ?>"><?php echo esc_html($form_field['field_label_filter']);?></option>
														<?php
															}
														}											 
													
												?>
											</select>
											<?php
											}	
											?>
											
											<ul class="listing-layout-btn d-flex list-unstyled mb-0 ml-auto">
												<li class="listing-grid-btn">
													<i class="fa-solid fa-grip-vertical" aria-hidden="true"></i>
												</li>
												<li class="listing-list-btn">
													<i class="fa-solid fa-grip" aria-hidden="true"></i>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<?php
								}
							?>
                            <div class="clearfix"></div>
                            <div class="row mix-container" >
								<?php
									$i=0;
									if ( $listfoliopro_query->have_posts() ) :
									while ( $listfoliopro_query->have_posts() ) : $listfoliopro_query->the_post();
									$id = get_the_ID();
									if(get_post_meta($id, 'listfoliopro_featured', true)=='featured'){
										$feature_img='';
										if(has_post_thumbnail()){
											$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
											if(isset($feature_image[0])){
												$feature_img =$feature_image[0];
											}
											}else{
											$feature_img= $defaul_feature_img;
										}
										$dir_data['title']=esc_html($post->post_title);
										$dir_data['dlink']=get_permalink($id);
										$dir_data['address']= get_post_meta($id,'address',true);
										$dir_data['image']=  $feature_img;
										$dir_data['locations']= '';
										$dir_data['lat']=(get_post_meta($id,'latitude',true)!='' ? get_post_meta($id,'latitude',true) :'0');
										$dir_data['lng']=(get_post_meta($id,'longitude',true)!='' ? get_post_meta($id,'longitude',true) :'0');
										$dir_data['marker_icon']= $main_class->listfoliopro_get_categories_mapmarker($id,$listfoliopro_directory_url);
										$ins_lat=get_post_meta($id,'latitude',true);
										$ins_lng=get_post_meta($id,'longitude',true);
										$cat_link='';$cat_name='';$cat_slug='';
										// VIP
										$post_author_id= $listfoliopro_query->post->post_author;
										$current_date=time();
										$price=(get_post_meta( $id, 'discount', true )!=''? get_post_meta( $id, 'discount', true ): get_post_meta( $id, 'price', true ));
										$sort_data='';
										if(isset($settings['top_fields_filter']) AND !empty($settings['top_fields_filter'])){
											foreach ($settings['top_fields_filter'] as $form_field){
												if(isset($form_field['field_name_filter']) AND !empty($form_field['field_name_filter'])){
													$field_key= $form_field['field_name_filter'];
												$field_key = str_replace(':asc','', $field_key); 
												$field_key = str_replace(':desc','', $field_key); 
												if($field_key=='price' ){
													$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($price) .' ' ; 
													}elseif($field_key==='category' OR  $field_key=='tag' OR $field_key=='locatins'){
													$terms = wp_get_post_terms($id, $listfoliopro_directory_url.'-'.$field_key);
													if (!empty($terms)) {
														$first_term='';
														$first_term = (isset($terms[0]->name)? $terms[0]->name:'');		
														if(!empty(trim($first_term))){ 
															$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($first_term) .' ' ;
														}
													}	
													}elseif($field_key=='title'){	
													$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($post->post_title) .' ' ; 
													}else{
													if(get_post_meta( $id, $field_key, true )!=''){
														$sort_data=$sort_data.'data-'.$field_key.'='.esc_html(get_post_meta( $id, $field_key, true )) .' ' ; 
													}
												}
												}	
											}											 
										}
										include( listfoliopro_ep_template. 'elementor/single-block/single-block-round.php');
									
									
										array_push( $dirs_data, $dir_data );
										$i++;
									}
									endwhile;
									endif;
									wp_reset_query();
									if ( $listfoliopro_query->have_posts() ) :
									while ( $listfoliopro_query->have_posts() ) : $listfoliopro_query->the_post();
									$id = get_the_ID();
									if(get_post_meta($id, 'listfoliopro_featured', true)!='featured'){
										$feature_img='';
										if(has_post_thumbnail()){
											$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'large' );
											if(isset($feature_image[0])){
												$feature_img =$feature_image[0];
											}
											}else{
											$feature_img= $defaul_feature_img;
										}
										$dir_data['title']=esc_html($post->post_title);
										$dir_data['dlink']=get_permalink($id);
										$dir_data['address']= get_post_meta($id,'address',true);
										$dir_data['image']=  $feature_img;
										$dir_data['locations']= '';
										$dir_data['lat']=(get_post_meta($id,'latitude',true)!='' ? get_post_meta($id,'latitude',true) :'0');
										$dir_data['lng']=(get_post_meta($id,'longitude',true)!='' ? get_post_meta($id,'longitude',true) :'0');
										$dir_data['marker_icon']= $main_class->listfoliopro_get_categories_mapmarker($id,$listfoliopro_directory_url);
										$ins_lat=get_post_meta($id,'latitude',true);
										$ins_lng=get_post_meta($id,'longitude',true);
										$cat_link='';$cat_name='';$cat_slug='';
										// VIP
										$post_author_id= $listfoliopro_query->post->post_author;
										$current_date=time();
										$price=(get_post_meta( $id, 'discount', true )!=''? get_post_meta( $id, 'discount', true ): get_post_meta( $id, 'price', true ));
										if(isset($settings['top_fields_filter']) AND !empty($settings['top_fields_filter'])){											
											$sort_data='';
											foreach ($settings['top_fields_filter'] as $form_field){
												if(isset($form_field['field_name_filter']) AND !empty($form_field['field_name_filter'])){
												$field_key= $form_field['field_name_filter'];
												$field_key = str_replace(':asc','', $field_key); 
												$field_key = str_replace(':desc','', $field_key); 
												if($field_key=='price' ){
													$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($price) .' ' ; 
													}elseif($field_key==='category' OR  $field_key=='tag' OR $field_key=='locatins'){
													$terms = wp_get_post_terms($id, $listfoliopro_directory_url.'-'.$field_key);
													if (!empty($terms)) {
														$first_term='';
														$first_term = (isset($terms[0]->name)? $terms[0]->name:'');		
														if(!empty(trim($first_term))){ 
															$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($first_term) .' ' ;
														}
													}	
													}elseif($field_key=='title'){	
													$sort_data=$sort_data.'data-'.$field_key.'='.esc_html($post->post_title) .' ' ; 
													}else{
													if(get_post_meta( $id, $field_key, true )!=''){
														$sort_data=$sort_data.'data-'.$field_key.'='.esc_html(get_post_meta( $id, $field_key, true )) .' ' ; 
													}
												}
												}	
											}											 
										}
										include( listfoliopro_ep_template. 'elementor/single-block/single-block-round.php');
										
										array_push( $dirs_data, $dir_data );
										$i++;
									}
									endwhile;
									$dirs_json_map = wp_json_encode($dirs_data);
								?>
								<?php else :
								$dirs_json=''; ?>
								<?php endif; ?>
							</div>
		                    <?php if($settings['pagination'] == 'yes') : ?>
                            <div class="row mt-1 post-pagination">
                                <div class="col-lg-12 text-center ep-list-style">
									<?php
										$GLOBALS['wp_query']->max_num_pages = $listfoliopro_query->max_num_pages;
										the_posts_pagination(array(
										'next_text' => '<i class="fas fa-angle-double-right"></i>',
										'prev_text' => '<i class="fas fa-angle-double-left"></i>',
										'screen_reader_text' => ' ',
										'type'                => 'list'
										));
									?>
								</div>
							</div>
		                    <?php endif; ?>
						</div>
					    <?php if ($settings['enable_map'] == 'yes') : ?>
						<div class="<?php echo esc_html($map_wrapper);?> " id="archivemap">
							<?php include(listfoliopro_ep_template.'listing/map/map.php'); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
            <!-- end of arhiece page -->
		</div>
        <!-- end of bootstrap wrapper -->
		<?php
			$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
			if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact US';}
		?>
		<?php
			wp_enqueue_script('listfoliopro_message', listfoliopro_ep_URLPATH . 'admin/files/js/user-message.js');
			wp_localize_script('listfoliopro_message', 'listfoliopro_data_message', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
			'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'listfoliopro' ),
			'contact'=> wp_create_nonce("contact"),
			'listing'=> wp_create_nonce("listing"),
			) );
			wp_enqueue_script('listfoliopro_single-listing', listfoliopro_ep_URLPATH . 'admin/files/js/single-listing.js');
			wp_localize_script('listfoliopro_single-listing', 'listfoliopro_data', array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
			'current_user_id'	=>get_current_user_id(),
			'Please_login'=>esc_html__('Please login', 'listfoliopro' ),
			'Add_to_Favorites'=>esc_html__('Save', 'listfoliopro' ),
			'Added_to_Favorites'=>esc_html__('Saved', 'listfoliopro' ),		
			'Please_put_your_message'=>esc_html__('Please put your detail', 'listfoliopro' ),
			'contact'=> wp_create_nonce("contact"),
			'dirwpnonce'=> wp_create_nonce("myaccount"),
			'listing'=> wp_create_nonce("listing"),			
			'listfoliopro_ep_URLPATH'=>listfoliopro_ep_URLPATH,
			) );
		?>
		<?php
			wp_reset_query();
		?>
		<?php
		}
	}
Plugin::instance()->widgets_manager->register( new ListfolioPro_Listing_Archive_Rounded_Widget );
