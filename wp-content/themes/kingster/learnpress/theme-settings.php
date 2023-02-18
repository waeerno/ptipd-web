<?php
	
	include_once(get_template_directory() . '/learnpress/kingster-lp-options.php');
	include_once(get_template_directory() . '/learnpress/pb/pb-element-lp-course-info.php');
	include_once(get_template_directory() . '/learnpress/pb/pb-element-lp-course-price.php');
	
	include_once(get_template_directory() . '/learnpress/pb/course-item.php');
	include_once(get_template_directory() . '/learnpress/pb/course-style.php');
	include_once(get_template_directory() . '/learnpress/pb/pb-element-lp-course-list.php');
	include_once(get_template_directory() . '/learnpress/pb/pb-element-lp-course-search.php');

	// remove ads
	add_action('admin_enqueue_scripts', 'kingster_lp_remove_admin_ads');
	function kingster_lp_remove_admin_ads( $hook ) {
		if( !class_exists('LearnPress') ) return;

	    if( in_array($hook, array('edit.php', 'admin.php')) ){
	        wp_enqueue_script('kingster-lp-remove', get_template_directory_uri() . '/learnpress/kingster-lp-remove.js', array());
	    }
	}

	add_filter('learn-press/admin-default-styles', 'kingster_lp_admin_default_styles');
	if( !function_exists('kingster_lp_admin_default_styles') ){
		function kingster_lp_admin_default_styles($styles){
			unset($styles['font-awesome']);
			return $styles;
		}
	}


	// add css
	add_action('wp_enqueue_scripts', 'kingster_learnpress_include_scripts', 9999);
	if( !function_exists('kingster_learnpress_include_scripts') ){
		function kingster_learnpress_include_scripts(){
			wp_enqueue_style('kingster-learnpress', get_template_directory_uri() . '/learnpress/kingster-learnpress.css', array());
			wp_enqueue_style('kingster-learnpress-pb', get_template_directory_uri() . '/learnpress/kingster-learnpress-pb.css', array());
		
			wp_enqueue_script('kingster-learnpress', get_template_directory_uri() . '/learnpress/kingster-learnpress.js');
		}
	}
	add_action('gdlr_core_load_page_builder_script', 'kingster_lp_gdlr_core_load_page_builder_script');
	if( !function_exists('kingster_lp_gdlr_core_load_page_builder_script') ){
		function kingster_lp_gdlr_core_load_page_builder_script(){
			wp_enqueue_style('kingster-learnpress-pb', get_template_directory_uri() . '/learnpress/kingster-learnpress-pb.css');
		}
	}

	// add page builder to courses and lessons
	if( is_admin() ){ add_filter('gdlr_core_page_builder_post_type', 'kingster_lp_gdlr_core_page_builder_post_type'); }
	if( !function_exists('kingster_lp_gdlr_core_page_builder_post_type') ){
		function kingster_lp_gdlr_core_page_builder_post_type( $post_type ){
			$post_type[] = 'lp_course';
			$post_type[] = 'lp_lesson';
			return $post_type;
		}
	}

	// inital page builder value
	if( is_admin() ){ add_filter('gdlr_core_lp_course_page_builder_val_init', 'kingster_lp_course_page_builder_val_init'); }
	if( !function_exists('kingster_lp_course_page_builder_val_init') ){
		function kingster_lp_course_page_builder_val_init( $value ){
			$value = '[{"template":"wrapper","type":"background","value":{"id":"","class":"","privacy":"","content-layout":"custom","max-width-wrapper":"","max-width":"1420px","enable-space":"disable","hide-this-wrapper-in":"none","animation":"none","animation-location":"0.8","z-index":"9","full-height":"disable","decrease-height":"0px","centering-content":"disable","background-type":"color","background-color-style":"plain","background-color":"","background-color-opacity":"1","background-gradient-color":"","background-gradient-color-opacity":"1","background-image":"","background-image-top-offset":"","background-image-bottom-offset":"","mobile-background-image":"","background-image-style":"cover","background-image-position":"center","background-image-position-custom":"","background-video-url":"","background-video-url-mp4":"","background-video-url-webm":"","background-video-url-ogg":"","background-video-image":"","background-pattern":"pattern-1","background-opacity":"","background-filter":"none","background-blur-size":"","pattern-opacity":"1","parallax-speed":"0.8","overflow":"","enable-container-background":"enable","container-background-color":"#ffffff","container-background-gradient":"none","container-background-gradient-min-opacity":"","container-background-gradient-color":"","container-background-image":"","container-background-image-opacity":"","container-padding":{"top":"60px","right":"70px","bottom":"0px","left":"50px","settings":"unlink"},"container-margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"unlink"},"container-tablet-padding":"","container-tablet-margin":"","container-mobile-padding":{"top":"","right":"20px","bottom":"","left":"20px","settings":"unlink"},"container-mobile-margin":"","container-border-radius":{"t-left":"8px","t-right":"8px","b-right":"8px","b-left":"8px","settings":"link"},"container-shadow-size":"","container-shadow-color":"","container-shadow-opacity":"0.2","container-z-index":"9","wrapper-background-gradient":"none","wrapper-background-gradient-color":"#000","wrapper-background-top-gradient-size":"413px","wrapper-background-bottom-gradient-size":"413px","enable-background-image-overlay":"disable","background-image-overlay":"","background-image-overlay-section":"left","background-image-overlay-margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"link"},"enable-background-particle":"disable","enable-marquee":"disable","marquee-text":"","marquee-position":"top","marquee-position-offset":"","marquee-speed":"10000","marquee-direction":"left","marquee-font-size":"","marquee-font-weight":"","marquee-font-letter-spacing":"","marquee-text-color":"","marquee-opacity":"1","border-radius":{"t-left":"8px","t-right":"8px","b-right":"8px","b-left":"8px","settings":"link"},"border-type":"none","border-pre-spaces":{"top":"20px","right":"20px","bottom":"20px","left":"20px","settings":"link"},"border-width":{"top":"1px","right":"1px","bottom":"1px","left":"1px","settings":"link"},"border-color":"#ffffff","border-style":"solid","background-shadow-size":"","background-shadow-color":"","background-shadow-opacity":"0.2","padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"unlink"},"margin":{"top":"-60px","right":"0px","bottom":"0px","left":"0px","settings":"unlink"},"tablet-padding":{"top":"","right":"","bottom":"","left":"","settings":"link"},"tablet-margin":{"top":"","right":"","bottom":"","left":"","settings":"link"},"mobile-padding":{"top":"","right":"","bottom":"","left":"","settings":"unlink"},"mobile-margin":{"top":"0px","right":"","bottom":"","left":"","settings":"unlink"},"skin":""},"items":[{"template":"wrapper","type":"column","column":"40","value":{"id":"","class":"","privacy":"","max-width":"","min-height":"","enable-left-right-spaces":"disable","hide-this-wrapper-in":"none","tablet-size":"","animation":"none","animation-location":"0.8","column-link":"","column-link-target":"_self","z-index":"","full-height":"disable","decrease-height":"0px","sync-height":"","centering-sync-height-content":"disable","background-type":"color","background-color-style":"plain","background-extending":"none","background-color":"","background-normal-color-opacity":"1","background-gradient-color":"","background-gradient-color-opacity":"1","background-image":"","background-image-style":"cover","background-image-position":"center","background-video-url":"","background-video-url-mp4":"","background-video-url-webm":"","background-video-url-ogg":"","background-video-image":"","background-pattern":"pattern-1","background-color-opacity":"1","background-opacity":"1","background-filter":"none","background-blur-size":"","border-radius":{"top":"","right":"","bottom":"","left":"","settings":"link"},"parallax-speed":"0.8","overflow":"","border-type":"none","border-pre-spaces":{"top":"20px","right":"20px","bottom":"20px","left":"20px","settings":"link"},"border-width":{"top":"1px","right":"1px","bottom":"1px","left":"1px","settings":"link"},"divider-height":"","hover-border-width":{"top":"","right":"","bottom":"","left":"","settings":"link"},"border-color":"#ffffff","hover-border-color":"#ffffff","border-style":"solid","background-shadow-size":"","background-shadow-color":"","background-shadow-opacity":"0.2","enable-move-up-shadow-effect":"disable","move-up-effect-length":"","frame-hover-shadow-size":"","frame-hover-shadow-color":"","frame-hover-shadow-opacity":"0.2","padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"link"},"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px","settings":"link"},"tablet-padding":{"top":"","right":"","bottom":"","left":"","settings":"link"},"tablet-margin":{"top":"","right":"","bottom":"","left":"","settings":"link"},"mobile-padding":{"top":"","right":"","bottom":"","left":"","settings":"link"},"mobile-margin":{"top":"","right":"","bottom":"","left":"","settings":"link"},"skin":""},"items":[{"template":"element","type":"lp-course-info"},{"template":"element","type":"title","value":{"id":"","class":"","title":"Digital Marketing Masterclass","caption":"Earn a University of London degree in Computer Science","caption-position":"bottom","title-link-text":"","title-link":"","title-link-target":"_self","text-align":"left","left-media-type":"image","left-icon":"fa fa-gear","left-image":"","title-left-icon":"none","enable-side-border":"disable","side-border-size":"1px","side-border-spaces":"30px","side-border-style":"solid","side-border-divider-color":"","heading-tag":"h3","icon-font-size":"30px","title-font-size":"36px","mobile-title-font-size":"","title-font-weight":"600","title-font-style":"normal","title-font-letter-spacing":"0px","title-line-height":"","title-font-uppercase":"disable","caption-font-size":"22px","caption-font-weight":"500","caption-font-style":"normal","caption-font-letter-spacing":"0px","caption-font-uppercase":"disable","read-more-font-size":"","read-more-font-weight":"","read-more-font-style":"italic","left-icon-color":"","title-color":"#222222","title-link-hover-color":"","title-text-shadow-size":"","title-text-shadow-color":"","caption-color":"#222222","caption-spaces":"20px","media-margin":{"top":"10px","right":"30px","bottom":"0px","left":"0px","settings":"unlink"},"padding-bottom":"20px"}},{"template":"element","type":"text-box","value":{"id":"","class":"","content":"<p>Open the door to sought-after technology careers with a world-class online Bachelor of Science (BSc) in Computer Science degree from the University of London. You’ll master in-demand computing skills, solve complex problems, and hone your innovation and creativity.</p>","text-align":"left","apply-the-content-filter":"disable","enable-p-space":"enable","font-size":"18px","content-line-height":"","content-font-weight":"","content-letter-spacing":"","content-text-transform":"none","tablet-font-size":"","mobile-font-size":"","text-color":"","margin-left":"","margin-right":"","padding-bottom":"25px"}},{"template":"element","type":"icon-list","value":{"id":"","class":"","tabs":[{"image":"","image-img":"","icon":"icon-clock","icon-hover":"","title":"Duration","caption":"3 week","link-url":"","link-target":"_self"},{"image":"","image-img":"","icon":"icon-book-open","icon-hover":"","title":"Lectures","caption":"12","link-url":"","link-target":"_self"},{"image":"","image-img":"","icon":"icon-globe-alt","icon-hover":"","title":"Language","caption":"English","link-url":"","link-target":"_self"},{"image":"","image-img":"","icon":"icon-graduation","icon-hover":"","title":"Skill level","caption":"Beginner","link-url":"","link-target":"_self"},{"image":"","image-img":"","icon":"icon-energy","icon-hover":"","title":"Quizzes","caption":"12","link-url":"","link-target":"_self"},{"image":"","image-img":"","icon":"icon-flag","icon-hover":"","title":"Full","caption":"Lifetime Access","link-url":"","link-target":"_self"}],"columns":"20","style":"style-2","align":"left","enable-divider":"disable","icon-background":"none","icon-position":"left","icon-color":"#222222","icon-background-color":"","content-color":"#222222","caption-color":"#222222","border-color":"","icon-size":"18px","content-size":"18px","content-font-weight":"500","content-text-transform":"","content-letter-spacing":"","caption-size":"18px","caption-font-weight":"400","caption-text-transform":"","caption-letter-spacing":"0px","image-max-width":"","icon-top-margin":"5px","icon-right-margin":"12px","list-bottom-margin":"15px","padding-bottom":"30px"}}]},{"template":"wrapper","type":"column","column":"20","value":{"id":"","class":"","privacy":"","max-width":"","min-height":"","enable-left-right-spaces":"disable","hide-this-wrapper-in":"none","tablet-size":"","animation":"none","animation-location":"0.8","column-link":"","column-link-target":"_self","z-index":"","full-height":"disable","decrease-height":"0px","sync-height":"","centering-sync-height-content":"disable","background-type":"color","background-color-style":"plain","background-extending":"none","background-color":"#ffffff","background-normal-color-opacity":"1","background-gradient-color":"","background-gradient-color-opacity":"1","background-image":"","background-image-style":"cover","background-image-position":"center","background-video-url":"","background-video-url-mp4":"","background-video-url-webm":"","background-video-url-ogg":"","background-video-image":"","background-pattern":"pattern-1","background-color-opacity":"1","background-opacity":"1","background-filter":"none","background-blur-size":"","border-radius":{"t-left":"7px","t-right":"7px","b-right":"7px","b-left":"7px","settings":"link"},"parallax-speed":"0.8","overflow":"","border-type":"none","border-pre-spaces":{"top":"20px","right":"20px","bottom":"20px","left":"20px","settings":"link"},"border-width":{"top":"1px","right":"1px","bottom":"1px","left":"1px","settings":"link"},"divider-height":"","hover-border-width":{"top":"","right":"","bottom":"","left":"","settings":"link"},"border-color":"#ffffff","hover-border-color":"#ffffff","border-style":"solid","background-shadow-size":{"x":"","y":"30px","size":"35px","settings":"unlink"},"background-shadow-color":"#0c0c0c","background-shadow-opacity":"0.1","enable-move-up-shadow-effect":"disable","move-up-effect-length":"","frame-hover-shadow-size":"","frame-hover-shadow-color":"","frame-hover-shadow-opacity":"0.2","padding":{"top":"50px","right":"40px","bottom":"20px","left":"40px","settings":"unlink"},"margin":{"top":"0px","right":"20px","bottom":"0px","left":"20px","settings":"unlink"},"tablet-padding":{"top":"","right":"","bottom":"","left":"","settings":"link"},"tablet-margin":{"top":"","right":"","bottom":"","left":"","settings":"link"},"mobile-padding":{"top":"","right":"20px","bottom":"","left":"20px","settings":"unlink"},"mobile-margin":{"top":"","right":"","bottom":"","left":"","settings":"link"},"skin":""},"items":[{"template":"element","type":"lp-course-price"},{"template":"element","type":"text-box","value":{"id":"","class":"","content":"<p>IT support is projected to grow 10% between 2018 and 2028 — faster than the average of all other occupations, BLS (2019)</p>","text-align":"center","apply-the-content-filter":"disable","enable-p-space":"disable","font-size":"16px","content-line-height":"","content-font-weight":"","content-letter-spacing":"","content-text-transform":"none","tablet-font-size":"","mobile-font-size":"","text-color":"","margin-left":"","margin-right":"","padding-bottom":"30px"}}]}]}]';
			
			return json_decode($value, true);
		}
	}


	// footer sub sription
	add_action('body_class', 'kingster_lp_body_class');
	if( !function_exists('kingster_lp_body_class') ){
		function kingster_lp_body_class($classes = array()){

			if( is_single() && get_post_type() == 'lp_course' ){
				$enable_subscription = kingster_get_option('lp', 'enable-bottom-subscription', 'enable');
				if( $enable_subscription == 'enable' ){
					$classes[] = 'kingster-lp-with-footer-subscription';
				}
			}
			
			return $classes;
		}
	}

	// add page option to lesson
	add_action('after_setup_theme', 'kingster_lp_post_option');
	if( !function_exists('kingster_lp_post_option') ){
		function kingster_lp_post_option(){

			// create page option
			if( class_exists('gdlr_core_page_option') ){

				// for course post type
				new gdlr_core_page_option(array(
					'post_type' => array('lp_course'),
					'options' => array(
						'layout' => array(
							'title' => esc_html__('Layout', 'kingster'),
							'options' => array(
								'title-background' => array(
									'title' => esc_html__('Page Title Background', 'kingster'),
									'type' => 'upload',
								),
								'display-course-info' => array(
									'title' => esc_html__('Display Course Info', 'kingster'),
									'type' => 'combobox',
									'options' => array(
										'default' => esc_html__('Default ( From Theme Option )', 'kingster'),
										'enable' => esc_html__('Enable', 'kingster'),
										'disable' => esc_html__('Disable', 'kingster')
									)
								),
								'page-caption' => array(
									'title' => esc_html__('Caption', 'kingster'),
									'type' => 'textarea',
								),
							)
						),
						'title' => array(
							'title' => esc_html__('Title Style', 'kingster'),
							'options' => array(

								'title-style' => array(
									'title' => esc_html__('Page Title Style', 'kingster'),
									'type' => 'combobox',
									'options' => array(
										'default' => esc_html__('Default', 'kingster'),
										'small' => esc_html__('Small', 'kingster'),
										'medium' => esc_html__('Medium', 'kingster'),
										'large' => esc_html__('Large', 'kingster'),
										'custom' => esc_html__('Custom', 'kingster'),
									),
									'default' => 'default'
								),
								'title-align' => array(
									'title' => esc_html__('Page Title Alignment', 'kingster'),
									'type' => 'radioimage',
									'options' => 'text-align',
									'with-default' => true,
									'default' => 'default'
								),
								'title-spacing' => array(
									'title' => esc_html__('Page Title Padding', 'kingster'),
									'type' => 'custom',
									'item-type' => 'padding',
									'data-input-type' => 'pixel',
									'options' => array('padding-top', 'padding-bottom', 'caption-bottom-margin'),
									'wrapper-class' => 'gdlr-core-fullsize gdlr-core-no-link gdlr-core-large',
									'condition' => array( 'title-style' => 'custom' )
								),
								'title-font-size' => array(
									'title' => esc_html__('Page Title Font Size', 'kingster'),
									'type' => 'custom',
									'item-type' => 'padding',
									'data-input-type' => 'pixel',
									'options' => array('title-size', 'title-letter-spacing', 'caption-size', 'caption-letter-spacing'),
									'wrapper-class' => 'gdlr-core-fullsize gdlr-core-no-link gdlr-core-large',
									'condition' => array( 'title-style' => 'custom' )
								),
								'title-font-weight' => array(
									'title' => esc_html__('Page Title Font Weight', 'kingster'),
									'type' => 'custom',
									'item-type' => 'padding',
									'options' => array('title-weight', 'caption-weight'),
									'wrapper-class' => 'gdlr-core-fullsize gdlr-core-no-link gdlr-core-large',
									'condition' => array( 'title-style' => 'custom' )
								),
								'title-font-transform' => array(
									'title' => esc_html__('Page Title Font Transform', 'kingster'),
									'type' => 'combobox',
									'options' => array(
										'none' => esc_html__('None', 'kingster'),
										'uppercase' => esc_html__('Uppercase', 'kingster'),
										'lowercase' => esc_html__('Lowercase', 'kingster'),
										'capitalize' => esc_html__('Capitalize', 'kingster'),
									),
									'default' => 'uppercase',
									'condition' => array( 'title-style' => 'custom' )
								),
								'top-bottom-gradient' => array(
									'title' => esc_html__('Title Top/Bottom Gradient', 'kingster'),
									'type' => 'combobox',
									'options' => array(
										'default' => esc_html__('Default', 'kingster'),
										'both' => esc_html__('Both', 'kingster'),
										'top' => esc_html__('Top', 'kingster'),
										'bottom' => esc_html__('Bottom', 'kingster'),
										'disable' => esc_html__('None', 'kingster'),
									)
								),
								'title-background-overlay-opacity' => array(
									'title' => esc_html__('Page Title Background Overlay Opacity', 'kingster'),
									'type' => 'text',
									'description' => esc_html__('Fill the number between 0.01 - 1 ( Leave Blank For Default Value )', 'kingster'),
									'condition' => array( 'title-style' => 'custom' )
								),
								'breadcrumbs-padding' => array(
									'title' => esc_html__('Breadcrumbs Padding', 'kingster'),
									'type' => 'custom',
									'item-type' => 'padding',
									'data-input-type' => 'pixel',
									'options' => array('padding-top', 'padding-bottom'),
									'wrapper-class' => 'gdlr-core-fullsize gdlr-core-no-link gdlr-core-large',
									'condition' => array( 'title-style' => 'custom' )
								),
								'title-color' => array(
									'title' => esc_html__('Page Title Color', 'kingster'),
									'type' => 'colorpicker',
								),
								'caption-color' => array(
									'title' => esc_html__('Page Caption Color', 'kingster'),
									'type' => 'colorpicker',
								),
								'title-background-overlay-color' => array(
									'title' => esc_html__('Page Background Overlay Color', 'kingster'),
									'type' => 'colorpicker',
								),

							)
						), // title
					)
				));

				// for lesson post type
				new gdlr_core_page_option(array(
					'post_type' => array('lp_lesson'),
					'options' => array(
						'layout' => array(
							'title' => esc_html__('Layout', 'kingster'),
							'options' => array(
								'hide-lesson-title' => array(
									'title' => esc_html__('Hide Lesson Title', 'kingster'),
									'type' => 'checkbox',
									'default' => 'disable',
									'single' => 'kingster-hide-lesson-title',
									'descirption' => esc_html__('This option will hide the default lesson title from Learnpress template. When you enable this option, you can put the custom content instead of the default one.', 'kingster')
								),
							)
						)
					)
				));
			}

		} // kingster_lp_post_option
	}

	// search nav bar
	add_filter('kingster_top_search_custom_input', 'kingster_lp_top_search_custom_input');
	if( !function_exists('kingster_lp_top_search_custom_input') ){
		function kingster_lp_top_search_custom_input( $ret = '' ){
			$ret .= '<input type="hidden" name="ref" value="course"/>';
			$ret .= '<input type="hidden" name="post_type" value="lp_course"/>';

			return $ret;
		}
	}

	add_filter('kingster_custom_top_bar_right', 'kingster_lp_login_top_bar');
	if( !function_exists('kingster_lp_login_top_bar') ){
		function kingster_lp_login_top_bar(){

			if( !class_exists('LP_Profile') ) return;

			$is_logged_in = is_user_logged_in();

			$ret  = '<div class="kingster-lp-top-bar-user ' . ($is_logged_in? 'kingster-lp-user': 'kingster-lp-guest') . '" >';
			
			if( $is_logged_in ){
				
				$profile = LP_Profile::instance();

				$ret .= '<i class="kingster-lp-top-bar-user-button fa fa-user-o" ></i>';
				$ret .= '<div class="kingster-lp-top-bar-nav" >';
				$ret .= '<div class="kingster-lp-top-bar-nav-content" >';
				foreach ( $profile->get_tabs()->tabs() as $tab_key => $tab_data ) {

					$link = $profile->get_tab_link( $tab_key, true );
					$title = $tab_data['title'];

					$ret .= '<a class="kingster-lp-page-' . esc_attr($tab_key) . '" href="' . esc_attr($link) . '" >';
					switch($tab_key){
						case 'overview': 	$ret .= '<i class="icon-grid" ></i>'; break;
            			case 'dashboard': 	$ret .= '<i class="icon-grid" ></i>'; break;
            			case 'courses': 	$ret .= '<i class="icon-book-open" ></i>'; break;
            			case 'quizzes': 	$ret .= '<i class="icon-pencil" ></i>'; break;
            			case 'wishlist': 	$ret .= '<i class="icon-heart" ></i>'; break;
            			case 'orders': 		$ret .= '<i class="icon-basket" ></i>'; break;
            			case 'settings': 	$ret .= '<i class="icon-equalizer" ></i>'; break;
            			case 'logout': 		$ret .= '<i class="icon-logout" ></i>'; break;
            		}
					$ret .= $title;
					$ret .= ' </a>';

				}
				# $ret .= '<a class="kingster-lp-page-logout" href="' . esc_attr(wp_logout_url()) . '" >';
				# $ret .= '<i class="icon-logout" ></i>';
				# $ret .= esc_html__('Logout', 'kingster');
				# $ret .= '</a>';
				$ret .= '</div>';
				$ret .= '</div>';

			}else{
				$profile_link = learn_press_get_page_link('profile');

				$ret .= '<a href="' . esc_attr($profile_link) . '" >';
				$ret .= '<i class="kingster-lp-top-bar-user-button fa fa-user-o" ></i>';
				$ret .= '</a>';
			}
			

			$ret .= '</div>';

			return $ret;
		}
	}

	// add_filter('kingster_custom_main_menu_right', 'kingster_lp_custom_main_menu_right');
	if( !function_exists('kingster_lp_custom_main_menu_right') ){
		function kingster_lp_custom_main_menu_right( $ret ){

			$enable_nav_search = kingster_get_option('lp', 'enable-navigation-course-search', 'disable');

			if( $enable_nav_search == 'enable' ){
				$ret  = '<form class="kingster-lp-menu-search" action="' . esc_attr(learn_press_get_page_link('courses')) . '" >';
				$ret .= '<input type="text" name="s" value="" placeholder="' . esc_attr(esc_html__('What do you want to learn today?', 'kingster')) . '" />';
	    		$ret .= '<input type="hidden" name="ref" value="course"/>';
	    		$ret .= '<input type="submit" />';
				$ret .= '</form>';
			}
			
			
			return $ret;
		}
	}

	// single course template
	add_filter('learn-press/override-templates', function(){ return true; } );
	
	remove_action( 'learn-press/content-landing-summary', 'learn_press_course_students', 10 );
	remove_action( 'learn-press/content-landing-summary', 'learn_press_course_instructor', 35 );

	if( class_exists('LearnPress') && method_exists('LearnPress', 'template') ){
		add_action('kingster_single_course_tab', LP()->template( 'course' )->callback( 'single-course/tabs/tabs' ));
	}

	add_filter('template_include', 'kingster_lp_template_include', 9999);
	if( !function_exists('kingster_lp_template_include') ){
		function kingster_lp_template_include( $template ){
			if( strpos($template, 'learnpress/templates/single-course.php') !== false ){
				$template = get_template_directory() . '/learnpress/single-lp_course.php';
			}
			return $template;
		}
	}



	// order receive
	add_action('learn-press/order/received-order-message', 'kingster_learnpress_received_order_title');
	if( !function_exists('kingster_learnpress_received_order_title') ){
		function kingster_learnpress_received_order_title( $message ){
			return $message;
		}
	}

	// add span to currency
	add_action('learn-press/currency-symbol', 'kingster_learnpress_currency_symbol', 10, 2);
	if( !function_exists('kingster_learnpress_currency_symbol') ){
		function kingster_learnpress_currency_symbol( $currency_symbol, $currency ){
			return '<span class="kingster-currency-symbol" >' . $currency_symbol . '</span>';
		}
	}