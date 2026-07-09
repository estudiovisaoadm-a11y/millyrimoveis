<?php
	 if ( ! defined( 'ABSPATH' ) ) exit;
	wp_enqueue_style('flexslider', listfoliopro_ep_URLPATH . 'admin/files/css/flexslider.css');
	wp_enqueue_style('slickslider', listfoliopro_ep_URLPATH . 'admin/files/css/slick/slick.css');

    $gallery_ids=get_post_meta($listingid ,'image_gallery_ids',true);
    $gallery_ids_array = array_filter(explode(",", $gallery_ids));
?>


<div class="bootstrap-wrapper">
	
<div class="container-fluid">
        <div class="row">
            <!-- Column with big image -->
            <div class="col-md-7 mb-3">
                <div class="img-container big-image" style="background-image: url('http://localhost/listfoliopro/wp-content/uploads/2024/05/ezgif.com-webp-to-jpg-converter-2.jpg');">
                </div>
            </div>
            <!-- Column with four smaller images -->
            <div class="col-md-5">
                <div class="row small-image">
                    <div class="col-6 mb-25">
                        <div class="img-container" style="background-image: url('http://localhost/listfoliopro/wp-content/uploads/2024/05/ezgif.com-webp-to-jpg-converter-1.jpg');">
                        </div>
                    </div>
                    <div class="col-6 mb-25">
                        <div class="img-container" style="background-image: url('http://localhost/listfoliopro/wp-content/uploads/2024/05/ezgif.com-webp-to-jpg-converter-3.jpg');">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="img-container" style="background-image: url('https://via.placeholder.com/200');">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="img-container" style="background-image: url('https://via.placeholder.com/200');">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	


  <div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div id="listfoliopro-listing-details-slider" class="listfoliopro-listing-details-slider">
                <?php foreach($gallery_ids_array as $slide): ?>
                    <?php if($slide!=''): ?>
                        <div class="listfoliopro-listing-details-slider-item" style="background-image: url(<?php echo esc_url(wp_get_attachment_url($slide)); ?>)"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div id="listfoliopro-listing-slider-nav" class="listfoliopro-listing-slider-nav">
                <?php foreach($gallery_ids_array as $slide): ?>
                    <?php if($slide!=''): ?>
                        <div class="listfoliopro-listing-slider-nav-item" style="background-image: url(<?php echo esc_url(wp_get_attachment_url($slide)); ?>)"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

 </div>


<?php
wp_enqueue_script('jquery.slickslider', listfoliopro_ep_URLPATH . 'admin/files/css/slick/slick.min.js');
wp_enqueue_script('jquery.flexslider', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.flexslider.js');
wp_enqueue_script('jquery.easing', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.easing.js"');
wp_enqueue_script('jquery.mousewheel', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.mousewheel.js"');
wp_enqueue_script('listfoliopro-single-listing-flexslider', listfoliopro_ep_URLPATH . 'admin/files/js/flexslider-single-listing.js"');
?>