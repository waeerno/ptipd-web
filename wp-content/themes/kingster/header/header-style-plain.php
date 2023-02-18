<?php
	/* a template for displaying the header area */

	// header container
	$body_layout = kingster_get_option('general', 'layout', 'full');
	$body_margin = kingster_get_option('general', 'body-margin', '0px');
	$header_width = kingster_get_option('general', 'header-width', 'boxed');
	$header_background_style = kingster_get_option('general', 'header-background-style', 'solid');
	
	if( $header_width == 'boxed' ){
		$header_container_class = ' kingster-container';
	}else if( $header_width == 'custom' ){
		$header_container_class = ' kingster-header-custom-container';
	}else{
		$header_container_class = ' kingster-header-full';
	}

	$header_style = kingster_get_option('general', 'header-plain-style', 'menu-right');
	$navigation_offset = kingster_get_option('general', 'fixed-navigation-anchor-offset', '');

	$header_wrap_class  = ' kingster-style-' . $header_style;
	$header_wrap_class .= ' kingster-sticky-navigation';
	if( $header_style == 'center-logo' || $body_layout == 'boxed' || 
		$body_margin != '0px' || $header_background_style == 'transparent' ){
		
		$header_wrap_class .= ' kingster-style-slide';
	}else{
		$header_wrap_class .= ' kingster-style-fixed';
	}
?>	
<header class="kingster-header-wrap kingster-header-style-plain <?php echo esc_attr($header_wrap_class); ?> clearfix" <?php
		if( !empty($navigation_offset) ){
			echo 'data-navigation-offset="' . esc_attr($navigation_offset) . '" ';
		}
	?> >
	<div class="kingster-header-background" ></div>
	<div class="kingster-header-container <?php echo esc_attr($header_container_class); ?>">
			
		<div class="kingster-header-container-inner clearfix">
			<?php

				if( $header_style == 'splitted-menu' ){
					add_filter('kingster_center_menu_item', 'kingster_get_logo');
				}else{
					echo kingster_get_logo();
				}

				$navigation_class = '';
				if( kingster_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
					$navigation_class = 'kingster-navigation-submenu-indicator ';
				}
			?>
			<div class="kingster-navigation kingster-item-pdlr clearfix <?php echo esc_attr($navigation_class); ?>" >
			<?php
				// print main menu
				if( has_nav_menu('main_menu') ){
					echo '<div class="kingster-main-menu" id="kingster-main-menu" >';
					wp_nav_menu(array(
						'theme_location'=>'main_menu', 
						'container'=> '', 
						'menu_class'=> 'sf-menu',
						'walker' => new kingster_menu_walker()
					));
					$slide_bar = kingster_get_option('general', 'navigation-slide-bar', 'enable');
					if( $slide_bar == 'enable' ){
						echo '<div class="kingster-navigation-slide-bar" id="kingster-navigation-slide-bar" ></div>';
					}
					echo '</div>';
				}

				// menu right side
				$menu_right_class = '';
				if( in_array($header_style, array('center-menu', 'center-logo', 'splitted-menu')) ){
					$menu_right_class = ' kingster-item-mglr kingster-navigation-top';
				}

				$enable_search = (kingster_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
				$enable_cart = (kingster_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
				$enable_right_button = (kingster_get_option('general', 'enable-main-navigation-right-button', 'disable') == 'enable')? true: false;
				$custom_main_menu_right = apply_filters('kingster_custom_main_menu_right', '');
				if( has_nav_menu('right_menu') || $enable_search || $enable_cart || $enable_right_button || !empty($custom_main_menu_right) ){
					echo '<div class="kingster-main-menu-right-wrap clearfix ' . esc_attr($menu_right_class) . '" >';

					// search icon
					if( $enable_search ){
						echo '<div class="kingster-main-menu-search" id="kingster-top-search" >';
						echo '<i class="icon_search" ></i>';
						echo '</div>';
						kingster_get_top_search();
					}

					// cart icon
					if( $enable_cart ){
						echo '<div class="kingster-main-menu-cart" id="kingster-menu-cart" >';
						echo '<i class="fa fa-shopping-cart" ></i>';
						kingster_get_woocommerce_bar();
						echo '</div>';
					}

					// menu right button
					if( $enable_right_button ){
						$button_class = 'kingster-style-' . kingster_get_option('general', 'main-navigation-right-button-style', 'default');
						$button_link = kingster_get_option('general', 'main-navigation-right-button-link', '');
						$button_link_target = kingster_get_option('general', 'main-navigation-right-button-link-target', '_self');
						echo '<a class="kingster-main-menu-right-button ' . esc_attr($button_class) . '" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
						echo kingster_get_option('general', 'main-navigation-right-button-text', '');
						echo '</a>';
					}

					// custom menu right
					if( !empty($custom_main_menu_right) ){
						echo gdlr_core_text_filter($custom_main_menu_right);
					}

					// print right menu
					if( has_nav_menu('right_menu') && $header_style != 'splitted-menu' ){
						kingster_get_custom_menu(array(
							'container-class' => 'kingster-main-menu-right',
							'button-class' => 'kingster-right-menu-button kingster-top-menu-button',
							'icon-class' => 'fa fa-bars',
							'id' => 'kingster-right-menu',
							'theme-location' => 'right_menu',
							'type' => kingster_get_option('general', 'right-menu-type', 'right')
						));
					}

					echo '</div>'; // kingster-main-menu-right-wrap

					if( has_nav_menu('right_menu') && $header_style == 'splitted-menu'  ){
						echo '<div class="kingster-main-menu-left-wrap clearfix kingster-item-pdlr kingster-navigation-top" >';
						kingster_get_custom_menu(array(
							'container-class' => 'kingster-main-menu-right',
							'button-class' => 'kingster-right-menu-button kingster-top-menu-button',
							'icon-class' => 'fa fa-bars',
							'id' => 'kingster-right-menu',
							'theme-location' => 'right_menu',
							'type' => kingster_get_option('general', 'right-menu-type', 'right')
						));
						echo '</div>';
					}
				}

				remove_filter('kingster_center_menu_item', 'kingster_get_logo');
			?>
			</div><!-- kingster-navigation -->

		</div><!-- kingster-header-inner -->
	</div><!-- kingster-header-container -->
</header><!-- header -->