<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	$id=$dir_id;
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Booking';}	
	$dir_addedit_contactustitle=esc_html__( 'Booking', 'listfoliopro' );
?>
<div class="bootstrap-wrapper "id="popup-booking" >		
	<div class="container" >
		<div class="row" >
			<div class="col-md-12">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo esc_html($dir_addedit_contactustitle);?></h5>	
					<div class="ml-2" id="booking_update_message_popup"></div> 
					<button type="button" onclick="listfoliopro_contact_close();" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
			<div class="modal-body">			
					<form   action="#" id="booking_pop" name="booking_pop"   method="POST" >
						<div class="form-group  row">	
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<input  class="form-control-popup " id="booking_name" name ="booking_name" type="text" placeholder="<?php  esc_html_e( 'Name', 'listfoliopro' ); ?>">
							</div>
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<input class="form-control-popup  "  name="booking_email_address" id="booking_email_address" placeholder="<?php  esc_html_e( 'Email', 'listfoliopro' ); ?>" type="text">
							</div>
						</div>
						<div class="form-group  row">	
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<input  class="form-control-popup  " id="booking_phone"  placeholder="<?php  esc_html_e( 'Phone#', 'listfoliopro' ); ?>" name ="booking_phone" type="text">
							</div>
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<input  class="form-control-popup " id="booking_address" name ="booking_address" placeholder="<?php  esc_html_e( 'Address', 'listfoliopro' ); ?>" type="text">
							</div>
						</div>
						
						
						
							<div class="form-group  row">	
							<div class="form-group col-sm-12 flex-column d-flex"> 
								<input  class="form-control-popup  col-md-12 epinputdate hasDatepicker"  placeholder="<?php  esc_html_e( 'Date and time', 'listfoliopro' ); ?>"id="booking_datetime" name ="booking_datetime"  type="datetime-local" >
							</div>
							
						</div>						
						
						<div class="form-group ">						
							<input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_attr($id);?>">
							<textarea  class="col-md-12 form-control-textarea"  placeholder="<?php  esc_html_e( 'Additional Information', 'listfoliopro' ); ?>" name="booking_message_content" id="booking_message_content"  cols="20" rows="3"></textarea>
						</div>
					</form>
				
				</div>
				
				<div class="modal-footer">
                    <button type="button" class="listfoliopro-button" onclick="listfoliopro_booking_send_message();"><?php esc_html_e( 'Send Message', 'listfoliopro' ); ?>
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
				</div>					
			</div>				
		</div>	
	</div>	
</div>		