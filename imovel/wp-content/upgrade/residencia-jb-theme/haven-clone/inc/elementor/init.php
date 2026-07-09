<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Haven_Elementor_Extensions {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        // Register Category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
        // Init Widgets
        add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );
    }

    public function add_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'haven-widgets',
            [
                'title' => '🏡 Residência JB (Premium)',
                'icon'  => 'fa fa-home',
            ]
        );
    }

    public function init_widgets() {
        require_once( __DIR__ . '/widgets.php' );

        \Elementor\Plugin::instance()->widgets_manager->register( new \Haven_Hero_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new \Haven_Stats_Widget() );
        \Elementor\Plugin::instance()->widgets_manager->register( new \Haven_Carousel_Widget() );
    }
}

// Instantiate the class logic
add_action( 'plugins_loaded', function() {
    // Check if Elementor exists
    if ( did_action( 'elementor/loaded' ) ) {
        Haven_Elementor_Extensions::instance();
    }
});
