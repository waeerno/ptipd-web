<?php
/**
 * Template for displaying instructor of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/instructor.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.3.0
 */

defined( 'ABSPATH' ) || exit();

$course     = LP_Global::course();
$instructor = $course->get_instructor();
?>

<div class="course-author">

	<?php do_action( 'learn-press/before-single-course-instructor' ); ?>

    <div class="author-thumbnail">
		<?php echo gdlr_core_text_filter($course->get_instructor()->get_profile_picture('', 260)); ?>
    </div>

    <div class="author-bio">
    	<?php echo '<div class="author-name" >' . $course->get_instructor_html() . '</div>'; ?>
    	<div class="author-description margin-bottom">
			<?php
			/**
			 * LP Hook
			 *
			 * @since 4.0.0
			 */
			do_action( 'learn-press/begin-course-instructor-description', $instructor );

			echo $instructor->get_description();

			/**
			 * LP Hook
			 *
			 * @since 4.0.0
			 */
			do_action( 'learn-press/end-course-instructor-description', $instructor );

			?>
		</div>

		<?php
		/**
		 * LP Hook
		 *
		 * @since 4.0.0
		 */
		do_action( 'learn-press/after-course-instructor-description', $instructor );
		?>

		<?php

		/**
		 * LP Hook
		 *
		 * @since 4.0.0
		 */
		do_action( 'learn-press/after-course-instructor-socials', $instructor );

		?>
    </div>

	<?php do_action( 'learn-press/after-single-course-instructor' ); ?>

</div>