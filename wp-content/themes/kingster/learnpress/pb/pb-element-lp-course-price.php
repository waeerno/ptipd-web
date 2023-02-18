<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('lp-course-price', 'kingster_lp_pb_element_course_price'); 
	}
	
	if( !class_exists('kingster_lp_pb_element_course_price') ){
		class kingster_lp_pb_element_course_price{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Learnpress Course Price', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(
							'price-font-size' => array(
								'title' => esc_html__('Price Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
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

				$custom_style = '';
				if( !empty($settings['price-font-size']) ){
					$custom_style = '#custom_style_id.kingster-lp-course-price-item .course-price .price{ font-size: ' . $settings['price-font-size'] . '; }';
				}
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $gdlr_core_lp_course_price_id;
						$gdlr_core_lp_course_price_id = empty($gdlr_core_lp_course_price_id)? array(): $gdlr_core_lp_course_price_id;

						// generate unique id so it does not get overwritten in admin area
						$rnd_course_price_id = mt_rand(0, 99999);
						while( in_array($rnd_course_price_id, $gdlr_core_lp_course_price_id) ){
							$rnd_course_price_id = mt_rand(0, 99999);
						}
						$gdlr_core_lp_course_price_id[] = $rnd_course_price_id;
						$settings['id'] = 'gdlr-core-lp-course-price-' . $rnd_course_price_id;
					}

					$custom_style = str_replace('custom_style_id', $settings['id'], $custom_style); 
					if( $preview ){
						$custom_style = '<style>' . $custom_style . '</style>';
					}else{
						gdlr_core_add_inline_style($custom_style);
						$custom_style = '';
					}
				}

				// start printing item
				$extra_class = empty($settings['class'])? '': ' ' . $settings['class'];
				$ret  = '<div class="kingster-lp-course-price-item gdlr-core-item-pdlr gdlr-core-item-mgb ' . esc_attr($extra_class) . ' clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('margin-bottom'=>$settings['margin-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				if( class_exists('LP_Global') ){
					$user = LP_Global::user();
				}
				if( empty($user) && class_exists('LP_User') ){
					global $current_user;
					$user = new LP_User($current_user->ID);
				}

				if( !is_admin() ){

					$ret .= kingster_lp_get_course_price(get_the_ID());

					// course button
					ob_start();

					do_action( 'learn-press/course-buttons' );
					#learn_press_course_external_button();
					#learn_press_course_purchase_button();
					#learn_press_course_enroll_button();

					$ret .= ob_get_contents();
					ob_end_clean();
				}else{

					$ret .= '<div class="course-price">';
					$ret .= '<span class="price "><span class="kingster-currency-symbol">$</span>10</span>';
					$ret .= '</div>';
					$ret .= '<button class="lp-button button button-purchase-course">Purchase</button>';

				}

				$ret .= '</div>' . $custom_style;

				return $ret;
			}
			
		} // kingster_lp_pb_element_course_price
	} // class_exists	

	if( !function_exists('kingster_lp_get_course_price') ){
		function kingster_lp_get_course_price($course_id){

			if( !class_exists('LP_Global') ) return;
			
			$course = LP_Global::course();
			if( empty($course) ){
				$course = learn_press_get_course($course_id);
			}

			$price = $course->get_price_html();

			$ret  = '<div class="course-price">';
			if( $course->has_sale_price() ){
    			$ret .= '<span class="origin-price">' . $course->get_origin_price_html() . '</span>';
			}
			$ret .= '<span class="price ';
			$ret .= $course->is_free()? 'free': '';
			$ret .= '">' . $price . '</span>';
			$ret .= '</div>'; // course-price

			return $ret;
		}
	}