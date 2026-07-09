<?php

if ( class_exists( 'CSF' ) ) {
	CSF::createWidget( 'listihub_subscribe_form', array(
		'title'       => esc_html__( 'Listihub : Subscribe Form', 'listihub-core' ),
		'classname'   => 'listihub_subscribe_form_widget',
		'description' => esc_html__( 'listihub Subscribe Form widget.', 'listihub-core' ),
		'fields'      => array(

			array(
				'id'    => 'title',
				'type'  => 'text',
				'title' => esc_html__( 'Title', 'listihub-core' ),
			),

			array(
				'id'            => 'form_top_desc',
				'type'          => 'wp_editor',
				'media_buttons' => false,
				'height'        => '80px',
				'title'         => esc_html__( 'Top Description Text', 'listihub-core' ),
				'desc'          => esc_html__( 'Type description text here.', 'listihub-core' ),
				'default'       => 'Want to stay up to date with news? Please Subscribe.',
			),

			array(
				'id'    => 'footer_subscribe',
				'type'  => 'text',
				'title' => esc_html__( 'Subscribe Form Shortcode', 'listihub-core' ),
			),

			array(
				'id'            => 'form_bottom_desc',
				'type'          => 'wp_editor',
				'media_buttons' => false,
				'height'        => '80px',
				'title'         => esc_html__( 'Bottom Description Text', 'listihub-core' ),
				'desc'          => esc_html__( 'Type description text here.', 'listihub-core' ),
				'default'       => esc_html__( 'By subscribing to our newsletter you agree to our privacy policy.', 'listihub-core' ),
			),
		)
	) );

	//
	// Front-end display of widget
	// Attention: This function named considering above widget base id.
	//
	if ( ! function_exists( 'listihub_subscribe_form' ) ) {
		function listihub_subscribe_form( $args, $instance ) {

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}
			?>
            <div class="ep-subscribe-form-wrapper">

                <div class="form-top-desc">
					<?php echo $instance['form_top_desc']; ?>
                </div>
				<?php if ( $instance['footer_subscribe'] ) : ?>
                    <div class="footer-subscribe-form">
						<?php echo do_shortcode( esc_html( $instance['footer_subscribe'] ) ); ?>
                    </div>
				<?php endif; ?>

                <div class="form-bottom-desc">
		            <?php echo $instance['form_bottom_desc']; ?>
                </div>
            </div>
			<?php
			echo $args['after_widget'];
		}
	}
}