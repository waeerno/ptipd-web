<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	if( class_exists('gdlr_core_page_builder_element') ){
		gdlr_core_page_builder_element::add_element('tab', 'kingster_gdlr_core_pb_element_tab');
	}
	
	if( !class_exists('kingster_gdlr_core_pb_element_tab') ){
		class kingster_gdlr_core_pb_element_tab{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-folder-o',
					'title' => esc_html__('Tab', 'kingster')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return array(
					'general' => array(
						'title' => esc_html__('General', 'kingster'),
						'options' => array(
							'tabs' => array(
								'title' => esc_html__('Add New Tab', 'kingster'),
								'type' => 'custom',
								'item-type' => 'tabs',
								'wrapper-class' => 'gdlr-core-fullsize',
								'options' => array(
									'image' => array(
										'title' => esc_html__('Tab\'s Image', 'kingster'),
										'type' => 'upload'
									),
									'image-video-link' => array(
										'title' => esc_html__('Tab\'s Image Video Link', 'kingster'),
										'type' => 'text'
									),
									'title' => array(
										'title' => esc_html__('Title', 'kingster'),
										'type' => 'text'
									),
									'content' => array(
										'title' => esc_html__('Content', 'kingster'),
										'type' => 'tmce'
									),
									'content-background' => array(
										'title' => esc_html__('Content Background', 'kingster'),
										'type' => 'upload'
									),
									'content-background-position' => array(
										'title' => esc_html__('Content Background Position', 'kingster'),
										'type' => 'combobox',
										'options' => array(
											'center' => esc_html__('Center', 'kingster'),
											'top left' => esc_html__('Top Left', 'kingster'),
											'top right' => esc_html__('Top Right', 'kingster'),
											'bottom left' => esc_html__('Bottom Left', 'kingster'),
											'bottom right' => esc_html__('Bottom Right', 'kingster'),
										)
									),
								),
								'default' => array(
									array(
										'title' => esc_html__('Tab Title', 'kingster'),
										'content' => esc_html__('Tab content area', 'kingster'),
									),
									array(
										'title' => esc_html__('Tab Title', 'kingster'),
										'content' => esc_html__('Tab content area', 'kingster'),
									),
								)
							),
						),
					),
					'style' => array(
						'title' => esc_html__('Style', 'kingster'),
						'options' => array(
							'align' => array(
								'title' => esc_html__('Tab Alignment', 'kingster'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'default' => 'left',
								'description' => esc_html__('Center style only supports with horizontal tab', 'kingster')
							)
						)
					),
					'color' => array(
						'title' => esc_html__('Color', 'kingster'),
						'options' => array(
							'tab-title-color' => array(
								'title' => esc_html__('Tab Title Color', 'kingster'),
								'type' => 'colorpicker'
							),
							'tab-title-active-color' => array(
								'title' => esc_html__('Tab Title Active Color', 'kingster'),
								'type' => 'colorpicker'
							),
							'tab-title-background-color' => array(
								'title' => esc_html__('Tab Title Background Color', 'kingster'),
								'type' => 'colorpicker'
							),
							'tab-title-active-background-color' => array(
								'title' => esc_html__('Tab Title Active Background Color', 'kingster'),
								'type' => 'colorpicker'
							),
							'tab-content-color' => array(
								'title' => esc_html__('Tab Content Color', 'kingster'),
								'type' => 'colorpicker'
							),
							'tab-content-background-color' => array(
								'title' => esc_html__('Tab Content Background Color', 'kingster'),
								'type' => 'colorpicker'
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
								'default' => $gdlr_core_item_pdb
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
?><script id="gdlr-core-preview-accordion-<?php echo esc_attr($id); ?>" >
$.fn.kingster_tab = function(){
	var elem = $(this);

	elem.find('.gdlr-core-tab-item-title').on('click', function(){
		var tab_id = $(this).attr('data-tab-id');
		var tab_item_wrap = $(this).closest('.gdlr-core-tab-item-wrap');

		tab_item_wrap.siblings('.gdlr-core-tab-item-content-image-wrap').each(function(){
			var active_tab = $(this).children('[data-tab-id="' + tab_id + '"]');

			if( active_tab.length ){
				$(this).css('width', '');
				$(this).css('height', tab_item_wrap.outerHeight());
				active_tab.siblings().removeClass('gdlr-core-active');
				active_tab.addClass('gdlr-core-active');
			}else{
				$(this).css('width', '0px');
				$(this).children().removeClass('gdlr-core-active'); // .hide();
			}
		});
			
	});

	elem.find('.gdlr-core-tab-item-content-image-wrap').css('height', $(this).find('.gdlr-core-tab-item-wrap').outerHeight());
	$(window).on('load resize', function(){
		elem.find('.gdlr-core-tab-item-content-image-wrap').css('height', elem.find('.gdlr-core-tab-item-wrap').outerHeight());
	});
}
jQuery(document).ready(function(){
	jQuery('#gdlr-core-preview-accordion-<?php echo esc_attr($id); ?>').parent().gdlr_core_tab().kingster_tab();

});
</script><?php	
				$content .= ob_get_contents();
				ob_end_clean();
				
				return $content;
			}		
			
			// get the content from settings
			static function get_content( $settings = array(), $preview = false ){
				global $gdlr_core_item_pdb, $gdlr_core_tab_item_id;
				if( is_admin() ){
					$gdlr_core_tab_item_id = mt_rand(0, 9999);
				}else{
					$gdlr_core_tab_item_id = empty($gdlr_core_tab_item_id)? 1: $gdlr_core_tab_item_id + 1;
				}

				// default variable
				if( empty($settings) ){
					$settings = array(
						'tabs' => array(
							array(
								'title' => esc_html__('Tab Title', 'kingster'),
								'content' => esc_html__('Tab content area', 'kingster'),
							),
							array(
								'title' => esc_html__('Tab Title', 'kingster'),
								'content' => esc_html__('Tab content area', 'kingster'),
							),
						),
						'align' => 'left',
						'style' => 'style1-horizontal',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}
				
				$settings['style'] = empty($settings['style'])? 'style1-horizontal': $settings['style'];
				$settings['align'] = empty($settings['align'])? 'left': $settings['align'];
				if( in_array($settings['style'], array('style1-vertical', 'style2-vertical')) && $settings['align'] == 'center' ){
					$settings['align'] = 'left';
				}

				$tab_item_class  = ' gdlr-core-' . esc_attr($settings['align']) . '-align';
				$tab_item_class .= ' gdlr-core-tab-' . esc_attr($settings['style']);
				$tab_item_class .= empty($settings['no-pdlr'])? ' gdlr-core-item-pdlr': '';
				$tab_item_class .= empty($settings['class'])? '': ' ' . $settings['class'];

				// tab custom style
				$custom_style  = '';
				$custom_style .= empty($settings['tab-title-color'])? '': ' #custom_style_id .gdlr-core-tab-item-title{ color: ' . $settings['tab-title-color'] . '; }';
				$custom_style .= empty($settings['tab-title-active-color'])? '': ' #custom_style_id .gdlr-core-tab-item-title.gdlr-core-active{ color: ' . $settings['tab-title-active-color'] . '; }';
				$custom_style .= empty($settings['tab-title-background-color'])? '': ' #custom_style_id.gdlr-core-tab-style1-horizontal .gdlr-core-tab-item-title, #custom_style_id.gdlr-core-tab-style1-vertical .gdlr-core-tab-item-title{ background-color: ' . $settings['tab-title-background-color'] . '; }';
				$custom_style .= empty($settings['tab-title-active-background-color'])? '': ' #custom_style_id.gdlr-core-tab-style1-horizontal .gdlr-core-tab-item-title.gdlr-core-active, #custom_style_id.gdlr-core-tab-style1-vertical .gdlr-core-tab-item-title.gdlr-core-active{ background-color: ' . $settings['tab-title-active-background-color'] . '; }';
				if( !empty($custom_style) ){
					if( empty($settings['id']) ){
						global $gdlr_core_tab_id; 
						$gdlr_core_tab_id = empty($gdlr_core_tab_id)? array(): $gdlr_core_tab_id;
						
						// generate unique id so it does not get overwritten in admin area
						$rnd_tab_id = mt_rand(0, 99999);
						while( in_array($rnd_tab_id, $gdlr_core_tab_id) ){
							$rnd_tab_id = mt_rand(0, 99999);
						}
						$gdlr_core_tab_id[] = $rnd_tab_id;
						$settings['id'] = 'gdlr-core-tab-' . $rnd_tab_id;
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
				$ret  = '<div class="gdlr-core-tab-item gdlr-core-js gdlr-core-item-pdb ' . esc_attr($tab_item_class) . '" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				$active = 1;
				if( !empty($settings['tabs']) ){
					
					$count = 0; 
					$ret .= '<div class="gdlr-core-tab-item-content-image-wrap clearfix" >';
					foreach( $settings['tabs'] as $tab ){ $count++;
						if( !empty($tab['image']) ){
							$ret .= '<div class="gdlr-core-tab-item-image ' . ($count == $active? ' gdlr-core-active': '') . '" data-tab-id="' . esc_attr($count) . '" >';
							if( !empty($tab['image-video-link']) ){
								$ret .= '<a ' . gdlr_core_get_lightbox_atts(array(
									'type' => 'video',
									'url' => $tab['image-video-link']
								)) . ' >';
							}
							$ret .= '<span class="gdlr-core-tab-item-image-background" ' . gdlr_core_esc_style(array(
								'background-image' => $tab['image']
							)) . ' ></span>';
							if( !empty($tab['image-video-link']) ){
								$ret .= '<i class="fa fa-play" ></i></a>';
							}
							$ret .= '</div>';
						}
					}
					$ret .= '</div>';

					$count = 0; 
					$ret .= '<div class="gdlr-core-tab-item-wrap" >';
					$ret .= '<div class="gdlr-core-tab-item-title-wrap clearfix gdlr-core-title-font" >';
					foreach( $settings['tabs'] as $tab ){ $count++;
						$ret .= '<div class="gdlr-core-tab-item-title ' . ($count == $active? ' gdlr-core-active': '') . '" data-tab-id="' . esc_attr($count) . '" >' . gdlr_core_text_filter($tab['title']) . '</div>';
					}
					if( in_array($settings['style'], array('style2-vertical', 'style2-horizontal')) ){
						$ret .= '<div class="gdlr-core-tab-item-title-line gdlr-core-skin-divider"></div>';
					}
					$ret .= '</div>'; // gdlr-core-tab-item-tab-title-wrap
					
					$count = 0;
					$ret .= '<div class="gdlr-core-tab-item-content-wrap clearfix" >';
					foreach( $settings['tabs'] as $tab ){ $count++;
						$ret .= '<div class="gdlr-core-tab-item-content ' . ($count == $active? ' gdlr-core-active': '') . '" data-tab-id="' . esc_attr($count) . '" ' . gdlr_core_esc_style(array(
							'color'=>empty($settings['tab-content-color'])? '': $settings['tab-content-color'],
							'background-color'=>empty($settings['tab-content-background-color'])? '': $settings['tab-content-background-color'],
							'background-image'=>empty($tab['content-background'])? '': $tab['content-background'],
							'background-position'=>empty($tab['content-background-position'])? '': $tab['content-background-position']
						)) . ' >' . gdlr_core_content_filter($tab['content']) . '</div>';
					}
					$ret .= '</div>'; // gdlr-core-tab-item-tab
					$ret .= '</div>'; // gdlr-core-tab-item-wrap
				}
				$ret .= '</div>'; // gdlr-core-tab-item
				$ret .= $custom_style;
				
				return $ret;
			}			
			
		} // kingster_gdlr_core_pb_element_tab
	} // class_exists	