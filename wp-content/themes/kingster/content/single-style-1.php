<?php
	/**
	 * The template part for displaying single posts style 1
	 */

	// print header title
	if( get_post_type() == 'post' ){
		get_template_part('header/header', 'title-blog');
	}

	$post_option = kingster_get_post_option(get_the_ID());
	$post_option = empty($post_option)? array(): $post_option;
	$post_option['show-content'] = empty($post_option['show-content'])? 'enable': $post_option['show-content']; 

	if( empty($post_option['sidebar']) || $post_option['sidebar'] == 'default' ){
		$sidebar_type = kingster_get_option('general', 'blog-sidebar', 'none');
		$sidebar_left = kingster_get_option('general', 'blog-sidebar-left');
		$sidebar_right = kingster_get_option('general', 'blog-sidebar-right');
	}else{
		$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
		$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
		$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
	}

	if( $sidebar_type != 'none' || $post_option['show-content'] == 'enable' ){
		echo '<div class="kingster-content-container kingster-container">';
		echo '<div class="' . kingster_get_sidebar_wrap_class($sidebar_type) . '" >';

		// sidebar content
		echo '<div class="' . kingster_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center')) . '" >';
		echo '<div class="kingster-content-wrap kingster-item-pdlr clearfix" >';

		// single content
		if( $post_option['show-content'] == 'enable' ){
			echo '<div class="kingster-content-area" >';
			if( in_array(get_post_format(), array('aside', 'quote', 'link')) ){
				get_template_part('content/content', get_post_format());
			}else{
				get_template_part('content/content', 'single');
			}
			echo '</div>';
		}
	}

	if( !post_password_required() ){
		if( $sidebar_type != 'none' ){
			echo '<div class="kingster-page-builder-wrap kingster-item-rvpdlr" >';
			do_action('gdlr_core_print_page_builder');
			echo '</div>';

		// sidebar == 'none'
		}else{
			ob_start();
			do_action('gdlr_core_print_page_builder');
			$pb_content = ob_get_contents();
			ob_end_clean();

			if( !empty($pb_content) ){
				if( $post_option['show-content'] == 'enable' ){
					echo '</div>'; // kingster-content-area
					echo '</div>'; // kingster_get_sidebar_class
					echo '</div>'; // kingster_get_sidebar_wrap_class
					echo '</div>'; // kingster_content_container
				}
				echo gdlr_core_escape_content($pb_content);
				echo '<div class="kingster-bottom-page-builder-container kingster-container" >'; // kingster-content-area
				echo '<div class="kingster-bottom-page-builder-sidebar-wrap kingster-sidebar-style-none" >'; // kingster_get_sidebar_class
				echo '<div class="kingster-bottom-page-builder-sidebar-class" >'; // kingster_get_sidebar_wrap_class
				echo '<div class="kingster-bottom-page-builder-content kingster-item-pdlr" >'; // kingster_content_container
			}
		}
	}

	// social share
	if( kingster_get_option('general', 'blog-social-share', 'enable') == 'enable' ){
		if( class_exists('gdlr_core_pb_element_social_share') ){
			$share_count = (kingster_get_option('general', 'blog-social-share-count', 'enable') == 'enable')? 'counter': 'none';

			echo '<div class="kingster-single-social-share kingster-item-rvpdlr" >';
			echo gdlr_core_pb_element_social_share::get_content(array(
				'social-head' => $share_count,
				'layout'=>'left-text', 
				'text-align'=>'center',
				'facebook'=>kingster_get_option('general', 'blog-social-facebook', 'enable'),
				'facebook-access-token'=>kingster_get_option('general', 'blog-facebook-access-token', 'enable'),
				'linkedin'=>kingster_get_option('general', 'blog-social-linkedin', 'enable'),
				'google-plus'=>kingster_get_option('general', 'blog-social-google-plus', 'enable'),
				'pinterest'=>kingster_get_option('general', 'blog-social-pinterest', 'enable'),
				'stumbleupon'=>kingster_get_option('general', 'blog-social-stumbleupon', 'enable'),
				'twitter'=>kingster_get_option('general', 'blog-social-twitter', 'enable'),
				'email'=>kingster_get_option('general', 'blog-social-email', 'enable'),
				'padding-bottom'=>'0px'
			));
			echo '</div>';
		}
	}

	// author section
	$author_desc = get_the_author_meta('description');
	if( !empty($author_desc) && kingster_get_option('general', 'blog-author', 'enable') == 'enable' ){
		echo '<div class="clear"></div>';
		echo '<div class="kingster-single-author clearfix" >';
		echo '<div class="kingster-single-author-wrap" >';
		echo '<div class="kingster-single-author-avartar kingster-media-image">' . get_avatar(get_the_author_meta('ID'), 90) . '</div>';
		
		echo '<div class="kingster-single-author-content-wrap" >';
		echo '<div class="kingster-single-author-caption kingster-info-font" >' . esc_html__('About the author', 'kingster') . '</div>';
		echo '<h4 class="kingster-single-author-title">';
		the_author_posts_link();
		echo '</h4>';

		echo '<div class="kingster-single-author-description" >' . gdlr_core_escape_content(gdlr_core_text_filter($author_desc)) . '</div>';
		echo '</div>'; // kingster-single-author-content-wrap
		echo '</div>'; // kingster-single-author-wrap
		echo '</div>'; // kingster-single-author
	}

	// prev - next post navigation
	if( kingster_get_option('general', 'blog-navigation', 'enable') == 'enable' ){
		$prev_post = get_previous_post_link(
			'<span class="kingster-single-nav kingster-single-nav-left">%link</span>',
			'<i class="arrow_left" ></i><span class="kingster-text" >' . esc_html__( 'Prev', 'kingster' ) . '</span>'
		);
		$next_post = get_next_post_link(
			'<span class="kingster-single-nav kingster-single-nav-right">%link</span>',
			'<span class="kingster-text" >' . esc_html__( 'Next', 'kingster' ) . '</span><i class="arrow_right" ></i>'
		);
		if( !empty($prev_post) || !empty($next_post) ){
			echo '<div class="kingster-single-nav-area clearfix" >' . $prev_post . $next_post . '</div>';
		}
	}

	// comments template
	if( comments_open() || get_comments_number() ){
		comments_template();
	}

	echo '</div>'; // kingster-content-area
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

?>