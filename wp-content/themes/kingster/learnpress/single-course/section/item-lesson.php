<?php
/**
 * Template for displaying lesson item section in single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/section/item-lesson.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $item ) ) {
	return;
}
?>

<span class="item-name"><?php 
	// goodlayers
	global $kingster_lp_section_count, $kingster_lp_item_count;

	$kingster_lp_item_count++;

	echo '<span class="kingster-head" >';
	echo sprintf(esc_html__('Lecture %s.%s', 'kingster'), $kingster_lp_section_count, $kingster_lp_item_count);
	echo '</span>';

	echo gdlr_core_text_filter($item->get_title( 'display' )); 
?></span>