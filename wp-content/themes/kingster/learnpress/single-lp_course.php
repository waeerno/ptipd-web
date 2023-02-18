<?php
/**
 * The template for displaying pages
 */
	global $kingster_event_id;
	$kingster_event_id = get_the_ID(); 
	
	get_header();

	while( have_posts() ){ the_post();

		$post_option = kingster_get_post_option(get_the_ID());

		// course info
		if( empty($post_option['display-course-info']) || $post_option['display-course-info'] == 'default' ){
			$display_course_info = kingster_get_option('lp', 'display-single-course-info', 'disable');
		}else{
			$display_course_info = $post_option['display-course-info'];
		}
		
		if( $display_course_info == 'enable' ){
			echo '<div class="kingster-lp-single-course-info-container kingster-container" >';
			echo '<div class="kingster-lp-single-course-info clearfix" >';
			echo '<div class="kingster-left" >';
			echo kingster_lp_pb_element_course_info::get_content( array( 'types' => array('teacher', 'category', 'review') ));
			echo '</div>';

			echo '<div class="kingster-right" >';
			echo kingster_lp_pb_element_course_price::get_content();
			echo '</div>';
			echo '</div>';
		}
			
		// default content
		$sidebar_type = 'none';
		$sidebar_left = '';
		$sidebar_right = '';

		if( !post_password_required() ){
			do_action('gdlr_core_print_page_builder');
		}
		
		// content from wordpress editor area
		ob_start();
		do_action('kingster_single_course_tab');
		// the_content();
		// wp_link_pages(array(
		// 	'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'kingster' ) . '</span>',
		// 	'after'       => '</div>',
		// 	'link_before' => '<span>',
		// 	'link_after'  => '</span>',
		// 	'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'kingster' ) . ' </span>%',
		// 	'separator'   => '<span class="screen-reader-text">, </span>',
		// ));
		$content = ob_get_contents();
		ob_end_clean();

		if( trim($content) != "" || post_password_required() ){
			echo '<div class="kingster-content-container kingster-container">';
			echo '<div class="kingster-content-area kingster-item-pdlr kingster-sidebar-style-none clearfix" >';
			echo gdlr_core_escape_content($content);


			if( class_exists('gdlr_core_pb_element_social_share') ){
				$enable_social = kingster_get_option('lp', 'enable-single-course-social-share', 'enable');

				if( $enable_social == 'enable' ){
					echo '<div class="kingster-lp-course-social-share" >';
					echo '<div class="kingster-head" >' . esc_html__('Share', 'kingster') . '</div>';
					echo gdlr_core_pb_element_social_share::get_content(array(
						'facebook'=>kingster_get_option('general', 'blog-social-facebook', 'enable'),
						'linkedin'=>kingster_get_option('general', 'blog-social-linkedin', 'enable'),
						'google-plus'=>kingster_get_option('general', 'blog-social-google-plus', 'enable'),
						'pinterest'=>kingster_get_option('general', 'blog-social-pinterest', 'enable'),
						'stumbleupon'=>kingster_get_option('general', 'blog-social-stumbleupon', 'enable'),
						'twitter'=>kingster_get_option('general', 'blog-social-twitter', 'enable'),
						'email'=>kingster_get_option('general', 'blog-social-email', 'enable'),
						'social-head' => 'none', 
						'style' => 'plain',
						'layout' => 'left-text',
						'padding-bottom'=>'0px'
					));
					echo '</div>';
				}
				
			}


			echo '</div>'; // kingster-content-area
			echo '</div>'; // kingster-content-container
		}

		// related course
		$related_course = kingster_get_option('lp', 'enable-single-course-related', 'course_tag');
		if( $related_course != 'disable' ){

			// query related post
			$args = array('post_type' => 'lp_course', 'suppress_filters' => false);
			$args['posts_per_page'] = kingster_get_option('lp', 'single-course-related-num-fetch', '3');
			$args['post__not_in'] = array(get_the_ID());
			$args['ignore_sticky_posts'] = 1;
			
			$related_terms = get_the_terms(get_the_ID(), $related_course);
			$category_list = array();
			if( !empty($related_terms) ){
				foreach( $related_terms as $term ){
					$category_list[] = $term->term_id;
				}
				$args['tax_query'] = array(array('terms'=>$category_list, 'taxonomy'=>$related_course, 'field'=>'id'));
			} 
			$query = new WP_Query($args);

			if( $query->have_posts() ){
				echo '<div class="kingster-lp-course-ralated-container kingster-container" >';
				echo '<div class="kingster-lp-course-ralated-head kingster-item-pdlr clearfix" >';
				echo '<h3 class="kingster-lp-course-related-title" >';
				echo esc_html__('More courses you might like', 'kingster');
				echo '</h3>';

				$view_all_courses = kingster_get_option('lp', 'single-course-related-view-all', '');
				if( !empty($view_all_courses) ){
					echo '<a href="' . esc_attr($view_all_courses) . '" class="kingster-lp-course-related-view-all" >' . esc_html__('View all courses', 'kingster') . '</a>';
				} 
				echo '</div>'; // kingster-lp-course-ralated-head

				$course_item = new kingster_lp_course_item(array(
					'query' => $query,
					'course-style' => 'grid',
					'layout' => 'fitrows',
					'course-grid-bottom-info' => array('price', 'wishlist'),
					'course-grid-bottom-info2' => array('lecture', 'student'),
					'excerpt' => 'specify-number',
					'excerpt-number' => 0,
					'column-size' => kingster_get_option('lp', 'single-course-related-column-size', '20'),
					'thumbnail-size' => kingster_get_option('lp', 'single-course-related-thumbnail-size', '3'),
					'enable-move-up-shadow-effect' => 'enable'
				));
				echo $course_item->get_content();

				echo '</div>'; // kingster-lp-course-ralated-container
			}
			
		}

		// comments template
		if( comments_open() || get_comments_number() ){
			echo '<div class="kingster-page-comment-container kingster-container" >';
			echo '<div class="kingster-page-comments kingster-item-pdlr" >';
			comments_template();
			echo '</div>';
			echo '</div>';
		}	

		$enable_subscription = kingster_get_option('lp', 'enable-bottom-subscription', 'enable');
		if( $enable_subscription == 'enable' ){
			$sub_title = kingster_get_option('lp', 'bottom-subscription-text-title', esc_html__('Subscribe to our newsletter', 'kingster'));
			$sub_caption = kingster_get_option('lp', 'bottom-subscription-text-caption', esc_html__('Get the new course in your inbox!', 'kingster'));

			
			echo '<div class="kingster-lp-course-buttom-subscription-container kingster-container" >';
			echo '<div class="kingster-lp-course-buttom-subscription kingster-item-mglr" >';
			echo '<div class="kingster-lp-course-buttom-subscription-inner clearfix" >';
			echo '<div class="kingster-column-30" >';
			if( !empty($sub_title) ){
				echo '<h3 class="kingster-title" >' . $sub_title . '</h3>';
			}
			if( !empty($sub_title) ){
				echo '<div class="kingster-caption" >' . $sub_caption . '</div>';
			}
			echo '</div>'; // kingster-column-30

			echo '<div class="kingster-column-30" >';
			if( class_exists('gdlr_core_pb_element_newsletter') ){
				$nl_item = new gdlr_core_pb_element_newsletter();
				echo $nl_item->get_content(array(
					'style' => 'curve',
					'padding-bottom' => '0px'
				));
			}
			echo '</div>'; // kingster-column-30
			echo '</div>'; // kingster-lp-course-buttom-subscription-inner
			echo '</div>'; // kingster-lp-course-buttom-subscription
			echo '</div>'; // kingster-container
		}
		
	} // while

	get_footer(); 
?>