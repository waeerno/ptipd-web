<?php 
	/*	
	*	Goodlayers Tgmpa Action File
	*/		
	
	// move the menu to goodlayers main area
	if( is_admin() ){ add_action('after_setup_theme', 'kingster_change_tgmpa_location', 20); }
	if( !function_exists('kingster_change_tgmpa_location') ){
		function kingster_change_tgmpa_location(){

			if( class_exists('gdlr_core_admin_menu') ){
				gdlr_core_admin_menu::register_menu(array(
					'parent-slug' => 'goodlayers_main_menu',
					'menu-url' => 'themes.php?page=tgmpa-install-plugins',
					'menu-slug' => 'tgmpa-install-plugins',
					'menu-parent-slug' => 'themes.php',
					'menu-title' => esc_html__( 'Install Plugins', 'kingster' ),
					'page-title' => esc_html__( 'Install Required Plugins', 'kingster' ),
					'capability' => 'edit_theme_options'
				));	
			}
			
		}
	}

	// auto install and redirect to plugin page
	if( !function_exists('kingster_tgmpa_complete') ){
		function kingster_tgmpa_complete(){
			if( !empty($GLOBALS['tgmpa']) ){
				
				// force plugin installation
				$tgmpa = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
				return $tgmpa->is_tgmpa_complete(true);
			}
		}
	}
	
	// auto install and redirect to plugin page
	if( !function_exists('kingster_tgmpa_does_plugin_active') ){
		function kingster_tgmpa_does_plugin_active($slug, $redirect_url){
			
			if( !empty($GLOBALS['tgmpa']) ){
				$tgmpa = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
			
				if( !$tgmpa->is_plugin_installed($slug) ){
					return false;
				}else if( !$tgmpa->is_plugin_active($slug) ){
					$result = activate_plugin($slug . '/' . $slug . '.php');
					return admin_url($redirect_url);
				}
			}
			
			return admin_url($redirect_url);
		}
	}
	if( !function_exists('kingster_tgmpa_auto_install_url') ){
		function kingster_tgmpa_auto_install_url($slug, $redirect_url){

			// force plugin installation
			if( !empty($GLOBALS['tgmpa']) ){
				$tgmpa = call_user_func(array(get_class($GLOBALS['tgmpa']), 'get_instance'));
				if( !$tgmpa->is_plugin_installed($slug) ){
					return add_query_arg(array(
						'plugin' => $slug,
						'tgmpa-install' => 'install-plugin',
						'tgmpa-nonce' => wp_create_nonce('tgmpa-install'),
						'return-page' => $redirect_url
					), $tgmpa->get_tgmpa_url());
				}else if( !$tgmpa->is_plugin_active($slug) ){
					$result = activate_plugin($slug . '/' . $slug . '.php');
					return admin_url($redirect_url);
				}
			}

			return admin_url($redirect_url);
		}
	}

	// register the menu for tgm plugin
	add_action('tgmpa_register', 'kingster_register_required_plugins');
	if( !function_exists('kingster_register_required_plugins') ){
		function kingster_register_required_plugins(){
			
			$plugins = array(
				array(
					'name'               => esc_html__('Goodlayers Core', 'kingster'),
					'slug'               => 'goodlayers-core', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/goodlayers-core.zip',
					'required'           => true, 
					'version'            => '1.8.1', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Goodlayers Core Portfolio', 'kingster'),
					'slug'               => 'goodlayers-core-portfolio', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/goodlayers-core-portfolio.zip',
					'required'           => true, 
					'version'            => '1.3.5', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Goodlayers Core Personnel', 'kingster'),
					'slug'               => 'goodlayers-core-personnel', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/goodlayers-core-personnel.zip',
					'required'           => true, 
					'version'            => '1.2.8', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Goodlayers Core Course', 'kingster'),
					'slug'               => 'goodlayers-core-course', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/goodlayers-core-course.zip',
					'required'           => true, 
					'version'            => '1.0.1', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Goodlayers Core Twitter', 'kingster'),
					'slug'               => 'goodlayers-core-twitter', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/goodlayers-core-twitter.zip',
					'required'           => false, 
					'version'            => '1.0.3', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Envato Market', 'kingster'),
					'slug'               => 'envato-market', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/envato-market.zip',
					'required'           => false, 
					'version'            => '2.0.3', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),
				array(
					'name'               => esc_html__('Revolution Slider', 'kingster'),
					'slug'               => 'revslider', 
					'source'             => get_template_directory() . '/admin/tgmpa/plugins/revslider.zip',
					'required'           => false, 
					'version'            => '6.4.6', 
					'force_activation'   => false, 
					'force_deactivation' => false, 
				),

				array(
					'name'      => esc_html__('The Events Calendar', 'kingster'),
					'slug'      => 'the-events-calendar',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Contact Form 7', 'kingster'),
					'slug'      => 'contact-form-7',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('WP Google Map Plugin', 'kingster'),
					'slug'      => 'wp-google-map-plugin',
					'required'  => false,
				),

				array(
					'name'      => esc_html__('Learnpress', 'kingster'),
					'slug'      => 'learnpress',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Learnpress - Course Review', 'kingster'),
					'slug'      => 'learnpress-course-review',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Learnpress - Wishlist', 'kingster'),
					'slug'      => 'learnpress-wishlist',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Learnpress - Offline Payment', 'kingster'),
					'slug'      => 'learnpress-offline-payment',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Learnpress - Prerequisites Courses', 'kingster'),
					'slug'      => 'learnpress-prerequisites-courses',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Learnpress - Export/Import', 'kingster'),
					'slug'      => 'learnpress-import-export',
					'required'  => false,
				),
			);
			
			$config = array(
				'id'           => 'kingster',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug'  => 'themes.php',            // Parent menu slug.
				'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			);

			tgmpa( $plugins, $config );
			
		} // kingster_register_required_plugins
	} // function_exists