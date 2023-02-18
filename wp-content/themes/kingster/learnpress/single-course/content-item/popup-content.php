<?php
/**
 * Content Poup.
 * Use for React Quiz.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

?>

<div id="popup-content">
	<?php
	LP()->template( 'course' )->course_content_item();

	LP()->template( 'course' )->course_item_comments();

    echo '<div class="content-item-wrap kingster-continue" >';
    do_action( 'learn-press/popup-footer' );
    echo '</div>';
	?>
</div>
