<?php 

	add_filter('gdlr_core_personnel_option', 'kingster_gdlr_core_personnel_option');
	if( !function_exists('kingster_gdlr_core_personnel_option') ){
		function kingster_gdlr_core_personnel_option($options){
			$options['general']['options'] = gdlr_core_array_insert($options['general']['options'], 'page-caption', array(
				'enable-title-background' => array(
					'title' => esc_html__('Enable Title Background', 'kingster'),
					'type' => 'checkbox',
					'default' => 'enable',
					'condition' => array( 'enable-page-title' => 'enable' )
				),					
				'title-background' => array(
					'title' => esc_html__('Page Title Background', 'kingster'),
					'type' => 'upload',
					'condition' => array( 'enable-page-title' => 'enable', 'enable-title-background' => 'enable' )
				),
				'enable-breadcrumbs' => array(
					'title' => esc_html__('Enable Breadcrumbs', 'kingster'),
					'type' => 'checkbox',
					'default' => 'disable',
					'condition' => array( 'enable-page-title' => 'enable' )
				),
			));

			$options['general']['options'] = gdlr_core_array_insert($options['general']['options'], 'position', array(
				'email' => array(
					'title' => esc_html__('Email', 'kingster'),
					'type' => 'text',
				),
				'phone' => array(
					'title' => esc_html__('Phone', 'kingster'),
					'type' => 'text',
				),
				'location' => array(
					'title' => esc_html__('Location', 'kingster'),
					'type' => 'text',
				),
			));

			if( !empty($options) ){
				$options['title'] = array(
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

				);
			}

			return $options;
		}
	}