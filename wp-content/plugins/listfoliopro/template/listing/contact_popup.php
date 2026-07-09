<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	$dir_id=0; if(isset($_REQUEST['dir_id'])){$dir_id=sanitize_text_field($_REQUEST['dir_id']);}
	$id=$dir_id;
	$dir_addedit_contactustitle=get_option('dir_addedit_contactustitle');
	if($dir_addedit_contactustitle==""){$dir_addedit_contactustitle='Contact Us';}	
?>
<div class="bootstrap-wrapper  "id="popup-contact" >		
	<div class="container" >
		<div class="row" >
			<div class="col-md-12">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo esc_html($dir_addedit_contactustitle);?></h5>	
					<div class="ml-2" id="update_message_popup"></div> 
					<button type="button" onclick="listfoliopro_contact_close();" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php
						include( listfoliopro_ep_template. 'listing/contact-form.php');						
					?>
				</div>
							
			</div>				
		</div>	
	</div>	
</div>		