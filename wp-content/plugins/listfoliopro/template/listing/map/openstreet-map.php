<?php	
 if ( ! defined( 'ABSPATH' ) ) exit; 
wp_enqueue_script('leaflet-script', listfoliopro_ep_URLPATH .'admin/files/js/leaflet.js');
	
wp_enqueue_script('leaflet-markercluster', listfoliopro_ep_URLPATH . 'admin/files/js/leaflet.markercluster.js');
wp_enqueue_style('leaflet', listfoliopro_ep_URLPATH . 'admin/files/css/leaflet.css');

	$top_image =( isset($active_archive_fields['image'])?'yes':'no' );
	
	$listfoliopro_infobox_image=get_option('listfoliopro_infobox_image');	
	if($listfoliopro_infobox_image==""){$listfoliopro_infobox_image=$top_image;}	
	if($listfoliopro_infobox_image=='yes'){
		$top_image='yes';	
	}
	$listfoliopro_infobox_title=get_option('listfoliopro_infobox_title');	
	if($listfoliopro_infobox_title==""){$listfoliopro_infobox_title='yes';}	
	$listfoliopro_infobox_location=get_option('listfoliopro_infobox_location');	
	if($listfoliopro_infobox_location==""){$listfoliopro_infobox_location='yes';}	
	$listfoliopro_infobox_direction=get_option('listfoliopro_infobox_direction');	
	if($listfoliopro_infobox_direction==""){$listfoliopro_infobox_direction='yes';}	
	$listfoliopro_infobox_linkdetail=get_option('listfoliopro_infobox_linkdetail');	
	if($listfoliopro_infobox_linkdetail==""){$listfoliopro_infobox_linkdetail='yes';}	
	
	 $listfoliopro_forcelocation=get_option('listfoliopro_forcelocation');	
	if($listfoliopro_forcelocation=='forcelocation'){
		$ins_lat=get_option('listfoliopro_defaultlatitude');
		$ins_lng=get_option('listfoliopro_defaultlongitude');
	}	

	wp_enqueue_style('listfoliopro-openstreet', listfoliopro_ep_URLPATH . 'admin/files/css/openstreet-map.css');	
	wp_enqueue_script('listfoliopro-openstreet-map', listfoliopro_ep_URLPATH . 'admin/files/js/openstreet-map.js');
	wp_localize_script('listfoliopro-openstreet-map', 'listfoliopro_map_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'listfoliopro' ),
	'Add_to_Favorites'=>esc_html__('Add to Favorites', 'listfoliopro' ),
	'direction_text'=>esc_html__('Direction', 'listfoliopro' ),
	'marker_icon'=> '',
	'top_image'=> $top_image,
	'infotitle'=>$listfoliopro_infobox_title,
	'infolocation'=>$listfoliopro_infobox_location,
	'indirection'=>$listfoliopro_infobox_direction,
	'infolinkdetail'=> $listfoliopro_infobox_linkdetail,
	'ins_lat'=> $ins_lat,
	'ins_lng'=> $ins_lng,
	'dir_map_zoom'=>$dir_map_zoom,
	'dirs_json'=>$dirs_json_map,	
	) );

?>

  