<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	$kingster_admin_option->add_element(array(
	
		// typography head section
		'title' => esc_html__('Typography', 'kingster'),
		'slug' => 'kingster_typography',
		'icon' => get_template_directory_uri() . '/include/options/images/typography.png',
		'options' => array(
		
			// starting the subnav
			'font-family' => array(
				'title' => esc_html__('Font Family', 'kingster'),
				'options' => array(
					'heading-font' => array(
						'title' => esc_html__('Heading Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body h1, .kingster-body h2, .kingster-body h3, ' . 
							'.kingster-body h4, .kingster-body h5, .kingster-body h6, .kingster-body .kingster-title-font,' .
							'.kingster-body .gdlr-core-title-font{ font-family: #gdlr#; }' . 
							'.woocommerce-breadcrumb, .woocommerce span.onsale, ' .
							'.single-product.woocommerce div.product p.price .woocommerce-Price-amount, .single-product.woocommerce #review_form #respond label{ font-family: #gdlr#; }'
					),
					'navigation-font' => array(
						'title' => esc_html__('Navigation Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-navigation .sf-menu > li > a, .kingster-navigation .sf-vertical > li > a, .kingster-navigation-font{ font-family: #gdlr#; }'
					),	
					'content-font' => array(
						'title' => esc_html__('Content Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body, .kingster-body .gdlr-core-content-font, ' . 
							'.kingster-body input, .kingster-body textarea, .kingster-body button, .kingster-body select, ' . 
							'.kingster-body .kingster-content-font, .gdlr-core-audio .mejs-container *{ font-family: #gdlr#; }'
					),
					'info-font' => array(
						'title' => esc_html__('Info Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body .gdlr-core-info-font, .kingster-body .kingster-info-font{ font-family: #gdlr#; }'
					),
					'blog-info-font' => array(
						'title' => esc_html__('Blog Info Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body .gdlr-core-blog-info-font, .kingster-body .kingster-blog-info-font{ font-family: #gdlr#; }'
					),
					'quote-font' => array(
						'title' => esc_html__('Quote Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body .gdlr-core-quote-font, blockquote{ font-family: #gdlr#; }'
					),
					'testimonial-font' => array(
						'title' => esc_html__('Testimonial Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'default' => 'Open Sans',
						'selector' => '.kingster-body .gdlr-core-testimonial-content{ font-family: #gdlr#; }'
					),
					'additional-font' => array(
						'title' => esc_html__('Additional Font', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'kingster')
					),
					'additional-font2' => array(
						'title' => esc_html__('Additional Font2', 'kingster'),
						'type' => 'font',
						'data-type' => 'font',
						'customizer' => false,
						'default' => 'Georgia, serif',
						'description' => esc_html__('Additional font you want to include for custom css.', 'kingster')
					),
					
				) // font-family-options
			), // font-family-nav
			
			'font-size' => array(
				'title' => esc_html__('Font Size', 'kingster'),
				'options' => array(
				
					'h1-font-size' => array(
						'title' => esc_html__('H1 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '52px',
						'selector' => '.kingster-body h1{ font-size: #gdlr#; }' 
					),					
					'h2-font-size' => array(
						'title' => esc_html__('H2 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '48px',
						'selector' => '.kingster-body h2, #poststuff .gdlr-core-page-builder-body h2{ font-size: #gdlr#; }' 
					),					
					'h3-font-size' => array(
						'title' => esc_html__('H3 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '36px',
						'selector' => '.kingster-body h3{ font-size: #gdlr#; }' 
					),					
					'h4-font-size' => array(
						'title' => esc_html__('H4 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '28px',
						'selector' => '.kingster-body h4{ font-size: #gdlr#; }' 
					),					
					'h5-font-size' => array(
						'title' => esc_html__('H5 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.kingster-body h5{ font-size: #gdlr#; }' 
					),					
					'h6-font-size' => array(
						'title' => esc_html__('H6 Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '18px',
						'selector' => '.kingster-body h6{ font-size: #gdlr#; }' 
					),				
					'header-font-weight' => array(
						'title' => esc_html__('Header Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-body h1, .kingster-body h2, .kingster-body h3, .kingster-body h4, .kingster-body h5, .kingster-body h6{ font-weight: #gdlr#; }' . 
							'#poststuff .gdlr-core-page-builder-body h1, #poststuff .gdlr-core-page-builder-body h2{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),
					'content-font-size' => array(
						'title' => esc_html__('Content Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.kingster-body{ font-size: #gdlr#; }' 
					),
					'content-font-weight' => array(
						'title' => esc_html__('Content Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-body{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),
					'content-line-height' => array(
						'title' => esc_html__('Content Line Height', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '1.7',
						'selector' => '.kingster-body, .kingster-body p, .kingster-line-height, .gdlr-core-line-height{ line-height: #gdlr#; }'
					),
					
				) // font-size-options
			), // font-size-nav			
			
			'mobile-font-size' => array(
				'title' => esc_html__('Mobile Font Size', 'kingster'),
				'options' => array(

					'mobile-h1-font-size' => array(
						'title' => esc_html__('Mobile H1 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h1{ font-size: #gdlr#; } }' 
					),
					'mobile-h2-font-size' => array(
						'title' => esc_html__('Mobile H2 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h2, #poststuff .gdlr-core-page-builder-body h2{ font-size: #gdlr#; } }' 
					),
					'mobile-h3-font-size' => array(
						'title' => esc_html__('Mobile H3 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h3{ font-size: #gdlr#; } }' 
					),
					'mobile-h4-font-size' => array(
						'title' => esc_html__('Mobile H4 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h4{ font-size: #gdlr#; } }' 
					),
					'mobile-h5-font-size' => array(
						'title' => esc_html__('Mobile H5 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h5{ font-size: #gdlr#; } }' 
					),
					'mobile-h6-font-size' => array(
						'title' => esc_html__('Mobile H6 Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body h6{ font-size: #gdlr#; } }' 
					),					
					'mobile-content-font-size' => array(
						'title' => esc_html__('Mobile Content Font Size', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .kingster-body{ font-size: #gdlr#; } }' 
					),

				)
			),

			'navigation-font-size' => array(
				'title' => esc_html__('Navigation Font Size', 'kingster'),
				'options' => array(	
					'navigation-font-size' => array(
						'title' => esc_html__('Navigation Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '14px',
						'selector' => '.kingster-navigation .sf-menu > li > a, .kingster-navigation .sf-vertical > li > a{ font-size: #gdlr#; }' 
					),	
					'navigation-font-weight' => array(
						'title' => esc_html__('Navigation Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '800',
						'selector' => '.kingster-navigation .sf-menu > li > a, .kingster-navigation .sf-vertical > li > a{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'navigation-font-letter-spacing' => array(
						'title' => esc_html__('Navigation Font Letter Spacing', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-navigation .sf-menu > li > a, .kingster-navigation .sf-vertical > li > a{ letter-spacing: #gdlr#; }'
					),
					'navigation-text-transform' => array(
						'title' => esc_html__('Navigation Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'uppercase',
						'selector' => '.kingster-navigation .sf-menu > li > a, .kingster-navigation .sf-vertical > li > a{ text-transform: #gdlr#; }',
					),
					'navigation-right-button-font-size' => array(
						'title' => esc_html__('Navigation Right Button Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '11px',
						'selector' => '.kingster-main-menu-right-button{ font-size: #gdlr#; }' 
					),	
					'navigation-right-button-font-weight' => array(
						'title' => esc_html__('Navigation Right Button Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-main-menu-right-button{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'navigation-right-button-font-letter-spacing' => array(
						'title' => esc_html__('Navigation Right Button Font Letter Spacing', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-main-menu-right-button{ letter-spacing: #gdlr#; }'
					),
					'navigation-right-button-text-transform' => array(
						'title' => esc_html__('Navigation Right Button Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'uppercase',
						'selector' => '.kingster-main-menu-right-button{ text-transform: #gdlr#; }',
					),
				) // font-size-options
			), // font-size-nav
			
			'footer-font-size' => array(
				'title' => esc_html__('Sidebar / Footer Font Size', 'kingster'),
				'options' => array(
					
					'sidebar-title-font-size' => array(
						'title' => esc_html__('Sidebar Title Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.kingster-sidebar-area .kingster-widget-title{ font-size: #gdlr#; }' 
					),
					'sidebar-title-font-weight' => array(
						'title' => esc_html__('Sidebar Title Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-sidebar-area .kingster-widget-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'sidebar-title-font-letter-spacing' => array(
						'title' => esc_html__('Sidebar Title Font Letter Spacing', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-sidebar-area .kingster-widget-title{ letter-spacing: #gdlr#; }'
					),
					'sidebar-title-text-transform' => array(
						'title' => esc_html__('Sidebar Title Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'uppercase',
						'selector' => '.kingster-sidebar-area .kingster-widget-title{ text-transform: #gdlr#; }',
					),
					'footer-title-font-size' => array(
						'title' => esc_html__('Footer Title Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.kingster-footer-wrapper .kingster-widget-title{ font-size: #gdlr#; }' 
					),
					'footer-title-font-weight' => array(
						'title' => esc_html__('Footer Title Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-footer-wrapper .kingster-widget-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'footer-title-font-letter-spacing' => array(
						'title' => esc_html__('Footer Title Font Letter Spacing', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-footer-wrapper .kingster-widget-title{ letter-spacing: #gdlr#; }'
					),
					'footer-title-text-transform' => array(
						'title' => esc_html__('Footer Title Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'uppercase',
						'selector' => '.kingster-footer-wrapper .kingster-widget-title{ text-transform: #gdlr#; }',
					),
					'footer-font-size' => array(
						'title' => esc_html__('Footer Content Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.kingster-footer-wrapper{ font-size: #gdlr#; }' 
					),
					'footer-content-font-weight' => array(
						'title' => esc_html__('Footer Content Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-footer-wrapper .widget_text{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'footer-content-text-transform' => array(
						'title' => esc_html__('Footer Content Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'none',
						'selector' => '.kingster-footer-wrapper .widget_text{ text-transform: #gdlr#; }',
					),
					'copyright-font-size' => array(
						'title' => esc_html__('Copyright Font Size', 'kingster'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '14px',
						'selector' => '.kingster-copyright-text, .kingster-copyright-left, .kingster-copyright-right{ font-size: #gdlr#; }' 
					),
					'copyright-font-weight' => array(
						'title' => esc_html__('Copyright Font Weight', 'kingster'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.kingster-copyright-text, .kingster-copyright-left, .kingster-copyright-right{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
					),	
					'copyright-font-letter-spacing' => array(
						'title' => esc_html__('Copyright Font Letter Spacing', 'kingster'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.kingster-copyright-text, .kingster-copyright-left, .kingster-copyright-right{ letter-spacing: #gdlr#; }'
					),
					'copyright-text-transform' => array(
						'title' => esc_html__('Copyright Text Transform', 'kingster'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'uppercase' => esc_html__('Uppercase', 'kingster'),
							'lowercase' => esc_html__('Lowercase', 'kingster'),
							'capitalize' => esc_html__('Capitalize', 'kingster'),
							'none' => esc_html__('None', 'kingster'),
						),
						'default' => 'uppercase',
						'selector' => '.kingster-copyright-text, .kingster-copyright-left, .kingster-copyright-right{ text-transform: #gdlr#; }',
					),
				)
			),

			'font-upload' => array(
				'title' => esc_html__('Font Uploader', 'kingster'),
				'reload-after' => true,
				'customizer' => false,
				'options' => array(
					
					'font-upload' => array(
						'title' => esc_html__('Upload Fonts', 'kingster'),
						'type' => 'custom',
						'item-type' => 'fontupload',
						'wrapper-class' => 'gdlr-core-fullsize',
					),
					
				) // fontupload-options
			), // fontupload-nav
		
		) // typography-options
		
	), 4);