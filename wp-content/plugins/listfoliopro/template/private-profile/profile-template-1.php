<?php
	 if ( ! defined( 'ABSPATH' ) ) exit; 
	wp_enqueue_script("jquery");
	wp_enqueue_style('jquery-ui', listfoliopro_ep_URLPATH . 'admin/files/css/jquery-ui.css');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('bootstrap', listfoliopro_ep_URLPATH . 'admin/files/css/iv-bootstrap.css');
	wp_enqueue_script('bootstrap.min', listfoliopro_ep_URLPATH . 'admin/files/js/bootstrap.min-4.js');
	wp_enqueue_script('popper', 		listfoliopro_ep_URLPATH . 'admin/files/js/popper.min.js');
	wp_enqueue_style('colorbox', listfoliopro_ep_URLPATH . 'admin/files/css/colorbox.css');
	wp_enqueue_script('colorbox', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.colorbox-min.js');
	wp_enqueue_script('jquery.fancybox',listfoliopro_ep_URLPATH . 'admin/files/js/jquery.fancybox.js');
	wp_enqueue_style('fontawesome', listfoliopro_ep_URLPATH . 'admin/files/css/all.min.css');
	wp_enqueue_style('listfoliopro_my-account', listfoliopro_ep_URLPATH . 'admin/files/css/my-account.css');
	wp_enqueue_style('listfoliopro_my-account-2', listfoliopro_ep_URLPATH . 'admin/files/css/my-account-new.css');
	wp_enqueue_style('listfoliopro_my-menu', listfoliopro_ep_URLPATH . 'admin/files/css/cssmenu.css');
	wp_enqueue_script('listfoliopro_script-user-directory', listfoliopro_ep_URLPATH . 'admin/files/js/user-directory.js');
	wp_enqueue_style('jquery.dataTables', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('jquery.dataTables', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.dataTables.js');	
	wp_enqueue_style('datetimepicker', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.datetimepicker.css');
	// Map openstreet
	wp_enqueue_script('leaflet', listfoliopro_ep_URLPATH . 'admin/files/js/leaflet.js');
	wp_enqueue_style('leaflet', listfoliopro_ep_URLPATH . 'admin/files/css/leaflet.css');
	wp_enqueue_script('leaflet-geocoder-locationiq', listfoliopro_ep_URLPATH . 'admin/files/js/leaflet-geocoder-locationiq.min.js');		
	wp_enqueue_style('leaflet-geocoder-locationiq', listfoliopro_ep_URLPATH . 'admin/files/css/leaflet-geocoder-locationiq.min.css');
	wp_enqueue_media();
	$main_class = new listfoliopro_eplugins;
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	global $current_user;
	global $wpdb;
	$user = new WP_User( $current_user->ID );
	if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
		foreach ( $user->roles as $role ){
			$crole= ucfirst($role);
			break;
		}
	}
	if(strtoupper($crole)!=strtoupper('administrator')){
		include(listfoliopro_ep_template.'/private-profile/check_status.php');
	}
	$currencies = array();
	$currencies['AUD'] ='$';$currencies['CAD'] ='$';
	$currencies['EUR'] ='€';$currencies['GBP'] ='£';
	$currencies['JPY'] ='¥';$currencies['USD'] ='$';
	$currencies['NZD'] ='$';$currencies['CHF'] ='Fr';
	$currencies['HKD'] ='$';$currencies['SGD'] ='$';
	$currencies['SEK'] ='kr';$currencies['DKK'] ='kr';
	$currencies['PLN'] ='zł';$currencies['NOK'] ='kr';
	$currencies['HUF'] ='Ft';$currencies['CZK'] ='Kč';
	$currencies['ILS'] ='₪';$currencies['MXN'] ='$';
	$currencies['BRL'] ='R$';$currencies['PHP'] ='₱';
	$currencies['MYR'] ='RM';$currencies['AUD'] ='$';
	$currencies['TWD'] ='NT$';$currencies['THB'] ='฿';
	$currencies['TRY'] ='TRY';	$currencies['CNY'] ='¥';
	$currency= get_option('listfoliopro_api_currency');
	$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
	$user_id= $current_user->ID;
?>
<?php
	
	$user_id=$current_user->ID;
	$iv_profile_pic_url=get_user_meta($user_id, 'listfoliopro_profile_pic_thum',true);
	
	$active_single_fields_saved=get_option('listfoliopro_single_fields_saved' );	
	if(empty($active_single_fields_saved)){$active_single_fields_saved=listfoliopro_get_listing_fields_all_single();}	
?>
<div class="bootstrap-wrapper " id="profile-account2">
	<input type="hidden" id="profileID" value="<?php echo esc_attr($user_id); ?>">
	<div class="container-fluid">			
	<div class="row" >
		<div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
			<div class="sidebar-myaccount" id="listfoliopro-left-menu">
				<div class="sidebar-heading pb-15 ">
					<div class="avatar-sidebar mt-3">
						<?php	
							$company_name= get_user_meta($user_id,'full_name', true);
							 $company_address= get_user_meta($user_id,'address', true);
							 $company_web=get_user_meta($user_id,'website', true);
							 $company_phone=get_user_meta($user_id,'phone', true);
							$company_logo=get_user_meta($user_id, 'listfoliopro_profile_pic_thum',true);
							if(array_key_exists('company-logo',$active_single_fields_saved)){ 
								if(trim($company_logo)!=''){
								?>
								<figure><img alt="image" class="height100p"  src="<?php echo esc_url($company_logo); ?>"></figure>
								<?php
								}else{?>
								<figure class="blank-rounded-logo"></figure>
								<?php
								}
							}
						?>
						<div class="sidebar-info"><span class="toptitle-sub"><?php echo esc_html($company_name); ?></span>
							<?php
								$all_locations= str_replace(',',' ',get_user_meta($user_id, 'all_locations', true));
								if(!empty( $all_locations)){
								?>
								<span class="card-location mt-2"><i class="fa-solid fa-location-dot mr-2"></i><?php echo esc_html($all_locations); ?>
								</span>
								<?php
								}								
							?>
						</div>
					</div>
				</div>
				
					
				<div class="sidebar-list-listing"  id="listfoliopro-left-menu">
					
					<!-- SIDEBAR MENU -->
					<div class="profile-usermenu" >
						<?php
							$active='setting';
							if(isset($_GET['profile']) AND $_GET['profile']=='setting' ){
								$active='setting';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='level' ){
								$active='level';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){
								$active='all-post';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='new-post' ){
								$active='new-post';
							}							
							if(isset($_GET['profile']) AND $_GET['profile']=='dashboard' ){
								$active='dashboard';
							}							
							
							if(isset($_GET['profile']) AND $_GET['profile']=='notification' ){
								$active='notification';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){
								$active='all-post';
							}							
							if(isset($_GET['profile']) AND $_GET['profile']=='booking' ){
								$active='booking';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='author_bookmarks' ){
								$active='author_bookmarks';
							}
							if(isset($_GET['profile']) AND $_GET['profile']=='messageboard' ){
								$active='messageboard';
							}							
							if(isset($_GET['profile']) AND $_GET['profile']=='listing_bookmark' ){
								$active='listing_bookmark';
							}
							$post_type=  'listing';
						?>
						<div id='cssmenu'>
							<?php
								
								include(  listfoliopro_ep_template. 'private-profile/all-menu.php');
									
							?>
						</div>
					</div>
					<!-- END MENU -->
				</div>
			</div>
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-12">
			<div class="listing-overview">	
				<?php
					if(isset($_GET['profile']) AND $_GET['profile']=='all-post' ){						
						if( get_option('epjblistfoliopro_menuallpost' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_menuallpost');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/profile-all-post-1.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
						
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='level' ){						
						if( get_option('epjblistfoliopro_mylevel' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_mylevel');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/profile-level-1.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='post-edit' ){						
						if( get_option('epjblistfoliopro_menuallpost' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_menuallpost');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/profile-edit-post-1.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
					}
					
					elseif(isset($_GET['profile']) AND $_GET['profile']=='setting' ){
						include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
					}	
					elseif(isset($_GET['profile']) AND $_GET['profile']=='author_bookmarks' ){
						if( get_option('epjblistfoliopro_author_bookmarks' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_author_bookmarks');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/author-bookmarks.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
					}										
					elseif(isset($_GET['profile']) AND $_GET['profile']=='listing_bookmark' ){						
						if( get_option('epjblistfoliopro_listing_bookmarks' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_listing_bookmarks');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/listing_bookmark-file.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
						
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='messageboard' ){						
						if( get_option('epjblistfoliopro_messageboard' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_messageboard');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/messageboard.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}
						
					
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='booking' ){						
						if( get_option('epjblistfoliopro_booking' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_booking');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/booking.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}	
						
					}elseif(isset($_GET['profile']) AND $_GET['profile']=='notification' ){						
						if( get_option('epjblistfoliopro_notification' ) ) {
							$account_menu_check= get_option('epjblistfoliopro_notification');
						}
						if($account_menu_check!='yes'){
							include(  listfoliopro_ep_template. 'private-profile/listing-notifications.php');
						}else{
							include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						}					
					}else{					 
						include(  listfoliopro_ep_template. 'private-profile/profile-setting-1.php');
						
					}
				?>
			</div>			
		</div>
	</div>		
</div>
</div>

<?php
	$currencyCode = get_option('listfoliopro_api_currency');
	wp_enqueue_script('listfoliopro_myaccount', listfoliopro_ep_URLPATH . 'admin/files/js/my-account.js');
	wp_localize_script('listfoliopro_myaccount', 'listfoliopro1', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'wp_iv_directories_URLPATH'		=> listfoliopro_ep_URLPATH,
	'current_user_id'	=>get_current_user_id(),
	'SetImage'		=>esc_html__('Set Image','listfoliopro'),
	'GalleryImages'=>esc_html__('Gallery Images','listfoliopro'),
	'cancel-message' => esc_html__('Are you sure to cancel this Membership','listfoliopro'),
	'currencyCode'=>  $currencyCode,
	'dirwpnonce'=> wp_create_nonce("myaccount"),
	'dirwpnonce2'=> wp_create_nonce("signup2"),
	'signup'=> wp_create_nonce("signup"),
	'contact'=> wp_create_nonce("contact"),
	'permalink'=> get_permalink(),
	"sProcessing"=>  esc_html__('Processing','listfoliopro'),
	"sSearch"=>   esc_html__('Search','listfoliopro'),
	"lengthMenu"=>   esc_html__('Display _MENU_ ','listfoliopro'),
	"zeroRecords"=>  esc_html__('Nothing found - sorry','listfoliopro'),
	"info"=>  esc_html__('Showing page _PAGE_ of _PAGES_','listfoliopro'),
	"infoEmpty"=>   esc_html__('No records available','listfoliopro'),
	"infoFiltered"=>  esc_html__('(filtered from _MAX_ total records)','listfoliopro'),
	"sFirst"=> esc_html__('First','listfoliopro'),
	"sLast"=>  esc_html__('Last','listfoliopro'),
	"sNext"=>     esc_html__('Next','listfoliopro'),
	"sPrevious"=>  esc_html__('Previous','listfoliopro'),
	"makeShortListed"=>  esc_html__('Make Shortlisted','listfoliopro'), 
	"ShortListed"=>  esc_html__('Undo Shortlisted','listfoliopro'), 
	"Rejected"=>  esc_html__('Rejected','listfoliopro'), 
	"MakeReject"=>  esc_html__('Make Reject','listfoliopro'), 		
	) );
	wp_enqueue_script('listfoliopro_single-listing', listfoliopro_ep_URLPATH . 'admin/files/js/single-listing.js');
	wp_localize_script('listfoliopro_single-listing', 'listfoliopro_data', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',
	'current_user_id'	=>get_current_user_id(),
	'Please_login'=>esc_html__('Please login', 'listfoliopro' ),
	'Add_to_Favorites'=>esc_html__('Add to Favorites', 'listfoliopro' ),
	'Added_to_Favorites'=>esc_html__('Added to Favorites', 'listfoliopro' ),	
	'contact'=> wp_create_nonce("contact"),
	'listing'=> wp_create_nonce("listing"),
	'cv'=> wp_create_nonce("Doc/CV/PDF"),
	'listfoliopro_ep_URLPATH'=>listfoliopro_ep_URLPATH,
	) );
	wp_enqueue_script('listfoliopro_message', listfoliopro_ep_URLPATH . 'admin/files/js/user-message.js');
	wp_localize_script('listfoliopro_message', 'listfoliopro_data_message', array(
	'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
	'loading_image'		=> '<img src="'.listfoliopro_ep_URLPATH.'admin/files/images/loader.gif">',		
	'Please_put_your_message'=>esc_html__('Please put your name,email & message', 'listfoliopro' ),
	'contact'=> wp_create_nonce("contact"),
	'listing'=> wp_create_nonce("listing"),
	) );
	wp_reset_query();
	?>	