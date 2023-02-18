<?php
	/*	
	*	Goodlayers Utility File
	*	---------------------------------------------------------------------
	*	This file contains utility function in the theme
	*	---------------------------------------------------------------------
	*/

	// a comment callback function to create comment list
	if ( !function_exists('kingster_comment_list') ){
		function kingster_comment_list( $comment, $args, $depth ){

			$GLOBALS['comment'] = $comment;

			if ( 'div' == $args['style'] ) {
			    $tag = 'div';
			    $add_below = 'comment';
			} else {
			    $tag = 'li';
			    $add_below = 'div-comment';
			}

?>
<<?php echo esc_html($tag); ?> <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment-article">
		<div class="comment-avatar"><?php echo get_avatar( $comment, 90 ); ?></div>
		<div class="comment-body">
			<header class="comment-meta">
				<div class="comment-author kingster-title-font"><?php echo get_comment_author_link(); ?></div>
				<div class="comment-time kingster-info-font">
					<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
						<time datetime="<?php echo get_comment_time('c'); ?>">
							<?php echo get_comment_date() . ' ' . esc_html__('at', 'kingster') . ' ' . get_comment_time(); ?>
						</time>
					</a>
				</div>
			<div class="comment-reply">
				<?php comment_reply_link(array_merge($args, array(
					'reply_text' => esc_html__('Reply', 'kingster'), 
					'depth' => $depth, 
					'max_depth' => $args['max_depth'])
				)); ?>
			</div><!-- reply -->					
			</header>

			<?php if( '0' == $comment->comment_approved ){ ?>
				<p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'kingster' ); ?></p>
			<?php } ?>

			<section class="comment-content">
				<?php comment_text(); ?>
				<?php edit_comment_link( esc_html__( 'Edit', 'kingster' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- comment-content -->

		</div><!-- comment-body -->
	</article><!-- comment-article -->
<?php

		}
	}
	
	// use to clear an option for customize page
	if( !function_exists('kingster_clear_option') ){
		function kingster_clear_option(){
			$options = array('general', 'typography', 'color', 'plugin');

			foreach( $options as $option ){
				unset($GLOBALS['kingster_' . $option]);
			}
			
		}
	}
	
	// get option for uses
	if( !function_exists('kingster_get_option') ){
		function kingster_get_option($option, $key = '', $default = ''){
			$option = 'kingster_' . $option;
			
			if( empty($GLOBALS[$option]) ){
				$GLOBALS[$option] = get_option($option, '');
			}
				
			if( !empty($key) ){
				if( !empty($GLOBALS[$option][$key]) || (isset($GLOBALS[$option][$key]) && $GLOBALS[$option][$key] === '0') ){
					return $GLOBALS[$option][$key];
				}else{
					return $default;
				}
			}else{
				return $GLOBALS[$option];
			}
		}
	}

	// set option for temporary uses
	if( !function_exists('kingster_set_option') ){
		function kingster_set_option($option, $key = '', $value = ''){
			$option = 'kingster_' . $option;
			
			if( empty($GLOBALS[$option]) ){
				$GLOBALS[$option] = get_option($option, '');
			}
				
			if( !empty($key) ){
				if( !empty($GLOBALS[$option][$key]) ){
					$GLOBALS[$option][$key] = $value;
				}
			}
		}
	}

	// get post option for uses
	if( !function_exists('kingster_get_post_option') ){
		function kingster_get_post_option( $post_id, $key = 'gdlr-core-page-option' ){

			global $kingster_post_option;

			if( empty($kingster_post_option['id']) || $kingster_post_option['id'] != $post_id || 
				empty($kingster_post_option['key']) || $kingster_post_option['key'] != $key ){

				$kingster_post_option = array(
					'id' => $post_id,
					'key' => $key,
					'option' => get_post_meta($post_id, $key, true)
				);
			}

			return empty($kingster_post_option['option'])? array(): $kingster_post_option['option'];
		}
	}

	// get blog info :: originate from gdlr core plugin
	if( !function_exists('kingster_get_blog_info') ){
		function kingster_get_blog_info($args){
			
			$blog_info_prefix = array(
				'date' => '',
				'tag' => '',
				'category' => '',
				'comment' => '<i class="fa fa-comments-o" ></i>',
				'like' => '<i class="icon_heart_alt" ></i>',
				'author' => esc_html__('By', 'kingster'),
				'comment-number' => '<i class="fa fa-comments-o" ></i>',
			);

			$ret = '';
			
			if( !empty($args['display']) ){
				foreach( $args['display'] as $blog_info ){
					
					$ret_temp = '';
					
					switch( $blog_info ){
						case 'date':
							$ret_temp .= '<a href="' . get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')) . '">';
							$ret_temp .= get_the_date();
							$ret_temp .= '</a>';
							break;
							
						case 'tag':
							$ret_temp .= get_the_term_list(get_the_ID(), 'post_tag', '', '<span class="gdlr-core-sep">,</span> ' , '');							
							break;
							
						case 'category':
							$ret_temp .= get_the_term_list(get_the_ID(), 'category', '', '<span class="gdlr-core-sep">,</span> ' , '' );;					
							break;
							
						case 'comment-number':
							$ret_temp .= get_comments_number() . ' ';
							break;
						
						case 'comment':
							ob_start();
							comments_number(
								esc_html__('no comments', 'kingster'), 
								esc_html__('one comment', 'kingster'), 
								esc_html__('% comments', 'kingster') 
							);
							$ret_temp .= '<a href="' . get_permalink() . '#respond" >';
							$ret_temp .= ob_get_contents();
							$ret_temp .= '</a>';
							ob_end_clean();								
							break;
							
						case 'author':
							ob_start();
							echo '<span class="fn" >';
							the_author_posts_link();
							echo '</span>';
							$ret_temp .= ob_get_contents();
							ob_end_clean();					
							break;
					} // switch
					
					if( !empty($ret_temp) ){
						
						$ret .= '<div class="kingster-blog-info kingster-blog-info-font'; 
						$ret .= ' kingster-blog-info-' . esc_attr($blog_info); 
						if( $blog_info == 'date' ){
							$ret .= ' post-date updated';
						}else if( $blog_info == 'author' ){
							$ret .= ' vcard author post-author';
						}
						$ret .= ' ">';
						if( !empty($args['separator']) ){
							$ret .= '<span class="kingster-blog-info-sep" >' . $args['separator'] . '</span>';
						}
						if( (!isset($args['icon']) || $args['icon'] !== false) && !empty($blog_info_prefix[$blog_info]) ){
							$ret .= '<span class="kingster-head" >' . $blog_info_prefix[$blog_info] . '</span>';
						}
						$ret .= $ret_temp;
						$ret .= '</div>';
					}
					
				} // foreach
			} // $args['display']
			
			if( !empty($ret) && !empty($args['wrapper']) ){
				$ret = '<div class="kingster-blog-info-wrapper" >' . $ret . '</div>';
			}
			return $ret;
		}
	}

	// get the sidebar
	if( !function_exists('kingster_get_sidebar_wrap_class') ){
		function kingster_get_sidebar_wrap_class($sidebar_type){
			return ' kingster-sidebar-wrap clearfix kingster-line-height-0 kingster-sidebar-style-' . $sidebar_type;
		}
	}
	if( !function_exists('kingster_get_sidebar_class') ){
		function kingster_get_sidebar_class($args){

			// set default column
			if( empty($args['column']) ){
				if( $args['sidebar-type'] == 'both' ){
					$args['column'] = kingster_get_option('general', 'both-sidebar-width', 15);
				}else if( $args['sidebar-type'] == 'left' || $args['sidebar-type'] == 'right' ){
					$args['column'] = kingster_get_option('general', 'sidebar-width', 20);
				}else{
					$args['column'] = 60;
				}
			}

			// if center section
			if( $args['section'] == 'center' ){
				if( $args['sidebar-type'] == 'both' ){
					$args['column'] = 60 - (2 * intval($args['column']));
				}else if( $args['sidebar-type'] == 'left' || $args['sidebar-type'] == 'right' ){
					$args['column'] = 60 - intval($args['column']);
				}
			}

			$sidebar_class  = ' kingster-sidebar-' . $args['section'];
			$sidebar_class .= ' kingster-column-' . $args['column'];
			$sidebar_class .= ' kingster-line-height';

			return $sidebar_class; 
		}
	}
	if( !function_exists('kingster_get_sidebar') ){
		function kingster_get_sidebar($sidebar_type, $section, $sidebar_id){

			echo '<div class="' . kingster_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>$section)) . ' kingster-line-height" >';
			echo '<div class="kingster-sidebar-area kingster-item-pdlr" >';
			if( is_active_sidebar($sidebar_id) ){ 
				dynamic_sidebar($sidebar_id); 
			}
			echo '</div>';
			echo '</div>';

		}
	}

	// overlay menu
	if( !function_exists('kingster_is_top_search') ){
		function kingster_is_top_search(){
			global $is_top_search;
			return empty($is_top_search)? false: true;
		}
	}
	if( !function_exists('kingster_get_top_search') ){
		function kingster_get_top_search(){
			global $is_top_search;
			$is_top_search = true;
?>
<div class="kingster-top-search-wrap" >
	<div class="kingster-top-search-close" ></div>

	<div class="kingster-top-search-row" >
		<div class="kingster-top-search-cell" >
			<?php get_search_form() ?>
		</div>
	</div>

</div>
<?php
			$is_top_search = false;
		}
	}