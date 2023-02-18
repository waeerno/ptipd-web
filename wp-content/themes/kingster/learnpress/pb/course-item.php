<?php
	/*	
	*	Goodlayers Blog Item
	*/
	
	if( !class_exists('kingster_lp_course_item') ){
		class kingster_lp_course_item{
			
			var $settings = '';
			
			// init the variable
			function __construct( $settings = array() ){
				
				$this->settings = wp_parse_args($settings, array(
					'category' => '', 
					'num-fetch' => '9', 
					'thumbnail-size' => 'full', 
					'orderby' => 'date', 
					'order' => 'desc',
					'course-style' => 'grid', 
					'excerpt' => 'specify-number', 
					'excerpt-number' => 55, 
					'column-size' => 20,
					'pagination' => 'none'
				));

				if( $this->settings['orderby'] == 'rand' ){
					$this->settings['orderby'] = 'RAND(' . rand(1, 1000) . ')';
				} 
			}
			
			// get the content of the blog item
			function get_content(){
				
				if( !empty($this->settings['column-size']) ){
					gdlr_core_set_container_multiplier(intval($this->settings['column-size']) / 60, false);
				}

				$ret = '';
				if( empty($this->settings['query']) ){
					$query = $this->get_course_query();
				}else{
					$query = $this->settings['query'];
				}

				// carousel style
				if( $this->settings['layout'] == 'carousel' ){
					$slides = array();
					$column_no = 60 / intval($this->settings['column-size']);

					$flex_atts = array(
						'carousel' => true,
						'column' => $column_no,
						'move' => empty($this->settings['carousel-scrolling-item-amount'])? '': $this->settings['carousel-scrolling-item-amount'],
						'navigation' => empty($this->settings['carousel-navigation'])? 'navigation': $this->settings['carousel-navigation'],
						'navigation-on-hover' => empty($this->settings['carousel-navigation-show-on-hover'])? 'disable': $this->settings['carousel-navigation-show-on-hover'],
						'navigation-align' => empty($this->settings['carousel-navigation-align'])? '': $this->settings['carousel-navigation-align'],
						'navigation-size' => empty($this->settings['carousel-navigation-size'])? '': $this->settings['carousel-navigation-size'],
						'navigation-icon-color' => empty($this->settings['carousel-navigation-icon-color'])? '': $this->settings['carousel-navigation-icon-color'],
						'navigation-icon-background' => empty($this->settings['carousel-navigation-icon-bg'])? '': $this->settings['carousel-navigation-icon-bg'],
						'navigation-icon-padding' => empty($this->settings['carousel-navigation-icon-padding'])? '': $this->settings['carousel-navigation-icon-padding'],
						'navigation-icon-radius' => empty($this->settings['carousel-navigation-icon-radius'])? '': $this->settings['carousel-navigation-icon-radius'],
						'navigation-margin' => empty($this->settings['carousel-navigation-margin'])? '': $this->settings['carousel-navigation-margin'],
						'navigation-icon-margin' => empty($this->settings['carousel-navigation-icon-margin'])? '': $this->settings['carousel-navigation-icon-margin'],
						'navigation-left-icon' => empty($this->settings['carousel-navigation-left-icon'])? '': $this->settings['carousel-navigation-left-icon'],
						'navigation-right-icon' => empty($this->settings['carousel-navigation-right-icon'])? '': $this->settings['carousel-navigation-right-icon'],
						'bullet-style' => empty($this->settings['carousel-bullet-style'])? '': $this->settings['carousel-bullet-style'],
						'controls-top-margin' => empty($this->settings['carousel-bullet-top-margin'])? '': $this->settings['carousel-bullet-top-margin'],
						'nav-parent' => 'kingster-lp-course-list-item',
						'disable-autoslide' => (empty($this->settings['carousel-autoslide']) || $this->settings['carousel-autoslide'] == 'enable')? '': true,
					);
					
					gdlr_core_setup_admin_postdata();

					$course_style = new kingster_lp_course_style();
					while($query->have_posts()){ $query->the_post();
						$slides[] = $course_style->get_content( $this->settings );
					} // while

					$ret .= gdlr_core_get_flexslider($slides, $flex_atts);

					wp_reset_postdata();
					gdlr_core_reset_admin_postdata();
					
				// fitrows style
				}else{
					
					gdlr_core_setup_admin_postdata();

					$ret .= '<div class="kingster-lp-course-list-item-holder gdlr-core-js-2 clearfix" data-layout="' . $this->settings['layout'] . '" >';
					if( $query->have_posts() ){
						$ret .= $this->get_course_grid_content($query);
					}
					$ret .= '</div>';

					wp_reset_postdata();
					gdlr_core_reset_admin_postdata();

					// pagination
					if( $this->settings['pagination'] != 'none' ){
						$extra_class = ($this->settings['no-space'] == 'yes')? '': 'gdlr-core-item-pdlr';

						if( $this->settings['pagination'] == 'page' ){
							$ret .= gdlr_core_get_pagination($query->max_num_pages, $this->settings, $extra_class);
						}
					}
				}

				gdlr_core_set_container_multiplier(1, false);

				return $ret;
			}

			// get content of non carousel blog item
			function get_course_grid_content( $query ){

				$ret = '';
				$column_sum = 0;
				$course_style = new kingster_lp_course_style();
				while($query->have_posts()){ $query->the_post();

					$args = $this->settings;

					$additional_class  = ' gdlr-core-item-pdlr';
					if( !empty($this->settings['column-size']) ){
						$additional_class .= empty($this->settings['column-size'])? '': ' gdlr-core-column-' . $this->settings['column-size'];
					}

					if( $column_sum == 0 || $column_sum + intval($this->settings['column-size']) > 60 ){
						$column_sum = intval($this->settings['column-size']);
						$additional_class .= ' gdlr-core-column-first';
					}else{
						$column_sum += intval($this->settings['column-size']);
					}

					$ret .= '<div class="gdlr-core-item-list ' . esc_attr($additional_class) . '" >';

					$ret .= $course_style->get_content($args);

					$ret .= '</div>';
				} // while

				return $ret;
			}
			
			// query the post
			function get_course_query(){
				
				$args = array( 'post_type' => 'lp_course', 'post_status' => 'publish', 'suppress_filters' => false );
				
				// category - tag selection
				if( !empty($this->settings['category']) || !empty($this->settings['tag']) ){
					$args['tax_query'] = array('relation' => 'OR');
					
					if( !empty($this->settings['category']) ){
						$this->settings['category'] = is_array($this->settings['category'])? $this->settings['category']: explode(',', $this->settings['category']);
						array_push($args['tax_query'], array('terms'=>$this->settings['category'], 'taxonomy'=>'course_category', 'field'=>'slug'));
					}
					if( !empty($this->settings['tag']) ){
						$this->settings['tag'] = is_array($this->settings['tag'])? $this->settings['tag']: explode(',', $this->settings['tag']);
						array_push($args['tax_query'], array('terms'=>$this->settings['tag'], 'taxonomy'=>'course_tag', 'field'=>'slug'));
					}
				}

				// author
				if( !empty($this->settings['author']) ){
					$args['author__in'] = $this->settings['author'];
				}

				// pagination
				if( $this->settings['pagination'] != 'none' ){
					if( empty($this->settings['paged']) ){
						$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
						$args['paged'] = empty($args['paged'])? 1: $args['paged'];
					}else{
						$args['paged'] = $this->settings['paged'];
					}
					$this->settings['paged'] = $args['paged'];
				}
				
				// variable
				$args['posts_per_page'] = $this->settings['num-fetch'];
				$args['orderby'] = $this->settings['orderby'];
				$args['order'] = $this->settings['order'];
				
				$query = new WP_Query( $args );

				return $query;
			}
			
		} // kingster_lp_course_item
	} // class_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	