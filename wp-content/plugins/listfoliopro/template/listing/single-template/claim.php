<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	include( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	
	$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	$id=$dir_id;	
	$dir_addedit_claimtitle=get_option('dir_addedit_claimtitle');
	if($dir_addedit_claimtitle==""){$dir_addedit_claimtitle=esc_html__('Report','listfoliopro');}
	?>
<div class="bootstrap-wrapper claim-form-wrapper">
	<div class="container">	
		<div class="row" >
			<div class="col-md-12">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel"><?php echo esc_html($dir_addedit_claimtitle); ?></h5>
							<div  class="ml-2" id="update_message_claim"></div>
							<button onclick="listfoliopro_contact_close();" type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="#" id="message-claim" name="message-claim"    method="POST" >
								<div class="form-group row">
									<input class="col-md-12 form-control"  id="subject" name ="subject" type="text" placeholder="<?php esc_html_e( 'Name', 'listfoliopro' ); ?>">
								</div>

								<div class="form-group row">
									<input class="col-md-12 form-control"  name="email_address" id="email_address" type="email" placeholder="<?php esc_html_e( 'Email', 'listfoliopro' ); ?>">
								</div>

								<div class="form-group row">
									<input type="hidden" name="dir_id" id="dir_id" value="<?php echo esc_html($id); ?>">
									<textarea class="col-md-12 form-control"  name="message-content" id="message-content"  cols="20" rows="5" placeholder="<?php esc_html_e( 'Message', 'listfoliopro' ); ?>"></textarea>
								</div>
							</form>
							
						</div>
						<div class="modal-footer">
                            <button type="button" class="listfoliopro-button" onclick="send_message_claim();"><?php esc_html_e( 'Send Message', 'listfoliopro' ); ?>
                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
						</div>
					</div>
				
		</div>
	</div>
</div>