<?php
/**
 * Template for displaying no content lesson.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/content-lesson/no-content.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.1
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! isset( $lesson ) ) {
	return;
}

if ( false && $lesson->current_user_can_edit() ) {
	$message = esc_html__( 'Lesson content is empty.', 'kingster' );
	$message .= sprintf( '<a href="%s" class="edit-content">%s</a>', $lesson->get_edit_link(), esc_html__( 'Edit', 'kingster' ) );
	learn_press_display_message( $message, 'notice' );
}