<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * listihub Admin Pages
 *
 */
if ( ! class_exists( 'listihub_Admin' ) ) {

  class listihub_Admin{
    private static $instance = null;

    public static function init() {
      if( is_null( self::$instance ) ) {
        self::$instance = new self();
      }
      return self::$instance;
    }

    public function __construct() {

      add_action( 'init', array( $this, 'listihub_create_tgmpa_page' ), 1 );
      add_action( 'admin_menu', array( $this, 'listihub_create_admin_page' ), 1 );
      add_action( 'admin_enqueue_scripts', array( $this, 'listihub_admin_page_enqueue_scripts' ) );
      
      add_filter( 'ocdi/plugin_page_setup', array( $this, 'listihub_pt_ocdi_page_setup' ) );
    
    }

    public function listihub_create_admin_page() {
      add_menu_page( esc_html__( 'listihub', 'listihub' ), esc_html__( 'listihub', 'listihub' ), 'manage_options', 'listihub', array( $this, 'listihub_admin_page_dashboard' ), 'dashicons-screenoptions', 2 );
      add_submenu_page( 'listihub', esc_html__( 'Welcome', 'listihub' ), esc_html__( 'Welcome & Support', 'listihub' ), 'manage_options', 'listihub', array( $this, 'listihub_admin_page_dashboard' ) );
    }

    public function listihub_admin_page_dashboard() {
      require_once LISTIHUB_INC_DIR .'admin/page-dashboard.php';
    }

    public function listihub_create_tgmpa_page() {
      require_once LISTIHUB_INC_DIR .'admin/class-tgm-plugin-activation.php';
      require_once LISTIHUB_INC_DIR .'admin/page-tgmpa.php';
    }

    public function listihub_admin_page_enqueue_scripts() {
      wp_enqueue_style( 'listihub-admin', get_theme_file_uri( 'inc/admin/assets/css/admin.css' ), array(), LISTIHUB_VERSION, 'all' );
    }

    public function listihub_pt_ocdi_page_setup( $args ) {

      $args['parent_slug'] = 'listihub';
      $args['menu_slug']   = 'listihub-import-demo';
      $args['menu_title']  = esc_html__( 'Import Demo', 'listihub' );
      $args['capability']  = 'manage_options';

      return $args;

    }

  }

  listihub_Admin::init();
}