<?php
/**
 * The template part for displaying single posts
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="kingster-single-article kingster-blog-aside-format" >
		<?php 
			// post title
			$post_option = kingster_get_post_option(get_the_ID());
			if( empty($post_option['blog-title-style']) || $post_option['blog-title-style'] == 'default' ){
				$title_style = kingster_get_option('general', 'default-blog-title-style', 'small');
			}else{	
				$title_style = $post_option['blog-title-style'];
			}
			if( $title_style == 'none' ){
				get_template_part('content/content-single', 'title');
			}

			// post content
			echo '<div class="kingster-single-article-content">';
			the_content(); 
			echo '</div>';
		?>
		
	</div><!-- kingster-single-article -->
</article><!-- post-id -->
