<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	$dir_map_api=get_option('listfoliopro_map_api');
	if($dir_map_api==""){$dir_map_api='';}	
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	$map_api_have='no';
?>

		
<?php					
	global $wpdb;
	// Check Max\
	$max=999999;									 
	 
	$listfoliopro_pack='listfoliopro_pack';
	$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'  and post_status='draft' ",$listfoliopro_pack );
	$membership_pack = $wpdb->get_results($sql);
	$total_package = count($membership_pack);
	$max=999999;
	$package_id=get_user_meta($current_user->ID,'listfoliopro_package_id',true);
					
	if($package_id!=""){  					
		$max=get_post_meta($package_id, 'listfoliopro_package_max_post_no', true);
	}											
	if($package_id=="" OR $package_id=="0"){  						
		global $wpdb;
		$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s' and post_status='draft'", $listfoliopro_pack);
		$membership_pack = $wpdb->get_results($sql);
		$total_package=count($membership_pack);								
		if($total_package>0){		  						
			$max=get_post_meta($package_id, 'listfoliopro_package_max_post_no', true);
		}else{ 
			 $max=999999;
		}	
	}		
	
	if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
		$max=999999;
	}		
						 
	
	$sql=$wpdb->prepare("SELECT count(*) as total FROM $wpdb->posts WHERE post_type ='%s' and post_status IN ('publish','pending','draft') and post_author='%d'",$listfoliopro_directory_url, $current_user->ID);
	$all_post = $wpdb->get_row($sql);
	$my_post_count=$all_post->total;
	if ( $my_post_count>=$max or !current_user_can('edit_posts') )  { 
		$iv_redirect = get_option('listfoliopro_profile_page');
		$reg_page= get_permalink( $iv_redirect); 							
	?>
	<?php  esc_html_e('Please Upgrade Your Account','listfoliopro'); ?>
	<a href="<?php echo esc_url($reg_page).'?&profile=level'; ?>" title="Upgarde"><b><?php  esc_html_e('Here','listfoliopro'); ?> </b></a>
	<?php  esc_html_e('To Add More Post.','listfoliopro'); ?>
	<?php
		}else{	
	?>					
	<div class="row">
		<div class="col-md-12">	 
			<form action="" id="new_post" name="new_post"  method="POST" role="form">
				<div class=" form-group">
					<label for="text" class=" control-label"><?php  esc_html_e('Title','listfoliopro'); ?></label>
					<div class="  "> 
						<input type="text" class="form-control" name="title" id="title" value="" placeholder="<?php  esc_html_e('Enter Title Here','listfoliopro'); ?>">
					</div>																		
				</div>
				<?php
				$listfoliopro_active_chatGPT=get_option('listfoliopro_active_chatGPT');
				if($listfoliopro_active_chatGPT==""){$listfoliopro_active_chatGPT='yes';}
				if($listfoliopro_active_chatGPT=="yes"){
				?>
				<div class="row">
					<div class="col-md-12 "> <hr/>											
						<button type="button" onclick="listfoliopro_chatgtp_settings_popup();"  class="btn green-haze mt-2 mb-2"><?php  esc_html_e('Create Post Using ChatGPT ',	'listfoliopro'); ?></button>
						<div id="chatgpt-message"></div>
					</div>						
				</div>	
				<?php
				}
				?>
				<input type="hidden" name="feature_image_id" id="feature_image_id" value="">
				
				<div class=" form-group row mt-2 ">	
						<div class="col-md-6" id="post_image_div">				
						</div> 
						
						<div class="col-md-6" id="post_image_edit">	
							<button type="button" onclick="listfoliopro_edit_post_image('post_image_div');"  class="btn btn-small-ar"><?php  esc_html_e('Feature Image[best fit 450X350]','listfoliopro'); ?> </button>
						</div>									
				</div>
				
				<span class="caption-subject">											
					<?php  esc_html_e('Image Gallery','listfoliopro'); ?>
				</span>
				<hr/>
			
					<input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="">
					<div class="row" id="gallery_image_div">
					
					</div>									
				
				<div class="row">										
					<div class="  form-group col-md-12">									
						<button type="button" onclick="listfoliopro_edit_gallery_image('gallery_image_div');"  class="btn btn-small-ar mt-2"><?php  esc_html_e('Add Images','listfoliopro'); ?></button>
					</label>						
					</div>
				</div>
				<div class=" row  form-group ">	
					<div class=" col-md-12 form-group">
						<label for="text" class=" control-label"><?php  esc_html_e('360 Image URL','listfoliopro'); ?></label>
						<input type="text" class="form-control" name="360_image" id="360_image" value="" placeholder="<?php  esc_html_e('Enter 360 image URL','listfoliopro'); ?>">
					</div>
				</div>	
			
			
			<input type="hidden" name="topbanner_image_id" id="topbanner_image_id" value="">	
				<div class="form-group">
					<label for="text" class="control-label"><?php  esc_html_e('Listing Description','listfoliopro'); ?>  </label>
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
				<hr/>
				<div class="clearfix"></div>
				<span class="caption-subject mt-2">												
					<?php  esc_html_e('Categories','listfoliopro'); ?>
				</span>
				<hr/>
				
					<div class=" form-group row mt-2"  id="listfolioprocats-container">
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
					<span class="caption-subject mt-2">	
					 <?php esc_html_e( 'Listing Details ', 'listfoliopro' ); ?>
				</span>								
				<hr/>
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
				
				
				<div class="row mt-2" >
					<div class="col-md-12" id="listfoliopro_fields">
					<?php							
							$post_cats=array();			
							echo ''.$main_class->listfoliopro_listing_fields(0, $post_cats );
						?>	
						</div>
				</div>
				<span class="caption-subject">														
					<?php  esc_html_e('Contact Info','listfoliopro'); ?>
				</span>
				<hr/>
				<?php
				
					$listing_contact_source='new_value';
					
				?>
				<div class=" form-group mt-2">	
					<div class="radio">											
						<label><input type="radio" name="contact_source" value="user_info"  class="mr-1" <?php echo ($listing_contact_source=='user_info'?'checked':''); ?> > <?php  esc_html_e(' Use The company Info ->','listfoliopro'); ?> <?php echo ucfirst($current_user->display_name); ?><?php  esc_html_e(' : Image, Email, Phone, Website','listfoliopro'); ?> <a href="<?php echo get_permalink().'?profile=setting';?>" target="_blank"> <?php  esc_html_e('Edit','listfoliopro'); ?> </a></label>
					</div>
					<div class="radio">
						<label><input type="radio" name="contact_source" value="new_value" class="mr-1" <?php echo ($listing_contact_source=='new_value'?'checked':''); ?>><?php  esc_html_e(' New Contact Info','listfoliopro'); ?>  </label>
					</div>
				</div>
				<div  class="row" id="new_contact_div" <?php echo ($listing_contact_source=='user_info'?'style="display:none"':''); ?> >
					
					<div class=" form-group col-md-6">
						<label for="text" class=" control-label"><?php  esc_html_e('Agent Name','listfoliopro'); ?></label>
						<input type="text" class="form-control" name="company_name" id="company_name" value="" placeholder="<?php  esc_attr_e('Company name','listfoliopro'); ?>">
					</div>
					<div class=" form-group col-md-6">
						<label for="text" class=" control-label"><?php  esc_html_e('Phone','listfoliopro'); ?></label>
						<input type="text" class="form-control" name="phone" id="phone" value="" placeholder="<?php  esc_attr_e('Enter Phone Number','listfoliopro'); ?>">
					</div>
					<div class=" form-group col-md-6">
						<label for="text" class=" control-label"><?php  esc_html_e('Whats Up','listfoliopro'); ?></label>
						<input type="text" class="form-control" name="whatsapp" id="whatsapp" value="" placeholder="<?php  esc_attr_e('Enter whats up Number','listfoliopro'); ?>">
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
				
				
				
					
				<div class="clearfix"></div>
				<span class="caption-subject">												
					<?php  esc_html_e('Tags','listfoliopro'); ?>
				</span>
				<hr/>
				
				<div class=" row mt-2">		
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
				
				<div class=" row mt-2 mb-3">		
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
					<?php  esc_html_e('Videos ','listfoliopro'); ?>
				</span>
				
				<hr/>
			
					<div class="row mt-2">
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
				<span class="caption-subject mt-2">											
					<?php  esc_html_e('Attached Doc','listfoliopro'); ?>
					</span>
				<hr/>			
					<input type="hidden" name="attached_ids" id="attached_ids" value="">
					<div id="attached_div">
					
					</div>									
				
				<div class="row ">										
					<div class="  form-group col-md-12">									
						<button type="button" onclick="listfoliopro_attached_doc('attached_div');"  class="btn btn-small-ar mt-2"><?php  esc_html_e('Add Attachments','listfoliopro'); ?></button>
					</label>						
					</div>
				</div>
								
				<div class="clearfix"></div>	
							<span class="caption-subject">	
								<?php  esc_html_e('What’s Nearby ','listfoliopro'); ?>
							</span>								
							<hr/>
							<datalist id="neat_whats"> 
							  <option value="Shop">
							  <option value="School">
							  <option value="University">
							  <option value="Airport">
							  <option value="City center">
							  <option value="Hospital">
							  <option value="CPT stop">
							 </datalist> 
								
							<div id="public_facilities_div">
								<div class=" row form-group " id="public_facilities_row1" >									
									<div class=" col-md-6"> 
										<input type="text" list="neat_whats"  placeholder="<?php  esc_html_e ('What’s Nearby ','listfoliopro'); ?>" name="facilities_name[]" id="facilities_name[]"  class="form-control" />										
									</div>		
									<div  class=" col-md-6">
										<input type="text" class="form-control"  name="facilities_value[]" id="facilities_value[]"  placeholder="<?php  esc_html_e('Enter KM or time','ivproperty'); ?>">
									</div>
								</div>
							</div>
							<div class=" row  form-group ">
								<div class="col-md-12" >	
									<button type="button" onclick="listfoliopro_add_public_facilities();"  class="btn btn-small-ar"><?php  esc_html_e('Add More','ivproperty'); ?></button>
								</div>
							</div>	
				
				
				<hr/>		
				<div class="clearfix"></div>	
				<span class="caption-subject">	
					<?php  esc_html_e('Time','listfoliopro'); ?>
				</span>								
				<hr/>
				<div class="row mt-2">
					<?php							
						include( listfoliopro_ep_template. 'private-profile/listing-open-close-time.php');
						?>		
				</div>
				
				<hr/>		
				<div class="clearfix"></div>	
				<span class="caption-subject">	
					<?php  esc_html_e('Social Profile ','listfoliopro'); ?>
				</span>								
				<hr/>
				<div class="row mt-2">
					<?php							
						include( listfoliopro_ep_template. 'private-profile/profile-social.php');
						?>		
				</div>
				
				
				
				
				<div class="clearfix"></div>
				 <hr/>
				<div class="row mt-2">
					<div class="col-md-12  ">
						<div class="" id="update_message"></div>
						<input type="hidden" name="user_post_id" id="user_post_id" value="0">
						<button type="button" onclick="listfoliopro_save_post();"  class="btn green-haze"><?php  esc_html_e('Save Post',	'listfoliopro'); ?></button>						
					</div>						
				</div>	
			</form>
		</div>
	
	<?php
	} // for Role
?>
				
		
<!-- END PROFILE CONTENT -->
<?php
	$save_address='';
	
	$my_theme = wp_get_theme();
	$theme_name= strtolower($my_theme->get( 'Name' ));
	wp_enqueue_script('listfoliopro_add-edit-listing', listfoliopro_ep_URLPATH . 'admin/files/js/add-edit-listing.js');
	wp_localize_script('listfoliopro_add-edit-listing', 'realpro_data', array(
	'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),
	'loading_image'			=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'		=>get_current_user_id(),
	'Set_Feature_Image'	=> esc_html__('Set Feature Image','listfoliopro'),
	'Set_plan_Image'		=> esc_html__('Set plan Image','listfoliopro'),
	'Set_Event_Image'		=> esc_html__('Set Event Image','listfoliopro'),
	'Gallery_Images'		=> esc_html__('Gallery Images','listfoliopro'),
	'attached_doc'		=> esc_html__('Set Doc','listfoliopro'),
	'permalink'				=> get_permalink(),
	'save_address'			=> $save_address,
	'dirwpnonce'			=> wp_create_nonce("addlisting"),
	'theme_name'			=> $theme_name,
	) );
?> 