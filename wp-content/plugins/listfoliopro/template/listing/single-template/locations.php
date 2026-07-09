<?php
if (!defined('ABSPATH')) exit;

?>
<i class="fa-solid fa-location-dot"></i>
<?php


$i = 0;
foreach ($tag_array as $one_tag) {
	$locations .= '<a href="' . get_tag_link($one_tag->term_id) . '">' . esc_attr($one_tag->name) . '</a>';

	// Add a comma after each location, except for the last one
	if ($i < count($tag_array) - 1) {
		$locations .= ', ';
	}

	$i++;
}

echo  wp_kses( $locations,$allowed_html ); // Output the locations with commas
?>
	