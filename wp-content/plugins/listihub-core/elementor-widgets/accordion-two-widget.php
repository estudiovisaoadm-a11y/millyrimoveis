<?php
namespace Elementor;

class Hijobs_Accordion_Two_Widget extends Widget_Base{

	public function get_name(){

		return "hijobs_accordion_two";
	}
	public function get_title(){
		return esc_html__("Accordion Two","hijobs-core");
	}
	public function get_icon() {

		return "eicon-accordion";
	}
	public function get_categories() {
		return [ 'hijobs_elements' ];
	}

	protected function _register_controls(){
		$this->start_controls_section(
			'accordion_content_options',
			[
				'label' => esc_html__( 'Accordion', 'hijobs-core' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'accordion_title',
			[
				'label'       => esc_html__( 'Accordion Title', 'hijobs-core' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default' => 'Accordion Title Here',
				'placeholder' => esc_html__( 'Type Accordion Title Here', 'hijobs-core' ),
			]
		);

		$repeater->add_control(
			'accordion_content', [
				'label' => esc_html__( 'Accordion Content', 'hijobs-core' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Accordion content here',
				'label_block' => true,
			]
		);

		$this->add_control(
			'accordion_list',
			[
				'label' => __( 'Accordion Lists', 'hijobs-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => 'Accordion Title Here',
					],
				],
				'title_field' => '{{{ accordion_title }}}',
			]
		);

		$this->add_control(
			'open_by_default',
			[
				'label'       => esc_html__('Open By Default', 'hijobs-core'),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 1000,
				'step'        => 1,
				'default'     => 1,
				'separator'     => 'before',
				'description' => esc_html__('Which accordion you want to open by default.', 'hijobs-core'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'accordion_style',
			[
				'label' => esc_html__( 'Accordion', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => __( 'Title Typography', 'hijobs-core' ),
				'selector' => '{{WRAPPER}} .ep-accordion-wrapper .accordion-button',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'       => esc_html__('Title Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-accordion-wrapper .accordion-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'       => esc_html__('Title Active Color', 'hijobs-core'),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [
					'{{WRAPPER}} .ep-accordion-wrapper.ep-accordion-two-wrapper .accordion-button:hover,
					{{WRAPPER}} .ep-accordion-wrapper.ep-accordion-two-wrapper .accordion-button:not(.collapsed)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	//Render In HTML
	protected function render() {
		$settings = $this->get_settings_for_display();
		$id = rand(100, 100000);
		?>
		<div class="ep-accordion-wrapper ep-accordion-two-wrapper ep-accordion-wrapper-<?php echo esc_attr($id);?>">
			<div class="accordion" id="ep-accordion-<?php echo esc_attr($id);?>">

				<?php
				if($settings['accordion_list']){
					$i = 0;
					foreach($settings['accordion_list'] as $accordionItem){
						$i++;

						if($i == $settings['open_by_default']){
							$show = 'show';
							$open = 'true';
							$collapsed = '';
						}else{
							$show = '';
							$open = 'false';
							$collapsed = 'collapsed';
						}

						?>
						<div class="accordion-item">
							<h2 class="accordion-header">
								<button class="accordion-button <?php echo esc_attr($collapsed);?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo esc_attr($i.$id);?>" aria-expanded="<?php echo esc_attr($open);?>" aria-controls="collapse-<?php echo esc_attr($i.$id);?>">
									<?php
									echo esc_html($accordionItem['accordion_title']);
									?>
									<span class="btn-arrow-bg"></span>
								</button>
							</h2>

							<div id="collapse-<?php echo esc_attr($i.$id);?>" class="accordion-collapse collapse <?php echo esc_attr($show) ?>" data-bs-parent="#ep-accordion-<?php echo esc_attr($id);?>">
								<div class="accordion-body">
									<?php echo wp_kses_post( $accordionItem['accordion_content']) ?>
								</div>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	}
}
Plugin::instance()->widgets_manager->register( new Hijobs_Accordion_Two_Widget );