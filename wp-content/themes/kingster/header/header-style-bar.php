<?php
	/* a template for displaying the header area */

	// header container
	$body_layout = kingster_get_option('general', 'layout', 'full');
	$body_margin = kingster_get_option('general', 'body-margin', '0px');
	$header_width = kingster_get_option('general', 'header-width', 'boxed');
	$header_style = kingster_get_option('general', 'header-bar-navigation-align', 'center');
	$header_background_style = kingster_get_option('general', 'header-background-style', 'solid');

	$header_wrap_class = '';
	if( $header_style == 'center-logo' ){
		$header_wrap_class .= ' kingster-style-center';
	}else{
		$header_wrap_class .= ' kingster-style-left';
	}

	$header_container_class = '';
	if( $header_width == 'boxed' ){
		$header_container_class .= ' kingster-container';
	}else if( $header_width == 'custom' ){
		$header_container_class .= ' kingster-header-custom-container';
	}else{
		$header_container_class .= ' kingster-header-full';
	}

	$navigation_wrap_class  = ' kingster-style-' . $header_background_style;
	$navigation_wrap_class .= ' kingster-sticky-navigation kingster-sticky-navigation-height';
	if( $header_style == 'center' || $header_style == 'center-logo' ){
		$navigation_wrap_class .= ' kingster-style-center';
	}else{
		$navigation_wrap_class .= ' kingster-style-left';
	}
	if( $body_layout == 'boxed' || $body_margin != '0px' ){
		$navigation_wrap_class .= ' kingster-style-slide';
	}else{
		$navigation_wrap_class .= '  kingster-style-fixed';
	}
	if( $header_background_style == 'transparent' ){
		$navigation_wrap_class .= ' kingster-without-placeholder';
	}

?>	
<header class="kingster-header-wrap kingster-header-style-bar kingster-header-background <?php echo esc_attr($header_wrap_class); ?>" >
	<div class="kingster-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="kingster-header-container-inner">
		<?php
			echo kingster_get_logo();

			$logo_right_text = kingster_get_option('general', 'logo-right-text');
			if( !empty($logo_right_text) ){
				echo '<div class="kingster-logo-right-text kingster-item-pdlr" >';
				echo gdlr_core_content_filter($logo_right_text);
				echo '</div>';
			}
		?>
		</div>
	</div>
</header><!-- header -->
<div class="kingster-navigation-bar-wrap <?php echo esc_attr($navigation_wrap_class); ?>" >
	<div class="kingster-navigation-background" ></div>
	<div class="kingster-navigation-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<?php
			$navigation_class = '';
			if( kingster_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
				$navigation_class .= 'kingster-navigation-submenu-indicator ';
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
			if( $header_style == 'center' || $header_style == 'center-logo' ){
				$menu_right_class = ' kingster-item-mglr kingster-navigation-top';
			}

			// menu right side
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
					echo '<div class="kingster-main-menu-cart" id="kingster-main-menu-cart" >';
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
				if( has_nav_menu('right_menu') ){
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
			}
		?>
		</div><!-- kingster-navigation -->

	</div><!-- kingster-header-container -->
</div><!-- kingster-navigation-bar-wrap -->