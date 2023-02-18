<?php
/**
 * The main template file
 */ 


	get_header();

	echo '<div class="kingster-content-container kingster-container">';
	echo '<div class="kingster-sidebar-style-none" >'; // for max width

	get_template_part('content/archive', 'default');

	echo '</div>'; // kingster-content-area
	echo '</div>'; // kingster-content-container

	get_footer(); 
