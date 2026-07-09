<?php

// Control core classes for avoid errors
if( class_exists( 'CSF' ) ) {

	CSF::createWidget( 'listihub_about_company_widget', array(
		'title'       => esc_html__('Listihub : About Company Widget ', 'listihub-core'),
		'classname'   => 'widget_listihub_about_company_widget',
		'description' => esc_html__('listihub about company widget.', 'listihub-core'),
		'fields'      => array(

			array(
				'id'      => 'title',
				'type'    => 'text',
				'title'   => esc_html__('Title' , 'listihub-core'),
			),

			array(
				'id'           => 'image',
				'type'         => 'media',
				'title'        => esc_html__('Image', 'listihub-core'),
				'library'      => 'image',
				'url'          => false,
				'button_title' => esc_html__('Upload Image', 'listihub-core'),

			),

			array(
				'id'      => 'image_url',
				'type'    => 'text',
				'title'   => esc_html__('Image Url' , 'listihub-core'),
			),

			array(
				'id'            => 'description',
				'type'          => 'wp_editor',
				'default'          => 'It is a long established at fact that is the read will been the distractend there and readable an important content.',
				'media_buttons' => false,
				'height'        => '100px',
				'title'         => esc_html__('Description', 'listihub-core'),
			),

			array(
				'id'           => 'social_icon_list',
				'type'         => 'group',
				'title'        => esc_html__('Social Profiles', 'listihub-core'),
				'button_title' => esc_html__('Add New Profile', 'listihub-core'),
				'fields'       => array(

					array(
						'id'      => 'site_name',
						'type'    => 'text',
						'title'   => esc_html__('Social Site Name' , 'listihub-core'),
					),

					array(
						'id'    => 'icon',
						'type'  => 'icon',
						'title' => esc_html__('Icon', 'listihub-core'),
						'desc'  => esc_html__('Select icon', 'listihub-core'),
					),

					array(
						'id'      => 'profile_url',
						'type'    => 'text',
						'title'   => esc_html__('Social Profile URL' , 'listihub-core'),
					),

				),
				'default'      => array(
					array(
						'site_name' => 'Facebook',
						'icon' => 'fab fa-facebook-f',
						'profile_url' => '#',
					),
				),
			),
		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if( ! function_exists( 'listihub_about_company_widget' ) ) {
		function listihub_about_company_widget( $args, $instance ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			} ?>

			<?php if($instance['image']['url']) :
				$image_src = $instance['image']['url'];
				$image_alt = $instance['image']['alt'];
				$image_title = $instance['image']['title'];
				$image_url = $instance['image_url'];
				?>
                <div class="about-info-img">
					<?php if($image_url) : ?>
                        <a href="<?php echo esc_url($image_url);?>">
                            <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
                        </a>
					<?php else :?>
                        <img src="<?php echo esc_url($image_src);?>" alt="<?php echo esc_attr($image_alt);?>" title="<?php echo esc_attr($image_title);?>">
					<?php endif;?>
                </div>
			<?php endif;?>

			<?php if($instance['description']) : ?>
                <div class="widget-about-description">
					<?php echo nl2br(($instance['description']));?>
                </div>
			<?php endif; ?>

			<?php if ($instance['social_icon_list']) :?>
                <ul class="widget-social-icons footer-social-icon ep-list-inline">
					<?php foreach ($instance['social_icon_list'] as $social){ ?>
                        <li><a href="<?php echo esc_url($social['profile_url']);?>" target="_blank"><i class="<?php echo esc_attr($social['icon']);?>"></i></a></li>
					<?php } ?>
                </ul>
			<?php endif; ?>

			<?php
			echo $args['after_widget'];
		}
	}
}