<?php
namespace Elementor;
use WP_Query;
class ListfolioPro_Recent_Posts_Widget extends Widget_Base {

	public function get_name() {

		return 'listfoliopro_recent_post';
	}

	public function get_title() {
		return esc_html__( 'Recent Posts', 'listfoliopro' );
	}

	public function get_icon() {

		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'listfoliopro_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'recent_post_settings',
			[
				'label' => __( 'Post Settings', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Number Of Post To Show', 'listfoliopro' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => __( 'Categories', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoloipro_post_categories(),
			]
		);

		$this->add_control(
			'exclude_post',
			[
				'label'       => __( 'Exclude Posts', 'listfoliopro' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => listfoliopro_get_post_title_as_list(),
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label'       => __( 'Button Text', 'listfoliopro' ),
				'label_block'       => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Browse All', 'listfoliopro-core' ),
			]
		);

		$this->add_control(
			'btn_url',
			[
				'label'         => __( 'Button URL', 'listfoliopro' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://your-link.com', 'listfoliopro' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'recent_post_layout_settings',
			[
				'label' => __( 'Post Column & Layout', 'listfoliopro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_word',
			[
				'label'   => __( 'Title Word Count', 'listfoliopro' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => '',
				'step'    => 1,
				'default' => 10,
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => __( 'Show Date', 'listfoliopro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		?>

		<div class="bootstrap-wrapper listfoliopro-recent-post">
            <div class="container">
                <div class="row">
                    <?php
                    if ( ! empty( $settings['category'] ) ) {
                        $post_query = new WP_Query( array(
                            'post_type'           => 'post',
                            'posts_per_page'      => $settings['post_count'],
                            'ignore_sticky_posts' => 1,
                            'post__not_in'        => $settings['exclude_post'],
                            'tax_query'           => array(
                                array(
                                    'taxonomy' => 'category',
                                    'terms'    => $settings['category'],
                                    'field'    => 'slug',
                                )
                            )
                        ) );
                    } else {

                        $post_query = new WP_Query(
                            array(
                                'posts_per_page'      => $settings['post_count'],
                                'post_type'           => 'post',
                                'ignore_sticky_posts' => 1,
                                'post__not_in'        => $settings['exclude_post'],
                            )
                        );
                    }

                    if ( $post_query->have_posts() ) {
                        $post_index = 0; ?>
                        <div class="col-xl-6 col-lg-6">
                            <div class="recent-post-wrapper big-post">
                                <?php
                                while ( $post_query->have_posts() ) {
                                    $post_query->the_post(); ?>

                                    <div class="single-post-item">
                                        <a href="<?php echo get_the_permalink();?>" class="recent-post-thumbnail-wrapper">
                                            <div class="recent-post-thumbnail" style="background-image: url(<?php the_post_thumbnail_url( 'large' ); ?>)"></div>
                                        </a>

                                        <a href="<?php echo get_the_permalink();?>">
                                            <h4 class="recent-post-title"><?php echo wp_trim_words(get_the_title(), $settings['title_word'], ' ...');?></h4>
                                        </a>

                                        <?php if ($settings['show_date'] == 'yes') :?>
                                        <div class="date-and-time">
                                            <?php listfoliopro_posted_on();?>
                                            <span> | <?php the_time('g:i a');?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>


                                    <?php $post_index ++;

                                    if ( $post_index === 1 ) {
                                        break;
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="recent-post-wrapper small-post">
                                <?php
                                while ( $post_query->have_posts() ) {
                                    $post_query->the_post(); ?>

                                    <div class="single-post-item">
                                        <a href="<?php echo get_the_permalink();?>" class="recent-post-thumbnail-wrapper">
                                            <div class="recent-post-thumbnail" style="background-image: url(<?php the_post_thumbnail_url( 'large' ); ?>)"></div>
                                        </a>

                                        <div class="recent-post-cotent">
                                            <a href="<?php echo get_the_permalink();?>">
                                                <h4 class="recent-post-title"><?php echo wp_trim_words(get_the_title(), $settings['title_word'], ' ...');?></h4>
                                            </a>

	                                        <?php if ($settings['show_date'] == 'yes') :?>
                                                <div class="date-and-time">
			                                        <?php listfoliopro_posted_on();?>
                                                    <span> | <?php the_time('g:i a');?></span>
                                                </div>
	                                        <?php endif; ?>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>

                            <div class="recent-post-button">
                                <a href="<?php echo esc_url($settings['btn_url']['url']);?>" class="listfoliopro-button"><?php echo esc_html($settings['btn_text']);?>
                                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 17L17 7M17 7H7M17 7V17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <?php
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new ListfolioPro_Recent_Posts_Widget );