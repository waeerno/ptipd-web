<?php
	/* a template for displaying the top bar */

	if( kingster_get_option('general', 'enable-top-bar', 'enable') == 'enable' ){

		$top_bar_width = kingster_get_option('general', 'top-bar-width', 'boxed');
		$top_bar_container_class = '';

		if( $top_bar_width == 'boxed' ){
			$top_bar_container_class = 'kingster-container ';
		}else if( $top_bar_width == 'custom' ){
			$top_bar_container_class = 'kingster-top-bar-custom-container ';
		}else{
			$top_bar_container_class = 'kingster-top-bar-full ';
		}

		$top_bar_menu = kingster_get_option('general', 'top-bar-menu-position', 'none');

		echo '<div class="kingster-top-bar" >';
		echo '<div class="kingster-top-bar-background" ></div>';
		echo '<div class="kingster-top-bar-container ' . esc_attr($top_bar_container_class) . '" >';
		echo '<div class="kingster-top-bar-container-inner clearfix" >';

		$language_flag = kingster_get_wpml_flag();
		$left_text = kingster_get_option('general', 'top-bar-left-text', '');
		if( !empty($left_text) || !empty($language_flag) || 
			($top_bar_menu == 'left' && has_nav_menu('top_bar_menu')) ){

			echo '<div class="kingster-top-bar-left kingster-item-pdlr">';
			if( $top_bar_menu == 'left' ){
				kingster_get_top_bar_menu('left');
			}
			echo gdlr_core_escape_content($language_flag);
			echo gdlr_core_escape_content(gdlr_core_text_filter($left_text));
			echo '</div>';
		}

		$right_text = kingster_get_option('general', 'top-bar-right-text', '');
		$right_button_text = kingster_get_option('general', 'top-bar-right-button-text', '');
		$right_button_link = kingster_get_option('general', 'top-bar-right-button-link', '');
		$top_bar_social = kingster_get_option('general', 'enable-top-bar-social', 'enable');
		$custom_top_bar_right = apply_filters('kingster_custom_top_bar_right', ''); 
		if( !empty($right_text) || $top_bar_social == 'enable' || !empty($custom_top_bar_right) ||
			($top_bar_menu == 'right' && has_nav_menu('top_bar_menu')) || 
			(!empty($right_button_text) && !empty($right_button_link)) ){

			echo '<div class="kingster-top-bar-right kingster-item-pdlr">';
			if( $top_bar_menu == 'right' ){
				kingster_get_top_bar_menu('right');
			}

			if( !empty($right_text) ){
				echo '<div class="kingster-top-bar-right-text">';
				echo gdlr_core_escape_content(gdlr_core_text_filter($right_text));
				echo '</div>';
			}

			if( $top_bar_social == 'enable' ){
				echo '<div class="kingster-top-bar-right-social" >';
				get_template_part('header/header', 'social');
				echo '</div>';	
			}

			if( !empty($right_button_text) && !empty($right_button_link) ){
				echo '<a class="kingster-top-bar-right-button" href="' . esc_url($right_button_link) . '" ';
				echo 'target="' . kingster_get_option('general', 'top-bar-right-button-target', '_blank') . '" ';
				echo ' >' . gdlr_core_text_filter($right_button_text) . '</a>';
			}

			if( !empty($custom_top_bar_right) ){
				echo gdlr_core_text_filter($custom_top_bar_right);
			}
			echo '</div>';	
		}
		echo '</div>'; // kingster-top-bar-container-inner
		echo '</div>'; // kingster-top-bar-container
		echo '</div>'; // kingster-top-bar

	}  // top bar
?>