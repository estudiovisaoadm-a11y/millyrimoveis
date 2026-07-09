<?php
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	
	$active_search_fields_saved=get_option('listfoliopro_search_fields_saved' );
	if($active_search_fields_saved==''){
		$active_search_fields=array();
		$active_search_fields[$listfoliopro_directory_url.'-category']='multi-checkbox';
		$active_search_fields[$listfoliopro_directory_url.'-tag']='multi-checkbox';
		$active_search_fields[$listfoliopro_directory_url.'-locations']='drop-down';
		$active_search_fields['near_to_me']='text-field';
		$active_search_fields['title']='text-field';		
				
		
		
	}else{
		$active_search_fields=array();
		$active_search_fields=$active_search_fields_saved;
	}
	
	
	$no_dropdown=array('near_to_me','address','price_slider');
	$only_dropdown=array('sort_listing');
	$only_multi_checkbox=array('review');	
	
	$available_fields= listfoliopro_get_available_search_fields();
	$args = array(
		'child_of'     => 0,
		'sort_order'   => 'ASC',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,															
		'post_type' => 'page'
		);
	
?> 
<div class="row">
	<div class="col-md-12">	
	</div>
</div>
<div class="row">		
	<div class="col-md-6">	
		<p ><strong><?php esc_html_e('Active Fields','listfoliopro');?></strong> </p>
		<form id="search_active_fields" name="search_active_fields"  >
				<div class="form-group ">	
					<?php
					$listfoliopro_search_action_target=get_option('listfoliopro_search_action_target' );
					?>								
						<label  class="  control-label"><?php esc_html_e( 'Form Submit Action Terget:', 'listfoliopro' );?> </label>
					<?php
						if ( $pages = get_pages( $args ) ){
							echo "<select id='listfoliopro_search_action_target' name='listfoliopro_search_action_target' class='form-control  '>";
							echo "<option value='same_page' ".($listfoliopro_search_action_target=='same_page' ? 'selected':'').">".esc_html__( 'Same Page', 'listfoliopro' )."</option>";
							
							echo "<option value='default_archive' ".($listfoliopro_search_action_target=='default_archive' ? 'selected':'').">".esc_html__( 'Default Archive Page', 'listfoliopro' )."</option>";
							
							foreach ( $pages as $page ) {
								if($page->post_title!=''){
								echo "<option value='".esc_url(get_permalink($page->ID))."'". ($listfoliopro_search_action_target==get_permalink($page->ID) ? 'selected':'').">".esc_html($page->post_title)."</option>";
								
								}
							}
							echo "</select>";
						}
					?>
				</div>				
			<ul id="searchfieldsActive" class="connectedSortable">	
				<?php
					if(is_array($active_search_fields)){
						foreach($active_search_fields  as $field_key => $field_value){
							if($field_key!=''){
							?>
							<li class="ui-state-default">
								<div class="row">
									<div class="col-md-12 col-lg-6">
											<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>
									</div>
									<div class="col-md-12 col-lg-6">
											<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_attr($field_key);?>">
											<?php
											if(in_array($field_key ,$no_dropdown)){?>
											<select class="form-control" id="search-field-type" name="search-field-type[]">							
													<option value="text-field"><?php esc_html_e('text-field','listfoliopro');?> </option>
												</select>
											<?php
											}elseif(in_array($field_key ,$only_multi_checkbox)){?>
												<select class="form-control" id="search-field-type" name="search-field-type[]">	
													<option value="multi-checkbox" <?php echo ($field_value=='multi-checkbox'? 'selected' :''); ?>> <?php esc_html_e('Multi Checkbox','listfoliopro');?> </option>
												</select>
											<?php
											}elseif(in_array($field_key ,$only_dropdown)){?>
												<select class="form-control" id="search-field-type" name="search-field-type[]">	
													<option value="drop-down"> <?php esc_html_e('Drop Down','listfoliopro');?> </option>
												</select>
											<?php
											}else{
											?>
											<select class="form-control" id="search-field-type" name="search-field-type[]">								
												<option value="text-field" <?php echo ($field_value=='text-field'? 'selected' :''); ?>> <?php esc_html_e('Text Field','listfoliopro');?> </option>
												<option value="drop-down" <?php echo ($field_value=='drop-down'? 'selected' :''); ?> > <?php esc_html_e('Drop Down','listfoliopro');?> </option>
												<option value="multi-checkbox" <?php echo ($field_value=='multi-checkbox'? 'selected' :''); ?>> <?php esc_html_e('Multi Checkbox','listfoliopro');?> </option>
												<?php	
												if($field_key==$listfoliopro_directory_url.'-category' OR $field_key==$listfoliopro_directory_url.'-tag' OR $field_key==$listfoliopro_directory_url.'-locations'){?>
													<option value="multi-checkbox-group" <?php echo ($field_value=='multi-checkbox-group'? 'selected' :''); ?>> <?php esc_html_e('Multi Checkbox-Sub-Group','listfoliopro');?> </option>
												
												<?php
												}
												?>
												
												<option value="datefield" <?php echo ($field_value=='datefield'? 'selected' :''); ?>> <?php esc_html_e('Date','listfoliopro');?> </option>
											</select>
											<?php
											}
											?>
									</div>									
								</div>	
							</li>				
							<?php
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
						if(!array_key_exists($field_key,$active_search_fields)){
						?>
						<li class="ui-state-default">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<?php echo esc_html(ucfirst(str_replace('_',' ',$field_key))); ?>
							</div>
							<div class="col-md-12 col-lg-6">
								<input type="hidden" name="search-field-name[]" id="search-field-name" value="<?php echo esc_html($field_key);?>">
								<?php
								if(in_array($field_key ,$no_dropdown)){
									?>
									<select class="form-control" id="search-field-type" name="search-field-type[]">							
											<option value="text-field"><?php esc_html_e('text-field','listfoliopro');?> </option>
									</select>
								
								<?php
								}elseif(in_array($field_key ,$only_multi_checkbox)){?>
										<select class="form-control" id="search-field-type" name="search-field-type[]">	
											<option value="multi-checkbox" <?php echo ($field_value=='multi-checkbox'? 'selected' :''); ?>> <?php esc_html_e('Multi Checkbox','listfoliopro');?> </option>
										</select>
								<?php
								}elseif(in_array($field_key ,$only_dropdown)){?>
										<select class="form-control" id="search-field-type" name="search-field-type[]">	
											<option value="drop-down"> <?php esc_html_e('Drop Down','listfoliopro');?> </option>
										</select>
									<?php
								}else{
								?>
								<select class="form-control" id="search-field-type" name="search-field-type[]">								
									<option value="text-field"> <?php esc_html_e('Text Field','listfoliopro');?> </option>
									<option value="drop-down"> <?php esc_html_e('Drop Down','listfoliopro');?> </option>
									<option value="multi-checkbox"> <?php esc_html_e('Multi Checkbox','listfoliopro');?> </option>
									<?php	
										if($field_key==$listfoliopro_directory_url.'-category' OR $field_key==$listfoliopro_directory_url.'-tag' OR $field_key==$listfoliopro_directory_url.'-locations'){?>
											<option value="multi-checkbox-group" <?php echo ($field_value=='multi-checkbox-group'? 'selected' :''); ?>> <?php esc_html_e('Multi Checkbox-Sub-Group','listfoliopro');?> </option>
										
										<?php
										}
										?>
									<option value="datefield"> <?php esc_html_e('Date','listfoliopro');?> </option>
								</select>
								<?php
								}
								?>
							</div>							
						</div>						
						</li>				
						<?php
						}
					}
				}
			?>
		</ul>
	</div>
</div>
<div class="row bottom20 " >					
	<div class="col-md-12">	
		<div id="success_message-search-fields"></div>														
		<button class="listfoliopro-button" onclick="return listfoliopro_update_search_fields();"><?php esc_html_e( 'Save', 'listfoliopro' );?> </button>
		<button class="listfoliopro-button" onclick="return listfoliopro_create_search_shortcode();"><?php esc_html_e( 'Get Shortcode', 'listfoliopro' );?> </button>
		<form name="savedsearch_shortcodes" id="savedsearch_shortcodes">
			<h4><?php esc_html_e( 'Previously generated shortcodes:', 'listfoliopro' );?> </h4>
			<div id="create_search_shortcode_update_message"></div>
			<div id="create_search_shortcode">
			
			<?php
				
				$listfoliopro_search_shortcodes_saved=get_option('listfoliopro_search_shortcodes_saved' );
				
				$i=0;
				if(is_array($listfoliopro_search_shortcodes_saved )){
					foreach($listfoliopro_search_shortcodes_saved  as $field_key => $field_value ){
						if($field_value!=''){?>
						<div class="row " id="searchshortcode<?php echo esc_attr($i); ?>" >
							
								<input name="shortcodearr[]" type="hidden" value='<?php echo esc_attr($field_value); ?>'>
								<?php
								echo'<div class="col-md-11" id="searchshortcodedata'.esc_attr($i).'">'.esc_html($field_value).'</div><div class="col-md-1"><span onclick="return listfoliopro_remove_saved_shortcode('.esc_attr($i).')" class="dashicons dashicons-trash"></span></div>';
						?>
							
						</div><hr/>
						<?php
						$i++;
						}
					}
				}
			?>
			
			
			</div>	
		</form>
	</div>
</div>