<?php
/**
 * The template for displaying 404 pages (not found)
 */

	get_header();

	echo '<div class="kingster-not-found-wrap" id="kingster-full-no-header-wrap" >';
	echo '<div class="kingster-not-found-background" ></div>';
	echo '<div class="kingster-not-found-container kingster-container">';
	echo '<div class="kingster-header-transparent-substitute" ></div>';
	
	echo '<div class="kingster-not-found-content kingster-item-pdlr">';
	echo '<h1 class="kingster-not-found-head" >' . esc_html__('404', 'kingster') . '</h1>';
	echo '<h3 class="kingster-not-found-title kingster-content-font" >' . esc_html__('Page Not Found', 'kingster') . '</h3>';
	echo '<div class="kingster-not-found-caption" >' . esc_html__('Sorry, we couldn\'t find the page you\'re looking for.', 'kingster') . '</div>';

	echo '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '">';
	echo '<input type="text" class="search-field kingster-title-font" placeholder="' . esc_attr__('Type Keywords...', 'kingster') . '" value="" name="s">';
	echo '<div class="kingster-top-search-submit"><i class="fa fa-search" ></i></div>';
	echo '<input type="submit" class="search-submit" value="Search">';
	echo '</form>';
	echo '<div class="kingster-not-found-back-to-home" ><a href="' . esc_url(home_url('/')) . '" >' . esc_html__('Or Back To Homepage', 'kingster') . '</a></div>';
	echo '</div>'; // kingster-not-found-content

	echo '</div>'; // kingster-not-found-container
	echo '</div>'; // kingster-not-found-wrap

	get_footer(); 
