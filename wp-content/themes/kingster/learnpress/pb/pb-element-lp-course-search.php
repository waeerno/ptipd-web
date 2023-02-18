<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('lp-course-search', 'kingster_lp_pb_element_course_search'); 
	}
	
	if( !class_exists('kingster_lp_pb_element_course_search') ){
		class kingster_lp_pb_element_course_search{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Learnpress Course Search', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(
							'type' => array(
								'title' => esc_html__('Type', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'course_category' => esc_html__('Course Category', 'kingster'),
									'course_tag' => esc_html__('Course Tag', 'kingster'),
									'keywords' => esc_html__('Keywords', 'kingster')
								),
								'default' => array('course_category', 'keywords')
							)
						)
					), 

					'spacing' => array(
						'title' => esc_html__('Spacing', 'kingster'),
						'options' => array(
							'form-max-width' => array(
								'title' => esc_html__('Form Max Width', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'form-align' => array(
								'title' => esc_html__('Form Align', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'center'
							),
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'kingster'),
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
				$content  = self::get_content($settings, true);
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}

				$settings['type'] = empty($settings['type'])? array('course_category', 'keywords'): $settings['type'];
				$column_size = sizeof($settings['type']);

				// start printing item
				$extra_class = empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="kingster-lp-course-search-item gdlr-core-item-pdlr gdlr-core-item-mgb ' . esc_attr($extra_class) . ' clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('margin-bottom'=>$settings['margin-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				
				if( !class_exists('LearnPress') ){
					$ret .= '<div class="gdlr-core-external-plugin-message">';
					$ret .= esc_html__('Please install and activate Learnpress plugin to use this item.', 'goodlayers-core');
					$ret .= '</div>';
				}else{ 
					$ret .= '<' . ($preview? 'div': 'form') . ' class="kingster-lp-course-search';
					$ret .= ' kingster-lp-size-' . esc_attr($column_size) . ' ';
					$ret .= ' kingster-lp-align-' . (empty($settings['form-align'])? 'center': $settings['form-align']);
					$ret .= ' clearfix" ';
					$ret .= gdlr_core_esc_style(array(
						'max-width' => empty($settings['form-max-width'])? '': $settings['form-max-width']
					));
					$ret .= ' action="' . esc_attr(learn_press_get_page_link('courses')) . '" >';
					
					if( in_array('course_category', $settings['type']) ){
						$categories = gdlr_core_get_term_list('course_category');
						$categories = array('' => esc_html__('Categories', 'kingster')) + $categories;

						$ret .= '<div class="kingster-lp-course-search-column" >';
						$ret .= '<div class="kingster-combobox" >';
						$ret .= '<select name="course_category" >';
						foreach( $categories as $slug => $name ){
							$ret .= '<option value="' . esc_attr($slug) . '" >' . esc_html($name) . '</option>';
						} 
						$ret .= '</select>';
						$ret .= '</div>';
						$ret .= '</div>';
					}

					if( in_array('course_tag', $settings['type']) ){
						$categories = gdlr_core_get_term_list('course_tag');
						$categories = array('' => esc_html__('Tags', 'kingster')) + $categories;

						$ret .= '<div class="kingster-lp-course-search-column" >';
						$ret .= '<div class="kingster-combobox" >';
						$ret .= '<select name="course_tag" >';
						foreach( $categories as $slug => $name ){
							$ret .= '<option value="' . esc_attr($slug) . '" >' . esc_html($name) . '</option>';
						} 
						$ret .= '</select>';
						$ret .= '</div>';
						$ret .= '</div>';
					}


					if( in_array('keywords', $settings['type']) ){
						$ret .= '<div class="kingster-lp-course-search-column" >';
						$ret .= '<input type="text" name="s" value="" placeholder="' . esc_attr(esc_html__('Enter your keyword...', 'kingster')) . '" />';
						$ret .= '</div>';
					}else{
						$ret .= '<input type="hidden" name="s" value="" />';
					}
					$ret .= '<input type="hidden" name="ref" value="course"/>';

					$ret .= '<div class="kingster-lp-course-search-column kingster-lp-type-button" >';
		    		$ret .= '<input type="submit" value="' . esc_html__('Search', 'kingster') . '" />';
		    		$ret .= '</div>';

					$ret .= '</' . ($preview? 'div': 'form') . '>';
				}
				
				$ret .= '</div>';

				return $ret;
			}
			
		} // kingster_lp_pb_element_course_search
	} // class_exists	