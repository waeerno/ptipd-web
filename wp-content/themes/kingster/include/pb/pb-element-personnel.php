<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('personnel', 'kingster_gdlr_core_pb_element_personnel'); 
	}
	
	if( !class_exists('kingster_gdlr_core_pb_element_personnel') ){
		class kingster_gdlr_core_pb_element_personnel{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-outdent',
					'title' => esc_html__('Personnel', 'kingster')
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
								'options' => gdlr_core_get_term_list('personnel_category'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'kingster'),
								'type' => 'text',
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing on the personnel item', 'kingster')
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
						),
					),				
					'settings' => array(
						'title' => esc_html__('Style', 'kingster'),
						'options' => array(
							'text-align' => array(
								'title' => esc_html__('Text Align', 'kingster'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'left',
							),
							'personnel-style' => array(
								'title' => esc_html__('Personnel Style', 'kingster'),
								'type' => 'radioimage',
								'options' => array(
									'grid' => get_template_directory_uri() . '/images/personnel/grid.png',
									'grid-no-space' => get_template_directory_uri() . '/images/personnel/grid-no-space.png',
									'grid-with-background' => get_template_directory_uri() . '/images/personnel/grid-with-background.png',
									'modern' => get_template_directory_uri() . '/images/personnel/modern.png',
									'modern-no-space' => get_template_directory_uri() . '/images/personnel/modern-no-space.png',
									'medium' => get_template_directory_uri() . '/images/personnel/medium.png',
								),
								'default' => 'blog-full',
								'wrapper-class' => 'gdlr-core-fullsize'
							),
							'column-size' => array(
								'title' => esc_html__('Column Size', 'kingster'),
								'type' => 'combobox',
								'options' => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5 ),
								'default' => 3,
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space'))
							),
							'thumbnail-size' => array(
								'title' => esc_html__('Thumbnail Size', 'kingster'),
								'type' => 'combobox',
								'options' => 'thumbnail-size'
							),
							'enable-thumbnail-opacity-on-hover' => array(
								'title' => esc_html__('Thumbnail Opacity on Hover', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'enable-thumbnail-zoom-on-hover' => array(
								'title' => esc_html__('Thumbnail Zoom on Hover', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'enable-thumbnail-grayscale-effect' => array(
								'title' => esc_html__('Enable Thumbnail Grayscale Effect', 'kingster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'description' => esc_html__('Only works with browser that supports css3 filter ( http://caniuse.com/#feat=css-filters ).', 'kingster')
							),
							'carousel' => array(
								'title' => esc_html__('Enable Carousel', 'kingster'),
								'type' => 'checkbox',
								'default' => 'disable',
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space'))
							),
							'carousel-autoslide' => array(
								'title' => esc_html__('Autoslide Carousel', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array( 'carousel' => 'enable', 'personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space') )
							),
							'carousel-scrolling-item-amount' => array(
								'title' => esc_html__('Carousel Scrolling Item Amount', 'kingster'),
								'type' => 'text',
								'default' => '1',
								'condition' => array( 'carousel' => 'enable', 'personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space') )
							),
							'carousel-navigation' => array(
								'title' => esc_html__('Carousel Navigation', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'none' => esc_html__('None', 'kingster'),
									'navigation' => esc_html__('Only Navigation', 'kingster'),
									'bullet' => esc_html__('Only Bullet', 'kingster'),
									'both' => esc_html__('Both Navigation and Bullet', 'kingster'),
								),
								'default' => 'navigation',
								'condition' => array( 'carousel' => 'enable', 'personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space') )
							),
							'carousel-bullet-style' => array(
								'title' => esc_html__('Carousel Bullet Style', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'kingster'),
									'cylinder' => esc_html__('Cylinder', 'kingster'),
								),
								'condition' => array( 'carousel' => 'enable', 'carousel-navigation' => array('bullet','both'), 'personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'modern', 'modern-no-space') )
							),
							'enable-social-shortcode' => array(
								'title' => esc_html__('Enable Social Shortcode', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'enable-position' => array(
								'title' => esc_html__('Enable Position', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
							),
							'personnel-info' => array(
								'title' => esc_html__('Select Information To Display', 'kingster'),
								'type' => 'multi-combobox',
								'options' => array(
									'email' => esc_html__('Email', 'kingster'),
									'phone' => esc_html__('Phone', 'kingster'),
									'location' => esc_html__('Location', 'kingster'),
								),
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'medium')),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'kingster'),
							),
							'enable-excerpt' => array(
								'title' => esc_html__('Enable Excerpt', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable',
								'condition' => array('personnel-style' => array('grid', 'grid-no-space', 'grid-with-background', 'medium'))
							),
							'more-detail-button' => array(
								'title' => esc_html__('More Detail Button', 'kingster'),
								'type' => 'checkbox',
								'default' => 'enable'
							),
							'enable-hover-social' => array(
								'title' => esc_html__('Enable Hover Social', 'goodlayeres-core-personnel'),
								'type' => 'combobox',
								'options' => array(
									'disable' => esc_html__('Disable', 'kingster'),
									'enable' => esc_html__('Plain Style', 'kingster'),
									'round-border' => esc_html__('Round Border', 'kingster'),
								),
								'default' => 'disable',
								'condition' => array( 'personnel-style' => array('grid','grid-no-space', 'grid-with-background', 'medium') )
							),
							'disable-link' => array(
								'title' => esc_html__('Disable Link To Single Personnel', 'kingster'),
								'type' => 'checkbox',
								'default' => 'disable'
							),
						)
					),
					'typography' => array(
						'title' => esc_html__('Typography', 'kingster'),
						'options' => array(
							'personnel-title-font-size' => array(
								'title' => esc_html__('Personnel Title Font Size', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'personnel-title-font-weight' => array(
								'title' => esc_html__('Personnel Title Font Weight', 'kingster'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
							),
							'personnel-title-letter-spacing' => array(
								'title' => esc_html__('Personnel Title Letter Spacing', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'personnel-title-text-transform' => array(
								'title' => esc_html__('Personnel Title Text Transform', 'kingster'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'none' => esc_html__('None', 'kingster'),
									'uppercase' => esc_html__('Uppercase', 'kingster'),
									'lowercase' => esc_html__('Lowercase', 'kingster'),
									'capitalize' => esc_html__('Capitalize', 'kingster'),
								),
								'default' => 'uppercase'
							),
							'personnel-position-font-size' => array(
								'title' => esc_html__('Personnel Position Font Size', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'personnel-position-font-weight' => array(
								'title' => esc_html__('Personnel Position Font Weight', 'kingster'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'kingster')
							),
							'personnel-position-font-style' => array(
								'title' => esc_html__('Personnel Position Font Style', 'kingster'),
								'type' => 'combobox',
								'options' => array(
									'normal' => esc_html__('Normal', 'kingster'),
									'italic' => esc_html__('Italic', 'kingster'),
								),
								'default' => 'normal'
							),
							'personnel-position-letter-spacing' => array(
								'title' => esc_html__('Personnel Position Letter Spacing', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'personnel-position-text-transform' => array(
								'title' => esc_html__('Personnel Position Text Transform', 'kingster'),
								'type' => 'combobox',
								'data-type' => 'text',
								'options' => array(
									'none' => esc_html__('None', 'kingster'),
									'uppercase' => esc_html__('Uppercase', 'kingster'),
									'lowercase' => esc_html__('Lowercase', 'kingster'),
									'capitalize' => esc_html__('Capitalize', 'kingster'),
								),
								'default' => 'none'
							),
						)
					),
					'shadow' => array(
						'title' => esc_html__('Shadow', 'kingster'),
						'options' => array(
							'shadow-size' => array(
								'title' => esc_html__('Shadow Size ( Thumbnail, Frame Style )', 'kingster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'options' => array('x', 'y', 'size'),
								'data-input-type' => 'pixel',
							),
							'shadow-color' => array(
								'title' => esc_html__('Shadow Color ( Thumbnail, Frame Style )', 'kingster'),
								'type' => 'colorpicker'
							),
							'shadow-opacity' => array(
								'title' => esc_html__('Shadow Opacity ( Thumbnail, Frame Style )', 'kingster'),
								'type' => 'text',
								'default' => '0.2',
								'description' => esc_html__('Fill the number between 0.01 to 1', 'kingster')
							),
						)
					),
					'spacing' => array(
						'title' => esc_html__('Spacing', 'kingster'),
						'options' => array(
							'personnel-thumbnail-bottom-margin' => array(
								'title' => esc_html__('Personnel Thumbnail Bottom Margin', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'personnel-title-bottom-margin' => array(
								'title' => esc_html__('Personnel Title Bottom Margin', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel'
							),
							'personnel-frame-padding' => array(
								'title' => esc_html__('Personnel Frame Padding', 'kingster'),
								'type' => 'custom',
								'item-type' => 'padding',
								'data-input-type' => 'pixel',
								'default' => array( 'top'=>'', 'right'=>'', 'bottom'=>'', 'left'=>'', 'settings'=>'unlink' ),
							),
							'personnel-frame-bottom-border' => array(
								'title' => esc_html__('Personnel Frame Bottom Border', 'kingster'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => ''
							),
							'personnel-modern-content-bottom' => array(
								'title' => esc_html__('Personnel Content Bottom Spaces ( For Image/Frame Style )', 'kingster'),
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
					),	
				);
			}

			// get the preview for page builder
			static function get_preview( $settings = array() ){
				$content  = self::get_content($settings);
				$id = mt_rand(0, 9999);
				
				ob_start();
?><script type="text/javascript" id="gdlr-core-preview-personnel-<?php echo esc_attr($id); ?>" >
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-personnel-<?php echo esc_attr($id); ?>').parent().gdlr_core_flexslider();
});
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
				return $content;
			}			
			
			// get the content from settings
			static function get_content( $settings = array() ){
				global $gdlr_core_item_pdb;
				
				// default variable
				if( empty($settings) ){
					$settings = array(
						'category' => '', 'num-fetch' => 9, 'thumbnail-size' => 'full', 'orderby' => 'date', 'order' => 'asc',
						'personnel-style' => 'grid', 'column-size' => 3, 'text-align' => 'left', 'carousel' => 'disable',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				// default value
				$settings['personnel-style'] = empty($settings['personnel-style'])? 'grid': $settings['personnel-style'];
				if( in_array($settings['personnel-style'], array('grid', 'grid-no-space', 'grid-with-background')) ){
					$settings['style'] = 'grid';
				}else if( in_array($settings['personnel-style'], array('modern', 'modern-no-space')) ){
					$settings['style'] = 'modern';
				}else if( $settings['personnel-style'] == 'medium' ){
					$settings['style'] = 'medium';
				}
				$settings['carousel'] = empty($settings['carousel'])? 'disable': $settings['carousel'];
				$settings['disable-link'] = empty($settings['disable-link'])? 'disable': $settings['disable-link'];
				$with_space = !in_array($settings['personnel-style'], array('grid-no-space', 'modern-no-space'));

				// query
				$args = array( 'post_type' => 'personnel', 'suppress_filters' => false );

				if( !empty($settings['category']) ){
					$args['tax_query'] = array(array('terms'=>$settings['category'], 'taxonomy'=>'personnel_category', 'field'=>'slug'));
				}

				$args['posts_per_page'] = $settings['num-fetch'];
				$args['orderby'] = $settings['orderby'];
				$args['order'] = $settings['order'];	

				// $args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
				// $args['paged'] = empty($args['paged'])? 1: $args['paged'];

				$query = new WP_Query( $args );

				// start printing item
				$extra_class  = ' gdlr-core-' . (empty($settings['text-align'])? 'left': $settings['text-align']) . '-align';
				$extra_class .= ' gdlr-core-personnel-item-style-' . $settings['personnel-style'];
				$extra_class .= ' gdlr-core-personnel-style-' . $settings['style'];
				$extra_class .= ($settings['personnel-style'] == 'grid-with-background')? ' gdlr-core-with-background': '';
				
				$title_settings = $settings;
				if( empty($with_space) || $settings['carousel'] == 'enable' ){
					$title_settings['pdlr'] = false;
					$extra_class .= ' gdlr-core-item-pdlr';
				}

				if( !empty($settings['column-size']) ){
					gdlr_core_set_container_multiplier(1 / intval($settings['column-size']), false);
				}

				$ret  = '<div class="gdlr-core-personnel-item gdlr-core-item-pdb clearfix ' . esc_attr($extra_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				// print title
				$ret .= gdlr_core_block_item_title($title_settings);
				
				// print grid item
				if( $query->have_posts() ){
					if( $settings['carousel'] == 'disable' || $settings['style'] == 'medium' ){

						if( $query->have_posts() ){
							$p_column_count = 0;
							if( $settings['style'] == 'medium' ){
								$p_column = 60;
							}else{
								$p_column = 60 / intval($settings['column-size']);
							}
							
							gdlr_core_setup_admin_postdata();
							while( $query->have_posts() ){ $query->the_post();
								$column_class  = ' gdlr-core-column-' . $p_column;
								$column_class .= ($p_column_count % 60 == 0)? ' gdlr-core-column-first': '';
								$column_class .= empty($with_space)? '': ' gdlr-core-item-pdlr';
								$column_class .= ($settings['style'] == 'modern' && !empty($with_space))? ' gdlr-core-item-mgb': '';

								$ret .= '<div class="gdlr-core-personnel-list-column ' . esc_attr($column_class) . '" >';
								$ret .= self::get_tab_item($settings);
								$ret .= '</div>';

								$p_column_count += $p_column;
							}
							wp_reset_postdata();
							gdlr_core_reset_admin_postdata();
						}

					// print carousel item
					}else{

						$slides = array();
						$flex_atts = array(
							'carousel' => true,
							'column' => empty($settings['column-size'])? '3': $settings['column-size'],
							'move' => empty($settings['carousel-scrolling-item-amount'])? '': $settings['carousel-scrolling-item-amount'],
							'navigation' => empty($settings['carousel-navigation'])? 'navigation': $settings['carousel-navigation'],
							'bullet-style' => empty($settings['carousel-bullet-style'])? '': $settings['carousel-bullet-style'],
							'nav-parent' => 'gdlr-core-personnel-item',
							'disable-autoslide' => (empty($settings['carousel-autoslide']) || $settings['carousel-autoslide'] == 'enable')? '': true,
						);
						if( empty($with_space) ){
							$flex_atts['mglr'] = false;
						}

						while( $query->have_posts() ){ $query->the_post();
							$slides[] = self::get_tab_item($settings);
						}

						$ret .= gdlr_core_get_flexslider($slides, $flex_atts);
					}
				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('No personnel found, please create the personnel post to use the item.', 'kingster') . '</div>';
				}

				$ret .= '</div>'; // gdlr-core-blog-item
				
				gdlr_core_set_container_multiplier(1, false);

				return $ret;
			}

			static function get_tab_item( $settings = array() ){ 

				$post_meta = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);

				
				if( in_array($settings['personnel-style'], array('grid-with-background', 'modern', 'modern-no-space')) &&
					!empty($settings['shadow-size']['size']) && !empty($settings['shadow-color']) && !empty($settings['shadow-opacity']) ){
						
					$ret  = '<div class="gdlr-core-personnel-list gdlr-core-outer-frame-element clearfix" ';
					$ret .= gdlr_core_esc_style(array(
						'background-shadow-size' => empty($settings['shadow-size'])? '': $settings['shadow-size'],
						'background-shadow-color' => empty($settings['shadow-color'])? '': $settings['shadow-color'],
						'background-shadow-opacity' => empty($settings['shadow-opacity'])? '': $settings['shadow-opacity'],

					));
					$ret .= ' >';
				}else{
					$ret  = '<div class="gdlr-core-personnel-list clearfix" >';
				}
				
				$thumbnail_id = get_post_thumbnail_id();
				if( !empty($thumbnail_id) ){
					$thumbnail_size = empty($settings['thumbnail-size'])? 'full': $settings['thumbnail-size'];

					$additional_class  = '';
					if( empty($settings['enable-thumbnail-opacity-on-hover']) || $settings['enable-thumbnail-opacity-on-hover'] == 'enable' ){
						$additional_class .= ' gdlr-core-hover-element';
					}
					if( empty($settings['enable-thumbnail-zoom-on-hover']) || $settings['enable-thumbnail-zoom-on-hover'] == 'enable' ){
						$additional_class .= ' gdlr-core-zoom-on-hover';
					}
					if( !empty($settings['enable-thumbnail-grayscale-effect']) && $settings['enable-thumbnail-grayscale-effect'] == 'enable' ){
						$additional_class .= ' gdlr-core-grayscale-effect';
					}
					$ret .= '<div class="gdlr-core-personnel-list-image gdlr-core-media-image ' . esc_attr($additional_class) . '" >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= gdlr_core_get_image($thumbnail_id, $thumbnail_size);
					}else{
						$ret .= '<a href="' . esc_url(get_permalink()) . '" >' . gdlr_core_get_image($thumbnail_id, $thumbnail_size) .  '</a>';
					}

					// hover
					$ret .= '<div class="gdlr-core-hover-opacity" >';
					$hover_content = '';
					if( !empty($settings['enable-hover-social']) && $settings['enable-hover-social'] != 'disable' ){
						if( in_array($settings['personnel-style'], array('grid','grid-no-space', 'grid-with-background', 'medium')) ){
							$hover_content .= '<div class="gdlr-core-personnel-thumbnail-hover-social ';
							$hover_content .= ($settings['enable-hover-social'] == 'enable')? '': ' gdlr-core-' . $settings['enable-hover-social'];
							$hover_content .= '" >' . gdlr_core_text_filter($post_meta['social-shortcode']) . '</div>';
						}
					}
					if( !empty($hover_content) ){
						$ret .= '<div class="gdlr-core-personnel-thumbnail-hover-content gdlr-core-bottom" >' . gdlr_core_text_filter($hover_content) . '</div>';
					}
					$ret .= '</div>';
					$ret .= '</div>'; // gdlr-core-personnel-list-image
				}

				$title_atts = array(
					'font-size' => empty($settings['personnel-title-font-size'])? '': $settings['personnel-title-font-size'],
					'font-weight' => empty($settings['personnel-title-font-weight'])? '': $settings['personnel-title-font-weight'],
					'letter-spacing' => empty($settings['personnel-title-letter-spacing'])? '': $settings['personnel-title-letter-spacing'],
					'text-transform' => (empty($settings['personnel-title-text-transform']) || $settings['personnel-title-text-transform'] == 'uppercase')? '': $settings['personnel-title-text-transform'],
					'margin-bottom' => empty($settings['personnel-title-bottom-margin'])? '': $settings['personnel-title-bottom-margin'],
				);
				$position_atts = array(
					'font-size' => empty($settings['personnel-position-font-size'])? '': $settings['personnel-position-font-size'],
					'font-weight' => empty($settings['personnel-position-font-weight'])? '': $settings['personnel-position-font-weight'],
					'font-style' => (empty($settings['personnel-position-font-style']) || $settings['personnel-position-font-style'] == 'italic')? '': $settings['personnel-position-font-style'],
					'letter-spacing' => empty($settings['personnel-position-letter-spacing'])? '': $settings['personnel-position-letter-spacing'],
					'text-transform' => (empty($settings['personnel-position-text-transform']) || $settings['personnel-position-text-transform'] == 'none')? '': $settings['personnel-position-text-transform'],
				);
				$css_atts = array(
					'padding-top' => empty($settings['personnel-thumbnail-bottom-margin'])? '': $settings['personnel-thumbnail-bottom-margin'],
				);
				if( $settings['personnel-style'] == 'grid-with-background' ){
					$css_atts['padding'] = empty($settings['personnel-frame-padding'])? '': $settings['personnel-frame-padding'];
					$css_atts['padding-bottom'] = empty($settings['personnel-modern-content-bottom'])? '': $settings['personnel-modern-content-bottom'];
					$css_atts['border-bottom-width'] = empty($settings['personnel-frame-bottom-border'])? '': $settings['personnel-frame-bottom-border'];
				}else if( in_array($settings['personnel-style'], array('modern', 'modern-no-space')) ){
					$css_atts['bottom'] = empty($settings['personnel-modern-content-bottom'])? '': $settings['personnel-modern-content-bottom'];
				}
				
				$ret .= '<div class="gdlr-core-personnel-list-content-wrap" ' . gdlr_core_esc_style($css_atts) . ' >';

				if( in_array($settings['style'], array('grid', 'medium')) ){
					if( (empty($settings['enable-social-shortcode']) || $settings['enable-social-shortcode'] == 'enable') && !empty($post_meta['social-shortcode']) ){
						$ret .= '<div class="gdlr-core-personnel-list-social" >' . gdlr_core_content_filter($post_meta['social-shortcode']) . '</div>';
					}
					$ret .= '<h3 class="gdlr-core-personnel-list-title" ' . gdlr_core_esc_style($title_atts) . ' >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= get_the_title();
					}else{
						$ret .= '<a href="' . esc_url(get_permalink()) . '" >' . get_the_title() . '</a>';
					}
					$ret .= '</h3>';
					if( (empty($settings['enable-position']) || $settings['enable-position'] == 'enable') && !empty($post_meta['position']) ){
						$ret .= '<div class="gdlr-core-personnel-list-position gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style($position_atts) . ' >' . gdlr_core_text_filter($post_meta['position']) . '</div>';
					}
					if( !empty($settings['personnel-info']) ){
						$ret .= '<div class="gdlr-core-personnel-info" >';
						$ret .= kingster_get_personnel_info($post_meta, $settings['personnel-info']);
						$ret .= '</div>';
					}
					if( (empty($settings['enable-excerpt']) || $settings['enable-excerpt'] == 'enable') && !empty($post_meta['excerpt']) ){
						$ret .= '<div class="gdlr-core-personnel-list-content" >' . gdlr_core_content_filter($post_meta['excerpt']) . '</div>';
					}

					if( empty($settings['more-detail-button']) || $settings['more-detail-button'] == 'enable' ){
						if( $settings['disable-link'] == 'disable' ){
							$ret .= '<a class="gdlr-core-personnel-list-button gdlr-core-button" href="' . esc_url(get_permalink()) . '" >' . esc_html__('More Detail', 'kingster') . '</a>';
						}
					}
						
				}else{
					if( (empty($settings['enable-social-shortcode']) || $settings['enable-social-shortcode'] == 'enable') && !empty($post_meta['social-shortcode']) ){
						$ret .= '<div class="gdlr-core-personnel-list-social" >' . gdlr_core_content_filter($post_meta['social-shortcode']) . '</div>';
					}

					$ret .= '<div class="gdlr-core-personnel-list-title gdlr-core-title-font" ' . gdlr_core_esc_style($title_atts) . ' >';
					if( $settings['disable-link'] == 'enable' ){
						$ret .= get_the_title();
					}else{
						$ret .= '<a href="' . esc_url(get_permalink()) . '" >' . get_the_title() . '</a>';
					}
					$ret .= '</div>';
					if( (empty($settings['enable-position']) || $settings['enable-position'] == 'enable') && !empty($post_meta['position']) ){
						$ret .= '<div class="gdlr-core-personnel-list-position gdlr-core-info-font" ' . gdlr_core_esc_style($position_atts) . ' >' . gdlr_core_text_filter($post_meta['position']) . '</div>';
					}
				}
				$ret .= '</div>'; // gdlr-core-personnel-list-content-wrap

				$ret .= '</div>'; // gdlr-core-personnel-list

				return $ret;
			}
			
		} // kingster_gdlr_core_pb_element_personnel
	} // class_exists	