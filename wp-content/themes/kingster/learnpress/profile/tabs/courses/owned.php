<?php
/**
 * Template for displaying own courses in courses tab of user profile page.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/courses/own.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.11.2
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile       = learn_press_get_profile();
$filter_status = LP_Request::get_string( 'filter-status' );
$query         = $profile->query_courses( 'own', array( 'status' => $filter_status ) );
?>

<div class="learn-press-subtab-content">

    <h3 class="profile-heading">
		<?php _e( 'My Courses', 'learnpress' ); ?>
    </h3>

	<?php if ( $filters = $profile->get_own_courses_filters( $filter_status ) ) { ?>
        <ul class="lp-sub-menu">
			<?php foreach ( $filters as $class => $link ) { ?>
                <li class="<?php echo $class; ?>"><?php echo $link; ?></li>
			<?php } ?>
        </ul>
	<?php } ?>

	<?php if ( ! $query['total'] ) {
		learn_press_display_message( __( 'No courses!', 'learnpress' ) );
	} else { ?>

        <ul class="learn-press-courses profile-courses-list">
			<?php
			global $post;

			$course_style = new kingster_lp_course_style();
			$count = 0;
			foreach ( $query['items'] as $item ) { $count++;
				$course = learn_press_get_course( $item );
				$post   = get_post( $item );
				setup_postdata( $post );

				echo '<div class="kingster-profile-owned-course-list kingster-column-20 ';
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
				echo '</div>';
			}
			wp_reset_postdata();
			?>
        </ul>
		<?php $query->get_nav( '', true, $profile->get_current_url() ); ?>

	<?php } ?>
</div>
