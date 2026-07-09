<form class="form-horizontal" role="form"  name='openai_settings' id='openai_settings'>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Active ChatGPT Option ','listfoliopro');  ?>			
			</label>
		<div class="col-md-3"><?php
				$listfoliopro_active_chatGPT=get_option('listfoliopro_active_chatGPT');		
				if($listfoliopro_active_chatGPT==""){$listfoliopro_active_chatGPT='yes';}	
			?>
			<label class="switch">
			  <input name="listfoliopro_active_chatGPT" type="checkbox" value="yes"  <?php echo ($listfoliopro_active_chatGPT=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	<div class="form-group row">
		<label  class="col-md-3 col-xs-6 col-sm-6 control-label"> <?php esc_html_e( 'OpenAI API Key :', 'listfoliopro' );?> </label>
		<div class="col-md-4 col-xs-6 col-sm-6">
			<?php
				$listfoliopro_openai_api_key='';
				if( get_option( 'listfoliopro_openai_api_key' )==FALSE ) {
					$listfoliopro_openai_api_key = get_option('listfoliopro_openai_api_key');						 
					}else{
					$listfoliopro_openai_api_key = get_option('listfoliopro_openai_api_key');								
				}
			?>
			<input type="text" class="form-control" id="listfoliopro_openai_api_key" name="listfoliopro_openai_api_key" value="<?php echo esc_html($listfoliopro_openai_api_key); ?>" placeholder="">
			<a href="<?php echo esc_url('https://beta.openai.com/signup'); ?>" target="_blank"><?php  esc_html_e('Get your API key here','listfoliopro');?>.</a>
			<p>
			<?php  esc_html_e('Log into your OpenAI account. Click on your username in the top right corner, then "View API keys". You should see all your API keys listed there.','listfoliopro');?>
			</p>			
		</div>
		<div>
			<?php
			if($listfoliopro_openai_api_key!=''){
				$listfoliopro_openai_api_key_status = get_option('listfoliopro_openai_api_key_status' ,true);
				if($listfoliopro_openai_api_key_status =='' ){
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
				}
				if($listfoliopro_openai_api_key_status=='clear'){
					?>
					<img src="<?php echo esc_url(listfoliopro_ep_URLPATH.'admin/files/images/right_icon.png'); ?>">						
					<?php
					esc_html_e( 'API key is valid', 'listfoliopro' );
				}else{
					echo esc_html($listfoliopro_openai_api_key_status);
				}
			}
			?>
			
		</div>
	</div>
		<div class="form-group row">
		<label  class="col-md-3 col-xs-6 col-sm-6 control-label"> <?php esc_html_e( 'Default Model :', 'listfoliopro' );?> </label>
		<div class="col-md-4 col-xs-6 col-sm-6">
			<?php
				$gpt_model=get_option('listfoliopro_gpt_model');	
				if($gpt_model==""){$gpt_model='text-davinci-003';}	
			?>
			<select id='gpt_model' name='gpt_model' class='form-control'>
				<option value="text-davinci-001" <?php echo ($gpt_model=='text-davinci-001'?' selected':''); ?>><?php esc_html_e('text-davinci-001','listfoliopro');  ?></option>
				<option value="text-davinci-002" <?php echo ($gpt_model=='text-davinci-002'?' selected':''); ?> ><?php esc_html_e('text-davinci-002','listfoliopro');  ?></option>
				<option value="text-davinci-003" <?php echo ($gpt_model=='text-davinci-003'?' selected':''); ?> ><?php esc_html_e('text-davinci-003','listfoliopro');  ?></option>
				<option value="text-curie-001" <?php echo ($gpt_model=='text-curie-001'?' selected':''); ?> ><?php esc_html_e('text-curie-001','listfoliopro');  ?></option>
				<option value="text-babbage-001" <?php echo ($gpt_model=='text-babbage-001'?' selected':''); ?> ><?php esc_html_e('text-babbage-001','listfoliopro');  ?></option>
				<option value="text-ada-001" <?php echo ($gpt_model=='text-ada-001'?' selected':''); ?> ><?php esc_html_e('text-ada-001','listfoliopro');  ?></option>
				<option value="text-davinci-insert-002" <?php echo ($gpt_model=='text-davinci-insert-002'?' selected':''); ?> ><?php esc_html_e('text-davinci-insert-002','listfoliopro');  ?></option>
				<option value="text-davinci-insert-001" <?php echo ($gpt_model=='text-davinci-insert-001'?' selected':''); ?> ><?php esc_html_e('text-davinci-insert-001','listfoliopro');  ?></option>
				<option value="text-davinci-edit-001" <?php echo ($gpt_model=='text-davinci-edit-001'?' selected':''); ?> ><?php esc_html_e('text-davinci-edit-001','listfoliopro');  ?></option>
				<option value="davinci" <?php echo ($gpt_model=='davinci'?' selected':''); ?> ><?php esc_html_e('davinci','listfoliopro');  ?></option>
				
				<option value="curie" <?php echo ($gpt_model=='curie'?' selected':''); ?> ><?php esc_html_e('curie','listfoliopro');  ?></option>
				<option value="babbage" <?php echo ($gpt_model=='babbage'?' selected':''); ?> ><?php esc_html_e('babbage','listfoliopro');  ?></option>
				<option value="ada" <?php echo ($gpt_model=='ada'?' selected':''); ?> ><?php esc_html_e('ada','listfoliopro');  ?></option>
				<option value="text-davinci-edit-001 " <?php echo ($gpt_model=='text-davinci-edit-001 '?' selected':''); ?> ><?php esc_html_e('text-davinci-edit-001 ','listfoliopro');  ?></option>				
			</select>
			</div>
		</div>
	<div class="clearfix"></div>
</form>
<div class="form-group  row">
		
	<label  class="col-md-3  control-label"> </label>
	<div class="col-md-8">
	<div id="update_openai-message"></div>	
		<button type="button" onclick="return  listfoliopro_update_openai_settings();" class="button button-primary"><?php esc_html_e( 'Update OpenAI Setting', 'listfoliopro' );?></button>					
	</div>							
</div>	
					
