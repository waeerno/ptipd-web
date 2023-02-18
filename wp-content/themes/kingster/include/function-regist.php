<?php 
	/*	
	*	Goodlayers Function Inclusion File
	*	---------------------------------------------------------------------
	*	This file contains the script to includes necessary function to the theme
	*	---------------------------------------------------------------------
	*/

	// Set the content width based on the theme's design and stylesheet.
	if( !isset($content_width) ){
		$content_width = str_replace('px', '', '1150px'); 
	}

	// Add body class for page builder
	add_filter('body_class', 'kingster_body_class');
	if( !function_exists('kingster_body_class') ){
		function kingster_body_class( $classes ) {
			$classes[] = 'kingster-body';
			$classes[] = 'kingster-body-front';

			// layout class
			$layout = kingster_get_option('general', 'layout', 'full');
			if( $layout == 'boxed' ){
			 	$classes[] = 'kingster-boxed';

			 	$border = kingster_get_option('general', 'enable-boxed-border', 'disable');
			 	if( $border == 'enable' ){
			 		$classes[] = 'kingster-boxed-border';
			 	}
			}else{
				$classes[] = 'kingster-full';
			}

			// background class
			if( $layout == 'boxed' ){
				$post_option = kingster_get_post_option(get_the_ID());
				if( empty($post_option['body-background-type']) || $post_option['body-background-type'] == 'default' ){
					$background = kingster_get_option('general', 'background-type', 'color');
				 	if( $background == 'pattern' ){
				 		$classes[] = 'kingster-background-pattern';
				 	}
				}
			}

			// header style
			$header_style = kingster_get_option('general', 'header-style', 'plain');
			if( !in_array($header_style, array('side', 'side-toggle')) ){
				if( is_page() ){
					$post_option = kingster_get_post_option(get_the_ID());
				}

				if( empty($post_option['sticky-navigation']) || $post_option['sticky-navigation'] == 'default' ){
					$sticky_menu = kingster_get_option('general', 'enable-main-navigation-sticky', 'enable');
				}else{
					$sticky_menu = $post_option['sticky-navigation'];
				}
				if( $sticky_menu == 'enable' ){
					$classes[] = ' kingster-with-sticky-navigation';
					
					$sticky_menu_logo = kingster_get_option('general', 'enable-logo-on-main-navigation-sticky', 'enable');
					if( $sticky_menu_logo == 'disable' ){
						$classes[] = ' kingster-sticky-navigation-no-logo';
					}
				}
			}

			// blog style
			if( is_single() && get_post_type() == 'post' ){
				$blog_style = kingster_get_option('general', 'blog-style', 'style-1');
				$classes[] = ' kingster-blog-' . $blog_style;
			}

			// blockquote style
			$blockquote_style = kingster_get_option('general', 'blockquote-style', 'style-1');
			$classes[] = ' kingster-blockquote-' . $blockquote_style;
			
			return $classes;
		}
	}

	// Set the neccessary function to be used in the theme
	add_action('after_setup_theme', 'kingster_theme_setup');
	if( !function_exists( 'kingster_theme_setup' ) ){
		function kingster_theme_setup(){
			
			// define textdomain for translation
			load_theme_textdomain('kingster', get_template_directory() . '/languages');

			// add default posts and comments RSS feed links to head.
			add_theme_support('automatic-feed-links');

			// declare that this theme does not use a hard-coded <title> tag in <head>
			add_theme_support('title-tag');

			// tmce editor stylesheet
			add_editor_style('/css/editor-style.css');

			// define menu locations
			register_nav_menus(array(
				'main_menu' => esc_html__('Primary Menu', 'kingster'),
				'right_menu' => esc_html__('Secondary Menu', 'kingster'),
				'top_bar_menu' => esc_html__('Top Bar Menu', 'kingster'),
				'mobile_menu' => esc_html__('Mobile Menu', 'kingster'),
			));

			// enable support for post formats / thumbnail
			add_theme_support('post-thumbnails');
			add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio')); // 'status', 'chat'
			
			// switch default core markup
			add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
			
			// add custom image size
			$thumbnail_sizes = kingster_get_option('plugin', 'thumbnail-sizing');
			if( !empty($thumbnail_sizes) ){
				foreach( $thumbnail_sizes as $thumbnail_size ){
					add_image_size($thumbnail_size['name'], $thumbnail_size['width'], $thumbnail_size['height'], true);
				}
			}

		}
	}

	// turn the page comment off by default
	add_filter( 'wp_insert_post_data', 'kingster_page_default_comments_off' );
	if( !function_exists('kingster_page_default_comments_off') ){
		function kingster_page_default_comments_off( $data ) {
			if( $data['post_type'] == 'page' && $data['post_status'] == 'auto-draft' ) {
				$data['comment_status'] = 0;
			} 

			return $data;
		}
	}

	// top bar menu
	if( !function_exists('kingster_get_top_bar_menu') ){
		function kingster_get_top_bar_menu($position = 'left'){
			if( has_nav_menu('top_bar_menu') ){
				wp_nav_menu(array(
					'menu_id' => 'kingster-top-bar-menu',
					'theme_location'=>'top_bar_menu', 
					'container'=> '', 
					'menu_class'=> 'sf-menu kingster-top-bar-menu kingster-top-bar-' . esc_attr($position) . '-menu',
					'walker' => new kingster_menu_walker()
				));
			}
		}
	}

	// logo displaying
	if( !function_exists('kingster_get_logo') ){
		function kingster_get_logo($settings = array()){

			$extra_class  = (isset($settings['padding']) && $settings['padding'] === false)? '': ' kingster-item-pdlr';
			$extra_class .= empty($settings['wrapper-class'])? '': ' ' . $settings['wrapper-class'];
			
			$ret  = '<div class="kingster-logo ' . esc_attr($extra_class) . '">';
			$ret .= '<div class="kingster-logo-inner">';
		
			// fixed nav logo
			$orig_logo_class = ''; 
			if( empty($settings['mobile']) ){
				$enable_fixed_nav = kingster_get_option('general', 'enable-main-navigation-sticky', 'enable');
				$fixed_nav_sticky = kingster_get_option('general', 'enable-logo-on-main-navigation-sticky', 'enable');
				$fixed_nav_logo = kingster_get_option('general', 'fixed-navigation-bar-logo', '');
				if( $enable_fixed_nav == 'enable' && $fixed_nav_sticky == 'enable' && !empty($fixed_nav_logo) ){
					$ret .= '<a class="kingster-fixed-nav-logo" href="' . esc_url(home_url('/')) . '" >';
					$ret .= gdlr_core_get_image($fixed_nav_logo);
					$ret .= '</a>';

					$orig_logo_class = ' kingster-orig-logo'; 
				}
			}
		
			// print logo / mobile logo
			if( !empty($settings['mobile']) ){
				$logo_id = kingster_get_option('general', 'mobile-logo');
			} 
			if( empty($logo_id) ){
				$logo_id = kingster_get_option('general', 'logo');
			}
			if( is_numeric($logo_id) && !wp_attachment_is_image($logo_id) ){
				$logo_id = '';
			}
			$ret .= '<a class="' . esc_attr($orig_logo_class) . '" href="' . esc_url(home_url('/')) . '" >';
			if( empty($logo_id) ){
				if( !empty($settings['mobile']) && file_exists(get_template_directory() . '/images/logo-mobile.png') ){
					$ret .= gdlr_core_get_image(get_template_directory_uri() . '/images/logo-mobile.png');
				}else{
					$ret .= gdlr_core_get_image(get_template_directory_uri() . '/images/logo.png');
				}
			}else{
				$ret .= gdlr_core_get_image($logo_id);
			}
			$ret .= '</a>';

			$ret .= '</div>';
			$ret .= '</div>';

			return $ret;
		}	
	}

	// set anchor color
	add_action('wp_enqueue_scripts', 'kingster_set_anchor_color', 11);
	if( !function_exists('kingster_set_anchor_color') ){
		function kingster_set_anchor_color(){
			$post_option = kingster_get_post_option(get_the_ID());

			$anchor_css = '';
			if( !empty($post_option['bullet-anchor']) ){
				foreach( $post_option['bullet-anchor'] as $anchor ){
					if( !empty($anchor['title']) ){
						$anchor_section = str_replace('#', '', $anchor['title']);

						if( !empty($anchor['anchor-color']) ){
							$anchor_css .= '.kingster-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:before{ background-color: ' . esc_html($anchor['anchor-color']) . '; }';
						}
						if( !empty($anchor['anchor-hover-color']) ){
							$anchor_css .= '.kingster-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:hover, ';
							$anchor_css .= '.kingster-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a.current-menu-item{ border-color: ' . esc_html($anchor['anchor-hover-color']) . '; }';
							$anchor_css .= '.kingster-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a:hover:before, ';
							$anchor_css .= '.kingster-bullet-anchor[data-anchor-section="' . esc_attr($anchor_section) . '"] a.current-menu-item:before{ background: ' . esc_html($anchor['anchor-hover-color']) . '; }';
						}
					}
				}
			}

			if( !empty($anchor_css) ){
				wp_add_inline_style('kingster-style-core', $anchor_css);
			}
		}
	}

	// remove id from nav menu item
	add_filter('nav_menu_item_id', 'kingster_nav_menu_item_id', 10, 4);
	if( !function_exists('kingster_nav_menu_item_id') ){
		function kingster_nav_menu_item_id( $id, $item, $args, $depth ){
			return '';
		}
	}

	// add additional script
	add_action('wp_head', 'kingster_header_script', 99);
	if( !function_exists('kingster_header_script') ){
		function kingster_header_script(){
			$header_script = kingster_get_option('plugin', 'additional-head-script', '');
			if( !empty($header_script) ){
				echo '<script>' . $header_script . '</script>';
			}

			$header_script2 = kingster_get_option('plugin', 'additional-head-script2', '');
			if( !empty($header_script2) ){
				echo gdlr_core_text_filter($header_script2);
			}

		}
	}
	add_action('wp_footer', 'kingster_footer_script');
	if( !function_exists('kingster_footer_script') ){
		function kingster_footer_script(){
			$footer_script = kingster_get_option('plugin', 'additional-script', '');
			if( !empty($footer_script) ){
				echo '<script>' . $footer_script . '</script>';
			}

		}
	}

	remove_action('tgmpa_register', 'newsletter_register_required_plugins');