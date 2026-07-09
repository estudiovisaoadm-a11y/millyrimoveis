<?php
wp_enqueue_style('fontawesome-browser', listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome-browser.css');
wp_enqueue_style('all-font-awesome', 			listfoliopro_ep_URLPATH . 'admin/files/css/fontawesome.css');
wp_enqueue_script( 'listfoliopro_meta-image', listfoliopro_ep_URLPATH . 'admin/files/js/meta-media-uploader.js', array( 'jquery' ) );
		
		
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
	$active_single_fields_saved=get_option('listfoliopro_single_fields_saved' );
	
	
	if($active_single_fields_saved==''){
		$active_single_fields=array();
		$active_single_fields=listfoliopro_get_listing_fields_all_single();
		
	}else{
		$active_single_fields=array();
		$active_single_fields=$active_single_fields_saved;
	}
	$available_fields=array();
	$available_fields=listfoliopro_get_listing_fields_all_single();
	// For top section		
		$fields_top_section_all=listfoliopro_get_fields_top_section();
		$save_fields_top_section=get_option('listfoliopro_fields_top_saved' );
	// End top section
?> 

<div class="row">
	<div class="col-12">	
	</div>
</div>	
<div class="row">		
	<div class="col-md-6 col-sm-12 col-lg-6">	
		<form id="active_single_template_fields" name="active_single_template_fields"  >
			
			<p ><strong><?php esc_html_e('Active Custom Fields For Top Section[ 5 Items are good fit], You can add more custom fields from -> Custom Fields section','listfoliopro');?></strong> </p>
				<div  class="row mb-3">	
				<?php
				$i=0;
					
					
					if(is_array($fields_top_section_all)){
						foreach($fields_top_section_all  as $field_key => $field_value){
							if($field_key!=''){
							$checked='';
							if($save_fields_top_section==''){
								$checked='checked';
							}else{
								if(in_array($field_key, $save_fields_top_section)){$checked='checked';}
							}
							?>								
								<div class="col-md-6 col-lg-6 ">
									<div  class="row mb-3">	
									<label class="col-md-6"><?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>:</label>																				
									<div class="col-md-6" >	
										<label class="switch">
										  <input name="singlie_top_fields[]" type="checkbox" value="<?php echo esc_html($field_key);?>" <?php echo esc_html($checked); ?>>
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
			<ul id="searchfieldsActive" class="connectedSortable">	
				<?php
				$i=0;
					if(is_array($active_single_fields)){
						foreach($active_single_fields  as $field_key => $field_value){
							if($field_key!=''){														
							?>
							<li class="ui-state-default">
								<div class="row">
									<div class="col-md-12 col-lg-6">
										<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>	
										<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_html($field_key);?>">	
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
	
	

	<div class="col-md-6 col-sm-12 col-lg-6">				
		<p class="text-left"> <strong><?php esc_html_e('Available Fields','listfoliopro');?> </strong> </p >
		<ul id="searchfieldsAvailable" class="connectedSortable">  	
			<?php
				if(is_array($available_fields)){
					foreach($available_fields  as $field_key => $field_value){ 
						if(!array_key_exists($field_key,$active_single_fields)){
						?>
						<li class="ui-state-default">
							<div class="row">
								<div class="col-md-12 col-lg-6">
									<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>
									<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_html($field_key);?>">
									
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
		<div id="success_message-single-fields"></div>														
		<button class="button button-primary" onclick="return listfoliopro_update_single_fields();"><?php esc_html_e( 'Save', 'listfoliopro' );?> </button>
		
		
	</div>
</div>