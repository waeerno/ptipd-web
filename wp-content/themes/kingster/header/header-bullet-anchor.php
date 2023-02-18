<?php
	/* a template for displaying the header social network */

	$post_option = kingster_get_post_option(get_the_ID());
	if( !empty($post_option['bullet-anchor']) ){

		echo '<div class="kingster-bullet-anchor" id="kingster-bullet-anchor" >';
		echo '<a class="kingster-bullet-anchor-link current-menu-item" href="' . get_permalink() . '" ></a>';
		foreach( $post_option['bullet-anchor'] as $anchor ){
			echo '<a class="kingster-bullet-anchor-link" href="' . esc_url($anchor['title']) . '" ></a>';
		}
		echo '</div>';
	}