<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once ('controls/icons.php');

define( 'Property_Pro_ELEMENTOR_ASSETS', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) .'/assets/');
if (!defined('listfoliopro_ep_URLPATH'))define('listfoliopro_ep_URLPATH', trailingslashit(plugins_url() . '/' . plugin_basename(dirname(__FILE__))));

//Filter fields****
function listfoliopro_listing_filter_fields() {
	$options=null;
	$fields_top_section_all=listfoliopro_get_fields_sort_section();
	if(is_array($fields_top_section_all)){
		foreach($fields_top_section_all  as $field_key => $field_value){
			$options[ $field_key.':asc' ] = $field_key.':asc';
			$options[ $field_key.':desc' ] = $field_key.':desc';			
		}
	}	
	return $options;
}
//Archive fields****
function listfoliopro_listing_archive_fields() {
	$options=null;
	$fields_top_section_all=listfoliopro_get_fields_sort_section();
	if(is_array($fields_top_section_all)){
		foreach($fields_top_section_all  as $field_key => $field_value){
			if($field_key!='locations' AND $field_key!='title' AND $field_key!='category' AND $field_key!='tag'  ){
			$options[ $field_key ] = $field_key;
			}
		}
	}	
	return $options;
}
//Listing Category
function listfoliopro_listing_categories() {
		$options=null;
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
		if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$terms = get_terms( array(
		'taxonomy'   => $listfoliopro_directory_url.'-category',
		'hide_empty' => false,
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}
//Listing Type
function listfoliopro_listing_type() {
		$options=null;
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
		if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$terms = get_terms( array(
		'taxonomy'   => $listfoliopro_directory_url.'-type',
		'hide_empty' => false,
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}
//Post Category
function listfoloipro_post_categories() {
	$terms = get_terms( array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}

function listfoliopro_get_post_title_as_list( ) {
	$args = wp_parse_args( array(
		'post_type'   => 'post',
		'order'   => 'desc',
		'numberposts' => -1,
	) );

	$posts = get_posts( $args );

	if ( $posts ) {
		foreach ( $posts as $post ) {
			$post_options[ $post->ID ] = $post->post_title;
		}
	}

	return $post_options;
}

// Post Date
function listfoliopro_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
	/* translators: %s: post date. */
		esc_html_x( ' %s', 'post date', 'listfoliopro' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}

//Listing Locations List
function listfoliopro_listing_locations() {
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
		if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
	$terms = get_terms( array(
		'taxonomy'   => $listfoliopro_directory_url.'-locations',
		'hide_empty' => true,
	) );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$options[ $term->slug ] = $term->name;
		}
	}

	return $options;
}



class Listfoliopro_Elementor_Scripts {

	public function __construct() {
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'listfoliopro_register_scripts' ) );
	}

	public function listfoliopro_register_scripts() {
		wp_enqueue_style( 'archive-listing-2', listfoliopro_ep_URLPATH.'admin/files/css/archive-listing-grid-style-2-sharp.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'archive-listing-1', listfoliopro_ep_URLPATH.'admin/files/css/archive-listing-grid-style-1.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'iv-bootstrap', listfoliopro_ep_URLPATH.'admin/files/css/iv-bootstrap.css', array(), '5.0.0', 'all' );
		wp_enqueue_style( 'slick-slider2', listfoliopro_ep_URLPATH.'template/elementor/assets/css/slick-slider.css', array(), '1.0.0', 'all' );
		wp_enqueue_style( 'listing-elementor-widget', listfoliopro_ep_URLPATH.'admin/files/css/listing-elementor-widget.css', array('iv-bootstrap'), '1.0.0', 'all' );
		wp_enqueue_script( 'slick-slider-min', listfoliopro_ep_URLPATH.'template/elementor/assets/js/slick-slider.min.js', array( 'jquery' ), '1.0', true );
	}
}

new Listfoliopro_Elementor_Scripts();

	class listfoliopro_Elementor_Custom_Widget {
		private static $instance = null;
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		public function listfoliopro_add_elementor_custom_widgets() {
			require_once( 'accordion-widget.php' );
			require_once( 'button-widget.php' );
			require_once( 'contact-form-7-widget.php' );
			require_once( 'contact-info-widget.php' );
			require_once( 'home-banner-one-widget.php' );
			require_once( 'home-banner-two-widget.php' );
			require_once( 'how-it-works-widget.php' );
			require_once( 'listing-category-widget.php' );
			require_once( 'listing-two-widget.php' );
			require_once( 'search-widget.php' );
			require_once( 'listing-archive-rounded-widget.php' );
			require_once( 'listing-archive-square-widget.php' );
			require_once( 'listing-location-widget.php' );
			require_once( 'recent-post-widget.php' );
			require_once( 'recent-post-slider-widget.php' );
			require_once( 'section-title-one-widget.php' );
			require_once( 'section-title-two-widget.php' );
			require_once( 'team-member-one-widget.php' );
			require_once( 'testimonial-one-widget.php' );
			require_once( 'testimonial-two-widget.php' );
			require_once( 'image-one-widget.php' );
			require_once( 'icon-box-two-widget.php' );
			require_once( 'title-with-text-widget.php' );
			require_once( 'video-popup-widget.php' );
			
			
		}
		public function init() {
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'listfoliopro_add_elementor_custom_widgets' ) );
		}
	}
	listfoliopro_Elementor_Custom_Widget::get_instance()->init();
	// Add New Category In Elementor Widget
	function listfoliopro_elementor_widget_categories( $elements_manager ) {
		$elements_manager->add_category(
		'listfoliopro_elements',
		[
		'title' => esc_html__( 'ListiHub Elements', 'listfoliopro' ),		
		]
		);
	}
add_action( 'elementor/elements/categories_registered', 'listfoliopro_elementor_widget_categories' );