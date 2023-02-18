<?php
	/*	
	*	Goodlayers Product Item
	*/
	
	if( !class_exists('gdlr_core_product_table_item') ){
		class gdlr_core_product_table_item{
			
			var $settings = '';
			
			// init the variable
			function __construct( $settings = array() ){
				
				$this->settings = wp_parse_args($settings, array(
					'category' => '', 
					'tag' => '', 
					'stock-status' => 'all', 
					'num-fetch' => '9', 
					'layout' => 'fitrows',
					'orderby' => 'date', 
					'order' => 'desc',
					'column-size' => 20,
					'pagination' => 'none'
				));

				if( $this->settings['orderby'] == 'rand' ){
					$this->settings['orderby'] = 'RAND(' . rand(1, 1000) . ')';
				} 
			}
			
			// get the content of the product item
			function get_content(){

				$ret = '';
				if( empty($this->settings['query']) ){
					$query = $this->get_product_query();
				}else{
					$query = $this->settings['query'];
				}

				gdlr_core_setup_admin_postdata();
				
				$ret .= '<div class="gdlr-core-product-item-table-holder gdlr-core-js-2 clearfix" >';
				$ret .= $this->get_product_table_content($query);
				$ret .= '</div>';

				wp_reset_postdata();
				gdlr_core_reset_admin_postdata();

				// pagination
				if( $this->settings['pagination'] != 'none' ){
					$extra_class = 'gdlr-core-item-pdlr';

					if( $this->settings['pagination'] == 'page' ){
						$ret .= gdlr_core_get_pagination($query->max_num_pages, $this->settings, $extra_class);
					}else if( $this->settings['pagination'] == 'load-more' ){
						$paged = empty($query->query['paged'])? 2: intval($query->query['paged']) + 1;
						$ret .= gdlr_core_get_ajax_load_more('product', $this->settings, $paged, $query->max_num_pages, 'gdlr-core-product-item-holder', $extra_class);
					}
				}

				return $ret;
			}

			function get_product_attribute( $key ){
				global $product;
				return $product->get_attribute($key);
			}
			function get_product_attribute_variation(){
				global $product; 

				$ret = array();
				if( $product->get_type() == 'variable' ){

					$variation = $product->get_variation_prices(true);
					if( !empty($variation['price']) ){
						foreach( $variation['price'] as $variation_id => $price ){
							$wc_variation = new WC_Product_Variation($variation_id);
							$wc_variation_title = $wc_variation->get_title() . ' - ';

							$label = str_replace($wc_variation_title, '', $wc_variation->get_name());
							$ret[$label] = $price;
						}
					}
				}
				
				return $ret;
			}

			// get content of non carousel product item
			function get_product_table_content( $query ){

				$ret = '';
				$count = 0;

				while($query->have_posts()){ $query->the_post(); $count++;

					$ret .= '<div class="gdlr-core-item-list clearfix" >';
					
					$ret .= '<div class="gdlr-core-product-table-head-wrap clearfix" >';
					$feature_image = get_post_thumbnail_id();
					$ret .= '<div class="gdlr-core-product-thumbnail gdlr-core-media-image" >';
					$ret .= gdlr_core_get_image($feature_image, 'thumbnail', array('placeholder' => false));
					$ret .= '</div>';
					
					$ret .= '<div class="gdlr-core-product-table-head" >';
					$ret .= '<h3 class="gdlr-core-title" ><a href="' . get_permalink() . '" >' . get_the_title() . '</a></h3>';
					
					$caption_fields = array_map('trim', explode('|', 'Type | THC | CBC'));
					if( !empty($caption_fields) ){
						$ret .= '<div class="gdlr-core-caption" >';
						foreach( $caption_fields as $field ){
							$att = $this->get_product_attribute($field);
							$ret .= '<span class="gdlr-core-att" >' . $field . ': ' . $att . '</span>';
						} 
						$ret .= '</div>';
					}
					$ret .= '</div>'; // gdlr-core-product-table-head
					$ret .= '</div>'; // gdlr-core-product-table-head-wrap

					$variations = $this->get_product_attribute_variation();
					$variation_fields =  array_map('trim', explode('|', '1 Oz | 1/8 Oz | 1/4 Oz'));
					$ret .= '<div class="gdlr-core-product-variation-table" >';
					foreach( $variation_fields as $field_slug ){
						$ret .= '<div class="gdlr-core-item" >';
						if( !empty($variations[$field_slug]) ){
							$ret .= '<div class="gdlr-core-tail" >' . $variations[$field_slug] . '</div>';
							$ret .= '<div class="gdlr-core-head" >' . $field_slug . '</div>';
						}
						$ret .= '</div>';
					}
					$ret .= '</div>';
					
					$ret .= '<div class="gdlr-core-learn-more" ><a href="' . get_permalink() . '" >';
					$ret .= esc_html__('Learn More', 'goodlayers-core');
					$ret .= '</a></div>';
					$ret .= '</div>';
					// $ret .= $product_style->get_content($this->settings);

				} // while

				return $ret;
			}
			
			// query the post
			function get_product_query(){
				
				$args = array( 'post_type' => 'product', 'post_status' => 'publish', 'suppress_filters' => false );
				
				// category - tag selection
				if( !empty($this->settings['category']) || !empty($this->settings['tag']) ){
					$args['tax_query'] = array(
						'relation' => empty($this->settings['relation'])? 'OR': $this->settings['relation']
					);
					
					if( !empty($this->settings['category']) ){
						array_push($args['tax_query'], array('terms'=>$this->settings['category'], 'taxonomy'=>'product_cat', 'field'=>'slug'));
					}
					if( !empty($this->settings['tag']) ){
						array_push($args['tax_query'], array('terms'=>$this->settings['tag'], 'taxonomy'=>'product_tag', 'field'=>'slug'));
					}
				}

				// pagination
				if( empty($this->settings['paged']) ){
					$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : get_query_var('page');
					$args['paged'] = empty($args['paged'])? 1: $args['paged'];
				}else{
					$args['paged'] = $this->settings['paged'];
				}
				$this->settings['paged'] = $args['paged'];				

				if( !empty($this->settings['stock-status']) && $this->settings['stock-status'] != 'all' ){
					 $args['meta_query'] = array(
				        array(
				            'key' => '_stock_status',
				            'value' => $this->settings['stock-status']
				        )
				    );
				}

				// variable
				$args['posts_per_page'] = $this->settings['num-fetch'];
				$args['orderby'] = $this->settings['orderby'];
				$args['order'] = $this->settings['order'];
				
				$query = new WP_Query( $args );

				return $query;
			}
			
		} // gdlr_core_product_item
	} // class_exists
	
	add_action('wp_ajax_gdlr_core_product_ajax', 'gdlr_core_product_ajax');
	add_action('wp_ajax_nopriv_gdlr_core_product_ajax', 'gdlr_core_product_ajax');
	if( !function_exists('gdlr_core_product_ajax') ){
		function gdlr_core_product_ajax(){

			if( !empty($_POST['settings']) ){

				$settings = $_POST['settings'];
				if( !empty($_POST['option']) ){	
					$settings[$_POST['option']['name']] = $_POST['option']['value'];
				}

				$product_item = new gdlr_core_product_item($settings);
				$query = $product_item->get_product_query();	

				$ret = array(
					'status'=> 'success',
					'content'=> $product_item->get_product_grid_content($query)
				);
				if( !empty($settings['pagination']) && $settings['pagination'] != 'none' ){
					if( $settings['pagination'] == 'load-more' ){
						$paged = empty($query->query['paged'])? 2: intval($query->query['paged']) + 1;
						$extra_class = ($settings['no-space'] == 'yes')? '': 'gdlr-core-item-pdlr';

						$ret['load_more'] = gdlr_core_get_ajax_load_more('product', $settings, $paged, $query->max_num_pages, 'gdlr-core-product-item-holder', $extra_class);
						$ret['load_more'] = empty($ret['load_more'])? 'none': $ret['load_more'];
					}
				} 

				die(json_encode($ret));
			}else{
				die(json_encode(array(
					'status'=> 'failed',
					'message'=> esc_html__('Settings variable is not defined.', 'goodlayers-core')
				)));
			}

		} // gdlr_core_product_load_more
	} // function_exists

	