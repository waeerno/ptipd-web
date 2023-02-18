<?php

/**
 * Template for displaying the list of course content is in wishlist.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/wishlist/wishlist-content.php.
 *
 * @author ThimPress
 * @package LearnPress/Wishlist/Templates
 * @version 3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

global $post;
?>

<li id="learn-press-tab-wishlist-course-<?php echo $post->ID; ?>" class="course" data-context="tab-wishlist">

	<?php do_action( 'learn_press_before_profile_tab_wishlist_loop_course' ); ?>
   	
	<?php
		$course_style = new kingster_lp_course_style();
		echo $course_style->get_content(array(
			'course-style' => 'grid',
			'course-grid-bottom-info' => array('price', 'wishlist'),
			'course-grid-bottom-info2' => array('lecture', 'student'),
			'thumbnail-size' => kingster_get_option('lp', 'course-list-thumbnail-size', 'full'),
			'excerpt' => 'specify-number',
			'excerpt-number' => 0
		));
	?>

	<?php do_action( 'learn_press_after_profile_tab_wishlist_loop_course' ); ?>

</li>