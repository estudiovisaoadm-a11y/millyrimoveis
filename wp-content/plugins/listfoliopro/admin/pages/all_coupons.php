<?php
	if(isset($_REQUEST['delete_id']))  { 
		if (current_user_can( 'manage_options' ) ) {
			$post_id=sanitize_text_field($_REQUEST['delete_id']);
			wp_delete_post($post_id);
			delete_post_meta($post_id,true);
			$message=esc_html__( 'Deleted Successfully', 'listfoliopro' ) ;
		}	
	}

			if(!isset($_REQUEST['id']))  {
			?>
			
			<div class="row">
				<div class="col-md-12 table-responsive ">					
					<small >
						<?php
							if (isset($_REQUEST['form_submit']) AND $_REQUEST['form_submit'] <> "") {
								echo  '<span>['.esc_html__( ' The Coupon Create Successfully ','listfoliopro').']</span>';
							}
							if (isset($message) AND $message <> "") {
								echo  '<span> [ '.$message.' ]</span>';
							}
						?>
					</small>
					
					<table class="table table-striped col-md-12">
						<thead >
							<tr>
								<th><?php esc_html_e( 'Coupon Detail', 'listfoliopro' );?></th>						
								<th ><?php esc_html_e( 'Action', 'listfoliopro' );?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								global $wpdb, $post;
								$listfoliopro_coupon='listfoliopro_coupon';
								$sql=$wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = '%s'", $listfoliopro_coupon );
								$products_rows = $wpdb->get_results($sql);
								if(sizeof($products_rows)>0){
									$i=0;
									foreach ( $products_rows as $row )
									{ ?>
										<tr>
											<td>
												<div class="row control-label">					
													<div class="col-md-12 col-lg-12">	
														<?php esc_html_e( 'Name : ', 'listfoliopro' );?><?php echo esc_html($row->post_title);?>
													</div>
													<div class="col-md-12 col-lg-12">	
													<?php esc_html_e( 'Start Date : ', 'listfoliopro' );?><?php echo esc_html(get_post_meta($row->ID, 'listfoliopro_coupon_end_date', true));?>
													</div>
													<div class="col-md-12 col-lg-12">	
													<?php esc_html_e( 'End Date : ', 'listfoliopro' );?><?php echo esc_html(get_post_meta($row->ID, 'listfoliopro_coupon_end_date', true));?>
													</div>
													<div class="col-md-12 col-lg-12">	
													<?php esc_html_e( 'Uses Limit : ', 'listfoliopro' );?><?php echo esc_html(get_post_meta($row->ID, 'listfoliopro_coupon_limit', true).' / '.get_post_meta($row->ID, 'listfoliopro_coupon_used', true));?>
													</div>
													<div class="col-md-12 col-lg-12">
													<?php esc_html_e( 'Amount : ', 'listfoliopro' );?><?php echo esc_html( get_post_meta($row->ID, 'listfoliopro_coupon_amount', true));?>
													</div>
													
												</div>	
													
											</td>
											<td>
											<div class="row control-label">
												<div class=" col-md-12 col-lg-4 mb-2">	
													<a class="btn btn-primary btn-xs" href="?page=listfoliopro-coupon-update&id=<?php echo esc_attr($row->ID);?>"> <?php echo esc_html__( 'Edit', 'listfoliopro');?></a> 
												</div>
												<div class=" col-md-12 col-lg-4 mb-2">	
													<a href="?page=listfoliopro-settings&delete_id=<?php echo esc_attr($row->ID);?>" class="btn btn-danger btn-xs" onclick="return confirm(\'Are you sure to delete this form?\');">
														<?php esc_html_e( 'Delete', 'listfoliopro');?></a>
												</div>
												
											</div>	
											
										
											
											</td>
										</tr>
									
									<?php										
										
										$i++;
									}
								}
							?>
						</tbody>
					</table>
					<div class=" col-md-12  bs-callout bs-callout-info">		
						<?php esc_html_e( 'Note : Coupon will work on "One Time Payment" only. Coupon will not work on recurring payment and it will not support 100% discount.	', 'listfoliopro' );?>					
					</div>
				</div>
			</div>
			<div class="row">					
				<div class="col-md-12">					
					<div class="">								
						<a class="btn btn-info listfoliopro-button"  href="<?php echo listfoliopro_ep_ADMINPATH; ?>admin.php?page=listfoliopro-coupon-create"><?php esc_html_e( 'Create A New Coupon', 'listfoliopro' );?></a>
					</div>
				</div>
			</div>
			<div class="row">
				<br/>	
			</div>
			<?php
			}
		?>
		
	