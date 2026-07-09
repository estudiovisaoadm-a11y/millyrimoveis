<?php
wp_enqueue_style('fontawesome-browser', listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome-browser.css');	
wp_enqueue_style('all-font-awesome', 			listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome.css');
wp_enqueue_script( 'listfoliopro_meta-image', listfoliopro_ep_URLPATH . 'admin/files/js/meta-media-uploader.js', array( 'jquery' ) );		
	
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
	$active_archive_fields=listfoliopro_get_archive_fields_all();	
	$active_archive_icon_saved=get_option('listfoliopro_archive_icon_saved' );		
	$available_fields=listfoliopro_get_listing_fields_all();
	
	$archive_field_label=get_option('archive_field_label');
	if($archive_field_label==""){$archive_field_label='no'; }
	// For top sort		
		$fields_top_section_all=listfoliopro_get_fields_sort_section();
		$listfoliopro_top_sort_saved=get_option('listfoliopro_top_sort_saved' );
	// End top sort
?> 
<div class="row">
	<div class="col-12">	
	</div>
</div>	
<div class="row">		
	<div class="col-md-6">	
	
		<form id="search_active_archive_fields" name="search_active_archive_fields"  >	
			
			
<p ><strong><?php esc_html_e('Top Right Sort Items, You can add more custom fields from -> Custom Fields section','listfoliopro');?></strong> </p>
				<div  class="row mb-3">	
				<?php
				$i=0;
					if(is_array($fields_top_section_all)){
						foreach($fields_top_section_all  as $field_key => $field_value){
							if($field_key!=''){
							$checked='';
							if($listfoliopro_top_sort_saved==''){
								$checked='checked';
							}else{
								if(in_array($field_key, $listfoliopro_top_sort_saved)){$checked='checked';}
							}
							?>								
								<div class="col-md-6 col-lg-6 ">
									<div  class="row mb-3">	
									<label class="col-md-6"><?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>:</label>																				
									<div class="col-md-6" >	
										<label class="switch">
										  <input name="sort_top_fields[]" type="checkbox" value="<?php echo esc_html($field_key);?>" <?php echo esc_html($checked); ?>>
										  <span class="slider round"></span>
										</label>
									</div>
									</div>
								</div>
										
							<?php
								$i++;
							}
						}
					}
				?>			
			</div>
				<p ><strong><?php esc_html_e('Active Fields','listfoliopro');?></strong> </p>
				<label class="listing-field-label" > <input type="checkbox"  name="archive_field_label"  id="archive_field_label" <?php echo ($archive_field_label=='with_label'? 'checked':'');?> value="with_label"> <?php esc_html_e('Display Field Value + Label , e.g : 4 Beds','listfoliopro');?> </label>
			
				<ul id="searchfieldsActive" class="connectedSortable">					
				<?php
				$i=0;
				if(is_array($active_archive_fields)){
					foreach($active_archive_fields  as $field_key => $field_value){
						if($field_key!=''){
							$saved_icon='';
							if(isset($active_archive_icon_saved[$field_key])){
								$saved_icon=$active_archive_icon_saved[$field_key];
							}
						?>
						<li class="ui-state-default">
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>
									
								</div>
								<div class="col-md-12 col-lg-6">															
										<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_html($field_key);?>">
										<?php
										if( $field_key=='top_search_form'){
										?>									
											<select name="field_icon[]" id="field_icon<?php echo esc_attr($i); ?>" class="form-control">
												
												<option value="on-page" <?php echo ($saved_icon=='on-page'?' selected':''); ?>><?php esc_html_e('Search Form on the page','listfoliopro'); ?></option>
												<option value="no-search" <?php echo ($saved_icon=='no-search'?' selected':''); ?>><?php esc_html_e('No Search Form Option','listfoliopro'); ?></option>
											</select>
										<?php										
										}
										?>								
								</div>								
							</div>	
						</li>				
						<?php
							$i++;
						}
					}
				}
				?>			
			</ul>
		</form>
	</div>
	<div class="col-md-6">	
		<p class="text-left"> <strong><?php esc_html_e('Available Fields','listfoliopro');?> </strong> </p >
		<ul id="searchfieldsAvailable" class="connectedSortable">  	
			<?php
				if(is_array($available_fields)){
					foreach($available_fields  as $field_key => $field_value){ 
						if(!array_key_exists($field_key,$active_archive_fields)){
						?>
						<li class="ui-state-default">
							
							<div class="row">
								<div class="col-md-12 col-lg-6">	
									<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>
									<?php
										if( $field_key!='category' AND $field_key!='top_search_form'){
											?>							
											
									<?php
										}
									?>									
								</div>
								<div class="col-md-12 col-lg-6">
									<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_html($field_key);?>">
									<?php
									if( $field_key=='category'){
										?>									
									
									
									<?php
									}elseif( $field_key=='top_search_form'){
									?>									
										<select name="field_icon[]" id="field_icon<?php echo esc_attr($i); ?>" class="form-control">
											<option value="on-page" ><?php esc_html_e('Search Form on The Page','listfoliopro'); ?></option>
											<option value="no-search" ><?php esc_html_e('No Search Form Option','listfoliopro'); ?></option>
										</select>
									<?php
									}else{
									?>	
									
									<?php
									}
									?>
								</div>								
							</div>
						</li>				
						<?php
							$i++;
						}
					}
				}
			?>
		</ul>
	</div>
</div>
<div class="row bottom20 " >					
	<div class="col-md-12">	
		<div id="success_message-archive-fields"></div>														
		<button class="button button-primary" onclick="return listfoliopro_update_archive_fields();"><?php esc_html_e( 'Save', 'listfoliopro' );?> </button>
	</div>
</div>