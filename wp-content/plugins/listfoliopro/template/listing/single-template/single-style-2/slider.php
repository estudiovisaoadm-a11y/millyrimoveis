<?php
	 if ( ! defined( 'ABSPATH' ) ) exit;
	wp_enqueue_style('flexslider', listfoliopro_ep_URLPATH . 'admin/files/css/flexslider.css');
	wp_enqueue_style('slickslider', listfoliopro_ep_URLPATH . 'admin/files/css/slick/slick.css');

    $gallery_ids=get_post_meta($listingid ,'image_gallery_ids',true);
    $gallery_ids_array = array_filter(explode(",", $gallery_ids));
	if(count($gallery_ids_array)>0){
	
?>

	<div class="container-fluid">
        <div class="row mt-2">
            <!-- Column with big image -->
            <div class="col-md-7 mb-3">
				 <?php foreach($gallery_ids_array as $slide): ?>
						<div class="img-container big-image" style="background-image: url('<?php echo esc_url(wp_get_attachment_url($slide)); ?>');">
							<a class="d-block" data-fancybox="gallery" href="<?php echo wp_get_attachment_url( $slide ); ?>">
								<div class="img-fancy-btn fw-500 fs-16 color-dark" bis_skin_checked="1"><?php  esc_html_e('Sell all ','listfoliopro'); ?><?php echo esc_html( count($gallery_ids_array)); ?> <?php  esc_html_e(' Photos','listfoliopro'); ?>
									<span class="d-block ">
										<?php
										foreach($gallery_ids_array as $slide_sub): ?>
										<a class="display-block " data-fancybox="gallery" href="<?php echo wp_get_attachment_url( $slide_sub ); ?>"></a>
										<?php
										endforeach; ?>
									</span>	
								</div>
							</a>
						</div>
				<?php	break;
						endforeach; ?>
						
            </div>
            <!-- Column with four smaller images -->
            <div class="col-md-5">
                <div class="row small-image">
				<?php 
					$i=0; $ii=0;
					foreach($gallery_ids_array as $slide): 
						if($i>0){
						?>
						
						<div class="col-6 <?php echo ($ii<3 ? 'mb-25':'');?> ">
							<a data-fancybox="gallery2" href="<?php echo wp_get_attachment_url( $slide ); ?>">
							<div class="img-container" style="background-image: url('<?php echo esc_url(wp_get_attachment_url($slide)); ?>');">
							</div>
							</a>
						</div>
						
						<?php
						}
						if($i==4){
							break;
						}
						$i++;	$ii++;	
						endforeach; ?>
						
                  
                </div>
            </div>
       
	   </div>
    </div>
	<div class="clearfix "></div>	



<?php
	}
wp_enqueue_script('jquery.slickslider', listfoliopro_ep_URLPATH . 'admin/files/css/slick/slick.min.js');
wp_enqueue_script('jquery.flexslider', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.flexslider.js');
wp_enqueue_script('jquery.easing', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.easing.js"');
wp_enqueue_script('jquery.mousewheel', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.mousewheel.js"');
wp_enqueue_script('listfoliopro-single-listing-flexslider', listfoliopro_ep_URLPATH . 'admin/files/js/flexslider-single-listing.js"');
?>