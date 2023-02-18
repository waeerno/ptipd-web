<?php
/**
 * Template for displaying course rate.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/addons/course-review/course-rate.php.
 *
 * @author ThimPress
 * @package LearnPress/Course-Review/Templates
 * version  3.0.1
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

$course_id       = get_the_ID();
$course_rate_res = learn_press_get_course_rate( $course_id, false );
$course_rate     = $course_rate_res['rated'];
$total           = $course_rate_res['total'];
?>

<div class="course-rate-wrap clearfix">
	<?php
		$percent = ( ! $course_rate ) ? 0 : min( 100, ( round( $course_rate * 2 ) / 2 ) * 20 );
		$title   = sprintf( __( '%s out of 5 stars', 'learnpress-course-review' ), $course_rate );
	?>
	<?php do_action( 'learn_press_before_total_review_number' ); ?>
	<div class="kingster-course-rating-summary" >
		<div class="kingster-course-rating-summary-amount" >
			<?php printf('%1.2f', $course_rate ); ?>
		</div>
		<div class="review-stars-rated" title="<?php echo esc_attr( $title ); ?>">
		    <div class="review-stars empty"></div>
		    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
		</div>
		<div class="kingster-course-rating-summary-number" >
			<?php printf( _n( ' %d rating', '%d ratings', $total, 'learnpress-course-review' ), $total ); ?>
		</div>
	</div>
	<?php do_action( 'learn_press_after_total_review_number' ); ?>
    <div class="kingster-course-rating-content" >
		<?php
		if ( isset( $course_rate_res['items'] ) && ! empty( $course_rate_res['items'] ) ):
			foreach ( $course_rate_res['items'] as $item ):
				?>
                <div class="course-rate">
                    <div class="review-bar">
                        <div class="rating" style="width:<?php echo $item['percent']; ?>% "></div>
                    </div>
                    <?php $percent = ( ! $item['rated'] ) ? 0 : min( 100, ( round( $item['rated'] * 2 ) / 2 ) * 20 ); ?>
                    <div class="review-stars-rated" >
					    <div class="review-stars empty"></div>
					    <div class="review-stars filled" style="width:<?php echo $percent; ?>%;"></div>
					</div>
                    <span><?php echo esc_html($item['total']) . ' (' . esc_html($item['percent']) . '%)'; ?></span>
                </div>
			<?php
			endforeach;
		endif;
		?>
    </div>
</div>
