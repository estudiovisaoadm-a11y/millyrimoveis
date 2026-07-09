<div class="footer-bottom-area">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6">
				<div class="site-info-left">
					<?php
					$footer_info_left_text = listihub_option('footer_info_left_text');
					echo wp_kses($footer_info_left_text, listihub_allow_html());
					?>
				</div>
			</div>

			<div class="col-lg-6 col-md-6">
				<div class="site-copyright-text">
					<?php
					$copyright_text = listihub_option('copyright_text');

					echo wp_kses($copyright_text, listihub_allow_html());
					?>
				</div>
			</div>
		</div>
	</div>
</div>