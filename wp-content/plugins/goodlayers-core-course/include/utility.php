<?php
	
	// get table html data
	if( !function_exists('goodlayers_core_course_get_table_head') ){
		function goodlayers_core_course_get_table_head( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<th>' . $column . '</th>';
			}
			echo '</tr>';
		}
	}
	if( !function_exists('goodlayers_core_course_get_table_content') ){
		function goodlayers_core_course_get_table_content( $data, $settings = array() ){
			echo '<tr>';
			foreach( $data as $column ){
				echo '<td>' . $column . '</td>';
			}
			echo '</tr>';
		}
	}