<?php
$sticky_header    = listihub_option( 'sticky_header', true );
?>

<div class="menu-area-wrapper" <?php if($sticky_header == true ){echo 'data-uk-sticky="top: 250; animation: uk-animation-slide-top;"';} ?>>
    <div class="main-menu-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5">
                    <div class="header-nav-and-buttons">
                        <div class="header-navigation-area">
			                <?php get_template_part( 'template-parts/header/header-menu' );?>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-6">
	                <?php get_template_part( 'template-parts/header/header-logo' ); ?>
                </div>

                <div class="col-xl-5 col-lg-10 col-6">
                    <div class="header-nav-and-buttons">
		                <?php get_template_part( 'template-parts/header/header-buttons' );?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-four-border">
        <img src="<?php echo esc_url(get_theme_file_uri()).'/assets/images/header-four-line.svg';?>" alt="header-border">
    </div>
</div>

