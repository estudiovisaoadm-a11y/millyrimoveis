<form class="form-horizontal" role="form"  name='color_settings' id='color_settings'>	
	
	<?php
	$listfoliopro_primary_color=get_option('listfoliopro_primary_color');	
	if($listfoliopro_primary_color==""){$listfoliopro_primary_color='#1dbfc1';}	
?>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Prime Color','listfoliopro');  ?>		
		</label>
		<div class="col-md-8">																		
			<input type="color" name="listfoliopro_primary_color" id="listfoliopro_primary_color" value='<?php echo esc_attr($listfoliopro_primary_color); ?>' >			
		</div>
	</div>	
	<?php
	$listfoliopro_second_color=get_option('listfoliopro_second_color');	
	if($listfoliopro_second_color==""){$listfoliopro_second_color='#87f1f2';}	
	
?>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Second Color','listfoliopro');  ?>		
		</label>
		<div class="col-md-8">																		
			<input type="color" name="listfoliopro_second_color" id="listfoliopro_second_color" value="<?php echo esc_attr($listfoliopro_second_color); ?>" >			
		</div>
	</div>	
	
	<?php
	$listfoliopro_listing_d_color=get_option('listfoliopro_listing_d_color');	
	if($listfoliopro_listing_d_color==""){$listfoliopro_listing_d_color='#f8f7f7';}	
	
?>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Listing Detail Background Color','listfoliopro');  ?>		
		</label>
		<div class="col-md-8">																		
			<input type="color" name="listfoliopro_listing_d_color" id="listfoliopro_listing_d_color" value="<?php echo esc_attr($listfoliopro_listing_d_color); ?>" >			
		</div>
	</div>	
	<div class="row">
		
		<div class="col-md-12 col-12">
			<hr/>
			<div id="success_message_color_setting"></div>	
			<button type="button" onclick="return  listfoliopro_update_color_settings();" class="button button-primary"><?php esc_html_e( 'Update', 'listfoliopro' );?></button>
		</div>	
	</div>	
</form>