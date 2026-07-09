<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package listihub
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php
	if (is_page() || is_singular( 'post' ) || listihub_custom_post_types() && get_post_meta( $post->ID, 'listihub_common_meta', true ) ) {
		$common_meta = get_post_meta( $post->ID, 'listihub_common_meta', true );
	} else {
		$common_meta = array();
	}

	if ( is_array( $common_meta ) && array_key_exists( 'header_meta', $common_meta ) && $common_meta['header_meta'] != 'default' ) {
		$selected_header = $common_meta['header_meta'];
	} else {
		$selected_header = listihub_option( 'site_default_header', 'header-style-one' );
	}

	$preloader    = listihub_option( 'enable_preloader', true );

	wp_head();
	?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site <?php echo esc_attr( $selected_header);?>">
	<?php if($preloader == true) : ?>
        <!-- Preeloader -->
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
	<?php endif;?>

    <!-- Mobile Menu -->
    <div class="mobile-menu-container ep-secondary-font">
        <div class="mobile-menu-close"></div>
        <div id="mobile-menu-wrap">
		<?php
		if(is_page() || is_singular('post') || listihub_custom_post_types() && get_post_meta($post->ID, 'listihub_common_meta', true)) {
				$common_meta = get_post_meta($post->ID, 'listihub_common_meta', true);
			}else{
				$common_meta = array();
			}
				if (is_array($common_meta) && array_key_exists('main_menu_meta', $common_meta)) {
			$selected_menu = $common_meta['main_menu_meta'];
		} else  {
			$selected_menu = '';
		}
		wp_nav_menu( array(
			'menu'            => $selected_menu,
			'theme_location'  => 'main-menu',
			'menu_id'         => 'main-menu',
			'container_class' => 'main-menu-container',
		) );
		?>		
		</div>
    </div>
    <!-- Mobile Menu End -->
    <header class="header-area site-header">
	    <?php get_template_part( 'template-parts/header/' . $selected_header . '' ); ?>
    </header>

    <div id="content" class="site-content">
        