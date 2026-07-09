<?php
class hijobs_contact_form_widget extends WP_Widget{
    public function __construct(){

        parent::__construct('hijobs_contact_form_widget', esc_html__('hijobs : Contact Form Widget', 'hijobs-core'), array(
            'description'   =>  esc_html__('hijobs contact form widget', 'hijobs-core'),
        ));
    }


    public function widget($args, $instance){
        echo wp_kses_post( $args['before_widget'] );

        if(!empty($instance['title'])){
            echo  wp_kses_post( $args['before_title'] ).apply_filters('widget_title', esc_html($instance['title'])).wp_kses_post( $args['after_title'] );
        };?>

        <?php
        if(!empty($instance['contact_form'])){
	        ?>
                <div class="contact-widget-form">
			        <?php echo do_shortcode( '[contact-form-7 id="' . $instance['contact_form'] . '" ]' );?>
                </div>
            <?php
        }

        echo wp_kses_post( $args['after_widget'] );
    }



    public function form($instance){
        $title = ! empty($instance['title']) ? $instance['title'] : '';
        $contact_form = ! empty($instance['contact_form']) ? $instance['contact_form'] : '';
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title'));?>"> <?php echo esc_html__( 'Title', 'hijobs-core' );?></label>

            <input id="<?php echo esc_attr($this->get_field_id('title'));?>" class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('title'));?>" value="<?php echo esc_attr($title); ?>">
        </p>


        <p>
            <label for="<?php echo $this->get_field_id( 'contact_form' ); ?>"><?php echo esc_html__( 'Select Form', 'hijobs-core' );?>
                <select class='widefat' id="<?php echo $this->get_field_id( 'contact_form' ); ?>"
                        name="<?php echo $this->get_field_name( 'contact_form' ); ?>" type="text">

                    <option value=''><?php echo esc_html__( 'Select Form', 'hijobs-core' ); ?></option>

                        <?php
                        if ( class_exists( 'WPCF7_ContactForm' ) ) {
                            $forms = WPCF7_ContactForm::find( array(
                                'orderby' => 'title',
                                'order'   => 'ASC',
                            ) );
                            
                            foreach ( $forms as $item ) {
                                $key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
                                $result[ $key ] = $item->title(); ?>
                                <option value='<?php echo $key;?>' <?php echo ( $key == $contact_form ) ? 'selected' : ''; ?>><?php echo $item->title(); ?></option>
                                <?php
                            }
                        }
                        ?>
                </select>
            </label>
        </p>

    <?php }

    public function update( $new_instance, $old_instance ){
        $instance                  = $old_instance;

        $instance['title']         = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

        $instance['contact_form']         = ( ! empty( $new_instance['contact_form'] ) ) ? sanitize_text_field( $new_instance['contact_form'] ) : '';
        return $instance;
    }
}

function hijobs_init_contact_form_widget(){
    register_widget('hijobs_contact_form_widget');
}

add_action('widgets_init', 'hijobs_init_contact_form_widget');