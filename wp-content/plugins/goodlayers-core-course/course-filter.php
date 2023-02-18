<?php
	/*	
	*	---------------------------------------------------------------------
	*	for course post type
	*	---------------------------------------------------------------------
	*/

	add_action('init', 'goodlayers_core_course_add_custom_tax', 99);
	if( !function_exists('goodlayers_core_course_add_custom_tax') ){
		function goodlayers_core_course_add_custom_tax(){
			$custom_taxs = get_option('goodlayers_core_course_custom_taxs', array());

			foreach( $custom_taxs as $custom_tax_slug => $custom_tax ){
				$args = array(
					'hierarchical'      => $custom_tax['hierarchical'],
					'label'             => $custom_tax['label'],
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'capabilities'		=> array(
						'manage_terms' => 'edit_course', 
						'edit_terms'   => 'edit_course', 
						'delete_terms' => 'delete_course', 
						'assign_terms' => 'edit_course'
					)
				);
				register_taxonomy($custom_tax_slug, array('course'), $args);
				register_taxonomy_for_object_type($custom_tax_slug, 'course');
			}
		}
	}

	add_action('admin_menu', 'goodlayers_core_course_init_filter_page', 99);
	if( !function_exists('goodlayers_core_course_init_filter_page') ){
		function goodlayers_core_course_init_filter_page(){
			add_submenu_page(
				'edit.php?post_type=course', 
				esc_html__('Add New Filter', 'goodlayers_core_course'), 
				esc_html__('Add New Filter', 'goodlayers_core_course'),
				'edit_course', 
				'goodlayers_core_course_add_filter_page', 
				'goodlayers_core_course_create_add_filter_page'
			);
		}
	}

	// add the script when opening the filter
	add_action('admin_enqueue_scripts', 'goodlayers_core_course_add_filter_page_script');
	if( !function_exists('goodlayers_core_course_add_filter_page_script') ){
		function goodlayers_core_course_add_filter_page_script($hook){
			
			if( strpos($hook, 'page_goodlayers_core_course_add_filter_page') !== false ){

				wp_enqueue_style('fontAwesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css');
				wp_enqueue_style('google-Montserrat', '//fonts.googleapis.com/css?family=Montserrat:400,700');
				wp_enqueue_style('google-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:400,700');

				wp_enqueue_style('goodlayers-core-course-utility', GDLR_CORE_COURSE_URL . '/css/utility.css');
				wp_enqueue_script('goodlayers-core-course-utility', GDLR_CORE_COURSE_URL . '/js/utility.js', array('jquery'), false, true);
				wp_localize_script('goodlayers-core-course-utility', 'goodlayers_core_course_utility', array(
					'confirm_head' => esc_html__('Just to confirm', 'goodlayers-core-course'),
					'confirm_text' => esc_html__('Are you sure to do this ?', 'goodlayers-core-course'),
					'confirm_sub' => esc_html__('* Please noted that this could not be undone.', 'goodlayers-core-course'),
					'confirm_yes' => esc_html__('Yes', 'goodlayers-core-course'),
					'confirm_no' => esc_html__('No', 'goodlayers-core-course'),
				));

				wp_enqueue_style('goodlayers-core-course-add-filter', GDLR_CORE_COURSE_URL . '/css/add-filter.css');
				wp_enqueue_script('goodlayers-core-course-add-filter', GDLR_CORE_COURSE_URL . '/js/add-filter.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), false, true);
				
				// action
				$custom_taxs = get_option('goodlayers_core_course_custom_taxs', array());
				if( !empty($_GET['slug']) && !empty($_GET['label']) ){
					$slug = strtolower(trim($_GET['slug']));
					$slug = str_replace(' ', '-', $slug);
					$label = trim($_GET['label']);
					$hierarchical = empty($_GET['hierarchical'])? false: true;

					$custom_taxs[$slug] = array(
						'label' => $label,
						'hierarchical' => $hierarchical
					);

					update_option('goodlayers_core_course_custom_taxs', $custom_taxs);
					wp_redirect(remove_query_arg(array('slug', 'label', 'hierarchical')));
				}else if( !empty($_GET['slug']) && !empty($_GET['action']) ){
					if( $_GET['action'] == 'remove' ){
						$slug = trim($_GET['slug']);
						unset($custom_taxs[$slug]);

						update_option('goodlayers_core_course_custom_taxs', $custom_taxs);
						wp_redirect(remove_query_arg(array('slug', 'action')));
					}
				}
			}

		} // goodlayers_core_course_add_filter_page_script
	}	

	if( !function_exists('goodlayers_core_course_create_add_filter_page') ){
		function goodlayers_core_course_create_add_filter_page(){

			// create filter form
			goodlayers_core_course_get_add_filter_form();

			// add filter content
			echo '<div class="goodlayers-core-course-add-filter-page-wrap" >';
			echo '<div class="goodlayers-core-course-add-filter-head" >';
			echo '<i class="fa fa-check-circle-o" ></i>';
			echo esc_html__('Filter', 'goodlayers_core_course');
			echo '</div>';

			echo '<div class="goodlayers-core-course-add-filter-page-content" >';
			echo '<table>';
			echo goodlayers_core_course_get_table_head(array(
				esc_html__('Taxonomy Slug', 'goodlayers_core_course'),
				esc_html__('Taxonomy Name', 'goodlayers_core_course'),
				esc_html__('Hierarchical', 'goodlayers_core_course'),
				esc_html__('Action', 'goodlayers_core_course'),
			));

			$custom_taxs = get_option('goodlayers_core_course_custom_taxs', array());
			foreach( $custom_taxs as $custom_tax_slug => $custom_tax ){

				$tax_link = admin_url('edit-tags.php?taxonomy=' . $custom_tax_slug);

				$action  = '<a href="' . add_query_arg(array('slug'=>$custom_tax_slug, 'action'=>'remove')) . '" class="goodlayers-core-course-add-filter-action" title="' . esc_html__('Remove', 'goodlayers_core_course') . '" ';
				$action .= 'data-confirm="' . esc_html__('The filter you selected will be permanently removed from the system.', 'goodlayers_core_course') . '" ';
				$action .= '>';
				$action .= '<i class="fa fa-trash-alt" ></i>';
				$action .= '</a>';

				goodlayers_core_course_get_table_content(array(
					'<a href="' . esc_url($tax_link) . '" >' . $custom_tax_slug . '</a>',
					'<a href="' . esc_url($tax_link) . '" >' . $custom_tax['label'] . '</a>',
					empty($custom_tax['hierarchical'])? esc_html__('No', 'goodlayers_core_course'): esc_html__('Yes', 'goodlayers_core_course'), 
					$action
				));

			}
			echo '</table>';
			echo '</div>';
			echo '</div>';
		}
	}

	// add filter form
	if( !function_exists('goodlayers_core_course_get_add_filter_form') ){
		function goodlayers_core_course_get_add_filter_form(){

			echo '<form class="goodlayers-core-course-add-filter-form" method="GET" >';
			echo '<input type="hidden" name="post_type" value="course" />';
			echo '<input type="hidden" name="page" value="goodlayers_core_course_add_filter_page" />';

			echo '<div class="goodlayers-core-course-add-filter-form-item clearfix" >';
			echo '<label>' . esc_html__('Custom Filter Slug :', 'goodlayers_core_course') . '</label>';
			echo '<input type="text" name="slug" value="" />';
			echo '<span class="goodlayers-core-course-add-filter-description" >';
			echo esc_html__('Please only use lowercase English character and hypen with no spaces. ( "a to z" "-" "_")', 'goodlayers_core_course');
			echo '</span>';
			echo '</div>';

			echo '<div class="goodlayers-core-course-add-filter-form-item clearfix" >';
			echo '<label>' . esc_html__('Custom Filter Label :', 'goodlayers_core_course') . '</label>';
			echo '<input type="text" name="label" value="" />';
			echo '</div>';

			echo '<div class="goodlayers-core-course-add-filter-form-item clearfix" >';
			echo '<label>' . esc_html__('Custom Filter Hierarchical :', 'goodlayers_core_course') . '</label>';
			echo '<input type="checkbox" name="hierarchical" checked />';
			echo '<span class="goodlayers-core-course-add-filter-description" >';
			echo esc_html__('Enable this option to make custom filter behave like "post category". Otherwise, it will be similar to "post tag"', 'goodlayers_core_course');
			echo '</span>';
			echo '</div>';

			echo '<div class="goodlayers-core-course-add-filter-form-submit" >';
			echo '<input class="goodlayers-core-course-button" type="submit" value="' . esc_html__('Create', 'goodlayers_core_course') . '" />';
			echo '</div>';
			echo '</form>';

		}
	}

	if( !function_exists('goodlayers_core_course_get_custom_tax_list') ){
		function goodlayers_core_course_get_custom_tax_list(){
			$ret = array();

			$custom_taxs = get_option('goodlayers_core_course_custom_taxs', array());
			foreach( $custom_taxs as $custom_tax_slug => $custom_tax ){
				$ret[$custom_tax_slug] = $custom_tax['label'];
			}

			return $ret;
		}
	}