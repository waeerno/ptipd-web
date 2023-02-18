<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('lp-course-list', 'kingster_lp_pb_element_course_list'); 
	}
	
	if( !class_exists('kingster_lp_pb_element_course_list') ){
		class kingster_lp_pb_element_course_list{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Learnpress Course List', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(
							'category' => array(
								'title' => esc_html__('Category', 'kingster'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('course_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'kingster'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('course_tag'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'author' => array(
								'title' => esc_html__('Author', 'kingster'),
								'type' => 'multi-combobox',
								'options' => function_exists('gdlr_core_get_author_list')? gdlr_core_get_author_list(array('lp_teacher', 'administrator')): array(),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'kingster'),
								'type' => 'text',
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing on the item', 'kingster')
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'kingster'), 
									'title' => esc_html__('Title', 'kingster'), 
									'rand' => esc_html__('Random', 'kingster'), 
									'menu_order' => esc_html__('Menu Order', 'kingster'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'kingster'), 
									'asc'=> esc_html__('Ascending Order', 'kingster'), 
								)
							),
							'pagination' => array(
								'title' => esc_html__('Pagination', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'kingster'), 
									'page'=>esc_html__('Page', 'kingster'), 
									// 'load-more'=>esc_html__('Load More', 'kingster'), 
								),
							),
							'pagination-style' => array(
								'title' => esc_html__('Pagination Style', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'kingster'),
									'plain' => esc_html__('Plain', 'kingster'),
									'rectangle' => esc_html__('Rectangle', 'kingster'),
									'rectangle-border' => esc_html__('Rectangle Border', 'kingster'),
									'round' => esc_html__('Round', 'kingster'),
									'round-border' => esc_html__('Round Border', 'kingster'),
									'circle' => esc_html__('Circle', 'kingster'),
									'circle-border' => esc_html__('Circle Border', 'kingster'),
								),
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'pagination-align' => array(
								'title' => esc_html__('Pagination Alignment', 'kingster'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'with-default' => true,
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
						)
					), 

					'settings' => array(
						'title' => esc_html__('Course Style', 'kingster'),
						'options' => array(
							'course-style' => array(
								'title' => esc_html__('Course Style', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'grid' => esc_html__('Grid', 'kingster'),
									'left-thumbnail' => esc_html__('Left Thumbnail', 'kingster'),
								),
							),
							'with-frame' => array(
								'title' => esc_html__('With Frame', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('course-style' => 'grid')
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'kingster'),
								'type' => 'combobox',
								'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
								'default' => 20,
								'condition' => array( 'course-style' => array('grid') )
							),
							'course-left-thumbnail-info' => array(
								'title' => esc_html__('Course Left Thumbnail Info', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'category' => esc_html__('Category', 'kingster'),
									'duration' => esc_html__('Duration', 'kingster'),
									'lecture' => esc_html__('Lecture', 'kingster'),
									'review' => esc_html__('Review', 'kingster'),
								),
								'default' => array('category', 'duration', 'lecture', 'review'),
								'condition' => array( 'course-style' => 'left-thumbnail' )
							),
							'course-grid-bottom-info' => array(
								'title' => esc_html__('Course Grid Bottom Info', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'price' => esc_html__('Price', 'kingster'),
									'wishlist' => esc_html__('Wishlist', 'kingster'),
								),
								'default' => array('price', 'wishlist'),
								'condition' => array( 'course-style' => 'grid' )
							),
							'course-grid-bottom-info2' => array(
								'title' => esc_html__('Course Grid Bottom Info 2', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'lecture' => esc_html__('Lesson', 'kingster'),
									'student' => esc_html__('Student', 'kingster'),
								),
								'default' => array('lecture', 'student'),
								'condition' => array( 'course-style' => 'grid' )
							),
							'layout' => array(
								'title' => esc_html__('Layout', 'kingster'),
								'type' => 'combobox',
								'options' => array( 
									'fitrows' => esc_html__('Fit Rows', 'kingster'),
									'carousel' => esc_html__('Carousel', 'kingster'),
									'masonry' => esc_html__('Masonry', 'kingster'),
								),
								'default' => 'fitrows',
							),
							'carousel-scrolling-item-amount' => array(
								'title' => esc_html__('Carousel Scrolling Item Amount', 'kingster'),
								'type' => 'text',
								'default' => '1',
								'condition' => array( 'layout' => 'carousel' )
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'layout' => 'carousel' )
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'kingster'),
								'type' => 'combobox',
								'options' => (function_exists('gdlr_core_get_flexslider_navigation_types')? gdlr_core_get_flexslider_navigation_types(): array()),
								'default' => 'navigation',
								'condition' => array( 'layout' => 'carousel' )
							),
							'carousel-navigation-show-on-hover' => array(
								'title' => esc_html__('Carousel Navigation Display On Hover', 'kingster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array( 'carousel-navigation' => array('navigation-outer', 'navigation-inner') )
							),
							'carousel-navigation-align' => (function_exists('gdlr_core_get_flexslider_navigation_align')? gdlr_core_get_flexslider_navigation_align(): array()),
							'carousel-navigation-left-icon' => (function_exists('gdlr_core_get_flexslider_navigation_left_icon')? gdlr_core_get_flexslider_navigation_left_icon(): array()),
							'carousel-navigation-right-icon' => (function_exists('gdlr_core_get_flexslider_navigation_right_icon')? gdlr_core_get_flexslider_navigation_right_icon(): array()),
							'carousel-navigation-icon-color' => (function_exists('gdlr_core_get_flexslider_navigation_icon_color')? gdlr_core_get_flexslider_navigation_icon_color(): array()),
							'carousel-navigation-icon-bg' => (function_exists('gdlr_core_get_flexslider_navigation_icon_background')? gdlr_core_get_flexslider_navigation_icon_background(): array()),
							'carousel-navigation-icon-padding' => (function_exists('gdlr_core_get_flexslider_navigation_icon_padding')? gdlr_core_get_flexslider_navigation_icon_padding(): array()),
							'carousel-navigation-icon-radius' => (function_exists('gdlr_core_get_flexslider_navigation_icon_radius')? gdlr_core_get_flexslider_navigation_icon_radius(): array()),
							'carousel-navigation-size' => (function_exists('gdlr_core_get_flexslider_navigation_icon_size')? gdlr_core_get_flexslider_navigation_icon_size(): array()),
							'carousel-navigation-margin' => (function_exists('gdlr_core_get_flexslider_navigation_margin')? gdlr_core_get_flexslider_navigation_margin(): array()),
							'carousel-navigation-icon-margin' => (function_exists('gdlr_core_get_flexslider_navigation_icon_margin')? gdlr_core_get_flexslider_navigation_icon_margin(): array()),
							'carousel-bullet-style' => array(
								'title' => esc_html__('Carousel Bullet Style', 'kingster'),
								'type' => 'radioimage',
								'options' => (function_exists('gdlr_core_get_flexslider_bullet_itypes')? gdlr_core_get_flexslider_bullet_itypes(): array()),
								'condition' => array( 'layout' => 'carousel', 'carousel-navigation' => array('bullet','both') ),
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'carousel-bullet-top-margin' => array(
								'title' => esc_html__('Carousel Bullet Top Margin', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'condition' => array( 'layout' => 'carousel', 'carousel-navigation' => array('bullet','both') )
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'kingster'),
								'type' => 'combobox',
								'options' => 'thumbnail-size',
							),
							'excerpt' => array(
								'title' => esc_html__('Excerpt Type', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'specify-number' => esc_html__('Specify Number', 'kingster'),
									'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'kingster'),
								),
								'default' => 'specify-number',
							),
							'excerpt-number' => array(
								'title' => esc_html__('Excerpt Number', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 55,
							),
						)
					),
					
					'shadow' => array(
						'title' => esc_html__('Color/Shadow', 'kingster'),
						'options' => array(
							'frame-shadow-size' => array(
								'title' => esc_html__('Shadow Size ( for image/frame )', 'goodlayers-core'),
								'type' => 'custom',
								'item-type' => 'padding',
								'options' => array('x', 'y', 'size'),
								'data-input-type' => 'pixel',
							),
							'frame-shadow-color' => array(
								'title' => esc_html__('Shadow Color ( for image/frame )', 'goodlayers-core'),
								'type' => 'colorpicker'
							),
							'frame-shadow-opacity' => array(
								'title' => esc_html__('Shadow Opacity ( for image/frame )', 'goodlayers-core'),
								'type' => 'text',
								'default' => '0.2',
								'description' => esc_html__('Fill the number between 0.01 to 1', 'goodlayers-core')
							),
							'enable-move-up-shadow-effect' => array(
								'title' => esc_html__('Move Up Shadow Hover Effect', 'kingster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('Only effects the "Grid With Frame" style', 'kingster')
							),
							'move-up-effect-length' => array(
								'title' => esc_html__('Move Up Hover Effect Length', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-size' => array(
								'title' => esc_html__('Shadow Hover Size', 'kingster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'options' => array('x', 'y', 'size'),
								'data-input-type' => 'pixel',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-color' => array(
								'title' => esc_html__('Shadow Hover Color', 'kingster'),
								'type' => 'colorpicker',
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
							'frame-hover-shadow-opacity' => array(
								'title' => esc_html__('Shadow Hover Opacity', 'kingster'),
								'type' => 'text',
								'default' => '0.2',
								'description' => esc_html__('Fill the number between 0.01 to 1', 'kingster'),
								'condition' => array( 'enable-move-up-shadow-effect' => 'enable' )
							),
						),
					),

					'typography' => array(
						'title' => esc_html__('Typography', 'goodlayers-core'),
						'options' => array(
							'title-font-size' => array(
								'title' => esc_html__('Title Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'title-font-weight' => array(
								'title' => esc_html__('Title Font Weight', 'goodlayers-core'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'title-letter-spacing' => array(
								'title' => esc_html__('Title Letter Spacing', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'title-text-transform' => array(
								'title' => esc_html__('Title Text Transform', 'goodlayers-core'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'none' => esc_html__('None', 'goodlayers-core'),
									'uppercase' => esc_html__('Uppercase', 'goodlayers-core'),
									'lowercase' => esc_html__('Lowercase', 'goodlayers-core'),
									'capitalize' => esc_html__('Capitalize', 'goodlayers-core'),
								),
								'default' => 'none'
							),
						),
					),

					'spacing' => array(
						'title' => esc_html__('Spacing', 'kingster'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'defau6
								ฃ7
								t' => $gdlr_core_item_pdb
							)
						)
					)
				);
			}
			
			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings, true);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script id="gdlr-core-preview-lp-course-<?php echo esc_attr($id); ?>" >
if( document.readyState == 'complete' ){
	jQuery(document).ready(function(){
		var course_preview = jQuery('#gdlr-core-preview-lp-course-<?php echo esc_attr($id); ?>').parent();
		course_preview.gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_content_script();
		new gdlr_core_sync_height(course_preview);
	});
}else{
	jQuery(window).load(function(){
		var course_preview = jQuery('#gdlr-core-preview-lp-course-<?php echo esc_attr($id); ?>').parent();
		course_preview.gdlr_core_flexslider().gdlr_core_isotope().gdlr_core_content_script();
		new gdlr_core_sync_height(course_preview);
	});
}
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
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

				$settings['course-style'] = empty($settings['course-style'])? '': $settings['course-style'];

				$extra_class  = empty($settings['class'])? '': $settings['class'];
				$extra_class .= ' kingster-lp-course-style-' . $settings['course-style'];

				$settings['course-style'] = empty($settings['course-style'])? 'grid': $settings['course-style'];
				if( $settings['course-style'] == 'left-thumbnail' ){
					$settings['column-size'] = 60;
				}

				$settings['layout'] = empty($settings['layout'])? 'fitrows': $settings['layout'];

				// custom css
				$custom_style  = '';
				if( $settings['course-style'] == 'grid' ){
					if( !empty($settings['enable-move-up-shadow-effect']) && $settings['enable-move-up-shadow-effect'] == 'enable' ){
						$custom_style_temp = gdlr_core_esc_style(array(
							'background-shadow-size' => empty($settings['frame-hover-shadow-size'])? '': $settings['frame-hover-shadow-size'],
							'background-shadow-color' => empty($settings['frame-hover-shadow-color'])? '': $settings['frame-hover-shadow-color'],
							'background-shadow-opacity' => empty($settings['frame-hover-shadow-opacity'])? '': $settings['frame-hover-shadow-opacity'],
						), false);

						if( !empty($settings['move-up-effect-length']) ){
							$custom_style_temp .= 'transform: translate3d(0, -' . $settings['move-up-effect-length'] . ', 0); ';
						}

						if( !empty($custom_style_temp) ){
							$custom_style .= '#custom_style_id .gdlr-core-move-up-with-shadow:hover{ ' . $custom_style_temp . ' }';
						}
					}
				}
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $gdlr_core_lp_course_id;
						$gdlr_core_lp_course_id = empty($gdlr_core_lp_course_id)? array(): $gdlr_core_lp_course_id;

						// generate unique id so it does not get overwritten in admin area
						$rnd_course_id = mt_rand(0, 99999);
						while( in_array($rnd_course_id, $gdlr_core_lp_course_id) ){
							$rnd_course_id = mt_rand(0, 99999);
						}
						$gdlr_core_lp_course_id[] = $rnd_course_id;
						$settings['id'] = 'gdlr-core-lp-course-' . $rnd_course_id;
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
				$ret  = '<div class="kingster-lp-course-list-item gdlr-core-item-mgb ' . esc_attr($extra_class) . ' clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('margin-bottom'=>$settings['margin-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// pring item
				if( !class_exists('LearnPress') ){
					$ret .= '<div class="gdlr-core-external-plugin-message">';
					$ret .= esc_html__('Please install and activate Learnpress plugin to use this item.', 'goodlayers-core');
					$ret .= '</div>';
				}else{
					$course_item = new kingster_lp_course_item($settings);
					$ret .= $course_item->get_content();
				}
				

				$ret .= '</div>' . $custom_style;

				if( defined('LP_ADDON_COURSE_REVIEW_URL') ){
					wp_enqueue_script( 'course-review', LP_ADDON_COURSE_REVIEW_URL . '/assets/js/course-review.js', array( 'jquery' ), '', true );
				}
				
				return $ret;
			}
			
		} // kingster_lp_pb_element_course_list
	} // class_exists	