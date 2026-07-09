<div class="row">
	<div class="   col-md-12 ">
		<?php
			$no=20000;
			$paged = (isset($_REQUEST['paged'])) ? sanitize_text_field($_REQUEST['paged']) : 1;
			if($paged==1){
				$offset=0;
				}else {
				$offset= ($paged-1)*$no;
			}
			$args = array();
			$args['number']='99999999';		
			$args['orderby']='registered';
			$args['order']='DESC';
			$user_query = new WP_User_Query( $args );
		?>
		<table id="user-data" class="table dt-responsive nowrap"   width="100%">
			<thead>
				<tr>
					<th> <?php  esc_html_e('User Detail','listfoliopro')	;?> </th>
					<th> <?php  esc_html_e('Payment','listfoliopro')	;?> </th>
				</tr>
			</thead>
			<tbody>
				<?php
					// User Loop
					if ( ! empty( $user_query->results ) ) {
						foreach ( $user_query->results as $user ) {
						?>
						<tr>
							<td>
								<div class="row control-label">
									<div class="col-md-12 ">
										<?php  esc_html_e('ID : ','listfoliopro');?> <?php echo esc_html($user->ID); ?>
									</div>
									<div class="col-md-12">
										<?php  esc_html_e('Date : ','listfoliopro');?><?php echo gmdate("d-M-Y h:m:s A" ,strtotime($user->user_registered) ); ?>
									</div>
									<div class="col-md-12">
										<?php  esc_html_e('User Name : ','listfoliopro');?> <?php echo esc_attr(get_user_meta($user->ID, 'first_name', true)).' '.esc_attr(get_user_meta($user->ID, 'last_name', true)).' ('. $user->display_name.')'; ?>
									</div>										
									<div class="col-md-12">
										<?php  esc_html_e('Email : ','listfoliopro');?> <?php echo esc_html($user->user_email); ?>
									</div>
									<div class="col-md-12">
									<?php  esc_html_e('Role  : ','listfoliopro');?>
									<?php
										if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
											foreach ( $user->roles as $role )
											echo ucfirst($role);
										}
									?>
									</div>										
								</div>
								<div class="row mt-2 control-label">
									<div class="col-12">
										<a class="btn btn-primary btn-xs" href="?page=listfoliopro-user_update&id=<?php echo esc_attr($user->ID); ?>"><span class="dashicons dashicons-edit"></span></a>

										<?php
										$profile_page=get_option('listfoliopro__public_profile_page');
										$page_link= get_permalink( $profile_page).'?&id='.$user->ID;
										?>
                                        <a  target="blank" href="<?php echo esc_url($page_link); ?>" target="_blank" class="btn btn-primary btn-xs "><span class="dashicons dashicons-visibility"></span></a>

                                        <a class="btn btn-primary btn-xs" href="<?php echo admin_url().'/users.php'?>"><span class="dashicons dashicons-trash"></span></a>
                                    </div>
								</div>
							</td>
							<td>
								<?php
									echo esc_attr(get_user_meta($user->ID, 'listfoliopro_payment_status', true));
								?>
							</td>
							
						</tr>
						<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>