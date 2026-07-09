<?php
	global $wpdb;
	global $current_user;
	$ii=1;
	$main_category='';
	if(isset($_POST['main_category'])){$main_category=sanitize_text_field($_POST['main_category']);}	
	
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
?>
<div class="row">
	<div class="col-12">	
	</div>
</div>	
<div class="row">
	<div class="col-md-12 table-responsive mb-4">
		<form id="dir_fields_max" name="dir_fields_max" class="form-horizontal" role="form" onsubmit="return false;">			
			<table id="listing_fieldsdatatable" name="listing_fieldsdatatable"  class="display table" width="100%">					
				<thead>
					<tr>
						<th > <?php  esc_html_e('Input Detail','listfoliopro')	;?> </th>
						<th> <?php  esc_html_e('Categories','listfoliopro')	;?> </th>
						
					</tr>
				</thead>
				<tbody>							
					<?php
						
						$default_fields = array();
						$field_set=			get_option('listfoliopro_li_fields' );
						$field_image=  get_option( 'listfoliopro_li_field_image' );
						$field_type=  		get_option( 'listfoliopro_li_field_type' );
						$field_type_value=  get_option( 'listfoliopro_li_fieldtype_value' );
						$field_type_cat=  	get_option( 'listfoliopro_field_type_cat' );
						if($field_set!=""){
							$default_fields=get_option('listfoliopro_li_fields' );
						}else{							
							$default_fields_two_arr=listfoliopro_default_custom_fields_with_type();
							$default_fields = $default_fields_two_arr[0];							
							$field_type=  $default_fields_two_arr[1];
						}
						$i=0;								
						foreach ( $default_fields as $field_key => $field_value ) {
						?>
						<tr  id="wpdatatablelistingfield_<?php echo esc_attr($i);?>">
							<td >
								<div class="row mt-2">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"><?php  esc_html_e('Input Name','listfoliopro');?></label>
                                    </div>

                                    <div class="col-md-6 col-6">
                                        <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="<?php echo esc_attr($field_key); ?>">
                                    </div>
								</div>
								<div class="row mt-2">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"><?php  esc_html_e('Label','listfoliopro')	;?></label>
                                    </div>

                                    <div class="col-md-6 col-6">
                                        <input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="<?php echo esc_attr($field_value);?>" >
                                    </div>
								</div>								
								<div class="row mt-2">
                                    <div class="col-md-3 col-6">
                                      <button type="button" onclick="return  listfoliopro_field_image_fun('<?php echo esc_attr($i); ?>');" class="button button-primary mt-1"><?php esc_html_e('Set Icon','listfoliopro');  ?></button>
									</div>
									<div class="col-md-3 col-6" id="meta_image_display<?php echo esc_attr($i); ?>">
									
									<?php  if(isset($field_image[$field_key])){?>
										<img class="img-fluid" src="<?php echo (isset($field_image[$field_key])? esc_url($field_image[$field_key]):'' ); ?>">
										
									<?php
									}
									?>
									</div>
                                    <div class="col-md-6 col-12">
                                        <input type="text" class="form-control" name="meta_image[]" id="meta_image<?php echo esc_attr($i); ?>" value="<?php echo (isset($field_image[$field_key])? esc_url($field_image[$field_key]):'' );?>" >
										<input type="hidden" name="meta_image_id[]" id="meta_image_id<?php echo esc_attr($i); ?>" >
										
                                    </div>
								</div>
								<div class="row mt-2">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"><?php  esc_html_e('Type','listfoliopro');?></label>
                                    </div>

                                    <div class="col-md-6 col-6">
	                                    <?php $field_type_saved= (isset($field_type[$field_key])?$field_type[$field_key]:'' );?>
                                        <select class="form-control" name="field_type[]" id="field_type[]">
                                            <option value="text" <?php echo ($field_type_saved=='text'? "selected":'');?> ><?php esc_html_e('Text','listfoliopro');?></option>
                                            <option value="textarea" <?php echo ($field_type_saved=='textarea'? "selected":'');?> ><?php esc_html_e('Text Area','listfoliopro');?></option>
                                            <option value="dropdown" <?php echo ($field_type_saved=='dropdown'? "selected":'');?> ><?php esc_html_e('Dropdown','listfoliopro');?></option>
                                            <option value="radio" <?php echo ($field_type_saved=='radio'? "selected":'');?> ><?php esc_html_e('Radio button','listfoliopro');?></option>
                                            <option value="datepicker" <?php echo ($field_type_saved=='datepicker'? "selected":'');?> ><?php esc_html_e('Date Picker','listfoliopro');?></option>
                                            <option value="checkbox" <?php echo ($field_type_saved=='checkbox'? "selected":'');?> ><?php esc_html_e('Checkbox','listfoliopro');?></option>
                                            <option value="url" <?php echo ($field_type_saved=='url'? "selected":'');?> ><?php esc_html_e('URL','listfoliopro');?></option>
                                        </select>
                                    </div>
								</div>
								<div class="row mt-2">
                                    <div class="col-md-12 col-12">
                                        <label class="control-label"><?php  esc_html_e('Value[Dropdown,checkbox,Radio]','listfoliopro');?> </label>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <textarea class="form-control" rows="3" name="field_type_value[]" id="field_type_value[]" placeholder="<?php  esc_html_e('Separated by comma','listfoliopro');?> "><?php echo esc_attr((isset($field_type_value[$field_key])?$field_type_value[$field_key]:''));?></textarea>
                                    </div>
								</div>

								<div class="row mt-2">
									<div class="col-md-12">
									<button type="button" class="btn btn-danger btn-sm"  onclick="return listfoliopro_remove_listingfield('<?php echo esc_attr($i); ?>');"  ><span  class="dashicons dashicons-trash ml-1"></span></button>
									</div>	
								</div>	
							</td>
							<td id="categoriesmax_<?php echo esc_attr($i);?>"  >	
									<div class="row mt-2"> 
										<div class="col-md-12">
										<label ><input type="checkbox"  class="all_checked" name="checkcat_all<?php echo esc_attr($i);?>[]"  id="field_categories<?php echo esc_attr($i);?>" > <?php  esc_html_e('Check/Uncheck all','listfoliopro');?> </label>
										</div>
									</div>
								<div class="row mt-2 p-3">
									<?php
										$field_type_cat_saved= (isset($field_type_cat[$field_key])?$field_type_cat[$field_key]:'' ) ;										
										if($field_type_cat_saved==''){$field_type_cat_saved=array('all');}
										$args =array();								
										$args2 = array(
										'type'                     => $listfoliopro_directory_url,
										'orderby'                  => 'name',
										'order'                    => 'ASC',
										'hide_empty'               => 0,
										'hierarchical'             => 1,
										'exclude'                  => '',
										'include'                  => '',
										'number'                   => '',
										'taxonomy'                 => $listfoliopro_directory_url.'-category',
										'pad_counts'               => false
										);
										$main_tag = get_categories( $args2 );										
										if ( $main_tag && !is_wp_error( $main_tag ) ) :
										foreach ( $main_tag as $term_m ) {
											$checked= (in_array($term_m->slug,$field_type_cat_saved)? " checked":'');
											if($field_type_cat_saved=='all'){
												$checked=' checked';
											}
											if($term_m->name!=''){		
											?>
											<div class="col-md-12 col-xl-6">
												<label class="listing-field-cat " ><input type="checkbox"  name="field_categories<?php echo esc_attr($i);?>[]"  id="field_categories<?php echo esc_attr($i);?>" <?php echo esc_attr($checked);?> class="field_categories<?php echo esc_attr($i);?>" value="<?php echo esc_attr($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>
											</div>
											<?php
											}
										}
										endif;
									?>
								</div>
							</td>
							
						</tr>	
						<?php
							$i++;
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th> <?php  esc_html_e('Input Detail','listfoliopro')	;?> </th>
						<th> <?php  esc_html_e('Categories','listfoliopro');?> </th>
						
					</tr>
				</tfoot>
			</table>
			<div id="custom_field_div">
			</div>
			<div class="col-xs-12">
				<button class="button button-primary " onclick="return listfoliopro_add_listingfield();"><span class="dashicons dashicons-plus"></span><?php esc_html_e('Add More Field','listfoliopro');?></button>
			</div>
			<div class="row">					
				<div class="col-md-12">	
					<hr>
					<div id="success_message-fields"></div>														
					<button class="button button-primary" onclick="return listfoliopro_update_dir_fields();"><?php esc_html_e( 'Update', 'listfoliopro' );?> </button>
					<p>&nbsp;</p>
				</div>
			</div>
		</form>					
	</div>
</div>	
<div id="fieldtypemainblank" class="none">
	<?php $field_type_saved= '' ;?>
	<select class="form-control col-md-6 col-6" name="field_type[]" id="field_type[]">
		<option value="text" <?php echo ($field_type_saved=='text'? "selected":'');?> ><?php esc_html_e('Text','listfoliopro');?></option>
		<option value="textarea" <?php echo ($field_type_saved=='textarea'? "selected":'');?> ><?php esc_html_e('Text Area','listfoliopro');?></option>
		<option value="dropdown" <?php echo ($field_type_saved=='dropdown'? "selected":'');?> ><?php esc_html_e('Dropdown','listfoliopro');?></option>
		<option value="radio" <?php echo ($field_type_saved=='radio'? "selected":'');?> ><?php esc_html_e('Radio button','listfoliopro');?></option>
		<option value="datepicker" <?php echo ($field_type_saved=='datepicker'? "selected":'');?> ><?php esc_html_e('Date Picker','listfoliopro');?></option>
		<option value="checkbox" <?php echo ($field_type_saved=='checkbox'? "selected":'');?> ><?php esc_html_e('Checkbox','listfoliopro');?></option>
		<option value="url" <?php echo ($field_type_saved=='url'? "selected":'');?> ><?php esc_html_e('URL','listfoliopro');?></option>
	</select>
</div>
<div id="fieldcat-main" class="none">
	<div class="row p-3">
		<?php																		
			$field_type_cat_saved=array('all');										
			$args =array();											
			$args2 = array(
			'type'                     => $listfoliopro_directory_url,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => $listfoliopro_directory_url.'-category',
			'pad_counts'               => false
			);
			$main_tag = get_categories( $args2 );										
			if ( $main_tag && !is_wp_error( $main_tag ) ) :
			foreach ( $main_tag as $term_m ) {											
				$checked=' checked';											
			?>										
			<div class="col-md-12 col-xl-6">
				<label class="listing-field-cat" > <input type="checkbox"  name="field_categories<?php echo esc_attr($i);?>[]"  id="field_categories<?php echo esc_attr($i);?>[]" <?php echo esc_attr($checked);?> value="<?php echo esc_attr($term_m->slug); ?>"> <?php echo esc_html($term_m->name); ?> </label>
			</div>
			<?php
			}
			endif;										
		?>
	</div>
</div>
<?php
	wp_enqueue_script('listfoliopro_eplugins-dashboard5', listfoliopro_ep_URLPATH.'admin/files/js/profile-fields.js', array('jquery'), $ver = true, true );
	wp_localize_script('listfoliopro_eplugins-dashboard5', 'profile_data', array( 			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'adminnonce'=> wp_create_nonce("admin"),
	'pii'	=>$ii,
	'pi'	=> $i,
	'signup_field_serial'	=> $listfoliopro_signup_fields_serial,
	"sProcessing"=>  esc_html__('Processing','listfoliopro'),
	"InputName"=>  esc_html__('Input Name','listfoliopro'),
	"Label"=>  esc_html__('Label','listfoliopro'),
	"Type"=>  esc_html__('Type','listfoliopro'),
	"set_image"=>  esc_html__('Set Image','listfoliopro'),
	"Value"=>  esc_html__('Value','listfoliopro'),
	"sProcessing"=>  esc_html__('Processing','listfoliopro'),
	"sSearch"=>   esc_html__('Search','listfoliopro'),
	"lengthMenu"=>   esc_html__('Display _MENU_ records per page','listfoliopro'),
	"zeroRecords"=>  esc_html__('Nothing found - sorry','listfoliopro'),
	"info"=>  esc_html__('Showing page _PAGE_ of _PAGES_','listfoliopro'),
	"infoEmpty"=>   esc_html__('No records available','listfoliopro'),
	"infoFiltered"=>  esc_html__('(filtered from _MAX_ total records)','listfoliopro'),
	"sFirst"=> esc_html__('First','listfoliopro'),
	"sLast"=>  esc_html__('Last','listfoliopro'),
	"sNext"=>     esc_html__('Next','listfoliopro'),
	"sPrevious"=>  esc_html__('Previous','listfoliopro'),
	"ValueDropdownLabel"=>  esc_html__('Value[Dropdown,checkbox,Radio]','listfoliopro'),
	"Registration"=>  esc_html__('Registration','listfoliopro'),
	"MyAccountProfile"=>  esc_html__('My Account/Profile','listfoliopro'),
	"Require"=>  esc_html__('Require','listfoliopro'),
	"EnterMenuTitle"=>  esc_html__('Enter Menu Title','listfoliopro'),
	"EnterMenuLink"=>  esc_html__('Enter Menu Link. Example http://www.google.com','listfoliopro'),
	"Delete"=>  esc_html__('Delete','listfoliopro'),
	) );
?>	
