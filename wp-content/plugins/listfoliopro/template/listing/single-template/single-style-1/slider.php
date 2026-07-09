<?php
	 if ( ! defined( 'ABSPATH' ) ) exit;
	wp_enqueue_style('flickity.min', listfoliopro_ep_URLPATH . 'admin/files/css/flickity.min.css');
	wp_enqueue_style('hero-top-slider', listfoliopro_ep_URLPATH . 'admin/files/css/hero-top-slider.css');
	
	
	wp_enqueue_script('flickity.pkgd.min',listfoliopro_ep_URLPATH . 'admin/files/js/flickity.pkgd.min.js');
	wp_enqueue_script('hero-top-slider',listfoliopro_ep_URLPATH . 'admin/files/js/hero-top-slider.js');
	
?>

<section class="eplistingcarousel" aria-label="hero banner eplistingcarousel">  

  <!-- Pause/resume button -->
  <button class="rotation-button is-control">
    <span class="pause-container is-visible">
      <span class="icon fas fa-pause" aria-hidden="true"></span>
      <span class="sr-only"><?php  esc_html_e('Pause slide rotation', 'listfoliopro' ); ?></span>
    </span>

    <span class="resume-container">
      <span class="icon fas fa-play" aria-hidden="true"></span>
      <span class="sr-only"><?php  esc_html_e('Resume slide rotation', 'listfoliopro' ); ?></span>
    </span>
  </button>

  <!-- Previous button -->
  <button class="previous-button is-control">
    <span class="fas fa-angle-left" aria-hidden="true"></span>
    <span class="sr-only"><?php  esc_html_e('Previous slide', 'listfoliopro' ); ?></span>
  </button>

  <!-- Slide content -->
  <div class="eplistingslides"> 
		<?php
		 $gallery_ids=get_post_meta($listingid ,'image_gallery_ids',true);
		$gallery_ids_array = array_filter(explode(",", $gallery_ids));
		$i=1;
		if(count($gallery_ids_array)>0){
			foreach($gallery_ids_array as $slide){
				if($slide!=''){ ?>				
					<div class="slide" role="group">				 
					  <img src="<?php echo wp_get_attachment_url( $slide ); ?>" class="background-image">
					 </div>
		 
				
				<?php
					$i++;
				}
			}
		}
		?>

  
  </div>
  <!-- Next button -->
  <button class="next-button is-control">
    <span class="fas fa-angle-right" aria-hidden="true"></span>
    <span class="sr-only"><?php  esc_html_e('Next slide', 'listfoliopro' ); ?></span>
  </button>
  <!-- Slide dots -->
  <ul class="navigation"></ul>
</section>
<a href="#" class="credits" ></a>



