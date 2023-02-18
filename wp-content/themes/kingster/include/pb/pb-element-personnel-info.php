<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('personnel-info', 'kingster_gdlr_core_pb_element_personnel_info'); 
	}
	
	if( !class_exists('kingster_gdlr_core_pb_element_personnel_info') ){
		class kingster_gdlr_core_pb_element_personnel_info{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-outdent',
					'title' => esc_html__('Personnel Info', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(					
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(
							'title' => array(
								'title' => esc_html__('Title', 'kingster'),
								'type' => 'checkbox'

							),
							'position' => array(
								'title' => esc_html__('Position', 'kingster'),
								'type' => 'checkbox'
							),
							'info' => array(
								'title' => esc_html__('Select Information To Display', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'social-shortcode' => esc_html__('Social', 'kingster'),
									'email' => esc_html__('Email', 'kingster'),
									'phone' => esc_html__('Phone', 'kingster'),
									'location' => esc_html__('Location', 'kingster'),
								),
								'default' => array( 'social-shortcode', 'email', 'phone', 'location' ),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
						),
					),
					'typography' => array(
						'title' => esc_html__('Typography', 'kingster'),
						'options' => array(
							'title-font-size' => array(
								'title' => esc_html__('Title Font Size', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'position-font-size' => array(
								'title' => esc_html__('Position Font Size', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
						)
					),
					'spacing' => array(
						'title' => esc_html__('Spacing', 'kingster'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					),
				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb, $page_builder_post_id;
				
				// default variable
				if( empty($settings) ){
					$settings = array( 
						'info' => array('social-shortcode', 'email', 'phone', 'location')
					);
				}
				
				$settings['info'] = empty($settings['info'])? array(): $settings['info'];

				// start printing item
				$ret  = '<div class="gdlr-core-personnel-info-item gdlr-core-item-pdb gdlr-core-item-pdlr clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				$post_id = get_the_ID();
				if( $post_id || $page_builder_post_id ){
					if( empty($post_id) ){
						$post_id = $page_builder_post_id;
					}
					$post_option = get_post_meta($post_id, 'gdlr-core-page-option', true);

					// title & position
					$title_html = '';
					if( empty($settings['title']) || $settings['title'] == 'enable' ){
						$title_html .= '<h3 class="gdlr-core-personnel-info-item-title" ' . gdlr_core_esc_style(array(
							'font-size' => empty($settings['title-font-size'])? '': $settings['title-font-size']
						)) . ' >' . get_the_title($post_id) . '</h3>';
					}
					if( (empty($settings['position']) || $settings['position'] == 'enable') && !empty($post_option['position']) ){
						$title_html .= '<div class="gdlr-core-personnel-info-item-position gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
							'font-size' => empty($settings['position-font-size'])? '': $settings['position-font-size']
						)) . ' >' . gdlr_core_text_filter($post_option['position']) . '</div>';
					}
					if( !empty($title_html) ){
						$ret .= '<div class="gdlr-core-personnel-info-item-head" >' . gdlr_core_text_filter($title_html) . '</div>';
					}

					// get info
					if( !empty($settings['info']) ){
						$ret .= '<div class="gdlr-core-personnel-info-item-list-wrap" >';
						$ret .= kingster_get_personnel_info($post_option, $settings['info']);
						$ret .= '</div>';
					}
					
				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('This option will show selected personnel information on front end area.', 'kingster') . '</div>';
				}
				
				$ret .= '</div>'; // gdlr-core-blog-item
				
				return $ret;
			}
			
		} // gdlr_core_pb_element_personnel
	} // class_exists

	if( !function_exists('kingster_get_personnel_info') ){
		function kingster_get_personnel_info($post_option, $display){

			$ret = '';

			$icons = array(
				'email' => 'fa fa-envelope-open',
				'phone' => 'fa fa-phone',
				'location' => 'fa fa-location-arrow'
			);
			foreach($display as $info_slug){
				if( !empty($post_option[$info_slug]) ){
					$ret .= '<div class="kingster-personnel-info-list kingster-type-' . esc_attr($info_slug) . '" >';
					if( !empty($icons[$info_slug]) ){
						$ret .= '<i class="kingster-personnel-info-list-icon ' . esc_attr($icons[$info_slug]) . '" ></i>';
					}
					$ret .= gdlr_core_text_filter($post_option[$info_slug]);
					$ret .= '</div>';
				}
			}

			return $ret;
		} // kingster_get_social_info
	}