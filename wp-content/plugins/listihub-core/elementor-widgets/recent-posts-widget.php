<?php
namespace Elementor;
use WP_Query;
class HiJobs_Recent_Posts_Widget extends Widget_Base {

	public function get_name() {

		return 'hijobs_recent_post';
	}

	public function get_title() {
		return esc_html__( 'Recent Posts', 'hijobs-core' );
	}

	public function get_icon() {

		return 'eicon-post-excerpt';
	}

	public function get_categories() {
		return [ 'hijobs_elements' ];
	}


	protected function register_controls() {

		$this->start_controls_section(
			'recent_post_settings',
			[
				'label' => __( 'Post Settings', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_count',
			[
				'label'   => __( 'Number Of Post To Show', 'hijobs-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => - 1,
				'max'     => '',
				'step'    => 1,
				'default' => 3,
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => __( 'Categories', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => ep_hijobs_post_categories(),
			]
		);

		$this->add_control(
			'exclude_post',
			[
				'label'       => __( 'Exclude Posts', 'hijobs-core' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => hijobs_get_post_title_as_list(),
			]
		);

		$this->add_control(
		    'btn_text',
		    [
		        'label'       => __( 'Button Text', 'hijobs-core' ),
		        'label_block'       => true,
		        'type'        => Controls_Manager::TEXT,
		        'default'     => 'Continue Reading',
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'recent_post_layout_settings',
			[
				'label' => __( 'Post Column & Layout', 'hijobs-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'columns_desktop',
			[
				'label'   => __( 'Columns On Desktop', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-lg-4',
				'options' => [
					'col-lg-12' => __( '1 Column', 'hijobs-core' ),
					'col-lg-6'  => __( '2 Column', 'hijobs-core' ),
					'col-lg-4'  => __( '3 Column', 'hijobs-core' ),
					'col-lg-3'  => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'columns_tab',
			[
				'label'   => __( 'Columns On Tablet', 'hijobs-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'col-sm-6',
				'options' => [
					'col-sm-12' => __( '1 Column', 'hijobs-core' ),
					'col-sm-6'  => __( '2 Column', 'hijobs-core' ),
					'col-sm-4'  => __( '3 Column', 'hijobs-core' ),
					'col-sm-3'  => __( '4 Column', 'hijobs-core' ),
				],
			]
		);

		$this->add_control(
			'title_word',
			[
				'label'   => __( 'Title Word Count', 'hijobs-core' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => '',
				'step'    => 1,
				'default' => 8,
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'   => __( 'Show Date', 'hijobs-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label'   => __( 'Show First Category Name', 'themedraft-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'comment_count',
			[
				'label'   => __( 'Show Comment Count', 'hijobs-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}

	//Render
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ep_column = $settings['columns_desktop'].' '.$settings['columns_tab'];
		?>

		<div class="container ep-recent-post-wrapper">
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

				while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

				<div class="<?php echo esc_attr($ep_column);?>">
					<div class="ep-recent-post-item">
                        <a href="" class="ep-recent-post-thumbnail">
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                        </a>


						<div class="recent-post-content">
							<?php if($settings['show_category'] == 'yes' && function_exists('hijobs_post_first_category')) : ?>
                                <div class="recent-post-category">
									<?php hijobs_post_first_category(); ?>
                                </div>
							<?php endif;?>

                            <a href="<?php echo esc_url( get_the_permalink() );?>" class="ep-rpt-url">
                                <h4 class="ep-recent-post-title ep-transition"><?php echo wp_trim_words(get_the_title(), $settings['title_word'], ' ...');?></h4>
                            </a>

                            <div class="post-meta ep-list-style ep-list-inline">
                                <ul>
									<?php if($settings['show_date'] == 'yes'):?>
                                        <li><?php hijobs_posted_on(); ?></li>
									<?php endif; ?>

									<?php if ( get_comments_number() != 0 && $settings['comment_count'] == 'yes' ) : ?>
                                        <li class="comment-number"><?php hijobs_comment_count(); ?></li>
									<?php endif; ?>
                                </ul>
                            </div>

                            <div class="ep-post-read-more">
                                <a class="ep-text-button" href="<?php echo esc_url( get_the_permalink() );?>">
									<?php echo esc_html($settings['btn_text']);?><i class="fas fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
					</div>
				</div>

				<?php
				endwhile;
				wp_reset_query();
				?>
			</div>
		</div>

		<?php

	}
}

Plugin::instance()->widgets_manager->register_widget_type( new HiJobs_Recent_Posts_Widget );