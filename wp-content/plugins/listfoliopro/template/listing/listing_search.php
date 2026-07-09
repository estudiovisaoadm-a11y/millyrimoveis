<?php
	 if ( ! defined( 'ABSPATH' ) ) exit;
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('nouislider.min', 			listfoliopro_ep_URLPATH . 'admin/files/css/nouislider.min.css');
	wp_enqueue_style('select2', listfoliopro_ep_URLPATH . 'admin/files/css/select2.css');
	wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');	;
	wp_enqueue_style('multiselect', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.multiselect.css');
	wp_enqueue_style('listfoliopro_search-form', listfoliopro_ep_URLPATH . 'admin/files/css/search-form.css');
	wp_enqueue_style('fontawesome', 			listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome.css');
	
	
	wp_enqueue_script('popper', listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_script('bootstrap-slider', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap-slider.min.js');
	wp_enqueue_style('bootstrap-slider.min', 			listfoliopro_ep_URLPATH . 'admin/files/css/bootstrap-slider.min.css');
	wp_enqueue_script('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('multiselect', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.multiselect.js');
	wp_enqueue_script('nouislider.min', listfoliopro_ep_URLPATH . 'admin/files/js/nouislider.min.js');
													
	// Map openstreet

global $post,$wpdb,$wp,$listfoliopro_filter_badge;
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$active_search_fields_saved=get_option('listfoliopro_search_fields_saved' );
	if($active_search_fields_saved==''){
		$active_search_fields =listfoliopro_get_search_fields_default();
		}else{
		$active_search_fields=array();
		$active_search_fields=$active_search_fields_saved;
	}
	//atts atts
	if(isset($atts['field-name'])){
		$field_name= $atts['field-name'];
		$field_type= $atts['field-type'];
		$field_name_arr= explode(",",$field_name);
		$field_type_arr= explode(",",$field_type);
		$i=0;
		$active_search_fields=array();
		foreach($field_name_arr as $one_field){
			if(isset($field_type_arr[$i])){
				$active_search_fields[$one_field]=$field_type_arr[$i];
			}
			$i++;
		}
	}
	
	$search_form_col='col-xl-3 col-lg-3 col-md-4';		
	if(isset($atts['style'])){ 		
		 $search_bar_style= $atts['style'];
		if($search_bar_style=='top-bar'){  
			$search_form_col='col-xl-3 col-lg-3 col-md-4';
		}
		if($search_bar_style=='side-bar'){  
			$search_form_col='col-xl-12 col-lg-12 col-md-12';
		}
	}else{
		$search_form_col='col-xl-3 col-lg-3 col-md-4';
	}
	
	
	$current_url =  home_url( $wp->request );
	$pos = strpos($current_url , '/page');
	$finalurl = substr($current_url,0,$pos);
	$form_action=$finalurl;
	
	if(isset($atts['action'])){
		if($atts['action']=='same_page'){  
				$current_url =  home_url( $wp->request );
				$pos = strpos($current_url , '/page');

				$finalurl = substr($current_url,0,$pos);
				$form_action=$finalurl;
		}elseif($atts['action']=='default_archive'){ 
				$form_action=get_post_type_archive_link( $listfoliopro_directory_url );		
		}else{ 
			$form_action= $atts['action'];
		}
	}
	$label_will_add=array('bed','bath','kitchen','garage');
	$custom_fileds_set=get_option('listfoliopro_li_fields' );
	if($custom_fileds_set==""){
		$custom_fileds_set=listfoliopro_default_custom_fields_with_type();
		$custom_fileds_set = $custom_fileds_set[0];
	}	
	global $atts;
?>


	<div class="bootstrap-wrapper listfoliopro-search-wrapper">
		<div class="" id="ep_search_fields_all" >
			<div class="row">
				<div class="col-md-12 form-search">
					<form class="" id="listfoliopro_search_form" name="listfoliopro_search_form" action="<?php echo esc_url($form_action) ; ?>" >
						<div class="form-row d-flex" >
							<input type="hidden" name="latitude" id="latitude" value="<?php echo (isset($_REQUEST['latitude'])? sanitize_text_field($_REQUEST['latitude']):'' ); ?>">
							<input type="hidden" name="longitude" id="longitude" value="<?php echo (isset($_REQUEST['longitude'])? $_REQUEST['longitude']:'' ); ?>">
							<input type="hidden" name="address_latitude" id="address_latitude" value="<?php echo (isset($_REQUEST['address_latitude'])? sanitize_text_field($_REQUEST['address_latitude']):'' ); ?>">
							<input type="hidden" name="address_longitude" id="address_longitude" value="<?php echo (isset($_REQUEST['address_longitude'])? sanitize_text_field($_REQUEST['address_longitude']):'' ); ?>">
							<?php
								
								if(is_array($active_search_fields)){
									foreach($active_search_fields  as $field_key => $field_value){
										
										
										if($field_key!=''){
											$dropdown_value_with_label='';
											if(in_array($field_key,$label_will_add)){
												$dropdown_value_with_label= (isset($custom_fileds_set[$field_key])? $custom_fileds_set[$field_key]:'');
											}
													
											$submit_value=(isset($_REQUEST['sf'.$field_key])? $_REQUEST['sf'.$field_key]:'' );
											 $trandlated_title= listfoliopro_text_translate($field_key);
											if($field_value=='text-field'){
												if($field_key=='address'){ ?>
												<div class="form-group <?php echo esc_html($search_form_col); ?>  ep_search_field" id="searchaddressauto">
													<div id="search-box" ></div>
													<div id="map_address"></div>
												</div>
												<?php
												}elseif($field_key=='near_to_me'){
												?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<div class="input-group">
														<label class="customcheck">
															<input type="checkbox" value="on"  name="neartome" id="neartome" onclick="listfoliopro_getLocation()"  <?php echo (isset($_REQUEST['neartome']) ? ' checked':' '); ?> >
															<span class="checkmark"></span>
															<?php  esc_html_e('Near','listfoliopro'); ?>
														</label>
														<input id="near_km" name="near_km" class=" col-md-8  "  data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="1000" data-slider-step="1" data-slider-value="14"  />
													</div>
												</div>
												<?php 
												}elseif($field_key=='price_slider'){?>
													<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field mt-4">
														 <div id="price-range-slider"></div>
														 
														<div class="row mt-3">
															<div class="col text-left">
																<label for="min-price"><?php  esc_attr_e('Min Price','listfoliopro');?></label>
																<input type="hidden" id="min-price" name="min-price" value="1000">
																</div>
															<div class="col text-right">
																<label for="max-price"><?php  esc_attr_e('Max Price','listfoliopro');?></label>
																<input type="hidden" id="max-price" name="max-price" value="500000"   >
																<input type="hidden" id="sfprice_slider" name="sfprice_slider" value="1">
															</div>
														</div>
													</div>
													
													
												
												<?php
												}else{
												?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<?php
														$placeholder = ucfirst(str_replace('_',' ',$field_key));
														if ($field_key === 'title') {
															$placeholder = esc_html__('Pesquisar....','listfoliopro');
														}
													?>
													<input type="text" class="form-control " name="sf<?php echo esc_attr($field_key); ?>" id="<?php echo esc_attr($field_key); ?>id" placeholder="<?php echo esc_attr($placeholder); ?>" value="<?php echo esc_attr($submit_value); ?>">
												</div>
												<?php
												}
											}
											if($field_value=='datefield'){ ?>
											<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
												<input type="text" class="form-control  searchdate"  name="sf<?php echo esc_attr($field_key); ?>" id="<?php echo esc_attr($field_key); ?>id" placeholder="<?php echo esc_attr(ucfirst(str_replace('_',' ',$field_key))); ?>" value="<?php echo esc_attr($submit_value); ?>">
											</div>
											<?php
											}
											if($field_value=='drop-down'){
												$cat_tag_location=  str_replace($listfoliopro_directory_url,'',$field_key);
												$cat_tag_location=  str_replace('-','',$cat_tag_location);
												if($cat_tag_location=='category' OR $cat_tag_location=='tag' OR $cat_tag_location=='locations'){
													
													$taxonomy = get_taxonomy($listfoliopro_directory_url.'-'.$cat_tag_location);
													if ($taxonomy !== false) {
														$taxonomy_labels = get_taxonomy_labels(get_taxonomy($listfoliopro_directory_url.'-'.$cat_tag_location));
														$taxonomy_label = $taxonomy_labels->singular_name;
													}else{
														$taxonomy_label =$cat_tag_location;
													}
													// Remove leading "Select" from labels
													$taxonomy_label = preg_replace('/^Select\s+/i', '', $taxonomy_label);

												?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field" >
                                                    <div class="select-arrow"></div>
													<select name="sf<?php echo esc_attr($field_key); ?>" class="form-control select2-enable" >
														<option value=""><?php echo esc_attr($taxonomy_label); ?></option>
														<?php
															$taxonomy = $field_key;
															$args = array(
															'orderby'           => 'name',
															'taxonomy'   => 	$taxonomy ,
															'order'             => 'ASC',
															'hide_empty'        => true,
															'exclude'           => array(),
															'exclude_tree'      => array(),
															'include'           => array(),
															'number'            => '',
															'fields'            => 'all',
															'slug'              => '',
															'parent'            => '0',
															'hierarchical'      => true,
															'child_of'          => 0,
															'childless'         => false,
															'get'               => '',
															);
															$terms = get_terms($args); // Get all terms of a taxonomy
															if ( $terms && !is_wp_error( $terms ) ) :
															$i=0;
															foreach ( $terms as $term_parent ) {
																$selected= ($term_parent->slug==$submit_value ?' selected':'' );
																echo '<option '.$selected.' value="'.esc_attr($term_parent->slug).'" >'.$term_parent->name.'</option>';
															?>
															<?php
																$args2 = array(
																'type'                     => $listfoliopro_directory_url,
																'parent'                   => $term_parent->term_id,
																'orderby'                  => 'name',
																'order'                    => 'ASC',
																'hide_empty'               => 1,
																'hierarchical'             => 1,
																'exclude'                  => '',
																'include'                  => '',
																'number'                   => '',
																'taxonomy'                 => $field_key,
																'pad_counts'               => false
																);
																$categories = get_categories( $args2 );
																if ( $categories && !is_wp_error( $categories ) ) :
																foreach ( $categories as $term ) {
																	$selected= ($term->slug==$submit_value ?' selected':'' );
																	echo '<option  '.$selected.' value="'.esc_attr($term->slug).'">-'.esc_attr($term->name).'</option>';
																}
																endif;
																$i++;
															}
															endif;
														?>
													</select>
												</div>

												<?php
												}elseif($field_key=='sort_listing'){

														?>
													<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field" id="sort_listing_div">
                                                        <div class="select-arrow"></div>
													<select name="sf<?php echo esc_attr($field_key); ?>" id="sf<?php echo esc_attr($field_key); ?>" class="form-control form-control-sm select2-enable	40" >
														<option value=""><?php  esc_attr_e('Sort','listfoliopro');?></option>

														<option  <?php echo esc_html($submit_value=='asc'?' selected':' '); ?> value="asc" ><?php  esc_attr_e('A to Z (title)','listfoliopro');?></option>
														<option <?php echo esc_html($submit_value=='desc'?' selected':' '); ?> value="desc" ><?php  esc_attr_e('Z to A (title)','listfoliopro');?></option>
														<option  <?php echo esc_html($submit_value=='date-desc'?' selected':' '); ?> value="date-desc" ><?php  esc_attr_e('Latest listings','listfoliopro');?></option>
														<option  <?php echo esc_html($submit_value=='date-asc'?' selected':' '); ?> value="date-asc" ><?php  esc_attr_e('Oldest listings','listfoliopro');?></option>
														<option  <?php echo esc_html($submit_value=='rand'?' selected':' '); ?> value="rand" ><?php  esc_attr_e('Random listings','listfoliopro');?></option>
													</select>
													</div>
												<?php
												}elseif($field_key=='title'){?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<?php

														$args_metadata = array(
														'post_type'  => $listfoliopro_directory_url,
														'posts_per_page' => -1,
														);
													?>
                                                    <div class="select-arrow"></div>
													<select name="sf<?php echo esc_attr($field_key); ?>" class="form-control select2-enable" >
														<option value=""><?php  esc_attr_e('Title','listfoliopro');?></option>
														<?php
															$args_metadata_arr = new WP_Query( $args_metadata );
															while ( $args_metadata_arr->have_posts() ) : $args_metadata_arr->the_post();
															$selected= (get_the_title()==$submit_value ?' selected':'' );
														?>
														<option  <?php echo esc_html($selected); ?> value="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></option>
														<?php
															endwhile;
														?>
													</select>
												</div>
												<?php
												}else{
													
													
												?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													
													<?php
														$args_metadata = array(
														'post_type'  => $listfoliopro_directory_url,
														'posts_per_page' => -1,
														'meta_query' => array(
														array(
														'key'     => $field_key,
														'orderby' => 'meta_value',
														'order' => 'ASC',
														),
														),
														);
														$args_metadata_arr = new WP_Query( $args_metadata );
														$args_metadata_arr_all = $args_metadata_arr->posts;
														$get_val_arr =array();
														foreach ( $args_metadata_arr_all as $term ) {
															$new_fields_val="";
															$new_fields_val=get_post_meta($term->ID,$field_key,true);
															if(is_array($new_fields_val)){
																foreach ( $new_fields_val as $new_fields_val_one ) {
																	if (!in_array($new_fields_val_one,$get_val_arr )) {
																		$get_val_arr[]=$new_fields_val_one;
																	}
																}
																}else{
																if (!in_array($new_fields_val, $get_val_arr)) {
																	$get_val_arr[]=$new_fields_val;
																}
															}
														}
													?>
                                                    <div class="select-arrow"></div>
													<select name="sf<?php echo esc_attr($field_key); ?>" class="form-control select2-enable" >
														<option value=""><?php echo esc_attr($trandlated_title); ?></option>
														<?php
															if(count($get_val_arr)) {
																asort($get_val_arr);
																foreach($get_val_arr as $row1) {
																	if($row1!=''){
																		$selected= ($row1==$submit_value ?' selected':'' );
																	?>
																	<option  <?php echo esc_html($selected); ?> value="<?php echo esc_attr($row1); ?>"><?php echo esc_html($row1).' '.$dropdown_value_with_label; ?></option>
																	<?php
																	}
																}
															}
														?>
													</select>
												</div>
												<?php
												}
											?>
											<?php
											}
											if($field_value=='multi-checkbox'){
												$cat_tag_location=  str_replace($listfoliopro_directory_url,'',$field_key);
												$cat_tag_location=  str_replace('-','',$cat_tag_location);
												$taxonomy = get_taxonomy($listfoliopro_directory_url.'-'.$cat_tag_location);
													if ($taxonomy !== false) {
														$taxonomy_labels = get_taxonomy_labels(get_taxonomy($listfoliopro_directory_url.'-'.$cat_tag_location));
														$taxonomy_label = $taxonomy_labels->singular_name;
													}else{
														$taxonomy_label =$cat_tag_location;
													}
												if($cat_tag_location=='category' OR $cat_tag_location=='tag' OR $cat_tag_location=='locations'){ ?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field" >
													<select name="sf<?php echo esc_attr($field_key); ?>[]" id="<?php echo esc_attr($field_key); ?>id" class="form-control" multiple="multiple" >
														<?php
															if(!is_array($submit_value)){$submit_value2=array($submit_value);}else{$submit_value2=$submit_value;}
															$taxonomy = $field_key;
															$args = array(
															'orderby'           => 'name',
															'taxonomy'   => 	$taxonomy ,
															'order'             => 'ASC',
															'hide_empty'        => true,
															'exclude'           => array(),
															'exclude_tree'      => array(),
															'include'           => array(),
															'number'            => '',
															'fields'            => 'all',
															'slug'              => '',
															'parent'            => '0',
															'hierarchical'      => true,
															'child_of'          => 0,
															'childless'         => false,
															'get'               => '',
															);
															$terms = get_terms($args); // Get all terms of a taxonomy
															if ( $terms && !is_wp_error( $terms ) ) :
															$i=0;
															foreach ( $terms as $term_parent ) {
																$selected= (in_array($term_parent->slug,$submit_value2) ?' selected':'' );
																echo '<option '.$selected.' value="'.esc_attr($term_parent->slug).'" >'.$term_parent->name.'</option>';
															?>
															<?php
																$args2 = array(
																'type'                     => $listfoliopro_directory_url,
																'parent'                   => $term_parent->term_id,
																'orderby'                  => 'name',
																'order'                    => 'ASC',
																'hide_empty'               => 1,
																'hierarchical'             => 1,
																'exclude'                  => '',
																'include'                  => '',
																'number'                   => '',
																'taxonomy'                 => $field_key,
																'pad_counts'               => false
																);
																$categories = get_categories( $args2 );
																if ( $categories && !is_wp_error( $categories ) ) :
																foreach ( $categories as $term ) {
																	$selected= (in_array($term->slug,$submit_value2) ?' selected':'' );
																	echo '<option '.$selected.' value="'.esc_attr($term->slug).'">-'.esc_attr($term->name).'</option>';
																}
																endif;
																$i++;
															}
															endif;
														?>
													</select>
												</div>
												<?php
												}elseif($field_key=='review'){ ?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<select  name="sf<?php echo esc_attr($field_key); ?>[]" id="<?php echo esc_attr($field_key); ?>id" class="form-control multiselect "  multiple="multiple"   >

														<?php
															if(!is_array($submit_value)){$submit_value2=array($submit_value);}else{$submit_value2=$submit_value;}

														?>
														<option   <?php echo (in_array('5',$submit_value2) ?' selected':'' ); ?> value="5"><?php  esc_attr_e('5 Stars','listfoliopro');?></option>
														<option   <?php echo (in_array('4',$submit_value2) ?' selected':'' ); ?> value="4"><?php  esc_attr_e('4 Stars','listfoliopro');?></option>
														<option   <?php echo (in_array('3',$submit_value2) ?' selected':'' ); ?> value="3"><?php  esc_attr_e('3 Stars','listfoliopro');?></option>
														<option   <?php echo (in_array('2',$submit_value2) ?' selected':'' ); ?> value="2"><?php  esc_attr_e('2 Stars','listfoliopro');?></option>
														<option   <?php echo (in_array('1',$submit_value2) ?' selected':'' ); ?> value="1"><?php  esc_attr_e('1 Star','listfoliopro');?></option>
													</select>
												</div>
												<?php
												}elseif($field_key=='title'){?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<?php

														$args_metadata = array(
														'post_type'  => $listfoliopro_directory_url,
														'posts_per_page' => -1,
														);
													?>
													<select  name="sf<?php echo esc_attr($field_key); ?>[]" id="<?php echo esc_attr($field_key); ?>id" class="form-control multiselect"  multiple="multiple"   >
														<option value=""><?php  esc_attr_e('Title','listfoliopro');?></option>
														<?php
															if(!is_array($submit_value)){$submit_value2=array($submit_value);}else{$submit_value2=$submit_value;}
															$args_metadata_arr = new WP_Query( $args_metadata );
															while ( $args_metadata_arr->have_posts() ) : $args_metadata_arr->the_post();
															$selected= (in_array($args_metadata_arr->post->ID,$submit_value2) ?' selected':'' );
														?>
														<option   <?php echo esc_html($selected); ?> value="<?php echo esc_attr($args_metadata_arr->post->ID) ; ?>"><?php echo the_title(); ?></option>
														<?php
															endwhile;
														?>
													</select>
												</div>
												<?php
													}else{
													$args_metadata = array(
													'post_type'  => $listfoliopro_directory_url,
													'posts_per_page' => -1,
													'meta_query' => array(
													array(
													'key'     => $field_key,
													'orderby' => 'meta_value',
													'order' => 'ASC',
													),
													),
													);
													$args_metadata_arr = new WP_Query( $args_metadata );
													$args_metadata_arr_all = $args_metadata_arr->posts;
													$get_val_arr =array();
													foreach ( $args_metadata_arr_all as $term ) {
														$new_fields_val="";
														$new_fields_val=get_post_meta($term->ID,$field_key,true);
														if(is_array($new_fields_val)){
															foreach ( $new_fields_val as $new_fields_val_one ) {
																if (!in_array($new_fields_val_one,$get_val_arr)) {
																	$get_val_arr[]=$new_fields_val_one;
																}
															}
															}else{
															if (!in_array($new_fields_val, $get_val_arr)) {
																$get_val_arr[]=$new_fields_val;
															}
														}
													}
												?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field">
													<select  name="sf<?php echo esc_attr($field_key); ?>[]" id="<?php echo esc_attr($field_key); ?>id" class="form-control multiselect "  multiple="multiple"   >
														<?php
															if(!is_array($submit_value)){$submit_value2=array($submit_value);}else{$submit_value2=$submit_value;}
															if(count($get_val_arr)) {
																asort($get_val_arr);
																foreach($get_val_arr as $row1) {
																	if($row1!=''){
																		$selected= (in_array($row1,$submit_value2) ?' selected':'' );
																	?>
																	<option  <?php echo esc_html($selected); ?>  value="<?php echo esc_attr($row1); ?>"><?php echo esc_html($row1).' '.$dropdown_value_with_label; ?></option>
																	<?php
																	}
																}
															}
														?>
													</select>
												</div>
												<?php
												}
											}
											if($field_value=='multi-checkbox-group'){
												 ?>
												<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field" >
													<select name="sf<?php echo esc_attr($field_key); ?>[]" id="<?php echo esc_attr($field_key); ?>id" class="form-control" multiple="multiple" >
														<?php
															if(!is_array($submit_value)){$submit_value2=array($submit_value);}else{$submit_value2=$submit_value;}
															$taxonomy = $field_key;
															$args = array(
															'orderby'           => 'name',
															'taxonomy'   => 	$taxonomy ,
															'order'             => 'ASC',
															'hide_empty'        => true,
															'exclude'           => array(),
															'exclude_tree'      => array(),
															'include'           => array(),
															'number'            => '',
															'fields'            => 'all',
															'slug'              => '',
															'parent'            => '0',
															'hierarchical'      => true,
															'child_of'          => 0,
															'childless'         => false,
															'get'               => '',
															);
															$terms = get_terms($args); // Get all terms of a taxonomy
															if ( $terms && !is_wp_error( $terms ) ) :
															$i=0;
															foreach ( $terms as $term_parent ) {
																$selected= (in_array($term_parent->slug,$submit_value2) ?' selected':'' );

																echo '<optgroup label="'.$term_parent->name.'">';
																echo '<option '.esc_attr($selected).' value="'.esc_attr($term_parent->slug).'">'.esc_attr($term_parent->name).'</option>';
															?>
															<?php
																$args2 = array(
																'type'                     => $listfoliopro_directory_url,
																'parent'                   => $term_parent->term_id,
																'orderby'                  => 'name',
																'order'                    => 'ASC',
																'hide_empty'               => 1,
																'hierarchical'             => 1,
																'exclude'                  => '',
																'include'                  => '',
																'number'                   => '',
																'taxonomy'                 => $field_key,
																'pad_counts'               => false
																);
																$categories = get_categories( $args2 );
																if ( $categories && !is_wp_error( $categories ) ) :
																foreach ( $categories as $term ) {
																	$selected= (in_array($term->slug,$submit_value2) ?' selected':'' );
																	echo '<option '.$selected.' value="'.esc_attr($term->slug).'">'.esc_attr($term->name).' '.$dropdown_value_with_label.'</option>';
																}
																endif;
																$i++;
																echo'</optgroup>';
															}
															endif;
														?>
													</select>
												</div>
											<?php

											}
										}
									}
								}
							?>

							<div class="form-group <?php echo esc_html($search_form_col); ?> ep_search_field" >
								<div class="" role="toolbar" aria-label="Toolbar with button groups">
									<button type="submit" class="btn btn-big">
                                        <?php  esc_html_e('Search Now','listfoliopro');?>
                                        <img src="<?php echo esc_url(listfoliopro_ep_URLPATH.'admin/files/css/images/arrow-up-right.svg');?> " alt="arrow up">
                                    </button>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>


<?php
	$min_price=(isset($_REQUEST['min-price'])? $_REQUEST['min-price'] : 100);
	$max_price=(isset($_REQUEST['max-price'])? $_REQUEST['max-price'] : 5000000);
	$save_address='';
	if(isset($_REQUEST['near_km'])){
		$listfoliopro_near_to_me = sanitize_text_field($_REQUEST['near_km']);
		}else{
		$listfoliopro_near_to_me =(get_option('listfoliopro_near_to_me')==''? '50': get_option('listfoliopro_near_to_me') );
	}
	$data_for_translate=listfoliopro_text_translate_array_all();

	$listfoliopro_map_radius=get_option('listfoliopro_map_radius');
	if($listfoliopro_map_radius==''){$listfoliopro_map_radius=='Km';}
		
	wp_enqueue_script('listfoliopro_select_2', listfoliopro_ep_URLPATH.'admin/files/js/select2.js', array('jquery'), $ver = true, true );
	wp_enqueue_script('listfoliopro_search', listfoliopro_ep_URLPATH.'admin/files/js/listing_search.js', array('jquery'), $ver = true, true );
	wp_localize_script('listfoliopro_search', 'search_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'adminnonce'=> wp_create_nonce("admin"),
	'data_for_translate'=> $data_for_translate,
	'active_search_fields'	=>$active_search_fields,
	'min_price'=> $min_price,
	'max_price'=> $max_price,	
	'select_text'=> '',
	'search'=> esc_html__('Search ','listfoliopro'),
	'selectAll'=> esc_html__('Selecionar tudo','listfoliopro'),
	'unselectAll'=> esc_html__('Limpar','listfoliopro'),
	'neartome'=> $listfoliopro_near_to_me,
	'listfoliopro_map_radius'=> $listfoliopro_map_radius,
	'current_url'=> home_url( add_query_arg( array(), $wp->request ) ),
	'current_location'	=>esc_html__('Your Current Location ','listfoliopro'),
	) );

?>
<?php
	wp_reset_query();
?>
