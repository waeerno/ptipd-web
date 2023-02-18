<?php
/**
 * The main template file
 */

	get_header();

	if( have_posts() ){

		$sidebar_type = kingster_get_option('general', 'archive-blog-sidebar', 'none');
		$sidebar_left = kingster_get_option('general', 'archive-blog-sidebar-left');
		$sidebar_right = kingster_get_option('general', 'archive-blog-sidebar-right');

		echo '<div class="kingster-content-container kingster-container">';
		echo '<div class="' . kingster_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . kingster_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		
		if( class_exists('gdlr_core_pb_element_blog')  ){

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