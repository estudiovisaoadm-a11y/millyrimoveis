<?php
	if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<?php
	if (!function_exists('listfoliopro_get_icon')) {	
		function listfoliopro_get_icon($active_single_icon_saved, $field_key, $onpage ){
			$saved_icon=''; 		
			if(isset($active_single_icon_saved[$field_key]) and $active_single_icon_saved[$field_key]!=""){ 			
				if($field_key!='category'){				
					if(trim($active_single_icon_saved [$field_key])!=''){ 						
						$saved_icon=$active_single_icon_saved [$field_key];
						}else{
					}
				}	
				}else{
				if($onpage=='single'){ 
					$archive_page_icon_saved=get_option('listfoliopro_archive_icon_saved');
					if(isset($archive_page_icon_saved[$field_key]) and $archive_page_icon_saved[$field_key]!=""){ 
						$saved_icon=$archive_page_icon_saved [$field_key];
					}				
				}
				if($onpage=='archive'){ 
					$archive_page_icon_saved=get_option('listfoliopro_li_field_image');
					if(isset($archive_page_icon_saved[$field_key]) and $archive_page_icon_saved[$field_key]!=""){ 
						$saved_icon=$archive_page_icon_saved [$field_key];
					}
				}
			}	
			return $saved_icon;	
		}
	}	
	if (!function_exists('listfoliopro_get_cat_icon')) {		
		function listfoliopro_get_cat_icon($term_id){	
			$saved_icon = get_term_meta($term_id, 'listfoliopro_term_icon', true);
			
			return $saved_icon;	
		}
	}	
	if (!function_exists('listfoliopro_check_field_display_access')) {	
		function listfoliopro_check_field_display_access($saved_fields_arr, $field_key){
			
			return '';
		}
	}	
	if (!function_exists('listfoliopro_get_archive_field')) {	
		function listfoliopro_get_archive_field($active_fields_arr, $field_icon_saved){
			
			return '';
		}
	}
	
	if (!function_exists('listfoliopro_default_custom_fields_with_type')) {		
		function listfoliopro_default_custom_fields_with_type(){
			$default_custom_fields=array();	
			$default_custom_fields['bed']=esc_html__('Bed','listfoliopro');			
			$default_custom_fields['bath']=esc_html__('Bath','listfoliopro');
			$default_custom_fields['garage']=esc_html__('Garage','listfoliopro');	
			$default_custom_fields['kitchen']=esc_html__('Kitchen','listfoliopro'); 
			$default_custom_fields['property_status']=esc_html__('Property Status','listfoliopro');
			$default_custom_fields['year_built']=esc_html__('Year Built','listfoliopro'); 
			$default_custom_fields['furnishing']=esc_html__('Furnishing','listfoliopro');
			$default_custom_fields['floor']=esc_html__('Floor','listfoliopro');
			$default_custom_fields['area_prefix_text']=esc_html__('Area Prefix Text','listfoliopro');
			$default_custom_fields['area']=esc_html__('Area','listfoliopro');	
			// For Car Fields****************
			$default_custom_fields['body']=esc_html__('Body','listfoliopro');			
			$default_custom_fields['brand']=esc_html__('Brand','listfoliopro');
			$default_custom_fields['made_in']=esc_html__('Made In','listfoliopro');	
			$default_custom_fields['mileage']=esc_html__('Mileage','listfoliopro'); 
			$default_custom_fields['fuel_type']=esc_html__('Fuel Type','listfoliopro');
			$default_custom_fields['year_built']=esc_html__('Year Built','listfoliopro'); 
			$default_custom_fields['drive_type']=esc_html__('Drive Type','listfoliopro');			
			$default_custom_fields['condition']=esc_html__('Condition','listfoliopro');
			$default_custom_fields['transmission']=esc_html__('Transmission','listfoliopro'); 
			$default_custom_fields['engine_size']=esc_html__('Engine Size','listfoliopro');			
			$default_custom_fields['door']=esc_html__('Door','listfoliopro');
			$default_custom_fields['cylinder']=esc_html__('Cylinder','listfoliopro'); 
			$default_custom_fields['color']=esc_html__('Color','listfoliopro');
			$default_custom_fields['no_of_seats']=esc_html__('No. of Seats','listfoliopro');
			
			
			
			$default_custom_fields_type=array();			
			$default_custom_fields_type['bed']='text'; 
			$default_custom_fields_type['bath']='text'; 					
			$default_custom_fields_type['garage']='text';
			$default_custom_fields_type['kitchen']='text';			
			$default_custom_fields_type['property_status']='text';
			$default_custom_fields_type['year_built']='text';
			$default_custom_fields_type['furnishing']='text';			
			$default_custom_fields_type['floor']='text';	
			$default_custom_fields_type['area_prefix_text']='text';
			$default_custom_fields_type['area']='text';
			// For Car Fields****************
			$default_custom_fields_type['body']='text'; 
			$default_custom_fields_type['brand']='text'; 
			$default_custom_fields_type['made_in']='text';			
			$default_custom_fields_type['mileage']='text';
			$default_custom_fields_type['fuel_type']='text';			
			$default_custom_fields_type['drive_type']='text';
			$default_custom_fields_type['condition']='text';
			$default_custom_fields_type['transmission']='text';			
			$default_custom_fields_type['engine_size']='text';			
			$default_custom_fields_type['door']='text';
			$default_custom_fields_type['cylinder']='text';			
			$default_custom_fields_type['color']='text';
			$default_custom_fields_type['no_of_seats']='text';
			
					
			return array($default_custom_fields, $default_custom_fields_type);
		}
	}	
	if (!function_exists('listfoliopro_get_listing_fields_all_single')) {		
		function listfoliopro_get_listing_fields_all_single(){
			$available_fields_main=array();	
			$available_fields_main['image-gallery']='Image Gallery';
			$available_fields_main['open_status']='Business Hours';
			$available_fields_main['open_status_table']='Business Hours Table';
			$available_fields_main['company-logo']='Company Logo';
			$available_fields_main['company-name']='Company Name';	
			$available_fields_main['social-profile']='Social Profile';
			$available_fields_main['title']='Title';
			$available_fields_main['description']='Description';	
			$available_fields_main['category']='Category';
			$available_fields_main['tag']='Amenities';
			$available_fields_main['review']='Review';
			$available_fields_main['location']='Location';	
			$available_fields_main['post_date']='Post Date';	
			$available_fields_main['contact_button']='Contact Form';
			$available_fields_main['booking_button']='Booking Button';
			$available_fields_main['report_button']='Report Button';
			$available_fields_main['pdf_button']='PDF Button';
			$available_fields_main['favorite']='Favorite Button';
			$available_fields_main['video']='Video';
			$available_fields_main['360-view']='360 Image Viewer';
			$available_fields_main['near-to-me']='Near to me';			
			$available_fields_main['map']='Map';
			$available_fields_main['address']='Address';
			$available_fields_main['price']='Price/Discount';			
			$available_fields_main['whatsapp']='Whatsapp';
			$available_fields_main['attachments']='Attachments';	
			$available_fields_main['similar-listing']='Similar Listing';
			
			$available_fields_main['social-share']='Social Share';
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
				$new_field_set = $default_fields_two_arr[0];	
			}
			
			
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields_main[$field_key]=$field_value;
				}
			}
			return $available_fields_main;
		}
	}
	if (!function_exists('listfoliopro_get_fields_top_section')) {	
		function listfoliopro_get_fields_top_section(){		
			$available_fields_top=array();	
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
				$new_field_set = $default_fields_two_arr[0];	
			}
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields_top[$field_key]=$field_value;
				}
			}	
			$available_fields_top['category']='Category';	
			return $available_fields_top;
		}
	}
	if (!function_exists('listfoliopro_get_fields_sort_section')) {	
		function listfoliopro_get_fields_sort_section(){		
			$available_fields_top=array();	
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
				$new_field_set = $default_fields_two_arr[0];	
			}
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields_top[$field_key]=$field_value;
				}
			}	
			$available_fields_top['title']='Title';
			$available_fields_top['category']='Category';	
			$available_fields_top['locations']='Location';
			$available_fields_top['tag']='Tag';
			$available_fields_top['price']='Price';
			return $available_fields_top;
		}
	}
	
	if (!function_exists('listfoliopro_get_listing_fields_all')) {	
		function listfoliopro_get_listing_fields_all(){			
			
			$available_fields_main['top_search_form']='Top Filter';
			$available_fields_main['image']='Image';			
			$available_fields_main['title']='Title';
			$available_fields_main['price']='Price/Discount';
			$available_fields_main['location']='Location';							
			$available_fields_main['favorite']='Favorite Button';	
			
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
				$new_field_set = $default_fields_two_arr[0];	
			}
			
			
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields_main[$field_key]=$field_value;
					}
			}
			
			return $available_fields_main;
		}
	}
	if (!function_exists('listfoliopro_get_available_search_fields')) {	
		function listfoliopro_get_available_search_fields(){	
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
			$available_fields=array();
			$available_fields[$listfoliopro_directory_url.'-category']='multi-checkbox';
			$available_fields[$listfoliopro_directory_url.'-tag']='multi-checkbox';
			$available_fields[$listfoliopro_directory_url.'-locations']='drop-down';
			$available_fields['near_to_me']='text-field';
			$available_fields['title']='text-field';
			$available_fields['price_slider']='text-field';
			$available_fields['city']='City';
			$available_fields['postcode']='Postcode';
			$available_fields['state']='State';
			$available_fields['country']='Country';	
			$available_fields['post_date']='datefield';
			$available_fields['sort_listing']='drop-down';
			$available_fields['review']='Review';
			
			
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$field_set_all= listfoliopro_default_custom_fields_with_type();
				$new_field_set = $field_set_all[0];
			}			
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields[$field_key]=$field_value;
				}
			}
			
			return $available_fields;
		}
	}	
	if (!function_exists('listfoliopro_get_available_search_fields_elementor')) {	
		function listfoliopro_get_available_search_fields_elementor(){	
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
			$available_fields=array();
			$available_fields[$listfoliopro_directory_url.'-category']=$listfoliopro_directory_url.'-category';
			$available_fields[$listfoliopro_directory_url.'-tag']=$listfoliopro_directory_url.'-tag';
			$available_fields[$listfoliopro_directory_url.'-locations']=$listfoliopro_directory_url.'-locations';
			$available_fields['near_to_me']='near_to_me';
			$available_fields['title']='title';
			$available_fields['price_slider']='price_slider';
			$available_fields['city']='City';
			$available_fields['postcode']='Postcode';
			$available_fields['state']='State';
			$available_fields['country']='Country';	
			$available_fields['post_date']='post_date';
			$available_fields['sort_listing']='sort_listing';
			$available_fields['review']='Review';
			
			
			$new_field_set=	get_option('listfoliopro_li_fields' );
			if($new_field_set==""){
				$field_set_all= listfoliopro_default_custom_fields_with_type();
				$new_field_set = $field_set_all[0];
			}			
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key => $field_value){
					$available_fields[$field_key]=$field_value;
				}
			}
			
			return $available_fields;
		}
	}	
	if (!function_exists('listfoliopro_get_price')) {
		function listfoliopro_get_price($price,$listing_id,$format){	
			$price = str_replace('$','',$price);
			$price_prefix = get_post_meta($listing_id,'price_prefix_text',true);
			if ($price_prefix === '') {
				$price_prefix = get_option('listfoliopro_currency_symbol');
			}
			if ($price_prefix === '') {
				$price_prefix = 'R$ ';
			}
			$price_clean = (int) str_replace(",", "", $price);
			if($format=='european'){
					$price_real = $price_prefix . number_format($price_clean, 0, ',', '.');
				}else{
					$price_real = $price_prefix . number_format($price_clean);
			}
		return $price_real;
		}
	}					
	if (!function_exists('listfoliopro_get_archive_fields_all')) {
		function listfoliopro_get_archive_fields_all(){ 
			$active_archive_fields_saved=get_option('listfoliopro_archive_fields_saved' );	
			if($active_archive_fields_saved==''){ 
				$active_archive_fields=array();	
				$active_archive_fields['top_search_form']='Top Filter';
				$active_archive_fields['image']='Image';			
				$active_archive_fields['title']='Title';
				$active_archive_fields['location']='Location';		
				$active_archive_fields['price']='Price/Discount';	
				$active_archive_fields['favorite']='Favorite Button';				
					
					$new_field_set=	get_option('listfoliopro_li_fields' );
					if($new_field_set==""){
						$field_set_all= listfoliopro_default_custom_fields_with_type();
						$new_field_set = $field_set_all[0];
					}			
					if(is_array($new_field_set)){ $i=1;
						foreach($new_field_set  as $field_key => $field_value){
							$active_archive_fields[$field_key]=$field_value;
							if($i>=3){break;}
							$i++;
							
						}
					}
				}else{
				$active_archive_fields=array();
				$active_archive_fields=$active_archive_fields_saved;
			}
			return $active_archive_fields;
		}
	}
	if (!function_exists('listfoliopro_text_translate_array_all')) {
		function listfoliopro_text_translate_array_all(){
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
			
			$listfoliopro_label_category=get_option('listfoliopro_label_category');
			if($listfoliopro_label_category==""){$listfoliopro_label_category='Category';}
			$listfoliopro_label_tag=get_option('listfoliopro_label_tag');
			if($listfoliopro_label_tag==""){$listfoliopro_label_tag='Tag';}
			$listfoliopro_label_location=get_option('listfoliopro_label_location');
			if($listfoliopro_label_location==""){$listfoliopro_label_location='Location';}
			
			
			$data_for_translate=array();	
			$data_for_translate['category']=esc_html__( 'Category', 'listfoliopro' );				
			$data_for_translate['location']=esc_html__( 'Location', 'listfoliopro' );	
			$data_for_translate['social-share']=esc_html__( 'Social Share', 'listfoliopro' );		
			$data_for_translate[$listfoliopro_directory_url.'-category']=esc_html($listfoliopro_label_category );
			$data_for_translate[$listfoliopro_directory_url.'-tag']=esc_html( $listfoliopro_label_tag);
			$data_for_translate[$listfoliopro_directory_url.'-locations']=esc_html( $listfoliopro_label_location);
			
			$data_for_translate['title']=esc_html__( 'Title', 'listfoliopro' );				
			$data_for_translate['city']=esc_html__( 'City', 'listfoliopro' );	
			$data_for_translate['postcode']=esc_html__( 'Post code', 'listfoliopro' );	
			$data_for_translate['state']=esc_html__( 'State', 'listfoliopro' );	
			$data_for_translate['country']=esc_html__( 'Country', 'listfoliopro' );	
			$data_for_translate['review']=esc_html__( 'Review', 'listfoliopro' );	
			$data_for_translate['post_date']=esc_html__( 'Post Date', 'listfoliopro' );
			$new_field_set=	get_option('listfoliopro_li_fields' );				
			if($new_field_set==""){
				$field_set_all= listfoliopro_default_custom_fields_with_type();
				$new_field_set = $field_set_all[0];	
			}
			if(is_array($new_field_set)){
				foreach($new_field_set  as $field_key_custom => $field_value_custom){
					$data_for_translate[$field_key_custom]=$field_value_custom;	
				}
			}	
			return $data_for_translate;
		}
	}
	if (!function_exists('listfoliopro_text_translate')) {
		function listfoliopro_text_translate($key_text){		
			$data_for_translate=listfoliopro_text_translate_array_all();		
			$display_title= (isset($data_for_translate[$key_text])? $data_for_translate[$key_text]:$key_text);	
			return $display_title;
		}
	}
	if (!function_exists('listfoliopro_get_search_fields_default')) {
		function listfoliopro_get_search_fields_default(){
			$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
			$active_search_fields=array();
			$active_search_fields[$listfoliopro_directory_url.'-category']='multi-checkbox';		
			$active_search_fields[$listfoliopro_directory_url.'-locations']='multi-checkbox';		
			$active_search_fields['review']='multi-checkbox';
			return $active_search_fields;
		}
	}	
	if (!function_exists('listfoliopro_get_color_changer_js')) {
		function listfoliopro_get_color_changer_js(){ 
				$listfoliopro_primary_color=listihub_option('theme_primary_color');	
				if($listfoliopro_primary_color==""){$listfoliopro_primary_color='#1dbfc1';}
				
				$listfoliopro_second_color=listihub_option('theme_second_color');	
				if($listfoliopro_second_color==""){$listfoliopro_second_color='#87f1f2';}	
				$theme_content_bg_color=get_option('theme_content_bg_color');	
				if($theme_content_bg_color==""){$theme_content_bg_color='#87f1f2';}
				wp_enqueue_script('listfoliopro-dynamic-color', listfoliopro_ep_URLPATH . 'admin/files/js/dynamic-color.js');
				wp_localize_script('listfoliopro-dynamic-color', 'listfoliopro_color', array(
				'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
				'listfoliopro_primary_color'=>$listfoliopro_primary_color,
				'listfoliopro_second_color'=>$listfoliopro_second_color,	
				'listfoliopro_content_bg_color'=>$theme_content_bg_color,				
				) );		
		}
	}
	if (!function_exists('listfoliopro_get_search_args')) {
		function listfoliopro_get_search_args($listfoliopro_directory_url){
			$search_arg= array();
			
			global $listfoliopro_filter_badge;
			$listfoliopro_filter_badge=0;
			$other_field_mq= array();
			$field_prefix='sf';
			$dir_listing_sort=get_option('_dir_listing_sort');
			if($dir_listing_sort==""){$dir_listing_sort='date-desc';}
			if(isset($_REQUEST[$field_prefix.'sort_listing']) AND $_REQUEST[$field_prefix.'sort_listing']!=''){
				$dir_listing_sort=sanitize_text_field($_REQUEST[$field_prefix.'sort_listing']);
			}
			if($dir_listing_sort=='asc'){
				$search_arg['orderby']='title';
				$search_arg['order']='ASC';
			}
			if($dir_listing_sort=='desc'){
				$search_arg['orderby']='title';
				$search_arg['order']='DESC';
			}
			// Date
			if($dir_listing_sort=='date-desc'){
				$search_arg['orderby']='date';
				$search_arg['order']='DESC';
			}
			if($dir_listing_sort=='date-asc'){
				$search_arg['orderby']='date';
				$search_arg['order']='ASC';
			}
			if($dir_listing_sort=='rand'){
				$search_arg['orderby']='rand';
				$search_arg['order']='ASC';
			}
			// Search Fields****************
			$active_search_fields_saved=get_option('listfoliopro_search_fields_saved' );	
			if($active_search_fields_saved==''){		
				$active_search_fields =listfoliopro_get_search_fields_default();				
				}else{
				$active_search_fields=array();
				$active_search_fields=$active_search_fields_saved;
			}	
			
			
			
			$active_search_fields =listfoliopro_get_available_search_fields();		
			
			$category_query=''; $tag_query=''; $location_query='';
			if(is_array($active_search_fields)){
				foreach($active_search_fields  as $field_key => $field_value){		 
				
					if(isset($_REQUEST[$field_prefix.$field_key]) AND $_REQUEST[$field_prefix.$field_key]!='' AND $field_key!='sort_listing'){
						
						
						
						$listfoliopro_filter_badge=$listfoliopro_filter_badge+1;												
						if($field_key=='title'){
							$search_title= sanitize_text_field($_REQUEST[$field_prefix.$field_key]);
							if(is_array($search_title)){
								$title_arr=array();
								foreach($search_title as $one_title){
									$title_arr[]= sanitize_text_field($one_title);
								}	
								$search_arg['post__in']= $title_arr;
								}else{
								$search_arg['s']=   sanitize_text_field($_REQUEST[$field_prefix.$field_key]);
							}
							}elseif($field_key==$listfoliopro_directory_url.'-category'){	
							if(isset($_REQUEST[$field_prefix.$listfoliopro_directory_url.'-category']) AND $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-category']!=''){
								$categories= $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-category'];
								$categories_arr=array();							
								if(is_array($categories)){
									foreach($categories as $one_category){
										$categories_arr[]= sanitize_text_field($one_category);
									}
									}else{
									$categories_arr[]= sanitize_text_field($categories);
								}	
								$category_query = 
								array(
								'taxonomy'  => $listfoliopro_directory_url.'-category',
								'field'		=> 	'slug',
								'terms'   	=> $categories_arr,
								'compare' 	=> 'IN'
								);
							}	
							}elseif($field_key==$listfoliopro_directory_url.'-tag'){		
							if(isset($_REQUEST[$field_prefix.$listfoliopro_directory_url.'-tag'])  AND $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-tag']!=''){
								$tags= $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-tag'];
								$tags_arr=array();							
								if(is_array($tags)){
									foreach($tags as $one_tag){
										$tags_arr[]= sanitize_text_field($one_tag);
									}
									}else{
									$tags_arr[]= sanitize_text_field($tags);
								}	
								$tag_query = 
								array(
								'taxonomy'  => $listfoliopro_directory_url.'-tag',
								'field'		=> 	'slug',
								'terms'   	=> $tags_arr,
								'compare' 	=> 'IN'
								);
							}	
							}elseif(trim($field_key)==$listfoliopro_directory_url.'-locations'){
								if(isset($_REQUEST[$field_prefix.$listfoliopro_directory_url.'-locations'])  AND $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-locations']!=''){
									$locations= $_REQUEST[$field_prefix.$listfoliopro_directory_url.'-locations'];
									$locations_arr=array();
									if(is_array($locations)){
										foreach($locations as $one_location){
											$locations_arr[]= sanitize_text_field($one_location);
										}
										}else{
										$locations_arr[]= sanitize_text_field($locations);
									}	
									$location_query = 
									array(
									'taxonomy'  => $listfoliopro_directory_url.'-locations',
									'field'		=> 	'slug',
									'terms'   	=> $locations_arr,
									'compare' 	=> 'IN'
									);
								}
							}elseif($field_key=='price_slider'){
								if(isset($_REQUEST['sfprice_slider'])  AND $_REQUEST['sfprice_slider']!=''){ 
								
								$min_price=(int)$_REQUEST['min-price'];
								$max_price=(int)$_REQUEST['max-price'];
								$field_mq = 
									array(
									'key'     => 'price',
									 'value'   => array($min_price, $max_price),
									'compare' => 'BETWEEN',
									'type'    => 'NUMERIC'							
									);
								array_push( $other_field_mq, $field_mq );
								}
							}else{ 
								if(isset($_REQUEST[$field_prefix.$field_key])  AND $_REQUEST[$field_prefix.$field_key]!=''){ 
									$other_field= $_REQUEST[$field_prefix.$field_key];
									$other_field_arr=array();
									if(is_array($other_field)){								
										foreach($other_field as $one_field){
											$other_field_arr[]= sanitize_text_field($one_field);
										}
										}else{
										$other_field_arr[]= sanitize_text_field($_REQUEST[$field_prefix.$field_key]);
									}	
									$field_mq = 
									array(
									'key'     => $field_key,
									'value'   => $other_field_arr,
									'compare' => 'IN'							
									);
								
								array_push( $other_field_mq, $field_mq );
							}	
						}					
					}
				}
			}	
			$search_arg['tax_query'] = array(
			'relation' => 'AND',
			$category_query, $tag_query, $location_query,
			);
			// Need to add min & max price meta query data*****
			
			
			$search_arg['meta_query'] = array(
			'relation' => 'AND',
			$other_field_mq,
			);
			if(isset($_REQUEST['latitude']) AND $_REQUEST['latitude']!=''){
				$search_arg['lat']=sanitize_text_field($_REQUEST['latitude']);
				$listfoliopro_filter_badge=$listfoliopro_filter_badge+1;
			}
			if(isset($_REQUEST['longitude']) AND $_REQUEST['longitude']!=''){
				$search_arg['lng']=sanitize_text_field($_REQUEST['longitude']);
			}
			if(isset($_REQUEST['near_km']) AND $_REQUEST['near_km']!=''){
				$search_arg['distance']=sanitize_text_field($_REQUEST['near_km']);
			}
			
			
			return $search_arg;
		}
	}	
