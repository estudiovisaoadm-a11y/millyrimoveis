<?php
$footer_cta_title = listihub_option('footer_cta_title');
$footer_cta_btn_text = listihub_option('footer_cta_btn_text');
$footer_cta_btn_url = listihub_option('footer_cta_btn_url');
?>
<div class="footer-cta-area ep-cover-bg">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-8 offset-xxl-3 offset-xl-2">
				<div class="cta-one-content">
					<div class="footer-cta-title">
						<?php echo wp_kses($footer_cta_title, listihub_allow_html()); ?>
					</div>

					<div class="footer-cta-button">
						<a href="<?php echo esc_url($footer_cta_btn_url);?>" class="ep-button"><?php echo esc_html($footer_cta_btn_text);?>
							<svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
							</svg>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>