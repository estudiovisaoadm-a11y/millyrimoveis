<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
?>

	<?php
	
echo '<ul class=" list-style row">';
foreach ($tag_array as $one_tag) {  ?>	 
	<?php
    echo '<li class="col-12 col-md-6 col-lg-4"> <a href="'.esc_url(get_tag_link($one_tag->term_id)).'">' . esc_html($one_tag->name) . '</a></li>';
	?>	
<?php	
}
echo '</ul>';	
?>


