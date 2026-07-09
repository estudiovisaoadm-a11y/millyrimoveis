<?php
	global $wpdb;
	global $current_user;
	$ii=1;
?>	
<div class="row">
	<div class="col-md-12 p-0">
	
<form id="my_account_menu" name="my_account_menu" class="form-horizontal col-md-12" role="form" onsubmit="return false;">
	<div id="success_message">	</div>	
	<?php
		$profile_page=get_option('listfoliopro_profile_page');
		$page_link= get_permalink( $profile_page); 
	?>
	<hr>
	<div class="row ">
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Listing Search','listfoliopro');?>
		</div>					
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_menu_listinghome' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_menu_listinghome');
					}	 
				?>
				<input type="checkbox" name="listinghome" id="listinghome" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> > <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>					  
	</div>
	<hr>
	<div class="row ">
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Membership','listfoliopro');	 ?>
		</div>
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_mylevel' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_mylevel');
					}	 
				?>
				<input type="checkbox" name="mylevel" id="mylevel" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>					  
	</div>						
	<hr>
	<div class="row ">					
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Manage Listings','listfoliopro');?>
		</div>						
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_menuallpost' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_menuallpost');
					}	 
				?>
				<input type="checkbox" name="menuallpost" id="menuallpost" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>
	</div>		
	<hr>
	<div class="row ">
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Message board','listfoliopro');?>
		</div>
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_messageboard' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_messageboard');
					}	 
				?>
				<input type="checkbox" name="messageboard" id="messageboard" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>					  
	</div>	
	<hr>
	<div class="row ">
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Notification','listfoliopro');?>
		</div>						
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_notification' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_notification');
					}	 
				?>
				<input type="checkbox" name="notification" id="notification" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>					  
	</div>		
	
	<hr>
	<div class="row ">
		<div class="col-sm-3 col-6 control-label">
			<?php  esc_html_e('Saved Listing','listfoliopro');?>
		</div>					
		<div class="col-sm-9 col-6">
			<div class="checkbox ">
				<label><?php
					$account_menu_check='';
					if( get_option('epjblistfoliopro_listing_bookmarks' ) ) {
						$account_menu_check= get_option('epjblistfoliopro_listing_bookmarks');
					}	 
				?>
				<input type="checkbox" name="listing_bookmark" id="listing_bookmark" value="yes" <?php echo ($account_menu_check=='yes'? 'checked':'' ); ?> >  <?php  esc_html_e('Hide from My Account Page','listfoliopro');?>
				</label>
			</div>											
		</div>	
	</div>		
</form>
	<div class="row">					
		<div class="col-md-12">					
			<hr/>
			<div id="update_myaccount_menu-message"></div>					
			<button class="btn btn-info listfoliopro-button" onclick="return listfoliopro_update_myaccount_menu();"><?php  esc_html_e('Update','listfoliopro');?>  </button>
		</div>
	</div>
</div>
</div>