<?php
namespace Elementor;

class ListfolioPro_Search_Form_Widget extends Widget_Base {

	public function get_name() {
		return 'ListfolioPro_Search_Form';
	}

	public function get_title() {
		return esc_html__( 'Search Form', 'listfoliopro' );
	}

	public function get_icon() {
		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}

	protected function register_controls() {
		$listfoliopro_directory_url=get_option('listfoliopro_ep_url');
			if($listfoliopro_directory_url==""){$listfoliopro_directory_url='listing';}
			
		$this->start_controls_section(
			'search_form_options',
			[
				'label' => esc_html__( 'Search Form', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
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
				'options' => listfoliopro_get_available_search_fields_elementor(),
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
	
                        <div class="banner-one-search-form-wrapper elementor-search" >
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
                  
        
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Search_Form_Widget );