<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
$dir_id=0; if(isset($_REQUEST['dir-id'])){$dir_id=sanitize_text_field($_REQUEST['dir-id']);}	
?>
<div class="bootstrap-wrapper popup0margin" >
		<div class=" row">
			<br/>
			<h3><?php   esc_html_e( 'Message Board', 'listfoliopro' ); ?></h3>
		</div>
		<div class="clearfix"></div>
		<form action="" id="message-pop" name="message-pop"  method="POST" role="form">
		  <div class="form-group">
			<label for="text" class="control-label"><?php   esc_html_e( 'Subject', 'listfoliopro' ); ?></label>
			<input type="text" class="form-control" id="subject" placeholder="<?php esc_html_e( 'Enter Subject', 'listfoliopro' );?>">
		  </div>
		  <div class="form-group">
			<label for="text" class="control-label"><?php   esc_html_e( 'Enter Message', 'listfoliopro' ); ?></label>
			<textarea name="message-content" id="message-content"  class="form-control" cols="60" rows="4" title="<?php esc_attr_e( 'Please Enter Message', 'listfoliopro' );?>"  placeholder="<?php esc_attr_e( 'Please Enter Message', 'listfoliopro' );?>"  ></textarea>
		  </div>
		  <div class="row">
			 <div class="col-md-6">
			 <input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_attr($dir_id); ?>">
			  <button type="button" onclick="listfoliopro_send_message_iv();" class="btn btn-large btn-primary"><?php   esc_html_e( 'Submit', 'listfoliopro' ); ?></button>
			 </div> 
			<div class="col-md-1">
			</div>
			 <div class="col-md-5"> <div id="update_message_popup"></div>
			 </div>
		</div>	 
		</form>
</div>