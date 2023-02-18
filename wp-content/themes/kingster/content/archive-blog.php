<?php
/**
 * The template part for displaying blog archive
 */

	global $wp_query;

	$settings = array(
		'query' => $wp_query,
		'blog-style' => kingster_get_option('general', 'archive-blog-style', 'blog-full'),
		'blog-full-style' => kingster_get_option('general', 'archive-blog-full-style', 'style-1'),
		'blog-side-thumbnail-style' => kingster_get_option('general', 'archive-blog-side-thumbnail-style', 'style-1'),
		'blog-column-style' => kingster_get_option('general', 'archive-blog-column-style', 'style-1'),
		'blog-image-style' => kingster_get_option('general', 'archive-blog-image-style', 'style-1'),
		'blog-full-alignment' => kingster_get_option('general', 'archive-blog-full-alignment', 'left'),
		'thumbnail-size' => kingster_get_option('general', 'archive-thumbnail-size', 'full'),
		'show-thumbnail' => kingster_get_option('general', 'archive-show-thumbnail', 'enable'),
		'column-size' => kingster_get_option('general', 'archive-column-size', 20),
		'excerpt' => kingster_get_option('general', 'archive-excerpt', 'specify-number'),
		'excerpt-number' => kingster_get_option('general', 'archive-excerpt-number', 55),
		'blog-date-feature' => kingster_get_option('general', 'archive-date-feature', 'enable'),
		'meta-option' => kingster_get_option('general', 'archive-meta-option', array()),
		'show-read-more' => kingster_get_option('general', 'archive-show-read-more', 'enable'),

		'blog-title-font-size' => kingster_get_option('general', 'archive-blog-title-font-size', ''),
		'blog-title-font-weight' => kingster_get_option('general', 'archive-blog-title-font-weight', ''),
		'blog-title-letter-spacing' => kingster_get_option('general', 'archive-blog-title-letter-spacing', ''),
		'blog-title-text-transform' => kingster_get_option('general', 'archive-blog-title-text-transform', ''),

		'paged' => (get_query_var('paged'))? get_query_var('paged') : 1,
		'pagination' => 'page',
		'pagination-style' => kingster_get_option('general', 'pagination-style', 'round'),
		'pagination-align' => kingster_get_option('general', 'pagination-align', 'right'),

	);

	echo '<div class="kingster-content-area" >';
	if( is_category() ){
		$tax_description = category_description();
		if( !empty($tax_description) ){
			echo '<div class="kingster-archive-taxonomy-description kingster-item-pdlr" >' . $tax_description . '</div>';
		}
	}else if( is_tag() ){
		$tax_description = term_description(NULL, 'post_tag');
		if( !empty($tax_description) ){
			echo '<div class="kingster-archive-taxonomy-description kingster-item-pdlr" >' . $tax_description . '</div>';
		}
	}

	echo gdlr_core_pb_element_blog::get_content($settings);
	echo '</div>'; // kingster-content-area