<?php
	$dir_map_api=get_option('listfoliopro_map_api');
	if($dir_map_api==""){$dir_map_api='';}	
	
	
	
?>
<form class="form-horizontal" role="form"  name='map_settings' id='map_settings'>	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Google Map & Places API Key','listfoliopro');  ?>
			<br/><small><?php esc_html_e('Please set your own google map API key for your site( default key is for only demo)
			','listfoliopro');  ?> </small>
		</label>
		<div class="col-md-8">																		
			<input class="col-md-12 form-control" type="text" name="dir_map_api" id="dir_map_api" value='<?php echo esc_attr($dir_map_api); ?>' >
			<a href="<?php echo esc_url('https://developers.google.com/maps/documentation/javascript/get-api-key');?>"> <?php esc_html_e( 'Get your Google Maps API Key here.', 'listfoliopro' );?>     </a>
		</div>
	</div>
	
	
	
	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Zoom','listfoliopro');  ?></label>
		<?php
			$dir_map_zoom=get_option('listfoliopro_map_zoom');
			if($dir_map_zoom==""){$dir_map_zoom='7';}	
		?>
		<div class="col-md-3">													
			<input  class="form-control" type="text" name="dir_map_zoom" id="dir_map_zoom" value='<?php echo esc_attr($dir_map_zoom); ?>' >
				<?php esc_html_e('20 is more Zoom, 1 is less zoom','listfoliopro');  ?>
				
		</div>
		
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Type','listfoliopro');  ?></label>
		<div class="col-md-6">
			<?php
				$dir_map_type=get_option('listfoliopro_map_type');
				if($dir_map_type==""){$dir_map_type='OpenSteet';}	
			?>
			<select id='map_type' name='map_type' class='form-control'>
				<option value="google-map" <?php echo ($dir_map_type=='google-map'?' selected':''); ?>><?php esc_html_e('Google Map','listfoliopro');  ?></option>
				<option value="opensteet-map" <?php echo ($dir_map_type=='opensteet-map'?' selected':''); ?> ><?php esc_html_e('OpenSteet Map','listfoliopro');  ?></option>
			</select>
		</div>
		<div class="col-md-2">
			<label>	
			</label>	
		</div>
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Radius','listfoliopro');  ?></label>
		<div class="col-md-6">
			<?php
				$listfoliopro_map_radius=get_option('listfoliopro_map_radius');
				if($listfoliopro_map_radius==""){$listfoliopro_map_radius='Km';}
			?>
			<select id='listfoliopro_map_radius' name='listfoliopro_map_radius' class='form-control'>
				<option value="Km" <?php echo ($listfoliopro_map_radius=='Km'?' selected':''); ?>><?php esc_html_e('Km','listfoliopro');  ?></option>
				<option value="Mile" <?php echo ($listfoliopro_map_radius=='Mile'?' selected':''); ?> ><?php esc_html_e('Mile','listfoliopro');  ?></option>
			</select>
		</div>
		<div class="col-md-2">
			<label>	
			</label>	
		</div>
	</div>
	
	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Search Box Near to Me','listfoliopro');  ?></label>
		<div class="col-md-3">
			<?php
				$listfoliopro_near_to_me=get_option('listfoliopro_near_to_me');
				if($listfoliopro_near_to_me==""){$listfoliopro_near_to_me='50';}
			?>
			<input  class="form-control" type="text" name="listfoliopro_near_to_me" id="listfoliopro_near_to_me" value='<?php echo esc_attr($listfoliopro_near_to_me); ?>' >
		</div>
		<div class="col-md-2">
			<label>	
			</label>	
		</div>
	</div>
	
	
	
	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Force Default Location','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_forcelocation=get_option('listfoliopro_forcelocation');
			?>
			<label class="switch">
			  <input name="listfoliopro_forcelocation" type="checkbox" value="forcelocation"  <?php echo ($listfoliopro_forcelocation=='forcelocation' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Default Latitude','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_defaultlatitude=get_option('listfoliopro_defaultlatitude');
			?>
			<input  class="form-control" type="text" name="listfoliopro_defaultlatitude" id="listfoliopro_defaultlatitude" value='<?php echo esc_attr($listfoliopro_defaultlatitude); ?>' >
		</div>
		<div class="col-md-4">
			<label>	<a href="<?php echo esc_url('https://www.maps.ie/coordinates.html');?>" target="_blank" >
				<?php esc_html_e('You can find latitude here','listfoliopro');  ?></a>
			</label>	
		</div>
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Default Longitude','listfoliopro');  ?></label>
		<div class="col-md-3">			<?php
				$listfoliopro_defaultlongitude=get_option('listfoliopro_defaultlongitude');
			?>
			<input  class="form-control" type="text" name="listfoliopro_defaultlongitude" id="listfoliopro_defaultlongitude" value='<?php echo esc_attr($listfoliopro_defaultlongitude); ?>' >
		</div>
		<div class="col-md-4">
			<label>	<a href="<?php echo esc_url('https://www.maps.ie/coordinates.html');?>" target="_blank" >
				<?php esc_html_e('You can find longitude here','listfoliopro');  ?></a>
			</label>	
		</div>
	</div>
	<hr/>
	 <label class="listfoliopro-settings-sub-section-title "> <?php esc_html_e('Map Popup/ Infobox settings','listfoliopro');  ?></label>
	
	
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Popup/Infobox Image ','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_infobox_image=get_option('listfoliopro_infobox_image');
				if($listfoliopro_infobox_image==""){$listfoliopro_infobox_image='yes';}
			?>
			<label class="switch">
			  <input name="listfoliopro_infobox_image" type="checkbox" value="yes"  <?php echo ($listfoliopro_infobox_image=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Popup/Infobox Title ','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_infobox_title=get_option('listfoliopro_infobox_title');
				if($listfoliopro_infobox_title==""){$listfoliopro_infobox_title='yes';}
			?>
			<label class="switch">
			  <input name="listfoliopro_infobox_title" type="checkbox" value="yes"  <?php echo ($listfoliopro_infobox_title=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Popup/Infobox Location ','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_infobox_location=get_option('listfoliopro_infobox_location');
				if($listfoliopro_infobox_location==""){$listfoliopro_infobox_location='yes';}
			?>
			<label class="switch">
			  <input name="listfoliopro_infobox_location" type="checkbox" value="yes"  <?php echo ($listfoliopro_infobox_location=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Map Popup/Infobox Direction ','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_infobox_direction=get_option('listfoliopro_infobox_direction');
				if($listfoliopro_infobox_direction==""){$listfoliopro_infobox_direction='yes';}
			?>
			<label class="switch">
			  <input name="listfoliopro_infobox_direction" type="checkbox" value="yes"  <?php echo ($listfoliopro_infobox_direction=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	<div class="form-group row">
		<label  class="col-md-4 control-label"> <?php esc_html_e('Link to Detail page ','listfoliopro');  ?>
			</label>
		<div class="col-md-3">			<?php
				$listfoliopro_infobox_linkdetail=get_option('listfoliopro_infobox_linkdetail');
				if($listfoliopro_infobox_linkdetail==""){$listfoliopro_infobox_linkdetail='yes';}
			?>
			<label class="switch">
			  <input name="listfoliopro_infobox_linkdetail" type="checkbox" value="yes"  <?php echo ($listfoliopro_infobox_linkdetail=='yes' ? ' checked':'');  ?> >
			  <span class="slider round"></span>
			</label>
		</div>		
	</div>
	
	<div class="row">
		
		<div class="col-md-12 col-12">
			<hr/>
			<div id="success_message_map_setting"></div>	
			<button type="button" onclick="return  listfoliopro_update_map_settings();" class="button button-primary listfoliopro-map-settings-save-btn"><?php esc_html_e( 'Update', 'listfoliopro' );?></button>
		</div>	
	</div>	
</form>