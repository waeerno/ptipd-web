<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('event', 'gdlr_core_pb_element_event'); 
	}
	
	if( !class_exists('gdlr_core_pb_element_event') ){
		class gdlr_core_pb_element_event{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'icon_briefcase',
					'title' => esc_html__('Event List', 'kingster')
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
								'options' => gdlr_core_get_term_list('tribe_events_cat'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'kingster'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('post_tag')
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'number',
								'default' => 9,
								'description' => esc_html__('The number of posts showing on the blog item', 'kingster')
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
					), // general

					'style' => array(
						'title' => esc_html__('Style2', 'kingster'),
						'options' => array(	
							'event-style' => array(
								'title' => esc_html__('Event Style', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'widget' => esc_html__('Widget', 'kingster'),
									'grid' => esc_html__('Grid', 'kingster'),
								),
								'default' => 'grid'
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'kingster'),
								'type' => 'combobox',
								'options' => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5 ),
								'default' => 3,
								'condition' => array('event-style' => 'grid')
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'kingster'),
								'type' => 'combobox',
								'options' => 'thumbnail-size',
								'condition' => array('event-style' => 'grid')
							),
						)
					),

					'spacing' => array(
						'title' => esc_html__('Spacing', 'kingster'),
						'options' => array(
							'event-bottom-margin' => array(
								'title' => esc_html__('Event Bottom Margin ( Space Between Each Item )', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom ( Item )', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							)
						)
					),

					'item-title' => array(
						'title' => esc_html__('Item Title', 'kingster'),
						'options' => gdlr_core_block_item_option()
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
				$ret  = '<div class="gdlr-core-event-item gdlr-core-item-pdb" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				if( defined('TRIBE_EVENTS_FILE') ){

					$title_settings = $settings;
					$ret .= gdlr_core_block_item_title($title_settings);

					$query = self::query_post($settings);
					$settings['paged'] = empty($query->query['paged'])? 1: $query->query['paged'];

					gdlr_core_setup_admin_postdata();
					if( $query->have_posts() ){

						$count = 0;
						$settings['event-style'] = empty($settings['event-style'])? 'grid': $settings['event-style'];
						$settings['column-size'] = empty($settings['column-size'])? 3: intval($settings['column-size']);

						$ret .= '<div class="gdlr-core-event-item-holder clearfix" >';
						while($query->have_posts()){ $query->the_post(); $count++;
							$extra_class  = 'gdlr-core-style-' . $settings['event-style'] . ' ';
							$extra_class .= 'gdlr-core-item-pdlr ';

							if( $settings['event-style'] == 'grid' ){
								$extra_class .= 'gdlr-core-column-' . (60 / $settings['column-size']) . ' ';
								if( $settings['column-size'] == 1 || $count % $settings['column-size'] == 1 ){
									$extra_class .= 'gdlr-core-column-first ';
								}
							}
							
							$ret .= '<div class="gdlr-core-event-item-list ' . esc_attr($extra_class) . ' clearfix" ' . gdlr_core_esc_style(array(
								'margin-bottom' => empty($settings['event-bottom-margin'])? '': $settings['event-bottom-margin']
							)) . ' >';
							if( $settings['event-style'] == 'widget' ){
								$ret .= self::get_event_widget($settings);
							}else if( $settings['event-style'] == 'grid' ){
								$ret .= self::get_event_grid($settings);
							}
							$ret .= '</div>';
						}
						$ret .= '</div>';

						if( !empty($settings['pagination']) && $settings['pagination'] == 'page' ){
							$ret .= gdlr_core_get_pagination($query->max_num_pages, $settings, 'gdlr-core-item-pdlr');
						}
					}else{
						$ret .= '<div class="gdlr-core-course-not-found" >';
						$ret .= esc_html__('There\'re no item that match your search criteria. Please try again with different keywords.', 'kingster');
						$ret .= '</div>';
					}

					wp_reset_postdata();
					gdlr_core_reset_admin_postdata();
				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('Please activate "The Events Calendar" plugin to use this item', 'kingster') . '</div>';
				}
				
				$ret .= '</div>';


				return $ret;
			}

			static function query_post( $settings = array() ){

				if( !empty($settings['query']) ){ return $settings['query']; }

				$args = array('post_type' => 'tribe_events', 'post_status' => 'publish', 'suppress_filters' => false);
				
				// category - tag selection
				$args['tax_query'] = array('relation' => 'OR');
				
				if( !empty($settings['category']) ){
					if( !is_array($settings['category']) ){
						$settings['category'] = array_map('trim', explode(',', $settings['category']));
					}
					array_push($args['tax_query'], array('terms'=>$settings['category'], 'taxonomy'=>'tribe_events_cat', 'field'=>'slug'));
				}
				if( !empty($settings['tag']) ){
					if( !is_array($settings['tag']) ){
						$settings['tag'] = array_map('trim', explode(',', $settings['tag']));
					}
					array_push($args['tax_query'], array('terms'=>$settings['tag'], 'taxonomy'=>'post_tag', 'field'=>'slug'));
				}

				// order
				$args['order'] = empty($settings['order'])? 'desc': $settings['order'];
				$args['orderby'] = empty($settings['orderby'])? 'date': $settings['orderby'];
				
				$args['posts_per_page'] = empty($settings['num-fetch'])? 9: $settings['num-fetch'];

				$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				$args['paged'] = empty($args['paged'])? 1: $args['paged'];

				return new WP_Query( $args );
			}

			static function get_event_widget($settings = array()){
				$ret = '';

				$ret .= self::get_event_info(array('start-date-month'), false);

				$ret .= '<div class="gdlr-core-event-item-content-wrap" >';
				$ret .= '<h3 class="gdlr-core-event-item-title" ><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
				
				$ret .= self::get_event_info(array('time', 'location'));
				$ret .= '</div>';

				return $ret;
			}
			static function get_event_grid($settings = array()){
				$ret = '';

				$thumbnail_id = get_post_thumbnail_id();
				if( !empty($thumbnail_id) ){
					$settings['thumbnail-size'] = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];
					
					$ret .= '<div class="gdlr-core-event-item-thumbnail" ><a href="' . get_permalink() . '" >';
					$ret .= gdlr_core_get_image($thumbnail_id, $settings['thumbnail-size']);
					$ret .= '</a></div>';
				}

				$ret .= self::get_event_info(array('start-date-month'), false);

				$ret .= '<div class="gdlr-core-event-item-content-wrap" >';
				$ret .= '<h3 class="gdlr-core-event-item-title" ><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
				
				$ret .= self::get_event_info(array('time', 'location'));
				$ret .= '</div>';

				return $ret;
			}
			static function get_event_info($types = array(), $wrap = true ){
				$ret = '';

				foreach( $types as $type ){
					$temp = '';

					switch($type){
						case 'start-date-month':
							$event = get_post();
							$temp .= '<span class="gdlr-core-date" >' . tribe_get_start_date($event, false, 'd') . '</span>'; //d
							$temp .= '<span class="gdlr-core-month" >' . tribe_get_start_date($event, false, 'M') . '</span>'; //M
							break;

						case 'time':
							$event = get_post();
							$start_date = tribe_get_start_date($event, false, 'Y m d');
							$end_date = tribe_get_start_date($event, false, 'Y m d');

							$temp .= '<span class="gdlr-core-head" ><i class="icon_clock_alt" ></i></span>';
								
							if( $start_date == $end_date ){
								$temp .= '<span class="gdlr-core-tail" >' . tribe_get_start_date($event, true, 'g:i a') . ' - ' . tribe_get_end_date($event, true, 'g:i a') . '</span>';
							}else{
								$temp .= '<span class="gdlr-core-tail" >' . tribe_get_start_date($event, true, 'g:i a') . '</span>';
							}
							break;

						case 'location':
							$location = tribe_get_venue(get_the_ID());

							if( !empty($location) ){
								$temp .= '<span class="gdlr-core-head" ><i class="icon_pin_alt" ></i></span>';
								$temp .= '<span class="gdlr-core-tail" >' . $location . '</span>';
							}
							break;

						default:
							break;
					}

					if( !empty($temp) ){
						$ret .= '<span class="gdlr-core-event-item-info gdlr-core-type-' . $type . '" >' . $temp . '</span>';
					}
				}
				

				if( $wrap && !empty($ret) ){
					$ret = '<div class="gdlr-core-event-item-info-wrap" >' . $ret . '</div>';
				}

				return $ret;
			}
			
		} // gdlr_core_pb_element_event
	} // class_exists	