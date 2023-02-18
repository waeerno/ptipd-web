<?php
/**
 * The template for displaying the footer
 */
    get_template_part( 'admin/core/layout/footer', 'default' );
	$post_option = kingster_get_post_option(get_the_ID());
	if( empty($post_option['enable-footer']) || $post_option['enable-footer'] == 'default' ){
		$enable_footer = kingster_get_option('general', 'enable-footer', 'enable');
	}else{
		$enable_footer = $post_option['enable-footer'];
	}	
	if( empty($post_option['enable-copyright']) || $post_option['enable-copyright'] == 'default' ){
		$enable_copyright = kingster_get_option('general', 'enable-copyright', 'enable');
	}else{
		$enable_copyright = $post_option['enable-copyright'];
	}

	$fixed_footer = kingster_get_option('general', 'fixed-footer', 'disable');
	echo '</div>'; // kingster-page-wrapper

	$footer_divider = kingster_get_option('general', 'enable-footer-divider', 'enable');
	$footer_class = ($footer_divider == 'enable')? '': ' kingster-no-title-divider';

	if( $enable_footer == 'enable' || $enable_copyright == 'enable' ){

		if( $fixed_footer == 'enable' ){
			echo '</div>'; // kingster-body-wrapper

			echo '<footer class="kingster-fixed-footer ' . esc_attr($footer_class) . '" id="kingster-fixed-footer" >';
		}else{
			echo '<footer class="' . esc_attr($footer_class) . '" >';
		}

		if( $enable_footer == 'enable' ){

			$kingster_footer_layout = array(
				'footer-1'=>array('kingster-column-60'),
				'footer-2'=>array('kingster-column-15', 'kingster-column-15', 'kingster-column-15', 'kingster-column-15'),
				'footer-3'=>array('kingster-column-15', 'kingster-column-15', 'kingster-column-30',),
				'footer-4'=>array('kingster-column-20', 'kingster-column-20', 'kingster-column-20'),
				'footer-5'=>array('kingster-column-20', 'kingster-column-40'),
				'footer-6'=>array('kingster-column-40', 'kingster-column-20'),
			);
			$footer_style = kingster_get_option('general', 'footer-style');
			$footer_style = empty($footer_style)? 'footer-2': $footer_style;

			$count = 0;
			$has_widget = false;
			foreach( $kingster_footer_layout[$footer_style] as $layout ){ $count++;
				if( is_active_sidebar('footer-' . $count) ){ $has_widget = true; }
			}

			if( $has_widget ){ 	

				$footer_column_divider = kingster_get_option('general', 'enable-footer-column-divider', 'enable');
				$extra_class  = ($footer_column_divider == 'enable')? ' kingster-with-column-divider': '';

				echo '<div class="kingster-footer-wrapper ' . esc_attr($extra_class) . '" >';
				echo '<div class="kingster-footer-container kingster-container clearfix" >';
				
				$count = 0;
				foreach( $kingster_footer_layout[$footer_style] as $layout ){ $count++;
					echo '<div class="kingster-footer-column kingster-item-pdlr ' . esc_attr($layout) . '" >';
					if( is_active_sidebar('footer-' . $count) ){
						dynamic_sidebar('footer-' . $count); 
					}
					echo '</div>';
				}
				
				echo '</div>'; // kingster-footer-container
				echo '</div>'; // kingster-footer-wrapper 
			}
		} // enable footer

		if( $enable_copyright == 'enable' ){
			$copyright_style = kingster_get_option('general', 'copyright-style', 'center');
			
			if( $copyright_style == 'center' ){
				$copyright_text = kingster_get_option('general', 'copyright-text');

				if( !empty($copyright_text) ){
					echo '<div class="kingster-copyright-wrapper" >';
					echo '<div class="kingster-copyright-container kingster-container">';
					echo '<div class="kingster-copyright-text kingster-item-pdlr">';
					echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_text));
					echo '</div>';
					echo '</div>';
					echo '</div>'; // kingster-copyright-wrapper
				}
			}else if( $copyright_style == 'left-right' ){
				$copyright_left = kingster_get_option('general', 'copyright-left');
				$copyright_right = kingster_get_option('general', 'copyright-right');

				if( !empty($copyright_left) || !empty($copyright_right) ){
					echo '<div class="kingster-copyright-wrapper" >';
					echo '<div class="kingster-copyright-container kingster-container clearfix">';
					if( !empty($copyright_left) ){
						echo '<div class="kingster-copyright-left kingster-item-pdlr">';
						echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_left));
						echo '</div>';
					}

					if( !empty($copyright_right) ){
						echo '<div class="kingster-copyright-right kingster-item-pdlr">';
						echo gdlr_core_escape_content(gdlr_core_text_filter($copyright_right));
						echo '</div>';
					}
					echo '</div>';
					echo '</div>'; // kingster-copyright-wrapper
				}
			}
		}

		echo '</footer>';

		if( $fixed_footer == 'disable' ){
			echo '</div>'; // kingster-body-wrapper
		}
		echo '</div>'; // kingster-body-outer-wrapper

	// disable footer	
	}else{
		echo '</div>'; // kingster-body-wrapper
		echo '</div>'; // kingster-body-outer-wrapper
	}

	$header_style = kingster_get_option('general', 'header-style', 'plain');
	
	if( $header_style == 'side' || $header_style == 'side-toggle' ){
		echo '</div>'; // kingster-header-side-nav-content
	}

	$back_to_top = kingster_get_option('general', 'enable-back-to-top', 'disable');
	if( $back_to_top == 'enable' ){
		echo '<a href="#kingster-top-anchor" class="kingster-footer-back-to-top-button" id="kingster-footer-back-to-top-button"><i class="fa fa-angle-up" ></i></a>';
	}
?>

<?php wp_footer(); ?>

</body>
</html>