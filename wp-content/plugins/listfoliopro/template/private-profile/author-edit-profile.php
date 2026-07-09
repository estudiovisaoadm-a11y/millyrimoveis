<?php
 if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<div class="row"> 
	<div class="col-md-12">
		<div class="upload-avatar">
			<div class="avatar listfoliopro-my-account-logo" id="profile_image_main">
				<?php
					$iv_profile_pic_url=get_user_meta($current_user->ID, 'listfoliopro_profile_pic_thum',true);
					if($iv_profile_pic_url!=''){ ?>
					<img class="img-fluid"  src="<?php echo esc_url($iv_profile_pic_url); ?>">
					<?php
						}else{
						echo'	 <img class="img-fluid"  src="'. esc_url(listfoliopro_ep_URLPATH.'assets/images/company-enterprise.png').'">';
					}
				?>
			</div>
		</div>
	</div>		
	<div class="col-md-12 mb-2">
		<button type="button" onclick="listfoliopro_edit_profile_image('profile_image_main');"  class="btn btn-small-ar">
		<?php esc_html_e('Change Profile Pic','listfoliopro'); ?> </button>
	</div>
	
	
	

		
	<?php
		$default_fields = array();
		$field_set=get_option('listfoliopro_profile_fields' );
		if($field_set!=""){
			$default_fields=get_option('listfoliopro_profile_fields' );
			}else{
			$default_fields['full_name']='Full Name';
			$default_fields['phone']='Phone Number';			
			$default_fields['address']='Address';
			$default_fields['city']='City';
			$default_fields['postcode']='Postcode';
			$default_fields['state']='State';
			$default_fields['country']='Country';	
			$default_fields['website']='Website Url';
			$default_fields['description']='About';
		}
		
		$field_type_opt=  get_option( 'listfoliopro_field_type' );
		$field_type_roles=  	get_option( 'listfoliopro_field_type_roles' );			
		$myaccount_fields_array=  get_option( 'listfoliopro_myaccount_fields' );							
		$user = new WP_User( $current_user->ID );
		$i=1;
		
		foreach ( $default_fields as $field_key => $field_value ) { 		
			if(isset($myaccount_fields_array[$field_key])){  				
				
				if($myaccount_fields_array[$field_key]=='yes'){ 
					$role_access='no';
					if(in_array('all',$field_type_roles[$field_key] )){
						$role_access='yes';
					}
					if(in_array('administrator',$field_type_roles[$field_key] )){
						$role_access='yes';
					}
					
					if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
						foreach ( $user->roles as $role ){
							if(in_array($role,$field_type_roles[$field_key] )){
								$role_access='yes';
							}
							
						}
					}	
					if($role_access=='yes'){ 
						echo  $main_class->listfoliopro_check_field_input_access($field_key, $field_value,$current_user->ID , 'myaccount' );
					}
				}
				}else{  
				echo  $main_class->listfoliopro_check_field_input_access($field_key, $field_value, $current_user->ID ,'myaccount'  );
			}
		}
	?>
</div>
<div class="margin-top-10">
	<div class="" id="update_message"></div>
	<input type="hidden" name="latitude" id="latitude" value="<?php echo esc_attr(get_user_meta($current_user->ID,'latitude ',true)); ?>">
	<input type="hidden" name="longitude" id="longitude" value="<?php echo esc_attr(get_user_meta($current_user->ID,'longitude',true)); ?>">
	<button type="button" onclick="listfoliopro_update_profile_setting();"  class="btn green-haze"><?php   esc_html_e('Save Changes','listfoliopro');?></button>
</div>