<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	add_action('plugins_loaded', 'gdlr_core_pb_element_course_info_init');
	if( !function_exists('gdlr_core_pb_element_course_info_init') ){
		function gdlr_core_pb_element_course_info_init(){
			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('course-info', 'gdlr_core_pb_element_course_info'); 
			}
		}
	} 
	
	if( !class_exists('gdlr_core_pb_element_course_info') ){
		class gdlr_core_pb_element_course_info{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Course Info', 'goodlayers-core-course')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core-course'),
						'options' => array(

							'course-info' => array(
								'title' => esc_html__('Course Info', 'goodlayers-core-course'),
								'type' => 'multi-combobox',
								'options' => array(
									'course-id' => esc_html__('Course ID', 'goodlayers-core-course')
								) + goodlayers_core_course_get_custom_tax_list()
							),
							'column' => array(
								'title' => esc_html__('Column', 'goodlayers-core-course'),
								'type' => 'combobox',
								'options' => array(
									'60' => '1',
									'30' => '2',
									'20' => '3',
									'15' => '4',
									'12' => '5',
								)
							)

						)
					), // general

					'color' => array(
						'title' => esc_html__('Color', 'goodlayers-core-course'),
						'options' => array(

							'background-color' => array(
								'title' => esc_html__('Background Color', 'goodlayers-core-course'),
								'type' => 'colorpicker'
							),
							'text-color' => array(
								'title' => esc_html__('Text Color', 'goodlayers-core-course'),
								'type' => 'colorpicker'
							),

						)
					),

					'spacing' => array(
						'title' => esc_html__('Spacing', 'goodlayers-core-course'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'goodlayers-core-course'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					)
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
					$settings = array( 'padding-bottom' => $gdlr_core_item_pdb );
				}
				
				// start printing item
				$ret  = '<div class="gdlr-core-course-info-item gdlr-core-item-pdlr gdlr-core-item-pdb" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				$post_id = get_the_ID();
				if( empty($post_id) && !empty($page_builder_post_id) ){
					$post_id = $page_builder_post_id;
				}

				if( !empty($settings['course-info']) && !empty($post_id) ){
					$ret .= '<div class="gdlr-core-course-info-item-inner clearfix" ' . gdlr_core_esc_style(array(
						'color' => empty($settings['text-color'])? '': $settings['text-color'],
						'background-color' => empty($settings['background-color'])? '': $settings['background-color'],
					)) . ' >';

					$settings['column'] = empty($settings['column'])? 60: $settings['column'];
					$column_size = intval(60 / $settings['column']);
					$taxs = goodlayers_core_course_get_custom_tax_list();

					$count = 0;
					foreach( $settings['course-info'] as $tax_slug ){ $count++;
						$column_class  = 'gdlr-core-pbf-column gdlr-core-column-' . esc_attr($settings['column']);
						$column_class .= ($count % $column_size == 1)? ' gdlr-core-column-first': '';

						$ret .= '<div class="' . esc_attr($column_class) . '" >';
						if( $tax_slug == 'course-id' ){
							$course_id = get_post_meta($post_id, 'goodlayers-core-course-id', true);
							$ret .= '<div class="gdlr-core-head" >' . esc_html__('Course ID', 'goodlayers-core-course') . '</div>';
							$ret .= '<div class="gdlr-core-tail" >' . gdlr_core_text_filter($course_id) . '</div>';
						}else{
							$terms = get_the_terms($post_id, $tax_slug);
							$term_name = '';
							if( !empty($terms) ){
								foreach( $terms as $term ){
									$term_name .= empty($term_name)? '': ', ';
									$term_name .= $term->name; 
								}
							}
							

							$ret .= '<div class="gdlr-core-head" >' . $taxs[$tax_slug] . '</div>';
							$ret .= '<div class="gdlr-core-tail" >' . gdlr_core_text_filter($term_name) . '</div>';
						}
						$ret .= '</div>';
					}
					
					$ret .= '</div>';
				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('Please select the information you want to display', 'goodlayers-core-course') . '</div>';
				}

				$ret .= '</div>';

				return $ret;
			}
			
		} // gdlr_core_pb_element_course_info
	} // class_exists	