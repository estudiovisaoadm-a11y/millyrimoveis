<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	get_header(); 
	
$listfoliopro_archive_style=get_option('listfoliopro_archive_style');
if($listfoliopro_archive_style==""){$listfoliopro_archive_style='rounded';}

if($listfoliopro_archive_style=='rounded'){
	echo do_shortcode('[listfoliopro_archive_grid_rounded]');
}else{
	echo do_shortcode('[listfoliopro_archive_grid_square]');
}	
get_footer();
 ?>
