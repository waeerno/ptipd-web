<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// save the css/js file 
	add_action('gdlr_core_after_save_theme_option', 'kingster_gdlr_core_after_save_theme_option');
	if( !function_exists('kingster_gdlr_core_after_save_theme_option') ){
		function kingster_gdlr_core_after_save_theme_option(){
			if( function_exists('gdlr_core_generate_combine_script') ){
				kingster_clear_option();

				gdlr_core_generate_combine_script(array(
					'lightbox' => kingster_gdlr_core_lightbox_type()
				));
			}
		}
	}

	if( !function_exists('kingster_gdlr_core_get_privacy_options') ){
		function kingster_gdlr_core_get_privacy_options( $type = 1 ){
			if( function_exists('gdlr_core_get_privacy_options') ){
				return gdlr_core_get_privacy_options( $type );
			}

			return array();
		} // kingster_gdlr_core_get_privacy_options
	}

	// add the option
	$kingster_admin_option->add_element(array(
	
		// plugin head section
		'title' => esc_html__('Miscellaneous', 'kingster'),
		'slug' => 'kingster_plugin',
		'icon' => get_template_directory_uri() . '/include/options/images/plugin.png',
		'options' => array(
			
			// starting the subnav
			'thumbnail-sizing' => array(
				'title' => esc_html__('Thumbnail Sizing', 'kingster'),
				'customizer' => false,
				'options' => array(
				
					'enable-srcset' => array(
						'title' => esc_html__('Enable Srcset', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('Enable this option will improve the performance by resizing the image based on the screensize. Please be cautious that this will generate multiple images on your server.', 'kingster')
					),
					'thumbnail-sizing' => array(
						'title' => esc_html__('Add Thumbnail Size', 'kingster'),
						'type' => 'custom',
						'item-type' => 'thumbnail-sizing',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					
				) // thumbnail-sizing-options
			), // thumbnail-sizing-nav		

			'consent-settings' => array(
				'title' => esc_html__('Consent Settings', 'kingster'),
				'options' => kingster_gdlr_core_get_privacy_options(1)
			),
			'privacy-settings' => array(
				'title' => esc_html__('Privacy Style Settings', 'kingster'),
				'options' => kingster_gdlr_core_get_privacy_options(2)
			),

			'plugins' => array(
				'title' => esc_html__('Plugins', 'kingster'),
				'options' => array(

					'font-icon' => array(
						'title' => esc_html__('Icon Type', 'kingster'),
						'type' => 'multi-combobox',
						'options' => (function_exists('gdlr_core_get_icon_font_title')? gdlr_core_get_icon_font_title(): array()),
						'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
						'default' => array('font-awesome', 'elegant-font')
					),
					'lightbox' => array(
						'title' => esc_html__('Lightbox Type', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'lightGallery' => esc_html__('LightGallery', 'kingster'),
							// 'ilightbox' => esc_html__('ilightbox', 'kingster'),
							'strip' => esc_html__('Strip', 'kingster'),
						)
					),
					'ilightbox-skin' => array(
						'title' => esc_html__('iLightbox Skin', 'kingster'),
						'type' => 'combobox',
						'options' => array(
							'dark' => esc_html__('Dark', 'kingster'),
							'light' => esc_html__('Light', 'kingster'),
							'mac' => esc_html__('Mac', 'kingster'),
							'metro-black' => esc_html__('Metro Black', 'kingster'),
							'metro-white' => esc_html__('Metro White', 'kingster'),
							'parade' => esc_html__('Parade', 'kingster'),
							'smooth' => esc_html__('Smooth', 'kingster'),		
						),
						'condition' => array( 'lightbox' => 'ilightbox' )
					),
					'link-to-lightbox' => array(
						'title' => esc_html__('Turn Image Link To Open In Lightbox', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'lightbox-video-autoplay' => array(
						'title' => esc_html__('Enable Video Autoplay On Lightbox', 'kingster'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					
				) // plugin-options
			), // plugin-nav		
			'additional-script' => array(
				'title' => esc_html__('Custom Css/Js', 'kingster'),
				'options' => array(
				
					'additional-css' => array(
						'title' => esc_html__('Additional CSS ( without <style> tag )', 'kingster'),
						'type' => 'textarea',
						'data-type' => 'text',
						'selector' => '#gdlr#',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'additional-mobile-css' => array(
						'title' => esc_html__('Mobile CSS ( screen below 767px )', 'kingster'),
						'type' => 'textarea',
						'data-type' => 'text',
						'selector' => '@media only screen and (max-width: 767px){ #gdlr# }',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'additional-head-script' => array(
						'title' => esc_html__('Additional Head Script ( without <script> tag )', 'kingster'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'descriptin' => esc_html__('Eg. For analytics', 'kingster')
					),
					'additional-head-script2' => array(
						'title' => esc_html__('Additional Head Script ( with <script> tag )', 'kingster'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'descriptin' => esc_html__('Eg. For analytics', 'kingster')
					),
					'additional-script' => array(
						'title' => esc_html__('Additional Script ( without <script> tag )', 'kingster'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					
				) // additional-script-options
			), // additional-script-nav	
			'maintenance' => array(
				'title' => esc_html__('Maintenance Mode', 'kingster'),
				'options' => array(		
					'enable-maintenance' => array(
						'title' => esc_html__('Enable Maintenance / Coming Soon Mode', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable'
					),					
					'maintenance-page' => array(
						'title' => esc_html__('Select Maintenance / Coming Soon Page', 'kingster'),
						'type' => 'combobox',
						'options' => 'post_type',
						'options-data' => 'page'
					),

				) // maintenance-options
			), // maintenance
			'pre-load' => array(
				'title' => esc_html__('Preload', 'kingster'),
				'options' => array(		
					'enable-preload' => array(
						'title' => esc_html__('Enable Preload', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'preload-image' => array(
						'title' => esc_html__('Preload Image', 'kingster'),
						'type' => 'upload',
						'data-type' => 'file', 
						'selector' => '.kingster-page-preload{ background-image: url(#gdlr#); }',
						'condition' => array( 'enable-preload' => 'enable' ),
						'description' => esc_html__('Upload the image (.gif) you want to use as preload animation. You could search it online at https://www.google.com/search?q=loading+gif as well', 'kingster')
					),
				)
			),
			'import-export' => array(
				'title' => esc_html__('Import / Export', 'kingster'),
				'options' => array(

					'export' => array(
						'title' => esc_html__('Export Option', 'kingster'),
						'type' => 'export',
						'action' => 'gdlr_core_theme_option_export',
						'options' => array(
							'all' => esc_html__('All Options(general/typography/color/miscellaneous) exclude widget, custom template', 'kingster'),
							'kingster_general' => esc_html__('General Option', 'kingster'),
							'kingster_typography' => esc_html__('Typography Option', 'kingster'),
							'kingster_color' => esc_html__('Color Option', 'kingster'),
							'kingster_plugin' => esc_html__('Miscellaneous', 'kingster'),
							'kingster_lp' => esc_html__('Learnpress', 'kingster'),
							'widget' => esc_html__('Widget', 'kingster'),
							'page-builder-template' => esc_html__('Custom Page Builder Template', 'kingster'),
							'goodlayers_core_course_custom_taxs' => esc_html__('Custom Course Taxonomy', 'kingster')
						),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'import' => array(
						'title' => esc_html__('Import Option', 'kingster'),
						'type' => 'import',
						'action' => 'gdlr_core_theme_option_import',
						'wrapper-class' => 'gdlr-core-fullsize'
					),

				) // import-options
			), // import-export
			
		
		) // plugin-options
		
	), 8);	