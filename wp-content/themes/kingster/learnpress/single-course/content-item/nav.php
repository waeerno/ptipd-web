<?php
/**
 * Template for displaying next/prev item in course.
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 4.0.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $prev_item ) && ! isset( $next_item ) ) {
    return;
}

if ( $prev_item && $next_item ) {
    $nav = 'all';
} elseif ( $prev_item ) {
    $nav = 'prev';
} else {
    $nav = 'next';
}
?>

<div class="course-item-nav" data-nav="<?php echo esc_attr( $nav ); ?>" >
    <?php if ( $prev_item ) { ?>
        <div class="prev">
            <a class="kingster-nav" href="<?php echo esc_attr($prev_item->get_permalink()); ?>"><?php echo esc_html_x( 'Prev', 'course-item-navigation', 'kingster' ); ?></a>
            <a class="kingster-nav-title" href="<?php echo esc_attr($prev_item->get_permalink()); ?>">
                <?php echo gdlr_core_text_filter($prev_item->get_title()); ?>
            </a>
        </div>
    <?php } ?>

    <?php if ( $next_item ) { ?>
        <div class="next">
            <a class="kingster-nav" href="<?php echo esc_attr($next_item->get_permalink()); ?>"><?php echo esc_html_x( 'Next', 'course-item-navigation', 'kingster' ); ?></a>
            <a class="kingster-nav-title" href="<?php echo esc_attr($next_item->get_permalink()); ?>">
                <?php echo gdlr_core_text_filter($next_item->get_title()); ?>
            </a>
        </div>
    <?php } ?>
</div>


