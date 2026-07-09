<?php
	/**
		*
		*
		* @version 1.0.1
		* @package Main
		* @author e-plugins
	*/
	/*
		Plugin Name: ListfolioPro
		Plugin URI: http://e-plugins.com/
		Description: Build Paid Service Directory listing using WordPress.No programming knowledge required.
		Author: e-plugins
		Author URI: http://e-plugins.com/
		Version: 1.0.1
		Text Domain: listfoliopro
		License: GPLv3
	*/
	// Exit if accessed directly
	if (!defined('ABSPATH')) {
		exit;
	}
	define( 'Property_Pro', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) .'/');
	if (!class_exists('listfoliopro_eplugins')) {
		final class listfoliopro_eplugins {
			private static $instance;
			/**
				* The Plug-in version.
				*
				* @var string
			*/
			public $version = "1.0.1";
			/**
				* The minimal required version of WordPress for this plug-in to function correctly.
				*
				* @var string
			*/
			public $wp_version = "3.5";
			public static function instance() {
				if (!isset(self::$instance) && !(self::$instance instanceof listfoliopro_eplugins)) {
					self::$instance = new listfoliopro_eplugins;
				}
				return self::$instance;
			}
			/**
				* Construct and start the other plug-in functionality
			*/
			public function __construct() {
				//
				// 1. Plug-in requirements
				//
				if (!$this->check_requirements()) {
					return;
				}
				//
				// 2. Declare constants and load dependencies
				//
				$this->define_constants();
				$this->load_dependencies();
				//
				// 3. Activation Hooks
				//
				register_activation_hook(__FILE__, array($this, 'activate'));
				register_deactivation_hook(__FILE__, array($this, 'deactivate'));
				register_uninstall_hook(__FILE__, 'listfoliopro_eplugins::uninstall');
				//
				// 4. Load Widget
				//
				add_action('widgets_init', array($this, 'register_widget'));
				//
				// 5. i18n
				//
				add_action('init', array($this, 'i18n'));
				//
				// 6. Actions
				//	
				add_action('wp_ajax_listfoliopro_check_coupon', array($this, 'listfoliopro_check_coupon'));
				add_action('wp_ajax_nopriv_listfoliopro_check_coupon', array($this, 'listfoliopro_check_coupon'));
				add_action('wp_ajax_listfoliopro_check_package_amount', array($this, 'listfoliopro_check_package_amount'));
				add_action('wp_ajax_nopriv_listfoliopro_check_package_amount', array($this, 'listfoliopro_check_package_amount'));
				add_action('wp_ajax_listfoliopro_update_profile_pic', array($this, 'listfoliopro_update_profile_pic'));
				add_action('wp_ajax_listfoliopro_update_profile_setting', array($this, 'listfoliopro_update_profile_setting'));
				add_action('wp_ajax_listfoliopro_update_wp_post', array($this, 'listfoliopro_update_wp_post'));
				add_action('wp_ajax_listfoliopro_save_wp_post', array($this, 'listfoliopro_save_wp_post'));
				add_action('wp_ajax_listfoliopro_update_setting_password', array($this, 'listfoliopro_update_setting_password'));
				add_action('wp_ajax_listfoliopro_check_login', array($this, 'listfoliopro_check_login'));
				add_action('wp_ajax_nopriv_listfoliopro_check_login', array($this, 'listfoliopro_check_login'));
				add_action('wp_ajax_listfoliopro_forget_password', array($this, 'listfoliopro_forget_password'));
				add_action('wp_ajax_nopriv_listfoliopro_forget_password', array($this, 'listfoliopro_forget_password'));
				add_action('wp_ajax_listfoliopro_cancel_stripe', array($this, 'listfoliopro_cancel_stripe'));
				add_action('wp_ajax_listfoliopro_cancel_paypal', array($this, 'listfoliopro_cancel_paypal'));
				add_action('wp_ajax_listfoliopro_profile_stripe_upgrade', array($this, 'listfoliopro_profile_stripe_upgrade'));
				add_action('wp_ajax_listfoliopro_save_favorite', array($this, 'listfoliopro_save_favorite'));
				add_action('wp_ajax_listfoliopro_save_un_favorite', array($this, 'listfoliopro_save_un_favorite'));
				add_action('wp_ajax_listfoliopro_save_notification', array($this, 'listfoliopro_save_notification'));
				add_action('wp_ajax_listfoliopro_delete_favorite', array($this, 'listfoliopro_delete_favorite'));				
				add_action('wp_ajax_listfoliopro_message_delete', array($this, 'listfoliopro_message_delete'));
				add_action('wp_ajax_listfoliopro_booking_delete', array($this, 'listfoliopro_booking_delete'));
				add_action('wp_ajax_listfoliopro_message_send', array($this, 'listfoliopro_message_send'));
				add_action('wp_ajax_nopriv_listfoliopro_message_send', array($this, 'listfoliopro_message_send'));
				add_action('wp_ajax_listfoliopro_booking_message_send', array($this, 'listfoliopro_booking_message_send'));
				add_action('wp_ajax_nopriv_listfoliopro_booking_message_send', array($this, 'listfoliopro_booking_message_send'));
				add_action('wp_ajax_listfoliopro_chatgpt_upload_image', array($this, 'listfoliopro_chatgpt_upload_image'));
				add_action('wp_ajax_listfoliopro_claim_send', array($this, 'listfoliopro_claim_send'));
				add_action('wp_ajax_nopriv_listfoliopro_claim_send', array($this, 'listfoliopro_claim_send'));
				add_action('wp_ajax_listfoliopro_cron_listing', array($this, 'listfoliopro_cron_listing'));
				add_action('wp_ajax_nopriv_listfoliopro_cron_listing', array($this, 'listfoliopro_cron_listing'));
				add_action('wp_ajax_listfoliopro_finalerp_csv_product_upload', array($this, 'listfoliopro_finalerp_csv_product_upload'));
				add_action('wp_ajax_listfoliopro_save_csv_file_to_database', array($this, 'listfoliopro_save_csv_file_to_database'));
				add_action('wp_ajax_listfoliopro_eppro_get_import_status', array($this, 'listfoliopro_eppro_get_import_status'));
				add_action('wp_ajax_listfoliopro_contact_popup', array($this, 'listfoliopro_contact_popup'));
				add_action('wp_ajax_listfoliopro_listing_contact_popup', array($this, 'listfoliopro_listing_contact_popup'));
				add_action('wp_ajax_nopriv_listfoliopro_listing_contact_popup', array($this, 'listfoliopro_listing_contact_popup'));
				add_action('wp_ajax_listfoliopro_listing_claim_popup', array($this, 'listfoliopro_listing_claim_popup'));
				add_action('wp_ajax_nopriv_listfoliopro_listing_claim_popup', array($this, 'listfoliopro_listing_claim_popup'));
				add_action('wp_ajax_listfoliopro_listing_booking_popup', array($this, 'listfoliopro_listing_booking_popup'));
				add_action('wp_ajax_nopriv_listfoliopro_listing_booking_popup', array($this, 'listfoliopro_listing_booking_popup'));
				add_action('wp_ajax_listfoliopro_chatgtp_settings_popup', array($this, 'listfoliopro_chatgtp_settings_popup'));
				add_action('wp_ajax_nopriv_listfoliopro_chatgtp_settings_popup', array($this, 'listfoliopro_chatgtp_settings_popup'));
				add_action('wp_ajax_listfoliopro_load_categories_fields_wpadmin', array($this, 'listfoliopro_load_categories_fields_wpadmin'));
				add_action('wp_ajax_nopriv_listfoliopro_load_categories_fields_wpadmin', array($this, 'listfoliopro_load_categories_fields_wpadmin'));
				add_action('wp_ajax_listfoliopro_save_post_without_user', array($this, 'listfoliopro_save_post_without_user'));
				add_action('wp_ajax_nopriv_listfoliopro_save_post_without_user', array($this, 'listfoliopro_save_post_without_user'));
				add_action('wp_ajax_listfoliopro_save_user_review', array($this, 'listfoliopro_save_user_review'));
				add_action('add_meta_boxes', array($this, 'listfoliopro_custom_meta_listfoliopro'));
				add_action('save_post', array($this, 'listfoliopro_meta_save'));
				add_action('wp_ajax_listfoliopro_chatgpt_post_creator', array($this, 'listfoliopro_chatgpt_post_creator'));
				add_action('wp_ajax_nopriv_listfoliopro_chatgpt_post_creator', array($this, 'listfoliopro_chatgpt_post_creator'));
				add_action('pre_get_posts',array($this, 'listfoliopro_restrict_media_library') );
				// 7. Shortcode
				add_shortcode('listfoliopro_price_table', array($this, 'listfoliopro_price_table_func'));
				add_shortcode('listfoliopro_form_wizard', array($this, 'listfoliopro_form_wizard_func'));
				add_shortcode('listfoliopro_profile_template', array($this, 'listfoliopro_profile_template_func'));
				add_shortcode('listfoliopro_login', array($this, 'listfoliopro_login_func'));
				add_shortcode('listfoliopro_categories', array($this, 'listfoliopro_categories_func'));
				add_shortcode('listfoliopro_featured', array($this, 'listfoliopro_featured_func'));
				add_shortcode('listfoliopro_map', array($this, 'listfoliopro_map_func'));
				add_shortcode('listfoliopro_archive_grid_rounded', array($this, 'listfoliopro_archive_grid_rounded_func'));
				add_shortcode('listfoliopro_archive_grid_square', array($this, 'listfoliopro_archive_grid_square_func'));
				add_shortcode('listfoliopro_archive_grid_no_map', array($this, 'listfoliopro_archive_grid_no_map_func'));
				add_shortcode('listfoliopro_single_rounded', array($this, 'listfoliopro_single_rounded_func'));
				add_shortcode('listfoliopro_single_square', array($this, 'listfoliopro_single_square_func'));
				add_shortcode('listfoliopro_search', array($this, 'listfoliopro_search_func'));
				add_shortcode('listfoliopro_listing_filter', array($this, 'listfoliopro_listfoliopro_listing_filter_func'));
				add_shortcode('listfoliopro_categories_carousel', array($this, 'listfoliopro_categories_carousel_func'));
				add_shortcode('listfoliopro_tags_carousel', array($this, 'listfoliopro_tags_carousel_func'));
				add_shortcode('listfoliopro_locations_carousel', array($this, 'listfoliopro_locations_carousel_func'));
				add_shortcode('listfoliopro_locations', array($this, 'listfoliopro_locations_func'));
				add_shortcode('listfoliopro_reminder_email_cron', array($this, 'listfoliopro_reminder_email_cron_func'));
				add_shortcode('listfoliopro_add_listing', array($this, 'listfoliopro_add_listing_func'));
				// 8. Filter	
				add_filter( 'template_include', array($this, 'listfoliopro_include_template_function'), 9  );
				add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'listfoliopro_plugin_action_links' ) );
				// For elementor
				add_action( 'init', array($this, 'listfoliopro_elementor_file') );

				// *** End elementor
				//---- COMMENT FILTERS ----//		
				add_action('init', array($this, 'listfoliopro_remove_admin_bar') );
				add_action( 'init', array($this, 'listfoliopro_paypal_form_submit') );
				add_action( 'init', array($this, 'listfoliopro_stripe_form_submit') );
				add_action( 'init', array($this, 'listfoliopro_post_type') );
				add_action( 'init', array($this, 'listfoliopro_create_taxonomy_category'));
				add_action( 'init', array($this, 'listfoliopro_create_taxonomy_tags'));
				add_action( 'init', array($this, 'listfoliopro_create_taxonomy_locations'));
				add_action( 'init', array($this, 'listfoliopro_create_taxonomy_type'));
				add_action( 'init', array($this, 'ep_listfoliopro_pdf_cv') );
				add_action('init', array($this, 'listfoliopro_all_functions'));
				add_action( 'wp_loaded', array($this, 'listfoliopro_woocommerce_form_submit') );
				add_action( 'init', array($this, 'ep_listfoliopro_cpt_columns') );
				// Add color script
				add_action('wp_enqueue_scripts', array($this, 'listfoliopro_color_js') );
			}
			/**
				* Define constants needed across the plug-in.
			*/
			private function define_constants() {
				if (!defined('listfoliopro_ep_BASENAME')) define('listfoliopro_ep_BASENAME', plugin_basename(__FILE__));
				if (!defined('listfoliopro_ep_DIR')) define('listfoliopro_ep_DIR', dirname(__FILE__));
				if (!defined('listfoliopro_ep_FOLDER'))define('listfoliopro_ep_FOLDER', plugin_basename(dirname(__FILE__)));
				if (!defined('listfoliopro_ep_ABSPATH'))define('listfoliopro_ep_ABSPATH', trailingslashit(str_replace("\\", "/", WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)))));
				if (!defined('listfoliopro_ep_URLPATH'))define('listfoliopro_ep_URLPATH', trailingslashit(plugins_url() . '/' . plugin_basename(dirname(__FILE__))));
				if (!defined('listfoliopro_ep_ADMINPATH'))define('listfoliopro_ep_ADMINPATH', get_admin_url());
				$filename = get_stylesheet_directory()."/listfoliopro/";
				if (!file_exists($filename)) {					
					if (!defined('listfoliopro_ep_template'))define( 'listfoliopro_ep_template', listfoliopro_ep_ABSPATH.'template/' );
					}else{
					if (!defined('listfoliopro_ep_template'))define( 'listfoliopro_ep_template', $filename);
				}	
			}				
			public function listfoliopro_remove_admin_bar() {
				$iv_hide = get_option('epjblistfoliopro_hide_admin_bar');
				if (!current_user_can('administrator') && !is_admin()) {
					if($iv_hide=='yes'){							
						show_admin_bar(false);
					}
				}	
			}
			public function listfoliopro_include_template_function( $template_path ) {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				global $post;	
				$post_type = get_post_type();
				if($post_type==''){
					if(is_post_type_archive($listfoliopro_directory_url)){
						$post_type =$listfoliopro_directory_url;
					}
				}				
				if ( $post_type ==$listfoliopro_directory_url ) {
					if (is_singular()) {
						$directoryprosinglepage=get_option('directoryprosinglepage');
						if($directoryprosinglepage==''){$directoryprosinglepage='plugintemplate';}
						if($directoryprosinglepage=='custompage'){
							global $post;	
							$single_custompag=get_option('listing_single_custompage'); 
							$page_path= get_the_permalink($single_custompag);
							$template_path = add_query_arg( 'detail', $post->post_name, $page_path );
							wp_redirect($template_path);
							exit;
							}else{		
							$listfoliopro_single_style=get_option('listfoliopro_single_style');
							if($listfoliopro_single_style==""){$listfoliopro_single_style='style-2';}
							if($listfoliopro_single_style=='style-1'){
								$template_path =  listfoliopro_ep_template. 'listing/single-listing-1.php';	
								}else{
								$template_path =  listfoliopro_ep_template. 'listing/single-listing-2.php';	
							}
							return $template_path;
						}
					}				
					if( is_tag() || is_category() || is_archive() ){
						$template_path =  listfoliopro_ep_template. 'listing/listing-layout.php';
					}
				}
				return $template_path;
			}
			public function listfoliopro_create_taxonomy_category() {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$listfoliopro_label_category=get_option('listfoliopro_label_category');
				if($listfoliopro_label_category==""){$listfoliopro_label_category=esc_html__('Categories','listfoliopro');}
				$labels = array(			
				'all_items'           => esc_html( $listfoliopro_label_category ),
				'add_new_item'        => esc_html__( 'Add New ', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add ', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New ', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit ', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update ', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View ', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search ', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				register_taxonomy(
				$listfoliopro_directory_url.'-category',
				$listfoliopro_directory_url,
				array(
				'label' => esc_html($listfoliopro_label_category),
				'rewrite' => array( 'slug' => $listfoliopro_directory_url.'-category' ),
				'hierarchical' => true,					
				'show_in_rest' =>	true,
				'labels'              => $labels,
				)
				);
			}
			public function listfoliopro_post_type() {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$listfoliopro_directory_url_name=ucfirst($listfoliopro_directory_url);
						$listfoliopro_directory_url_name=__($listfoliopro_directory_url_name, 'listfoliopro');
				$labels = array(
				'name'                => esc_html( $listfoliopro_directory_url_name ),
				'singular_name'       => esc_html( $listfoliopro_directory_url_name),
				'menu_name'           => esc_html( $listfoliopro_directory_url_name ),
				'name_admin_bar'      => esc_html( $listfoliopro_directory_url_name),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'listfoliopro' ),
				'all_items'           => esc_html__( 'All ', 'listfoliopro' ).$listfoliopro_directory_url_name,
				'add_new_item'        => esc_html__( 'Add New Item', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add New', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New Item', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit Item', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update Item', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View Item', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search Item', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				$args = array(
				'label'               => esc_html( $listfoliopro_directory_url_name ),
				'description'         => esc_html( $listfoliopro_directory_url_name ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),					
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu' => 		'listfoliopro',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'show_in_rest' =>	true,	
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( $listfoliopro_directory_url, $args );
				///******Review**********
				$labels2 = array(
				'name'                => _x( 'Reviews', 'Post Type General Name', 'listfoliopro' ),
				'singular_name'       => _x( 'Reviews', 'Post Type Singular Name', 'listfoliopro' ),
				'menu_name'           => esc_html__( 'Reviews', 'listfoliopro' ),
				'name_admin_bar'      =>esc_html__( 'Reviews', 'listfoliopro' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'listfoliopro' ),
				'all_items'           => esc_html__( 'All Reviews', 'listfoliopro' ),
				'add_new_item'        => esc_html__( 'Add New Review', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add New', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New Review', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit Review', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update Review', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View Review', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search Review', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				$args2 = array(
				'label'               => esc_html__( 'Reviews', 'listfoliopro' ),
				'description'         => esc_html__( 'Reviews: Directory Pro', 'listfoliopro' ),
				'labels'              => $labels2,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu' => 		'listfoliopro',
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'listfoliopro_review', $args2 );
				///******Booking**********
				$labels2 = array(
				'name'                => _x( 'Booking', 'Post Type General Name', 'listfoliopro' ),
				'singular_name'       => _x( 'Booking', 'Post Type Singular Name', 'listfoliopro' ),
				'menu_name'           => esc_html__( 'Booking', 'listfoliopro' ),
				'name_admin_bar'      =>esc_html__( 'Booking', 'listfoliopro' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'listfoliopro' ),
				'all_items'           => esc_html__( 'All Booking', 'listfoliopro' ),
				'add_new_item'        => esc_html__( 'Add New Review', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add New', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New Review', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit Review', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update Review', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View Review', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search Review', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				$args2 = array(
				'label'               => esc_html__( 'Booking', 'listfoliopro' ),
				'description'         => esc_html__( 'Booking', 'listfoliopro' ),
				'labels'              => $labels2,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu' => 		'listfoliopro',
				'menu_position'       => 6,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'listfoliopro_booking', $args2 );
				// Message 
				$labels4 = array(
				'name'                => esc_html__( 'Message', 'Post Type General Name', 'listfoliopro' ),
				'singular_name'       => esc_html__( 'Message', 'Post Type Singular Name', 'listfoliopro' ),
				'menu_name'           => esc_html__( 'Message', 'listfoliopro' ),
				'name_admin_bar'      => esc_html__( 'Message', 'listfoliopro' ),
				'parent_item_colon'   => esc_html__( 'Parent Item:', 'listfoliopro' ),
				'all_items'           => esc_html__( 'All Message', 'listfoliopro' ),
				'add_new_item'        => esc_html__( 'Add New Item', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add New', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New Item', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit Item', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update Item', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View Item', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search Item', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				$args4 = array(
				'label'               => esc_html__( 'Message', 'listfoliopro' ),
				'description'         => esc_html__( 'Message', 'listfoliopro' ),
				'labels'              => $labels4,
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments', 'post-formats','custom-fields' ),					
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu' => 		'listfoliopro',
				'menu_position'       => 5,
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'show_in_rest' =>true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				);
				register_post_type( 'listfoliopro_message', $args4 );
			}
			public function listfoliopro_post_type_tags_fix($request) {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				if ( isset($request['tag']) && !isset($request['post_type']) ){
					$request['post_type'] = $listfoliopro_directory_url;
				}
				return $request;
			} 
			public function ep_listfoliopro_cpt_columns(){
				require_once(listfoliopro_ep_DIR . '/admin/pages/manage-cpt-columns.php');
			}
			public function listfoliopro_plugin_action_links( $links ) {
				return array_merge( array(
				'settings' => '<a href="admin.php?page=listfoliopro-settings">' . esc_html__( 'Settings', 'listfoliopro' ).'</a>',
				'doc'  => '<a href="'.esc_url('http://help.eplug-ins.com/listfoliopro').'">' . esc_html__( 'Docs', 'listfoliopro' ) . '</a>',
				), $links );
			}	
			public function author_public_profile() {
				$author = get_the_author();	
				$iv_redirect = get_option('epjblistfoliopro_profile_public_page');
				if($iv_redirect!='defult'){ 
					$reg_page= get_permalink( $iv_redirect) ; 
					return    $reg_page.'?&id='.$author; 
					exit;
				}
			}
			public function listfoliopro_login_func($atts = ''){ 
				global $current_user;
				ob_start();		
				if($current_user->ID==0){
					include(listfoliopro_ep_template. 'private-profile/profile-login.php');
					}else{	
					include( listfoliopro_ep_template. 'private-profile/profile-template-1.php');
				}	
				$content = ob_get_clean();	
				return $content;
			}
			public function listfoliopro_forget_password(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'listfoliopro' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $data_a);
				if( ! email_exists($data_a['forget_email']) ) {
					echo wp_json_encode(array("code" => "not-success","msg"=>"There is no user registered with that email address."));
					exit(0);
					} else {
					require_once( listfoliopro_ep_ABSPATH. 'inc/forget-mail.php');
					echo wp_json_encode(array("code" => "success","msg"=>"Updated Successfully"));
					exit(0);
				}
			}
			public function listfoliopro_check_login(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'listfoliopro' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				global $user;
				$creds = array();
				$creds['user_login'] =sanitize_text_field($form_data['username']);
				$creds['user_password'] =  sanitize_text_field($form_data['password']);
				$creds['remember'] = 'true';
				$secure_cookie = is_ssl() ? true : false;
				$user = wp_signon( $creds, $secure_cookie );
				if ( is_wp_error($user) ) {
					echo wp_json_encode(array("code" => "not-success","msg"=>$user->get_error_message()));
					exit(0);
				}
				if ( !is_wp_error($user) ) {
					$iv_redirect = get_option('listfoliopro_profile_page');
					if($iv_redirect!='defult'){
						$reg_page= get_permalink( $iv_redirect); 
						echo wp_json_encode(array("code" => "success","msg"=>$reg_page));
						exit(0);
					}
				}		
			}
			public function get_unique_keyword_values( $post_type, $key = 'keyword'  ){
				global $wpdb;
				if( empty( $key ) ){
					return;
				}	
				$res=array();
				$args = array(
				'post_type' => $post_type, // enter your custom post type						
				'post_status' => 'publish',						
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				);
				$query_auto = new WP_Query( $args );
				$posts_auto = $query_auto->posts;						
				foreach($posts_auto as $post_a) {
					$res[]=$post_a->post_title;
				}	
				return $res;
			}
			public function get_unique_post_meta_values( $post_type,$key = 'postcode' ){
				global $wpdb;
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				if( empty( $key ) ){
					return;
				}	
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );
				return $res;
			}  
			public function listfoliopro_check_field_input_access($field_key_pass, $field_value, $user_id, $template='myaccount'){
				if($template=='myaccount'){				
					$current_user_id=$user_id;					
					}else{
					$current_user_id=0;		
				}	
				
				$field_type_opt=  get_option( 'listfoliopro_field_type' );
				if(!empty($field_type_opt)){
					$field_type=get_option('listfoliopro_field_type' );
					}else{
					$field_type= array();
					$field_type['full_name']='text';
					$field_type['phone']='text';					
					$field_type['address']='text';
					$field_type['city']='text';
					$field_type['postcode']='text';
					$field_type['state']='text';
					$field_type['country']='text';	
					$field_type['website']='url';
					$field_type['description']='textarea';	
								
				}
				$field_type_value= get_option( 'listfoliopro_field_type_value' );				
				$return_value='';
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='dropdown'){	 								
					$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
					$return_value=$return_value.'<div class="col-md-6"><div class="form-group">
					<label class="control-label">'. esc_html($field_value).'</label>
					<select name="'. esc_html($field_key_pass).'" id="'.esc_attr($field_key_pass).'" class="form-control col-md-12"  >';				
					foreach($dropdown_value as $one_value){	 
						if(trim($one_value)!=''){
							$return_value=$return_value.'<option '.(trim(get_user_meta($current_user_id,$field_key_pass,true))==trim($one_value)?' selected':'').' value="'. esc_attr($one_value).'">'. esc_html($one_value).'</option>';
						}
					}	
					$return_value=$return_value.'</select></div></div>';					
				}
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='checkbox'){	 								
					$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
					$return_value=$return_value.'<div class="col-md-6"><div class="form-group">
					<label class="control-label ">'. esc_html($field_value).'</label>						
					';
					$saved_checkbox_value =	explode(',',get_user_meta($current_user_id,$field_key_pass,true));
					foreach($dropdown_value as $one_value){
						if(trim($one_value)!=''){
							$return_value=$return_value.'
							<div class="form-check form-check-inline">
							<label class="form-check-label" for="'. esc_attr($one_value).'">
							<input '.( in_array($one_value,$saved_checkbox_value)?' checked':'').' class=" form-check-input" type="checkbox" name="'. esc_attr($field_key_pass).'[]"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
							'. esc_html($one_value).' </label>
							</div>';
						}
					}	
					$return_value=$return_value.'</div></div>';						
				}
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='radio'){	 								
					$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
					$return_value=$return_value.'<div class="col-md-6"><div class="form-group ">
					<label class="control-label ">'. esc_html($field_value).'</label>
					';						
					foreach($dropdown_value as $one_value){	 
						if(trim($one_value)!=''){
							$return_value=$return_value.'
							<div class="form-check form-check-inline">
							<label class="form-check-label" for="'. esc_attr($one_value).'">
							<input '.(get_user_meta($current_user_id,$field_key_pass,true)==$one_value?' checked':'').' class="form-check-input" type="radio" name="'. esc_attr($field_key_pass).'"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
							'. esc_html($one_value).'</label>
							</div>														
							';
						}
					}	
					$return_value=$return_value.'</div></div>';					
				}					 
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='textarea'){	 
					$return_value=$return_value.'<div class="col-md-12"><div class="form-group">';
					$return_value=$return_value.'<label class="control-label ">'. esc_html($field_value).'</label>';
					$return_value=$return_value.'<textarea  placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-textarea col-md-12"  rows="4"/>'.esc_textarea(get_user_meta($current_user_id,$field_key_pass,true)).'</textarea></div></div>';
				}
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='datepicker'){	 
					$return_value=$return_value.'<div class="col-md-6"><div class="form-group ">';
					$return_value=$return_value.'<label class="control-label ">'. esc_html($field_value).'</label>';
					$return_value=$return_value.'<input type="text" placeholder="'.esc_html__('Select ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control epinputdate " value="'.esc_attr(get_user_meta($current_user_id,$field_key_pass,true)).'"/></div></div>';
				}
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='text'){ 
					if($field_value=='address'){								
						$return_value=$return_value.'<input type="hidden" class="form-control" name="address" id="address" value="'. esc_attr(get_user_meta($current_user_id,'address',true)).'" >									
						<div class=" form-group col-md-12">
						<label for="text" class=" control-label">'.esc_html__('Address','listfoliopro').'</label>
						<div id="map"></div>
						<div id="search-box"></div>
						<div id="result"></div>
						</div>';
						}else{
						$return_value=$return_value.'<div class="col-md-6"><div class="form-group ">';
						$return_value=$return_value.'<label class="control-label ">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<input type="text" placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_attr(get_user_meta($current_user_id,$field_key_pass,true)).'"/></div></div>';
					}
				}
				if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='url'){	 
					$return_value=$return_value.'<div class="col-md-6"><div class="form-group ">';
					$return_value=$return_value.'<label class="control-label ">'. esc_html($field_value).'</label>';
					$return_value=$return_value.'<input type="text" placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_url(get_user_meta($current_user_id,$field_key_pass,true)).'"/></div></div>';
				}
				return $return_value;
			}
			public function listfoliopro_check_field_input_access_signup($field_key_pass, $field_value){
				$sign_up_array=		get_option( 'listfoliopro_signup_fields');
				$require_array=		get_option( 'listfoliopro_signup_require');
				$field_type=  		get_option( 'listfoliopro_field_type' );
				$field_type_value=  get_option( 'listfoliopro_field_type_value' );
				$field_type_roles=  get_option( 'listfoliopro_field_type_roles' );
				$myaccount_fields_array=  get_option( 'listfoliopro_myaccount_fields' );
				$return_value='';
				$require='no';				
				if(isset($require_array[$field_key_pass]) && $require_array[$field_key_pass] == 'yes') {
					$require='yes';
				}
				if(isset($sign_up_array[$field_key_pass]) && $sign_up_array[$field_key_pass]=='yes'){
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='dropdown'){	 								
						$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8"><select name="'. esc_html($field_key_pass).'" id="'.esc_attr($field_key_pass).'" class="form-dropdown col-md-12" '.($require=='yes'?'data-validation="required" data-validation-error-msg="'. esc_html__('This field cannot be left blank','listfoliopro').'"':'').'>';
						foreach($dropdown_value as $one_value){	 	
							if(trim($one_value)!=''){
								$return_value=$return_value.'<option value="'. esc_attr($one_value).'">'. esc_html($one_value).'</option>';
							}
						}	
						$return_value=$return_value.'</select></div></div>';					
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='checkbox'){	 								
						$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8">
						<div class="" >
						';
						foreach($dropdown_value as $one_value){
							if(trim($one_value)!=''){
								$return_value=$return_value.'
								<div class="form-check form-check-inline col-md-4">
								<input class=" form-check-input" type="checkbox" name="'. esc_attr($field_key_pass).'[]"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'" '.($require=='yes'?'data-validation="required" data-validation-error-msg="'. esc_html__('Required','listfoliopro').'"':'').'>
								<label class="form-check-label" for="'. esc_attr($one_value).'">							
								'. esc_attr($one_value).' </label>
								</div>';
							}
						}	
						$return_value=$return_value.'</div></div></div>';						
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='radio'){	 								
						$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
						$return_value=$return_value.'<div class="form-group row ">
						<label class="control-label col-md-4">'. esc_html($field_value).'</label>
						<div class="col-md-8">
						<div class="" >
						';						
						foreach($dropdown_value as $one_value){	 		
							if(trim($one_value)!=''){
								$return_value=$return_value.'
								<div class="form-check form-check-inline col-md-4">
								<label class="form-check-label" for="'. esc_attr($one_value).'">
								<input class="form-check-input" type="radio" name="'. esc_attr($field_key_pass).'"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'" '.($require=='yes'?'data-validation="required" data-validation-error-msg="'. esc_html__('Required','listfoliopro').'"':'').'>
								'. esc_attr($one_value).'</label>
								</div>';
							}
						}	
						$return_value=$return_value.'</div></div></div>';					
					}					 
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='textarea'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label><div class="col-md-8">';
						$return_value=$return_value.'<textarea  placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-textarea col-md-12"  rows="4"/ '.($require=='yes'?'data-validation="length" data-validation-length="2-100"':'').'></textarea></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='datepicker'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Select ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-date col-md-12 epinputdate " '.($require=='yes'?'data-validation="required" data-validation-error-msg="'. esc_html__('This field cannot be left blank','listfoliopro').'"':'').' /></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='text'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-input col-md-12" '.($require=='yes'?'data-validation="length" data-validation-length="2-100"':'').' /></div></div>';
					}
					if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='url'){	 
						$return_value=$return_value.'<div class="form-group row">';
						$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
						$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','listfoliopro').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-input col-md-12" '.($require=='yes'?'data-validation="length" data-validation-length="2-100"':'').' /></div></div>';
					}
				}
				return $return_value;
			}
			public function listfoliopro_chatgpt_upload_image(){
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;				
				parse_str($_POST['form_data'], $form_data);
				if(isset($form_data['gpt_image'])){
					$url = $form_data['gpt_image'];
					$image_url='';$attachment_id='';	
					$attachment_id = media_sideload_image($url, 0, 'Image description','id');			
					if (!is_wp_error($attachment_id)) {
						$image_url_arr = wp_get_attachment_image_src( $attachment_id, 'full' );
						if(isset($image_url_arr[0])){
							$image_url = $image_url_arr[0];
						}						
					}					
				}			
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro'),"attachment_id"=> $attachment_id,"image_url"=> $image_url ));
				exit(0);
			}
			public function listfoliopro_chatgpt_post_creator(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$title=sanitize_text_field($form_data['gpt_title']);	
				$apiKey =  get_option('listfoliopro_openai_api_key');
				$feature_image_url='';
				$gpt_model=get_option('listfoliopro_gpt_model');
				if($gpt_model==""){$gpt_model='text-davinci-003';}	
				$modelId = $gpt_model; // Change this to the desired GPT-3 model ID
				// Set up the request data fr Content
				$requestData = array(
				'model' => $modelId,
				'prompt' => $title . '\n\n',
				'temperature' => 0.5, 
				'max_tokens' => (int)$form_data['max_tokens'], 
				'n' => 1,
				'stop' => '\n\n'
				);	
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($requestData));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $apiKey,
				));
				$response = curl_exec($ch);
				curl_close($ch);	
				$responseData = json_decode($response, true);
				$content = $responseData['choices'][0]['text'];				  
				// End content
				// Start FAQs
				$requestData = array(
				'model' => $modelId,
				'prompt' => 'Write '.$form_data['gpt_faq_number'].' FAQ for  ' . $title . ' \n\n',
				'temperature' => 0.5, 
				'max_tokens' =>1024, 
				'n' => 1,
				'stop' => '\n\n'
				);						 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/completions');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($requestData));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $apiKey,
				));
				$response = curl_exec($ch);
				curl_close($ch); 
				$responseData = json_decode($response, true);
				$faqs = $responseData['choices'][0]['text'];
				// End 	
				if(isset($form_data['listfoliopro_feature_image_chatgpt'])){
					// Feature_image_size image				
					$url = 'https://api.openai.com/v1/images/generations';
					$data = [
					'model' => 'image-alpha-001',
					'prompt' => $title,
					'num_images' => 4,
					'size' => '512x512',
					'response_format' => 'url'
					];
					$curl = curl_init();
					curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => wp_json_encode($data),
					CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer ' . $apiKey,
					'Content-Type: application/json'
					),
					));
					$response = curl_exec($curl);
					if (curl_error($curl)) {					 
						} else {
						$response_all= json_decode($response, true);
						if(isset($response_all['data'][0]['url'])){
							$image_url = $response_all['data'][0]['url'];
						}
						if(isset($response_all['data'][1]['url'])){
							$image_url = $image_url .'|'.$response_all['data'][1]['url'];	
						}
						if(isset($response_all['data'][2]['url'])){
							$image_url = $image_url .'|'.$response_all['data'][2]['url'];	
						}
						if(isset($response_all['data'][3]['url'])){
							$image_url = $image_url .'|'.$response_all['data'][3]['url'];	
						}	
						$feature_image_url =$image_url;
					}
					curl_close($curl);
					}else{
					$feature_image_url='off';
				}	
				// End Feature_image		  
				//FAQ maker		
				$qa_pairs_ep = explode("\n\n", $faqs);
				$qa_pairs_noempty = array_filter($qa_pairs_ep, function($value) { return !empty($value); });
				$i=0;	$faq_html='';					
				foreach ($qa_pairs_noempty as $qa_pair) {
					if(!empty($qa_pair)){
						$qa_pair_q_n_a = explode("\n", $qa_pair);
						if(isset($qa_pair_q_n_a[0]) AND isset($qa_pair_q_n_a[1])){							
							$faq_html=$faq_html.'<div class="row border-bottom mb-4" id="faq_delete_'.esc_html($i).'"> <div class="col-md-5 form-group"> <input type="text" class="form-control" name="faq_title[]" id="faq_title[]" value="'.esc_html($qa_pair_q_n_a[0]).'" placeholder="FAQ"></div><div class="col-md-6 form-group"><textarea rows="2"  name="faq_description[]" id="faq_description[]" placeholder="Answer">'.$qa_pair_q_n_a[1].'</textarea></div><div class="col-md-1 form-group pull-right"><button type="button" onclick="listfoliopro_faq_delete('. esc_html($i).');"  class="btn btn-small-ar"><span class="dashicons dashicons-trash"></span></button></div><div class="row"><hr></div></div><div class="clearfix"></div>';
						}
						$i++;
					}						
				}					
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro'),"content"=> $content,"faqs"=> $faq_html,'feature_image_url'=>$feature_image_url));
				exit(0);
			}
			public function listfoliopro_save_user_review(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				$post_type = 'listfoliopro_review';
				$args = array(
				'post_type' => $post_type, 
				'author' => sanitize_text_field($form_data['listingid']),
				);
				$the_query_review = new WP_Query( $args );
				$deleteid ='';
				if ( $the_query_review->have_posts() ) :
				while ( $the_query_review->have_posts() ) : $the_query_review->the_post();
				$deleteid = get_the_ID();
				if(get_post_meta($deleteid,'review_submitter',true)==$current_user->ID){
					wp_delete_post($deleteid );
				}
				endwhile;
				endif;
				$my_post= array();
				$my_post['post_author'] = sanitize_text_field($form_data['listingid']);
				$my_post['post_title'] = sanitize_text_field($form_data['review_subject']);
				$my_post['post_content'] = sanitize_textarea_field($form_data['review_comment']);
				$my_post['post_status'] = 'publish';
				$my_post['post_type'] = $post_type;
				$newpost_id= wp_insert_post( $my_post );
				$review_value=1;
				if(isset($form_data['star']) ){$review_value=sanitize_text_field($form_data['star']);}
				update_post_meta($newpost_id, 'review_submitter', $current_user->ID);
				update_post_meta($newpost_id, 'review_value', $review_value);	
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function user_profile_image_upload($userid){
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				$iv_membership_signup_profile_pic=get_option('listfoliopro_signup_profile_pic');
				if($iv_membership_signup_profile_pic=='' ){ $iv_membership_signup_profile_pic='yes';}	
				if($iv_membership_signup_profile_pic=='yes' ){ 
					if ( 0 < $_FILES['profilepicture']['error'] ) { 
					}
					else {  
						$new_file_type = mime_content_type( $_FILES['profilepicture']['tmp_name'] );	
						if( in_array( $new_file_type, get_allowed_mime_types() ) ){   
							$upload_dir   = wp_upload_dir();
							$date = gmdate('YmdHis');		
							$upload_overrides = array('test_form' => false);
							$file_name = $date.$_FILES['profilepicture']['name'];	
							$file = $_FILES['profilepicture'];
							$return=  wp_handle_upload($file, $upload_overrides);
							if ($return && !isset($return['error'])) {
								$image_url= $return['url'];
								update_user_meta($userid, 'listfoliopro_profile_pic_thum',sanitize_url($image_url));
							}
						}
					}
				}
			}
			public function listfoliopro_update_wp_post(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					wp_die( 'Are you cheating:user Permission?' );								
				}
				global $current_user;global $wpdb;	
				$allowed_html = wp_kses_allowed_html( 'post' );	
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				parse_str($_POST['form_data'], $form_data);
				$newpost_id= sanitize_text_field($form_data['user_post_id']);
				$my_post = array();
				$my_post['ID'] = $newpost_id;
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] =  wp_kses( $form_data['new_post_content'], $allowed_html);
				$my_post['post_type'] 	= $listfoliopro_directory_url;
				$listfoliopro_user_can_publish=get_option('listfoliopro_user_can_publish');
				if($listfoliopro_user_can_publish==""){$listfoliopro_user_can_publish='yes';}
				$my_post['post_status']=$form_data['post_status'];
				if($form_data['post_status']=='publish'){					
					$my_post['post_status']='pending';
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$my_post['post_status']='publish';
						}else{ 
						if($listfoliopro_user_can_publish=="yes"){
							$my_post['post_status']='publish';
							}else{
							$my_post['post_status']='pending';
						}								
					}						
				}
				wp_update_post( $my_post );
				if(isset($form_data['feature_image_id'] ) AND $form_data['feature_image_id']!='' ){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( sanitize_text_field($form_data['user_post_id']), $attach_id );
					}else{
					$attach_id='0';
					delete_post_thumbnail( sanitize_text_field($form_data['user_post_id']));
				}
				if(isset($form_data['postcats'] )){ 
					$category_ids = $form_data['postcats'];
					$input_array_data= sanitize_text_field($category_ids) ;
					if(is_array($category_ids)){
						$input_array_data= array();
						foreach($category_ids as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-category');
				}
				if(isset($form_data['new_category'] )){						
					$tag_new= explode(",", $form_data['new_category']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-category');
					}
				}	
				// Location
				if(isset($form_data['location_arr'] )){ 
					$location_arr = $form_data['location_arr'];
					$input_array_data= sanitize_text_field($location_arr) ;
					if(is_array($location_arr)){
						$input_array_data= array();
						foreach($location_arr as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-locations');
				}
				if(isset($form_data['new_location'] )){						
					$tag_new= explode(",", $form_data['new_location']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-locations');
					}
				}	
				// Check Feature*************	
				$post_author_id= $current_user->ID;
				$author_package_id=get_user_meta($post_author_id, 'listfoliopro_package_id', true);
				$have_package_feature= get_post_meta($author_package_id,'listfoliopro_package_feature',true);
				$exprie_date= strtotime (get_user_meta($post_author_id, 'listfoliopro_exprie_date', true));
				$current_date=time();						
				if($have_package_feature=='yes'){
					if($exprie_date >= $current_date){ 
						update_post_meta($newpost_id, 'listfoliopro_featured', 'featured' );
					}	
					}else{
					update_post_meta($newpost_id, 'listfoliopro_featured', 'no' );
				}
				// listing detail *****	
				// For Tag Save tag_arr			
				$tag_all='';
				if(isset($form_data['tag_arr'] )){
					$tag_name= $form_data['tag_arr'] ;	
					$input_array_data= sanitize_text_field($tag_name) ;
					if(is_array($tag_name)){
						$input_array_data= array();
						foreach($tag_name as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					$i=0;$tag_all='';						
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-tag');
				}
				$tag_all='';
				if(isset($form_data['new_tag'] )){						
					$tag_new= explode(",", $form_data['new_tag']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-tag');
						$i++;	
					}
				}	
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude']));  
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));					
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city'])); 
				update_post_meta($newpost_id, 'state', sanitize_text_field($form_data['state'])); 
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode'])); 
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country'])); 
				update_post_meta($newpost_id, 'local-area', sanitize_text_field($form_data['local-area'])); 
				$opening_day=array();
				if(isset($form_data['day_name'] )){
					$day_name= $form_data['day_name'] ;
					$day_value1 = $form_data['day_value1'];
					$day_value2 = $form_data['day_value2'] ;
					$i=0;
					foreach($day_name  as $one_meta){
						if(isset($day_name[$i]) and isset($day_value1[$i]) ){
							if($day_name[$i] !=''){
								$opening_day[sanitize_text_field($day_name[$i])]= array(sanitize_text_field($day_value1[$i])=>sanitize_text_field($day_value2[$i])) ;
							}
						}
						$i++;
					}
					update_post_meta($newpost_id, '_opening_time', $opening_day);
				}
				// For FAQ Save
				// Delete 1st
				$i=0;
				for($i=0;$i<20;$i++){
					delete_post_meta($newpost_id, 'faq_title'.$i);							
					delete_post_meta($newpost_id, 'faq_description'.$i);
				}
				// Delete End
				if(isset($form_data['faq_title'] )){
					$faq_title= $form_data['faq_title']; //this is array data we sanitize later, when it save				
					$faq_description= $form_data['faq_description'];
					$i=0;
					for($i=0;$i<20;$i++){
						if(isset($faq_title[$i]) AND $faq_title[$i]!=''){
							update_post_meta($newpost_id, 'faq_title'.$i, sanitize_text_field($faq_title[$i]));
							update_post_meta($newpost_id, 'faq_description'.$i, sanitize_textarea_field($faq_description[$i]));
						}
					}
				}
				// End FAQ
				$default_fields = array();
				$field_set=get_option('listfoliopro_li_fields' );
				
				if($field_set==""){
					$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
					$default_fields = $default_fields_two_arr[0];	
				}else{
					$default_fields=$field_set;
				}
				
				if(is_array($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						update_post_meta($newpost_id, $field_key, $form_data[$field_key] );							
					}					
				}
				// listing detail*****		
				if(isset($form_data['dirpro_email_button'])){						
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button'])); 
				}
				if(isset($form_data['dirpro_web_button'])){						
					update_post_meta($newpost_id, 'dirpro_web_button', sanitize_text_field($form_data['dirpro_web_button'])); 
				}
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids'])); 
				update_post_meta($newpost_id, 'attached_ids', sanitize_text_field($form_data['attached_ids']));
				update_post_meta($newpost_id, 'topbanner', sanitize_text_field($form_data['topbanner_image_id'])); 
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}	
				update_post_meta($newpost_id, 'price_prefix_text', sanitize_text_field($form_data['price_prefix_text']));
				update_post_meta($newpost_id, 'price', sanitize_text_field($form_data['price']));
				update_post_meta($newpost_id, 'discount', sanitize_text_field($form_data['discount']));
				update_post_meta($newpost_id, 'whatsapp', sanitize_text_field($form_data['whatsapp']));
				update_post_meta($newpost_id, 'viber', sanitize_text_field($form_data['viber']));
				update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));  
				update_post_meta($newpost_id, 'company_name', sanitize_text_field($form_data['company_name']));
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone'])); 
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email'])); 
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));				
				update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo'])); 
				update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube'])); 
				update_post_meta($newpost_id, '360_image', sanitize_url($form_data['360_image']));
				update_post_meta($newpost_id, 'facebook', sanitize_url($form_data['facebook']));
				update_post_meta($newpost_id, 'linkedin', sanitize_url($form_data['linkedin']));
				update_post_meta($newpost_id, 'instagram', sanitize_url($form_data['instagram']));
				update_post_meta($newpost_id, 'twitter', sanitize_url($form_data['twitter']));
				//Public Facilities
				$facilities=array();
				if(isset($form_data['facilities_name'] )){
					$facilities_name= $form_data['facilities_name'] ;
					$facilities_value = $form_data['facilities_value'] ;
					$i=0;
					foreach($facilities_name  as $one_facility){
						if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
							if($facilities_name[$i] !=''){
								$facilities[$facilities_name[$i]] = sanitize_text_field($facilities_value[$i]);
							}
						}							
						$i++;	
					}
					update_post_meta($newpost_id, 'public_facilities', $facilities); 	
				}
				delete_post_meta($newpost_id, 'listfoliopro-tags');
				delete_post_meta($newpost_id, 'listfoliopro-category');
				delete_post_meta($newpost_id, 'listfoliopro-locations');
				if($form_data['post_status']=='publish'){ 
					include( listfoliopro_ep_ABSPATH. 'inc/add-listing-notification.php');
					include( listfoliopro_ep_ABSPATH. 'inc/notification.php');
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);				
			}
			public function listfoliopro_save_wp_post(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'edit_posts' ) ) {
					wp_die( 'Are you cheating:user edit_posts Permission?' );
				}
				$allowed_html = wp_kses_allowed_html( 'post' );	
				global $current_user; global $wpdb;	
				parse_str($_POST['form_data'], $form_data);				
				$my_post = array();
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$post_type = $listfoliopro_directory_url;
				$listfoliopro_user_can_publish=get_option('listfoliopro_user_can_publish');
				if($listfoliopro_user_can_publish==""){$listfoliopro_user_can_publish='yes';}
				if($form_data['post_status']=='publish'){					
					$form_data['post_status']='pending';
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						$form_data['post_status']='publish';
						}else{
						if($listfoliopro_user_can_publish=="yes"){
							$form_data['post_status']='publish';
							}else{
							$form_data['post_status']='pending';
						}								
					}						
				}
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] = wp_kses( $form_data['new_post_content'], $allowed_html); 
				$my_post['post_type'] = $post_type;
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);										
				$newpost_id= wp_insert_post( $my_post );
				update_post_meta($newpost_id, 'listfoliopro_listing_status', sanitize_text_field($form_data['listing_type']));
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1",$post_type,$newpost_id );
					$wpdb->query($query);					
				}
				// End WPML**********	
				if(isset($form_data['postcats'] )){ 				
					$category_ids = $form_data['postcats'];
					$input_array_data= sanitize_text_field($category_ids) ;
					if(is_array($category_ids)){
						$input_array_data= array();
						foreach($category_ids as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-category');
				}
				if(isset($form_data['new_category'] )){						
					$tag_new= explode(",", $form_data['new_category']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-category');
					}
				}	
				$opening_day=array();
				if(isset($form_data['day_name'] )){
					$day_name= $form_data['day_name'] ;
					$day_value1 = $form_data['day_value1'];
					$day_value2 = $form_data['day_value2'] ;
					$i=0;
					foreach($day_name  as $one_meta){
						if(isset($day_name[$i]) and isset($day_value1[$i]) ){
							if($day_name[$i] !=''){
								$opening_day[sanitize_text_field($day_name[$i])]= array(sanitize_text_field($day_value1[$i])=>sanitize_text_field($day_value2[$i])) ;
							}
						}
						$i++;
					}
					update_post_meta($newpost_id, '_opening_time', $opening_day);
				}
				// For FAQ Save				
				if(isset($form_data['faq_title'] )){
					$faq_title= $form_data['faq_title']; //this is array data we sanitize later, when it save				
					$faq_description= $form_data['faq_description'];
					$i=0;
					for($i=0;$i<20;$i++){
						if(isset($faq_title[$i]) AND $faq_title[$i]!=''){
							update_post_meta($newpost_id, 'faq_title'.$i, sanitize_text_field($faq_title[$i]));
							update_post_meta($newpost_id, 'faq_description'.$i, sanitize_textarea_field($faq_description[$i]));
						}
					}
				}
				// End FAQ
				// Location
				if(isset($form_data['location_arr'] )){ 
					$location_arr = $form_data['location_arr'];
					$input_array_data= sanitize_text_field($location_arr) ;
					if(is_array($location_arr)){
						$input_array_data= array();
						foreach($location_arr as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-locations');
				}
				if(isset($form_data['new_location'] )){						
					$tag_new= explode(",", $form_data['new_location']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-locations');
					}
				}	
				$default_fields = array();
				$field_set=get_option('listfoliopro_li_fields' );
				
				if($field_set==""){
					$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
					$default_fields = $default_fields_two_arr[0];	
				}else{
					$default_fields=$field_set;
				}
							
				if(is_array($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) { 
						update_post_meta($newpost_id, $field_key, $form_data[$field_key] );							
					}					
				}
				// Check Feature*************	
				$post_author_id= $current_user->ID;
				$author_package_id=get_user_meta($post_author_id, 'listfoliopro_package_id', true);
				$have_package_feature= get_post_meta($author_package_id,'listfoliopro_package_feature',true);
				$exprie_date= strtotime (get_user_meta($post_author_id, 'listfoliopro_exprie_date', true));
				$current_date=time();						
				if($have_package_feature=='yes'){
					if($exprie_date >= $current_date){
						update_post_meta($newpost_id, 'listfoliopro_featured', 'featured' );
					}	
					}else{
					update_post_meta($newpost_id, 'listfoliopro_featured', 'no' );
				}
				// For Tag Save tag_arr
				$tag_all='';
				if(isset($form_data['tag_arr'] )){
					$tag_name= $form_data['tag_arr'] ;	
					$input_array_data= sanitize_text_field($tag_name) ;
					if(is_array($tag_name)){
						$input_array_data= array();
						foreach($tag_name as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					$i=0;$tag_all='';						
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-tag');
				}
				$tag_all='';
				if(isset($form_data['new_tag'] )){						
					$tag_new= explode(",", $form_data['new_tag']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-tag');
						$i++;	
					}
				}	
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude'])); 
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));					
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city'])); 
				update_post_meta($newpost_id, 'state', sanitize_text_field($form_data['state'])); 
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode'])); 
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country'])); 
				update_post_meta($newpost_id, 'local-area', sanitize_text_field($form_data['local-area'])); 
				// listing detail*****
				if(isset($form_data['dirpro_email_button'])){						
					update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($form_data['dirpro_email_button'])); 
				}
				if(isset($form_data['dirpro_web_button'])){						
					update_post_meta($newpost_id, 'dirpro_web_button', sanitize_text_field($form_data['dirpro_web_button'])); 
				}
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids']));
				update_post_meta($newpost_id, 'attached_ids', sanitize_text_field($form_data['attached_ids']));
				update_post_meta($newpost_id, 'topbanner', sanitize_text_field($form_data['topbanner_image_id'])); 
				update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));  
				update_post_meta($newpost_id, 'external_form_url', sanitize_url($form_data['external_form_url']));  
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}
				update_post_meta($newpost_id, 'price_prefix_text', sanitize_text_field($form_data['price_prefix_text']));
				update_post_meta($newpost_id, 'price', sanitize_text_field($form_data['price']));
				update_post_meta($newpost_id, 'discount', sanitize_text_field($form_data['discount']));
				update_post_meta($newpost_id, 'whatsapp', sanitize_text_field($form_data['whatsapp']));
				update_post_meta($newpost_id, 'viber', sanitize_text_field($form_data['viber']));
				update_post_meta($newpost_id, 'company_name', sanitize_text_field($form_data['company_name']));
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone'])); 
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email'])); 
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));
				update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo'])); 
				update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube']));
				update_post_meta($newpost_id, '360_image', sanitize_url($form_data['360_image']));
				update_post_meta($newpost_id, 'facebook', sanitize_url($form_data['facebook']));
				update_post_meta($newpost_id, 'linkedin', sanitize_url($form_data['linkedin']));
				update_post_meta($newpost_id, 'instagram', sanitize_url($form_data['instagram']));
				update_post_meta($newpost_id, 'twitter', sanitize_url($form_data['twitter']));
				//Public Facilities
				$facilities=array();
				if(isset($form_data['facilities_name'] )){
					$facilities_name= $form_data['facilities_name'] ;
					$facilities_value = $form_data['facilities_value'] ;
					$i=0;
					foreach($facilities_name  as $one_facility){
						if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
							if($facilities_name[$i] !=''){
								$facilities[$facilities_name[$i]] = sanitize_text_field($facilities_value[$i]);
							}
						}							
						$i++;	
					}
					update_post_meta($newpost_id, 'public_facilities', $facilities); 	
				}
				include( listfoliopro_ep_ABSPATH. 'inc/add-listing-notification.php');
				if($form_data['post_status']=='publish'){ 
					include( listfoliopro_ep_ABSPATH. 'inc/notification.php');
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			// add listing listfoliopro_save_post_without_user
			public function listfoliopro_save_post_without_user(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				$allowed_html = wp_kses_allowed_html( 'post' );	
				global $current_user; global $wpdb;	
				parse_str($_POST['form_data'], $form_data);		
				if($form_data['user_id']=='0'){ 					// create new user 
					if($form_data['n_user_email']!='' and $form_data['n_password']!='' ){ 
						$userdata = array();
						$userdata['user_email']=sanitize_email($form_data['n_user_email']);
						$userdata['user_login']='';
						$userdata['user_pass']=sanitize_text_field($form_data['n_password']);
						if ( email_exists($userdata['user_email']) == false ) {						
							$user_id = wp_create_user($userdata['user_email'],$userdata['user_pass'],$userdata['user_email']); 
							wp_clear_auth_cookie();
							wp_set_current_user ( $user_id);
							wp_set_auth_cookie  ( $user_id );
							include( listfoliopro_ep_ABSPATH. 'inc/signup-mail.php');
							}else{
							echo wp_json_encode(array("code" => "error","msg"=>esc_html__( 'Email already exists ', 'listfoliopro')));
							exit(0);
						}
					}	
				}
				$my_post = array();
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$post_type = $listfoliopro_directory_url;
				$listfoliopro_user_can_publish=get_option('listfoliopro_user_can_publish');
				if($listfoliopro_user_can_publish==""){$listfoliopro_user_can_publish='yes';}
				$form_data['post_status']='pending';
				if($form_data['post_status']=='publish'){	
					if($listfoliopro_user_can_publish=="yes"){
						$form_data['post_status']='publish';
						}else{
						$form_data['post_status']='pending';
					}								
				}
				$my_post['post_title'] = sanitize_text_field($form_data['title']);
				$my_post['post_content'] = wp_kses( $form_data['new_post_content'], $allowed_html); 
				$my_post['post_type'] = $post_type;
				$my_post['post_status'] = sanitize_text_field($form_data['post_status']);										
				$newpost_id= wp_insert_post( $my_post );
				update_post_meta($newpost_id, 'listfoliopro_listing_status', sanitize_text_field($form_data['listing_type']));
				// WPML Start******
				if ( function_exists('icl_object_id') ) {
					include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
					$_POST['icl_post_language'] = $language_code = ICL_LANGUAGE_CODE;
					$query =$wpdb->prepare( "UPDATE {$wpdb->prefix}icl_translations SET element_type='post_%s' WHERE element_id='%s' LIMIT 1",$post_type,$newpost_id );
					$wpdb->query($query);					
				}
				// End WPML**********	
				if(isset($form_data['postcats'] )){ 				
					$category_ids = $form_data['postcats'];
					$input_array_data= sanitize_text_field($category_ids) ;
					if(is_array($category_ids)){
						$input_array_data= array();
						foreach($category_ids as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-category');
				}
				if(isset($form_data['new_category'] )){						
					$tag_new= explode(",", $form_data['new_category']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-category');
					}
				}	
				// For FAQ Save				
				if(isset($form_data['faq_title'] )){
					$faq_title= $form_data['faq_title']; //this is array data we sanitize later, when it save				
					$faq_description= $form_data['faq_description'];
					$i=0;
					for($i=0;$i<20;$i++){
						if(isset($faq_title[$i]) AND $faq_title[$i]!=''){
							update_post_meta($newpost_id, 'faq_title'.$i, sanitize_text_field($faq_title[$i]));
							update_post_meta($newpost_id, 'faq_description'.$i, sanitize_textarea_field($faq_description[$i]));
						}
					}
				}
				// End FAQ
				// Location
				if(isset($form_data['location_arr'] )){ 
					$location_arr = $form_data['location_arr'];
					$input_array_data= sanitize_text_field($location_arr) ;
					if(is_array($location_arr)){
						$input_array_data= array();
						foreach($location_arr as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-locations');
				}
				if(isset($form_data['new_location'] )){						
					$tag_new= explode(",", $form_data['new_location']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-locations');
					}
				}	
				$default_fields = array();
				$field_set=get_option('listfoliopro_li_fields' );
				if($field_set!=""){ 
					$default_fields=get_option('listfoliopro_li_fields' );
					}else{	
					$default_fields['listing_hours']='listing Hours';
					$default_fields['number_of_cleaner']='Number Of Cleaner';	
				}					
				if(sizeof($default_fields )){			
					foreach( $default_fields as $field_key => $field_value ) {
						if(isset($form_data[$field_key])){
							update_post_meta($newpost_id, $field_key, $form_data[$field_key] );				
						}
					}					
				}
				$post_author_id= $current_user->ID;
				update_post_meta($newpost_id, 'listing_education', wp_kses( $form_data['content_education'], $allowed_html));	
				update_post_meta($newpost_id, 'listing_must_have', wp_kses( $form_data['content_must_have'], $allowed_html));
				// For Tag Save tag_arr
				$tag_all='';
				if(isset($form_data['tag_arr'] )){
					$tag_name= $form_data['tag_arr'] ;							
					$i=0;$tag_all='';	
					$input_array_data= sanitize_text_field($tag_name) ;
					if(is_array($tag_name)){
						$input_array_data= array();
						foreach($tag_name as $one_input_field){
							$input_array_data[]=sanitize_text_field($one_input_field);
						}					
					}
					wp_set_object_terms( $newpost_id, $input_array_data, $listfoliopro_directory_url.'-tag');
				}
				$tag_all='';
				if(isset($form_data['new_tag'] )){						
					$tag_new= explode(",", $form_data['new_tag']); 			
					foreach($tag_new  as $one_tag){	
						wp_add_object_terms( $newpost_id, sanitize_text_field($one_tag), $listfoliopro_directory_url.'-tag');
						$i++;	
					}
				}	
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'latitude', sanitize_text_field($form_data['latitude'])); 
				update_post_meta($newpost_id, 'longitude', sanitize_text_field($form_data['longitude']));					
				update_post_meta($newpost_id, 'city', sanitize_text_field($form_data['city'])); 
				update_post_meta($newpost_id, 'state', sanitize_text_field($form_data['state'])); 
				update_post_meta($newpost_id, 'postcode', sanitize_text_field($form_data['postcode'])); 
				update_post_meta($newpost_id, 'country', sanitize_text_field($form_data['country'])); 
				// listing detail*****
				update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($form_data['gallery_image_ids'])); 
				update_post_meta($newpost_id, 'attached_ids', sanitize_text_field($form_data['attached_ids']));				
				update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($form_data['contact_source']));  
				update_post_meta($newpost_id, 'external_form_url', sanitize_url($form_data['external_form_url']));  
				if(isset($form_data['feature_image_id'] )){
					$attach_id =sanitize_text_field($form_data['feature_image_id']);
					set_post_thumbnail( $newpost_id, $attach_id );					
				}	
				update_post_meta($newpost_id, 'price_prefix_text', sanitize_text_field($form_data['price_prefix_text']));
				update_post_meta($newpost_id, 'price', sanitize_text_field($form_data['price']));
				update_post_meta($newpost_id, 'discount', sanitize_text_field($form_data['discount']));
				update_post_meta($newpost_id, 'whatsapp', sanitize_text_field($form_data['whatsapp']));
				update_post_meta($newpost_id, 'viber', sanitize_text_field($form_data['viber']));
				update_post_meta($newpost_id, 'company_name', sanitize_text_field($form_data['company_name']));
				update_post_meta($newpost_id, 'phone', sanitize_text_field($form_data['phone'])); 
				update_post_meta($newpost_id, 'address', sanitize_text_field($form_data['address'])); 
				update_post_meta($newpost_id, 'contact-email', sanitize_text_field($form_data['contact-email'])); 
				update_post_meta($newpost_id, 'contact_web', sanitize_text_field($form_data['contact_web']));
				update_post_meta($newpost_id, 'vimeo', sanitize_text_field($form_data['vimeo'])); 
				update_post_meta($newpost_id, 'youtube', sanitize_text_field($form_data['youtube'])); 
				//Public Facilities
				$facilities=array();
				if(isset($form_data['facilities_name'] )){
					$facilities_name= $form_data['facilities_name'] ;
					$facilities_value = $form_data['facilities_value'] ;
					$i=0;
					foreach($facilities_name  as $one_facility){
						if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
							if($facilities_name[$i] !=''){
								$facilities[$facilities_name[$i]] = sanitize_text_field($facilities_value[$i]);
							}
						}							
						$i++;	
					}
					update_post_meta($newpost_id, 'public_facilities', $facilities); 	
				}
				include( listfoliopro_ep_ABSPATH. 'inc/add-listing-notification.php');
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function eppro_upload_featured_image($thumb_url, $post_id ) { 
				require_once(ABSPATH . 'wp-admin/includes/file.php');
				require_once(ABSPATH . 'wp-admin/includes/media.php');
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				// Download file to temp location
				$i=0;$product_image_gallery='';									
				$tmp = download_url( $thumb_url );						
				// Set variables for storage
				// fix file name for query strings
				preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG|webp|WEBP)/', $thumb_url, $matches);
				$file_array['name'] = basename($matches[0]);
				$file_array['tmp_name'] = $tmp;
				// If error storing temporarily, unlink
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';						
				}
				//use media_handle_sideload to upload img:
				$thumbid = media_handle_sideload( $file_array, $post_id, 'gallery desc' );
				// If error storing permanently, unlink
				if ( is_wp_error($thumbid) ) {
					@unlink($file_array['tmp_name']);										
				}						
				set_post_thumbnail($post_id, $thumbid);	
			}
			public function listfoliopro_finalerp_csv_product_upload(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				$csv_file_id=0;$maping='';
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= sanitize_text_field($_POST['csv_file_id']);
				}
				require(listfoliopro_ep_DIR .'/admin/pages/importer/upload_main_big_csv.php');
				$total_files = get_option( 'finalerp-number-of-files');
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro'), "maping"=>$maping));
				exit(0);
			}
			public function listfoliopro_save_csv_file_to_database(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'csv' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Are you cheating:user Permission?' );
				}
				parse_str($_POST['form_data'], $form_data);
				$csv_file_id=0;
				if(isset($_POST['csv_file_id'])){
					$csv_file_id= sanitize_text_field($_POST['csv_file_id']);
				}	
				$row_start=0;
				if(isset($_POST['row_start'])){
					$row_start= sanitize_text_field($_POST['row_start']);
				}
				require (listfoliopro_ep_DIR .'/admin/pages/importer/csv_save_database.php');
				echo wp_json_encode(array("code" => $done_status,"msg"=>esc_html__( 'Updated Successfully', 'listfoliopro'), "row_done"=>$row_done ));
				exit(0);
			}
			public function listfoliopro_eppro_get_import_status(){
				$listfoliopro_total_row = floatval( get_option( 'listfoliopro_total_row' ));
				$listfoliopro_current_row = floatval( get_option( 'listfoliopro_current_row' ));
				$progress =  ((int)$listfoliopro_current_row / (int)$listfoliopro_total_row)*100;
				if($listfoliopro_total_row<=$listfoliopro_current_row){$progress='100';}
				if($progress=='100'){
					echo wp_json_encode(array("code" => "-1","progress"=>(int)$progress, "listfoliopro_total_row"=>$listfoliopro_total_row,"listfoliopro_current_row"=>$listfoliopro_current_row));
					}else{
					echo wp_json_encode(array("code" => "0","progress"=>(int)$progress, "listfoliopro_total_row"=>$listfoliopro_total_row ,"listfoliopro_current_row"=>$listfoliopro_current_row));
				}		  
				exit(0);
			}
			public function ep_listfoliopro_pdf_cv(){
				require( listfoliopro_ep_DIR . '/template/pdf/pdf_post.php');
			}
			public function listfoliopro_elementor_file(  ) {
				//Register Custom Elementor Widget					
				if(defined( 'ELEMENTOR_PATH' )){						
					require_once(listfoliopro_ep_template . 'elementor/custom-elementor-widgets.php' );
				}				
			}
			public function listfoliopro_cancel_paypal(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);
				if( ! class_exists('Paypal' ) ) {
					require_once(listfoliopro_ep_DIR . '/inc/class-paypal.php');
				}
				$post_name='listfoliopro_paypal_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name));
				$paypal_id='0';
				if(isset($row->ID )){
					$paypal_id= $row->ID;
				}
				$paypal_api_currency=get_post_meta($paypal_id, 'listfoliopro_paypal_api_currency', true);
				$paypal_username=get_post_meta($paypal_id, 'listfoliopro_paypal_username',true);
				$paypal_api_password=get_post_meta($paypal_id, 'listfoliopro_paypal_api_password', true);
				$paypal_api_signature=get_post_meta($paypal_id, 'listfoliopro_paypal_api_signature', true);
				$credentials = array();
				$credentials['USER'] = (isset($paypal_username)) ? $paypal_username : '';
				$credentials['PWD'] = (isset($paypal_api_password)) ? $paypal_api_password : '';
				$credentials['SIGNATURE'] = (isset($paypal_api_signature)) ? $paypal_api_signature : '';
				$paypal_mode=get_post_meta($paypal_id, 'listfoliopro_paypal_mode', true);
				$currencyCode = $paypal_api_currency;
				$sandbox = ($paypal_mode == 'live') ? '' : 'sandbox.';
				$sandboxBool = (!empty($sandbox)) ? true : false;
				$paypal = new Paypal($credentials,$sandboxBool);
				$oldProfile = get_user_meta($current_user->ID,'iv_paypal_recurring_profile_id',true);
				if (!empty($oldProfile)) {
					$cancelParams = array(
					'PROFILEID' => $oldProfile,
					'ACTION' => 'Cancel'
					);
					$paypal -> request('ManageRecurringPaymentsProfileStatus',$cancelParams);
					update_user_meta($current_user->ID,'iv_paypal_recurring_profile_id','');
					update_user_meta($current_user->ID,'listfoliopro_iv_cancel_reason', sanitize_text_field($form_data['cancel_text']));
					update_user_meta($current_user->ID,'listfoliopro_payment_status', 'cancel');
					echo wp_json_encode(array("code" => "success","msg"=>"Cancel Successfully"));
					exit(0);							
					}else{
					echo wp_json_encode(array("code" => "not","msg"=>esc_html__( 'Unable to Cancel', 'listfoliopro')));
					exit(0);	
				}
			}
			public function listfoliopro_woocommerce_form_submit(  ) {
				$iv_gateway = get_option('listfoliopro_payment_gateway');
				if($iv_gateway=='woocommerce'){ 
					require_once(listfoliopro_ep_ABSPATH . '/admin/pages/payment-inc/woo-submit.php');
				}	
			}
			public function  listfoliopro_profile_stripe_upgrade(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				require_once(listfoliopro_ep_DIR . '/admin/init.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$newpost_id='';
				$post_name='listfoliopro_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'listfoliopro_stripe_mode',true);
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'listfoliopro_stripe_secret_test',true);
					}else{
					$stripe_api =get_post_meta($newpost_id, 'listfoliopro_stripe_live_secret_key',true);
				}
				\Stripe\Stripe::setApiKey($stripe_api);				
				// For  cancel ----
				$arb_status =	get_user_meta($current_user->ID, 'listfoliopro_payment_status', true);
				$cust_id = get_user_meta($current_user->ID,'listfoliopro_stripe_cust_id',true);
				$sub_id = get_user_meta($current_user->ID,'listfoliopro_stripe_subscrip_id',true);
				if($sub_id!=''){	
					try{
						$iv_cancel_stripe = Stripe_Customer::retrieve(sanitize_text_field($form_data['cust_id']));
						$iv_cancel_stripe->subscriptions->retrieve(sanitize_text_field($form_data['sub_id']))->cancel();
						} catch (Exception $e) {
					}
					update_user_meta($current_user->ID,'listfoliopro_payment_status', 'cancel');
					update_user_meta($current_user->ID,'listfoliopro_stripe_subscrip_id','');
				}			
				require_once(listfoliopro_ep_DIR . '/admin/pages/payment-inc/stripe-upgrade.php');
				echo wp_json_encode(array("code" => "success","msg"=>$response));
				exit(0);
			}
			public function listfoliopro_contact_popup(){
				include( listfoliopro_ep_template. 'private-profile/contact_popup.php');
				exit(0);
			}
			public function listfoliopro_listing_contact_popup(){
				include( listfoliopro_ep_template. 'listing/contact_popup.php');
				exit(0);
			}
			public function listfoliopro_chatgtp_settings_popup(){
				include( listfoliopro_ep_template. 'private-profile/chatgtp_settings_popup.php');
				exit(0);
			}
			public function listfoliopro_listing_booking_popup(){
				include( listfoliopro_ep_template. 'listing/booking_popup.php');
				exit(0);
			}
			public function listfoliopro_get_categories_caching($id, $post_type){
				if(metadata_exists('post', $id, 'listfoliopro-category')) {
					$items = get_post_meta($id,'listfoliopro-category',true );
				}else{									
					$items=wp_get_object_terms( $id, $post_type.'-category');
					update_post_meta($id, 'listfoliopro-category' , $items);
				}	
				$items=wp_get_object_terms( $id, $post_type.'-category');
				return $items;
			}
			public function listfoliopro_get_categories_mapmarker($id, $post_type){
				$default_marker =listfoliopro_ep_URLPATH."/admin/files/css/images/marker-icon.png";
				if(metadata_exists('post', $id, 'listfoliopro-category')) {
					$items = get_post_meta($id,'listfoliopro-category',true );
					if(isset($items[0]->slug)){										
						foreach($items as $c){
							$map_marker= get_term_meta($c->term_id, 'listfoliopro_term_mapmarker', true);
							if($map_marker!=''){
								$default_marker =$map_marker;
								break;
							}							
						}
					}
				}			
				return $default_marker;
			}
			public function listfoliopro_get_location_caching($id, $post_type){
				if(metadata_exists('post', $id, 'listfoliopro-locations')) {
					$items = get_post_meta($id,'listfoliopro-locations',true );
					}else{									
					$items=wp_get_object_terms( $id, $post_type.'-locations');
					update_post_meta($id, 'listfoliopro-locations' , $items);
				}					
				return $items;
			}					
			public function listfoliopro_get_tags_caching($id, $post_type){
				if(metadata_exists('post', $id, 'listfoliopro-tags')) {
					$items = get_post_meta($id,'listfoliopro-tags',true );
					}else{										
					$items=wp_get_object_terms( $id, $post_type.'-tag');
					update_post_meta($id, 'listfoliopro-tags' , $items);
				}					
				return $items;
			}
			public function listfoliopro_listing_default_image() {
				$listfoliopro_listing_defaultimage=get_option('listfoliopro_listing_defaultimage');
				if(!empty($listfoliopro_listing_defaultimage)){
					$default_image_url= wp_get_attachment_image_src($listfoliopro_listing_defaultimage,'full');
					if(isset($default_image_url[0])){									
						$default_image_url=$default_image_url[0] ;
					}
					}else{
					$default_image_url=listfoliopro_ep_URLPATH."/assets/images/default-directory.jpg";
				}
				return $default_image_url;
			}
			public function listfoliopro_cancel_stripe(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				require_once(listfoliopro_ep_DIR . '/admin/files/lib/Stripe.php');
				global $wpdb;
				global $current_user;
				parse_str($_POST['form_data'], $form_data);	
				$newpost_id='';
				$post_name='listfoliopro_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s' ",$post_name ));
				if(isset($row->ID )){
					$newpost_id= $row->ID;
				}
				$stripe_mode=get_post_meta( $newpost_id,'listfoliopro_stripe_mode',true);
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($newpost_id, 'listfoliopro_stripe_secret_test',true);
					}else{
					$stripe_api =get_post_meta($newpost_id, 'listfoliopro_stripe_live_secret_key',true);
				}
				Stripe::setApiKey($stripe_api);
				try{
					$iv_cancel_stripe = Stripe_Customer::retrieve(sanitize_text_field($form_data['cust_id']));
					$iv_cancel_stripe->subscriptions->retrieve(sanitize_text_field($form_data['sub_id']))->cancel();
					} catch (Exception $e) {
				}
				update_user_meta($current_user->ID,'listfoliopro_iv_cancel_reason', sanitize_text_field($form_data['cancel_text']));
				update_user_meta($current_user->ID,'listfoliopro_payment_status', 'cancel');
				update_user_meta($current_user->ID,'listfoliopro_stripe_subscrip_id','');
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Cancel Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_update_setting_password(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}
				global $current_user;										
				if ( wp_check_password( sanitize_text_field($form_data['c_pass']), $current_user->user_pass, $current_user->ID) ){
					if($form_data['r_pass']!=$form_data['n_pass']){
						echo wp_json_encode(array("code" => "not", "msg"=>"New Password & Re Password are not same. "));
						exit(0);
						}else{
						wp_set_password( sanitize_text_field($form_data['n_pass']), $current_user->ID);
						echo wp_json_encode(array("code" => "success","msg"=>"Updated Successfully"));
						exit(0);
					}
					}else{
					echo wp_json_encode(array("code" => "not", "msg"=>esc_html__( 'Current password is wrong.', 'listfoliopro')));
					exit(0);
				}
			}
			public function listfoliopro_update_profile_setting(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);		
				if(array_key_exists('wp_capabilities',$form_data)){
					wp_die( 'Are you cheating:wp_capabilities?' );		
				}
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$allowed_html = wp_kses_allowed_html( 'post' );
				global $current_user;
				// Location
				$all_locations='';
				if(is_array($form_data['location_arr'])){				
					$all_locations= implode(",",$form_data['location_arr']);
					if(isset($form_data['new_location']) AND $form_data['new_location']!=''){ 
						$all_locations= $all_locations.','.$form_data['new_location'];
					}
				}				
				update_user_meta($current_user->ID, 'all_locations', sanitize_text_field($all_locations)); 
				update_user_meta($current_user->ID, 'new_locations', sanitize_text_field($form_data['new_location']));  
				$field_type=array();
				$field_type_opt=  get_option( 'listfoliopro_field_type' );
				if($field_type_opt!=''){
					$field_type=get_option('listfoliopro_field_type' );
					}else{
					$field_type['full_name']='text';					 
					$field_type['company_type']='text';
					$field_type['phone']='text';								
					$field_type['address']='text';
					$field_type['city']='text';
					$field_type['postcode']='text';
					$field_type['country']='text';
					$field_type['listing_title']='text';
					$field_type['gender']='radio';
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
							update_user_meta($current_user->ID, sanitize_text_field($field_key), sanitize_url($field_value)); 
							}elseif($field_type[$field_key]=='textarea'){
							update_user_meta($current_user->ID, sanitize_text_field($field_key), sanitize_textarea_field($field_value));  
							}else{
							update_user_meta($current_user->ID, sanitize_text_field($field_key), sanitize_text_field($field_value)); 
						}
					}
				}
				if(isset($form_data['latitude'])){
					update_user_meta($current_user->ID, 'latitude', sanitize_text_field($form_data['latitude']));
				}
				if(isset($form_data['longitude'])){
					update_user_meta($current_user->ID, 'longitude', sanitize_text_field($form_data['longitude']));
				}
				echo wp_json_encode(array("code" => "success","msg"=>esc_html__( 'Updated Successfully', 'listfoliopro')));
				exit(0);
			}
			public function listfoliopro_total_listing_count($userid, $allusers='no' ){
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				if($allusers=='yes' ){
					$args = array(
					'post_type' => $listfoliopro_directory_url, // enter your custom post type
					'paged' => '1',					
					'post_status' => 'publish',	
					'posts_per_page'=>'99999',  // overrides posts per page in theme settings
					);
					}else{
					$args = array(
					'post_type' => $listfoliopro_directory_url, // enter your custom post type
					'paged' => '1',
					'author'=>$userid ,
					'post_status' => 'publish',	
					'posts_per_page'=>'99999',  // overrides posts per page in theme settings
					);
				}
				$listing_count = new WP_Query( $args );
				$count = $listing_count->found_posts;
				return $count;
			}
			public function listfoliopro_restrict_media_library( $wp_query ) {
				if(!function_exists('wp_get_current_user')) { include(ABSPATH . "wp-includes/pluggable.php"); }
				global $current_user, $pagenow;
				if( is_admin() && !current_user_can('edit_others_posts') ) {
					$wp_query->set( 'author', $current_user->ID );
					add_filter('views_edit-post', 'fix_post_counts');
					add_filter('views_upload', 'fix_media_counts');
				}
			}
			public function listfoliopro_update_profile_pic(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $current_user;
				if(isset($_REQUEST['profile_pic_url_1'])){
					$iv_profile_pic_url=sanitize_url($_REQUEST['profile_pic_url_1']);
					$attachment_thum=sanitize_url($_REQUEST['attachment_thum']);
					}else{
					$iv_profile_pic_url='';
					$attachment_thum='';
				}
				update_user_meta($current_user->ID, 'listfoliopro_profile_pic_thum', $attachment_thum);
				update_user_meta($current_user->ID, 'iv_profile_pic_url', $iv_profile_pic_url);
				echo wp_json_encode('success');
				exit(0);
			}
			public function listfoliopro_paypal_form_submit(  ) {
				require_once(listfoliopro_ep_DIR . '/admin/pages/payment-inc/paypal-submit.php');
			}	
			public function listfoliopro_stripe_form_submit(  ) {
				require_once(listfoliopro_ep_DIR . '/admin/pages/payment-inc/stripe-submit.php');
			}
			/***********************************
				* Adds a meta box to the post editing screen
			*/
			public function listfoliopro_custom_meta_listfoliopro() {
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				add_meta_box('prfx_meta', esc_html__('Claim Approve ', 'listfoliopro'), array(&$this, 'listfoliopro_meta_callback'),$listfoliopro_directory_url,'side');
				add_meta_box('prfx_meta2', esc_html__('Listing Data  ', 'listfoliopro'), array(&$this, 'listfoliopro_meta_callback_full_data'),$listfoliopro_directory_url,'advanced');
			}
			public function listfoliopro_check_coupon(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'signup' ) ) {
					echo wp_json_encode(array("msg"=>"Are you cheating:wpnonce?"));						
					exit(0);
				}
				global $wpdb;
				$coupon_code=sanitize_text_field($_REQUEST['coupon_code']);
				$package_id=sanitize_text_field($_REQUEST['package_id']);					
				$package_amount=get_post_meta($package_id, 'listfoliopro_package_cost',true);
				$api_currency =sanitize_text_field($_REQUEST['api_currency']);
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='listfoliopro_coupon'",$coupon_code ));
				if(sizeof($post_cont)>0 && $package_amount>0){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = gmdate("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'listfoliopro_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'listfoliopro_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'listfoliopro_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'listfoliopro_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'listfoliopro_coupon_amount', true);
					$package_ids =get_post_meta($post_cont->ID, 'listfoliopro_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					if(in_array('0', $all_pac_arr)){
						$pac_found=1;
						}else{
						if(in_array($package_id, $all_pac_arr)){
							$pac_found=1;
							}else{
							$pac_found=0;
						}
					}
					$recurring = get_post_meta( $package_id,'listfoliopro_package_recurring',true);
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found == '1' && $recurring!='on' ){
						$total = $package_amount -$dis_amount;
						$coupon_type= get_post_meta($post_cont->ID, 'listfoliopro_coupon_type', true);
						if($coupon_type=='percentage'){
							$dis_amount= $dis_amount * $package_amount/100;
							$total = $package_amount -$dis_amount ;
						}
						echo wp_json_encode(array('code' => 'success',
						'dis_amount' => $dis_amount.' '.$api_currency,
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
						}else{
						$dis_amount='';
						$total=$package_amount;
						echo wp_json_encode(array('code' => 'not-success-2',
						'dis_amount' => '',
						'gtotal' => $total.' '.$api_currency,
						'p_amount' => $package_amount.' '.$api_currency,
						));
						exit(0);
					}
					}else{
					if($package_amount=="" or $package_amount=="0"){$package_amount='0';}
					$dis_amount='';
					$total=$package_amount;
					echo wp_json_encode(array('code' => 'not-success-1',
					'dis_amount' => '',
					'gtotal' => $total.' '.$api_currency,
					'p_amount' => $package_amount.' '.$api_currency,
					));
					exit(0);
				}
			}
			public function listfoliopro_check_package_amount(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'signup' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				global $wpdb;
				$coupon_code=(isset($_REQUEST['coupon_code'])? sanitize_text_field($_REQUEST['coupon_code']):'');
				$package_id=sanitize_text_field($_REQUEST['package_id']);
				if( get_post_meta( $package_id,'listfoliopro_package_recurring',true) =='on'  ){
					$package_amount=get_post_meta($package_id, 'listfoliopro_package_recurring_cost_initial', true);
					}else{					
					$package_amount=get_post_meta($package_id, 'listfoliopro_package_cost',true);
				}
				$api_currency =sanitize_text_field($_REQUEST['api_currency']);			
				$iv_gateway = get_option('listfoliopro_payment_gateway');
				if($iv_gateway=='woocommerce'){
					if ( class_exists( 'WooCommerce' ) ) {	
						$api_currency= get_option( 'woocommerce_currency' );
						$api_currency= get_woocommerce_currency_symbol( $api_currency );
					}
				}		
				$post_cont = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_title = '%s' and  post_type='listfoliopro_coupon'", $coupon_code));
				if(isset($post_cont->ID)){
					$coupon_name = $post_cont->post_title;
					$current_date=$today = gmdate("m/d/Y");
					$start_date=get_post_meta($post_cont->ID, 'listfoliopro_coupon_start_date', true);
					$end_date=get_post_meta($post_cont->ID, 'listfoliopro_coupon_end_date', true);
					$coupon_used=get_post_meta($post_cont->ID, 'listfoliopro_coupon_used', true);
					$coupon_limit=get_post_meta($post_cont->ID, 'listfoliopro_coupon_limit', true);
					$dis_amount=get_post_meta($post_cont->ID, 'listfoliopro_coupon_amount', true);
					$package_ids =get_post_meta($post_cont->ID, 'listfoliopro_coupon_pac_id', true);
					$all_pac_arr= explode(",",$package_ids);
					$today_time = strtotime($current_date);
					$start_time = strtotime($start_date);
					$expire_time = strtotime($end_date);
					$pac_found= in_array($package_id, $all_pac_arr);							
					if($today_time >= $start_time && $today_time<=$expire_time && $coupon_used<=$coupon_limit && $pac_found=="1"){
						$total = $package_amount -$dis_amount;
						echo wp_json_encode(array('code' => 'success',
						'dis_amount' => $api_currency.' '.$dis_amount,
						'gtotal' => $api_currency.' '.$total,
						'p_amount' => $api_currency.' '.$package_amount,
						));
						exit(0);
						}else{
						$dis_amount='--';
						$total=$package_amount;
						echo wp_json_encode(array('code' => 'not-success',
						'dis_amount' => $api_currency.' '.$dis_amount,
						'gtotal' => $api_currency.' '.$total,
						'p_amount' => $api_currency.' '.$package_amount,
						));
						exit(0);
					}
					}else{
					$dis_amount='--';
					$total=$package_amount;
					echo wp_json_encode(array('code' => 'not-success',
					'dis_amount' => $api_currency.' '.$dis_amount,
					'gtotal' => $api_currency.' '.$total,
					'p_amount' => $api_currency.' '.$package_amount,
					));
					exit(0);
				}
			}
			/**
				* Outputs the content of the meta box
			*/
			public function listfoliopro_meta_callback($post) {
				wp_nonce_field(basename(__FILE__), 'prfx_nonce');
				require_once ('admin/pages/metabox.php');
			}
			public function listfoliopro_meta_callback_full_data(){
				require_once ('admin/pages/metabox_full_data.php');
			}
			public function listfoliopro_color_js(){ global $listihub_theme_option ; 
					
				$listfoliopro_primary_color=listihub_option('theme_primary_color');	
				if($listfoliopro_primary_color==""){$listfoliopro_primary_color='#1dbfc1';}
				
				$listfoliopro_second_color=listihub_option('theme_second_color');	
				if($listfoliopro_second_color==""){$listfoliopro_second_color='#87f1f2';}	
				$theme_content_bg_color=get_option('theme_content_bg_color');	
				if($theme_content_bg_color==""){$theme_content_bg_color='#87f1f2';}
				wp_enqueue_script('listfoliopro-dynamic-color', listfoliopro_ep_URLPATH . 'admin/files/js/dynamic-color.js');
				wp_localize_script('listfoliopro-dynamic-color', 'listfoliopro_color', array(
				'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
				'listfoliopro_primary_color'=>$listfoliopro_primary_color,
				'listfoliopro_second_color'=>$listfoliopro_second_color,	
				'listfoliopro_content_bg_color'=>$theme_content_bg_color,				
				) );			
			}
			public function listfoliopro_all_functions(){
				include_once('functions/listing-functions.php');
				include_once('functions/open-status-checker.php');				
				include_once('admin/pages/metaboxes/location-meta.php');
				include_once('admin/pages/metaboxes/category-meta.php');
				include_once('admin/pages/metaboxes/tag-meta.php');
			}
			public function listfoliopro_meta_save($post_id) {
				global $wpdb;
				$newpost_id=$post_id;
				$is_autosave = wp_is_post_autosave($post_id);
				if (isset($_REQUEST['listfoliopro_approve'])) {
					if($_REQUEST['listfoliopro_approve']=='yes'){
						update_post_meta($post_id, 'listfoliopro_approve', sanitize_text_field($_REQUEST['listfoliopro_approve']));
						// Set new user for post							
						$listfoliopro_author_id= sanitize_text_field($_REQUEST['listfoliopro_author_id']);
						$sql=$wpdb->prepare("UPDATE  $wpdb->posts SET post_author=%d  WHERE ID=%d",$listfoliopro_author_id,$post_id );
						$wpdb->query($sql); 					
					}
				} 
				if (isset($_REQUEST['listfoliopro_featured'])) {
					update_post_meta($post_id, 'listfoliopro_featured', sanitize_text_field($_REQUEST['listfoliopro_featured']));
				}
				$opening_day=array();
				if(isset($_REQUEST['day_name'] )){
					$day_name= $_REQUEST['day_name'] ;
					$day_value1 = $_REQUEST['day_value1'];
					$day_value2 = $_REQUEST['day_value2'] ;
					$i=0;
					foreach($day_name  as $one_meta){
						if(isset($day_name[$i]) and isset($day_value1[$i]) ){
							if($day_name[$i] !=''){
								$opening_day[sanitize_text_field($day_name[$i])]= array(sanitize_text_field($day_value1[$i])=>sanitize_text_field($day_value2[$i])) ;
							}
						}
						$i++;
					}
					update_post_meta($newpost_id, '_opening_time', $opening_day);
				}
				if (isset($_REQUEST['listing_data_submit'])) {
					$newpost_id=$post_id;
					// For FAQ Save
					// Delete 1st
					$i=0;
					for($i=0;$i<20;$i++){
						delete_post_meta($newpost_id, 'faq_title'.$i);							
						delete_post_meta($newpost_id, 'faq_description'.$i);
					}
					// Delete End
					if(isset($_REQUEST['faq_title'] )){
						$faq_title= $_REQUEST['faq_title']; //this is array data we sanitize later, when it save				
						$faq_description= $_REQUEST['faq_description'];
						$i=0;
						for($i=0;$i<20;$i++){
							if(isset($faq_title[$i]) AND $faq_title[$i]!=''){
								update_post_meta($newpost_id, 'faq_title'.$i, sanitize_text_field($faq_title[$i]));
								update_post_meta($newpost_id, 'faq_description'.$i, sanitize_textarea_field($faq_description[$i]));
							}
						}
					}
					// End FAQ
					$default_fields = array();
					$field_set=get_option('listfoliopro_li_fields' );
					
					if($field_set==""){
						$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
						$default_fields = $default_fields_two_arr[0];	
					}else{
						$default_fields=$field_set;
					}				
					if(is_array($default_fields )){			
						foreach( $default_fields as $field_key => $field_value ) { 
							update_post_meta($newpost_id, $field_key, $_REQUEST[$field_key] );							
						}					
					}
					update_post_meta($newpost_id, 'address', sanitize_text_field($_REQUEST['address'])); 
					update_post_meta($newpost_id, 'latitude', sanitize_text_field($_REQUEST['latitude'])); 
					update_post_meta($newpost_id, 'longitude', sanitize_text_field($_REQUEST['longitude']));					
					update_post_meta($newpost_id, 'city', sanitize_text_field($_REQUEST['city'])); 
					update_post_meta($newpost_id, 'state', sanitize_text_field($_REQUEST['state'])); 
					update_post_meta($newpost_id, 'postcode', sanitize_text_field($_REQUEST['postcode'])); 
					update_post_meta($newpost_id, 'country', sanitize_text_field($_REQUEST['country'])); 
					update_post_meta($newpost_id, 'local-area', sanitize_text_field($_REQUEST['local-area'])); 
					// Get latlng from address* START********
					// Get latlng from address* ENDDDDDD********	
					// listing detail*****
					if(isset($_REQUEST['dirpro_email_button'])){						
						update_post_meta($newpost_id, 'dirpro_email_button', sanitize_text_field($_REQUEST['dirpro_email_button'])); 
					}
					if(isset($_REQUEST['dirpro_web_button'])){						
						update_post_meta($newpost_id, 'dirpro_web_button', sanitize_text_field($_REQUEST['dirpro_web_button'])); 
					}
					update_post_meta($newpost_id, 'image_gallery_ids', sanitize_text_field($_REQUEST['gallery_image_ids'])); 
					update_post_meta($newpost_id, 'attached_ids', sanitize_text_field($_REQUEST['attached_ids']));
					update_post_meta($newpost_id, 'topbanner', sanitize_text_field($_REQUEST['topbanner_image_id'])); 
					if(isset($_REQUEST['feature_image_id'] )){
						$attach_id =sanitize_text_field($_REQUEST['feature_image_id']);
						set_post_thumbnail( $newpost_id, $attach_id );					
					}
					update_post_meta($newpost_id, 'price_prefix_text', sanitize_text_field($_REQUEST['price_prefix_text']));
					update_post_meta($newpost_id, 'price', sanitize_text_field($_REQUEST['price']));
					update_post_meta($newpost_id, 'discount', sanitize_text_field($_REQUEST['discount']));
					update_post_meta($newpost_id, 'whatsapp', sanitize_text_field($_REQUEST['whatsapp']));
					update_post_meta($newpost_id, 'viber', sanitize_text_field($_REQUEST['viber']));
					update_post_meta($newpost_id, 'listing_contact_source', sanitize_text_field($_REQUEST['contact_source']));  
					update_post_meta($newpost_id, 'company_name', sanitize_text_field($_REQUEST['company_name']));
					update_post_meta($newpost_id, 'phone', sanitize_text_field($_REQUEST['phone'])); 
					update_post_meta($newpost_id, 'address', sanitize_text_field($_REQUEST['address'])); 
					update_post_meta($newpost_id, 'contact-email', sanitize_text_field($_REQUEST['contact-email'])); 
					update_post_meta($newpost_id, 'contact_web', sanitize_text_field($_REQUEST['contact_web']));
					update_post_meta($newpost_id, 'vimeo', sanitize_text_field($_REQUEST['vimeo'])); 
					update_post_meta($newpost_id, 'youtube', sanitize_text_field($_REQUEST['youtube'])); 
					update_post_meta($newpost_id, '360_image', sanitize_url($_REQUEST['360_image']));
					update_post_meta($newpost_id, 'facebook', sanitize_url($_REQUEST['facebook']));
					update_post_meta($newpost_id, 'linkedin', sanitize_url($_REQUEST['linkedin']));
					update_post_meta($newpost_id, 'instagram', sanitize_url($_REQUEST['instagram']));
					update_post_meta($newpost_id, 'twitter', sanitize_url($_REQUEST['twitter']));
					//Public Facilities
					$facilities=array();
					if(isset($_REQUEST['facilities_name'] )){
						$facilities_name= $_REQUEST['facilities_name'] ;
						$facilities_value = $_REQUEST['facilities_value'] ;
						$i=0;
						foreach($facilities_name  as $one_facility){
							if(isset($facilities_name[$i]) and isset($facilities_value[$i]) ){
								if($facilities_name[$i] !=''){
									$facilities[$facilities_name[$i]] = sanitize_text_field($facilities_value[$i]);
								}
							}							
							$i++;	
						}
						update_post_meta($newpost_id, 'public_facilities', $facilities); 	
					}
					delete_post_meta($newpost_id, 'listfoliopro-tags');
					delete_post_meta($newpost_id, 'listfoliopro-category');
					delete_post_meta($newpost_id, 'listfoliopro-locations');
				}
				delete_post_meta($post_id, 'listfoliopro-tags');
				delete_post_meta($post_id, 'listfoliopro-category');
				delete_post_meta($post_id, 'listfoliopro-locations');
			}
			/**
				* Checks that the WordPress setup meets the plugin requirements
				* @global string $wp_version
				* @return boolean
			*/
			private function check_requirements() {
				global $wp_version;
				if (!version_compare($wp_version, $this->wp_version, '>=')) {
					add_action('admin_notices', 'listfoliopro_eplugins::display_req_notice');
					return false;
				}
				return true;
			}
			/**
				* Display the requirement notice
				* @static
			*/
			static function display_req_notice() {
				global $listfoliopro_eplugins;
				echo '<div id="message" class="error"><p><strong>';
				echo esc_html__('Sorry, BootstrapPress re requires WordPress ' . $listfoliopro_eplugins->wp_version . ' or higher.
				Please upgrade your WordPress setup', 'listfoliopro');
				echo '</strong></p></div>';
			}
			private function load_dependencies() {
				// Admin Panel
				if (is_admin()) {						
					require_once ('admin/admin.php');	
				}
				// Front-End Site
				if (!is_admin()) {
				}
				require_once('functions/listing-functions.php');
				// Global
			}
			/**
				* Called every time the plug-in is activated.
			*/
			public function activate() {				
				require_once ('install/install.php');
			}
			/**
				* Called when the plug-in is deactivated.
			*/
			public function deactivate() {
				global $wpdb;	
				$page_name='price-table';	
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}			
				$page_name='registration';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='my-account';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='login';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='all-listings';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='all-listings-no-map';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='all-locations';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='all-categories';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
				$page_name='search-form';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}			
				$page_name='add-listing';						
				$page = get_page_by_title($page_name);
				if ($page) {
					wp_delete_post($page->ID, true); 
				}
			}
			/**
				* Called when the plug-in is uninstalled
			*/
			static function uninstall() {
			}
			/**
				* Register the widgets
			*/
			public function register_widget() {
			}
			/**
				* Internationalization
			*/
			public function i18n() {
				load_plugin_textdomain('listfoliopro', false, basename(dirname(__FILE__)) . '/languages/' );
			}
			/**
				* Starts the plug-in main functionality
			*/
			public function listfoliopro_price_table_func($atts = '', $content = '') {
				ob_start();					  //include the specified file
				include( listfoliopro_ep_template. 'price-table/price-table-1.php');
				$content = ob_get_clean();	
				return $content;
			}
			public function listfoliopro_form_wizard_func($atts = '') {
				global $current_user;
				$template_path=listfoliopro_ep_template.'signup/';
				ob_start();	 //include the specified file
				if($current_user->ID==0){
					$signup_access= get_option('users_can_register');	
					if($signup_access=='0'){
						esc_html_e( 'Sorry! You are not allowed for signup.', 'listfoliopro' );
						}else{
						include( $template_path. 'wizard-style-2.php');
					}						
					}else{						  
					include( listfoliopro_ep_template. 'private-profile/profile-template-1.php');
				}
				$content = ob_get_clean();	
				return $content;
			}
			public function listfoliopro_profile_template_func($atts = '') {
				global $current_user;
				ob_start();
				// If user is not logged in, show login form
				if ( ! is_user_logged_in() || empty($current_user->ID) ) {
					require_once(listfoliopro_ep_template. 'private-profile/profile-login.php');
				} else {					  
					include( listfoliopro_ep_template. 'private-profile/profile-template-1.php');
				}
				$content = ob_get_clean();	
				return $content;
			}
			public function listfoliopro_reminder_email_cron_func ($atts = ''){
				include( listfoliopro_ep_ABSPATH. 'inc/reminder-email-cron.php');
			}
			public function listfoliopro_cron_listing(){
				include( listfoliopro_ep_ABSPATH. 'inc/all_cron_listing.php');
				exit(0);
			}
			public function listfoliopro_categories_func($atts = ''){
				ob_start();				
				include( listfoliopro_ep_template. 'listing/listing_categories.php');
				$content = ob_get_clean();
				return $content;	
			}
			public function listfoliopro_add_listing_func(){
				ob_start();	
				include( listfoliopro_ep_template. 'private-profile/add-listing-without-user.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_locations_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/listing-locations.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_listing_claim_popup(){
				include( listfoliopro_ep_template. 'listing/single-template/claim.php');
				exit(0);
			}
			public function listfoliopro_search_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/listing_search.php');
				
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_categories_carousel_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/carousel/categories-carousel.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_tags_carousel_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/carousel/tags-carousel.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_locations_carousel_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/carousel/locations-carousel.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_map_func($atts = ''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/archive-map.php');
				$content = ob_get_clean();
				return $content;
			}				
			public function listfoliopro_featured_func($atts = ''){
				ob_start();	
				if(isset($atts['style']) and $atts['style']!="" ){
					$tempale=$atts['style']; 
					}else{
					$tempale=get_option('listfoliopro_featured');
				}
				if($tempale==''){
					$tempale='style-1';
				}						
				//include the specified file
				if($tempale=='style-1'){
					include( listfoliopro_ep_template. 'listing/listing_featured.php');
				}
				$content = ob_get_clean();
				return $content;	
			}	
			public function listfoliopro_archive_grid_no_map_func($atts=''){
				ob_start();
				$no_map='no-map';
				include( listfoliopro_ep_template. 'listing/archive-grid-no-map.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_archive_grid_square_func($atts=''){
				ob_start();					
				include( listfoliopro_ep_template. 'listing/archive-grid-square.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_archive_grid_rounded_func($atts=''){
				ob_start();					
				include( listfoliopro_ep_template. 'listing/archive-grid-rounded.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_listfoliopro_listing_filter_func($atts=''){
				ob_start();	
				include( listfoliopro_ep_template. 'listing/listing-filter.php');
				$content = ob_get_clean();
				return $content;				
			}
			public function listfoliopro_single_rounded_func($atts=''){
				ob_start();					
				include( listfoliopro_ep_template. 'listing/single-template/shortcode/single-listing-1.php');
				$content = ob_get_clean();
				return $content;
			}
			public function listfoliopro_single_square_func($atts=''){				
				ob_start();	
				include( listfoliopro_ep_template. 'listing/single-template/shortcode/single-listing-2.php');
				$content = ob_get_clean();
				return $content;					
			}
			public function get_unique_location_values(  $post_type , $key = 'keyword'){
				global $wpdb;
				$post_type=get_option('listfoliopro_ep_url');
				if($post_type==""){$post_type='listing';}
				$all_data=array();
				$dir_facet_title=get_option('dir_facet_area_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Area','listfoliopro');}
				$res=array();
				$key = 'area';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}
				}
				// City ***
				$dir_facet_title=get_option('dir_facet_location_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('City','listfoliopro');}
				$res=array();
				$key = 'city';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='{$post_type}' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}	
				}
				// Zipcode ***
				$dir_facet_title=get_option('dir_facet_zipcode_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Zipcode','listfoliopro');}
				$res=array();
				$key = 'postcode';
				$res = $wpdb->get_col( $wpdb->prepare( "
				SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE p.post_type='".esc_html($post_type)."' AND  pm.meta_key = '%s'						
				", $key) );						
				foreach($res as $row1){							
					$row_data=array();
					if(!empty($row1)){
						$row_data['label']=$row1;
						$row_data['value']=$row1;
						$row_data['category']= $dir_facet_title;
						array_push( $all_data, $row_data );
					}	
				}
				$all_data_json= wp_json_encode($all_data);		
				return $all_data_json;
			}
			public function get_unique_search_values(){						
				global $wpdb;
				$post_type=get_option('listfoliopro_ep_url');
				if($post_type==""){$post_type='listing';}
				$res=array();
				$all_data=array();						
				$partners = array();
				$partners_obj =  get_terms( array('hide_empty' => true,'taxonomy'=>$post_type.'-category') );
				$dir_facet_title=get_option('dir_facet_cat_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Categories','listfoliopro');}
				foreach ($partners_obj as $partner) {
					$row_data=array();
					$row_data['label']=$partner->name.'['.$partner->count.']';
					$row_data['value']=$partner->name;
					$row_data['category']= $dir_facet_title;
					array_push( $all_data, $row_data );
				}
				// For tags
				$dir_facet_title=get_option('dir_facet_features_title');
				if($dir_facet_title==""){$dir_facet_title= esc_html__('Features','listfoliopro');}
				$dir_tags=get_option('listfoliopro_tags');
				if($dir_tags==""){$dir_tags='yes';}	
				if($dir_tags=="yes"){
					$partners = array();
					$partners_obj =  get_terms( array('hide_empty' => true,'taxonomy'=>$post_type.'-tag') );
					foreach ($partners_obj as $partner) {
						$row_data=array();
						$row_data['label']=$partner->name.'['.$partner->count.']';
						$row_data['value']=$partner->name;
						$row_data['category']=$dir_facet_title;
						array_push( $all_data, $row_data );
					}
					}else{
					$args =array();
					$args['hide_empty']=true;
					$tags = get_tags($args );
					foreach ( $tags as $tag ) { 
						$row_data=array();
						$row_data['label']=$tag->name.'['.$tag->count.']';
						$row_data['value']=$tag->name;
						$row_data['category']=$dir_facet_title;
						array_push( $all_data, $row_data );
					}							
				}
				// End Tags	****					
				$args3 = array(
				'post_type' => $post_type, // enter your custom post type						
				'post_status' => 'publish',						
				'posts_per_page'=> -1,  // overrides posts per page in theme settings
				'orderby' => 'title',
				'order' => 'ASC',
				);
				$all_data_json=array();
				$query_auto = new WP_Query( $args3 );
				$posts_auto = $query_auto->posts;						
				foreach($posts_auto as $post_a) {
					$row_data=array();  
					$row_data['label']=$post_a->post_title;
					$row_data['value']=$post_a->post_title;
					$row_data['category']= esc_html__('Title','listfoliopro');
					array_push( $all_data, $row_data );
				}						
				$all_data_json= wp_json_encode($all_data);	
				return $all_data_json;
			}
			public function listfoliopro_create_taxonomy_locations(){
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$listfoliopro_label_location=get_option('listfoliopro_label_location');
				if($listfoliopro_label_location==""){$listfoliopro_label_location=esc_html__('Locations','listfoliopro');}
				$labels = array(			
				'all_items'           => esc_html($listfoliopro_label_location ),
				'add_new_item'        => esc_html__( 'Add New', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add ', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New ', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit ', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update ', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View ', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				register_taxonomy(
				$listfoliopro_directory_url.'-locations',
				$listfoliopro_directory_url,
				array(
				'label' => esc_html( $listfoliopro_label_location),
				'description'         => esc_html($listfoliopro_label_location ),
				'labels'              => $labels,
				'rewrite' => array( 'slug' => $listfoliopro_directory_url.'-locations' ),				
				'hierarchical' => true,
				'show_in_rest' =>	true,
				)
				);		
			}
			public function listfoliopro_create_taxonomy_type(){
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}				
				$labels = array(			
				'all_items'           => esc_html__( 'All Post Type', 'listfoliopro' ),
				'add_new_item'        => esc_html__( 'Add New Post Type', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add Post Type', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New Post Type', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit Post Type', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update Post Type', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View Post Type', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search Post Type', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				register_taxonomy(
				$listfoliopro_directory_url.'-type',
				$listfoliopro_directory_url,
				array(
				'label' => esc_html__( 'Post Type', 'listfoliopro'),
				'description'         => esc_html__('Post Type' , 'listfoliopro' ),
				'labels'              => $labels,
				'rewrite' => array( 'slug' => $listfoliopro_directory_url.'-type' ),
				'description'         => esc_html__( 'Post Type', 'listfoliopro' ),
				'hierarchical' => true,
				'show_in_rest' =>	true,
				)
				);		
			}
			public function listfoliopro_create_taxonomy_tags(){
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$listfoliopro_label_tag=get_option('listfoliopro_label_tag');
				if($listfoliopro_label_tag==""){$listfoliopro_label_tag=esc_html__('Tags','listfoliopro');}
				$listfoliopro_directory_url_name=ucfirst('Tags');
				$labels = array(			
				'all_items'           => esc_html( $listfoliopro_label_tag ),
				'add_new_item'        => esc_html__( 'Add New ', 'listfoliopro' ),
				'add_new'             => esc_html__( 'Add ', 'listfoliopro' ),
				'new_item'            => esc_html__( 'New ', 'listfoliopro' ),
				'edit_item'           => esc_html__( 'Edit ', 'listfoliopro' ),
				'update_item'         => esc_html__( 'Update ', 'listfoliopro' ),
				'view_item'           => esc_html__( 'View ', 'listfoliopro' ),
				'search_items'        => esc_html__( 'Search ', 'listfoliopro' ),
				'not_found'           => esc_html__( 'Not found', 'listfoliopro' ),
				'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'listfoliopro' ),
				);
				register_taxonomy(
				$listfoliopro_directory_url.'-tag',
				$listfoliopro_directory_url,
				array(
				'label' => esc_html($listfoliopro_label_tag),
				'description'         => esc_html($listfoliopro_label_tag ),
				'labels'              => $labels,
				'rewrite' => array( 'slug' => $listfoliopro_directory_url.'-tag' ),
				'hierarchical' => true,
				'show_in_rest' =>	true,
				)
				);						
			}		
			public function listfoliopro_save_favorite(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites.', '.get_current_user_id();
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2.', '.$dir_id;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo wp_json_encode(array("msg" => 'success'));
				exit(0);	
			}
			public function listfoliopro_save_un_favorite(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo wp_json_encode(array("msg" => 'success'));
				exit(0);	
			}
			public function listfoliopro_save_notification(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);	
				get_current_user_id();
				$notification_value=array();
				$notification= $form_data['notificationone']; //this is array data we sanitize later, when it save
				foreach($notification as $notification_one){
					if( $notification_one!=''){							
						$notification_value[]= sanitize_text_field($notification_one);
					}
				}	
				update_user_meta(get_current_user_id(),'listing_notifications',$notification_value);
				echo wp_json_encode(array("code" => "success","msg"=>"Updated Successfully"));
				exit(0);	
			}
			public function listfoliopro_booking_delete(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				global $current_user;
				$message_id=sanitize_text_field($form_data['id']);
				$user_to=get_post_meta($message_id,'user_to',true);	
				if($user_to==$current_user->ID){				
					wp_delete_post($message_id);					
					echo wp_json_encode(array("msg" => 'success'));
					}else{
					echo wp_json_encode(array("msg" => 'Not success'));
				}
				exit(0);
			}
			public function listfoliopro_message_delete(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);
				global $current_user;
				$message_id=sanitize_text_field($form_data['id']);
				$user_to=get_post_meta($message_id,'user_to',true);	
				if($user_to==$current_user->ID){				
					wp_delete_post($message_id);
					delete_post_meta($message_id,true);	
					echo wp_json_encode(array("msg" => 'success'));
					}else{
					echo wp_json_encode(array("msg" => 'Not success'));
				}
				exit(0);		
			}
			public function listfoliopro_load_categories_fields_wpadmin(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'addlisting' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$main_class = new listfoliopro_eplugins;
				$fields_data='';
				$categories_arr=array();
				$term_id = $_POST['term_id'];
				$post_id= sanitize_text_field($_POST['post_id']);
				$datatype= sanitize_text_field($_POST['datatype']); 
				if (!empty($term_id)) {
					if($datatype!='slug'){
						foreach ($term_id as $tid) {
							$tid=sanitize_text_field($tid);
							$category = get_term_by('name', $tid, $listfoliopro_directory_url.'-category');
							$categories_arr[] = $category->slug;
						}
						}else{
						foreach ($term_id as $tid) {	
							$tid=sanitize_text_field($tid);
							$categories_arr[] = $tid;
						}
					}
					$fields_data=$main_class->listfoliopro_listing_fields($post_id, $categories_arr );
				}
				echo wp_json_encode(array("msg" => 'success',"field_data"=>$fields_data));
				exit(0);
			}
			public function listfoliopro_listing_fields($listid, $categories_arr){
				$listid=$listid;
				global $current_user;
				$default_fields = array();			
				$listfoliopro_fields=  		get_option( 'listfoliopro_li_fields' );
				$field_type=  get_option( 'listfoliopro_li_field_type' );
				$field_type_value=  get_option( 'listfoliopro_li_fieldtype_value' );
				$listfoliopro_field_type_cat=  get_option( 'listfoliopro_field_type_cat' );
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				$taxonomy = $listfoliopro_directory_url.'-category';				
				$terms = get_terms( array(
				'taxonomy' => $taxonomy,
				'hide_empty' => false, 
				) );
				if($listfoliopro_fields==""){ 
					$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
					$default_fields = $default_fields_two_arr[0];							
					$field_type=  $default_fields_two_arr[1];
				}else{ 
					$default_fields=$listfoliopro_fields;
				}
				$return_value='';
				foreach ( $default_fields as $field_key_pass => $field_value ) { 					
					$intersection='';				
					$field_cat_arr= (isset($listfoliopro_field_type_cat[$field_key_pass])?$listfoliopro_field_type_cat[$field_key_pass] : '' );
					if(is_array($field_cat_arr) AND is_array($categories_arr) ){
						$intersection = array_intersect($categories_arr, $listfoliopro_field_type_cat[$field_key_pass]);
					}
					if ( empty( $terms ) ) {
						$intersection='all empty category';
					}
					if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
						// $intersection='all access for admin';	// If you want to display all custom fields then open it. 		
					}
					if(!empty($intersection)){ 
						$return_value=$return_value.'<div class="col-md-12">';
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='dropdown'){	 								
							$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
							$return_value=$return_value.'<div class="form-group row">
							<label class="control-label col-md-4">'. esc_html($field_value).'</label>
							<div class="col-md-8"><select name="'. esc_html($field_key_pass).'" id="'.esc_attr($field_key_pass).'" class="form-control "  >';				
							foreach($dropdown_value as $one_value){	 
								if(trim($one_value)!=''){
									$return_value=$return_value.'<option '.(trim(get_post_meta($listid,$field_key_pass,true))==trim($one_value)?' selected':'').' value="'. esc_attr($one_value).'">'. esc_html($one_value).'</option>';
								}
							}	
							$return_value=$return_value.'</select></div></div>';					
						}
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='checkbox'){								
							$dropdown_value= explode(',',$field_type_value[$field_key_pass]);						
							$return_value=$return_value.'<div class="form-group row">
							<label class="control-label col-md-4">'. esc_html($field_value).'</label>
							<div class="col-md-8">
							<div class="" >
							';
							$saved_checkbox_value=get_post_meta($listid,$field_key_pass,true);							
							if(!is_array($saved_checkbox_value)){
								if($saved_checkbox_value!=''){								
									$saved_checkbox_value =	explode(',',get_post_meta($listid,$field_key_pass,true));
								}
							}
							if(empty($saved_checkbox_value)){$saved_checkbox_value=array();}
							foreach($dropdown_value as $one_value){
								if(trim($one_value)!=''){
									$return_value=$return_value.'
									<div class="form-check form-check-inline col-md-12 margin-top10">
									<label class="form-check-label" for="'. esc_attr($one_value).'">
									<input '.( in_array($one_value,$saved_checkbox_value)?' checked':'').' class=" form-check-input" type="checkbox" name="'. esc_attr($field_key_pass).'[]"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
									'. esc_attr($one_value).' </label>
									</div>';
								}
							}	
							$return_value=$return_value.'</div></div></div>';						
						}
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='radio'){	 								
							$dropdown_value= explode(',',$field_type_value[$field_key_pass]);
							$return_value=$return_value.'<div class="form-group row ">
							<label class="control-label col-md-4">'. esc_html($field_value).'</label>
							<div class="col-md-8">
							<div class="" >
							';						
							foreach($dropdown_value as $one_value){	 
								if(trim($one_value)!=''){
									$return_value=$return_value.'
									<div class="form-check form-check-inline col-md-12 margin-top10">
									<label class="form-check-label " for="'. esc_attr($one_value).'">
									<input '.(get_post_meta($listid,$field_key_pass,true)==$one_value?' checked':'').' class="form-check-input" type="radio" name="'. esc_attr($field_key_pass).'"  id="'. esc_attr($one_value).'" value="'. esc_attr($one_value).'">
									'. esc_attr($one_value).'</label>
									</div>														
									';
								}
							}	
							$return_value=$return_value.'</div></div></div>';					
						}					 
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='textarea'){	
							$return_value=$return_value.'<div class="form-group row">';
							$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
							$return_value=$return_value.'<div class="col-md-8"><textarea  placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="col-md-12"  rows="4"/>'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'</textarea></div></div>';
						}
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='datepicker'){	 
							$return_value=$return_value.'<div class="form-group row">';
							$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
							$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Select ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control epinputdate " value="'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
						}
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='text'){	 
							$return_value=$return_value.'<div class="form-group row">';
							$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
							$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_attr(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
						}
						if(isset($field_type[$field_key_pass]) && $field_type[$field_key_pass]=='url'){	 
							$return_value=$return_value.'<div class="form-group row">';
							$return_value=$return_value.'<label class="control-label col-md-4">'. esc_html($field_value).'</label>';
							$return_value=$return_value.'<div class="col-md-8"><input type="text" placeholder="'.esc_html__('Enter ','ivdirectories').esc_attr($field_value).'" name="'.esc_html($field_key_pass).'" id="'. esc_attr($field_key_pass).'"  class="form-control " value="'.esc_url(get_post_meta($listid,$field_key_pass,true)).'"/></div></div>';
						}
						$return_value=$return_value.'</div>';
					}
				} // For main  fields loop 
				return $return_value;
			}
			public function listfoliopro_author_bookmark_delete(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);
				$old_favorites= get_post_meta($dir_id,'listfoliopro_authorbookmark',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'listfoliopro_authorbookmark',$new_favorites);
				$old_favorites2=get_user_meta(get_current_user_id(),'listfoliopro_authorbookmark', true);
				$old_favorites2 = str_replace($dir_id ,'',  $old_favorites2);
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'listfoliopro_authorbookmark',$new_favorites2);
				echo wp_json_encode(array("msg" => 'success'));
				exit(0);		
			}
			public function listfoliopro_delete_favorite(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'myaccount' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['data'], $form_data);					
				$dir_id=sanitize_text_field($form_data['id']);						
				$old_favorites= get_post_meta($dir_id,'_favorites',true);
				$old_favorites = str_replace(get_current_user_id(), '',  $old_favorites);
				$new_favorites=$old_favorites;
				update_post_meta($dir_id,'_favorites',$new_favorites);						
				$old_favorites2=get_user_meta(get_current_user_id(),'_dir_favorites', true);						
				$old_favorites2 = str_replace($dir_id ,' ',  $old_favorites2);						
				$new_favorites2=$old_favorites2;
				update_user_meta(get_current_user_id(),'_dir_favorites',$new_favorites2);
				echo wp_json_encode(array("msg" => 'success'));
				exit(0);
			}
			public function listfoliopro_booking_message_send(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				// Create new message post
				$allowed_html = wp_kses_allowed_html( 'post' );					
				if(isset($form_data['dir_id'])){
					if($form_data['dir_id']>0){
						$dir_id=sanitize_text_field($form_data['dir_id']);
						$dir_detail= get_post($dir_id); 
						$dir_title= get_permalink($dir_id);
						$dir_name=$dir_detail->post_title;
						$user_id=$dir_detail->post_author;
						$user_info = get_userdata( $user_id);
						$client_email_address =$user_info->user_email;
						$userid_to=$user_id;
					}
				}
				$new_nessage= esc_html__( 'Booking Message', 'listfoliopro' );
				$my_post=array();
				$subject= $form_data['booking_name'].' | '.	$form_data['booking_email_address'].' | Phone: '.$form_data['booking_phone'].' | Date: '.$form_data['booking_datetime'];		
				$my_post['post_title'] =$subject;
				$my_post['post_content'] = wp_kses( $form_data['booking_message_content'], $allowed_html); 
				$my_post['post_type'] = 'listfoliopro_booking';
				$my_post['post_status']='private';												
				$newpost_id= wp_insert_post( $my_post );
				update_post_meta($newpost_id,'user_to', $userid_to );
				update_post_meta($newpost_id,'dir_url', $dir_title );	
				update_post_meta($newpost_id,'dir_name', $dir_name );
				update_post_meta($newpost_id,'from_email',sanitize_email($form_data['booking_email_address']) );
				if(isset($form_data['name'])){
					update_post_meta($newpost_id,'from_name', sanitize_text_field($form_data['booking_name']) );
				}
				update_post_meta($newpost_id,'from_phone', sanitize_text_field($form_data['booking_phone']) );
				update_post_meta($newpost_id,'service_type', sanitize_text_field($form_data['booking_service_type']) );
				update_post_meta($newpost_id,'bedrooms', sanitize_text_field($form_data['booking_bedrooms']) );
				update_post_meta($newpost_id,'baths', sanitize_text_field($form_data['booking_baths']) );
				update_post_meta($newpost_id,'booking_datetime', sanitize_text_field($form_data['booking_datetime']) );
				include( listfoliopro_ep_ABSPATH. 'inc/booking-mail.php');
				echo wp_json_encode(array("msg" => esc_html__( 'Message Sent', 'listfoliopro' )));
				exit(0);
			}
			public function listfoliopro_message_send(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'contact' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				// Create new message post
				$allowed_html = wp_kses_allowed_html( 'post' );					
				if(isset($form_data['dir_id'])){
					if($form_data['dir_id']>0){
						$dir_id=sanitize_text_field($form_data['dir_id']);
						$dir_detail= get_post($dir_id); 
						$dir_title= '<a href="'.get_permalink($dir_id).'">'.$dir_detail->post_title.'</a>';
						$user_id=$dir_detail->post_author;
						$user_info = get_userdata( $user_id);
						$client_email_address =$user_info->user_email;
						$userid_to=$user_id;
					}
				}
				$new_nessage= esc_html__( 'New Message', 'listfoliopro' );
				$my_post=array();
				$subject=$new_nessage;
				if(isset($form_data['subject'])){
					$subject=sanitize_text_field($form_data['subject']);
				} 
				$my_post['post_title'] =$subject;
				$my_post['post_content'] = wp_kses( $form_data['message-content'], $allowed_html); 
				$my_post['post_type'] = 'listfoliopro_message';
				$my_post['post_status']='private';												
				$newpost_id= wp_insert_post( $my_post );
				update_post_meta($newpost_id,'user_to', $userid_to );
				update_post_meta($newpost_id,'dir_url', $dir_title );				
				update_post_meta($newpost_id,'from_email',sanitize_email($form_data['email_address']) );
				if(isset($form_data['name'])){
					update_post_meta($newpost_id,'from_name', sanitize_text_field($form_data['name']) );
				}
				update_post_meta($newpost_id,'from_phone', sanitize_text_field($form_data['visitorphone']) );
				include( listfoliopro_ep_ABSPATH. 'inc/message-mail.php');
				echo wp_json_encode(array("msg" => esc_html__( 'Message Sent', 'listfoliopro' )));
				exit(0);
			}
			public function listfoliopro_claim_send(){
				if ( ! wp_verify_nonce(  sanitize_text_field($_POST['_wpnonce']), 'listing' ) ) {
					wp_die( 'Are you cheating:wpnonce?' );
				}
				parse_str($_POST['form_data'], $form_data);					
				include( listfoliopro_ep_ABSPATH. 'inc/claim-mail.php');
				echo wp_json_encode(array("msg" => esc_html__( 'Message Sent', 'listfoliopro' )));
				exit(0);
			}
			public function check_listing_expire_date($listin_id, $owner_id,$listfoliopro_directory_url){
				$listing_hide=get_option('listfoliopro_listing_hide_opt');
				if($listing_hide==""){$listing_hide='package';}			
				if($listing_hide=='package'){
					$exp_date= get_user_meta($owner_id, 'listfoliopro_exprie_date', true);
					if($exp_date!=''){
						$package_id=get_user_meta($owner_id,'listfoliopro_package_id',true);
						$dir_hide= get_post_meta($package_id, 'listfoliopro_package_hide_exp', true);
						if($dir_hide=='yes'){
							if(strtotime($exp_date) < time()){
								$dir_post = array();
								$dir_post['ID'] = $listin_id;
								$dir_post['post_status'] = 'draft';	
								$dir_post['post_type'] = $listfoliopro_directory_url;
								wp_update_post( $dir_post );
							}
						}
						$have_package_feature= get_post_meta($package_id,'listfoliopro_package_feature',true);
						if($have_package_feature=='yes'){
							if(strtotime($exp_date) < time()){
								update_post_meta($listin_id, 'listfoliopro_featured', 'no' );
							}	
						}
					}
				}
				if($listing_hide=='deadline'){
					$deadline= get_post_meta($listin_id, 'deadline', true);		
					$current_time= strtotime(gmdate("Y-m-d"));							
					if(strtotime($deadline) < $current_time){ 
						$dir_post = array();
						$dir_post['ID'] = $listin_id;
						$dir_post['post_status'] = 'draft';	
						$dir_post['post_type'] = $listfoliopro_directory_url;
						wp_update_post( $dir_post );
						$have_package_feature= get_post_meta($package_id,'listfoliopro_package_feature',true);
						if($have_package_feature=='yes'){
							if(strtotime($exp_date) < time()){
								update_post_meta($listin_id, 'listfoliopro_featured', 'no' );
							}	
						}						
					}
				}
			}
			public function paging() {
				global $wp_query;
			} 
		}
	}
	if(!class_exists('WP_GeoQuery'))
	{
		/**
			* Extends WP_Query to do geographic searches
		*/
		class WP_GeoQuery extends WP_Query
		{
			private $_search_latitude = NULL;
			private $_search_longitude = NULL;
			private $_search_distance = NULL;
			private $_search_postcats = NULL;
			/**
				* Constructor - adds necessary filters to extend Query hooks
			*/
			public function __construct($args = array())
			{
				$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
				if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
				// Extract Latitude
				if(!empty($args['lat']))
				{
					$this->_search_latitude = $args['lat'];
				}
				// Extract Longitude
				if(!empty($args['lng']))
				{
					$this->_search_longitude = $args['lng'];
				}
				if(!empty($args['distance']))
				{
					$this->_search_distance = (int)$args['distance'];
				}
				if(!empty($args[$listfoliopro_directory_url.'-category']))
				{
					$this->_search_postcats= $args[$listfoliopro_directory_url.'-category'];
				}
				if(!empty($args[$listfoliopro_directory_url.'-tag']))
				{
					$this->_search_posttags= $args[$listfoliopro_directory_url.'-tag'];
				}
				if(!empty($args[$listfoliopro_directory_url.'-locations']))
				{
					$this->_search_postlocations= $args[$listfoliopro_directory_url.'-locations'];
				}
				// unset lat/lng
				unset($args['lat'], $args['lng'],$args['distance']);
				add_filter('posts_fields', array($this, 'listfoliopro_posts_fields'), 10, 2);
				add_filter('posts_join', array($this, 'listfoliopro_posts_join'), 10, 2);
				add_filter('posts_where', array($this, 'listfoliopro_posts_where'), 10, 2);
				add_filter('posts_groupby', array($this, 'listfoliopro_posts_groupby'), 10, 2);
				add_filter('posts_orderby', array($this, 'listfoliopro_posts_orderby'), 10, 2);
				parent::query($args);
				remove_filter('posts_fields', array($this, 'listfoliopro_posts_fields'));
				remove_filter('posts_join', array($this, 'listfoliopro_posts_join'));
				remove_filter('posts_where', array($this, 'listfoliopro_posts_where'));
				remove_filter('posts_groupby', array($this, 'listfoliopro_posts_groupby'));
				remove_filter('posts_orderby', array($this, 'listfoliopro_posts_orderby'));
			} // END public function __construct($args = array())
			/**
				* Selects the distance from a haversine formula
			*/
			public function listfoliopro_posts_groupby($where) {
				global $wpdb;
				if($this->_search_longitude!=""){
					if($this->_search_postcats!=""){
						$where .= $wpdb->prepare(" HAVING distance < %d ", $this->_search_distance);
						}else{
						$where = $wpdb->prepare("{$wpdb->posts}.ID  HAVING distance < %d ", $this->_search_distance);
					}
					if($this->_search_posttags!=""){
						$where .= $wpdb->prepare(" HAVING distance < %d ", $this->_search_distance);
						}else{
						$where = $wpdb->prepare("{$wpdb->posts}.ID  HAVING distance < %d ", $this->_search_distance);
					}
					if($this->_search_postlocations!=""){
						$where .= $wpdb->prepare(" HAVING distance < %d ", $this->_search_distance);
						}else{
						$where = $wpdb->prepare("{$wpdb->posts}.ID  HAVING distance < %d ", $this->_search_distance);
					}
				}
				if($this->_search_postcats!=""){
				}
				return $where;
			}
			public function listfoliopro_posts_fields($fields)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude))
				{
					$dir_search_redius=get_option('listfoliopro_map_radius');
					$for_option_redius='6387.7';
					if($dir_search_redius=="Mile"){$for_option_redius='3959';}else{$for_option_redius='6387.7'; }
					$fields .= sprintf(", ( ".$for_option_redius."* acos(
					cos( radians(%s) ) *
					cos( radians( latitude.meta_value ) ) *
					cos( radians( longitude.meta_value ) - radians(%s) ) +
					sin( radians(%s) ) *
					sin( radians( latitude.meta_value ) )
					) ) AS distance ", $this->_search_latitude, $this->_search_longitude, $this->_search_latitude);
					$fields .= ", latitude.meta_value AS latitude ";
					$fields .= ", longitude.meta_value AS longitude ";
				}
				return $fields;
			} // END public function posts_join($join, $query)
			/**
				* Makes joins as necessary in order to select lat/long metadata
			*/
			public function listfoliopro_posts_join($join, $query)
			{
				global $wpdb;
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$join .= " INNER JOIN {$wpdb->postmeta} AS latitude ON {$wpdb->posts}.ID = latitude.post_id ";
					$join .= " INNER JOIN {$wpdb->postmeta} AS longitude ON {$wpdb->posts}.ID = longitude.post_id ";
				}
				return $join;
			} // END public function posts_join($join, $query)
			/**
				* Adds where clauses to compliment joins
			*/
			public function listfoliopro_posts_where($where)
			{
				if(!empty($this->_search_latitude) && !empty($this->_search_longitude)){
					$where .= ' AND latitude.meta_key="latitude" ';
					$where .= ' AND longitude.meta_key="longitude" ';
				}
				return $where;
			} // END public function posts_where($where)
			/**
				* Adds where clauses to compliment joins
			*/
			public function listfoliopro_posts_orderby($orderby)
			{
				if(!empty($this->_search_latitude) && !empty($this->_search_distance))
				{
					$orderby = " distance ASC, " . $orderby;
				}
				return $orderby;
			} // END public function posts_orderby($orderby)
		}
	}
	/*
		* Creates a new instance of the BoilerPlate Class
	*/
	function listfolioproBootstrap() {
		return listfoliopro_eplugins::instance();
	}
listfolioproBootstrap(); ?>
