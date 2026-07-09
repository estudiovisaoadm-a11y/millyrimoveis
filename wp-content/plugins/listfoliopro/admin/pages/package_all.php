<?php
	global $wpdb;
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
	$registration=get_option('listfoliopro_registration'); 
	if(isset($_REQUEST['delete_id']))  {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'Are you cheating:user Permission?' );
		}
		$post_id=sanitize_text_field($_REQUEST['delete_id']);	
		$recurring= get_post_meta($post_id, 'listfoliopro_package_recurring', true);
		if($recurring=='on'){
			$iv_gateway = get_option('listfoliopro_payment_gateway');
			if($iv_gateway=='stripe'){
				require_once(listfoliopro_ep_DIR . '/admin/files/lib/Stripe.php');
				$post_name2='listfoliopro_stripe_setting';
				$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name = '%s",$post_name2 ));
				if(isset($row->ID )){
					$stripe_id= $row->ID;
				}	
				$post_package = get_post($post_id); 
				$p_name = $post_package->post_name;
				$stripe_mode=get_post_meta( $stripe_id,'listfoliopro_stripe_mode',true);	
				if($stripe_mode=='test'){
					$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_secret_test',true);	
					}else{
					$stripe_api =get_post_meta($stripe_id, 'listfoliopro_stripe_live_secret_key',true);	
				}
				$plan='';	
				Stripe::setApiKey($stripe_api);
				try {
					$plan = Stripe_Plan::retrieve($p_name);
					$plan->delete();
					} catch (Exception $e) {
					print_r($e); die();
				}		
			}
		}							
		wp_delete_post($post_id);
		delete_post_meta($post_id,true);
		$message=esc_html__( 'Deleted Successfully', 'listfoliopro' ) ;
	}
	if(isset($_REQUEST['form_submit']))  {
		$message= esc_html__( 'Update Successfully', 'listfoliopro' ) ;
	}
	$api_currency= get_option('listfoliopro_api_currency' );
?>
<div class="row">
	<div class="col-md-12  ">
		<small >
			<?php
				if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
				}
				if (isset($message) AND $message <> "") {
					echo  '<span> [ '.$message.' ]</span>';
				}
			?>
		</small>
		<table class="table table-striped  col-md-12" >
			<thead >
				<tr>
					<th ><?php esc_html_e( 'Package Detail', 'listfoliopro' );?></th>									
					<th ><?php esc_html_e( 'Action', 'listfoliopro' );?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$currency=$api_currency ;
					$currency_symbol=(isset($currencies[$currency]) ? $currencies[$currency] :$currency );
					global $wpdb, $post;
					$listfoliopro_pack='listfoliopro_pack';
					$sql=$wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = '%s'",$listfoliopro_pack );
					$membership_pack = $wpdb->get_results($sql);
					$total_package=count($membership_pack);
					if(is_array($membership_pack)){
						$i=0;
						foreach ( $membership_pack as $row )
						{
						?>
						<tr>
							<td>
								<div class="row control-label">					
									<div class="col-md-12 col-lg-12">					
										<?php esc_html_e( 'Package Name : ', 'listfoliopro' );?><?php echo esc_html($row->post_title);?>
									</div>
									<div class="col-md-12 col-lg-12">										
										<?php esc_html_e( 'Amount : ', 'listfoliopro' );?><?php 
											$amount='';
											if(get_post_meta($row->ID, 'listfoliopro_package_cost', true)!="" AND get_post_meta($row->ID, 'listfoliopro_package_cost', true)!="0"){
												$amount= get_post_meta($row->ID, 'listfoliopro_package_cost', true).' '.$currency;
												}else{
												$amount= '0 '.$currency;
											}
											$recurring= get_post_meta($row->ID, 'listfoliopro_package_recurring', true);	
											if($recurring == 'on'){
												$count_arb=get_post_meta($row->ID, 'listfoliopro_package_recurring_cycle_count', true); 	
												if($count_arb=="" or $count_arb=="1"){
													$recurring_text=" per ".' '.get_post_meta($row->ID, 'listfoliopro_package_recurring_cycle_type', true);
													}else{
													$recurring_text=' per '.$count_arb.' '.get_post_meta($row->ID, 'listfoliopro_package_recurring_cycle_type', true).'s';
												}
												}else{
												$recurring_text=' &nbsp; ';
											}
											$recurring= get_post_meta($row->ID, 'listfoliopro_package_recurring', true);	
											if($recurring == 'on'){
												$amount= get_post_meta($row->ID, 'listfoliopro_package_recurring_cost_initial', true).' '.$currency;
												$amount=$amount. ' / '.$recurring_text;
											}
											echo esc_html($amount);?>
									</div>
									
									<div class="col-md-12 col-lg-12">
									<?php esc_html_e( 'Type : ', 'listfoliopro' );?>
										<?php											
										echo (get_post_meta($row->ID,'listfoliopro_package_vip_badge',true)=='yes'?'VIP Badge':'' );
										echo' | ';
										echo (get_post_meta($row->ID,'listfoliopro_package_feature',true)=='yes'?'Feature Listing':'' );
										?> 	
									</div>										
									<div class="col-md-12 col-lg-12">		
									<?php esc_html_e( 'User Role : ', 'listfoliopro' );?><?php echo esc_html($row->post_title);?> 	
									</div>
									<div class="col-md-12 col-lg-12">										
									<a target="blank" href="<?php echo get_page_link($registration);?>?&package_id=<?php echo esc_attr($row->ID);?> "><?php esc_html_e( 'Registration Link', 'listfoliopro' );?> </a>
									</div>
								</div>
							</td>
							<td>
								<div class="row control-label">
									<div class=" col-md-12 col-lg-5 mb-2">	
										<div id="status_<?php echo esc_html($row->ID); ?>">
											<?php
												if($row->post_status=="draft"){										
													$pac_msg=esc_html__( 'Active', 'listfoliopro' );
													}else{										
													$pac_msg=esc_html__( 'Inactive', 'listfoliopro' );
												}
											?>
											<button class="btn btn-info btn-xs mr-1" onclick="return listfoliopro_package_status_change('<?php echo esc_attr($row->ID); ?>','<?php echo esc_attr($row->post_status); ?>');"><?php echo esc_html($pac_msg); ?></button>
										</div>
									</div>
									<div class="col-md-12 col-lg-4   mb-2">	
										<a class="btn btn-primary btn-xs" href="?page=listfoliopro-package-update&id=<?php echo esc_attr($row->ID);?>"><?php esc_html_e( ' Edit', 'listfoliopro' );?></a> 
									</div>
									<div class="col-md-12 col-lg-3 mb-2">	
										<a href="?page=listfoliopro-settings&delete_id=<?php echo esc_attr($row->ID);?>" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this package?\')"><?php esc_html_e( 'X', 'listfoliopro' );?></a>
									</div>
								</div>																								
							</td>
						</tr>	
						<?php
								$i++;
							}
						}else{ ?>
						<br/>
						<br/>
						<tr><td> <h4><?php esc_html_e( 'Package List is Empty', 'listfoliopro' );?> </h4></td></tr>
						<?php	
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<div class="row">					
		<div class="col-md-12">		
				<a class="btn btn-info mt-2 listfoliopro-button "  href="<?php echo listfoliopro_ep_ADMINPATH; ?>admin.php?page=listfoliopro-package-create"><?php esc_html_e( 'Create A New Package', 'listfoliopro' );?></a>
			
		</div>
	</div>
	<div class="row">	
		<div class="card col-md-12">
			<div class="card-body">
				<div class=" col-md-12  bs-callout bs-callout-info">		
					<?php esc_html_e( 'User role "Basic" is created on the plugin activation. Paid exprired or unsuccessful payment user will set on the "Basic" user role.', 'listfoliopro' );?>	
				</div>
				<div class="clearfix"></div>
				<ul class=" list-group col-md-12">
					<li class="list-group-item"><?php esc_html_e('Short Code :','listfoliopro');  ?> <code>[listfoliopro_price_table]  </code>
						<?php 
							$listfoliopro_price_table=get_option('listfoliopro_price_table');
						?>
						<a class="btn btn-info btn-xs listfoliopro-button ml-5" href="<?php echo get_permalink( $listfoliopro_price_table ); ?>" target="blank"><?php esc_html_e( 'View Page', 'listfoliopro' );?></a>
					</li>
				</ul>	
				<div class="clearfix"></div>
				<div class="  bs-callout bs-callout-info">	
					<?php esc_html_e( 'Note: You can use other available pricing table. The package link URL will go on "Sign UP " button. ', 'listfoliopro' );?>	
				</div>
			</div>
		</div>	
	</div>		