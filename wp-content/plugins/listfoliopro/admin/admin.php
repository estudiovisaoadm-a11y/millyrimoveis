<?php
	if (!defined('ABSPATH')) {
		exit;
	}
	/**
		* The Admin Panel and related tasks are handled in this file.
	*/
	if (!class_exists('listfoliopro_eplugins_Admin')) {
		class listfoliopro_eplugins_Admin {
			static $pages = array();
			public function __construct() {
				add_action('admin_menu', array($this, 'listfoliopro_admin_menu'));
				add_action('admin_print_scripts', array($this, 'listfoliopro_load_scripts'));
				add_action('admin_print_styles', array($this, 'listfoliopro_load_styles'));							
				add_action('wp_ajax_listfoliopro_save_package', array($this, 'listfoliopro_save_package'));
				add_action('wp_ajax_listfoliopro_update_package', array($this, 'listfoliopro_update_package'));
				add_action('wp_ajax_listfoliopro_update_paypal_settings', array($this, 'listfoliopro_update_paypal_settings'));
				add_action('wp_ajax_listfoliopro_update_stripe_settings', array($this, 'listfoliopro_update_stripe_settings'));			
				add_action('wp_ajax_listfoliopro_create_coupon', array($this, 'listfoliopro_create_coupon'));
				add_action('wp_ajax_listfoliopro_update_coupon', array($this, 'listfoliopro_update_coupon'));	
				add_action('wp_ajax_listfoliopro_update_payment_setting', array($this, 'listfoliopro_update_payment_setting'));
				add_action('wp_ajax_listfoliopro_update_page_setting', array($this, 'listfoliopro_update_page_setting'));
				add_action('wp_ajax_listfoliopro_update_email_setting', array($this, 'listfoliopro_update_email_setting'));
				add_action('wp_ajax_listfoliopro_update_mailchamp_setting', array($this, 'listfoliopro_update_mailchamp_setting'));
				add_action('wp_ajax_listfoliopro_add_home_page', array($this, 'listfoliopro_add_home_page'));
				add_action('wp_ajax_listfoliopro_update_package_status', array($this, 'listfoliopro_update_package_status'));
				add_action('wp_ajax_listfoliopro_gateway_settings_update', array($this, 'listfoliopro_gateway_settings_update'));
				add_action('wp_ajax_listfoliopro_update_account_setting', array($this, 'listfoliopro_update_account_setting'));			
				add_action('wp_ajax_listfoliopro_update_protected_setting', array($this, 'listfoliopro_update_protected_setting'));
				add_action('wp_ajax_listfoliopro_import_data', array($this, 'listfoliopro_import_data'));
				add_action('wp_ajax_listfoliopro_update_user_settings', array($this, 'listfoliopro_update_user_settings'));			
				add_action('wp_ajax_listfoliopro_update_profile_fields', array($this, 'listfoliopro_update_profile_fields'));
				add_action('wp_ajax_listfoliopro_update_dir_fields', array($this, 'listfoliopro_update_dir_fields'));
				add_action('wp_ajax_listfoliopro_update_profile_signup_fields', array($this, 'listfoliopro_update_profile_signup_fields'));
				add_action('wp_ajax_listfoliopro_update_dir_setting', array($this, 'listfoliopro_update_dir_setting'));	
				add_action('wp_ajax_listfoliopro_update_search_fields', array($this, 'listfoliopro_update_search_fields'));				
				add_action('wp_ajax_listfoliopro_update_archive_fields', array($this, 'listfoliopro_update_archive_fields'));
				add_action('wp_ajax_listfoliopro_update_single_fields', array($this, 'listfoliopro_update_single_fields'));				
				add_action('wp_ajax_listfoliopro_create_search_shortcode', array($this, 'listfoliopro_create_search_shortcode'));
				add_action('wp_ajax_listfoliopro_search_shortcodes_saved_delete', array($this, 'listfoliopro_search_shortcodes_saved_delete'));			
				add_action('wp_ajax_listfoliopro_update_map_settings', array($this, 'listfoliopro_update_map_settings'));
				add_action('wp_ajax_listfoliopro_update_color_settings', array($this, 'listfoliopro_update_color_settings'));
				add_action('wp_ajax_listfoliopro_update_myaccount_menu', array($this, 'listfoliopro_update_myaccount_menu'));
				add_action('wp_ajax_listfoliopro_update_openai_settings', array($this, 'listfoliopro_update_openai_settings'));
				add_action( 'init', array($this, 'listfoliopro_gutenberg_widgets') );
				add_action( 'init', array($this, 'listfoliopro_payment_post_type') );
				add_filter( 'manage_edit-iv_payment_columns', array($this, 'listfoliopro_set_custom_edit_iv_payment_columns')  );
				add_action( 'manage_iv_payment_posts_custom_column' ,  array($this, 'listfoliopro_custom_iv_payment_column')  , 10, 2 );
				
			}
			// Hook into the 'init' action
			public function listfoliopro_payment_post_type() {
				$args = array(
				'description' => 'listfoliopro Payment Post Type',
				'show_ui' => true,   
				'exclude_from_search' => true,
				'labels' => array(
				'name'=> 'Payment History',
				'singular_name' => 'iv_payment',							 
				'edit' => 'Edit Payment History',
				'edit_item' => 'Edit Payment History',							
				'view' => 'View Payment History',
				'view_item' => 'View Payment History',
				'search_items' => 'Search ',
				'not_found' => 'No  Found',
				'not_found_in_trash' => 'No Found in Trash',
				),
				'public' => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_menu' => 'flase',
				'hiearchical' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => true,
				'supports' => array('title', 'editor', 'thumbnail','excerpt','custom-fields'),							
				);
				register_post_type( 'iv_payment', $args );
			}
			public function listfoliopro_gutenberg_widgets(){
				require_once ('pages/tinymce_shortcode_button.php');
			}
			public function listfoliopro_set_custom_edit_iv_payment_columns($columns) {
				$columns['title']=esc_html__( 'Package Name', 'listfoliopro'); 
				$columns['User'] = esc_html__( 'User Name', 'listfoliopro'); 
				$columns['Member'] = esc_html__( 'User ID', 'listfoliopro'); 			
				$columns['Amount'] = esc_html__( 'Amount', 'listfoliopro'); 
				return $columns;
			}
			public function listfoliopro_custom_iv_payment_column( $column ) {
				global $post;
				switch ( $column ) {
					case 'User' :							
					if(isset($post->post_author) ){
						$user_info = get_userdata( $post->post_author);
						if($user_info!='' ){
							echo  esc_html($user_info->user_login);
						}
					}
					break; 
					case 'Member' :
					echo esc_html($post->post_author); 
					break;
					case 'Amount' :
					echo esc_html($post->post_content); 
					break;
				}
			}
			/**
				* Menus in the wp-admin sidebar
			*/
			public function listfoliopro_admin_menu() {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');					
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				
				$listfoliopro_label_category=get_option('listfoliopro_label_category');
				if($listfoliopro_label_category==""){$listfoliopro_label_category='Category';}
				$listfoliopro_label_tag=get_option('listfoliopro_label_tag');
				if($listfoliopro_label_tag==""){$listfoliopro_label_tag='Tag';}
				$listfoliopro_label_location=get_option('listfoliopro_label_location');
				if($listfoliopro_label_location==""){$listfoliopro_label_location='Location';}
				
				
				add_menu_page('listfoliopro', esc_html__('ListfolioPro Settings','listfoliopro'), 'manage_options', 'listfoliopro', array($this, 'listfoliopro_menu_hook'),'dashicons-admin-home',9);
				self::$pages['listfoliopro-settings'] = add_submenu_page('listfoliopro', esc_html__('ListfolioPro Settings','listfoliopro'), esc_html__('Settings','listfoliopro'), 'manage_options', 'listfoliopro-settings', array($this, 'listfoliopro_menu_hook'));				
				add_submenu_page('listfoliopro', 'listfoliopro', esc_html($listfoliopro_label_category), 'manage_options',  'edit-tags.php?taxonomy='.$listfoliopro_directory_url.'-category&post_type='.$listfoliopro_directory_url,'',1);
				add_submenu_page('listfoliopro', 'listfoliopro', esc_html($listfoliopro_label_tag), 'manage_options', 'edit-tags.php?taxonomy='.$listfoliopro_directory_url.'-tag&post_type='.$listfoliopro_directory_url,'',2);
				add_submenu_page('listfoliopro', 'listfoliopro', esc_html($listfoliopro_label_location), 'manage_options', 'edit-tags.php?taxonomy='.$listfoliopro_directory_url.'-locations&post_type='.$listfoliopro_directory_url,'',3);
				add_submenu_page('listfoliopro', 'listfoliopro', esc_html__('Post Type','listfoliopro'), 'manage_options', 'edit-tags.php?taxonomy='.$listfoliopro_directory_url.'-type&post_type='.$listfoliopro_directory_url,'',4);
				
				self::$pages['listfoliopro-package-create'] = add_submenu_page('', 'listfoliopro package', '', 'manage_options', 'listfoliopro-package-create', array($this, 'listfoliopro_package_create_page'));
				self::$pages['listfoliopro-package-update'] = add_submenu_page('', 'listfoliopro package', '', 'manage_options', 'listfoliopro-package-update', array($this, 'listfoliopro_package_update_page'));
				self::$pages['listfoliopro-coupon-create'] = add_submenu_page('', ' listfoliopro coupon', '', 'manage_options', 'listfoliopro-coupon-create', array($this, 'listfoliopro_coupon_create_page'));
				self::$pages['listfoliopro-coupon-update'] = add_submenu_page('', 'listfoliopro coupon', '', 'manage_options', 'listfoliopro-coupon-update', array($this, 'listfoliopro_coupon_update_page'));
				self::$pages['listfoliopro-payment-paypal'] = add_submenu_page('', 'listfoliopro Payment setting', '', 'manage_options', 'listfoliopro-payment-paypal', array($this, 'listfoliopro_paypal_update_page'));
				self::$pages['listfoliopro-payment-stripe'] = add_submenu_page('', 'listfoliopro Payment setting', '', 'manage_options', 'listfoliopro-payment-stripe', array($this, 'listfoliopro_stripe_update_page'));
				self::$pages['listfoliopro-user_update'] = add_submenu_page('', 'listfoliopro user_update', '', 'manage_options', 'listfoliopro-user_update', array($this, 'listfoliopro_user_update_page'));
			}
			/**
				* Menu Page Router
			*/
			public function listfoliopro_menu_hook() {
				$screen = get_current_screen();
				switch ($screen->id) {
					default:
					require_once ('pages/settings.php');
					break;
					case self::$pages['listfoliopro-settings']:
					require_once ('pages/settings.php');
					break;
					
				}
			}
			public function listfoliopro_profile_fields_setting (){
				require_once ('pages/registration-fields.php');
			}
			
			public function listfoliopro_coupon_create_page(){
				require_once ('pages/coupon_create.php');
			}
			public function listfoliopro_coupon_update_page(){
				require_once ('pages/coupon_update.php');
			}
			public function listfoliopro_package_create_page(){
				require_once ('pages/package_create.php');
			}
			public function listfoliopro_package_update_page(){
				require_once ('pages/package_update.php');
			}
			public function listfoliopro_paypal_update_page(){
				require_once ('pages/paypal_update.php');
			}
			public function listfoliopro_stripe_update_page(){
				require_once ('pages/stripe_update.php');
			}
			public function listfoliopro_user_update_page(){
				require_once ('pages/user_update.php');
			}
			/**
				* Page based Script Loader
			*/
			public function listfoliopro_load_scripts() { 
				$screen = get_current_screen();
				if (in_array($screen->id, array_values(self::$pages))) {
					$currencyCode= 'USD';
					wp_enqueue_script("jquery");	
					wp_enqueue_script('jquery-ui-core');
					wp_enqueue_script('jquery-ui-datepicker');
					wp_enqueue_script('jquery-ui-sortable');
					wp_enqueue_media();
					wp_enqueue_script('bootstrap.min', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');					
					wp_enqueue_script('listfoliopro-script-dashboardadmin', listfoliopro_ep_URLPATH . 'admin/files/js/dashboard-admin.js');
					wp_localize_script('listfoliopro-script-dashboardadmin', 'admindata', array(
					'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
					'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
					'wp_iv_directories_URLPATH'		=> listfoliopro_ep_URLPATH,
					'listfoliopro_ep_ADMINPATH' => listfoliopro_ep_ADMINPATH,
					'current_user_id'	=>get_current_user_id(),	
					'SetImage'		=>esc_html__('Set Image','listfoliopro'),
					'GalleryImages'=>esc_html__('Gallery Images','listfoliopro'),	
					'cancel-message' => esc_html__('Are you sure to cancel this Membership','listfoliopro'),
					'currencyCode'=>  $currencyCode,
					'dirwpnonce'=> wp_create_nonce("myaccount"),
					'settings'=> wp_create_nonce("settings"), 
					'cityimage'=> wp_create_nonce("city-image"),
					'packagenonce'=> wp_create_nonce("package"),
					'catimage'=> wp_create_nonce("cat-image"),							
					'signup'=> wp_create_nonce("signup"),
					'contact'=> wp_create_nonce("contact"),
					'coupon'=> wp_create_nonce("coupon"),
					'fields'=> wp_create_nonce("fields"),
					'dirsetting'=> wp_create_nonce("dir-setting"),
					'mymenu'=> wp_create_nonce("my-menu"),
					'paymentgateway'=> wp_create_nonce("payment-gateway"), 
					'permalink'=> get_permalink(),			
					) );
					$listfoliopro_primary_color=get_option('listfoliopro_primary_color');	
					if($listfoliopro_primary_color==""){$listfoliopro_primary_color='#1dbfc1';}	
					$listfoliopro_second_color=get_option('listfoliopro_second_color');	
					if($listfoliopro_second_color==""){$listfoliopro_second_color='#87f1f2';}	

					
					$listfoliopro_third_color=get_option('listfoliopro_third_color');	
					if($listfoliopro_third_color==""){$listfoliopro_third_color='#e1e8ef';}
					
					$listfoliopro_listing_d_color=get_option('listfoliopro_listing_d_color');	
					if($listfoliopro_listing_d_color==""){$listfoliopro_listing_d_color='#f5f5f5';}
					
					wp_enqueue_script('listfoliopro-dynamic-color', listfoliopro_ep_URLPATH . 'admin/files/js/dynamic-color.js');
					wp_localize_script('listfoliopro-dynamic-color', 'listfoliopro_color', array(
					'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
					'listfoliopro_primary_color'=>$listfoliopro_primary_color,
					'listfoliopro_second_color'=>$listfoliopro_second_color,	
					'listfoliopro_third_color'=>$listfoliopro_third_color,
					'listfoliopro_bg_color'=>$listfoliopro_listing_d_color,
					) );	
					wp_enqueue_script('dataTables', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.dataTables.js');
					wp_enqueue_script('dataTablesrowReordermin', listfoliopro_ep_URLPATH . 'admin/files/js/dataTables.rowReorder.min.js');
					wp_enqueue_script('dataTablesresponsivemin', listfoliopro_ep_URLPATH . 'admin/files/js/dataTables.responsive.min.js');
				}
			}
			/**
				* Page based Style Loader
			*/
			public function listfoliopro_load_styles() {
				$screen = get_current_screen();		
				if (in_array($screen->id, array_values(self::$pages))) {
					wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');					
					wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
					wp_enqueue_style('listfoliopro_dashboard-style', listfoliopro_ep_URLPATH . 'admin/files/css/dashboard-admin.css');
					
					
					wp_enqueue_style('dataTables-min', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.dataTables.min.css');	
					wp_enqueue_style('rowReorder-dataTables', listfoliopro_ep_URLPATH . 'admin/files/css/rowReorder.dataTables.min.css');
					wp_enqueue_style('responsive-dataTables', listfoliopro_ep_URLPATH . 'admin/files/css/responsive.dataTables.min.css');
				}
				
			}
			
			
			/**
				* Use this function to execute actions
			*/
			public function listfoliopro_import_data(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating0:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating1:user Permission?' );
				}
				include ('pages/import-demo.php');
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}
			public function listfoliopro_save_package() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $wpdb;			
				$listfoliopro_pack='listfoliopro_pack';
				$last_post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type = '%s' ORDER BY `ID` DESC ", $listfoliopro_pack));
				$form_number = $last_post_id + 1;
				$role_name='';
				if($form_data['package_name']==""){
					$post_name = 'Package' . $form_number;
					$role_name=$post_name;
					}else{
					$post_name = sanitize_text_field($form_data['package_name']) .'-'. $form_number;
					$role_name=sanitize_text_field($form_data['package_name']);
				}					
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_content= ''; 
				$my_post_form = array('post_title' => wp_strip_all_tags($post_title), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_content, 'post_type'=>'listfoliopro_pack', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($my_post_form);
				update_post_meta($newpost_id, 'package_subtitle', sanitize_text_field($form_data['package_subtile']));
				if(isset($form_data['is_it_feature'])){
					update_post_meta($newpost_id, '_is_it_feature', sanitize_text_field($form_data['is_it_feature']));
					}else{
					update_post_meta($newpost_id, '_is_it_feature', '');
				}
				if(isset($form_data['package_feature'] )){
					$package_feature= $form_data['package_feature'];
					$image_icon= (isset($form_data['feature_icon']) ? $form_data['feature_icon']:'');
					$i=0;
					for($i=0;$i<20;$i++){
						if(isset($package_feature[$i])){
							if(trim($package_feature[$i])!=''){
								update_post_meta($newpost_id, 'package_feature_'.$i, sanitize_text_field($package_feature[$i]));
								if(isset($image_icon[$i])){
									update_post_meta($newpost_id, 'feature_icon_'.$i, sanitize_text_field($image_icon[$i]));
								}
							}
						}
					}
				}
				update_post_meta($newpost_id, 'listfoliopro_display_order', sanitize_text_field($form_data['package_order']));
				update_post_meta($newpost_id, 'listfoliopro_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'listfoliopro_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'listfoliopro_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'listfoliopro_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_recurring', '');
				}
				if(isset($form_data['listfoliopro_stripe_plan'])){
					update_post_meta($newpost_id, 'listfoliopro_stripe_plan', sanitize_text_field($form_data['listfoliopro_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_stripe_plan', '');
				}
				update_post_meta($newpost_id, 'listfoliopro_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
				update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
				update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
				update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
				if(isset($form_data['package_enable_trial_period'])){
					update_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', 'no');
				}
				update_post_meta($newpost_id, 'listfoliopro_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
				update_post_meta($newpost_id, 'listfoliopro_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
				update_post_meta($newpost_id, 'listfoliopro_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'listfoliopro_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));
				}
				// Start User Role
				global $wp_roles;
				$contributor_roles = $wp_roles->get_role('contributor');							
				$role_name_new= str_replace(' ', '_', $role_name);
				$wp_roles->remove_role( $role_name_new );
				$role_display_name = $role_name;
				$wp_roles->add_role($role_name_new, $role_display_name, array(
				'read' => true, // True allows that capability, False specifically removes it.
				'edit_posts' => true,
				'delete_posts' => true,
				'upload_files' => true //last in array needs no comma!
				));
				update_post_meta($newpost_id, 'listfoliopro_package_user_role', $role_name_new);					
				update_post_meta($newpost_id, 'listfoliopro_package_max_post_no', sanitize_text_field($form_data['max_pst_no']));				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'listfoliopro_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'listfoliopro_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_feature'])){
					update_post_meta($newpost_id, 'listfoliopro_package_feature', sanitize_text_field($form_data['listing_feature']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_feature', 'no');
				}
				// End User Role
				// For Stripe Plan Create*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('listfoliopro_payment_gateway');
					if($iv_gateway=='stripe'){
						require_once(listfoliopro_ep_DIR . '/admin/init.php');
						$post_name2='listfoliopro_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2 ));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'listfoliopro_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':$form_data['package_recurring_cycle_count']);
						$stripe_currency =get_post_meta($stripe_id, 'listfoliopro_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;						
						$stripe_array['amount']=sanitize_text_field($form_data['package_recurring_cost_initial']) * 100;
						$stripe_array['interval']=sanitize_text_field($form_data['package_recurring_cycle_type']);									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'listfoliopro_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'listfoliopro_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						\Stripe\Plan::create($stripe_array);
					}	
				}
				// End Stripe Plan Create*****	
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}
			public function listfoliopro_update_openai_settings(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['listfoliopro_openai_api_key'])){
					update_option('listfoliopro_openai_api_key' ,sanitize_text_field($form_data['listfoliopro_openai_api_key'])); 
					update_option('listfoliopro_openai_api_key_status' ,''); 
				}
				if(isset($form_data['listfoliopro_active_chatGPT'])){
					update_option('listfoliopro_active_chatGPT' ,sanitize_text_field($form_data['listfoliopro_active_chatGPT'])); 					
					}else{
					update_option('listfoliopro_active_chatGPT' ,'No'); 
				}
				if(isset($form_data['gpt_model'])){
					update_option('listfoliopro_gpt_model' ,sanitize_text_field($form_data['gpt_model'])); 					
				}
				
				echo wp_json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_myaccount_menu(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				// remove menu******
				if(isset($form_data['listinghome'])){
					update_option('epjblistfoliopro_menu_listinghome' ,sanitize_text_field($form_data['listinghome'])); 
					}else{
					update_option('epjblistfoliopro_menu_listinghome' ,'no') ; 
				}
				if(isset($form_data['mylevel'])){
					update_option('epjblistfoliopro_mylevel' ,sanitize_text_field($form_data['mylevel'])); 
					}else{
					update_option('epjblistfoliopro_mylevel' ,'no') ; 
				}
				if(isset($form_data['menusetting'])){
					update_option('epjblistfoliopro_menusetting' ,sanitize_text_field($form_data['menusetting'])); 
					}else{
					update_option('epjblistfoliopro_menusetting' ,'no') ; 
				}
				if(isset($form_data['menuallpost'])){
					update_option('epjblistfoliopro_menuallpost' ,sanitize_text_field($form_data['menuallpost'])); 
					}else{
					update_option('epjblistfoliopro_menuallpost' ,'no') ; 
				}
				if(isset($form_data['menunecandidates'])){
					update_option('epjblistfoliopro_menunecandidates' ,sanitize_text_field($form_data['menunecandidates'])); 
					}else{
					update_option('epjblistfoliopro_menunecandidates' ,'no') ; 
				}
				if(isset($form_data['messageboard'])){
					update_option('epjblistfoliopro_messageboard' ,sanitize_text_field($form_data['messageboard'])); 
					}else{
					update_option('epjblistfoliopro_messageboard' ,'no') ; 
				}
				if(isset($form_data['notification'])){
					update_option('epjblistfoliopro_notification' ,sanitize_text_field($form_data['notification'])); 
					}else{
					update_option('epjblistfoliopro_notification' ,'no') ; 
				}
				
				if(isset($form_data['author_bookmarks'])){
					update_option('epjblistfoliopro_author_bookmarks' ,sanitize_text_field($form_data['author_bookmarks'])); 
					}else{
					update_option('epjblistfoliopro_author_bookmarks' ,'no') ; 
				}
				if(isset($form_data['listing_bookmark'])){
					update_option('epjblistfoliopro_listing_bookmarks' ,sanitize_text_field($form_data['listing_bookmark'])); 
					}else{
					update_option('epjblistfoliopro_listing_bookmarks' ,'no') ; 
				}
				echo wp_json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_profile_signup_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'admin' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();
				$opt_type_array= array();
				$opt_type_value_array= array();
				$opt_type_roles_array= array();				
				$signup_array= array();
				$require_array= array();
				$myaccount_array= array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						$opt_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['meta_label'][$i]);	
						if(isset($form_data['field_type'][$i])){
							$opt_type_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type'][$i]);
							}else{
							$opt_type_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_type_value'][$i])){
							$opt_type_value_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type_value'][$i]);
							}else{
							$opt_type_value_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_user_role'.$i])){	
							$input_field_role_arr= array();
							foreach($form_data['field_user_role'.$i] as $field_role){
								$input_field_role_arr[]= sanitize_text_field($field_role);
							}							
							$opt_type_roles_array[$form_data['meta_name'][$i]]=$input_field_role_arr;
							}else{
							$opt_type_roles_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['signup'.$i])){							
							$signup_array[$form_data['meta_name'][$i]]='yes';							
							}else{							
							$signup_array[$form_data['meta_name'][$i]]='no';
						}
						if(isset($form_data['srequire'.$i])){							
							$require_array[$form_data['meta_name'][$i]]='yes';
							}else{
							$require_array[$form_data['meta_name'][$i]]='no';
						}
						if(isset($form_data['myaccountprofile'.$i])){							
							$myaccount_array[$form_data['meta_name'][$i]]='yes';
							}else{
							$myaccount_array[$form_data['meta_name'][$i]]='no';
						}
					}
				}
				update_option('listfoliopro_profile_fields', $opt_array );
				update_option('listfoliopro_field_type', $opt_type_array );
				update_option('listfoliopro_field_type_value', $opt_type_value_array );
				update_option('listfoliopro_field_type_roles', $opt_type_roles_array );
				update_option('listfoliopro_signup_fields', $signup_array );
				update_option('listfoliopro_myaccount_fields', $myaccount_array );				
				update_option('listfoliopro_signup_require', $require_array );
				if(isset($form_data['signup_profile_pic'])){
					update_option( 'listfoliopro_signup_profile_pic' ,sanitize_text_field($form_data['signup_profile_pic']));
					}else{
					update_option( 'listfoliopro_signup_profile_pic' ,'no') ;
				}
				if(isset($form_data['listfoliopro_payment_coupon'])){
					update_option( 'epjblistfoliopro_payment_coupon' ,sanitize_text_field($form_data['listfoliopro_payment_coupon']));
					}else{
					update_option( 'epjblistfoliopro_payment_coupon' ,'no') ;
				}
				if(isset($form_data['listfoliopro_payment_terms'])){
					update_option( 'listfoliopro_payment_terms' ,sanitize_text_field($form_data['listfoliopro_payment_terms']));
					}else{
					update_option( 'listfoliopro_payment_terms' ,'no') ;
				}
				echo wp_json_encode(array('code' => 'Update Successfully'));
				exit(0);
			}
			public function listfoliopro_update_dir_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'dir-setting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				update_option('listfoliopro_user_can_publish',sanitize_text_field($form_data['listfoliopro_user_can_publish']));
				update_option('listfoliopro_archive_layout',sanitize_text_field($form_data['listfoliopro_archive_layout']));
				
				update_option('listfoliopro_archive_style',sanitize_text_field($form_data['listfoliopro_archive_style']));
				update_option('listfoliopro_single_style',sanitize_text_field($form_data['listfoliopro_single_style']));
				update_option('listfoliopro_columns_desktop',sanitize_text_field($form_data['listfoliopro_columns_desktop']));
				update_option('listfoliopro_columns_iPad',sanitize_text_field($form_data['listfoliopro_columns_iPad']));
				update_option('listfoliopro_columns_tab',sanitize_text_field($form_data['listfoliopro_columns_tab']));
				update_option('directoryprosinglepage',sanitize_text_field($form_data['directoryprosinglepage']));
				update_option('listing_single_custompage',sanitize_text_field($form_data['listing_single_custompage']));
				
				update_option('listfoliopro_listing_hide_opt',sanitize_text_field($form_data['listing_hide']));
				$custom_post_type=sanitize_text_field($form_data['listfoliopro_url']);
				$custom_post_type=strtolower($custom_post_type);
				$custom_post_type=str_replace(' ','',$custom_post_type);
				$custom_post_type=str_replace('-','',$custom_post_type);
				$custom_post_type=str_replace('*','',$custom_post_type);
				$custom_post_type=str_replace('$','',$custom_post_type);
				$custom_post_type=str_replace('#','',$custom_post_type);
				update_option('listfoliopro_ep_url',trim(strtolower($custom_post_type)));
				update_option('listfoliopro_dir_perpage',sanitize_text_field($form_data['listfoliopro_dir_perpage']));
				update_option('dir_number_format',sanitize_text_field($form_data['dir_number_format']));
				
				
				update_option('listfoliopro_label_category',sanitize_text_field($form_data['listfoliopro_label_category']));
				update_option('listfoliopro_label_tag',sanitize_text_field($form_data['listfoliopro_label_tag']));
				update_option('listfoliopro_label_location',sanitize_text_field($form_data['listfoliopro_label_location']));
				
				update_option('listfoliopro_listing_defaultimage',sanitize_text_field($form_data['listfoliopro_listing_defaultimage']));
				update_option('listfoliopro_location_defaultimage',sanitize_text_field($form_data['listfoliopro_location_defaultimage']));
				update_option('listfoliopro_category_defaultimage',sanitize_text_field($form_data['listfoliopro_category_defaultimage']));
				update_option('listfoliopro_banner_defaultimage',sanitize_text_field($form_data['listfoliopro_banner_defaultimage']));
				if(isset($form_data['listfoliopro_facet_listinglevel_show'])){
					update_option( 'listfoliopro_facet_listinglevel_show' ,sanitize_text_field($form_data['listfoliopro_facet_listinglevel_show']));
					}else{
					update_option( 'listfoliopro_facet_listinglevel_show' ,'no') ; 						
				}
				echo wp_json_encode(array("code" => "success","msg"=> esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_profile_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'my-menu' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array2= array();
				if(isset($form_data['menu_title'])){
					$max = sizeof($form_data['menu_title']);
					for($i = 0; $i < $max;$i++)
					{	
						if($form_data['menu_title'][$i]!="" AND $form_data['menu_link'][$i]!=""){
							$opt_array2[$form_data['menu_title'][$i]]=$form_data['menu_link'][$i];
						}
					}			
					update_option('listfoliopro_profile_menu', $opt_array2 );
				}
				// remove menu******
				if(isset($form_data['listinghome'])){
					update_option('epjblistfoliopro_menu_listinghome' ,sanitize_text_field($form_data['listinghome'])); 
					}else{
					update_option('epjblistfoliopro_menu_listinghome' ,'no') ; 
				}
				if(isset($form_data['mylevel'])){
					update_option('epjblistfoliopro_mylevel' ,sanitize_text_field($form_data['mylevel'])); 
					}else{
					update_option('epjblistfoliopro_mylevel' ,'no') ; 
				}
				if(isset($form_data['menusetting'])){
					update_option('epjblistfoliopro_menusetting' ,sanitize_text_field($form_data['menusetting'])); 
					}else{
					update_option('epjblistfoliopro_menusetting' ,'no') ; 
				}
				if(isset($form_data['menuallpost'])){
					update_option('epjblistfoliopro_menuallpost' ,sanitize_text_field($form_data['menuallpost'])); 
					}else{
					update_option('epjblistfoliopro_menuallpost' ,'no') ; 
				}
				if(isset($form_data['menunecandidates'])){
					update_option('epjblistfoliopro_menunecandidates' ,sanitize_text_field($form_data['menunecandidates'])); 
					}else{
					update_option('epjblistfoliopro_menunecandidates' ,'no') ; 
				}
				if(isset($form_data['messageboard'])){
					update_option('epjblistfoliopro_messageboard' ,sanitize_text_field($form_data['messageboard'])); 
					}else{
					update_option('epjblistfoliopro_messageboard' ,'no') ; 
				}
				if(isset($form_data['notification'])){
					update_option('epjblistfoliopro_notification' ,sanitize_text_field($form_data['notification'])); 
					}else{
					update_option('epjblistfoliopro_notification' ,'no') ; 
				}
				
				if(isset($form_data['author_bookmarks'])){
					update_option('epjblistfoliopro_author_bookmarks' ,sanitize_text_field($form_data['author_bookmarks'])); 
					}else{
					update_option('epjblistfoliopro_author_bookmarks' ,'no') ; 
				}
				if(isset($form_data['listing_bookmark'])){
					update_option('epjblistfoliopro_listing_bookmarks' ,sanitize_text_field($form_data['listing_bookmark'])); 
					}else{
					update_option('epjblistfoliopro_listing_bookmarks' ,'no') ; 
				}
				echo wp_json_encode(array('code' => esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_dir_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'fields' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$opt_array= array();				
				$opt_type_array= array();
				$opt_type_value_array= array();
				$opt_type_cat_array= array();
				$opt_image_array=array();
				$max = sizeof($form_data['meta_name']);
				for($i = 0; $i < $max;$i++)
				{
					if($form_data['meta_name'][$i]!="" AND $form_data['meta_label'][$i]!=""){
						if(isset($form_data['meta_name'][$i])){
							$opt_array[sanitize_text_field($form_data['meta_name'][$i])]=sanitize_text_field($form_data['meta_label'][$i]);	
							}else{
							$opt_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_type'][$i])){
							$opt_type_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type'][$i]);
							}else{
							$opt_type_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['meta_image'][$i])){
							$opt_image_array[$form_data['meta_name'][$i]]=sanitize_url($form_data['meta_image'][$i]);
							}else{
							$opt_image_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_type_value'][$i])){
							$opt_type_value_array[$form_data['meta_name'][$i]]=sanitize_text_field($form_data['field_type_value'][$i]);
							}else{
							$opt_type_value_array[$form_data['meta_name'][$i]]='';
						}
						if(isset($form_data['field_categories'.$i])){							
							$opt_type_cat_array[$form_data['meta_name'][$i]]=$form_data['field_categories'.$i];
							}else{
							$opt_type_cat_array[$form_data['meta_name'][$i]]='';
						}	
					}
				}
				update_option('listfoliopro_li_fields', $opt_array );
				update_option('listfoliopro_li_field_type', $opt_type_array );
				update_option('listfoliopro_li_field_image', $opt_image_array ); 
				update_option('listfoliopro_li_fieldtype_value', $opt_type_value_array );
				update_option('listfoliopro_field_type_cat', $opt_type_cat_array );				
				update_option('listfoliopro_listing_level',sanitize_text_field($form_data['listfoliopro_listing_level_all']));						
				update_option('listfoliopro_listing_status',sanitize_text_field($form_data['listfoliopro_listing_status_all']));
				update_option('listfoliopro_experience_range',sanitize_text_field($form_data['listing_listfoliopro_experience_range']));
				echo wp_json_encode(array('code' => 'Update Successfully'));
				exit(0);
			}
			public function listfoliopro_update_package() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_title=sanitize_text_field($form_data['package_name']);
				$post_id=sanitize_text_field($form_data['package_id']);
				$newpost_id=$post_id;
				$post_content= ''; 
				$post_type = 'listfoliopro_pack';						
				$my_post = array(
				'ID'           => $post_id,
				'post_title'   => $post_title,
				'post_content'=>	$post_content,
				);
				wp_update_post( $my_post );
				update_post_meta($newpost_id, 'package_subtitle', sanitize_text_field($form_data['package_subtile']));
				if(isset($form_data['is_it_feature'])){
					update_post_meta($newpost_id, '_is_it_feature', sanitize_text_field($form_data['is_it_feature']));
					}else{
					update_post_meta($newpost_id, '_is_it_feature', '');
				}
				for($i=0;$i<30;$i++){			
					delete_post_meta($newpost_id, 'feature_icon_'.$i );
					delete_post_meta($newpost_id, 'package_feature_'.$i );
				}
				if(isset($form_data['package_feature'] )){
					$package_feature= $form_data['package_feature'];
					$image_icon= (isset($form_data['feature_icon']) ? $form_data['feature_icon']:'');
					$i=0;
					for($i=0;$i<30;$i++){
						if(isset($package_feature[$i])){
							if(trim($package_feature[$i])!=''){  
								update_post_meta($newpost_id, 'package_feature_'.$i, $package_feature[$i]);
								if(isset($image_icon[$i])){
									update_post_meta($newpost_id, 'feature_icon_'.$i, sanitize_text_field($image_icon[$i]));
								}
							}
						}
					}
				}
				update_post_meta($newpost_id, 'listfoliopro_display_order', sanitize_text_field($form_data['package_order']));				
				update_post_meta($newpost_id, 'listfoliopro_package_cost', sanitize_text_field($form_data['package_cost']));
				update_post_meta($newpost_id, 'listfoliopro_package_initial_expire_interval', sanitize_text_field($form_data['package_initial_expire_interval']));							
				update_post_meta($newpost_id, 'listfoliopro_package_initial_expire_type', sanitize_text_field($form_data['package_initial_expire_type']));
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'listfoliopro_package_recurring', sanitize_text_field($form_data['package_recurring']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_recurring', '');
				}
				if(isset($form_data['listfoliopro_stripe_plan'])){
					update_post_meta($newpost_id, 'listfoliopro_stripe_plan', sanitize_text_field($form_data['listfoliopro_stripe_plan']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_stripe_plan', '');
				}
				if(isset($form_data['package_recurring'])){
					update_post_meta($newpost_id, 'listfoliopro_package_recurring', sanitize_text_field($form_data['package_recurring']));
					update_post_meta($newpost_id, 'listfoliopro_package_recurring_cost_initial', sanitize_text_field($form_data['package_recurring_cost_initial']));
					update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_count', sanitize_text_field($form_data['package_recurring_cycle_count']));
					update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_type', sanitize_text_field($form_data['package_recurring_cycle_type']));
					update_post_meta($newpost_id, 'listfoliopro_package_recurring_cycle_limit', sanitize_text_field($form_data['package_recurring_cycle_limit']));
					if(isset($form_data['package_enable_trial_period'])){
						update_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', sanitize_text_field($form_data['package_enable_trial_period']));
						}else{
						update_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', 'no');
					}
					update_post_meta($newpost_id, 'listfoliopro_package_trial_amount', sanitize_text_field($form_data['package_trial_amount']));
					update_post_meta($newpost_id, 'listfoliopro_package_trial_period_interval', sanitize_text_field($form_data['package_trial_period_interval']));
					update_post_meta($newpost_id, 'listfoliopro_package_recurring_trial_type', sanitize_text_field($form_data['package_recurring_trial_type']));
				}
				//Woocommerce_products
				if(isset($form_data['Woocommerce_product'])){
					update_post_meta($newpost_id, 'listfoliopro_package_woocommerce_product', sanitize_text_field($form_data['Woocommerce_product']));				
				}
				update_post_meta($newpost_id, 'listfoliopro_package_max_post_no', sanitize_text_field($form_data['max_pst_no']));				
				if(isset($form_data['listing_hide'])){
					update_post_meta($newpost_id, 'listfoliopro_package_hide_exp', sanitize_text_field($form_data['listing_hide']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_hide_exp', 'no');
				}
				if(isset($form_data['listing_facilities'])){
					update_post_meta($newpost_id, 'listfoliopro_package_facilities', sanitize_text_field($form_data['listing_facilities']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_facilities', 'no');
				}
				if(isset($form_data['listing_deal'])){
					update_post_meta($newpost_id, 'listfoliopro_package_deal', sanitize_text_field($form_data['listing_deal']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_deal', 'no');
				}
				if(isset($form_data['listing_badge_vip'])){
					update_post_meta($newpost_id, 'listfoliopro_package_vip_badge', sanitize_text_field($form_data['listing_badge_vip']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_vip_badge', 'no');
				}						
				if(isset($form_data['listing_video'])){
					update_post_meta($newpost_id, 'listfoliopro_package_video', sanitize_text_field($form_data['listing_video']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_video', 'no');
				}
				if(isset($form_data['listing_plan'])){
					update_post_meta($newpost_id, 'listfoliopro_package_plan', sanitize_text_field($form_data['listing_plan']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_plan', 'no');
				}
				if(isset($form_data['listing_feature'])){
					update_post_meta($newpost_id, 'listfoliopro_package_feature', sanitize_text_field($form_data['listing_feature']));
					}else{
					update_post_meta($newpost_id, 'listfoliopro_package_feature', 'no');
				}
				// For Stripe*****
				// For Stripe Plan Edit*****
				if(isset($form_data['package_recurring'])){
					$iv_gateway = get_option('listfoliopro_payment_gateway');
					if($iv_gateway=='stripe'){
						require_once(listfoliopro_ep_DIR . '/admin/init.php');
						$post_name2='listfoliopro_stripe_setting';
						$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2));
						if(isset($row->ID )){
							$stripe_id= $row->ID;
						}			
						$stripe_mode=get_post_meta( $stripe_id,'listfoliopro_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_live_secret_key',true);	
						}									
						$interval_count= ($form_data['package_recurring_cycle_count']=="" ? '1':sanitize_text_field($form_data['package_recurring_cycle_count']));
						$stripe_currency =get_post_meta($stripe_id, 'listfoliopro_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						$stripe_array=array();
						$post_package_one = get_post($newpost_id); 
						$error=0;
						$p_name = $post_package_one->post_name;
						$stripe_array['id']= $p_name;						
						$stripe_array['amount']=sanitize_text_field($form_data['package_recurring_cost_initial']) * 100;
						$stripe_array['interval']=sanitize_text_field($form_data['package_recurring_cycle_type']);									
						$stripe_array['interval_count']=$interval_count;
						$stripe_array['currency']=$stripe_currency;
						$stripe_array['product']=array('name' => $p_name);
						$trial=get_post_meta($newpost_id, 'listfoliopro_package_enable_trial_period', true);
						if($trial=='yes'){
							$trial_type = get_post_meta( $newpost_id,'listfoliopro_package_recurring_trial_type',true);
							$trial_cycle_count =get_post_meta($newpost_id, 'listfoliopro_package_trial_period_interval', true);
							switch ($trial_type) {
								case 'year':
								$periodNum =  365 * 1;
								break;
								case 'month':
								$periodNum =  30 * $trial_cycle_count;
								break;
								case 'week':
								$periodNum = 7 * $trial_cycle_count;
								break;
								case 'day':
								$periodNum = 1 * $trial_cycle_count;
								break;
							}									
							$stripe_array['trial_period_days']=$periodNum;
						}																	
						try {
							$p = \Stripe\Plan::retrieve($p_name);
							} catch (Exception $e) {
							$error==1;
						}
						if( $error==0){
							$p->delete();	
						}
						\Stripe\Plan::create($stripe_array);
					}	
				}
				// End Stripe Plan Create*****	
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}
			public function listfoliopro_update_paypal_settings() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;		
				$post_name='listfoliopro_paypal_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(!isset($row->ID )){
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'Paypal Setting', 'post_type'=>'iv_payment_setting','post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);
					}else{
					$newpost_id= $row->ID;
				}
				update_post_meta($newpost_id, 'listfoliopro_paypal_mode', sanitize_text_field($form_data['paypal_mode']));
				update_post_meta($newpost_id, 'listfoliopro_paypal_username', sanitize_text_field($form_data['paypal_username']));
				update_post_meta($newpost_id, 'listfoliopro_paypal_api_password', sanitize_text_field($form_data['paypal_api_password']));
				update_post_meta($newpost_id, 'listfoliopro_paypal_api_signature', sanitize_text_field($form_data['paypal_api_signature']));
				update_post_meta($newpost_id, 'listfoliopro_paypal_api_currency', sanitize_text_field($form_data['paypal_api_currency']));						
				update_option('listfoliopro_api_currency', sanitize_text_field($form_data['paypal_api_currency'] ));
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}
			public function listfoliopro_update_stripe_settings() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_name='listfoliopro_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name));
				if(!isset($row->ID )){
					$post_type = 'iv_payment_setting';
					$my_post_form = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => 'stripe Setting','post_type'=>$post_type, 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
					$newpost_id = wp_insert_post($my_post_form);								
					}else{
					$newpost_id= $row->ID;
				}
				update_post_meta($newpost_id, 'listfoliopro_stripe_mode', sanitize_text_field($form_data['stripe_mode']));
				update_post_meta($newpost_id, 'listfoliopro_stripe_live_secret_key', sanitize_text_field($form_data['secret_key']));update_post_meta($newpost_id, 'listfoliopro_stripe_live_publishable_key', sanitize_text_field($form_data['publishable_key']));
				update_post_meta($newpost_id, 'listfoliopro_stripe_secret_test', sanitize_text_field($form_data['secret_key_test']));						
				update_post_meta($newpost_id, 'listfoliopro_stripe_publishable_test', sanitize_text_field($form_data['stripe_publishable_test']));		
				update_post_meta($newpost_id, 'listfoliopro_stripe_api_currency', sanitize_text_field($form_data['stripe_api_currency']));
				update_option('listfoliopro_api_currency', sanitize_text_field($form_data['stripe_api_currency'] ));
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}
			public function listfoliopro_create_coupon() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_content="";
				global $wpdb;			
				$post_name=$form_data['coupon_name'];
				$coupon_data = array('post_title' => wp_strip_all_tags($post_name), 'post_name' => wp_strip_all_tags($post_name), 'post_content' => $post_name,'post_type'=>'listfoliopro_coupon', 'post_status' => 'draft', 'post_author' => get_current_user_id(),);
				$newpost_id = wp_insert_post($coupon_data);
				if($form_data['coupon_count']==""){
					$coupon_limit='99999';
					}else{
					$coupon_limit=sanitize_text_field($form_data['coupon_count']);
				}
				$pac=''; $pck_ids=array();
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids']; }
				if($pac!=''){
					$pck_ids =implode(",",$pac);
				}
				update_post_meta($newpost_id, 'listfoliopro_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'listfoliopro_coupon_limit',$coupon_limit);
				update_post_meta($newpost_id, 'listfoliopro_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_amount', sanitize_text_field($form_data['coupon_amount']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function listfoliopro_update_coupon() {
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'coupon' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);						
				$post_content="";
				global $wpdb;	
				$post_title=sanitize_text_field($form_data['coupon_name']);
				$post_id=sanitize_text_field($form_data['coupon_id']);
				$newpost_id=$post_id;
				$my_post = array(
				'ID'           => $post_id,
				'post_title'   => $post_title,								
				);
				wp_update_post( $my_post );
				$pac=''; $pck_ids=array();
				if(isset($_POST['form_pac_ids'])){$pac=$_POST['form_pac_ids']; }
				if($pac!=''){
					$pck_ids =implode(",",$pac);
				}						
				update_post_meta($newpost_id, 'listfoliopro_coupon_pac_id', $pck_ids);
				update_post_meta($newpost_id, 'listfoliopro_coupon_limit', sanitize_text_field($form_data['coupon_count']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_start_date', sanitize_text_field($form_data['start_date']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_end_date', sanitize_text_field($form_data['end_date']));
				update_post_meta($newpost_id, 'listfoliopro_coupon_amount', sanitize_text_field($form_data['coupon_amount']));	update_post_meta($newpost_id, 'listfoliopro_coupon_type', sanitize_text_field($form_data['coupon_type']));
				echo wp_json_encode(array('code' => 'success'));
				exit(0);
			}	
			public function listfoliopro_update_payment_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=sanitize_text_field($form_data['iv_terms']);
				}
				$terms_detail=sanitize_text_field($form_data['terms_detail']);
				$iv_coupon='';
				if(isset($form_data['iv_coupon'])){
					$iv_coupon=sanitize_text_field($form_data['iv_coupon']);
				}
				update_option('listfoliopro_payment_terms_text', $terms_detail );
				update_option('listfoliopro_payment_terms', $iv_terms );
				update_option('epjblistfoliopro_payment_coupon', $iv_coupon );
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_account_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$post_approved='no';
				if(isset($form_data['post_approved'])){
					$post_approved=sanitize_text_field($form_data['post_approved']);
				}
				$signup_redirect=sanitize_text_field($form_data['signup_redirect']);
				$private_profile_page  = sanitize_text_field($form_data['pri_profile_redirect']); 
				$pub_profile_redirect=sanitize_text_field($form_data['profile_redirect']);
				if(isset($form_data['hide_admin_bar'])){
					$admin_bar=$form_data['hide_admin_bar'];
					}else{
					$admin_bar='no';
				}
				update_option('listfoliopro_post_approved', $post_approved );
				update_option('listfoliopro_signup_redirect', $signup_redirect );
				update_option('listfoliopro_profile_page', $private_profile_page );
				update_option('epjblistfoliopro_profile_public_page', $pub_profile_redirect );
				update_option('epjblistfoliopro_hide_admin_bar', $admin_bar );
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_protected_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['active_visibility'])){
					$active_visibility=$form_data['active_visibility'];
					}else{
					$active_visibility='no';
				}		
				update_option('epjblistfoliopro_active_visibility', $active_visibility );
				if(isset($form_data['login_message'])){
					update_option('listfoliopro_visibility_login_message', sanitize_text_field($form_data['login_message'] ));
				}
				if(isset($form_data['visitor_message'])){
					update_option('listfoliopro_visibility_visitor_message', sanitize_text_field($form_data['visitor_message'] ));
				}
				update_option('listfoliopro_visibility_serialize_role', $form_data);
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_page_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$iv_terms='no';
				if(isset($form_data['iv_terms'])){
					$iv_terms=$form_data['iv_terms'];
				}
				$pricing_page=sanitize_text_field($form_data['price_table']);
				
				$signup_page=sanitize_text_field($form_data['signup_page']);
				
				$profile_page=sanitize_text_field($form_data['profile_page']);
				
				$thank_you=sanitize_text_field($form_data['thank_you_page']);
				$login=sanitize_text_field($form_data['login_page']);
				update_option('listfoliopro_price_table', $pricing_page); 
				update_option('listfoliopro_registration', $signup_page); 
				update_option('listfoliopro_profile_page', $profile_page);
				
				update_option('listfoliopro_thank_you_page',$thank_you); 
				update_option('listfoliopro_login_page',$login); 				
				
				
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_email_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$allowed_html = wp_kses_allowed_html( 'post' );
				parse_str($_POST['form_data'], $form_data);
				update_option( 'listfoliopro_signup_email_subject',sanitize_text_field($form_data['listfoliopro_signup_email_subject']));			
				update_option( 'listfoliopro_signup_email',wp_kses( $form_data['signup_email_template'], $allowed_html));
				update_option( 'listfoliopro_forget_email_subject',sanitize_text_field($form_data['forget_email_subject']));				
				update_option( 'listfoliopro_forget_email',wp_kses( $form_data['forget_email_template'], $allowed_html));
				update_option('listfoliopro_admin_email', sanitize_text_field($form_data['listfoliopro_admin_email'])); 
				update_option('listfoliopro_order_client_email_sub', sanitize_text_field($form_data['listfoliopro_order_email_subject']));
				update_option( 'listfoliopro_order_client_email',wp_kses( $form_data['order_client_email_template'], $allowed_html));
				update_option('listfoliopro_order_admin_email_sub', sanitize_text_field($form_data['listfoliopro_order_admin_email_subject']));
				update_option( 'listfoliopro_order_admin_email',wp_kses( $form_data['order_admin_email_template'], $allowed_html));
				update_option( 'listfoliopro_reminder_email_subject',sanitize_text_field($form_data['listfoliopro_reminder_email_subject']));
				update_option( 'listfoliopro_reminder_email',wp_kses( $form_data['reminder_email_template'], $allowed_html));
				update_option('listfoliopro_reminder_day', sanitize_text_field($form_data['listfoliopro_reminder_day'])); 
				update_option( 'listfoliopro_contact_email_subject',sanitize_text_field($form_data['contact_email_subject']));				
				update_option( 'listfoliopro_contact_email',wp_kses( $form_data['message_email_template'], $allowed_html));
				update_option( 'listfoliopro_apply_email_subject',sanitize_text_field($form_data['listfoliopro_apply_email_subject']));				
				update_option( 'listfoliopro_apply_email',wp_kses( $form_data['apply_email_template'], $allowed_html));
				update_option( 'listfoliopro_notification_email_subject',sanitize_text_field($form_data['listfoliopro_notification_email_subject']));
				update_option( 'listfoliopro_notification_email',wp_kses( $form_data['notification_email_template'], $allowed_html));
				$bcc_message=(isset($form_data['bcc_message'])? sanitize_text_field($form_data['bcc_message']):'' );		
				update_option('epjblistfoliopro_bcc_message',$bcc_message);
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_add_home_page(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$page_title='Home';
				$page_name='home';
				$page_content='';
				$post_iv = array(
				'post_title'    => wp_strip_all_tags( $page_title),
				'post_name'    => wp_strip_all_tags( $page_name),
				'post_content'  => $page_content,
				'post_status'   => 'publish',
				'post_author'   =>  get_current_user_id(),	
				'post_type'		=> 'page',
				);
				$newpost_id= wp_insert_post( $post_iv );
				update_option( 'listfoliopro_page_on_front', $newpost_id );
				update_option( 'listfoliopro_show_on_front', 'page' );
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Home page added', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_mailchamp_setting (){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('listfoliopro_mailchimp_api_key', sanitize_text_field($form_data['listfoliopro_mailchimp_api_key'])); 
				update_option('listfoliopro_mailchimp_confirmation', sanitize_text_field($form_data['listfoliopro_mailchimp_confirmation'])); 
				if(isset($form_data['listfoliopro_mailchimp_list'])){
					update_option('listfoliopro_mailchimp_list', sanitize_text_field($form_data['listfoliopro_mailchimp_list'])); 
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_package_status (){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'package' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				global $wpdb;
				$package_id_update=trim($_POST['status_id']);
				$package_current_status=trim(sanitize_text_field($_POST['status_current']));
				if($package_current_status=="pending"){
					$package_st='draft';
					$pac_msg='Active';
					}else{
					$package_st='pending';
					$pac_msg='Inactive';
				}
				$post_type = 'listfoliopro_pack';
				$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}posts SET post_status='%s' WHERE ID='%s' LIMIT 1",$package_st,$package_id_update );
				$wpdb->query($query);
				echo wp_json_encode(array("code" => "success","msg"=>$pac_msg,"current_st"=>$package_st));
				exit(0);
			}
			public function listfoliopro_gateway_settings_update(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'payment-gateway' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$payment_gateway = sanitize_text_field($_POST['payment_gateway']);
				global $wpdb;
				update_option('listfoliopro_payment_gateway', $payment_gateway);
				// For Stripe Plan Create*****
				$iv_gateway = get_option('listfoliopro_payment_gateway');
				if($iv_gateway=='stripe'){
					$stripe_id='';
					$post_name2='listfoliopro_stripe_setting';
					$row2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name2 ));
					if(isset($row2->ID )){
						$stripe_id= $row2->ID;
					}
					$listfoliopro_pack='listfoliopro_pack';
					$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$listfoliopro_pack );
					$membership_pack = $wpdb->get_results($sql);
					if(count($membership_pack)>0){
						$i=0;
						include(listfoliopro_ep_DIR. '/admin/init.php');
						$stripe_mode=get_post_meta( $stripe_id,'listfoliopro_stripe_mode',true);	
						if($stripe_mode=='test'){
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_secret_test',true);	
							}else{
							$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_live_secret_key',true);	
						}	
						$stripe_currency =get_post_meta($stripe_id, 'listfoliopro_stripe_api_currency',true);
						\Stripe\Stripe::setApiKey($stripe_api);
						foreach ( $membership_pack as $row )
						{		$package_recurring=get_post_meta( $row->ID,'listfoliopro_package_recurring',true);	
							if($package_recurring=='on'){
								$interval_count= get_post_meta( $row->ID,'listfoliopro_package_recurring_cycle_count',true);
								$interval_count= ($interval_count=="" ? '1':$interval_count);
								$stripe_array=array();						
								$p_name = $row->post_name;
								$stripe_array['id']= $p_name;								
								$stripe_array['amount']=get_post_meta( $row->ID,'listfoliopro_package_recurring_cost_initial',true) * 100;
								$stripe_array['interval']=get_post_meta( $row->ID,'listfoliopro_package_recurring_cycle_type',true);
								$stripe_array['interval_count']=$interval_count;
								$stripe_array['currency']=$stripe_currency;
								$stripe_array['product']=array('name' => $p_name);
								$trial=get_post_meta($row->ID, 'listfoliopro_package_enable_trial_period', true);
								if($trial=='yes'){
									$trial_type = get_post_meta( $row->ID,'listfoliopro_package_recurring_trial_type',true);
									$trial_cycle_count =get_post_meta($row->ID, 'listfoliopro_package_trial_period_interval', true);
									switch ($trial_type) {
										case 'year':
										$periodNum =  365 * 1;
										break;
										case 'month':
										$periodNum =  30 * $trial_cycle_count;
										break;
										case 'week':
										$periodNum = 7 * $trial_cycle_count;
										break;
										case 'day':
										$periodNum = 1 * $trial_cycle_count;
										break;
									}									
									$stripe_array['trial_period_days']=$periodNum;
								}																	
								try {
									\Stripe\Plan::retrieve($p_name);
									} catch (Exception $e) {
									if($stripe_array['amount']>0){
										\Stripe\Plan::create($stripe_array);
									}
								}
							}	
						}
					}
				}	
				// End Stripe Plan Create*****	
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully: Your current gateway is ', 'listfoliopro').$payment_gateway));
				exit(0);
			}
			public function listfoliopro_update_color_settings(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['listfoliopro_primary_color'])){
					update_option('listfoliopro_primary_color',sanitize_text_field($form_data['listfoliopro_primary_color']));
				}
				if(isset($form_data['listfoliopro_second_color'])){
					update_option('listfoliopro_second_color',sanitize_text_field($form_data['listfoliopro_second_color']));
				}
				if(isset($form_data['listfoliopro_listing_d_color'])){
					update_option('listfoliopro_listing_d_color',sanitize_text_field($form_data['listfoliopro_listing_d_color']));
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_map_settings(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				update_option('listfoliopro_map_api',sanitize_text_field($form_data['dir_map_api']));
				
				update_option('listfoliopro_map_zoom',sanitize_text_field($form_data['dir_map_zoom']));				
				update_option('listfoliopro_map_type',sanitize_text_field($form_data['map_type']));
				update_option('listfoliopro_map_radius',sanitize_text_field($form_data['listfoliopro_map_radius']));
				update_option('listfoliopro_near_to_me',sanitize_text_field($form_data['listfoliopro_near_to_me']));				
				update_option('listfoliopro_defaultlatitude',sanitize_text_field($form_data['listfoliopro_defaultlatitude']));
				update_option('listfoliopro_defaultlongitude',sanitize_text_field($form_data['listfoliopro_defaultlongitude']));
				if(isset($form_data['listfoliopro_forcelocation'])){
					update_option('listfoliopro_forcelocation',sanitize_text_field($form_data['listfoliopro_forcelocation']));
					}else{
					update_option('listfoliopro_forcelocation','no');
				}
				if(isset($form_data['listfoliopro_infobox_image'])){
					update_option('listfoliopro_infobox_image',sanitize_text_field($form_data['listfoliopro_infobox_image']));
					}else{
					update_option('listfoliopro_infobox_image','no');
				}
				if(isset($form_data['listfoliopro_infobox_title'])){
					update_option('listfoliopro_infobox_title',sanitize_text_field($form_data['listfoliopro_infobox_title']));
					}else{
					update_option('listfoliopro_infobox_title','no');
				}
				if(isset($form_data['listfoliopro_infobox_location'])){
					update_option('listfoliopro_infobox_location',sanitize_text_field($form_data['listfoliopro_infobox_location']));
					}else{
					update_option('listfoliopro_infobox_location','no');
				}
				if(isset($form_data['listfoliopro_infobox_direction'])){
					update_option('listfoliopro_infobox_direction',sanitize_text_field($form_data['listfoliopro_infobox_direction']));
					}else{
					update_option('listfoliopro_infobox_direction','no');
				}
				if(isset($form_data['listfoliopro_infobox_linkdetail'])){
					update_option('listfoliopro_infobox_linkdetail',sanitize_text_field($form_data['listfoliopro_infobox_linkdetail']));
					}else{
					update_option('listfoliopro_infobox_linkdetail','no');
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_search_shortcodes_saved_delete(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				parse_str($_POST['form_data'], $form_data);
				$new_field_arr= array();
				if(isset($form_data['shortcodearr'])){
					foreach ( $form_data['shortcodearr'] as $field_key => $field_value ) { 
						$new_field_arr[]= sanitize_text_field($field_value);
					}
				}				
				print_r($new_field_arr);
				update_option('listfoliopro_search_shortcodes_saved',$new_field_arr);
				echo wp_json_encode(array("code" => "success","msg"=>''));
				exit(0);
			}
			public function listfoliopro_create_search_shortcode(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				parse_str($_POST['form_data'], $form_data);
				$post_fields_type=array();		
				$i=0;$field_name='';	$field_type='';
				if(isset($form_data['listfoliopro_single_restrict'])){
					update_option('listfoliopro_single_restrict',sanitize_text_field($form_data['listfoliopro_single_restrict']));
					}else{
					update_option('listfoliopro_single_restrict','no');
				}
				$short_text='[listfoliopro_search ';
				$short_text=$short_text.'action="'.$form_data['listfoliopro_search_action_target'].'" ';
				foreach ( $form_data['search-field-name'] as $field_key => $field_value ) { 
					$post_fields_type[sanitize_text_field($field_value)]=sanitize_text_field($form_data['search-field-type'][$field_key]);	
					$field_name=$field_name.$field_value.',';
					$field_type=$field_type.sanitize_text_field($form_data['search-field-type'][$field_key]).',';
					$i++;
				}
				$short_text=$short_text. 'field-name="'.$field_name.'" field-type="'.$field_type.'"  ]';
				$short_text_all='';
				$short_text_saved=get_option('listfoliopro_search_shortcodes_saved' );
				if(is_array($short_text_saved)){
					$short_text_saved[]=$short_text;	
				}
				if($short_text_saved==''){
					$short_text_saved =array();
					$short_text_saved[]=$short_text;
				}
				update_option('listfoliopro_search_shortcodes_saved',$short_text_saved );
				echo wp_json_encode(array("code" => "success","msg"=>$short_text));
				exit(0);
			}
			public function listfoliopro_update_single_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				parse_str($_POST['form_data'], $form_data);				
				$post_fields_type=array();	
				$post_fields_icon=array();
				$post_fields_top=array();
				
				$i=0;
				foreach ( $form_data['singlie_top_fields'] as $field_key => $field_value ) { 
					$post_fields_top[$i]=sanitize_text_field($field_value);				
					$i++;
				}
				update_option('listfoliopro_fields_top_saved',$post_fields_top );
				$i=0;
				foreach ( $form_data['search-field-name'] as $field_key => $field_value ) { 
					$post_fields_type[sanitize_text_field($field_value)]=sanitize_text_field($form_data['search-field-type'][$field_key]);$					
					$i++;
				}
				
				update_option('listfoliopro_single_fields_saved',$post_fields_type );							
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_archive_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				parse_str($_POST['form_data'], $form_data);				
				$post_fields_type=array();
				$post_fields_icon=array();
				$post_sort_top=array();
				
				$i=0;
				foreach ( $form_data['sort_top_fields'] as $field_key => $field_value ) { 
					$post_sort_top[$i]=sanitize_text_field($field_value);				
					$i++;
				}
				update_option('listfoliopro_top_sort_saved',$post_sort_top );
				
				$i=0;
				foreach ( $form_data['search-field-name'] as $field_key => $field_value ) { 
					$post_fields_type[sanitize_text_field($field_value)]=sanitize_text_field($form_data['search-field-type'][$field_key]);
					$post_fields_icon[sanitize_text_field($field_value)]=sanitize_text_field($form_data['field_icon'][$field_key]);
					$i++;
				}
				if(isset($form_data['archive_field_label'])){
					update_option('archive_field_label',$form_data['archive_field_label'] );	
				}else{
					update_option('archive_field_label','no' );	
				}
				
				update_option('listfoliopro_archive_fields_saved',$post_fields_type );
				update_option('listfoliopro_archive_icon_saved',$post_fields_icon );
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_search_fields(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}	
				parse_str($_POST['form_data'], $form_data);				
				$post_fields_type=array();		
				$i=0;
				foreach ( $form_data['search-field-name'] as $field_key => $field_value ) { 
					$post_fields_type[sanitize_text_field($field_value)]=sanitize_text_field($form_data['search-field-type'][$field_key]);					
					$i++;
				}
				update_option('listfoliopro_search_action_target',sanitize_url($form_data['listfoliopro_search_action_target']) );				
				update_option('listfoliopro_search_fields_saved',$post_fields_type );
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_user_settings(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'settings' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}		
				parse_str($_POST['form_data'], $form_data);
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );
				}	
				$user_id=sanitize_text_field($form_data['user_id']);
				if($form_data['exp_date']!=''){
					$exp_d=gmdate('Y-m-d', strtotime($form_data['exp_date']));	 
					update_user_meta($user_id, 'listfoliopro_exprie_date',$exp_d); 
				}		
				update_user_meta($user_id, 'listfoliopro_payment_status', sanitize_text_field($form_data['payment_status']));	
				update_user_meta($user_id, 'listfoliopro_package_id',sanitize_text_field($form_data['package_sel'])); 
				
				if(isset($form_data['topbanner_url']) AND $form_data['topbanner_url']!=''){				 
					update_user_meta($user_id,'topbanner', sanitize_url($form_data['topbanner_url']));
				}
				if(isset($form_data['profile_image_url']) AND $form_data['profile_image_url']!=''){				 
					update_user_meta($user_id,'listfoliopro_profile_pic_thum', sanitize_url($form_data['profile_image_url']));
				}
				$user = new WP_User( $user_id );
				$user->set_role(sanitize_text_field($form_data['user_role']));
				$field_type=array();
				$field_type_opt=  get_option( 'listfoliopro_field_type' );
				if($field_type_opt!=''){
					$field_type=get_option('listfoliopro_field_type' );
					}else{
					$field_type['first_name']='text';
					$field_type['last_name']='text';
					$field_type['phone']='text';								
					$field_type['address']='text';
					$field_type['city']='text';
					$field_type['zipcode']='text';
					$field_type['country']='text';
					$field_type['listing_title']='text';					
					$field_type['occupation']='text';
					$field_type['description']='textarea';
					$field_type['web_site']='url';					
				}		
				foreach ( $form_data as $field_key => $field_value ) { 
					if(strtolower(trim($field_key))!='wp_capabilities'){						
						if(is_array($field_value)){
							$field_value =implode(",",$field_value);
						}
						if($field_type[$field_key]=='url'){							
							update_user_meta($user_id, sanitize_text_field($field_key), sanitize_url($field_value)); 
							}elseif($field_type[$field_key]=='textarea'){
							update_user_meta($user_id, sanitize_text_field($field_key), sanitize_textarea_field($field_value));  
							}else{
							update_user_meta($user_id, sanitize_text_field($field_key), sanitize_text_field($field_value)); 
						}
					}
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
		}
	}
$listfoliopro_eplugins_admin = new listfoliopro_eplugins_Admin();