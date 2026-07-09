<?php
	$main_class = new listfoliopro_eplugins;
	wp_enqueue_style('admin-listfoliopro', listfoliopro_ep_URLPATH . 'admin/files/css/admin.css');
	wp_enqueue_style('dataTables', listfoliopro_ep_URLPATH . 'admin/files/css/vue-admin.css');
?>	
<div class="bootstrap-wrapper">
	<div class=" container-fluid">	
		<div class="listfoliopro-admin-header row">
			<div class="listfoliopro-admin-header-logo">
				<img src="<?php echo esc_url(listfoliopro_ep_URLPATH."assets/images/admin-logo.png");?>" alt="listfoliopro Logo">
				<span class="listfoliopro-admin-header-version"><?php echo esc_html($main_class->version); ?></span>
			</div>
			<div class="listfoliopro-admin-header-menu">
				<div class="menu-item">
					<div class="menu-icon">
						<i class="fa-solid fa-question"></i>
						<div class="dropdown">
							<h3><?php  esc_html_e('Get Help','listfoliopro'); ?></h3>
							<div class="list-item">  
							
							 <a href="<?php echo esc_url('https://www.youtube.com/playlist?list=PLLRcfoNnzUb7NzUw-MWlt2NJblMhpxndr');?>" target="_blank">
									<span class="listfoliopro-icon">
										<i class="fa-brands fa-youtube"></i>
									</span>
									<?php  esc_html_e('Video Tutorial','listfoliopro'); ?>
								</a>
								
								<a href="<?php echo esc_url('https://e-plugins.com/support/');?>" target="_blank">
									<span class="listfoliopro-icon">
										<i class="fa-regular fa-comments"></i>
									</span>
									<?php  esc_html_e('Get Support','listfoliopro'); ?>
								</a>
								<a href="<?php echo esc_url('https://help.eplug-ins.com/listfoliopro');?>" target="_blank">
									<div class="listfoliopro-icon">
										<i class="fa-solid fa-file-lines"></i>
									</div>
									<?php  esc_html_e('Documentation','listfoliopro'); ?>
								</a>
								
								<a href="#" target="_blank">
									<div class="listfoliopro-icon">
										<i class="fa-regular fa-comments"></i>
									</div>
								<?php  esc_html_e('FAQ','listfoliopro'); ?>
								</a>
								<a href="<?php echo esc_url('https://listfoliopro.e-plugins.com/request-a-feature/');?>" target="_blank">
									<div class="listfoliopro-icon">
										<i class="fa-regular fa-lightbulb"></i>
									</div>
								<?php  esc_html_e('Request a Feature  ','listfoliopro'); ?>                      </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>