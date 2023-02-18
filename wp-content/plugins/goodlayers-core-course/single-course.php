<?php
	/**
	 * The template for displaying all single portfolio posttype
	 */

get_header();
	
	while( have_posts() ){ the_post();

		global $post; 
		$post_option = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);
		$show_content = (empty($post_option['show-content']) || $post_option['show-content'] == 'enable')? true: false;

		if( ($show_content && trim($post->post_content) != "") || post_password_required() ){
			echo '<div class="gdlr-core-outer-content-wrap">';
			echo '<div class="gdlr-core-content-container gdlr-core-container">';
			echo '<div class="gdlr-core-content-area gdlr-core-item-pdlr" >';
			the_content();
			echo '</div>'; // gdlr-core-content-area
			echo '</div>';
			echo '</div>';
		}
		
		if( !post_password_required() ){
			do_action('gdlr_core_print_page_builder');
		}

	}

get_footer(); 

?>