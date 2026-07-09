<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package listihub
 */
if ( is_page() || is_singular( 'post' ) || listihub_custom_post_types() && get_post_meta( $post->ID, 'listihub_common_meta', true ) ) {
	$common_meta = get_post_meta( $post->ID, 'listihub_common_meta', true );
} else {
	$common_meta = array();
}

if ( is_array( $common_meta ) && array_key_exists( 'footer_style_meta', $common_meta ) && $common_meta['footer_style_meta'] != 'default' ) {
	$footer_style = $common_meta['footer_style_meta'];
} else {
	$footer_style = listihub_option('site_default_footer', 'footer-style-one');
}

$enable_footer_cta = listihub_option('enable_footer_cta', false);

$go_to_top = listihub_option('go_to_top_button', false);
?>

</div><!-- #content -->

<footer class="site-footer <?php echo esc_attr($footer_style);?>">
	<?php
        if($enable_footer_cta == true){
	        if($footer_style == 'footer-style-one'){
		       
	        }elseif($footer_style == 'footer-style-two'){
		        get_template_part( 'template-parts/footer/footer-cta-two');
	        } elseif($footer_style == 'footer-style-three'){
				get_template_part( 'template-parts/footer/footer-cta-three');
			}
        }


        get_template_part( 'template-parts/footer/footer-widgets' );
        get_template_part( 'template-parts/footer/footer-bottom' );
    ?>

	<?php if($go_to_top == true) : ?>
        <div class="scroll-to-top"><i class="fas fa-angle-double-up"></i></div>
	<?php endif;?>
</footer><!-- #colophon -->


</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>