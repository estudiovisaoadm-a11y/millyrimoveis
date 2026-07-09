<?php
$sticky_header    = listihub_option( 'sticky_header', true );
?>

<div class="menu-area-wrapper" <?php if($sticky_header == true ){echo 'data-uk-sticky="top: 250; animation: uk-animation-slide-top;"';} ?>>
    <div class="main-menu-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-sm-3 col-6">
                    <?php get_template_part( 'template-parts/header/header-logo' ); ?>
                </div>

                <div class="col-lg-10 col-sm-9 col-6">
                    <div class="header-nav-and-buttons">
                        <div class="header-navigation-area">
                            <?php get_template_part( 'template-parts/header/header-menu' );?>
                        </div>

                        <div class="header-buttons-area">
                            <ul class="header-buttons-wrapper ep-list-style">
                                <li class="mobile-menu-trigger"><span></span><span></span><span></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

