<?php
	/* a template for displaying the header area */
?>	
<header class="kingster-header-wrap kingster-header-style-side-toggle" >
	<?php
		$display_logo = kingster_get_option('general', 'header-side-toggle-display-logo', 'enable');
		if( $display_logo == 'enable' ){
			echo kingster_get_logo(array('padding' => false));
		}

		$navigation_class = '';
		if( kingster_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
			$navigation_class = 'kingster-navigation-submenu-indicator ';
		}
	?>
	<div class="kingster-navigation clearfix <?php echo esc_attr($navigation_class); ?>" >
	<?php
		// print main menu
		if( has_nav_menu('main_menu') ){
			kingster_get_custom_menu(array(
				'container-class' => 'kingster-main-menu',
				'button-class' => 'kingster-side-menu-icon',
				'icon-class' => 'fa fa-bars',
				'id' => 'kingster-main-menu',
				'theme-location' => 'main_menu',
				'type' => kingster_get_option('general', 'header-side-toggle-menu-type', 'overlay')
			));
		}
	?>
	</div><!-- kingster-navigation -->
	<?php

		// menu right side
		$enable_search = (kingster_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
		$enable_cart = (kingster_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
		if( $enable_search || $enable_cart ){ 
			echo '<div class="kingster-header-icon kingster-pos-bottom" >';

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

			echo '</div>'; // kingster-main-menu-right-wrap
		}

	?>
</header><!-- header -->