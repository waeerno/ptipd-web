<?php 

	// item title
	add_filter('gdlr_core_block_item_option', 'kingster_block_item_option');
	if( !function_exists('kingster_block_item_option') ){
		function kingster_block_item_option(){
			return array(
				'title-align' => array(
					'title' => esc_html__('Title Align', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'left' => esc_html__('Left', 'kingster'),
						'center' => esc_html__('Center', 'kingster'),
					),
					'default' => 'left',
				),
				'title-left-media' => array(
					'title' => esc_html__('Title Left Media', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'icon' => esc_html__('Icon', 'kingster'),
						'image' => esc_html__('Image', 'kingster')
					),
					'default' => 'icon'
				),
				'title-left-icon' => array(
					'title' => esc_html__('Title Left Icon', 'kingster'),
					'type' => 'icons',
					'allow-none' => true,
					'wrapper-class' => 'gdlr-core-fullsize',
					'condition' => array('title-left-media' => 'icon')
				),
				'title-left-image' => array(
					'title' => esc_html__('Upload Image', 'kingster'),
					'type' => 'upload',
					'condition' => array('title-left-media' => 'image')
				),
				'title' => array(
					'title' => esc_html__('Title', 'kingster'),
					'type' => 'text',
				),
				'title-divider' => array(
					'title' => esc_html__('Title Divider', 'kingster'),
					'type' => 'checkbox',
					'default' => 'disable'
				),
				'title-divider-width' => array(
					'title' => esc_html__('Title Divider Size', 'kingster'),
					'type' => 'text',
					'data-input-type' => 'pixel',
					'condition' => array( 'title-divider' => 'enable' )
				),
				'caption' => array(
					'title' => esc_html__('Caption', 'kingster'),
					'type' => 'textarea',
				),
				'caption-position' => array(
					'title' => esc_html__('Caption Position', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'top' => esc_html__('Above Title', 'kingster'),
						'bottom' => esc_html__('Below Title', 'kingster'),
					)
				),
				'read-more-text' => array(
					'title' => esc_html__('Read More Text', 'kingster'),
					'type' => 'text',
					'default' => esc_html__('Read More', 'kingster'),
				),
				'read-more-link' => array(
					'title' => esc_html__('Read More Link', 'kingster'),
					'type' => 'text',
				),
				'read-more-target' => array(
					'title' => esc_html__('Read More Target', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'_self' => esc_html__('Current Screen', 'kingster'),
						'_blank' => esc_html__('New Window', 'kingster'),
					),
				),
				'title-size' => array(
					'title' => esc_html__('Title Size', 'kingster'),
					'type' => 'fontslider',
					'default' => '41px'
				),
				'title-letter-spacing' => array(
					'title' => esc_html__('Title Letter Spacing', 'kingster'),
					'type' => 'text',
					'data-input-type' => 'pixel',
				),
				'title-line-height' => array(
					'title' => esc_html__('Title Line Height', 'kingster'),
					'type' => 'text',
				),
				'title-font-style' => array(
					'title' => esc_html__('Title Font Style', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'' => esc_html__('Default', 'kingster'),
						'normal' => esc_html__('Normal', 'kingster'),
						'italic' => esc_html__('Italic', 'kingster'),
					),
					'default' => ''
				),
				'title-text-transform' => array(
					'title' => esc_html__('Title Text Transform', 'kingster'),
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
				'caption-size' => array(
					'title' => esc_html__('Caption Size', 'kingster'),
					'type' => 'fontslider',
					'default' => '16px'
				),
				'caption-font-style' => array(
					'title' => esc_html__('Caption Font Style', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'' => esc_html__('Default', 'kingster'),
						'normal' => esc_html__('Normal', 'kingster'),
						'italic' => esc_html__('Italic', 'kingster'),
					),
					'default' => ''
				),
				'caption-spaces' => array(
					'title' => esc_html__('Space Between Caption ( And Title )', 'kingster'),
					'type' => 'text',
					'data-input-type' => 'pixel',
					'default' => ''
				),
				'read-more-size' => array(
					'title' => esc_html__('Read More Size', 'kingster'),
					'type' => 'fontslider',
					'default' => '14px',
				),
				'title-left-icon-color' => array(
					'title' => esc_html__('Title Left Icon Color', 'kingster'),
					'type' => 'colorpicker'
				),
				'title-color' => array(
					'title' => esc_html__('Title Color', 'kingster'),
					'type' => 'colorpicker'
				),
				'title-divider-color' => array(
					'title' => esc_html__('Title Divider Color', 'kingster'),
					'type' => 'colorpicker',
					'condition' => array( 'title-divider' => 'enable' )
				),
				'caption-color' => array(
					'title' => esc_html__('Caption Color', 'kingster'),
					'type' => 'colorpicker'
				),
				'read-more-color' => array(
					'title' => esc_html__('Read More Color', 'kingster'),
					'type' => 'colorpicker',
				),
				'title-wrap-bottom-margin' => array(
					'title' => esc_html__('Title Wrap Bottom Margin', 'kingster'),
					'type' => 'text',
					'data-input-type' => 'pixel',
				),
				'title-carousel-nav-style' => array(
					'title' => esc_html__('Title Carousel Nav Style (if any)', 'kingster'),
					'type' => 'combobox',
					'options' => array(
						'default' => esc_html__('Default', 'kingster'),
						'gdlr-core-plain-style gdlr-core-small' => esc_html__('Small Plain Style', 'kingster'),
						'gdlr-core-plain-style' => esc_html__('Plain Style', 'kingster'),
						'gdlr-core-plain-circle-style' => esc_html__('Plain Circle Style', 'kingster'),
						'gdlr-core-round-style' => esc_html__('Large Round Style', 'kingster'),
						'gdlr-core-round-style gdlr-core-small' => esc_html__('Small Round Style', 'kingster'),
						'gdlr-core-rectangle-style' => esc_html__('Rectangle Style', 'kingster'),
						'gdlr-core-rectangle-style gdlr-core-large' => esc_html__('Large Rectangle Style', 'kingster'),
					)
				)
			);
		}
	}
	add_filter('gdlr_core_block_item_title', 'kingster_block_item_title', 10, 2);
	if( !function_exists('kingster_block_item_title') ){
		function kingster_block_item_title( $ret = '', $settings = array() ){

			$settings['title-size'] = (empty($settings['title-size']) || $settings['title-size'] == '41px')? '': $settings['title-size'];
			$settings['caption-size'] = (empty($settings['caption-size']) || $settings['caption-size'] == '16px')? '': $settings['caption-size'];
			$settings['read-more-size'] = (empty($settings['read-more-size']) || $settings['read-more-size'] == '14px')? '': $settings['read-more-size'];

			if( !empty($settings['title']) || !empty($settings['caption']) ){ 

				$title_align = empty($settings['title-align'])? 'left': $settings['title-align'];
				$extra_class  = ' gdlr-core-' . $title_align . '-align';
				$extra_class .= (!isset($settings['pdlr']) || $settings['pdlr'] == true)? ' gdlr-core-item-mglr': '';

				$ret .= '<div class="gdlr-core-block-item-title-wrap ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
					'margin-bottom' => empty($settings['title-wrap-bottom-margin'])? '': $settings['title-wrap-bottom-margin']
				)) . ' >';
				if( !empty($settings['caption']) && 
					((!empty($settings['caption-position']) && $settings['caption-position'] == 'top') ||
					 (empty($settings['caption-position']) && $title_align == 'left')) ){
					
					$ret .= '<div class="gdlr-core-block-item-caption gdlr-core-top gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size'],
						'font-style' => empty($settings['caption-font-style'])? '': $settings['caption-font-style'],
						'color' => empty($settings['caption-color'])? '': $settings['caption-color'],
						'margin-bottom' => empty($settings['caption-spaces'])? '': $settings['caption-spaces']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				if( !empty($settings['title']) ){
					$ret .= '<div class="gdlr-core-block-item-title-inner clearfix" >';
					$ret .= '<h3 class="gdlr-core-block-item-title" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['title-size'],
						'font-weight' => empty($settings['title-font-weight'])? '': $settings['title-font-weight'],
						'font-style' => empty($settings['title-font-style'])? '': $settings['title-font-style'],
						'text-transform' => (empty($settings['title-text-transform']) || $settings['title-text-transform'] == 'uppercase')? '': $settings['title-text-transform'],
						'letter-spacing' => empty($settings['title-letter-spacing'])? '': $settings['title-letter-spacing'],
						'line-height' => empty($settings['title-line-height'])? '': $settings['title-line-height'],
						'color' => empty($settings['title-color'])? '': $settings['title-color']
					)) . ' >';
					if( empty($settings['title-left-media']) || $settings['title-left-media'] == 'icon' ){
						if( !empty($settings['title-left-icon']) ){
							$ret .= '<i class="' . esc_attr($settings['title-left-icon']) . '" ' . gdlr_core_esc_style(array(
								'color' => (empty($settings['title-left-icon-color'])? '': $settings['title-left-icon-color'])
							)) . ' ></i>';
						}
					}else{
						if( !empty($settings['title-left-image']) ){
							$ret .= gdlr_core_get_image($settings['title-left-image']);
						}
					}
					$ret .= gdlr_core_text_filter($settings['title']);
					$ret .= '</h3>';

					if( !empty($settings['title-divider']) && $settings['title-divider'] == 'enable' ){
						$ret .= '<div class="gdlr-core-block-item-title-divider" ' . gdlr_core_esc_style(array(
							'font-size' => $settings['title-size'],
							'border-bottom-color' => empty($settings['title-divider-color'])? '': $settings['title-divider-color'],
							'border-bottom-width' => empty($settings['title-divider-width'])? '': $settings['title-divider-width'],
						)) . ' ></div>';
					}
					$ret .= '</div>'; // gdlr-core-block-item-title-inner
				}
				if( !empty($settings['caption']) && 
					((!empty($settings['caption-position']) && $settings['caption-position'] == 'bottom') ||
					 (empty($settings['caption-position']) && $title_align == 'center')) ){

					$ret .= '<div class="gdlr-core-block-item-caption gdlr-core-bottom gdlr-core-info-font gdlr-core-skin-caption" ' . gdlr_core_esc_style(array(
						'font-size' => $settings['caption-size'],
						'font-style' => empty($settings['caption-font-style'])? '': $settings['caption-font-style'],
						'color' => empty($settings['caption-color'])? '': $settings['caption-color'],
						'margin-top' => empty($settings['caption-spaces'])? '': $settings['caption-spaces']
					)) . ' >' . gdlr_core_text_filter($settings['caption']) . '</div>';
				}
				if( !empty($settings['read-more-text']) && !empty($settings['read-more-link']) ){
					$ret .= '<a class="gdlr-core-block-item-read-more" href="' . esc_url($settings['read-more-link']) . '" ';
					$ret .= empty($settings['read-more-target'])? '': 'target="' . esc_attr($settings['read-more-target']) . '" ';
					$ret .= gdlr_core_esc_style(array(
						'font-size' => $settings['read-more-size'],
						'color' => empty($settings['read-more-color'])? '': $settings['read-more-color']
					));
					$ret .= ' >' . gdlr_core_text_filter($settings['read-more-text']) . '</a>';
				}

				if( !empty($settings['carousel']) && $settings['carousel'] != 'disable' ){
					if( empty($settings['title-carousel-nav-style']) || $settings['title-carousel-nav-style'] == 'default' ){
						$nav_style = apply_filters('gdlr_core_block_item_title_nav_filter', 'gdlr-core-round-style');
					}else{
						$nav_style = $settings['title-carousel-nav-style'];
					}
					
					$ret .= '<div class="gdlr-core-flexslider-nav ' . esc_attr($nav_style) . ' gdlr-core-absolute-center gdlr-core-right" ></div>';
				}
				$ret .= '</div>';

			}else if( !empty($settings['carousel']) && $settings['carousel'] != 'disable' ){

				if( empty($settings['carousel-navigation']) || in_array($settings['carousel-navigation'], array('navigation', 'both')) ){

					$enable_carousel = apply_filters('gdlr_core_block_item_title_only_carousel', 'enable');
					if( $enable_carousel == 'enable' ){
						$extra_class = (!isset($settings['pdlr']) || $settings['pdlr'] == true)? ' gdlr-core-item-mglr': '';

						if( empty($settings['title-carousel-nav-style']) || $settings['title-carousel-nav-style'] == 'default' ){
							$nav_style = 'gdlr-core-plain-style';
						}else{
							$nav_style = $settings['title-carousel-nav-style'];
						}

						$ret .= '<div class="gdlr-core-block-item-title-nav ' . esc_attr($extra_class) . '" >';
						$ret .= '<div class="gdlr-core-flexslider-nav ' . esc_attr($nav_style) . ' gdlr-core-block-center" ></div>';
						$ret .= '</div>';
					}

				}
			} 

			return $ret;
		}
	}