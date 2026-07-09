<?php
	$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
	if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
	global $post;

	
	add_action( 'manage_listfoliopro_message_posts_custom_column' , 'listfoliopro_custom_listfoliopro_message_column' );
	add_filter( 'manage_edit-listfoliopro_message_columns',  'listfoliopro_set_custom_edit_listfoliopro_message_columns'  );
	function listfoliopro_set_custom_edit_listfoliopro_message_columns($columns) {
		$columns['Message'] = esc_html__('Message','listfoliopro');
		$columns['email'] = esc_html__('Email','listfoliopro');
		$columns['phone'] = esc_html__('Phone','listfoliopro');
		return $columns;
	}
	function listfoliopro_custom_listfoliopro_message_column( $column ) {
		global $post;
		switch ( $column ) {
			case 'Message' :		
				echo esc_html($post->post_content);
			break; 
			case 'phone' :			
				echo get_post_meta($post->ID,'from_phone',true);  
			break;
			case 'email' :
				echo get_post_meta($post->ID,'from_email',true);  
			break;
			
			
		}
	}	
	
?>