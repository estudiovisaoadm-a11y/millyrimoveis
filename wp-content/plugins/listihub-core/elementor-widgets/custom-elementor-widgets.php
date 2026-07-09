<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hijobs_elementor_version( $operator = '<', $version = '2.6.0' ) {
	return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

function hijobs_custom_icon_render( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
	// Check if its already migrated
	$migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
	// Check if its a new widget without previously selected icon using the old Icon control
	$is_new = empty( $settings[ $old_icon_id ] );

	$attributes['aria-hidden'] = 'true';

	if ( hijobs_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
		\Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
	} else {
		if ( empty( $attributes['class'] ) ) {
			$attributes['class'] = $settings[ $old_icon_id ];
		} else {
			if ( is_array( $attributes['class'] ) ) {
				$attributes['class'][] = $settings[ $old_icon_id ];
			} else {
				$attributes['class'] .= ' ' . $settings[ $old_icon_id ];
			}
		}
		printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
	}
}

class hijobs_Elementor_Scripts {

	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'hijobs_core_register_scripts' ) );
	}

	public function hijobs_core_register_scripts() {
		wp_register_script( 'counterup', plugins_url( '/', __FILE__ ) . 'assets/js/counterup.min.js', array( 'jquery' ), '1.0', true );
	}
}

new hijobs_Elementor_Scripts();

class hijobs_Elementor_Custom_Widget {

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function hijobs_add_elementor_custom_widgets() {
		require_once( 'accordion-two-widget.php' );
		require_once( 'accordion-widget.php' );
		require_once( 'brand-image-widget.php' );
		require_once( 'button-widget.php' );
		require_once( 'counter-up-widget.php' );
		require_once( 'cta-widget.php' );
		require_once( 'cta-two-widget.php' );
		require_once( 'cta-three-widget.php' );
		require_once( 'contact-info-widget.php' );
		require_once( 'candidate-directory-widget.php' );
		require_once( 'contact-form-7-widget.php' );
		require_once( 'employer-directory-widget.php' );
		require_once( 'employer-profile-widget.php' );
		require_once( 'hijobs-images-one-widget.php' );
		require_once( 'hijobs-image-two-widget.php' );
		require_once( 'home-banner-one-widget.php' );
		require_once( 'home-banner-two-widget.php' );
		require_once( 'how-it-works-widget.php' );
		require_once( 'icon-box-one-widget.php' );
		require_once( 'job-banner-image.php' );
		require_once( 'job-category-widget.php' );
		require_once( 'job-description-tab.php' );
		require_once( 'job-grid-wiew-widget.php' );
		require_once( 'job-of-the-day-widget.php' );
		require_once( 'job-photo-gallery-widget.php' );
		require_once( 'job-post-filter-widget.php' );
		require_once( 'job-short-details-widget.php' );
		require_once( 'jobs-by-location-widget.php' );
		require_once( 'pricing-table-widget.php' );
		require_once( 'recent-job-widget.php' );
		require_once( 'related-jobs-widget.php' );
		require_once( 'recent-posts-widget.php' );
		require_once( 'section-title-widget.php' );
		require_once( 'team-member-widget.php' );
		require_once( 'testimonials-widgets.php' );
		require_once( 'text-button-widget.php' );
		require_once( 'video-popup-widget.php' );
		require_once( 'why-choose-us-widget.php' );
	}

	public function init() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'hijobs_add_elementor_custom_widgets' ) );
	}
}

hijobs_Elementor_Custom_Widget::get_instance()->init();

// Add New Category In Elementor Widget

function hijobs_elementor_widget_categories( $elements_manager ) {

	$elements_manager->add_category(
		'hijobs_elements',
		[
			'title' => __( 'HiJobs Elements', 'hijobs-core' ),
		]
	);

}

add_action( 'elementor/elements/categories_registered', 'hijobs_elementor_widget_categories' );