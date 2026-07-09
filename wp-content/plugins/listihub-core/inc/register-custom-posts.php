<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function hijobs_register_custom_posts() {

	// service
	/*if(function_exists('hijobs_option')){
		$service_slug = hijobs_option('service_url_slug');
	}else{
		$service_slug = 'service';
	}

	register_post_type( 'hijobs_service',
		array(
			'labels'       => array(
				'name'                  => esc_html__( 'Services', 'hijobs-core' ),
				'singular_name'         => esc_html__( 'Service', 'hijobs-core' ),
				'add_new_item'          => esc_html__( 'Add New Service', 'hijobs-core' ),
				'all_items'             => esc_html__( 'All Services', 'hijobs-core' ),
				'add_new'               => esc_html__( 'Add New', 'hijobs-core' ),
				'edit_item'             => esc_html__( 'Edit Service', 'hijobs-core' ),
				'featured_image'        => esc_html__( 'Service Image', 'hijobs-core' ),
				'set_featured_image'    => esc_html__( 'Set Service Image', 'hijobs-core' ),
				'remove_featured_image' => esc_html__( 'Remove Service Image', 'hijobs-core' ),
				'use_featured_image'    => esc_html__( 'Use as services image', 'hijobs-core' ),
			),
			'rewrite'      => array(
				'slug'       => $service_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-schedule',
			'show_in_rest'    => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'hijobs_service_cat',
		'hijobs_service',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__( 'Service Categories', 'hijobs-core' ),
			'query_var'         => true,
			'show_admin_column' => true,
			'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$service_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'hijobs_service_tag',
		'hijobs_service',
		array(
			'hierarchical'      => false,
			'label'             => esc_html__( 'Service Tags', 'hijobs-core' ),
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$service_slug.'-tag',
				'with_front' => true,
			),
		)
	);*/

	//Projects
	/*if(function_exists('hijobs_option')){
		$project_slug = hijobs_option('project_url_slug');
	}else{
		$project_slug = 'project';
	}

	register_post_type('hijobs_project',
		array(
			'labels'       => array(
				'name'                  => esc_html__('Projects', 'hijobs-core'),
				'singular_name'         => esc_html__('Project', 'hijobs-core'),
				'add_new_item'          => esc_html__('Add New Project', 'hijobs-core'),
				'all_items'             => esc_html__('All Project', 'hijobs-core'),
				'add_new'               => esc_html__('Add New', 'hijobs-core'),
				'edit_item'             => esc_html__('Edit Project', 'hijobs-core'),
				'featured_image'        => esc_html__('Project Image', 'hijobs-core'),
				'set_featured_image'    => esc_html__('Set project image', 'hijobs-core'),
				'remove_featured_image' => esc_html__('Remove project image', 'hijobs-core'),
				'use_featured_image'    => esc_html__('Use as project image', 'hijobs-core'),
			),
			'rewrite'      => array(
				'slug'       => $project_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-schedule',
			'show_in_rest'    => true,
			'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
		)
	);

	register_taxonomy(
		'hijobs_project_cat',
		'hijobs_project',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__('Project Categories', 'hijobs-core'),
			'query_var'         => true,
			'show_admin_column' => true,
			'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$project_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'hijobs_project_tag',
		'hijobs_project',
		array(
			'hierarchical'          => false,
			'label'                 => esc_html__( 'Project Tags', 'hijobs-core' ),
			'show_ui'               => true,
			'show_admin_column'          => true,
			'query_var'             => true,
			'show_in_rest'    => true,
			'rewrite'               => array(
				'slug'       => ''.$project_slug.'-tag',
				'with_front' => true,
			),
		)
	);*/


	//Team Members
	/*if(function_exists('hijobs_option')){
		$team_slug = hijobs_option('team_url_slug');
	}else{
		$team_slug = 'team';
	}

	register_post_type('hijobs_team',
		array(
			'labels'       => array(
				'name'                  => esc_html__('Team Members', 'hijobs-core'),
				'singular_name'         => esc_html__('Team Member', 'hijobs-core'),
				'add_new_item'          => esc_html__('Add New Member', 'hijobs-core'),
				'all_items'             => esc_html__('All Members', 'hijobs-core'),
				'add_new'               => esc_html__('Add New', 'hijobs-core'),
				'edit_item'             => esc_html__('Edit Member', 'hijobs-core'),
				'featured_image'        => esc_html__('Member Image', 'hijobs-core'),
				'set_featured_image'    => esc_html__('Set member image', 'hijobs-core'),
				'remove_featured_image' => esc_html__('Remove member image', 'hijobs-core'),
				'use_featured_image'    => esc_html__('Use as member image', 'hijobs-core'),
			),
			'rewrite'      => array(
				'slug'       => $team_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-businessman',
			'show_in_rest'    => true,
			'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
		)
	);

	register_taxonomy(
		'hijobs_team_cat',
		'hijobs_team',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__('Team Categories', 'hijobs-core'),
			'query_var'         => true,
			'show_admin_column' => true,
			'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$team_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'hijobs_team_tag',
		'hijobs_team',
		array(
			'hierarchical'          => false,
			'label'                 => esc_html__( 'Team Tags', 'hijobs-core' ),
			'show_ui'               => true,
			'show_admin_column'          => true,
			'query_var'             => true,
			'show_in_rest'    => true,
			'rewrite'               => array(
				'slug'       => ''.$team_slug.'-tag',
				'with_front' => true,
			),
		)
	);*/

	//Jobs
	/*if(function_exists('hijobs_option')){
		$job_slug = hijobs_option('job_url_slug');
	}else{
		$job_slug = 'job';
	}

	register_post_type('hijobs_job',
		array(
			'labels'       => array(
				'name'                  => esc_html__('Jobs', 'hijobs-core'),
				'singular_name'         => esc_html__('Job', 'hijobs-core'),
				'add_new_item'          => esc_html__('Add New Job', 'hijobs-core'),
				'all_items'             => esc_html__('All Jobs', 'hijobs-core'),
				'add_new'               => esc_html__('Add New', 'hijobs-core'),
				'edit_item'             => esc_html__('Edit Job', 'hijobs-core'),
				'featured_image'        => esc_html__('Job Image', 'hijobs-core'),
				'set_featured_image'    => esc_html__('Set Job Image', 'hijobs-core'),
				'remove_featured_image' => esc_html__('Remove Job Image', 'hijobs-core'),
				'use_featured_image'    => esc_html__('Use as job image', 'hijobs-core'),
			),
			'rewrite'      => array(
				'slug'       => $job_slug,
				'with_front' => true,
			),
			'hierarchical' => true,
			'public'       => true,
			'menu_icon'    => 'dashicons-schedule',
			'show_in_rest'    => true,
			'supports'     => array('title', 'editor', 'thumbnail', 'page-attributes'),
		)
	);

	register_taxonomy(
		'hijobs_job_cat',
		'hijobs_job',
		array(
			'hierarchical'      => true,
			'label'             => esc_html__('Job Categories', 'hijobs-core'),
			'query_var'         => true,
			'show_admin_column' => true,
			'show_in_rest'    => true,
			'rewrite'           => array(
				'slug'       => ''.$job_slug.'-category',
				'with_front' => true,
			)
		)
	);

	register_taxonomy(
		'hijobs_job_tag',
		'hijobs_job',
		array(
			'hierarchical'          => false,
			'label'                 => esc_html__( 'Job Tags', 'hijobs-core' ),
			'show_ui'               => true,
			'show_admin_column'          => true,
			'query_var'             => true,
			'show_in_rest'    => true,
			'rewrite'               => array(
				'slug'       => ''.$job_slug.'-tag',
				'with_front' => true,
			),
		)
	);*/
}

add_action( 'init', 'hijobs_register_custom_posts' );