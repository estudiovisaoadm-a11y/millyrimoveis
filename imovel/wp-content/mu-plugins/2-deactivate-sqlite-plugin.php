<?php
	add_action(
		'admin_footer',
		function() {
			if ( ! function_exists( 'deactivate_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			// The SQLite plugin is automatically activated, but wp-now use it as a a mu-plugin, so we need to deactivate it to prevent notices.
			deactivate_plugins( 'sqlite-database-integration/load.php' );
	}, 100 );