<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	wp_enqueue_style('listfoliopro_faqs', listfoliopro_ep_URLPATH . 'admin/files/css/faqs.css');
?>

<div class=" row    mb-4 "> 
 <ul class="accordionFAQ faqul col-md-12 ">	
	<?php
	$faq_i=0;
		$listingid = (isset($listingid)?$listingid: '0' );
		for($i=0;$i<20;$i++){
			if(get_post_meta($listingid,'faq_title'.$i,true)!='' || get_post_meta($listingid,'faq_description'.$i,true) ){?>
				  <li class="item">
					<h2 class="accordionTitle <?php if ($i==0){echo 'accordionTitleActive';}?>"><?php echo esc_attr(get_post_meta($listingid,'faq_title'.$i,true)); ?><span class="accIcon"></span></h2>
					 <div class="text <?php if ($i==0){echo 'show';}?>"><?php echo esc_attr(get_post_meta($listingid,'faq_description'.$i,true)); ?> </div>
				  </li>								
			<?php							
			}
		}				
	?>
	</ul>
</div>


