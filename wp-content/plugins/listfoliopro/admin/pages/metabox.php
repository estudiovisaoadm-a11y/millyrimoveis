<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="bootstrap-wrapper">
 	<div class="dashboard-eplugin container-fluid">
 		<?php	
			global $wpdb, $post,$current_user;	
			//*************************	plugin file *********
			$listfoliopro_approve= get_post_meta( $post->ID,'listfoliopro_approve', true );
			$listfoliopro_current_author= $post->post_author;
			$userId=$current_user->ID;
			if(isset($current_user->roles[0]) and $current_user->roles[0]=='administrator'){
			?>
			<div class="row">
				<div class="col-md-12">
					<?php esc_html_e( 'User ID :', 'listfoliopro' )?>
					<select class="form-control" id="listfoliopro_author_id" name="listfoliopro_author_id">
						<?php	
						
							$user_query = new WP_User_Query(array('number' => -1) );
							if ( ! empty( $user_query->get_results() ) ) {
								foreach ( $user_query->get_results() as $user ) {	
									echo '<option value="'.$user->ID.'"'. ($listfoliopro_current_author == $user->ID ? "selected" : "").' >'. $user->ID.' | '.$user->user_email.' </option>';
									
								}
							}
							
							
						?>
					</select>
				</div>  
				<div class="col-md-12"> <label>
					<input type="checkbox" name="listfoliopro_approve" id="listfoliopro_approve" value="yes" <?php echo ($listfoliopro_approve=="yes" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Approve', 'listfoliopro' )?></strong>
				</label>
				</div> 
			</div>	  
			<?php
			}
		?>
 		<br/>
		<div class="row">
 			<div class="col-md-12">
				<label>
					<?php
						$listfoliopro_featured= get_post_meta( $post->ID,'listfoliopro_featured', true );
					?>
					<label><input type="radio" name="listfoliopro_featured" id="listfoliopro_featured" value="featured" <?php echo ($listfoliopro_featured=="featured" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Featured (display on top)', 'listfoliopro' )?></strong></label>
					<br/>
					<label><input type="radio" name="listfoliopro_featured" id="listfoliopro_featured" value="Not-featured" <?php echo ($listfoliopro_featured=="Not-featured" ? 'checked': "" )  ; ?> />  <strong><?php esc_html_e( 'Not Featured', 'listfoliopro' )?></strong></label>
				</label>
			</div>
		</div>	
		<?php $nonce = wp_create_nonce('listfoliopro'); ?>
		<input type="hidden" name="listfoliopro_wpnonce" value="<?php echo esc_attr($nonce); ?>">
	</div>
</div>		