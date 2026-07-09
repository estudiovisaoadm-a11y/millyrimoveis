<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
	<form class="form-horizontal" role="form"  name='listfoliopro_page_settings' id='listfoliopro_page_settings'>
		<?php
			 $price_table=get_option('listfoliopro_price_table'); 
			$registration=get_option('listfoliopro_registration'); 
			$profile_page=get_option('listfoliopro_profile_page'); 
			$login_page=get_option('listfoliopro_login_page');  										
			$thank_you=get_option('listfoliopro_thank_you_page'); 	
			$args = array(
			'child_of'     => 0,
			'sort_order'   => 'ASC',
			'sort_column'  => 'post_title',
			'hierarchical' => 1,															
			'post_type' => 'page'
			);
			
			
		?>
		<div class="form-group row">
			<label  class="col-md-2   control-label"><?php esc_html_e( 'Pricing Table:', 'listfoliopro' );?> </label>
			<div class="col-md-7 ">
				
					<?php
					
						if ( $pages = get_pages( $args ) ){
							echo "<select id='price_table' name='price_table' class='form-control'>";
							foreach ( $pages as $page ) {
								echo "<option value='".esc_attr($page->ID)."'".($price_table==$page->ID ? 'selected':'').">".esc_html($page->post_title)."</option>";
							}
							echo "</select>";
						}
					?>					
				</div>
				<?php
						$reg_page= get_permalink( $price_table); 
					?>
					<a class="btn btn-info mt-2 listfoliopro-button col-md-2" href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'listfoliopro' );?></a>
		</div>
		
		<div class="form-group row">
			<label  class="col-md-2   control-label"><?php esc_html_e( 'User Sign Up:', 'listfoliopro' );?> </label>
			<div class="col-md-7 ">
				
					<?php
					
						if ( $pages = get_pages( $args ) ){
							echo "<select id='signup_page' name='signup_page' class='form-control'>";
							foreach ( $pages as $page ) {
								echo "<option value='".esc_attr($page->ID)."'".($registration==$page->ID ? 'selected':'').">".esc_html($page->post_title)."</option>";
							}
							echo "</select>";
						}
					?>					
				</div>
				<?php
						$reg_page= get_permalink( $registration); 
					?>
					<a class="btn btn-info mt-2 listfoliopro-button col-md-2" href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'listfoliopro' );?></a>
		</div>
		<div class="form-group row">
			<label  class="col-md-2   control-label"><?php esc_html_e( 'Signup Thanks', 'listfoliopro' );?> : </label>
			<div class="col-md-7 ">
				
					<?php
						if ( $pages = get_pages( $args ) ){
							echo "<select id='thank_you_page'  name='thank_you_page'  class='form-control'>";
							foreach ( $pages as $page ) {
								echo "<option value='".esc_attr($page->ID)."'".($thank_you==$page->ID ? 'selected':'').">".esc_html($page->post_title)."</option>";
							}
							echo "</select>";
						}
					?>
			</div>	
			<?php
				$reg_page= get_permalink( $thank_you); 
			?>
			<a class="btn btn-info mt-2 listfoliopro-button col-md-2" href="<?php  echo esc_url($reg_page); ?>"> <?php esc_html_e( 'View', 'listfoliopro' );?></a>
		</div>
		<div class="form-group row">
			<label  class="col-md-2   control-label"><?php esc_html_e( 'Login Page:', 'listfoliopro' );?> </label>
			<div class="col-md-7 ">
				
					<?php
						if ( $pages = get_pages( $args ) ){
							echo "<select id='login_page'  name='login_page'  class='form-control'>";
							foreach ( $pages as $page ) {
								echo "<option value='".esc_attr($page->ID)."'". ($login_page==$page->ID ? 'selected':'').">".esc_html($page->post_title)."</option>";
							}
							echo "</select>";
						}
					?>		
				
			
			</div>	
				<?php
						$reg_page= get_permalink( $login_page); 
					?>
					<a class="btn btn-info mt-2 listfoliopro-button col-md-2" href="<?php  echo esc_url($reg_page); ?>"><?php esc_html_e( 'View', 'listfoliopro' );?> </a>
		</div>
		<div class="form-group row">
			<label  class="col-md-2   control-label"><?php esc_html_e( 'User My Account', 'listfoliopro' );?> : </label>
			<div class="col-md-7 ">				
					<?php
						if ( $pages = get_pages( $args ) ){
							echo "<select id='profile_page'  name='profile_page'  class='form-control'>";
							foreach ( $pages as $page ) {
								echo "<option value='".esc_attr($page->ID)."'".($profile_page==$page->ID ? 'selected':'').">".esc_html($page->post_title)."</option>";
							}
							echo "</select>";
						}
					?>	
			</div>
				<?php
						$reg_page= get_permalink( $profile_page); 
					?>		
				<a class="btn btn-info mt-2 listfoliopro-button col-md-2" href="<?php  echo esc_url($reg_page); ?>"><?php esc_html_e( 'View', 'listfoliopro' );?></a>
		</div>
				
		
		<div class="form-group row">
			<label  class="col-md-2   control-label"> </label>
			<div class="col-md-20 ">
					<hr/>
					<div id="page_all_setting_save"></div>
					<button type="button" onclick="return  listfoliopro_update_page_settings();" class="button button-primary"><?php esc_html_e( 'Update', 'listfoliopro' );?></button>
				
				<div class="checkbox col-md-2 ">
				</div>
			</div>	
		</div>	
	</form>
