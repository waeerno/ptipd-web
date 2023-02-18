<?php
	/*
	Plugin Name: Goodlayers Course Post Type
	Plugin URI: 
	Description: A custom post type plugin to use with "Goodlayers Core" plugin
	Version: 1.0.1
	Author: Goodlayers
	Author URI: http://www.goodlayers.com
	License: 
	*/

	// define necessary variable for the site.
	define('GDLR_CORE_COURSE_URL', plugins_url('', __FILE__));
	define('GDLR_CORE_COURSE_LOCAL', dirname(__FILE__));
	define('GDLR_CORE_COURSE_AJAX_URL', admin_url('admin-ajax.php'));

	include(dirname(__FILE__) . '/search.php');
	include(dirname(__FILE__) . '/course-filter.php');
	include(dirname(__FILE__) . '/include/utility.php');
	include(dirname(__FILE__) . '/include/pb-element-course.php');
	include(dirname(__FILE__) . '/include/pb-element-course-search.php');
	include(dirname(__FILE__) . '/include/pb-element-course-info.php');
	// include(dirname(__FILE__) . '/portfolio-item.php');
	// include(dirname(__FILE__) . '/portfolio-style.php');
	// include(dirname(__FILE__) . '/pb-element-portfolio.php');

	// create post type
	add_action('init', 'gdlr_core_course_init');
	if( !function_exists('gdlr_core_course_init') ){
		function gdlr_core_course_init() {
			
			// custom post type
			$slug = apply_filters('gdlr_core_custom_post_slug', 'course', 'course');
			$supports = apply_filters('gdlr_core_custom_post_support', array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'), 'course');

			$labels = array(
				'name'               => esc_html__('Course', 'goodlayers-core-course'),
				'singular_name'      => esc_html__('Course', 'goodlayers-core-course'),
				'menu_name'          => esc_html__('Course', 'goodlayers-core-course'),
				'name_admin_bar'     => esc_html__('Course', 'goodlayers-core-course'),
				'add_new'            => esc_html__('Add New', 'goodlayers-core-course'),
				'add_new_item'       => esc_html__('Add New Course', 'goodlayers-core-course'),
				'new_item'           => esc_html__('New Course', 'goodlayers-core-course'),
				'edit_item'          => esc_html__('Edit Course', 'goodlayers-core-course'),
				'view_item'          => esc_html__('View Course', 'goodlayers-core-course'),
				'all_items'          => esc_html__('All Course', 'goodlayers-core-course'),
				'search_items'       => esc_html__('Search Course', 'goodlayers-core-course'),
				'parent_item_colon'  => esc_html__('Parent Course:', 'goodlayers-core-course'),
				'not_found'          => esc_html__('No course found.', 'goodlayers-core-course'),
				'not_found_in_trash' => esc_html__('No course found in Trash.', 'goodlayers-core-course')
			);
			$args = array(
				'labels'             => $labels,
				'description'        => esc_html__('Description.', 'goodlayers-core-course'),
				'public'             => true,
				'publicly_queryable' => true,
				'exclude_from_search'=> false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array('slug' => $slug),
				'capabilities'    	 => array(
			        'edit_post'          => 'edit_course',
			        'read_post'          => 'read_course',
			        'delete_post'        => 'delete_course',
			        'edit_posts'         => 'edit_courses',
			        'edit_others_posts'  => 'edit_others_courses',
			        'publish_posts'      => 'publish_courses',
			        'read_private_posts' => 'read_private_courses',
			        'delete_posts'       => 'delete_courses',
			    ),
				'map_meta_cap'		 => false,
				'has_archive'        => false,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => $supports
			);
			register_post_type('course', $args);

			// custom taxonomy
			$slug = apply_filters('gdlr_core_custom_post_slug', 'course_category', 'course_category');
			$args = array(
				'hierarchical'      => true,
				'label'             => esc_html__('Course Category', 'goodlayers-core-course'),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => $slug),
				'capabilities' 		=> array(
					'manage_terms' => 'edit_course',
					'edit_terms' => 'edit_course',
					'delete_terms' => 'delete_course',
					'assign_terms' => 'edit_course',
				)
			);
			register_taxonomy('course_category', array('course'), $args);
			register_taxonomy_for_object_type('course_category', 'course');

			$slug = apply_filters('gdlr_core_custom_post_slug', 'course_tag', 'course_tag');
			$args = array(
				'hierarchical'      => false,
				'label'             => esc_html__('Course Tag', 'goodlayers-core-course'),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array('slug' => $slug),
				'capabilities' 		=> array(
					'manage_terms' => 'edit_course',
					'edit_terms' => 'edit_course',
					'delete_terms' => 'delete_course',
					'assign_terms' => 'edit_course',
				)
			);
			register_taxonomy('course_tag', array('course'), $args);
			register_taxonomy_for_object_type('course_tag', 'course');
			
			// apply single template filter
			add_filter('single_template', 'gdlr_core_course_template');
		}
	} // gdlr_core_personnel_init

	if( !function_exists('gdlr_core_course_template') ){
		function gdlr_core_course_template($template){

			if( isset($_GET['tour-search']) ){
				// $template = GDLR_CORE_COURSE_LOCAL . '/search.php';		
			}else if( get_post_type() == 'course' ){
				$template = dirname(__FILE__) . '/single-course.php';
			}

			return $template;
		}
	}

	if( !function_exists('gdlr_core_course_get_template_url') ){
		function gdlr_core_course_get_template_url( $template = 'search' ){

			$ret = home_url('/');
			if( $template == 'search' ){
				$search_template = apply_filters('gdlr_core_course_search_template', '');

				if( !empty($search_template) ){
					return get_permalink($search_template);
				}
			}

			return $ret;
		}
	}

	// add capabilities on plugin activation
	register_activation_hook(__FILE__, 'gdlr_core_course_init_admin_cap');
	if( !function_exists('gdlr_core_course_init_admin_cap') ){
		function gdlr_core_course_init_admin_cap( $post_type ){

			$post_type_cap = array('edit_%s', 'read_%s', 'delete_%s',  
				'edit_%ss', 'edit_others_%ss', 'publish_%ss', 'read_private_%ss', 'delete_%ss');

			$admin = get_role('administrator');
			foreach( $post_type_cap as $cap ){
				$admin->add_cap(str_replace('%s', 'course', $cap));
			}

		} // gdlr_core_course_init_admin_cap
	}

	// add page builder to course
	if( is_admin() ){ add_filter('gdlr_core_page_builder_post_type', 'gdlr_core_course_add_page_builder'); }
	if( !function_exists('gdlr_core_course_add_page_builder') ){
		function gdlr_core_course_add_page_builder( $post_type ){
			$post_type[] = 'course';
			return $post_type;
		}
	}

	// inital page builder value
	// if( is_admin() ){ add_filter('gdlr_core_course_page_builder_val_init', 'gdlr_core_course_page_builder_val_init'); }
	if( !function_exists('gdlr_core_course_page_builder_val_init') ){
		function gdlr_core_course_page_builder_val_init( $value ){
			$value = '';

			return json_decode($value, true);
		}
	}

	// create an option
	if( is_admin() ){ add_action('after_setup_theme', 'gdlr_core_course_option_init'); }
	if( !function_exists('gdlr_core_course_option_init') ){
		function gdlr_core_course_option_init(){

			if( class_exists('gdlr_core_page_option') ){
				new gdlr_core_page_option(array(
					'post_type' => array('course'),
					'options' => apply_filters('gdlr_core_course_options', array(

						'general' => array(
							'title' => esc_html__('General', 'goodlayers-core-course'),
							'options' => array(
								'course-id' => array(
									'title' => esc_html__('Course ID', 'goodlayers-core-course'),
									'type' => 'text',
									'single' => 'goodlayers-core-course-id'
								),
								'enable-page-title' => array(
									'title' => esc_html__('Enable Page Title', 'goodlayers-core-course'),
									'type' => 'checkbox',
									'default' => 'enable'
								),
								'page-caption' => array(
									'title' => esc_html__('Page Caption', 'goodlayers-core-course'),
									'type' => 'textarea',
									'condition' => array( 'enable-page-title' => 'enable' )
								),
							)
						)
						

					)) // apply_filters
				));
			}


		}
	}

	add_action('plugins_loaded', 'gdlr_core_course_load_textdomain');
	if( !function_exists('gdlr_core_course_load_textdomain') ){
		function gdlr_core_course_load_textdomain() {
		  	load_plugin_textdomain('goodlayers-core-course', false, plugin_basename(dirname(__FILE__)) . '/languages'); 
		}
	}	