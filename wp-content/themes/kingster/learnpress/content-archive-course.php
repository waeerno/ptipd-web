<?php
/**
 * Template for displaying archive course content.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-archive-course.php
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $post, $wp_query, $lp_tax_query, $wp_query;

/**
 * @deprecated
 */
do_action( 'learn_press_before_main_content' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/before-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_archive_description' );

/**
 * @since 3.0.0
 */
do_action( 'learn-press/archive-description' );

if ( LP()->wp_query->have_posts() ) :

	echo '<div class="kingster-lp-archive-course kingster-item-rvpdlr" >';
	/**
	 * @deprecated
	 */
	do_action( 'learn_press_before_courses_loop' );

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/before-courses-loop' );

	learn_press_begin_courses_loop();

	$course_style = new kingster_lp_course_style();
	$count = 0;

	while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post(); $count++;
 
		echo '<li class="kingster-lp-archive-course-item kingster-column-20 kingster-item-pdlr ';
		echo ($count % 3 == 1)? ' kingster-first': '';
		echo '" >';
		echo $course_style->get_content(array(
			'course-style' => 'grid',
			'course-grid-bottom-info' => array('price', 'wishlist'),
			'course-grid-bottom-info2' => array('lecture', 'student'),
			'thumbnail-size' => kingster_get_option('lp', 'course-list-thumbnail-size', 'full'),
			'excerpt' => 'specify-number',
			'excerpt-number' => 0
		));
		echo '</li>';

		// learn_press_get_template_part( 'content', 'course' );

	endwhile;

	learn_press_end_courses_loop();

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn_press_after_courses_loop' );

	/**
	 * @deprecated
	 */
	do_action( 'learn-press/after-courses-loop' );

	echo '</div>';

	wp_reset_postdata();

else:
	learn_press_display_message( __( 'No course found.', 'learnpress' ), 'error' );
endif;

/**
 * @since 3.0.0
 */
do_action( 'learn-press/after-main-content' );

/**
 * @deprecated
 */
do_action( 'learn_press_after_main_content' );