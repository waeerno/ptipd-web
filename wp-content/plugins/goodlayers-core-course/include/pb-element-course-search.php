<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	add_action('plugins_loaded', 'gdlr_core_pb_element_course_search');
	if( !function_exists('gdlr_core_pb_element_course_search') ){
		function gdlr_core_pb_element_course_search(){
			if( class_exists('gdlr_core_page_builder_element') ){
				gdlr_core_page_builder_element::add_element('course-search', 'gdlr_core_pb_element_course_search'); 
			}
		}
	} 
	
	if( !class_exists('gdlr_core_pb_element_course_search') ){
		class gdlr_core_pb_element_course_search{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Course Search', 'goodlayers-core-course')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core-course'),
						'options' => array(

							'title' => array(
								'title' => esc_html__('Title', 'goodlayers-core-course'),
								'type' => 'text'
							),
							'title-align' => array(
								'title' => esc_html__('Title Align', 'goodlayers-core-course'),
								'type' => 'radioimage',
								'options' => 'text-align'
							),
							'search-fields' => array(
								'title' => esc_html__('Search Fields', 'goodlayers-core-course'),
								'type' => 'multi-combobox',
								'options' => array(
									'keywords' => esc_html__('Keywords', 'goodlayers-core-course'),
									'course-id' => esc_html__('Course ID', 'goodlayers-core-course'),
									'course_category' => esc_html__('Course Category', 'goodlayers-core-course'),
									'course_tag' => esc_html__('Course Tag', 'goodlayers-core-course')
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
								)
							),
							'full-size-button' => array(
								'title' => esc_html__('Full Size Button', 'goodlayers-core-course'),
								'type' => 'checkbox',
								'default' => 'enable'
							),
							'with-frame' => array(
								'title' => esc_html__('With Frame', 'goodlayers-core-course'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
							'frame-background' => array(
								'title' => esc_html__('Frame Background', 'goodlayers-core-course'),
								'type' => 'upload',
								'condition' => array( 'with-frame' => 'enable' )
							),

						)
					), // general

					'typography' => array(
						'title' => esc_html__('Typography', 'goodlayers-core-course'),
						'options' => array(
							'title-font-size' => array(
								'title' => esc_html__('Title Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'title-font-weight' => array(
								'title' => esc_html__('Title Font Weight', 'goodlayers-core'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'title-font-letter-spacing' => array(
								'title' => esc_html__('Title Font Letter Spacing', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
						)
					),

					'spacing' => array(
						'title' => esc_html__('Spacing', 'goodlayers-core-course'),
						'options' => array(
							'title-color' => array(
								'title' => esc_html__('Title Color', 'goodlayers-core-course'),
								'type' => 'colorpicker'
							)
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
				$ret  = '<div class="gdlr-core-course-search-item gdlr-core-item-pdb gdlr-core-item-pdlr" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';


				if( empty($settings['search-fields']) ){
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('Please select the information you want to display', 'goodlayers-core-course') . '</div>';
				}else{

					$action_url = gdlr_core_course_get_template_url('search');
					$form_tag = is_admin()? 'div': 'form';
					$column_size = empty($settings['column'])? 60: $settings['column'];
					$column_number = 60 / $column_size;

					$tax_list = array(
						'course_category' => esc_html__('Course Category', 'goodlayers-core-course'),
						'course_tag' => esc_html__('Course Tag', 'goodlayers-core-course')
					) + goodlayers_core_course_get_custom_tax_list();

					if( !empty($settings['with-frame']) && $settings['with-frame'] == 'enable' ){
						$ret .= '<div class="gdlr-core-search-frame" ' . gdlr_core_esc_style(array(
							'background-image' => empty($settings['frame-background'])? '': $settings['frame-background']
						)) . ' >';
					}

					if( !empty($settings['title']) ){
						$title_class = empty($settings['title-align'])? '': 'gdlr-core-' . $settings['title-align'] . '-align';

						$ret .= '<h3 class="gdlr-core-course-search-item-title ' . esc_attr($title_class) . '" ' . gdlr_core_esc_style(array(
							'font-size' => empty($settings['title-font-size'])? '': $settings['title-font-size'],
							'font-weight' => empty($settings['title-font-weigth'])? '': $settings['title-font-weigth'],
							'letter-spacing' => empty($settings['title-font-letter-spacing'])? '': $settings['title-font-letter-spacing'],
							'color' => empty($settings['title-color'])? '': $settings['title-color'],
						)) . ' >' . $settings['title'] . '</h3>';
					}
					$ret .= '<' . $form_tag . ' class="gdlr-core-course-form clearfix" action="' . esc_url($action_url) . '" method="GET" >';
					if( array_search('keywords', $settings['search-fields']) === false ){
						$ret .= '<input type="hidden" name="course-keywords" value="" />';
					}

					$count = 0;
					foreach( $settings['search-fields'] as $search_field ){ $count++;
						$column_class  = ' gdlr-core-course-column';
						$column_class .= ' gdlr-core-column-' . $column_size;
						$column_class .= ($count % $column_number == 1)? ' gdlr-core-column-first': '';

						$ret .= '<div class="' . esc_attr($column_class)  .'" >';
						$ret .= '<div class="gdlr-core-course-search-field gdlr-core-course-field-' . esc_attr($search_field) . '" >';

						switch( $search_field ){
							case 'keywords':
								$ret .= '<input type="text" placeholder="' . esc_html__('Keywords', 'goodlayers-core-course') . '" name="course-keywords" value="" />';
								break;
							case 'course-id': 
								$ret .= '<input type="text" placeholder="' . esc_html__('Course ID', 'goodlayers-core-course') . '" name="course-id" value="" />';
								break;
							default :
								$terms = gdlr_core_get_term_list($search_field);

								$ret .= '<div class="gdlr-core-course-form-combobox gdlr-core-skin-e-background" >';
								$ret .= '<select class="gdlr-core-skin-e-content" name="' . esc_attr($search_field) . '" >';
								$ret .= '<option value="" >' . $tax_list[$search_field] . '</option>';
								foreach( $terms as $term_slug => $term_name ){
									$ret .= '<option value="' . esc_attr($term_slug) . '" >' . $term_name . '</option>';
								}
								$ret .= '</select>';
								$ret .= '</div>';
								break; 
						}	
						$ret .= '</div>';
						$ret .= '</div>';
					}
					
					$ret .= '<div class="gdlr-core-course-form-submit gdlr-core-course-column gdlr-core-column-first gdlr-core-center-align" >';
					$ret .= '<input class="' . ((empty($settings['full-size-button']) || $settings['full-size-button'] == 'enable')? 'gdlr-core-full-size': 'gdlr-core-auto-size') . '" type="submit" value="' . esc_html__('Search Courses', 'goodlayers-core-course') . '" />';
					$ret .= '</div>';
					$ret .= '</' . $form_tag . '>';

					if( !empty($settings['with-frame']) && $settings['with-frame'] == 'enable' ){
						$ret .= '</div>';
					}
				}
				
				$ret .= '</div>';

				return $ret;
			}
			
		} // gdlr_core_pb_element_course_search
	} // class_exists	