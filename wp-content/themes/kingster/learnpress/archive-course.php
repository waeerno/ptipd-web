<?php
/**
 * Template for displaying content of archive courses page.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.0
 */

defined( 'ABSPATH' ) || exit;


global $kingster_archive_title;
$kingster_archive_title = learn_press_page_title( false );

/**
 * @since 4.0.0
 *
 * @see LP_Template_General::template_header()
 */
do_action( 'learn-press/template-header' );

/**
 * LP Hook
 */
do_action( 'learn-press/before-main-content' );

$page_title = learn_press_page_title( false );
?>

<div class="kingster-container kingster-lp-content-area">
	<?php
	/**
	 * LP Hook
	 */
	echo '<div class="kingster-lp-archive-course" >';

	do_action( 'learn-press/before-courses-loop' );

	LP()->template( 'course' )->begin_courses_loop();

	$course_style = new kingster_lp_course_style();
	$count = 0;

	while ( have_posts() ) : the_post(); $count++;

		echo '<li class="kingster-lp-archive-course-item kingster-column-20 kingster-item-pdlr ';
		if( $count % 3 == 1 ){
			echo ' kingster-first';
		}
		echo '" >';
		echo gdlr_core_text_filter($course_style->get_content(array(
			'course-style' => 'grid',
			'course-grid-bottom-info' => array('price', 'wishlist'),
			'course-grid-bottom-info2' => array('lecture', 'student'),
			'thumbnail-size' => kingster_get_option('lp', 'course-list-thumbnail-size', 'full'),
			'excerpt' => 'specify-number',
			'excerpt-number' => 0
		)));
		echo '</li>';

	endwhile;

	LP()->template( 'course' )->end_courses_loop();

	/**
	 * @since 3.0.0
	 */
	do_action( 'learn-press/after-courses-loop' );

	echo '</div>'; // kingster-lp-archive-course


	/**
	 * LP Hook
	 */
	do_action( 'learn-press/after-main-content' );

	/**
	 * LP Hook
	 *
	 * @since 4.0.0
	 */
	do_action( 'learn-press/sidebar' );
	?>
</div>

<?php
/**
 * @since 4.0.0
 *
 * @see   LP_Template_General::template_footer()
 */
do_action( 'learn-press/template-footer' );
