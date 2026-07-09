<?php

// Control core classes for avoid errors
if ( class_exists( 'CSF' ) ) {

	CSF::createWidget( 'hijobs_contact_info', array(
		'title'       => esc_html__( 'hijobs : Contact Info Widget ', 'hijobs-core' ),
		'classname'   => 'hijobs_contact_info_widget',
		'description' => esc_html__( 'hijobs contact info widget.', 'hijobs-core' ),
		'fields'      => array(

			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__( 'Title', 'hijobs-core' ),
			),

			array(
				'id'      => 'short_desc',
				'type'    => 'textarea',
				'title'   => esc_html__( 'Short Description', 'hijobs-core' ),
				'default' => esc_html( 'Visit our office or connect us via Phone and Email.'),
			),

			array(
				'id'           => 'contact_info_text',
				'type'         => 'group',
				'title'        => esc_html__( 'Info Text', 'hijobs-core' ),
				'subtitle'     => esc_html__( 'Add / edit info text from here.', 'hijobs-core' ),
				'desc'         => esc_html__( 'Click "Add Info" button to add new Information.', 'hijobs-core' ),
				'button_title' => esc_html__( 'Add Info', 'hijobs-core' ),
				'fields'       => array(

					array(
						'id'            => 'contact_info',
						'type'          => 'wp_editor',
						'media_buttons' => false,
						'height'        => '80px',
						'title'         => esc_html__( 'Info Text', 'hijobs-core' ),
						'desc'          => esc_html__( 'Type info text here.', 'hijobs-core' ),
					),

					array(
						'id'    => 'contact_info_icon',
						'type'  => 'icon',
						'title' => esc_html__( 'Icon', 'hijobs-core' ),
						'desc'  => esc_html__( 'Select icon', 'hijobs-core' ),
					),


				),
				'default'      => array(
					array(
						'contact_info' => 'Obere Haltenstrasse, Lugaggia. Switzerland - 6953',
						'contact_info_icon' => 'fas fa-map-marker-alt',
					),
					array(
						'contact_info' => '<a href="tel:+410123456789">+410 123 456 789</a>',
						'contact_info_icon' => 'fas fa-mobile-alt',
					),

					array(
						'contact_info' => '<a href="mailto:hijobs@e-plugins.com"> hijobs@e-plugins.com</a>',
						'contact_info_icon' => 'fas fa-paper-plane',
					),
				),
			),
		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if ( ! function_exists( 'hijobs_contact_info' ) ) {
		function hijobs_contact_info( $args, $instance ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			?>
			<div class="ep-contact-info-wrapper">
				<div class="ep-short-desc">
                    <?php echo esc_html($instance['short_desc']);?>
				</div>

				<ul class="ep-list-style widget-contact-info-list">
					<?php
					$contact_info_text = $instance['contact_info_text'];
					if(is_array($contact_info_text)){
						foreach ($contact_info_text as $contact){ ?>
                            <li>
                                <i class="<?php echo esc_attr($contact['contact_info_icon']);?>"></i>
								<?php echo wp_kses_post($contact['contact_info']);?>
                            </li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<?php
			echo $args['after_widget'];
		}
	}
}
