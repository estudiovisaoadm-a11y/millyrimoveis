<div id="update_message"> </div>		 
<form class="form-horizontal listfoliopro-general-settings" role="form"  name='directory_settings' id='directory_settings'>
	<?php
		$listfoliopro_archive_layout=get_option('listfoliopro_archive_layout');
		if($listfoliopro_archive_layout==""){$listfoliopro_archive_layout='archive-no-map';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default All Listing Page Layout','listfoliopro');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="listfoliopro_archive_layout" id="listfoliopro_archive_layout" value='archive-right-map' <?php echo ($listfoliopro_archive_layout=='archive-right-map' ? 'checked':'' ); ?> > <?php esc_html_e( 'Listing + Map', 'listfoliopro' );?>
			</label>	
		</div>		
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="listfoliopro_archive_layout" id="listfoliopro_archive_layout" value='archive-no-map' <?php echo ($listfoliopro_archive_layout=='archive-no-map' ? 'checked':'' );  ?> > <?php esc_html_e( 'Listing Without Map', 'listfoliopro' );?>
			</label>
		</div>		
	</div>	
	
	<?php
		 $listfoliopro_archive_style=get_option('listfoliopro_archive_style');
		if($listfoliopro_archive_style==""){$listfoliopro_archive_style='rounded';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Archive/All Listing Page Style','listfoliopro');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="listfoliopro_archive_style" id="listfoliopro_archive_style" value='rounded' <?php echo ($listfoliopro_archive_style=='rounded' ? 'checked':'' ); ?> > <?php esc_html_e( 'Rounded Grid View ', 'listfoliopro' );?>
			</label>	
		</div>		
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="listfoliopro_archive_style" id="listfoliopro_archive_style" value='square' <?php echo ($listfoliopro_archive_style=='square' ? 'checked':'' );  ?> > <?php esc_html_e( 'Square Grid View', 'listfoliopro' );?>
			</label>
		</div>		
	</div>
	<?php
		 $listfoliopro_single_style=get_option('listfoliopro_single_style');
		if($listfoliopro_single_style==""){$listfoliopro_single_style='style-2';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing Detail Page Style','listfoliopro');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="listfoliopro_single_style" id="listfoliopro_single_style" value='style-1' <?php echo ($listfoliopro_single_style=='style-1' ? 'checked':'' ); ?> > <?php esc_html_e( 'Rounded |style-1 ', 'listfoliopro' );?>
			</label>	
		</div>		
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="listfoliopro_single_style" id="listfoliopro_single_style" value='style-2' <?php echo ($listfoliopro_single_style=='style-2' ? 'checked':'' );  ?> > <?php esc_html_e( 'Square|Style-2', 'listfoliopro' );?>
			</label>
		</div>		
	</div>
	
<div class="form-group row">
	<label  class="col-md-3 control-label"> <?php esc_html_e('All Listing Page Columns','listfoliopro');  ?></label>
	<div class="col-md-2">
		<?php
			$listfoliopro_columns_desktop=get_option('listfoliopro_columns_desktop');
			if($listfoliopro_columns_desktop==""){$listfoliopro_columns_desktop='col-xl-4';}
		?>
		<select name="listfoliopro_columns_desktop"  class="form-control">
			<option value=""><?php esc_html_e('Columns On Desktop','listfoliopro'); ?></option>
			<option value="col-xl-12" <?php echo ($listfoliopro_columns_desktop=='col-xl-12'?' selected':''); ?>><?php esc_html_e('1 Column','listfoliopro'); ?></option>
			<option value="col-xl-6" <?php echo ($listfoliopro_columns_desktop=='col-xl-6'?' selected':''); ?>><?php esc_html_e('2 Column','listfoliopro'); ?></option>
			<option value="col-xl-4" <?php echo ($listfoliopro_columns_desktop=='col-xl-4'?' selected':''); ?>><?php esc_html_e('3 Column','listfoliopro'); ?></option>
			<option value="col-xl-3" <?php echo ($listfoliopro_columns_desktop=='col-xl-3'?' selected':''); ?>><?php esc_html_e('4 Column','listfoliopro'); ?></option>			
		</select>
	</div>		
	<div class="col-md-2">	
			<?php
			$listfoliopro_columns_iPad=get_option('listfoliopro_columns_iPad');
			if($listfoliopro_columns_iPad==""){$listfoliopro_columns_iPad='col-lg-6 col-md-6';}
		?>
		<select name="listfoliopro_columns_iPad"  class="form-control">
			<option value=""><?php esc_html_e('Columns On iPad Pro','listfoliopro'); ?></option>
			<option value="col-lg-12 col-md-12" <?php echo ($listfoliopro_columns_iPad=='col-lg-12 col-md-12'?' selected':''); ?>><?php esc_html_e('1 Column','listfoliopro'); ?></option>
			<option value="col-lg-6 col-md-6" <?php echo ($listfoliopro_columns_iPad=='col-lg-6 col-md-6'?' selected':''); ?>><?php esc_html_e('2 Column','listfoliopro'); ?></option>
			<option value="col-lg-4 col-md-4" <?php echo ($listfoliopro_columns_iPad=='col-lg-4 col-md-4'?' selected':''); ?>><?php esc_html_e('3 Column','listfoliopro'); ?></option>
			<option value="col-lg-3 col-md-3" <?php echo ($listfoliopro_columns_iPad=='col-lg-3 col-md-3'?' selected':''); ?>><?php esc_html_e('4 Column','listfoliopro'); ?></option>			
		</select>
	</div>
	<div class="col-md-2">	
			<?php
			$listfoliopro_columns_tab=get_option('listfoliopro_columns_tab');
			if($listfoliopro_columns_tab==""){$listfoliopro_columns_tab='col-sm-6';}
		?>
		<select name="listfoliopro_columns_tab"  class="form-control">
			<option value=""><?php esc_html_e('Columns On Tab','listfoliopro'); ?></option>
			<option value="col-sm-12" <?php echo ($listfoliopro_columns_tab=='col-sm-12'?' selected':''); ?>><?php esc_html_e('1 Column','listfoliopro'); ?></option>
			<option value="col-sm-6" <?php echo ($listfoliopro_columns_tab=='col-sm-6'?' selected':''); ?>><?php esc_html_e('2 Column','listfoliopro'); ?></option>
			<option value="col-sm-4" <?php echo ($listfoliopro_columns_tab=='col-sm-4'?' selected':''); ?>><?php esc_html_e('3 Column','listfoliopro'); ?></option>
			<option value="col-sm-3" <?php echo ($listfoliopro_columns_tab=='col-sm-3'?' selected':''); ?>><?php esc_html_e('4 Column','listfoliopro'); ?></option>			
		</select>
	</div>		
</div>	
	
	<?php
		$listfoliopro_user_can_publish=get_option('listfoliopro_user_can_publish');
		if($listfoliopro_user_can_publish==""){$listfoliopro_user_can_publish='yes';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Publish Listing','listfoliopro');  ?></label>
		<div class="col-md-2">
			<label>												
				<input type="radio" name="listfoliopro_user_can_publish" id="listfoliopro_user_can_publish" value='no' <?php echo ($listfoliopro_user_can_publish=='yes' ? 'checked':'' ); ?> > <?php esc_html_e( 'Admin will Publish', 'listfoliopro' );?>
			</label>	
		</div>
		<div class="col-md-2">	
			<label>											
				<input type="radio"  name="listfoliopro_user_can_publish" id="listfoliopro_user_can_publish" value='yes' <?php echo ($listfoliopro_user_can_publish=='no' ? 'checked':'' );  ?> > <?php esc_html_e( 'All user can publish', 'listfoliopro' );?>
			</label>
		</div>	
	</div>
	<?php
		$listing_hide=get_option('listfoliopro_listing_hide_opt');
		if($listing_hide==""){$listing_hide='package';}	
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing hide','listfoliopro');  ?></label>
		<div class="col-md-3">
			<label>												
				<input type="radio" name="listing_hide" id="listing_hide" value='package' <?php echo ($listing_hide=='package' ? 'checked':'' ); ?> > <?php esc_html_e( 'When User Package Expire ', 'listfoliopro' );?>
			</label>	
		</div>
		
		<div class="col-md-3">
			<label>											
				<input type="radio"  name="listing_hide" id="listing_hide" value='admin' <?php echo ($listing_hide=='admin' ? 'checked':'' );  ?> > <?php esc_html_e( 'Admin will hide/delete', 'listfoliopro' );?>
			</label>
		</div>	
		
	</div>
		<?php
		$directoryprosinglepage=get_option('directoryprosinglepage');
		if($directoryprosinglepage==''){$directoryprosinglepage='plugintemplate';}
		?>
	
		<div class="form-group row">
			<label  class="col-md-3 control-label"><?php esc_html_e('Listing Detail Page','listfoliopro');  ?>
				
				</label>
			<div class="col-md-2">					
				<label>												
					<input type="radio" name="directoryprosinglepage"  value='plugintemplate' <?php echo ($directoryprosinglepage=='plugintemplate' ? 'checked':'' ); ?> >							
					<?php esc_html_e('Plugin Own Template','listfoliopro');  ?>							
				</label>	
			</div>
			<div class="col-md-6">	
						<label >											
							<input type="radio" name="directoryprosinglepage"  value='custompage' <?php echo ($directoryprosinglepage=='custompage' ? 'checked':'' ); ?> >							
							<?php esc_html_e('Your Custom Page. Sometime Block theme will not get header. You need to create a page & add the shortcode :  [listfoliopro_single_rounded]  or [listfoliopro_single_square]','listfoliopro');  ?>							
						</label>
						<?php
						$single_custompag=get_option('listing_single_custompage'); 
							$args = array(
							'child_of'     => 0,
							'sort_order'   => 'ASC',
							'sort_column'  => 'post_title',
							'hierarchical' => 1,															
							'post_type' => 'page'
							);
						?>
						<?php											
						 if ( $pages = get_pages( $args ) ){
							echo "<select id='listing_single_custompage'  name='listing_single_custompage'  class=''>";
							 echo "<option value='' >".esc_html__('Select Your Custom listing Detail Page which has the shortcode','listfoliopro')."</option>";
							 
							foreach ( $pages as $page ) {
							  echo "<option value='{$page->ID}' ".($single_custompag==$page->ID ? 'selected':'').">{$page->post_title}</option>";
							}
							echo "</select>";
						  }
						?>
						
			</div>	
					
		</div>	
	<?php											
		$opt_style=	get_option('listfoliopro_archive_template');
		
	?>	
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default listing Image','listfoliopro');  ?>
		</label>
		<div class="col-md-2" id="listing_defaultimage">
				<?php
					if(get_option('listfoliopro_listing_defaultimage')!=''){
						$default_image= wp_get_attachment_image_src(get_option('listfoliopro_listing_defaultimage'));
						if(isset($default_image[0])){									
							$default_image=$default_image[0] ;
						}
						}else{
							$default_image=listfoliopro_ep_URLPATH."/assets/images/default-directory.jpg";
						}
					?>
				<img class="w80"   src="<?php echo esc_url($default_image);?>">
				
		</div>
		<div class="col-md-5">	
			
				<input type="hidden" name="listfoliopro_listing_defaultimage" id="listfoliopro_listing_defaultimage" >
				<button type="button" onclick="return  listfoliopro_listing_defaultimage_fun();" class="btn btn-primary btn-xs mt-1"><?php esc_html_e('Set Image','listfoliopro');  ?></button>
				<p class="btn-label"><?php esc_html_e('Best Fit 520px X 260px','listfoliopro');  ?> </p>
		</div>
	</div>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default Location Image','listfoliopro');  ?>
		</label>
		<div class="col-md-2" id="location_defaultimage">
			<?php
				if(get_option('listfoliopro_location_defaultimage')!=''){
						$default_image= wp_get_attachment_image_src(get_option('listfoliopro_location_defaultimage'));
						if(isset($default_image[0])){									
							$default_image=$default_image[0] ;
						}
						}else{
							$default_image=listfoliopro_ep_URLPATH."/assets/images/location.jpg";
						}
					?>
				<img class="w80"   src="<?php echo esc_url($default_image);?>">
				
		</div>
		<div class="col-md-5">	
				<input type="hidden" name="listfoliopro_location_defaultimage" id="listfoliopro_location_defaultimage" >
				<button type="button" onclick="return  listfoliopro_location_defaultimage_fun();" class="btn btn-primary btn-xs mt-1"><?php esc_html_e('Set Image','listfoliopro');  ?></button>
				<p class="btn-label"><?php esc_html_e('Best Fit 450px X 400px','listfoliopro');  ?> </p>
		</div>
	</div>
	
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Default Category Image','listfoliopro');  ?>
		</label>
		<div class="col-md-2" id="category_defaultimage">
					<?php
					if(get_option('listfoliopro_category_defaultimage')!=''){
						$default_image= wp_get_attachment_image_src(get_option('listfoliopro_category_defaultimage'));
						if(isset($default_image[0])){									
							$default_image=$default_image[0] ;
						}
						}else{
							$default_image=listfoliopro_ep_URLPATH."/assets/images/category.png";
						}
					?>
				<img class="w80"  src="<?php echo esc_url($default_image);?>">
				
		</div>
		<div class="col-md-5">	
				<input type="hidden" name="listfoliopro_category_defaultimage" id="listfoliopro_category_defaultimage" >
				<button type="button" onclick="return  listfoliopro_category_defaultimage_fun();" class="btn btn-primary btn-xs mt-1"><?php esc_html_e('Set Image','listfoliopro');  ?></button>
				<p class="btn-label"><?php esc_html_e('Best Fit 330px X 280px','listfoliopro');  ?> </p>
		</div>
	</div>
	
	<?php
		 $dir_number_format=get_option('dir_number_format');	
		 if($dir_number_format==""){$dir_number_format='usa';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Listing Price Format','listfoliopro');  ?></label>
		
			<label class="col-md-2">												
				<input type="radio" name="dir_number_format" id="dir_number_format" value='usa' <?php echo ($dir_number_format=='usa' ? 'checked':'' ); ?> ><?php esc_html_e('United States 1,200,000','listfoliopro');  ?>
			</label>	
		
		
			<label class="col-md-3">											
				<input type="radio"  name="dir_number_format" id="dir_number_format" value='european' <?php echo ($dir_number_format=='european' ? 'checked':'' );  ?> > <?php esc_html_e('European format 1.200.000','listfoliopro');  ?>
			</label>
			
	</div>
	
	<div class="form-group row">
		<?php
			$dir_style5_perpage='20';						
			$dir_style5_perpage=get_option('listfoliopro_dir_perpage');
			if($dir_style5_perpage==""){$dir_style5_perpage=20;}
		?>	
		<label  class="col-md-3 control-label">	<?php esc_html_e('Load Per Page','listfoliopro');  ?> </label>
		<div class="col-md-2">																	
			<input  class="form-control" type="input" name="listfoliopro_dir_perpage" id="listfoliopro_dir_perpage" value='<?php echo esc_attr($dir_style5_perpage); ?>'>
		</div>						
	</div>

	<?php
		$listfoliopro_url=get_option('listfoliopro_ep_url');
		if($listfoliopro_url==""){$listfoliopro_url='listing';}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Custom Post Type','listfoliopro');  ?></label>
		<div class="col-md-2">													
				<input  class="form-control"  type="input" name="listfoliopro_url" id="listfoliopro_url" value='<?php echo esc_attr($listfoliopro_url); ?>' >
			
		</div>
		<div class="col-md-5">
			<?php esc_html_e('No special characters, no upper case, no space','listfoliopro');  ?>
		</div>
	</div>
	
	
	<?php
		$listfoliopro_label_category=get_option('listfoliopro_label_category');
		if($listfoliopro_label_category==""){$listfoliopro_label_category=esc_html__('Categories','listfoliopro');}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Category Label','listfoliopro');  ?></label>
		<div class="col-md-2">													
				<input  class="form-control"  type="input" name="listfoliopro_label_category" id="listfoliopro_label_category" value='<?php echo esc_attr($listfoliopro_label_category); ?>' >
			
		</div>		
	</div>
		<?php
		$listfoliopro_label_tag=get_option('listfoliopro_label_tag');
		if($listfoliopro_label_tag==""){$listfoliopro_label_tag=esc_html__('Tags','listfoliopro');}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Tag Label','listfoliopro');  ?></label>
		<div class="col-md-2">													
				<input  class="form-control"  type="input" name="listfoliopro_label_tag" id="listfoliopro_label_tag" value='<?php echo esc_attr($listfoliopro_label_tag); ?>' >
			
		</div>		
	</div>
		<?php
		$listfoliopro_label_location=get_option('listfoliopro_label_location');
		if($listfoliopro_label_location==""){$listfoliopro_label_location=esc_html__('Locations','listfoliopro');}
	?>
	<div class="form-group row">
		<label  class="col-md-3 control-label"> <?php esc_html_e('Location Label','listfoliopro');  ?></label>
		<div class="col-md-2">													
				<input  class="form-control"  type="input" name="listfoliopro_label_location" id="listfoliopro_label_location" value='<?php echo esc_attr($listfoliopro_label_location); ?>' >
			
		</div>		
	</div>
	
	<hr>
	

	
	<div class="form-group row">
		<div class="col-md-8">
			<div id="update_message49"> </div>	
			<button type="button" onclick="return  listfoliopro_update_dir_setting();" class="listfoliopro-button"><?php esc_html_e('Save & Update','listfoliopro');  ?></button>
		</div>
	</div>
</form>