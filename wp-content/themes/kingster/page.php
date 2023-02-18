<?php
/**
 * The template for displaying pages
 */
	global $kingster_event_id;
	$kingster_event_id = get_the_ID(); 
	
	get_header();

	while( have_posts() ){ the_post();

		$post_option = kingster_get_post_option(get_the_ID());
		$show_content = (empty($post_option['show-content']) || $post_option['show-content'] == 'enable')? true: false;

		if( empty($post_option['sidebar']) ){
			if( is_singular( 'tribe_events' ) ){
				$sidebar_type = kingster_get_option('general', 'default-event-sidebar', 'none');
				$sidebar_left = kingster_get_option('general', 'default-event-sidebar-left', '');
				$sidebar_right = kingster_get_option('general', 'default-event-sidebar-right', '');
			}else{
				$sidebar_type = 'none';
				$sidebar_left = '';
				$sidebar_right = '';
			}
		}else{
			$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
			$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
			$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
		}

		if( $sidebar_type == 'none' ){

			// content from wordpress editor area
			ob_start();
			the_content();
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kingster' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kingster' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="kingster-content-container kingster-container">';
				echo '<div class="kingster-content-area kingster-item-pdlr kingster-sidebar-style-none clearfix" >';
				echo gdlr_core_escape_content($content);
				echo '</div>'; // kingster-content-area
				echo '</div>'; // kingster-content-container
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="kingster-page-comment-container kingster-container" >';
				echo '<div class="kingster-page-comments kingster-item-pdlr" >';
				comments_template();
				echo '</div>';
				echo '</div>';
			}

		}else{

			echo '<div class="kingster-content-container kingster-container">';
			echo '<div class="' . kingster_get_sidebar_wrap_class($sidebar_type) . '" >';

			// sidebar content
			echo '<div class="' . kingster_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
			
			// content from wordpress editor area
			ob_start();
			the_content();
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kingster' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kingster' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="kingster-content-area kingster-item-pdlr" >' . $content . '</div>'; // kingster-content-wrapper
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="kingster-page-comments kingster-item-pdlr" >';
				comments_template();
				echo '</div>';
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

		do_action('goodlayers_core_course_search_content', array(
			'num-fetch' => kingster_get_option('general', 'course-search-num-fetch', 9),
			'course-info' => kingster_get_option('general', 'course-search-info', array()),
			'frame-background' => kingster_get_option('general', 'course-search-frame-background', ''),
			'title-color' => kingster_get_option('general', 'course-search-title-color', ''),
			'search-fields' => kingster_get_option('general', 'course-search-item-fields', ''),
		));
		
	} // while

	get_footer(); 
?>