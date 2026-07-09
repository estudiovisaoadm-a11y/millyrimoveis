<?php
	global $wpdb,$wp_roles;
	$user_id='';
	if(isset($_GET['id'])){ $user_id=sanitize_text_field($_GET['id']);}
	$user = new WP_User( $user_id );
	$main_class = new listfoliopro_eplugins;
?>
<?php
	include('header.php');
?>
		<div class=" card col-md-12">
			<div class="row">
				<div class="col-md-12"><h3 class=""><?php esc_html_e( 'User Update: ', 'listfoliopro' );?>
				<?php 
						$user_type=get_user_meta($user_id, 'user_type',true);
						$profile_page=get_option('listfoliopro__public_profile_page');
						
						
						
						$page_link= get_permalink( $profile_page).'?&id='.$user_id; 
					?>
				<a  href="<?php echo esc_url($page_link); ?>" target="_blank" class="btn btn-info btn-xs ">
					<?php esc_html_e('Profile','listfoliopro'); ?> </a>
					 </h3>
				</div>	
			</div> 
			<div class="card-body ">				
				<form id="user_form_iv" name="user_form_iv" class="form-horizontal" role="form" onsubmit="return false;">				
					<div class="form-group row">
						<label for="text" class="col-md-3 control-label"></label>
						<div id="iv-loading"></div>
					</div>	
					<div class="form-group row">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'User Name', 'listfoliopro' );?></label>
						<div class="col-md-8">
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_login); ?></label>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Email Address', 'listfoliopro' );?></label>
						<div class="col-md-8">									
							<label for="inputEmail3" class="control-label"><?php echo esc_html($user->user_email); ?></label>
						</div>
					</div>								 
					<div class="form-group row">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Role', 'listfoliopro' );?></label>
						<div class="col-md-8">
							<?php
								$user_role= '';
								if(isset($user->roles[0])){
									$user_role= $user->roles[0];
									}else{
									if(isset($user->roles[1])){
										$user_role= $user->roles[1];
									}
								}
							?>
							<select name="user_role"  class="form-control">
								<?php											
									foreach ( $wp_roles->roles as $key=>$value ){															
										echo'<option value="'.$key.'"  '.($user_role==$key? " selected" : " ") .' >'.esc_html($key).'</option>';	
									}
								?>	
							</select>								
						</div>
					</div> 
					<div class="form-group row">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'User Package', 'listfoliopro' );?></label>
						<div class="col-md-8">									
							<?php
								$post_type='listfoliopro_pack';
								$membership_pack = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = %s ", $post_type ));	
								$total_package=count($membership_pack);
								if($membership_pack>0){
									$i=0; $current_package_id=get_user_meta($user_id,'listfoliopro_package_id',true);
								echo'<select name="package_sel"  class=" form-control">'; ?>
								<option value="" ><?php esc_html_e( 'Select Package', 'listfoliopro' );?></option>
								<?php
									foreach ( $membership_pack as $row )
									{
										if($current_package_id==$row->ID){
											echo '<option value="'. esc_attr($row->ID).'" selected>'. esc_html($row->post_title). esc_html__( '[User Current Package]', 'listfoliopro' ).' </option>';
											}else{
											echo '<option value="'. esc_attr($row->ID).'" >'. esc_html($row->post_title).'</option>';
										}
										$i++;
									}
									echo '</select>';
								}
							?>
						</div>
					</div> 							  
					<div class="form-group row">
						<label for="text" class="col-md-4 control-label"><?php esc_html_e( 'Payment Status', 'listfoliopro' );?></label>
						<div class="col-md-8">
							<?php
								$payment_status= get_user_meta($user_id, 'listfoliopro_payment_status', true);
							?>
							<select name="payment_status" id ="payment_status" class="form-control">
								<option value="success" <?php echo ($payment_status == 'success' ? 'selected' : '') ?>><?php esc_html_e( 'Success', 'listfoliopro' );?></option>
								<option value="pending" <?php echo ($payment_status == 'pending' ? 'selected' : '') ?>><?php esc_html_e( 'Pendinge', 'listfoliopro' );?></option>
								</select>	
						</div>
					</div>
					
					<div class="form-group row">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Expiry Date', 'listfoliopro' );?></label>
						<div class="col-md-8">
							<?php
								$exp_date= get_user_meta($user_id, 'listfoliopro_exprie_date', true);
							?>
							<input type="text"  name="exp_date"  readonly   id="exp_date" class="form-control ctrl-textbox "  value="<?php echo esc_attr($exp_date); ?>" placeholder="">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Profile Image', 'listfoliopro' );?></label>
						<div class="col-md-2">
							<div class="upload-avatar">
								<div class="avatar" id="profile_image_main">
									<?php
										$iv_profile_pic_url=get_user_meta($user_id, 'listfoliopro_profile_pic_thum',true);
										if($iv_profile_pic_url!=''){ ?>
										<img class="rounded-profileimg" src="<?php echo esc_url($iv_profile_pic_url); ?>">
										<?php
											}else{											 
											 
											echo' <img class="rounded-profileimg" src="'.esc_url(listfoliopro_ep_URLPATH.'assets/images/default-user.png') .'">';
										}
									?>
								</div>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="upload">
							<div class="btn-upload">
								<button type="button" onclick="listfoliopro_edit_profile_image('profile_image_main');"  class="btn btn-info ">
								<?php esc_html_e('Change Image','listfoliopro'); ?> </button>
								<input type="hidden" name="profile_image_url" id="profile_image_url" value="<?php echo esc_url($iv_profile_pic_url); ?>">	
							</div>
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="inputEmail3" class="col-md-4 control-label"><?php esc_html_e( 'Profile Baner Image', 'listfoliopro' );?></label>
						<div class="col-md-2">
						
									<?php
										$topbanner=get_user_meta($user_id,'topbanner', true);
										if(trim($topbanner)!=''){					
											$default_image_banner = wp_get_attachment_url($topbanner );
											}else{
											if(get_option('listfoliopro_banner_defaultimage')!=''){
												$default_image_banner= wp_get_attachment_image_src(get_option('listfoliopro_banner_defaultimage'),'large');
												if(isset($default_image_banner[0])){									
													$default_image_banner=$default_image_banner[0] ;			
												}
												}else{
												$default_image_banner=listfoliopro_ep_URLPATH."/assets/images/banner.png";
											}
										}
									?>
								<div class="avatar" id="banner_image_main">
									<?php					
										echo'<img class="rounded-profileimg" src="'. esc_url($default_image_banner).'">';
									?>
								</div>
						</div>
						<div class="col-md-6">
							<div class="upload">
							<div class="btn-upload">							
								<button type="button" onclick="listfoliopro_edit_banner_image('banner_image_main');"  class="btn btn-info ">
		<?php esc_html_e('Change Banner [best fit: 1200 X 400]','listfoliopro'); ?> </button>
							</div>
							</div>
						</div>
						<input type="hidden" name="topbanner_url" id="topbanner_url" value="<?php echo esc_url($default_image_banner); ?>">	
						<input type="hidden" name="topbanner" id="topbanner_id" value="<?php echo esc_attr($topbanner); ?>">
					</div>
					
					
					
					
					<div class="form-group row">
						<label for="" class="col-md-4 control-label"></label>
						<div class="row">
							<?php
								$default_fields = array();
								$field_set=get_option('listfoliopro_profile_fields' );
								if($field_set!=""){
									$default_fields=get_option('listfoliopro_profile_fields' );
									}else{
									$default_fields['full_name']='Full Name';	
									$default_fields['tagline']='Tag line';
									$default_fields['company_since']='Estd Since';
									$default_fields['team_size']='Team Size';									
									$default_fields['phone']='Phone Number';			
									$default_fields['address']='Address';
									$default_fields['city']='City';
									$default_fields['zipcode']='Zipcode';
									$default_fields['state']='State';
									$default_fields['country']='Country';	
									$default_fields['website']='Website Url';
									$default_fields['description']='About';
								}
								$field_type_opt=  get_option( 'listfoliopro_field_type' );
								if($field_type_opt!=''){
									$field_type=get_option('listfoliopro_field_type' );
									}else{
									$field_type= array();
									$field_type['full_name']='text';								
									$field_type['company_since']='datepicker';
									$field_type['team_size']='text';									
									$field_type['phone']='text';
									$field_type['mobile']='text';
									$field_type['address']='text';
									$field_type['city']='text';
									$field_type['zipcode']='text';
									$field_type['state']='text';
									$field_type['country']='text';										
									$field_type['listing_title']='text';									
									$field_type['hourly_rate']='text';
									$field_type['experience']='textarea';
									$field_type['age']='text';
									$field_type['qualification']='text';								
									$field_type['gender']='radio';	
									$field_type['website']='url';
									$field_type['description']='textarea';			
								}
								$field_type_roles=  	get_option( 'listfoliopro_field_type_roles' );
								$myaccount_fields_array=  get_option( 'listfoliopro_myaccount_fields' );
								$user = new WP_User( $user_id);
								$i=1;
								foreach ( $default_fields as $field_key => $field_value ) { 		
									if(isset($myaccount_fields_array[$field_key])){  
										if($myaccount_fields_array[$field_key]=='yes'){ 
											$role_access='yes';											
											if(in_array('administrator',$field_type_roles[$field_key] )){
												$role_access='yes';
											}											
											if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
												foreach ( $user->roles as $role ){
													if(in_array($role,$field_type_roles[$field_key] )){
														$role_access='yes';
													}
													if('administrator'==$role){
														$role_access='yes';
													}
												}
											}	
											if($role_access=='yes'){
												echo  $main_class->listfoliopro_check_field_input_access($field_key, $field_value, 'myaccount', $user_id );
											}
										}
										}else{ 
										echo  $main_class->listfoliopro_check_field_input_access($field_key, $field_value, 'myaccount', $user_id);
									}
								}
							?>	
						</div>
					</div>
					<input type="hidden"  name="user_id"     id="user_id"   value="<?php echo esc_attr($user_id); ?>" >
					<div class="row">	
					<div class="col-md-12" id="usersupdatemessage"></div>
						<div class="col-md-12">							
							<label for="" class="col-md-4 control-label"></label>							
							<div class="col-md-8">
								<button class="btn btn-info " onclick="return listfoliopro_update_user_setting();"><?php esc_html_e( 'Update User', 'listfoliopro' );?></button>
								<a href="<?php echo listfoliopro_ep_ADMINPATH; ?>admin.php?page=listfoliopro-settings&user_settings" class="btn btn-info" ><?php esc_html_e( '<< Back', 'listfoliopro' );?></a>
							</div>
							<p>&nbsp;</p>
						</div>
					</div>
				</div>								
			</form>		
		</div>			
<?php
	include('footer.php');
	?>