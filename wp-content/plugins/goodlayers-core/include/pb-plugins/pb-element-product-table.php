<?php
	/*	
	*	Goodlayers Item For Page Builder
	*/
	
	gdlr_core_page_builder_element::add_element('product-table', 'gdlr_core_pb_element_product_table'); 
	
	if( !class_exists('gdlr_core_pb_element_product_table') ){
		class gdlr_core_pb_element_product_table{
			
			// get the element settings
			static function get_settings(){
				return array(
					'icon' => 'fa-shopping-cart',
					'title' => esc_html__('Product Table (Woocommerce)', 'goodlayers-core')
				);
			}
			
			// return the element options
			static function get_options(){
				global $gdlr_core_item_pdb;
				
				return apply_filters('gdlr_core_product_item_options', array(					
					'general' => array(
						'title' => esc_html__('General', 'goodlayers-core'),
						'options' => array(
							'category' => array(
								'title' => esc_html__('Category', 'goodlayers-core'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('product_cat'),
								'description' => esc_html__('You can use Ctrl/Command button to select multiple items or remove the selected item. Leave this field blank to select all items in the list.', 'goodlayers-core'),
							),
							'tag' => array(
								'title' => esc_html__('Tag', 'goodlayers-core'),
								'type' => 'multi-combobox',
								'options' => gdlr_core_get_term_list('product_tag')
							),
							'relation' => array(
								'title' => esc_html__('Relation (Category & Tag)', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'or' => esc_html__('OR', 'goodlayers-core'),
									'and' => esc_html__('AND', 'goodlayers-core')
								)
							),
							'num-fetch' => array(
								'title' => esc_html__('Num Fetch', 'goodlayers-core'),
								'type' => 'text',
								'default' => 9,
								'data-input-type' => 'number',
								'description' => esc_html__('The number of posts showing on the product item', 'goodlayers-core')
							),
							'stock-status' => array(
								'title' => esc_html__('Stock Status', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'all' => esc_html__('All', 'goodlayers-core'), 
									'instock' => esc_html__('In Stock', 'goodlayers-core'), 
									'outofstock' => esc_html__('Out of Stock', 'goodlayers-core'), 
									'onrequest' => esc_html__('On Request', 'goodlayers-core'), 
								)
							),
							'orderby' => array(
								'title' => esc_html__('Order By', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'date' => esc_html__('Publish Date', 'goodlayers-core'), 
									'title' => esc_html__('Title', 'goodlayers-core'), 
									'rand' => esc_html__('Random', 'goodlayers-core'), 
									'menu_order' => esc_html__('Menu Order', 'goodlayers-core'), 
								)
							),
							'order' => array(
								'title' => esc_html__('Order', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'desc'=>esc_html__('Descending Order', 'goodlayers-core'), 
									'asc'=> esc_html__('Ascending Order', 'goodlayers-core'), 
								)
							),

						),
					),
					'settings' => array(
						'title' => esc_html__('Product Style', 'goodlayers-core'),
						'options' => array(
							'column-size' => array(
								'title' => esc_html__('Column Size', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
								'default' => 20,
							),
							'pagination' => array(
								'title' => esc_html__('Pagination', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'none'=>esc_html__('None', 'goodlayers-core'), 
									'page'=>esc_html__('Page', 'goodlayers-core'), 
									'load-more'=>esc_html__('Load More', 'goodlayers-core'), 
								),
								'description' => esc_html__('Pagination is not supported and will be automatically disabled on carousel layout.', 'goodlayers-core'),
							),
							'pagination-style' => array(
								'title' => esc_html__('Pagination Style', 'goodlayers-core'),
								'type' => 'combobox',
								'options' => array(
									'default' => esc_html__('Default', 'goodlayers-core'),
									'plain' => esc_html__('Plain', 'goodlayers-core'),
									'rectangle' => esc_html__('Rectangle', 'goodlayers-core'),
									'rectangle-border' => esc_html__('Rectangle Border', 'goodlayers-core'),
									'round' => esc_html__('Round', 'goodlayers-core'),
									'round-border' => esc_html__('Round Border', 'goodlayers-core'),
									'circle' => esc_html__('Circle', 'goodlayers-core'),
									'circle-border' => esc_html__('Circle Border', 'goodlayers-core'),
								),
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
							'pagination-align' => array(
								'title' => esc_html__('Pagination Alignment', 'goodlayers-core'),
								'type' => 'radioimage',
								'options' => 'text-align',
								'with-default' => true,
								'default' => 'default',
								'condition' => array( 'pagination' => 'page' )
							),
						),
					),	
					'typography' => array(
						'title' => esc_html__('Typography', 'goodlayers-core'),
						'options' => array(
							'product-title-font-size' => array(
								'title' => esc_html__('Product Title Font Size', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),
							'product-title-font-weight' => array(
								'title' => esc_html__('Product Title Font Weight', 'goodlayers-core'),
								'type' => 'text',
								'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'goodlayers-core')
							),
							'product-title-letter-spacing' => array(
								'title' => esc_html__('Product Title Letter Spacing', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
							),							
							'product-title-text-transform' => array(
								'title' => esc_html__('Product Title Text Transform', 'goodlayers-core'),
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
						'title' => esc_html__('Spacing', 'goodlayers-core'),
						'options' => array(
							'padding-bottom' => array(
								'title' => esc_html__('Padding Bottom', 'goodlayers-core'),
								'type' => 'text',
								'data-input-type' => 'pixel',
								'default' => $gdlr_core_item_pdb
							),
						),
					)
				));
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
						'category' => '', 'tag' => '', 'num-fetch' => '9', 'orderby' => 'date', 'order' => 'desc',
						'column-size' => 20, 'layout' => 'fitrows',
						'padding-bottom' => $gdlr_core_item_pdb
					);
				}

				// start printing item
				$ret  = '<div class="gdlr-core-product-table-item gdlr-core-item-pdb clearfix" ';
				if( !empty($settings['padding-bottom']) && $settings['padding-bottom'] != $gdlr_core_item_pdb ){
					$ret .= gdlr_core_esc_style(array('padding-bottom'=>$settings['padding-bottom']));
				}
				if( !empty($settings['id']) ){
					$ret .= ' id="' . esc_attr($settings['id']) . '" ';
				}
				$ret .= ' >';

				if( class_exists('WooCommerce') ){
							
					// pring product item
					$product_item = new gdlr_core_product_table_item($settings);
					
					$ret .= $product_item->get_content();

				}else{
					$ret .= '<div class="gdlr-core-external-plugin-message">' . esc_html__('Please install and activate the "Woocommerce" plugin before using this item.', 'goodlayers-core') . '</div>';
				}
				
				$ret .= '</div>'; // gdlr-core-product-item

				return $ret;
			}			
			
		} // gdlr_core_pb_element_product
	} // class_exists	