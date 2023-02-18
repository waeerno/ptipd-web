<?php
/**
 * The template part for displaying single posts
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kingster-single-article kingster-blog-link-format" >
		<?php 
			global $pages;

			if( preg_match('#^<a.+href=[\'"]([^\'"]+).+</a>#', $pages[0], $match) ){ 
				$post_format_link = $match[1];
				$pages[0] = substr($pages[0], strlen($match[0]));
			}else if( preg_match('#^https?://\S+#', $pages[0], $match) ){
				$post_format_link = $match[0];
				$pages[0] = substr($pages[0], strlen($match[0]));
			}else{
				$post_format_link = get_permalink();
			}

			echo '<div class="kingster-single-article-content" >';
			echo '<a class="kingster-blog-icon-link" href="' . esc_url($post_format_link) . '" target="_blank" ><i class="icon_link" ></i></a>';

			echo '<div class="kingster-blog-content-wrap" >';
			echo '<h3 class="kingster-blog-title gdlr-core-skin-title" ><a href="' . esc_url($post_format_link) . '" target="_blank" >' . get_the_title() . '</a></h3>';
			echo '<div class="kingster-blog-content" >';
			the_content();
			echo '</div>'; 
			echo '</div>';
			echo '</div>';
		?>
		
	</div><!-- kingster-single-article -->
</article><!-- post-id -->
