<div class="form-group row">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'BCC to Admin all Message :', 'listfoliopro' );?> </label>
		<div class="col-md-10 ">
			
			<?php
			 $bcc_message='';
			 if( get_option('epjblistfoliopro_bcc_message' ) ) {
				  $bcc_message= get_option('epjblistfoliopro_bcc_message'); 
			 }	
			
			?><label>
		  <input  class="" type="checkbox" name="bcc_message" id="bcc_message" value="yes" <?php echo ($bcc_message=='yes'? 'checked':'' ); ?> > 
				<?php esc_html_e( 'Yes, Admin will  get all message.', 'listfoliopro' );?>
		
	</div>
</div>
<div class="form-group row">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Subject : ', 'listfoliopro' );?></label>
		<div class="col-md-10 ">
			
				<?php
				$listfoliopro_contact_email_subject = get_option( 'listfoliopro_contact_email_subject');
				?>
				
				<input type="text" class="form-control" id="contact_email_subject" name="contact_email_subject" value="<?php echo esc_attr($listfoliopro_contact_email_subject); ?>" placeholder="<?php esc_html_e( 'Enter subject', 'listfoliopro' );?>">
		
	</div>
</div>
<div class="form-group row">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'New Message Template :', 'listfoliopro' );?> </label>
		<div class="col-md-10 ">
													<?php
					$settings_forget = array(															
						'textarea_rows' =>'20',	
						'editor_class'  => 'form-control',														 
						);
					$content_client = get_option( 'listfoliopro_contact_email');
					$editor_id = 'message_email_template';
													
					?>
			<textarea  name="message_email_template" rows="20" class="col-md-12 ">
			<?php echo esc_html($content_client); ?>
			</textarea>				

	</div>
</div>

<div class="form-group row">
	<h3  class="col-md-12 col-xs-12 col-sm-12  page-header"><?php esc_html_e( 'Notification Email', 'listfoliopro' );?> </h3>
</div>
	<div class="form-group row">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'Notification Subject : ', 'listfoliopro' );?></label>
		<div class="col-md-10 ">
			
				<?php
				$listfoliopro_notification_email_subject = get_option( 'listfoliopro_notification_email_subject');
				?>
				
				<input type="text" class="form-control" id="listfoliopro_notification_email_subject" name="listfoliopro_notification_email_subject" value="<?php echo esc_attr($listfoliopro_notification_email_subject); ?>" placeholder="<?php esc_html_e( 'Enter subject', 'listfoliopro' );?>">
		
	</div>
</div>
<div class="form-group row">
		<label  class="col-md-2   control-label"> <?php esc_html_e( 'Notification Template :', 'listfoliopro' );?> </label>
		<div class="col-md-10 ">
													<?php
					$settings_forget = array(															
						'textarea_rows' =>'20',	
						'editor_class'  => 'form-control',														 
						);
					$content_client = get_option( 'listfoliopro_notification_email');
				
													
					?>
			<textarea  name="notification_email_template" rows="20" class="col-md-12 ">
			<?php echo esc_html($content_client); ?>
			</textarea>				

	</div>
</div>
