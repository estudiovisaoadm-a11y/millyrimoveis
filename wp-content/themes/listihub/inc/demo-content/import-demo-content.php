<?php
/**
 * Import demo data.
 */

// Disable regenerating images while importing media
add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_filter( 'ocdi/disable_pt_branding', '__return_true' );

function listihub_ocdi_confirmation_dialog_options ( $options ) {
	return array_merge( $options, array(
		'width'       => 400,
		'dialogClass' => 'wp-dialog',
		'resizable'   => false,
		'height'      => 'auto',
		'modal'       => true,
	) );
}
add_filter( 'ocdi/confirmation_dialog_options', 'listihub_ocdi_confirmation_dialog_options', 10, 1 );


function listihub_import_demo_files() {
	return array(
		array(
			'import_file_name' => esc_html__('Home One', 'listihub'),

			'local_import_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/content.xml',

			'local_import_widget_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/widgets.wie',

			'local_import_customizer_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/customizer.dat',

			'local_import_json' => array(
				array(
					'file_path'   => trailingslashit(get_template_directory()) . '/inc/demo-content/theme-option.json',
					'option_name' => 'listihub_theme_options',
				),
			),

			'import_preview_image_url' => trailingslashit(get_template_directory_uri()) . '/inc/demo-content/images/demo-1.jpg',

			'import_notice' => esc_html__('Please click on the Import button only once and wait, it can take a couple of minutes.', 'listihub'),

			'preview_url'                => 'https://listihub.e-plugins.com/',
		),

		array(
			'import_file_name' => esc_html__('Home Two', 'listihub'),

			'local_import_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/content.xml',

			'local_import_widget_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/widgets.wie',

			'local_import_customizer_file' => trailingslashit(get_template_directory()) . '/inc/demo-content/customizer.dat',

			'local_import_json' => array(
				array(
					'file_path'   => trailingslashit(get_template_directory()) . '/inc/demo-content/theme-option.json',
					'option_name' => 'listihub_theme_options',
				),
			),

			'import_preview_image_url' => trailingslashit(get_template_directory_uri()) . '/inc/demo-content/images/demo-2.jpg',

			'import_notice' => esc_html__('Please click on the Import button only once and wait, it can take a couple of minutes.', 'listihub'),

			'preview_url'                => 'https://listihub.e-plugins.com/home-two/',
		),
	);
}

add_filter('ocdi/import_files', 'listihub_import_demo_files');

/**
 * Adding local_import_json and import_json param supports.
 */
if (!function_exists('listihub_after_content_import_execution')) {
	function listihub_after_content_import_execution($selected_import_files, $import_files, $selected_index) {

		$downloader = new OCDI\Downloader();

		if (!empty($import_files[$selected_index]['import_json'])) {

			foreach ( $import_files[$selected_index]['import_json'] as $index => $import ) {
				$file_path = $downloader->download_file($import['file_url'], 'demo-import-file-' . $index . '-' . date('Y-m-d__H-i-s') . '.json');
				$file_raw  = OCDI\Helpers::data_from_file($file_path);
				update_option($import['option_name'], json_decode($file_raw, true));
			}

		} else if (!empty($import_files[$selected_index]['local_import_json'])) {

			foreach ( $import_files[$selected_index]['local_import_json'] as $index => $import ) {
				$file_path = $import['file_path'];
				$file_raw  = OCDI\Helpers::data_from_file($file_path);
				update_option($import['option_name'], json_decode($file_raw, true));
			}
		}

	}

	add_action('ocdi/after_content_import_execution', 'listihub_after_content_import_execution', 3, 99);
}



/* After Import */

if (!function_exists('listihub_after_import')) {
	function listihub_after_import($selected_import) {

		//Set Menu
		$main_menu = get_term_by('name', esc_html__('Listihub Main Menu', 'listihub'), 'nav_menu');

		set_theme_mod('nav_menu_locations', array(
				'main-menu' => $main_menu->term_id,
			)
		);

		//Set Front page
		if (esc_html__('Home One', 'listihub') === $selected_import['import_file_name']) {
			$home_page = get_page_by_title(esc_html__('Home One', 'listihub'));
		}else{
			$home_page = get_page_by_title(esc_html__('Home Two', 'listihub'));
		}

		//Set Front page
		if (isset($home_page->ID)) {
			update_option('page_on_front', $home_page->ID);
			update_option('show_on_front', 'page');
		}

		// Set Post Page
		$blog_page   = get_page_by_title( esc_html__('Blog','listihub' ));
		if (isset($blog_page->ID)) {
			update_option('page_for_posts', $blog_page->ID);
		}
	}
	add_action( 'ocdi/after_import', 'listihub_after_import' );
}