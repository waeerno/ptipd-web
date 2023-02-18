<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('lp-course-info', 'kingster_lp_pb_element_course_info'); 
	}
	
	if( !class_exists('kingster_lp_pb_element_course_info') ){
		class kingster_lp_pb_element_course_info{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Learnpress Course Info', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(

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
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}


				// start printing item
				$extra_class = empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="kingster-lp-course-info-item gdlr-core-item-pdlr gdlr-core-item-mgb ' . esc_attr($extra_class) . ' clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('margin-bottom'=>$settings['margin-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';
				$ret .= '<div class="kingster-lp-course-info-item-inner" >';

				$course_id = get_the_ID();
				if( empty($course_id) ){
					global $page_builder_post_id; 
					$course_id = $page_builder_post_id;
				}

				$settings['types'] = empty($settings['types'])? array('teacher', 'category', 'review', 'wishlist'): $settings['types'];
				$column_size = 60 / sizeof($settings['types']); 
				$count = 0;
				foreach( $settings['types'] as $type ){ $count++;
					$ret .= '<div class="kingster-lp-course-info gdlr-core-column-' . esc_attr($column_size) . ' kingster-type-' . esc_attr($type) . ' clearfix" >';
					$ret .= ($count == 1)? '': '<div class="kingster-lp-course-info-divider" ></div>';
					$ret .= '<div class="kingster-lp-course-info-content" >';
					
					$ret .= kingster_lp_get_course_info($type, $course_id);

					$ret .= '</div>'; // course-info-content
					$ret .= '</div>'; // course-info-divider
				}

				$ret .= '</div>'; // kingster-lp-course-info-item-inner
				$ret .= '</div>';

				return $ret;
			}
			
		} // kingster_lp_pb_element_course_info
	} // class_exists	

	if( !function_exists('kingster_lp_get_course_info') ){
		function kingster_lp_get_course_info( $type, $course_id, $course_object = null ){

			$ret = '';

			if( empty($course_object) ){
				$course_object = learn_press_get_course($course_id);
			}

			switch( $type ){
				case 'student':
					if( empty($course_object) ){ break; }

					$ret .= '<div class="kingster-head" >' . esc_html__('Students', 'kingster') . '</div>';
					$ret .= '<div class="kingster-tail" >' . $course_object->count_students() . '</div>';
					break;
				case 'student2':
					if( empty($course_object) ){ break; }

					$student_count = $course_object->count_students();
					$ret .= '<div class="kingster-head" ><i class="icon-people"></i></div>';
					$ret .= '<div class="kingster-tail" >';
					$ret .= sprintf(($student_count > 1)? esc_html__('%d Students', 'kingster'): esc_html__('%d Student', 'kingster'), $student_count);
					$ret .= '</div>';
					break;

				case 'duration':
					if( empty($course_object) ){ break; }

					$duration = $course_object->get_data('duration');
					if( !empty($duration) ){
						$ret .= '<div class="kingster-head" >' . esc_html__('Duration', 'kingster') . '</div>';
						$ret .= '<div class="kingster-tail" >' . $course_object->get_data('duration') . '</div>';
					}
					break;

				case 'lecture':
					if( empty($course_object) ){ break; }

					$lecture_count = $course_object->count_items('lp_lesson');
					$ret .= '<div class="kingster-head" >' . esc_html__('Lecture', 'kingster') . '</div>';
					$ret .= '<div class="kingster-tail" >' . $lecture_count . '</div>';
					break; 
				case 'lecture2':
					if( empty($course_object) ){ break; }

					$lecture_count = $course_object->count_items('lp_lesson');
					$ret .= '<div class="kingster-head" ><i class="icon-book-open"></i></div>';
					$ret .= '<div class="kingster-tail" >';
					$ret .= sprintf(($lecture_count > 1)? esc_html__('%d Lessons', 'kingster'): esc_html__('%d Lesson', 'kingster'), $lecture_count);
					$ret .= '</div>';
					break; 

				case 'teacher':
					if( empty($course_object) ){ break; }
					
					$ret .= '<div class="kingster-author-thumbnail gdlr-core-media-image" >' . $course_object->get_instructor()->get_profile_picture() . '</div>';
					$ret .= '<div class="kingster-author-content" >';
					$ret .= '<div class="kingster-head" >' . esc_html__('Teacher', 'kingster') . '</div>';
					$ret .= '<div class="kingster-tail" >' . $course_object->get_instructor_html() . '</div>';
					$ret .= '</div>';
					break;

				case 'category':
					$category = get_the_term_list( $course_id, 'course_category', '', ', ', '' );
					if( !empty($category) ){
						$ret .= '<div class="kingster-head" >' . esc_html__('Category', 'kingster') . '</div>';
						$ret .= '<div class="kingster-tail" >' . $category . '</div>';
					}
					break;

				case 'review':
					$ret .= '<div class="kingster-head" >' . esc_html__('Review', 'kingster') . '</div>';
					if( function_exists('learn_press_get_course_rate') ){
						$course_rate_res = learn_press_get_course_rate( $course_id, false );
						$rate_percent = ( !$course_rate_res['rated'] ) ? 0 : min( 100, ( round( $course_rate_res['rated'] * 2 ) / 2 ) * 20 );

						$ret .= '<div class="kingster-tail" >';
            			$ret .= '<div class="review-stars-rated" >';
			    		$ret .= '<div class="review-stars empty"></div>';
			   			$ret .= '<div class="review-stars filled" style="width: ' . esc_attr($rate_percent) . '%;"></div>';
						$ret .= '</div>';
						$ret .= '<span class="kingster-text" >(' . $course_rate_res['rated'] . '/5)</span>';
						$ret .= '</div>';
					}else{
						$ret .= '<div class="kingster-tail" >' . esc_html__('Please install "LearnPress - Course Review" plugin') . '</div>';
					}
					break;

				case 'wishlist':
					if( class_exists('LP_Addon_Wishlist') ){

						$user_id = get_current_user_id();
						$state   = learn_press_user_wishlist_has_course($course_id, $user_id)? 'on' : 'off';
						$ret .= '<div class="kingster-middle" >';
						$ret .= '<div class="course-wishlist learn-press-course-wishlist-button-' . esc_attr($course_id) . ' ' . esc_attr($state) . '" ';
						$ret .= 'data-id="' . esc_attr($course_id) . '" ';
						$ret .= 'data-nonce="' . wp_create_nonce('course-toggle-wishlist') . '" ';
						$ret .= ' ></div>';
						$ret .= '<div class="kingster-lp-course-wishlist" >';
						$ret .= '<i class="fa fa-bookmark-o" ></i>';
						$ret .= '<span class="kingster-text" >' . esc_html__('Wishlist', 'kingster') . '</span>';
						$ret .= '</div>';
						$ret .= '</div>';
					}else{
						// $ret .= '<div class="kingster-head" >' . esc_html__('Wishlist', 'kingster') . '</div>';
						// $ret .= '<div class="kingster-tail" >' . esc_html__('Please install "LearnPress - Course Wishlist" plugin') . '</div>';
					}
					break;
			}

			return $ret;

		} // kingster_lp_get_course_info
	}