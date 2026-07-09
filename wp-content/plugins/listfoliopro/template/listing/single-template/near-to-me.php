<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<div class="text-content  mt-3 ">
	<?php
	
	if ( is_array( $facilities ) ) {
	echo '<ul class="list-style-custom-field row mb-2">';
		$i=1;
		foreach($facilities as $key => $item){	
			$facilities_one = explode("|", $item);	
				echo '<li class="col-12 col-md-6 col-lg-6  mt-2 d-flex justify-content-between">';
			echo '<span class="text-left">' . esc_html($key) . esc_html__(' : ', 'listfoliopro') . '</span>';
			echo '<span class="text-right">' . esc_html($facilities_one[0]) . '</span>';
			echo '</li>';
			$i++;
		}
	echo '</ul>';
	}
	?>
</div>
