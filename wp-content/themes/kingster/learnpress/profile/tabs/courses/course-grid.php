<?php
/**
 * Template for displaying own courses in courses tab of user profile page.
 * Edit by Nhamdv
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.10
 */

defined( 'ABSPATH' ) || exit();
?>

<?php if ( $current_page === 1 ) : ?>
<div class="lp-archive-courses">
<ul <?php lp_item_course_class( array( 'profile-courses-list' ) ); ?> data-layout="grid" data-size="3">
<?php endif; ?>

	<?php
	global $post;

	$course_style = new kingster_lp_course_style();
	$count = 0;
	foreach ( $course_ids as $id ) { $count++;
		$course = learn_press_get_course( $id );
		$post   = get_post( $id );
		setup_postdata( $post );

		echo '<div class="kingster-profile-owned-course-list kingster-column-20 ';
		if($count % 3 == 1){
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
		echo '</div>';
	}

	wp_reset_postdata();
	?>

<?php if ( $current_page === 1 ) : ?>
</ul>
</div>
<?php endif; ?>

<?php if ( $num_pages > 1 && $current_page < $num_pages && $current_page === 1 ) : ?>
	<div class="lp_profile_course_progress__nav">
		<button data-paged="<?php echo absint( $current_page + 1 ); ?>" data-number="<?php echo absint( $num_pages ); ?>"><?php esc_html_e( 'View more', 'learnpress' ); ?></button>
	</div>
<?php endif; ?>
