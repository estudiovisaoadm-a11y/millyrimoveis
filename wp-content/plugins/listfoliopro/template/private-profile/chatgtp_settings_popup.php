<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );	
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	$form_listing_title=''; 
	if(isset($_REQUEST['form_listing_title'])){$form_listing_title=sanitize_text_field($_REQUEST['form_listing_title']);}
	
?>
<div class="bootstrap-wrapper "  >		
	<div class="container" >
		<div class="row" >
			<div class="col-md-12">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo esc_html__( 'ChatGPT Content Creator Settings', 'listfoliopro' );?></h5>	
					<div class="ml-2" id="booking_update_message_popup"></div> 
					<button type="button" onclick="listfoliopro_contact_close();" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php
				$listfoliopro_openai_api_key = get_option('listfoliopro_openai_api_key');					
				$listfoliopro_openai_api_key_status = get_option('listfoliopro_openai_api_key_status' ,true);
				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/engines/davinci/completions");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					$headers = array(
						"Content-Type: application/json",
						"Authorization: Bearer $listfoliopro_openai_api_key"
					);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					$data = array(
						"prompt" => "Hello,",
						"max_tokens" => 5
					);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($data));

					$response = curl_exec($ch);
					$error = curl_error($ch);

					if ($error) {					
						update_option('listfoliopro_openai_api_key_status' ,'API key is not valid '); 
					} else {
						$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						if ($http_code == 200) {
							update_option('listfoliopro_openai_api_key_status' ,'clear');						
						} else {
							update_option('listfoliopro_openai_api_key_status' ,'API key is not valid '); 
						}
					}
					curl_close($ch);
					$listfoliopro_openai_api_key_status = get_option('listfoliopro_openai_api_key_status' ,true);
				
				if($listfoliopro_openai_api_key_status=='clear'){
					
				}else{
					$listfoliopro_openai_api_key='';
				
				}
				
				if($listfoliopro_openai_api_key!=''){
				
				?>
				<div class="modal-body">			
					<form   action="#" id="chatgpt_pop" name="chatgpt_pop"   method="POST" >
						<div class="form-group  row">	
							<div class="form-group col-sm-12 flex-column d-flex"> 
								<label  class="form-label"><?php  esc_html_e( 'Title for GPT', 'listfoliopro' ); ?></label>
								<input  class="form-control-popup " id="gpt_title" name ="gpt_title" type="text" placeholder="<?php  esc_html_e( 'Title', 'listfoliopro' ); ?>" value="<?php  esc_html_e( 'Write a detailed description of : ', 'listfoliopro' ); ?><?php echo esc_html($form_listing_title); ?> ">
							</div>	
						</div>
						<div class="form-group  row">	
							<div class="form-group col-sm-3 flex-column d-flex"> 
								<label  class="form-label">
									<input name="listfoliopro_feature_image_chatgpt" type="checkbox" value="yes"  checked >
									<?php  esc_html_e( 'Feature Image', 'listfoliopro' ); ?></label>								
							</div>
						</div>						
							
						<div class="form-group  row">	
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<label  class="form-label"><?php  esc_html_e( 'Max Tokens #[Word or characters]', 'listfoliopro' ); ?></label>
								<input  class="form-control-popup  " id="max_tokens"  placeholder="<?php  esc_html_e( '256', 'listfoliopro' ); ?>" name ="max_tokens" type="text" value="256">
							</div>
							<div class="form-group col-sm-6 flex-column d-flex"> 
								<label  class="form-label"><?php  esc_html_e( 'Number Of FAQ', 'listfoliopro' ); ?></label>
								<input  class="form-control-popup " id="gpt_faq_number" name ="gpt_faq_number" placeholder="<?php  esc_html_e( 'FAQ #', 'listfoliopro' ); ?>" value="5" type="text">
							</div>
							
						</div>						
						<div class="form-group  row" id="feature_image_urls">								
						</div>	
					</form>
				
				</div>
				
				<div class="modal-footer" >						
					<div class="col-md-6 " id="update_message-gpt"></div>						
					<button type="button" id="chatgpt_post_creator" class="btn btn-small-ar col-md-6 "  onclick="listfoliopro_chatgpt_post_creator();" ><?php  esc_html_e( 'Create Post', 'listfoliopro' ); ?></button>					
					<button type="button" id="insert_data_inform" class="btn btn-small-ar col-md-6  displaynone"  onclick="listfoliopro_insert_gpt_image_inform();" ><?php  esc_html_e( 'Add Image to Post', 'listfoliopro' ); ?></button>	
				</div>
				
				<?php
				}else{ ?>
					<div class="modal-body">
						<div class="form-group  row">	
								<label  class="form-label"><?php  esc_html_e( 'Please add your active OpenAI API key in plugin settings', 'listfoliopro' ); ?></label>
						</div>
					</div>
				<?php
				}
				?>
			</div>				
		</div>	
	</div>	
</div>		