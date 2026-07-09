<?php
	$ii=1;
	global $wp_roles;
	
	
?> 
<div class="row">
			<div class="col-md-12 table-responsive mb-4">

		<h4><?php esc_html_e('Registration / User Profile Fields','listfoliopro');?></h4>
		<form id="profile_fields_signup" name="profile_fields_signup" class="form-horizontal" role="form" onsubmit="return false;">
			<table id="all_fieldsdatatable" name="all_fieldsdatatable"  class="display table" width="100%">					
				<thead>
					<tr>
						<th> <?php  esc_html_e('Input Detail','listfoliopro')	;?> </th>
						<th> <?php  esc_html_e('User Role & Section ','listfoliopro');?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php  esc_html_e('User Profile Pic Uploader','listfoliopro');
								$listfoliopro_signup_profile_pic=get_option('listfoliopro_signup_profile_pic');
								if($listfoliopro_signup_profile_pic=='' ){ $listfoliopro_signup_profile_pic='yes';	}		
							?>
						</td>						
						<td> <label>
							<input type="checkbox" name="signup_profile_pic" id="signup_profile_pic" value="yes" <?php echo($listfoliopro_signup_profile_pic=='yes'? 'checked':'' );?> >
							 
							 <?php  esc_html_e('Registration','listfoliopro');?>
						</label></td>
						
										
					</tr>	
					<tr>
						<td>
							<?php  esc_html_e('Terms CheckBox','listfoliopro')	;
								$listfoliopro_payment_terms=get_option('listfoliopro_payment_terms');
								if($listfoliopro_payment_terms=='' ){ $listfoliopro_payment_terms='yes';	}
							?>
						</td>
						
						<td> <label>
							<input type="checkbox" name="listfoliopro_payment_terms" id="listfoliopro_payment_terms" value="yes" <?php echo($listfoliopro_payment_terms=='yes'? 'checked':'' );?> >
							<?php  esc_html_e('Registration','listfoliopro');?>
						</label>						
						</td>
										
					</tr>	
					<tr>
						<td>
							<?php  esc_html_e('Coupon Buton','listfoliopro')	;
								$listfoliopro_payment_coupon=get_option('_listfoliopro_payment_coupon');
								if($listfoliopro_payment_coupon=='' ){ $listfoliopro_payment_coupon='yes';	}
							?>
						</td>	
						<td> <label>
							<input type="checkbox" name="listfoliopro_payment_coupon" id="listfoliopro_payment_coupon" value="yes" <?php echo($listfoliopro_payment_coupon=='yes'? 'checked':'' );?> >
							<?php  esc_html_e('Registration','listfoliopro');?>
						</label></td>
						
						
					</tr>	
					<?php
						
						$default_fields = array();
						$field_set=get_option('listfoliopro_profile_fields' );
						if($field_set!=""){
							$default_fields=$field_set;
							}else{									
							$default_fields['full_name']=esc_html__('Full Name','listfoliopro');	
							$default_fields['tagline']=esc_html__('Tag line','listfoliopro');
							$default_fields['company_since']=esc_html__('Estd Since','listfoliopro');
							$default_fields['team_size']=esc_html__('Team Size','listfoliopro');									
							$default_fields['phone']=esc_html__('Phone Number','listfoliopro');
							$default_fields['mobile']=esc_html__('Mobile Number','listfoliopro');
							$default_fields['whatsapp']=esc_html__('Whatsup Number','listfoliopro');
							$default_fields['address']=esc_html__('Address','listfoliopro');
							$default_fields['city']=esc_html__('City','listfoliopro');
							$default_fields['postcode']=esc_html__('Postcode','listfoliopro');
							$default_fields['state']=esc_html__('State','listfoliopro');
							$default_fields['country']=esc_html__('Country','listfoliopro');										
							$default_fields['listing_title']=esc_html__('listing title','listfoliopro');
							$default_fields['website']=esc_html__('Website Url','listfoliopro');
							$default_fields['description']=esc_html__('About','listfoliopro');
						}
						$i=0;								
						$field_type_opt=  get_option( 'listfoliopro_field_type' );
						if($field_type_opt!=''){
							$field_type=$field_type_opt;
							}else{	
							$field_type= array();
							$field_type['full_name']='text';								
							$field_type['company_since']='datepicker';
							$field_type['team_size']='text';									
							$field_type['phone']='text';
							$field_type['mobile']='text';
							$field_type['address']='text';
							$field_type['city']='text';
							$field_type['postcode']='text';
							$field_type['state']='text';
							$field_type['country']='text';										
							$field_type['listing_title']='text';	
							$field_type['website']='url';
							$field_type['description']='textarea';									
						}
						$field_type_value= get_option( 'listfoliopro_field_type_value' );
						if($field_type_value==''){
							$field_type_value=array();
							$field_type_value['gender']=esc_html__('Female,Male,Other', 'listfoliopro');	
						}
						$field_type_roles=  	get_option( 'listfoliopro_field_type_roles' );
						$sign_up_array=  get_option( 'listfoliopro_signup_fields' );
						$myaccount_fields_array=  get_option( 'listfoliopro_myaccount_fields' );
						$require_array=  get_option( 'listfoliopro_signup_require' );								
						foreach ( $default_fields as $field_key => $field_value ) {
							$sign_up='';									
							if(isset($sign_up_array[$field_key]) && $sign_up_array[$field_key] == 'yes') {
								$sign_up=$sign_up_array[$field_key] ;
							}
							$require='';
							if(isset($require_array[$field_key]) && $require_array[$field_key] == 'yes') {
								$require=$require_array[$field_key];
							}
							$myaccount_one='';									
							if(isset($myaccount_fields_array[$field_key]) && $myaccount_fields_array[$field_key] == 'yes') {
								$myaccount_one=$myaccount_fields_array[$field_key];
							}
						?>
						<tr  id="wpdatatablefield_<?php echo esc_attr($i);?>">
							<td >
								<div class="row form-group">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"> <?php  esc_html_e('Input Name','listfoliopro');?></label>
                                    </div>

									<div class="col-md-6 col-6">
                                        <input type="text" class="form-control" name="meta_name[]" id="meta_name[]" value="<?php echo esc_attr($field_key); ?>">
                                    </div>
								</div>

								<div class="row form-group">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"><?php  esc_html_e('Label','listfoliopro')	;?></label>
                                    </div>
										<div class="col-md-6 col-6">
                                            <input type="text" class="form-control" name="meta_label[]" id="meta_label[]" value="<?php echo esc_attr($field_value);?>" >
                                        </div>
								</div>

								<div class="row form-group" id="inputtypell_<?php echo esc_attr($i);?>">
                                    <div class="col-md-6 col-6">
                                        <label class="control-label"><?php  esc_html_e('Type','listfoliopro');?></label>
                                    </div>

									<div class="col-md-6 col-6 ">
										<?php $field_type_saved= (isset($field_type[$field_key])?$field_type[$field_key]:'' );?>
                                        <select class="form-control listfoliopro-select" name="field_type[]" id="field_type[]">
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
								<div class="row form-group">
                                    <div class="col-md-12 col-12">
                                        <label class="control-label"><?php  esc_html_e('Value[Dropdown,checkbox,Radio]','listfoliopro')	;?> </label>
                                    </div>

                                    <div class="col-12">
                                        <textarea class="form-control mr-2 " rows="3" name="field_type_value[]" id="field_type_value[]" placeholder="<?php  esc_html_e('Separated by comma','listfoliopro');?> "><?php echo esc_attr((isset($field_type_value[$field_key])?$field_type_value[$field_key]:''));?></textarea>
                                    </div>

								</div>
								
								<?php
									if($i>=1){
									?>
									<div class="row mt-2">
										<div class="col-12">
                                            <button class="btn btn-danger btn-sm ml-2" onclick="return listfoliopro_remove_field('<?php echo esc_attr($i); ?>');"><span class="dashicons dashicons-trash ml-1"></span></button>
                                        </div>
									</div>
									<?php
									}
								?>
							</td>							
							
							<td >	
								<div class="row">
									<div class="col-12 col-md-12 col-lg-5 mb-2">
										<div id="roleall_<?php echo esc_attr($i);?>">
										<?php $field_user_role_saved= (isset($field_type_roles[$field_key])?$field_type_roles[$field_key]:'' );
											if($field_user_role_saved==''){$field_user_role_saved=array('all');}
										?>									
											<select name="field_user_role<?php echo esc_attr($i);?>[]" multiple="multiple" class="form-control col-md-12 col-12 " size="7">
												<option value="all" <?php echo (in_array('all',$field_user_role_saved)? "selected":'');?>> 
												<?php esc_html_e('All Users','listfoliopro');?> </option>
												
												<?php										
													foreach ( $wp_roles->roles as $key_role=>$value_role ){?>
													<option value="<?php echo esc_attr($key_role); ?>" <?php echo (in_array($key_role,$field_user_role_saved)? "selected":'');?>> <?php echo esc_html($key_role);?> </option>
													<?php												
													}
												?>
											</select>
										</div>	
									</div>
									<div class="col-12 col-md-12 col-lg-7 ">
										<p>
											<label>
												<input type="checkbox" name="signup<?php echo esc_attr($i); ?>" id="signup<?php echo esc_attr($i); ?>" value="yes" <?php echo($sign_up=='yes'? 'checked':'' );?> >
												
												<?php  esc_html_e('Registration','listfoliopro')	;?> 
											</label>
											</p>
											<p>
											<label>
												<input type="checkbox" name="myaccountprofile<?php echo esc_attr($i); ?>" id="myaccountprofile<?php echo esc_attr($i); ?>" value="yes" <?php echo ($myaccount_one=='yes'? 'checked':'' );?>  class="text-center">
												
												<?php  esc_html_e('My Account/Profile','listfoliopro')	;?> 
											</label>
											</p>
											<p>
											<label>
												<input type="checkbox" name="srequire<?php echo esc_attr($i); ?>" id="srequire<?php echo esc_attr($i); ?>" value="yes" <?php echo ($require=='yes'? 'checked':'' );?>  class="text-center">
												<?php  esc_html_e('Require','listfoliopro')	;?> 
											</label>
											</p>
									</div>
								</div>								
							</td>	
						</tr>
						<?php
							$i++;
						}
						$listfoliopro_signup_fields_serial=$i;
					?>
				</tbody>			
			</table>
			<div id="custom_field_div">
			</div>
			<div class="col-xs-12">
				<div id="success_message_profile"></div>
				<button class="button button-primary" onclick="return listfoliopro_update_profile_signup_fields();"><?php esc_html_e('Update Fields','listfoliopro');?> </button>
				<button class="listfoliopro-button" onclick="return listfoliopro_add_profile_field();"><?php esc_html_e('Add More Field','listfoliopro');?></button>
			</div>
		</form>
	</div>
</div>
<?php
	wp_enqueue_script('listfoliopro_eplugins-dashboard5', listfoliopro_ep_URLPATH.'admin/files/js/profile-fields.js', array('jquery'), $ver = true, true );
	wp_localize_script('listfoliopro_eplugins-dashboard5', 'profile_data', array( 			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'redirecturl'	=>  listfoliopro_ep_ADMINPATH.'admin.php?&page=listfoliopro-profile-fields',
	'adminnonce'=> wp_create_nonce("admin"),
	'pii'	=>$ii,
	'pi'	=> $i,
	'signup_field_serial'	=> $listfoliopro_signup_fields_serial, 
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
	"Label"=>  esc_html__('Label','listfoliopro'),
	"Type"=>  esc_html__('Type','listfoliopro'),
	"ValueDropdownLabel"=>  esc_html__('Value[Dropdown,checkbox,Radio]','listfoliopro'),
	"Registration"=>  esc_html__('Registration','listfoliopro'),
	"MyAccountProfile"=>  esc_html__('My Account/Profile','listfoliopro'),
	"Require"=>  esc_html__('Require','listfoliopro'),
	"EnterMenuTitle"=>  esc_html__('Enter Menu Title','listfoliopro'),
	"EnterMenuLink"=>  esc_html__('Enter Menu Link. Example http://www.google.com','listfoliopro'),
	"Delete"=>  esc_html__('Delete','listfoliopro'),
	) );
?>	
