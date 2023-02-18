<?php
/**
 * Template for displaying title of lesson.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

$title = $lesson->get_title( 'display' );

if ( ! $title ) {
	return;
}

$hide_title = get_post_meta($lesson->get_id(), 'kingster-hide-lesson-title', true);

if( empty($hide_title) || $hide_title == 'disable' ){
?>
<h3 class="course-item-title question-title"><?php echo gdlr_core_text_filter($title); ?></h3>
<?php
}
?>