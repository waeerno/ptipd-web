<?php

	add_action('goodlayers_core_course_search_content', 'goodlayers_core_course_search_content', 10, 1);
	if( !function_exists('goodlayers_core_course_search_content') ){
		function goodlayers_core_course_search_content( $settings ){

			$search_template = apply_filters('gdlr_core_course_search_template', '');

			if( !isset($_GET['course-keywords']) ){ 
				if( empty($search_template) || $search_template != get_the_ID() ){
					return ''; 
				}
			}

?>
<div class="gdlr-core-course-search-page" >
	<div class="gdlr-core-course-search-page-container gdlr-core-container clearfix">
		<div class="gdlr-core-course-search-page-content-wrap gdlr-core-column-40" >
			<div class="gdlr-core-course-search-page-content" >
			<?php
				$atts = array(
					'num-fetch' => empty($settings['num-fetch'])? 9: $settings['num-fetch'],
					'orderby' => 'date',
					'order' => 'desc',
					'course-style' => 'list-info',
					'course-info' => empty($settings['course-info'])? array(): $settings['course-info'],
					'padding-bottom' => '0px',
					'pagination' => 'page',
					'keywords' => empty($_GET['course-keywords'])? '': $_GET['course-keywords'],
					'course-id' => empty($_GET['course-id'])? '': $_GET['course-id']
				);

				// taxonomy
				$tax_fields = array( 
					'course_category' => esc_html__('Category', 'tourmaster'),
					'course_tag' => esc_html__('Tag', 'tourmaster') 
				);
				$tax_fields = $tax_fields + goodlayers_core_course_get_custom_tax_list();
				foreach( $tax_fields as $tax_field => $tax_title ){
					if( !empty($_GET[$tax_field]) ){
						$atts[$tax_field] = $_GET[$tax_field];
					}
				}

				echo gdlr_core_pb_element_course::get_content($atts);
			?>
			</div>
		</div>
		<div class="gdlr-core-column-20" >
			<div class="gdlr-core-course-search-page-sidebar" >
			<?php
				$atts = array(
					'title' => esc_html__('Search For Courses', 'goodlayers-core-course'),
					'search-fields' => empty($settings['search-fields'])? array('keywords', 'course-id', 'course_category', 'course_tag'): $settings['search-fields'],
					'with-frame' => 'enable',
					'title-color' => empty($settings['title-color'])? '': $settings['title-color'],
					'frame-background' => empty($settings['frame-background'])? '': $settings['frame-background'],
					'column' => 1
				);


				echo gdlr_core_pb_element_course_search::get_content($atts);
			?>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}

	add_action('goodlayers_core_course_archive_content', 'goodlayers_core_course_archive_content', 10, 1);
	if( !function_exists('goodlayers_core_course_archive_content') ){
		function goodlayers_core_course_archive_content( $settings ){
?>
<div class="gdlr-core-course-archive-page" >
	<div class="gdlr-core-course-archive-page-container gdlr-core-container clearfix">
		<div class="gdlr-core-course-archive-page-content-wrap gdlr-core-column-40" >
			<div class="gdlr-core-course-archive-page-content" >
			<?php
				global $wp_query;
				$atts = array(
					'num-fetch' => empty($settings['num-fetch'])? 9: $settings['num-fetch'],
					'course-style' => 'list-info',
					'course-info' => empty($settings['course-info'])? array(): $settings['course-info'],
					'padding-bottom' => '0px',
					'pagination' => 'page',
					'query' => $wp_query
				);

				echo gdlr_core_pb_element_course::get_content($atts);
			?>
			</div>
		</div>
		<div class="gdlr-core-column-20" >
			<div class="gdlr-core-course-archive-page-sidebar" >
			<?php
				$atts = array(
					'title' => esc_html__('Search For Courses', 'goodlayers-core-course'),
					'search-fields' => empty($settings['search-fields'])? array('keywords', 'course-id', 'course_category', 'course_tag'): $settings['search-fields'],
					'with-frame' => 'enable',
					'title-color' => empty($settings['title-color'])? '': $settings['title-color'],
					'frame-background' => empty($settings['frame-background'])? '': $settings['frame-background'],
					'column' => 1
				);
				echo gdlr_core_pb_element_course_search::get_content($atts);
			?>
			</div>
		</div>
	</div>
</div>
<?php
		}
	}