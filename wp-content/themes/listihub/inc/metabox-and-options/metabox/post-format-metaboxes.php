<?php
// Video Post Meta
$listihub_video_post_meta = 'video_post_format_meta';

CSF::createMetabox( $listihub_video_post_meta, array(
	'title'        => esc_html__('Video Post Format Options', 'listihub' ),
	'post_type'    => 'post',
	'post_formats' => array('video'),
) );

CSF::createSection( $listihub_video_post_meta, array(
	'fields' => array(

		array(
			'id'    => 'post_video_url',
			'type'  => 'text',
			'title' => esc_html__('Video URL', 'listihub' ),
			'desc'    => esc_html__( 'Paste video URL here', 'listihub' ),
		),

	)
));

// Audio Post Meta
$listihub_audio_post_meta = 'audio_post_format_meta';

CSF::createMetabox( $listihub_audio_post_meta, array(
	'title'        => esc_html__('Audio Post Format Options', 'listihub' ),
	'post_type'    => 'post',
	'post_formats' => array('audio'),
) );

CSF::createSection( $listihub_audio_post_meta, array(
	'fields' => array(

		array(
			'id'    => 'audio_embed_code',
			'type'  => 'code_editor',
			'settings' => array(
				'theme'  => 'monokai',
				'mode'   => 'htmlmixed',
			),
			'title' => esc_html__('Audio Embed Code', 'listihub' ),
			'desc'    => esc_html__( 'Paste sound cloud audio embed code here', 'listihub' ),
		),

	)
));


// Gallery Post Meta
$listihub_gallery_post_meta = 'gallery_post_format_meta';

CSF::createMetabox( $listihub_gallery_post_meta, array(
	'title'        => esc_html__('Gallery Post Format Options', 'listihub' ),
	'post_type'    => 'post',
	'post_formats' => array('gallery'),
) );

CSF::createSection( $listihub_gallery_post_meta, array(
	'fields' => array(

		array(
			'id'          => 'post_gallery_images',
			'type'        => 'gallery',
			'title' => esc_html__('Gallery Images', 'listihub' ),
			'add_title'   => esc_html__('Upload Gallery Images', 'listihub'),
			'edit_title'  => esc_html__('Edit Gallery Images', 'listihub'),
			'clear_title' => esc_html__('Remove Gallery Images', 'listihub'),
			'desc'    => esc_html__( 'Upload gallery images from here', 'listihub' ),
		),

	)
));