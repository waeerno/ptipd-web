<?php
/**
 * The main template file
 */

	get_header();

	// check for course archive
	$is_course_archive = false;
	if( is_tax('course_category') || is_tax('course_tag') ){
		$is_course_archive = true;
	}
	if( function_exists('goodlayers_core_course_get_custom_tax_list') ){
		$taxs = goodlayers_core_course_get_custom_tax_list();

		foreach( $taxs as $tax_slug => $tax_label ){
			if( is_tax($tax_slug) ){
				$is_course_archive = true;
			}
		}
	}

	if( $is_course_archive ){
		
		do_action('goodlayers_core_course_archive_content', array(
			'num-fetch' => kingster_get_option('general', 'course-search-num-fetch', 9),
			'course-info' => kingster_get_option('general', 'course-search-info', array()),
			'frame-background' => kingster_get_option('general', 'course-search-frame-background', ''),
			'title-color' => kingster_get_option('general', 'course-search-title-color', ''),
			'search-fields' => kingster_get_option('general', 'course-search-item-fields', ''),
		));	

	}else{

		if( is_tax('portfolio_category') || is_tax('portfolio_tag') && class_exists('gdlr_core_pb_element_portfolio') ){
			$post_type = 'portfolio';

			$sidebar_type = kingster_get_option('general', 'archive-portfolio-sidebar', 'none');
			$sidebar_left = kingster_get_option('general', 'archive-portfolio-sidebar-left');
			$sidebar_right = kingster_get_option('general', 'archive-portfolio-sidebar-right');		
		}else{
			$post_type = 'post';

			$sidebar_type = kingster_get_option('general', 'archive-blog-sidebar', 'none');
			$sidebar_left = kingster_get_option('general', 'archive-blog-sidebar-left');
			$sidebar_right = kingster_get_option('general', 'archive-blog-sidebar-right');
		}

		echo '<div class="kingster-content-container kingster-container">';
		echo '<div class="' . kingster_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . kingster_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		
		if( $post_type == 'portfolio' && class_exists('gdlr_core_pb_element_portfolio') ){

			get_template_part('content/archive', 'portfolio');

		}else if( class_exists('gdlr_core_pb_element_blog') ){

			get_template_part('content/archive', 'blog');
			
		}else{

			get_template_part('content/archive', 'default');
			
		}

		echo '</div>'; // kingster-get-sidebar-class

		// sidebar left
		if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
			echo kingster_get_sidebar($sidebar_type, 'left', $sidebar_left);
		}

		// sidebar right
		if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
			echo kingster_get_sidebar($sidebar_type, 'right', $sidebar_right);
		}

		echo '</div>'; // kingster-get-sidebar-wrap-class
	 	echo '</div>'; // kingster-content-container
	}

	get_footer(); 
?>