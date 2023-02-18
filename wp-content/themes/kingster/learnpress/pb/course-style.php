<?php
	/*	
	*	Goodlayers Blog Item Style
	*/
	
	if( !class_exists('kingster_lp_course_style') ){
		class kingster_lp_course_style{

			private $item_id;

			function __construct(){
				global $lp_course_style_id;
				$lp_course_style_id = empty($lp_course_style_id)? 1: $lp_course_style_id + 1;

				$this->item_id = $lp_course_style_id;
			}

			// get the content of the blog item
			function get_content( $args ){

				switch( $args['course-style'] ){
					case 'grid': 
						return $this->course_grid( $args );
						break;
					case 'left-thumbnail': 
						return $this->course_left_thumbnail( $args );
						break;
				}
				
			}

			function course_thumbnail( $args = array(), $thumbnail_atts = array() ){
				$ret = '';

				$feature_image = get_post_thumbnail_id();

				if( !empty($feature_image) ){
					$thumbnail_wrap_class  = '';
					if( empty($args['opacity-on-hover']) || $args['opacity-on-hover'] == 'enable' ){
						$thumbnail_wrap_class .= ' gdlr-core-opacity-on-hover';
					}
					if( empty($args['zoom-on-hover']) || $args['zoom-on-hover'] == 'enable' ){
						$thumbnail_wrap_class .= ' gdlr-core-zoom-on-hover';
					}
					if( !empty($args['grayscale-effect']) && $args['grayscale-effect'] == 'enable' ){
						$thumbnail_wrap_class .= ' gdlr-core-grayscale-effect';
					}
						
					$ret .= '<div class="kingster-lp-course-thumbnail gdlr-core-media-image ' . esc_attr($thumbnail_wrap_class) . '" ' . gdlr_core_esc_style($thumbnail_atts) . ' >';
					$ret .= '<a href="' . get_permalink() . '" >';
					$ret .= gdlr_core_get_image($feature_image, $args['thumbnail-size'], array('placeholder' => false));
					$ret .= '</a>';
					$ret .= '</div>';
				}

				return $ret;
			}

			function course_title( $args ){
				$ret  = '<h3 class="kingster-lp-course-title gdlr-core-skin-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($args['title-font-size'])? '': $args['title-font-size'],
					'font-weight' => empty($args['title-font-weight'])? '': $args['title-font-weight'],
					'letter-spacing' => empty($args['title-letter-spacing'])? '': $args['title-letter-spacing'],
					'text-transform' => (empty($args['title-text-transform']) || $args['title-text-transform'] == 'none')? '': $args['title-text-transform']
				)) . ' >';
				if( empty($permalink) ){
					$ret .= '<a href="' . get_permalink() . '" >';
				}else{
					$ret .= '<a href="' . esc_attr($permalink) . '" target="_blank" >';
				}
				$ret .= get_the_title();
				$ret .= '</a>';
				$ret .= '</h3>';

				return  $ret;
			}

			function course_excerpt( $args ){
				$ret = '';

				if( $args['excerpt'] == 'specify-number' ){
					if( !empty($args['excerpt-number']) ){
						$ret .= '<div class="kingster-lp-course-excerpt clearfix" >';
						if( !empty($args['excerpt-number']) ){
							$ret .= $this->get_excerpt($args['excerpt-number']);
							$ret .= '<div class="clear"></div>';
						}
						$ret .= '</div>';
					}
				}else if( $args['excerpt'] != 'none' ){
					$ret .= '<div class="kingster-lp-course-content" >';
					$ret .= gdlr_core_content_filter(get_the_content(), true);
					$ret .= '</div>';
				}

				return $ret;
			}
			function get_excerpt( $excerpt_length ) {
				
				$post = get_post();

				if( empty($post) || post_password_required() ){ return ''; }
			
				$excerpt = $post->post_excerpt;
				if( empty($excerpt) ){
					$excerpt = get_the_content('');
					$excerpt = strip_shortcodes($excerpt);
					
					$excerpt = apply_filters('the_content', $excerpt);
					$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
				}
				
				$excerpt_more = apply_filters('excerpt_more', '...');
				$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
				
				$excerpt = apply_filters('wp_trim_excerpt', $excerpt, $post->post_excerpt);		
				$excerpt = apply_filters('get_the_excerpt', $excerpt);
				
				return $excerpt;
			}	
			
			// blog medium
			function course_left_thumbnail( $args ){

				$course_object = learn_press_get_course(get_the_ID());

				$ret  = '<div class="kingster-lp-course-left-thumbnail clearfix" ' . gdlr_core_esc_style(array(
					'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
				)) . ' >';

				// left thumbnail
				$thumbnail_shadow = array();
				if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
					$thumbnail_shadow['background-shadow-size'] = $args['frame-shadow-size'];
					$thumbnail_shadow['background-shadow-color'] = $args['frame-shadow-color'];
					$thumbnail_shadow['background-shadow-opacity'] = $args['frame-shadow-opacity'];
				}
				$thumbnail_shadow['border-radius'] = empty($args['blog-border-radius'])? '': $args['blog-border-radius'];

				$ret .= '<div class="kingster-lp-course-thumbnail-wrap clearfix" >';
				$ret .= $this->course_thumbnail(array(
					'thumbnail-size' => $args['thumbnail-size'],
					'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
					'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
					'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
				), $thumbnail_shadow);

				$ret .= '<a class="kingster-lp-course-more-button" href="' . get_permalink() . '" >' . esc_html__('More Details', 'kingster') . '</a>';
				$ret .= '</div>';					

				// content
				$ret .= '<div class="kingster-lp-course-content-wrap clearfix">';
				$ret .= $this->course_title( $args );
				
				// course info top
				$types = isset($args['course-left-thumbnail-info'])? $args['course-left-thumbnail-info']: array('category', 'duration', 'lecture', 'review');
				$ret .= '<div class="kingster-lp-course-info-wrap clearfix" >';
				foreach( $types as $type ){ 
					$ret .= '<div class="kingster-lp-course-info kingster-type-' . esc_attr($type) . ' clearfix" >';
					$ret .= kingster_lp_get_course_info($type, get_the_ID(), $course_object);
					$ret .= '</div>'; // course-info-divider
				}
				$ret .= '</div>';

				$ret .= $this->course_excerpt($args);

				// course info bottom
				$types = array('teacher', 'price', 'wishlist');
				$ret .= '<div class="kingster-lp-course-info-bottom-wrap clearfix" >';
				foreach( $types as $type ){ 
					$ret .= '<div class="kingster-lp-course-bottom-info kingster-type-' . esc_attr($type) . ' clearfix" >';
					$ret .= '<div class="kingster-lp-course-bottom-info-divider" ></div>';
					$ret .= '<div class="kingster-lp-course-bottom-info-content">';
					if( $type == 'price' ){
						$ret .= kingster_lp_get_course_price(get_the_ID());
					}else{
						$ret .= kingster_lp_get_course_info($type, get_the_ID(), $course_object);
					}
					
					$ret .= '</div>';
					$ret .= '</div>'; // course-info-divider
				}
				$ret .= '</div>';

				$ret .= '</div>'; // kingster-lp-course-content-wrap

				$ret .= '</div>'; // kingster-lp-course-left-thumbnail
				
				return $ret;
			} 
			
			// course grid
			function course_grid( $args ){

				$course_object = learn_press_get_course(get_the_ID());

				$additional_class = ' gdlr-core-item-mgb gdlr-core-skin-e-background ';
				if( empty($args['with-frame']) || $args['with-frame'] == 'enable' ){
					$additional_class .= ' gdlr-core-with-frame';
				}else{
					$additional_class .= ' gdlr-core-without-frame';
				}
				

				// shadow
				$css_atts = array(
					'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
				);
				$css_atts['border-width'] = empty($args['frame-border-size'])? '': $args['frame-border-size'];
				$css_atts['border-color'] = empty($args['frame-border-color'])? '': $args['frame-border-color'];

				// move up with shadow effect
				$thumbnail_shadow = array();
				if( empty($args['with-frame']) || $args['with-frame'] == 'enable' ){
					if( !empty($args['enable-move-up-shadow-effect']) && $args['enable-move-up-shadow-effect'] == 'enable' ){
						$additional_class .= ' gdlr-core-move-up-with-shadow gdlr-core-outer-frame-element';
					}

					if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
						$css_atts['background-shadow-size'] = $args['frame-shadow-size'];
						$css_atts['background-shadow-color'] = $args['frame-shadow-color'];
						$css_atts['background-shadow-opacity'] = $args['frame-shadow-opacity'];

						$additional_class .= ' gdlr-core-outer-frame-element';
					}
				}else{
					if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
						$thumbnail_shadow['background-shadow-size'] = $args['frame-shadow-size'];
						$thumbnail_shadow['background-shadow-color'] = $args['frame-shadow-color'];
						$thumbnail_shadow['background-shadow-opacity'] = $args['frame-shadow-opacity'];
						
						$additional_class .= ' gdlr-core-outer-frame-element';
					}
				}

				$ret  = '<div class="kingster-lp-course-grid ' . esc_attr($additional_class) . '" ' . gdlr_core_esc_style($css_atts) . ' >';
				if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
					$ret .= $this->course_thumbnail(array(
						'thumbnail-size' => $args['thumbnail-size'],
						'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
						'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
						'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
					), $thumbnail_shadow);
				}

				if( empty($args['with-frame']) || $args['with-frame'] == 'enable' ){
					$ret .= '<div class="kingster-lp-course-grid-frame gdlr-core-js" ';
					$ret .= ' data-sync-height="lp-course-' . esc_attr($this->item_id) . '" ';
					$ret .= gdlr_core_esc_style(array(
						'padding' => empty($args['frame-padding'])? '': $args['frame-padding'],
					)) . ' >';
				}

				// course info top
				$types = array('category', 'review');
				$ret .= '<div class="kingster-lp-course-info-wrap clearfix" >';
				foreach( $types as $type ){ 
					$ret .= '<div class="kingster-lp-course-info kingster-type-' . esc_attr($type) . ' clearfix" >';
					$ret .= kingster_lp_get_course_info($type, get_the_ID(), $course_object);
					$ret .= '</div>'; // course-info-divider
				}
				$ret .= '</div>';
				
				$ret .= $this->course_title($args);
				$ret .= $this->course_excerpt($args);

				if( empty($args['with-frame']) || $args['with-frame'] == 'enable' ){
					$ret .= '<div class="kingster-lp-data-sync-height-offset" data-sync-height-offset ></div>';
				}
				
				// course info bottom
				$types = empty($args['course-grid-bottom-info'])? array(): $args['course-grid-bottom-info'];
				$types2 = empty($args['course-grid-bottom-info2'])? array(): $args['course-grid-bottom-info2'];
				
				if( !empty($types) ){
					$ret .= '<div class="kingster-lp-course-info-bottom-wrap ' . (empty($types2)? '': 'kingster-with-info2') .' clearfix" >';
					foreach( $types as $type ){ 
						$ret .= '<div class="kingster-lp-course-bottom-info kingster-type-' . esc_attr($type) . ' clearfix" >';
						if( $type == 'price' ){
							$ret .= kingster_lp_get_course_price(get_the_ID());
						}else{
							$ret .= kingster_lp_get_course_info($type, get_the_ID(), $course_object);
						}
						$ret .= '</div>'; // course-info-divider
					}
					$ret .= '</div>';
				}
				
				if( !empty($types2) ){
					$ret .= '<div class="kingster-lp-course-info-bottom2-wrap clearfix" >';
					foreach( $types2 as $type ){ 
						$ret .= '<div class="kingster-lp-course-bottom2-info kingster-type-' . esc_attr($type) . ' clearfix" >';
						$ret .= kingster_lp_get_course_info($type . '2', get_the_ID(), $course_object);
						$ret .= '</div>'; // course-info-divider
					}
					$ret .= '</div>';
				}
				
				if( empty($args['with-frame']) || $args['with-frame'] == 'enable' ){
					$ret .= '</div>'; // gdlr-core-course-grid-frame
				}
				$ret .= '</div>'; // gdlr-core-course-grid
				
				return $ret;
			} 
			
		} // kingster_lp_course_style
	} // class_exists
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	