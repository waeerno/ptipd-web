<?php 

	add_filter('gdlr_core_blog_item_options', 'kingster_gdlr_core_blog_item_options');
	if( !function_exists('kingster_gdlr_core_blog_item_options') ){
		function kingster_gdlr_core_blog_item_options($options){
			if( !empty($options['settings']['options']) ){
				$options['settings']['options'] = gdlr_core_array_insert($options['settings']['options'], 'blog-style', array(
					'blog-widget-with-feature' => array(
						'title' => esc_html__('Blog Widget With Feature', 'kingster'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'blog-style'=> 'blog-widget' ),
						'description' => esc_html__('Feature area will take the first column if multiple column is selected', 'kingster')
					)
				));

				$options['settings']['options']['blog-style']['options']['blog-widget'] = get_template_directory_uri() . '/images/blog-thumbnail-featured-widget.jpg';

				unset($options['settings']['options']['blog-widget-bottom-divider']);
				unset($options['settings']['options']['item-size']);
			}
			return $options;
		}
	}

	add_filter('gdlr_core_blog_info_prefix', 'kingster_gdlr_core_blog_info_prefix');
	if( !function_exists('kingster_gdlr_core_blog_info_prefix') ){
		function kingster_gdlr_core_blog_info_prefix(){
			return array(
				'date' => '',
				'tag' => '',
				'category' => '',
				'comment' => '<i class="fa fa-comments-o" ></i>',
				'like' => '<i class="icon_heart_alt" ></i>',
				'author' => esc_html__('By', 'kingster'),
				'comment-number' => '<i class="fa fa-comments-o" ></i>',
			);
		}
	}

	add_filter('gdlr_core_blog_style_content', 'kingster_gdlr_core_blog_style_content', 10, 3);
	if( !function_exists('kingster_gdlr_core_blog_style_content') ){
		function kingster_gdlr_core_blog_style_content($ret, $args, $blog_style){

			if( in_array($args['blog-style'], array('blog-column', 'blog-column-with-frame', 'blog-column-no-space')) ){
				if( empty($args['blog-column-style']) || $args['blog-column-style'] == 'style-1' ){
					return kingster_gdlr_core_blog_grid( $args, $blog_style );
				}
			}else if( $args['blog-style'] == 'blog-widget' ){
				return kingster_gdlr_core_blog_widget( $args, $blog_style );
			}

			return $ret;
		}
	}

	add_filter('get_blog_grid_widget', 'kingster_get_blog_grid_widget', 10, 3);
	if( !function_exists('kingster_get_blog_grid_widget') ){
		function kingster_get_blog_grid_widget( $ret, $query, $blog_item ){
			$ret = '';

			$with_feature = (empty($blog_item->settings['blog-widget-with-feature']) || $blog_item->settings['blog-widget-with-feature'] == 'disable')? false: true;
			$blog_widget_column = empty($blog_item->settings['blog-widget-column'])? 60: intval($blog_item->settings['blog-widget-column']);
			if( $with_feature ){
				$column = ($blog_widget_column == 60)? 1: ((60 / $blog_widget_column) - 1);
				$item_per_column = ceil((count($query->posts) - 1) / $column);
			}else{
				$item_per_column = ceil(count($query->posts) / (60 / $blog_widget_column));
			}
			if( empty($item_per_column) ) $item_per_column = 1;
			
			$count = 0;
			$first_column = true;
			$blog_style = new gdlr_core_blog_style();
			while($query->have_posts()){ $query->the_post(); $count++;
				
				if( $item_per_column == 1 || $count % $item_per_column == 1 ){
					if( $first_column ){
						$first_column = false;
					}else{
						$ret .= '</div>'; // gdlr-core-item-list-wrap
					}
					$ret .= '<div class="gdlr-core-item-list-wrap gdlr-core-column-' . esc_attr($blog_widget_column) . '" >';
				}

				if( $with_feature ){
					$feature_blog_settings = $blog_item->settings;
					$feature_blog_settings['blog-style'] = 'blog-column';
					$feature_blog_settings['blog-column-style'] = 'style-1';
					$feature_blog_settings['excerpt'] = 'specify-number';
					$feature_blog_settings['excerpt-number'] = '0';
					$feature_blog_settings['blog-title-font-size'] = '19px';
					$feature_blog_settings['show-read-more'] = 'disable';
					$ret .= '<div class="gdlr-core-item-list-inner gdlr-core-item-mglr" >';
					$ret .= $blog_style->get_content($feature_blog_settings);
					$ret .= '</div>';

					$count = 0;
					$with_feature = false;
				}else{
					$ret .= $blog_style->get_content($blog_item->settings);
				}
			} // while

			$ret .= '</div>'; // gdlr-core-item-list-wrap

			return $ret;
		}
	}

	if( !function_exists('kingster_gdlr_core_blog_widget') ){
		function kingster_gdlr_core_blog_widget( $args, $blog_style ){

			$additional_class  = empty($args['text-align'])? '': ' gdlr-core-' . $args['text-align'] . '-align';
			$additional_class .= empty($args['item-size'])? '': 'gdlr-core-style-' . $args['item-size']; 

			$ret  = '<div class="gdlr-core-item-list gdlr-core-blog-widget gdlr-core-item-mglr clearfix ' . esc_attr($additional_class) . '" ' . gdlr_core_esc_style(array(
				'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
			)) . ' >';
			if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
				$ret .= $blog_style->blog_thumbnail(array(
					'thumbnail-size' => 'thumbnail',
					'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
					'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
					'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
				));
			}

			$ret .= '<div class="gdlr-core-blog-widget-content" >';
			$ret .= $blog_style->blog_info(array(
				'display' => $args['meta-option'],
				'wrapper' => true
			));

			$ret .= $blog_style->blog_title($args);
			$ret .= '</div>'; // gdlr-core-blog-widget-content
			$ret .= '</div>'; // gdlr-core-blog-widget
			
			return $ret;
		}
	}

	if( !function_exists('kingster_gdlr_core_blog_grid') ){
		function kingster_gdlr_core_blog_grid( $args, $blog_style ){

			$post_format = get_post_format();
			if( in_array($post_format, array('aside', 'quote', 'link')) ){
				$args['extra-class']  = ' gdlr-core-blog-grid gdlr-core-small';
				if($args['blog-style'] == 'blog-column-with-frame' && $args['layout'] != 'masonry' ){
					$args['sync-height'] = true;
				}
				return $blog_style->blog_format( $args, $post_format );
			}

			$additional_class = '';

			// shadow
			$blog_atts = array(
				'margin-bottom' => empty($args['margin-bottom'])? '': $args['margin-bottom']
			);
			$thumbnail_shadow = array();
			if($args['blog-style'] == 'blog-column-with-frame' ){
				$additional_class .= ' gdlr-core-blog-grid-with-frame gdlr-core-item-mgb gdlr-core-skin-e-background ';

				$blog_atts['border-width'] = empty($args['blog-frame-border-size'])? '': $args['blog-frame-border-size'];
				$blog_atts['border-color'] = empty($args['blog-frame-border-color'])? '': $args['blog-frame-border-color'];

				if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
					$blog_atts['background-shadow-size'] = $args['frame-shadow-size'];
					$blog_atts['background-shadow-color'] = $args['frame-shadow-color'];
					$blog_atts['background-shadow-opacity'] = $args['frame-shadow-opacity'];
					$blog_atts['border-radius'] = empty($args['blog-border-radius'])? '': $args['blog-border-radius'];

					$additional_class .= ' gdlr-core-outer-frame-element';
				}
			}else{
				if( !empty($args['frame-shadow-size']['size']) && !empty($args['frame-shadow-color']) && !empty($args['frame-shadow-opacity']) ){
					$thumbnail_shadow['background-shadow-size'] = $args['frame-shadow-size'];
					$thumbnail_shadow['background-shadow-color'] = $args['frame-shadow-color'];
					$thumbnail_shadow['background-shadow-opacity'] = $args['frame-shadow-opacity'];
				}
				$thumbnail_shadow['border-radius'] = empty($args['blog-border-radius'])? '': $args['blog-border-radius'];
			}

			// move up with shadow effect
			if( $args['blog-style'] == 'blog-column-with-frame' && !empty($args['enable-move-up-shadow-effect']) && $args['enable-move-up-shadow-effect'] == 'enable' ){
				$additional_class .= ' gdlr-core-move-up-with-shadow gdlr-core-outer-frame-element';
			}

			if($args['blog-style'] == 'blog-column-with-frame' && $args['layout'] != 'masonry' ){
				$ret  = '<div class="gdlr-core-blog-grid gdlr-core-js ' . esc_attr($additional_class) . '" ' . gdlr_core_esc_style($blog_atts);
				$ret .= ' data-sync-height="blog-item-' . esc_attr($blog_style->blog_item_id) . '" >';
			}else{
				$ret  = '<div class="gdlr-core-blog-grid ' . esc_attr($additional_class) . '" ' . gdlr_core_esc_style($blog_atts) . ' >';
			}
			if( empty($args['show-thumbnail']) || $args['show-thumbnail'] == 'enable' ){
				$ret .= $blog_style->blog_thumbnail(array(
					'thumbnail-size' => $args['thumbnail-size'],
					'post-format' => $post_format,
					'post-format-gallery' => 'slider',
					'opacity-on-hover' => empty($args['enable-thumbnail-opacity-on-hover'])? 'enable': $args['enable-thumbnail-opacity-on-hover'],
					'zoom-on-hover' => empty($args['enable-thumbnail-zoom-on-hover'])? 'enable': $args['enable-thumbnail-zoom-on-hover'],
					'grayscale-effect' => empty($args['enable-thumbnail-grayscale-effect'])? 'disable': $args['enable-thumbnail-grayscale-effect']
				), $thumbnail_shadow);
			}
			
			if( $args['blog-style'] == 'blog-column-with-frame' ){
				$ret .= '<div class="gdlr-core-blog-grid-frame" ' . gdlr_core_esc_style(array(
					'padding' => empty($args['blog-frame-padding'])? '': $args['blog-frame-padding'],
				)) . ' >';
			}else{
				$ret .= '<div class="gdlr-core-blog-grid-content-wrap">';
			}

			if( !empty($args['meta-option']) ){
				$ret .= $blog_style->blog_info(array(
					'display' => $args['meta-option'],
					'wrapper' => true
				));
			}

			$ret .= $blog_style->blog_title($args);
			$ret .= $blog_style->get_blog_excerpt($args);

			$ret .= '</div>'; // gdlr-core-blog-grid-content-wrap
			$ret .= '</div>'; // gdlr-core-blog-grid
			
			return $ret;
		}
	}