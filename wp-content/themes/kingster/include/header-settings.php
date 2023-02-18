<?php

	add_filter('gdlr_core_enable_header_post_type', 'kingster_gdlr_core_enable_header_post_type');
	if( !function_exists('kingster_gdlr_core_enable_header_post_type') ){
		function kingster_gdlr_core_enable_header_post_type( $args ){
			return true;
		}
	}
	
	add_filter('gdlr_core_header_options', 'kingster_gdlr_core_header_options', 10, 2);
	if( !function_exists('kingster_gdlr_core_header_options') ){
		function kingster_gdlr_core_header_options( $options, $with_default = true ){

			// get option
			$options = array(
				'top-bar' => kingster_top_bar_options(),
				'top-bar-social' => kingster_top_bar_social_options(),			
				'header' => kingster_header_options(),
				'logo' => kingster_logo_options(),
				'navigation' => kingster_navigation_options(), 
				'fixed-navigation' => kingster_fixed_navigation_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = kingster_get_option('general', $key);
					}
				}
			} 
			
			return $options;
		}
	}
	
	add_filter('gdlr_core_header_color_options', 'kingster_gdlr_core_header_color_options', 10, 2);
	if( !function_exists('kingster_gdlr_core_header_color_options') ){
		function kingster_gdlr_core_header_color_options( $options, $with_default = true ){

			$options = array(
				'header-color' => kingster_header_color_options(), 
				'navigation-menu-color' => kingster_navigation_color_options(), 		
				'navigation-right-color' => kingster_navigation_right_color_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = kingster_get_option('color', $key);
					}
				}
			}

			return $options;
		}
	}

	add_action('wp_head', 'kingster_set_custom_header');
	if( !function_exists('kingster_set_custom_header') ){
		function kingster_set_custom_header(){
			kingster_get_option('general', 'layout', '');
			
			$header_id = get_post_meta(get_the_ID(), 'gdlr_core_custom_header_id', true);
			if( empty($header_id) ){
				$header_id = kingster_get_option('general', 'custom-header', '');
			}

			if( !empty($header_id) ){
				$option = 'kingster_general';
				$header_options = get_post_meta($header_id, 'gdlr-core-header-settings', true);

				if( !empty($header_options) ){
					foreach( $header_options as $key => $value ){
						$GLOBALS[$option][$key] = $value;
					}
				}

				$header_css = get_post_meta($header_id, 'gdlr-core-custom-header-css', true);
				if( !empty($header_css) ){
					if( get_post_type() == 'page' ){
						$header_css = str_replace('.gdlr-core-page-id', '.page-id-' . get_the_ID(), $header_css);
					}else{
						$header_css = str_replace('.gdlr-core-page-id', '.postid-' . get_the_ID(), $header_css);
					}
					echo '<style type="text/css" >' . $header_css . '</style>';
				}
				

			}
		} // kingster_set_custom_header
	}

	// override menu on page option
	add_filter('wp_nav_menu_args', 'kingster_wp_nav_menu_args');
	if( !function_exists('kingster_wp_nav_menu_args') ){
		function kingster_wp_nav_menu_args($args){

			$kingster_locations = array('main_menu', 'right_menu', 'top_bar_menu', 'mobile_menu');
			if( !empty($args['theme_location']) && in_array($args['theme_location'], $kingster_locations) ){
				$menu_id = get_post_meta(get_the_ID(), 'gdlr-core-location-' . $args['theme_location'], true);
				
				if( !empty($menu_id) ){
					$args['menu'] = $menu_id;
					$args['theme_location'] = '';
				}
			}

			return $args;
		}
	}

	if( !function_exists('kingster_top_bar_options') ){
		function kingster_top_bar_options(){
			return array(
				'title' => esc_html__('Top Bar', 'kingster'),
				'options' => array(

					'enable-top-bar' => array(
						'title' => esc_html__('Enable Top Bar', 'kingster'),
						'type' => 'checkbox',
					),
					'enable-top-bar-on-mobile' => array(
						'title' => esc_html__('Enable Top Bar On Mobile', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'top-bar-width' => array(
						'title' => esc_html__('Top Bar Width', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'kingster'),
							'full' => esc_html__('Full', 'kingster'),
							'custom' => esc_html__('Custom', 'kingster'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-width-pixel' => array(
						'title' => esc_html__('Top Bar Width Pixel', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'custom' ),
						'selector' => '.kingster-top-bar-container.kingster-top-bar-custom-container{ max-width: #gdlr#; }'
					),
					'top-bar-full-side-padding' => array(
						'title' => esc_html__('Top Bar Full ( Left/Right ) Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.kingster-top-bar-container.kingster-top-bar-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'full' )
					),
					'top-bar-menu-position' => array(
						'title' => esc_html__('Top Bar Menu Position', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'none' => esc_html__('None', 'kingster'),
							'left' => esc_html__('Left', 'kingster'),
							'right' => esc_html__('Right', 'kingster'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-left-text' => array(
						'title' => esc_html__('Top Bar Left Text', 'kingster'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-text' => array(
						'title' => esc_html__('Top Bar Right Text', 'kingster'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-button-text' => array(
						'title' => esc_html__('Top Bar Right Button Text', 'kingster'),
						'type' => 'text',
						'default' => esc_html__('Support KU', 'kingster'),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-button-link' => array(
						'title' => esc_html__('Top Bar Right Button Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-button-target' => array(
						'title' => esc_html__('Top Bar Right Button Target', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'kingster'),
							'_blank' => esc_html__('New Window', 'kingster'),
						),
						'default' => '_blank',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-top-padding' => array(
						'title' => esc_html__('Top Bar Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
 						'default' => '10px',
						'selector' => '.kingster-top-bar{ padding-top: #gdlr#; }' . 
							'.kingster-top-bar-right-button{ padding-top: #gdlr#; margin-top: -#gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-padding' => array(
						'title' => esc_html__('Top Bar Bottom Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '10px',
						'selector' => '.kingster-top-bar{ padding-bottom: #gdlr#; }' .
							'.kingster-top-bar .kingster-top-bar-menu > li > a{ padding-bottom: #gdlr#; }' .  
							'.sf-menu.kingster-top-bar-menu > .kingster-mega-menu .sf-mega, .sf-menu.kingster-top-bar-menu > .kingster-normal-menu ul{ margin-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-text-size' => array(
						'title' => esc_html__('Top Bar Text Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.kingster-top-bar{ font-size: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border' => array(
						'title' => esc_html__('Top Bar Bottom Border', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.kingster-top-bar{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),

				)
			);
		}
	}

	if( !function_exists('kingster_top_bar_social_options') ){
		function kingster_top_bar_social_options(){
			return array(
				'title' => esc_html__('Top Bar Social', 'kingster'),
				'options' => array(
					'enable-top-bar-social' => array(
						'title' => esc_html__('Enable Top Bar Social', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'top-bar-social-delicious' => array(
						'title' => esc_html__('Top Bar Social Delicious Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-email' => array(
						'title' => esc_html__('Top Bar Social Email Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-deviantart' => array(
						'title' => esc_html__('Top Bar Social Deviantart Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-digg' => array(
						'title' => esc_html__('Top Bar Social Digg Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-facebook' => array(
						'title' => esc_html__('Top Bar Social Facebook Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-flickr' => array(
						'title' => esc_html__('Top Bar Social Flickr Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-google-plus' => array(
						'title' => esc_html__('Top Bar Social Google Plus Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-lastfm' => array(
						'title' => esc_html__('Top Bar Social Lastfm Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-linkedin' => array(
						'title' => esc_html__('Top Bar Social Linkedin Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-pinterest' => array(
						'title' => esc_html__('Top Bar Social Pinterest Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-rss' => array(
						'title' => esc_html__('Top Bar Social RSS Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-skype' => array(
						'title' => esc_html__('Top Bar Social Skype Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-stumbleupon' => array(
						'title' => esc_html__('Top Bar Social Stumbleupon Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tumblr' => array(
						'title' => esc_html__('Top Bar Social Tumblr Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-twitter' => array(
						'title' => esc_html__('Top Bar Social Twitter Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-vimeo' => array(
						'title' => esc_html__('Top Bar Social Vimeo Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-youtube' => array(
						'title' => esc_html__('Top Bar Social Youtube Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-instagram' => array(
						'title' => esc_html__('Top Bar Social Instagram Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-snapchat' => array(
						'title' => esc_html__('Top Bar Social Snapchat Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),

				)
			);
		}
	}

	if( !function_exists('kingster_header_options') ){
		function kingster_header_options(){
			return array(
				'title' => esc_html__('Header', 'kingster'),
				'options' => array(

					'header-style' => array(
						'title' => esc_html__('Header Style', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'kingster'),
							'bar' => esc_html__('Bar', 'kingster'),
							'boxed' => esc_html__('Boxed', 'kingster'),
							'side' => esc_html__('Side Menu', 'kingster'),
							'side-toggle' => esc_html__('Side Menu Toggle', 'kingster'),
						),
						'default' => 'plain',
					),
					'header-plain-style' => array(
						'title' => esc_html__('Header Plain Style', 'kingster'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/plain-menu-right.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/plain-center-logo.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/plain-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/plain-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'plain' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-plain-bottom-shadow' => array(
						'title' => esc_html__('Header Bottom Shadow', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'header-style' => 'plain' )
					),
					'header-plain-bottom-border' => array(
						'title' => esc_html__('Plain Header Bottom Border', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.kingster-header-style-plain{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain') )
					),
					'header-bar-navigation-align' => array(
						'title' => esc_html__('Header Bar Style', 'kingster'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-background-style' => array(
						'title' => esc_html__('Header/Navigation Background Style', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'solid' => esc_html__('Solid', 'kingster'),
							'transparent' => esc_html__('Transparent', 'kingster'),
						),
						'default' => 'solid',
						'condition' => array( 'header-style' => array('plain', 'bar') )
					),
					'top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.kingster-header-background-transparent .kingster-top-bar-background{ opacity: #gdlr#; }'
					),
					'header-background-opacity' => array(
						'title' => esc_html__('Header Background Opacity', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.kingster-header-background-transparent .kingster-header-background{ opacity: #gdlr#; }'
					),
					'navigation-background-opacity' => array(
						'title' => esc_html__('Navigation Background Opacity', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'bar', 'header-background-style' => 'transparent' ),
						'selector' => '.kingster-navigation-bar-wrap.kingster-style-transparent .kingster-navigation-background{ opacity: #gdlr#; }'
					),
					'header-boxed-style' => array(
						'title' => esc_html__('Header Boxed Style', 'kingster'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/boxed-menu-right.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/boxed-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/boxed-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'boxed' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'boxed-top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '0',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.kingster-header-boxed-wrap .kingster-top-bar-background{ opacity: #gdlr#; }'
					),
					'boxed-top-bar-background-extend' => array(
						'title' => esc_html__('Top Bar Background Extend ( Bottom )', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.kingster-header-boxed-wrap .kingster-top-bar-background{ margin-bottom: -#gdlr#; }'
					),
					'boxed-header-top-margin' => array(
						'title' => esc_html__('Header Top Margin', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.kingster-header-style-boxed{ margin-top: #gdlr#; }'
					),
					'header-side-style' => array(
						'title' => esc_html__('Header Side Style', 'kingster'),
						'type' => 'radioimage',
						'options' => array(
							'top-left' => get_template_directory_uri() . '/images/header/side-top-left.jpg',
							'middle-left' => get_template_directory_uri() . '/images/header/side-middle-left.jpg',
							'middle-left-2' => get_template_directory_uri() . '/images/header/side-middle-left-2.jpg',
							'top-right' => get_template_directory_uri() . '/images/header/side-top-right.jpg',
							'middle-right' => get_template_directory_uri() . '/images/header/side-middle-right.jpg',
							'middle-right-2' => get_template_directory_uri() . '/images/header/side-middle-right-2.jpg',
						),
						'default' => 'top-left',
						'condition' => array( 'header-style' => 'side' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-align' => array(
						'title' => esc_html__('Header Side Text Align', 'kingster'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'header-style' => 'side' )
					),
					'header-side-toggle-style' => array(
						'title' => esc_html__('Header Side Toggle Style', 'kingster'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/side-toggle-left.jpg',
							'right' => get_template_directory_uri() . '/images/header/side-toggle-right.jpg',
						),
						'default' => 'left',
						'condition' => array( 'header-style' => 'side-toggle' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-toggle-menu-type' => array(
						'title' => esc_html__('Header Side Toggle Menu Type', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'kingster'),
							'right' => esc_html__('Right Slide Menu', 'kingster'),
							'overlay' => esc_html__('Overlay Menu', 'kingster'),
						),
						'default' => 'overlay',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-side-toggle-display-logo' => array(
						'title' => esc_html__('Display Logo', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-width' => array(
						'title' => esc_html__('Header Width', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'kingster'),
							'full' => esc_html__('Full', 'kingster'),
							'custom' => esc_html__('Custom', 'kingster'),
						),
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'))
					),
					'header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'), 'header-width' => 'custom'),
						'selector' => '.kingster-header-container.kingster-header-custom-container{ max-width: #gdlr#; }'
					),
					'header-full-side-padding' => array(
						'title' => esc_html__('Header Full ( Left/Right ) Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.kingster-header-container.kingster-header-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array('header-style'=> array('plain', 'bar', 'boxed'), 'header-width'=>'full')
					),
					'boxed-header-frame-radius' => array(
						'title' => esc_html__('Header Frame Radius', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '3px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.kingster-header-boxed-wrap .kingster-header-background{ border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'boxed-header-content-padding' => array(
						'title' => esc_html__('Header Content ( Left/Right ) Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '30px',
						'selector' => '.kingster-header-style-boxed .kingster-header-container-item{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.kingster-navigation-right{ right: #gdlr#; } .kingster-navigation-left{ left: #gdlr#; }',
						'condition' => array( 'header-style' => 'boxed' )
					),
					'navigation-text-top-margin' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'plain', 'header-plain-style' => 'splitted-menu' ),
						'selector' => '.kingster-header-style-plain.kingster-style-splitted-menu .kingster-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.kingster-header-style-plain.kingster-style-splitted-menu .kingster-main-menu-left-wrap,' .
							'.kingster-header-style-plain.kingster-style-splitted-menu .kingster-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-top-margin-boxed' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed', 'header-boxed-style' => 'splitted-menu' ),
						'selector' => '.kingster-header-style-boxed.kingster-style-splitted-menu .kingster-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.kingster-header-style-boxed.kingster-style-splitted-menu .kingster-main-menu-left-wrap,' .
							'.kingster-header-style-boxed.kingster-style-splitted-menu .kingster-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-side-spacing' => array(
						'title' => esc_html__('Navigation Text Side ( Left / Right ) Spaces', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '30',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.kingster-navigation .sf-menu > li{ padding-left: #gdlr#; padding-right: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'boxed') )
					),
					'navigation-left-offset' => array(
						'title' => esc_html__('Navigation Left Offset Spaces', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '0',
						'selector' => '.kingster-navigation .kingster-main-menu{ margin-left: #gdlr#; }'
					),
					'navigation-slide-bar' => array(
						'title' => esc_html__('Navigation Slide Bar', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => array('plain', 'bar', 'boxed') )
					),
					'side-header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '600',
						'default' => '340px',
						'condition' => array('header-style' => array('side', 'side-toggle')),
						'selector' => '.kingster-header-side-nav{ width: #gdlr#; }' . 
							'.kingster-header-side-content.kingster-style-left{ margin-left: #gdlr#; }' .
							'.kingster-header-side-content.kingster-style-right{ margin-right: #gdlr#; }'
					),
					'side-header-side-padding' => array(
						'title' => esc_html__('Header Side Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '70px',
						'condition' => array('header-style' => 'side'),
						'selector' => '.kingster-header-side-nav.kingster-style-side{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.kingster-header-side-nav.kingster-style-left .sf-vertical > li > ul.sub-menu{ padding-left: #gdlr#; }' .
							'.kingster-header-side-nav.kingster-style-right .sf-vertical > li > ul.sub-menu{ padding-right: #gdlr#; }'
					),
					'navigation-text-top-spacing' => array(
						'title' => esc_html__('Navigation Text Top / Bottom Spaces', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => ' .kingster-navigation .sf-vertical > li{ padding-top: #gdlr#; padding-bottom: #gdlr#; }',
						'condition' => array( 'header-style' => array('side') )
					),
					'logo-right-text' => array(
						'title' => esc_html__('Header Right Text', 'kingster'),
						'type' => 'textarea',
						'condition' => array('header-style' => 'bar'),
					),
					'logo-right-text-top-padding' => array(
						'title' => esc_html__('Header Right Text Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '30px',
						'condition' => array('header-style' => 'bar'),
						'selector' => '.kingster-header-style-bar .kingster-logo-right-text{ padding-top: #gdlr#; }'
					),

				)
			);
		}
	}

	if( !function_exists('kingster_logo_options') ){
		function kingster_logo_options(){
			return array(
				'title' => esc_html__('Logo', 'kingster'),
				'options' => array(
					'logo' => array(
						'title' => esc_html__('Logo', 'kingster'),
						'type' => 'upload'
					),
					'logo-top-padding' => array(
						'title' => esc_html__('Logo Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.kingster-logo{ padding-top: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'kingster'),
					),
					'logo-bottom-padding' => array(
						'title' => esc_html__('Logo Bottom Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.kingster-logo{ padding-bottom: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'kingster'),
					),
					'logo-left-padding' => array(
						'title' => esc_html__('Logo Left Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-logo.kingster-item-pdlr{ padding-left: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'kingster'),
					),
					'max-logo-width' => array(
						'title' => esc_html__('Max Logo Width', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '200px',
						'selector' => '.kingster-logo-inner{ max-width: #gdlr#; }'
					),

					'mobile-logo' => array(
						'title' => esc_html__('Mobile/Tablet Logo', 'kingster'),
						'type' => 'upload',
						'description' => esc_html__('Leave this option blank to use the same logo.', 'kingster'),
					),
					'max-tablet-logo-width' => array(
						'title' => esc_html__('Max Tablet Logo Width', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 1260px){ .kingster-mobile-header .kingster-logo-inner{ max-width: #gdlr#; } }'
					),
					'max-mobile-logo-width' => array(
						'title' => esc_html__('Max Mobile Logo Width', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-mobile-header .kingster-logo-inner{ max-width: #gdlr#; } }'
					),
					'mobile-logo-position' => array(
						'title' => esc_html__('Mobile Logo Position', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'logo-left' => esc_html__('Logo Left', 'kingster'),
							'logo-center' => esc_html__('Logo Center', 'kingster'),
							'logo-right' => esc_html__('Logo Right', 'kingster'),
						)
					),
				
				)
			);
		}
	}

	if( !function_exists('kingster_navigation_options') ){
		function kingster_navigation_options(){
			return array(
				'title' => esc_html__('Navigation', 'kingster'),
				'options' => array(
					'main-navigation-top-padding' => array(
						'title' => esc_html__('Main Navigation Top Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '25px',
						'selector' => '.kingster-navigation{ padding-top: #gdlr#; }' . 
							'.kingster-navigation-top{ top: #gdlr#; }'
					),
					'main-navigation-bottom-padding' => array(
						'title' => esc_html__('Main Navigation Bottom Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.kingster-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }'
					),
					'main-navigation-item-right-padding' => array(
						'title' => esc_html__('Main Navigation Item Right Padding', 'kingster'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.kingster-navigation .kingster-main-menu{ padding-right: #gdlr#; }'
					),
					'main-navigation-right-padding' => array(
						'title' => esc_html__('Main Navigation Wrap Right Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-navigation.kingster-item-pdlr{ padding-right: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'kingster'),
					),
					'enable-main-navigation-submenu-indicator' => array(
						'title' => esc_html__('Enable Main Navigation Submenu Indicator', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'navigation-right-top-margin' => array(
						'title' => esc_html__('Navigation Right ( search/cart/button ) Top Margin ', 'kingster'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.kingster-main-menu-right-wrap{ margin-top: #gdlr#; }'
					),
					'enable-main-navigation-search' => array(
						'title' => esc_html__('Enable Main Navigation Search', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'enable-main-navigation-cart' => array(
						'title' => esc_html__('Enable Main Navigation Cart ( Woocommerce )', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('The icon only shows if the woocommerce plugin is activated', 'kingster')
					),
					'enable-main-navigation-right-button' => array(
						'title' => esc_html__('Enable Main Navigation Right Button', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('This option will be ignored on header side style', 'kingster')
					),
					'main-navigation-right-button-style' => array(
						'title' => esc_html__('Main Navigation Right Button Style', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'default' => esc_html__('Default', 'kingster'),
							'round' => esc_html__('Round', 'kingster'),
							'round-with-shadow' => esc_html__('Round With Shadow', 'kingster'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-text' => array(
						'title' => esc_html__('Main Navigation Right Button Text', 'kingster'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'kingster'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link' => array(
						'title' => esc_html__('Main Navigation Right Button Link', 'kingster'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'kingster'),
							'_blank' => esc_html__('New Window', 'kingster'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'right-menu-type' => array(
						'title' => esc_html__('Secondary/Mobile Menu Type', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'kingster'),
							'right' => esc_html__('Right Slide Menu', 'kingster'),
							'overlay' => esc_html__('Overlay Menu', 'kingster'),
						),
						'default' => 'right'
					),
					'right-menu-style' => array(
						'title' => esc_html__('Secondary/Mobile Menu Style', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'hamburger-with-border' => esc_html__('Hamburger With Border', 'kingster'),
							'hamburger' => esc_html__('Hamburger', 'kingster'),
						),
						'default' => 'hamburger-with-border'
					),
					
				) // logo-options
			);
		}
	}

	if( !function_exists('kingster_fixed_navigation_options') ){
		function kingster_fixed_navigation_options(){
			return array(
				'title' => esc_html__('Fixed Navigation', 'kingster'),
				'options' => array(

					'enable-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Fixed Navigation Bar', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'enable-logo-on-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Logo on Fixed Navigation Bar', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-bar-logo' => array(
						'title' => esc_html__('Fixed Navigation Bar Logo', 'kingster'),
						'type' => 'upload',
						'description' => esc_html__('Leave blank to show default logo', 'kingster'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable', 'enable-logo-on-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-max-logo-width' => array(
						'title' => esc_html__('Fixed Navigation Max Logo Width', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.kingster-fixed-navigation.kingster-style-slide .kingster-logo-inner img{ max-height: none !important; }' .
							'.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-logo-inner, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-logo-inner{ max-width: #gdlr#; }'
					),
					'fixed-navigation-logo-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Top Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-logo, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-logo{ padding-top: #gdlr#; }'
					),
					'fixed-navigation-logo-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Bottom Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-logo, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-logo{ padding-bottom: #gdlr#; }'
					),
					'fixed-navigation-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Top Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '30px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-navigation, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-navigation{ padding-top: #gdlr#; }' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-navigation-top, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-navigation-top{ top: #gdlr#; }'
					),
					'fixed-navigation-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Bottom Padding', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '25px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.kingster-animate-fixed-navigation.kingster-header-style-plain .kingster-navigation .sf-menu > li > a, ' . 
							'.kingster-animate-fixed-navigation.kingster-header-style-boxed .kingster-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }'
					),
					'fixed-navigation-right-top-margin' => array(
						'title' => esc_html__('Fixed Navigation Right ( search/cart/button ) Top Margin ', 'kingster'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.kingster-header-wrap.kingster-fixed-navigation .kingster-main-menu-right-wrap{ margin-top: #gdlr#; }'
					),
					'fixed-navigation-anchor-offset' => array(
						'title' => esc_html__('Fixed Navigation Anchor Offset ( Fixed Navigation Height )', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '75px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
					),
					'enable-mobile-navigation-sticky' => array(
						'title' => esc_html__('Enable Mobile Fixed Navigation Bar', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable',
					),

				)
			);
		}
	}

	if( !function_exists('kingster_header_color_options') ){
		function kingster_header_color_options(){

			return array(
				'title' => esc_html__('Header', 'kingster'),
				'options' => array(
					
					'top-bar-background-color' => array(
						'title' => esc_html__('Top Bar Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#222222',
						'selector' => '.kingster-top-bar-background{ background-color: #gdlr#; }'
					),
					'top-bar-bottom-border-color' => array(
						'title' => esc_html__('Top Bar Bottom Border Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-body .kingster-top-bar{ border-bottom-color: #gdlr#; }'
					),
					'top-bar-text-color' => array(
						'title' => esc_html__('Top Bar Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-top-bar{ color: #gdlr#; }'
					),
					'top-bar-link-color' => array(
						'title' => esc_html__('Top Bar Link Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-body .kingster-top-bar a{ color: #gdlr#; }'
					),
					'top-bar-link-hover-color' => array(
						'title' => esc_html__('Top Bar Link Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-body .kingster-top-bar a:hover{ color: #gdlr#; }'
					),
					'top-bar-right-button-background-color' => array(
						'title' => esc_html__('Top Bar Right Button Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#3db166',
						'selector' => '.kingster-body .kingster-top-bar .kingster-top-bar-right-button{ background-color: #gdlr#; }'
					),
					'top-bar-social-color' => array(
						'title' => esc_html__('Top Bar Social Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-top-bar .kingster-top-bar-right-social a{ color: #gdlr#; }'
					),
					'top-bar-social-hover-color' => array(
						'title' => esc_html__('Top Bar Social Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#e44444',
						'selector' => '.kingster-top-bar .kingster-top-bar-right-social a:hover{ color: #gdlr#; }'
					),
					'header-background-color' => array(
						'title' => esc_html__('Header Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-header-background, .kingster-sticky-menu-placeholder, .kingster-header-style-boxed.kingster-fixed-navigation{ background-color: #gdlr#; }'
					),
					'header-plain-bottom-border-color' => array(
						'title' => esc_html__('Header Bottom Border Color ( Header Plain Style )', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.kingster-header-wrap.kingster-header-style-plain{ border-color: #gdlr#; }'
					),
					'logo-background-color' => array(
						'title' => esc_html__('Logo Background Color ( Header Side Menu Toggle Style )', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.kingster-header-side-nav.kingster-style-side-toggle .kingster-logo{ background-color: #gdlr#; }'
					),
					'secondary-menu-icon-color' => array(
						'title' => esc_html__('Secondary Menu Icon Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.kingster-top-menu-button i, .kingster-mobile-menu-button i{ color: #gdlr#; }' . 
							'.kingster-mobile-button-hamburger:before, ' . 
							'.kingster-mobile-button-hamburger:after, ' . 
							'.kingster-mobile-button-hamburger span{ background: #gdlr#; }'
					),
					'secondary-menu-border-color' => array(
						'title' => esc_html__('Secondary Menu Border Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#dddddd',
						'selector'=> '.kingster-main-menu-right .kingster-top-menu-button, .kingster-mobile-menu .kingster-mobile-menu-button{ border-color: #gdlr#; }'
					),
					'search-overlay-background-color' => array(
						'title' => esc_html__('Search Overlay Background Color', 'kingster'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.kingster-top-search-wrap{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'
					),
					'top-cart-background-color' => array(
						'title' => esc_html__('Top Cart Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#303030',
						'selector'=> '.kingster-top-cart-content-wrap .kingster-top-cart-content{ background-color: #gdlr#; }'
					),
					'top-cart-text-color' => array(
						'title' => esc_html__('Top Cart Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#b5b5b5',
						'selector'=> '.kingster-top-cart-content-wrap .kingster-top-cart-content span, ' .
							'.kingster-top-cart-content-wrap .kingster-top-cart-content span.woocommerce-Price-amount.amount{ color: #gdlr#; }'
					),
					'top-cart-view-cart-color' => array(
						'title' => esc_html__('Top Cart : View Cart Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.kingster-top-cart-content-wrap .kingster-top-cart-button,' .
							'.kingster-top-cart-content-wrap .kingster-top-cart-button:hover{ color: #gdlr#; }'
					),
					'top-cart-checkout-color' => array(
						'title' => esc_html__('Top Cart : Checkout Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector'=> '.kingster-top-cart-content-wrap .kingster-top-cart-checkout-button, ' .
							'.kingster-top-cart-content-wrap .kingster-top-cart-checkout-button:hover{ color: #gdlr#; }'
					),
					'breadcrumbs-text-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Color', 'kingster'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#c0c0c0',
						'selector'=> '.kingster-body .kingster-breadcrumbs, .kingster-body .kingster-breadcrumbs a span, ' . 
							'.gdlr-core-breadcrumbs-item, .gdlr-core-breadcrumbs-item a span{ color: #gdlr#; }'
					),
					'breadcrumbs-text-active-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Active Color', 'kingster'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#777777',
						'selector'=> '.kingster-body .kingster-breadcrumbs span, .kingster-body .kingster-breadcrumbs a:hover span, ' . 
							'.gdlr-core-breadcrumbs-item span, .gdlr-core-breadcrumbs-item a:hover span{ color: #gdlr#; }'
					),

				) // header-options
			);

		}
	}

	if( !function_exists('kingster_navigation_color_options') ){
		function kingster_navigation_color_options(){

			return array(
				'title' => esc_html__('Menu', 'kingster'),
				'options' => array(

					'navigation-bar-background-color' => array(
						'title' => esc_html__('Navigation Bar Background Color ( Header Bar Style )', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#f4f4f4',
						'selector' => '.kingster-navigation-background{ background-color: #gdlr#; }'
					),
					'navigation-bar-top-border-color' => array(
						'title' => esc_html__('Navigation Bar Top Border Color ( Header Bar Style )', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.kingster-navigation-bar-wrap{ border-color: #gdlr#; }'
					),
					'navigation-slide-bar-color' => array(
						'title' => esc_html__('Navigation Slide Bar Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.kingster-navigation .kingster-navigation-slide-bar{ border-color: #gdlr#; }' . 
							'.kingster-navigation .kingster-navigation-slide-bar:before{ border-bottom-color: #gdlr#; }'
					),
					'main-menu-text-color' => array(
						'title' => esc_html__('Main Menu Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#999999',
						'selector' => '.sf-menu > li > a, .sf-vertical > li > a{ color: #gdlr#; }'
					),
					'main-menu-text-hover-color' => array(
						'title' => esc_html__('Main Menu Text Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector' => '.sf-menu > li > a:hover, ' . 
							'.sf-menu > li.current-menu-item > a, ' .
							'.sf-menu > li.current-menu-ancestor > a, ' .
							'.sf-vertical > li > a:hover, ' . 
							'.sf-vertical > li.current-menu-item > a, ' .
							'.sf-vertical > li.current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-background-color' => array(
						'title' => esc_html__('Sub Menu Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#2e2e2e',
						'selector'=> '.sf-menu > .kingster-normal-menu li, .sf-menu > .kingster-mega-menu > .sf-mega, ' . 
							'.sf-vertical ul.sub-menu li, ul.sf-menu > .menu-item-language li{ background-color: #gdlr#; }'
					),
					'sub-menu-text-color' => array(
						'title' => esc_html__('Sub Menu Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#bebebe',
						'selector'=> '.sf-menu > li > .sub-menu a, .sf-menu > .kingster-mega-menu > .sf-mega a, ' . 
							'.sf-vertical ul.sub-menu li a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .kingster-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .kingster-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-background-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Background', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .kingster-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .kingster-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ background-color: #gdlr#; }'
					),
					'sub-mega-menu-title-color' => array(
						'title' => esc_html__('Sub Mega Menu Title Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.kingster-navigation .sf-menu > .kingster-mega-menu .sf-mega-section-inner > a{ color: #gdlr#; }'
					),
					'sub-mega-menu-divider-color' => array(
						'title' => esc_html__('Sub Mega Menu Divider Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.kingster-navigation .sf-menu > .kingster-mega-menu .sf-mega-section{ border-color: #gdlr#; }'
					),
					'side-menu-text-color' => array(
						'title' => esc_html__('Side Menu Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#979797',
						'selector'=> '.mm-navbar .mm-title, .mm-navbar .mm-btn, ul.mm-listview li > a, ul.mm-listview li > span{ color: #gdlr#; }' . 
							'ul.mm-listview li a{ border-color: #gdlr#; }' .
							'.mm-arrow:after, .mm-next:after, .mm-prev:before{ border-color: #gdlr#; }'
					),
					'side-menu-text-hover-color' => array(
						'title' => esc_html__('Side Menu Text Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.mm-navbar .mm-title:hover, .mm-navbar .mm-btn:hover, ' .
							'ul.mm-listview li a:hover, ul.mm-listview li > span:hover, ' . 
							'ul.mm-listview li.current-menu-item > a, ul.mm-listview li.current-menu-ancestor > a, ul.mm-listview li.current-menu-ancestor > span{ color: #gdlr#; }'
					),
					'side-menu-background-color' => array(
						'title' => esc_html__('Side Menu Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#1f1f1f',
						'selector'=> '.mm-menu{ background-color: #gdlr#; }'
					),
					'side-menu-border-color' => array(
						'title' => esc_html__('Side Menu Border Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#626262',
						'selector'=> 'ul.mm-listview li{ border-color: #gdlr#; }'
					),
					'overlay-menu-background-color' => array(
						'title' => esc_html__('Overlay Menu Background Color', 'kingster'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.kingster-overlay-menu-content{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'
					),
					'overlay-menu-border-color' => array(
						'title' => esc_html__('Overlay Menu Border Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.kingster-overlay-menu-content ul.menu > li, .kingster-overlay-menu-content ul.sub-menu ul.sub-menu{ border-color: #gdlr#; }'
					),
					'overlay-menu-text-color' => array(
						'title' => esc_html__('Overlay Menu Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.kingster-overlay-menu-content ul li a, .kingster-overlay-menu-content .kingster-overlay-menu-close{ color: #gdlr#; }'
					),
					'overlay-menu-text-hover-color' => array(
						'title' => esc_html__('Overlay Menu Text Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#a8a8a8',
						'selector'=> '.kingster-overlay-menu-content ul li a:hover{ color: #gdlr#; }'
					),
					'anchor-bullet-background-color' => array(
						'title' => esc_html__('Anchor Bullet Background', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#777777',
						'selector'=> '.kingster-bullet-anchor a:before{ background-color: #gdlr#; }'
					),
					'anchor-bullet-background-active-color' => array(
						'title' => esc_html__('Anchor Bullet Background Active', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.kingster-bullet-anchor a:hover, .kingster-bullet-anchor a.current-menu-item{ border-color: #gdlr#; }' .
							'.kingster-bullet-anchor a:hover:before, .kingster-bullet-anchor a.current-menu-item:before{ background: #gdlr#; }'
					),
					
										
				) // navigation-menu-options
			);	

		} // kingster_navigation_color_options
	}

	if( !function_exists('kingster_navigation_right_color_options') ){
		function kingster_navigation_right_color_options(){

			return array(
				'title' => esc_html__('Navigation Right', 'kingster'),
				'options' => array(

					'navigation-bar-right-icon-color' => array(
						'title' => esc_html__('Navigation Bar Right Icon Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.kingster-main-menu-search i, .kingster-main-menu-cart i{ color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-background' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Background', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector'=> '.kingster-main-menu-cart > .kingster-top-cart-count{ background-color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-color' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.kingster-main-menu-cart > .kingster-top-cart-count{ color: #gdlr#; }'
					),
					'navigation-right-button-text-color' => array(
						'title' => esc_html__('Navigation Right Button Text Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.kingster-body .kingster-main-menu-right-button{ color: #gdlr#; }'
					),
					'navigation-right-button-text-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Text Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.kingster-body .kingster-main-menu-right-button:hover{ color: #gdlr#; }'
					),
					'navigation-right-button-background-color' => array(
						'title' => esc_html__('Navigation Right Button Background Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.kingster-body .kingster-main-menu-right-button{ background-color: #gdlr#; }'
					),
					'navigation-right-button-background-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Background Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.kingster-body .kingster-main-menu-right-button:hover{ background-color: #gdlr#; }'
					),
					'navigation-right-button-border-color' => array(
						'title' => esc_html__('Navigation Right Button Border Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.kingster-body .kingster-main-menu-right-button{ border-color: #gdlr#; }'
					),
					'navigation-right-button-border-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Border Hover Color', 'kingster'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.kingster-body .kingster-main-menu-right-button:hover{ border-color: #gdlr#; }'
					),

				)
			);

		} // kingster_navigation_right_color_options
	}