<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<div class=" form-group">
	<label for="text" class=" control-label"><?php  esc_html_e('listing Title','listfoliopro'); ?></label>
	<div class="  "> 
		<input type="text" class="form-control" name="title" id="title" value="" placeholder="<?php  esc_html_e('Enter Title Here','listfoliopro'); ?>">
	</div>																		
</div>	

<div class="form-group">
	<label for="text" class="control-label"><?php  esc_html_e('listing Description','listfoliopro'); ?>  </label>
	<?php
		$settings_a = array(															
		'textarea_rows' =>8,
		'editor_class' => 'form-control'															 
		);
		$editor_id = 'new_post_content';
		wp_editor( '', $editor_id,$settings_a );										
	?>
</div>

						
<div class="  form-group ">
	<label for="text" class="  control-label"><?php  esc_html_e('Status','listfoliopro'); ?>  </label>
	<select name="post_status" id="post_status"  class="form-control">
		<?php
			$listfoliopro_user_can_publish=get_option('listfoliopro_user_can_publish');
			if($listfoliopro_user_can_publish==""){$listfoliopro_user_can_publish='yes';}
			if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){?>
			<option value="publish"><?php esc_html_e('Publish','listfoliopro'); ?></option>
			<?php
			}
			if(isset($current_user->roles[0]) and $current_user->roles[0]!='administrator'){
				if($listfoliopro_user_can_publish=="yes"){
				?>
				<option value="publish"><?php esc_html_e('Publish','listfoliopro'); ?></option>
				<?php
				}
			}
		?>											
		<option value="pending"><?php esc_html_e('Pending Review','listfoliopro'); ?></option>
		<option value="draft" ><?php esc_html_e('Draft','listfoliopro'); ?></option>
	</select>	
</div>										

<div class="row">	
	<div class=" col-md-4 form-group">
		<label for="text" class=" control-label"><?php  esc_html_e('Price Prefix Text','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="price_prefix_text" id="price_prefix_text" value="" placeholder="<?php  esc_html_e('e.g. $ EUR ','listfoliopro'); ?>">
	</div>
	<div class=" col-md-4 form-group">
		<label for="text" class=" control-label"><?php  esc_html_e('Price','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="price" id="price" value="" placeholder="<?php  esc_html_e('Enter Price ','listfoliopro'); ?>">
	</div>
	<div class="col-md-4  form-group">
		<label for="text" class=" control-label"><?php  esc_html_e('Discount Price','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="discount" id="discount" value="" placeholder="<?php  esc_html_e('Enter Discount Price','listfoliopro'); ?>">
	</div>
</div>	
<span class="caption-subject">														
	<?php  esc_html_e('Contact Info','listfoliopro'); ?>
</span>
<hr/>
<?php
	$listing_contact_source='';
	if($listing_contact_source==''){$listing_contact_source='user_info';}
?>

<div  class="row" id="new_contact_div" > 
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Company Name','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="company_name" id="company_name" value="" placeholder="<?php  esc_attr_e('Company name','listfoliopro'); ?>">
	</div>
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Phone','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="phone" id="phone" value="" placeholder="<?php  esc_attr_e('Enter Phone Number','listfoliopro'); ?>">
	</div>
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('WhatsApp','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="whatsapp" id="whatsapp" value="" placeholder="<?php  esc_attr_e('Enter whatsApp Number','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Viber','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="viber" id="viber" value="" placeholder="<?php  esc_attr_e('Enter Viber Number','listfoliopro'); ?>">
	</div>	
	
	
	<div class=" form-group col-md-12">
		<label for="text" class=" control-label"><?php  esc_html_e('Address (Save in the listing field)','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="address" id="address" value=""  placeholder="<?php  esc_html_e('Enter Address','listfoliopro'); ?>">
		<div id="autocomplete-results"></div>
	</div>
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('City','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="city" id="city" value="" placeholder="<?php  esc_attr_e('Enter city','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('State','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="state" id="state" value="" placeholder="<?php  esc_attr_e('Enter State','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Zipcode/Postcode','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="postcode" id="postcode" value="" placeholder="<?php  esc_attr_e('Enter Zipcode/Postcode','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Country','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="country" id="country" value="" placeholder="<?php  esc_attr_e('Enter Country','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Latitude ','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="latitude" id="latitude" value="" placeholder="<?php  esc_attr_e('Enter Latitude','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Longitude','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="longitude" id="longitude" value="" placeholder="<?php  esc_attr_e('Enter Longitude','listfoliopro'); ?>">
	</div>	
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Email Address','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="contact-email" id="contact-email" value="" placeholder="<?php  esc_attr_e('Enter Email Address','listfoliopro'); ?>">
	</div>
	<div class=" form-group col-md-6">
		<label for="text" class=" control-label"><?php  esc_html_e('Web Site','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="contact_web" id="contact_web" value="" placeholder="<?php  esc_attr_e('Enter Web Site','listfoliopro'); ?>">
	</div>
</div>	
<hr/>
<div class="clearfix"></div>
<span class="caption-subject">												
	<?php  esc_html_e('Categories','listfoliopro'); ?>
</span>
<hr/>
<div class=" form-group row"  id="listfolioprocats-container">
	<?php $selected='';
		//listing
		$taxonomy = $listfoliopro_directory_url.'-category';
		$args = array(
		'orderby'           => 'name',
		'taxonomy'   => 	$taxonomy ,
		'order'             => 'ASC',
		'hide_empty'        => false, 
		'exclude'           => array(), 
		'exclude_tree'      => array(), 
		'include'           => array(),
		'number'            => '', 
		'fields'            => 'all', 
		'slug'              => '',
		'hierarchical'      => true, 
		'child_of'          => 0,
		'childless'         => false,
		'get'               => '', 
		);
		$terms = get_terms($args); // Get all terms of a taxonomy
		if ( $terms && !is_wp_error( $terms ) ) :
		$i=0;
		foreach ( $terms as $term_parent ) {  ?>												
		<?php  
			if($term_parent->name!=''){	
			?>	
			<div class="col-md-6">
				<label class="form-group "> <input type="checkbox" name="postcats[]" id="postcats"  value="<?php echo esc_attr($term_parent->slug); ?>" class="listfolioprocats-fields" > <?php echo esc_html($term_parent->name); ?> </label>
			</div>
			<?php
			}
			$i++;
		} 								
		endif;	
	?>	
	<div class="col-md-12">
		<input type="text" class="form-control" name="new_category" id="new_category" value="" placeholder="<?php  esc_html_e('Enter New Categories: Separate with commas','listfoliopro'); ?>">
	</div>		
</div>
<div class="clearfix"></div>
<span class="caption-subject">												
	<?php  esc_html_e('Tags','listfoliopro'); ?>
</span>
<hr/>
<div class=" row">		
	<?php
		$args2 = array(
		'type'                     => $listfoliopro_directory_url,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => $listfoliopro_directory_url.'-tag',
		'pad_counts'               => false
		);
		$main_tag = get_categories( $args2 );	
		$tags_all= '';													
		if ( $main_tag && !is_wp_error( $main_tag ) ) :
		foreach ( $main_tag as $term_m ) {
		?>
		<div class="col-md-6">
			<label class="form-group"> 
			<input type="checkbox" name="tag_arr[]" id="tag_arr[]"  value="<?php echo esc_attr($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>  
		</div>
		<?php	
		}
		endif;	
	?>
</div>
<div class=" form-group">	
	<input type="text" class="form-control" name="new_tag" id="new_tag" value="" placeholder="<?php  esc_html_e('Enter New Tags: Separate with commas','listfoliopro'); ?>">
</div>															
<div class="clearfix"></div>
<span class="caption-subject">												
	<?php  esc_html_e('Locations','listfoliopro'); ?>
</span>
<hr/>
<div class=" row mb-3">		
	<?php
		$args2 = array(
		'type'                     => $listfoliopro_directory_url,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => $listfoliopro_directory_url.'-locations',
		'pad_counts'               => false
		);
		$main_tag = get_categories( $args2 );	
		$tags_all= '';													
		if ( $main_tag && !is_wp_error( $main_tag ) ) :
		foreach ( $main_tag as $term_m ) {
		?>
		<div class="col-md-6">
			<label class="form-group"> 
			<input type="checkbox" name="location_arr[]" id="location_arr"  value="<?php echo esc_attr($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>  
		</div>
		<?php	
		}
		endif;	
	?>
	<div class="col-md-12">
		<input type="text" class="form-control" name="new_location" id="new_location" value="" placeholder="<?php  esc_html_e('Enter New Locations: Separate with commas','listfoliopro'); ?>">
	</div>															
</div>
<div class="clearfix"></div>	
<span class="caption-subject">												
	<?php  esc_html_e('listing information','listfoliopro'); ?>
</span>
<hr/>	
<div class="clearfix"></div>

<span class="caption-subject">	
	<?php  esc_html_e('Videos ','listfoliopro'); ?>
</span>
<hr/>
<div class="row">
	<div class=" col-md-6 form-group">
		<label for="text" class=" control-label"><?php  esc_html_e('Youtube','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="youtube" id="youtube" value="" placeholder="<?php  esc_html_e('Enter Youtube video ID, e.g : bU1QPtOZQZU ','listfoliopro'); ?>">
	</div>
	<div class="col-md-6  form-group">
		<label for="text" class=" control-label"><?php  esc_html_e('vimeo','listfoliopro'); ?></label>
		<input type="text" class="form-control" name="vimeo" id="vimeo" value="" placeholder="<?php  esc_html_e('Enter vimeo ID, e.g : 134173961','listfoliopro'); ?>">
	</div>
</div>	

<hr/>
<span class="caption-subject">	
	<?php  esc_html_e('More Details ','listfoliopro'); ?>
</span>								
<hr/>
<div class="row" id="listfoliopro_fields">
	<?php							
		$post_cats=array();			
		echo ''.$main_class->listfoliopro_listing_fields(0, $post_cats );
	?>	
</div>
<div class="clearfix"></div>	
<span class="caption-subject">	
	<?php  esc_html_e('What’s Nearby ','listfoliopro'); ?>
</span>								
<hr/>
<datalist id="neat_whats"> 
  <option value="Loja">
  <option value="Escola">
  <option value="Universidade">
  <option value="Aeroporto">
  <option value="Centro da cidade">
  <option value="Hospital">
  <option value="Ponto de transporte">
 </datalist> 
	
<div id="public_facilities_div">
	<div class=" row form-group " id="day-row1" >									
		<div class=" col-md-6"> 
			<input type="text" list="neat_whats"  placeholder="<?php  esc_html_e ('What’s Nearby ','listfoliopro'); ?>" name="facilities_name[]" id="facilities_name[]"  class="form-control" />										
		</div>		
		<div  class=" col-md-6">
			<input type="text" class="form-control"  name="facilities_value[]" id="facilities_value[]"  placeholder="<?php  esc_html_e('Enter KM or time','listfoliopro'); ?>">
		</div>
	</div>
</div>
<div class=" row  form-group ">
	<div class="col-md-12" >	
		<button type="button" onclick="listfoliopro_add_public_facilities();"  class="btn btn-small-ar"><?php  esc_html_e('Add More','listfoliopro'); ?></button>
	</div>
</div>	
	
