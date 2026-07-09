<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Post Share
 */

require_once ('post-share.php');

/*
 * Hide Meta Box On Blog & WooCommerce page
 */

if ( ! function_exists( 'listihub_hide_metabox' ) ) {
	function listihub_hide_metabox() {

		global $post, $post_type;

		if( class_exists( 'WooCommerce' ) && is_object( $post ) && $post_type === 'page' ) {
			$exclude   = array();
			$exclude[] = get_option( 'woocommerce_shop_page_id' );
			$exclude[] = get_option( 'woocommerce_cart_page_id' );
			$exclude[] = get_option( 'woocommerce_checkout_page_id' );
			$exclude[] = get_option( 'woocommerce_myaccount_page_id' );
			$exclude[] = get_option( 'page_for_posts' );
			$exclude[] = get_option( 'wishlist_page_id' );
			if( in_array( $post->ID, $exclude ) ) {
				echo '<style type="text/css">';
				echo '#listihub_common_meta{ display: none !important; }';
				echo '</style>';
			}
		}else{
			if(is_object( $post ) && $post_type === 'page'){
				$exclude   = array();
				$exclude[] = get_option( 'page_for_posts' );
				if( in_array( $post->ID, $exclude ) ) {
					echo '<style type="text/css">';
					echo '#listihub_common_meta{ display: none !important; }';
					echo '</style>';
				}
			}
		}

		echo '<style type="text/css">';
		echo '
		.elementor-editor-active .edit-post-visual-editor .block-editor-writing-flow__click-redirect{min-height:5vh}
		';
		echo '</style>';

	}

	add_action( 'admin_head', 'listihub_hide_metabox' );
}