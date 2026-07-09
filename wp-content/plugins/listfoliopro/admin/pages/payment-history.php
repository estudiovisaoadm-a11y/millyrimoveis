<?php	
	wp_enqueue_style('dataTables', listfoliopro_ep_URLPATH . 'admin/files/css/jquery.dataTables.css');
	wp_enqueue_script('dataTables', listfoliopro_ep_URLPATH . 'admin/files/js/jquery.dataTables.js');
	global $post;
?> 
	
<div class="row">
	<div class="col-md-12  ">
			<?php
				
			$args = array(
			'post_type' => 'iv_payment', // enter your custom post type
			'post_status' => 'publish',
			'posts_per_page'=> '9999999999',
			'orderby' => 'date',
			'order'   => 'DESC',
			);							
			$the_query = new WP_Query( $args );
			
			?>
			<table id="user_payment_history" class="display table" width="100%" >
				<thead>
					<tr>
						<th> <?php  esc_html_e('User ID','listfoliopro')	;?> </th>
						<th> <?php  esc_html_e('Detail','listfoliopro')	;?> </th>						
					
					</tr>
				</thead>
				<tbody>
					<?php
						// User Loop
						if ( $the_query->have_posts() ) :
							while ( $the_query->have_posts() ) : $the_query->the_post();									
							?>
							<tr>
								<td>	
								<?php
									$user_info = get_userdata( $post->post_author);
									if($user_info!='' ){
										echo  esc_html($user_info->user_login);
									}									
									 ?>
								</td>
								<td>
										<div class="row control-label">		
											<div class="col-md-12 col-lg-12">	
												<?php  esc_html_e( 'Email  : ', 'listfoliopro' );?>										
												<?php echo esc_html($user_info->user_email); ?>
											</div>
											<div class="col-md-12 col-lg-12">	
												<?php  esc_html_e( 'Date  : ', 'listfoliopro' );?>										
												<?php echo get_the_date('M d, Y : h i a', $post->date);  ?>
											</div>										
											<div class="col-md-12 col-lg-12">	
												<?php esc_html_e( 'Package  : ', 'listfoliopro' );?>	
											</div>
											<div class="col-md-12 col-lg-12">	
												<?php esc_html_e( 'Amount  : ', 'listfoliopro' );?>	
												<?php echo esc_html($post->post_content); ?>
											</div>									
										</div>	
								
									</td>
							</tr>
							<?php
						endwhile;
					endif;
					?>
				</tbody>
			</table>
		</div>
	</div>
	