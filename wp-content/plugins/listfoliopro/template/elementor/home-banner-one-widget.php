<?php
namespace Elementor;

class ListfolioPro_Home_Banner_One_Widget extends Widget_Base {

	public function get_name() {
		return 'listfoliopro_home_banner_one';
	}

	public function get_title() {
		return esc_html__( 'Home Banner One', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}

	protected function register_controls() {
		
		$this->start_controls_section(
			'banner_one_options',
			[
				'label' => esc_html__( 'Home Banner', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'listfoliopro' ),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => __( '<h1>Find You <strong>Perfect & Suitable </strong> Real Estate</h1>', 'listfoliopro' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'       => __( 'Image', 'themedraft-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
		$this->add_control(
            'form_action_url',
			[
				'label'       => __( 'Search Form Action URL', 'listfoliopro' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => esc_html__( 'https://your-link.com', 'listfoliopro' ),
			]
        );
		
		$repeater = new Repeater();

		$repeater->add_control(
			'field_label',
			[
				'label'       => __( 'Label', 'listfoliopro' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Field Label', 'listfoliopro' ),
			]
		);

		$repeater->add_control(
			'field_name',
			[
				'label'   => __( 'Select Form Field', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'title'                    => __( 'Title', 'listfoliopro' ),
					'listing-category'             => __( 'Categories', 'listfoliopro' ),
					'listing-tag'                  => __( 'Tags', 'listfoliopro' ),
					'listing-locations'            => __( 'Locations', 'listfoliopro' ),
					'sort_listing'             => __( 'Short Listing', 'listfoliopro' ),
					'near_to_me'               => __( 'Near To Me', 'listfoliopro' ),
					'post_date'                => __( 'Post Date', 'listfoliopro' ),
					'listing_type'                 => __( 'Listing Type', 'listfoliopro' ),
				],
			]
		);

		$repeater->add_control(
			'field_type',
			[
				'label'   => __( 'Form Field Type', 'listfoliopro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text-field',
				'options' => [
					'text-field'           => __( 'Text', 'listfoliopro' ),
					'drop-down'            => __( 'DropDown', 'listfoliopro' ),
					'multi-checkbox'       => __( 'Multi Checkbox', 'listfoliopro' ),
					'multi-checkbox-group' => __( 'Multi Checkbox Group', 'listfoliopro' ),
					'datefield'            => __( 'Date', 'listfoliopro' ),

				],
			]
		);

		$this->add_control(
			'form_fields',
			[
				'label'       => __( 'Form Fields', 'listfoliopro' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'field_name' => '',
						'field_type' => 'text-field',
					],
				],
				'title_field' => '{{{ field_label }}}',
			]
		);

		$this->end_controls_section();
		
	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="home-banner-one-wrapper bootstrap-wrapper" style="background-image: url(<?php echo esc_url($settings['image']['url']);?>)">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="banner-one-title">
                            <?php echo wp_kses_post($settings['title']);?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-9">
                        <div class="banner-one-search-form-wrapper">
                            <?php if($settings['form_fields']){
                                $form_fields = array();
                                $form_field_types = array();
                                foreach ($settings['form_fields'] as $form_field){
                                    $form_fields[] = $form_field['field_name'];
                                    $form_field_types[] = $form_field['field_type'];
                                }
                                $field_list= implode(",",$form_fields);
                                $field_type_list= implode(",",$form_field_types);
                            }
														
							$search_form_action_url='default_archive';
							if($settings['form_action_url']){
								$search_form_action_url=$settings['form_action_url']; 
							}else{
								$search_form_action_url="default_archive";						
							}
							
							?>

                            <?php echo do_shortcode( '[listfoliopro_search action="'.$search_form_action_url.'" field-name="'.$field_list.'" field-type="'.$field_type_list.'" ]' );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery('body').addClass('home-banner-enable');
        </script>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Home_Banner_One_Widget );