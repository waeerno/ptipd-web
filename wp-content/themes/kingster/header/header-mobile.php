<?php
	// mobile menu template
	echo '<div class="kingster-mobile-header-wrap" >';

	// top bar
	$top_bar = kingster_get_option('general', 'enable-top-bar-on-mobile', 'disable');
	if( $top_bar == 'enable' ){
		get_template_part('header/header', 'top-bar');
	}

	// header
	$logo_position = kingster_get_option('general', 'mobile-logo-position', 'logo-left');
	$sticky_mobile_nav = kingster_get_option('general', 'enable-mobile-navigation-sticky', 'enable');
	echo '<div class="kingster-mobile-header kingster-header-background kingster-style-slide ';
	if($sticky_mobile_nav == 'enable'){
		echo 'kingster-sticky-mobile-navigation ';
	}
	echo '" id="kingster-mobile-header" >';
	echo '<div class="kingster-mobile-header-container kingster-container clearfix" >';
	echo kingster_get_logo(array(
		'mobile' => true,
		'wrapper-class' => ($logo_position == 'logo-center'? 'kingster-mobile-logo-center': '')
	));

	echo '<div class="kingster-mobile-menu-right" >';

	// search icon
	$enable_search = (kingster_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
	if( $enable_search ){
		echo '<div class="kingster-main-menu-search" id="kingster-mobile-top-search" >';
		echo '<i class="fa fa-search" ></i>';
		echo '</div>';
		kingster_get_top_search();
	}

	// cart icon
	$enable_cart = (kingster_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
	if( $enable_cart ){
		echo '<div class="kingster-main-menu-cart" id="kingster-mobile-menu-cart" >';
		echo '<i class="fa fa-shopping-cart" ></i>';
		kingster_get_woocommerce_bar();
		echo '</div>';
	}

	if( $logo_position == 'logo-center' ){
		echo '</div>';
		echo '<div class="kingster-mobile-menu-left" >';
	}

	// mobile menu
	if( has_nav_menu('mobile_menu') ){
		kingster_get_custom_menu(array(
			'type' => kingster_get_option('general', 'right-menu-type', 'right'),
			'container-class' => 'kingster-mobile-menu',
			'button-class' => 'kingster-mobile-menu-button',
			'icon-class' => 'fa fa-bars',
			'id' => 'kingster-mobile-menu',
			'theme-location' => 'mobile_menu'
		));
	}
	echo '</div>'; // kingster-mobile-menu-right/left
	echo '</div>'; // kingster-mobile-header-container
	echo '</div>'; // kingster-mobile-header

	echo '</div>'; // kingster-mobile-header-wrap