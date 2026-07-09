<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package listihub
 */

get_header();

$error_banner      = listihub_option('error_banner', true);
$error_banner_title = listihub_option('error_page_title');
$banner_text_align = listihub_option('banner_default_text_align', 'center');
$not_found_text     = listihub_option('not_found_text');
$go_back_home       = listihub_option('go_back_home', true);
$error_image = listihub_option('error_image', '');

?>

<?php if($error_banner == true) : ?>
    <div class="banner-area error-page-banner">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="banner-content text-<?php echo esc_attr( $banner_text_align ); ?>">
                        <h2 class="banner-title">
							<?php echo esc_html($error_banner_title); ?>
                        </h2>

						<?php if ( function_exists( 'bcn_display' ) ) :?>
                            <div class="breadcrumb-container">
								<?php bcn_display();?>
                            </div>
						<?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


    <div id="primary" class="content-area not-found-content">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="ep-404-text">
                        <?php if (!empty($error_image['url'])) : ?>
                            <img src="<?php echo esc_url($error_image['url']); ?>" alt="<?php echo esc_attr($error_image['alt']); ?>">
                        <?php else : ?>
                            <div class="text-404"><?php echo esc_html__('404', 'listihub') ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="error-content-text">
		                <?php
		                echo wp_kses( $not_found_text, listihub_allow_html() );
		                ?>
                    </div>

	                <?php if ($go_back_home == true) : ?>
                        <div class="go-back-button">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="ep-button"><?php echo esc_html__('Go Back Home', 'listihub') ?><i class="flaticon-double-right-arrow"></i></a>
                        </div>
	                <?php endif; ?>
                </div>
            </div>
        </div>
    </div><!-- #primary -->

<?php
get_footer();