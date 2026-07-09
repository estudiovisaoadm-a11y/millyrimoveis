<?php
$enable_header_cta_btn = listihub_option('enable_header_cta_btn', true);
$header_cta_text = listihub_option('header_cta_text');
$header_cta_url = listihub_option('header_cta_url');
$enable_header_login = listihub_option('enable_header_login', true);
$header_login_url = listihub_option('login_url');

// Resolve correct URLs for CTA and login
$add_listing_page = get_page_by_path('adicionar-listagem');
if (!$add_listing_page) {
	$add_listing_page = get_page_by_path('add-listing');
}
if ($add_listing_page) {
	$header_cta_url = get_permalink($add_listing_page->ID);
}

$login_page_id = get_option('listfoliopro_login_page');
$my_account_page_id = get_option('listfoliopro_profile_page');
$login_url_resolved = $login_page_id ? get_permalink($login_page_id) : home_url('/');
$my_account_url = $my_account_page_id ? get_permalink($my_account_page_id) : home_url('/');
$header_login_url = is_user_logged_in() ? $my_account_url : $login_url_resolved;
?>

<div class="header-buttons-area">
	<ul class="header-buttons-wrapper ep-list-style">
        <?php if($enable_header_cta_btn == true) : ?>
        <li class="header-button">
            <a class="ep-button" href="<?php echo esc_attr($header_cta_url);?>"><?php echo esc_html($header_cta_text);?></a>
        </li>
		<?php endif; ?>

		<?php if($enable_header_login == true) : ?>
            <li class="header-login">
                <a href="<?php echo esc_attr($header_login_url);?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M3 20C5.33579 17.5226 8.50702 16 12 16C15.493 16 18.6642 17.5226 21 20M16.5 7.5C16.5 9.98528 14.4853 12 12 12C9.51472 12 7.5 9.98528 7.5 7.5C7.5 5.01472 9.51472 3 12 3C14.4853 3 16.5 5.01472 16.5 7.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
		<?php endif; ?>

		<li class="mobile-menu-trigger"><span></span><span></span><span></span></li>
	</ul>
</div>
