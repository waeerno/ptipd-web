<?php
/**
 * Template for displaying user profile cover image.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/profile/profile-cover.php.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

$user = $profile->get_user();
?>

<div id="learn-press-profile-header" class="lp-profile-header">
    <div class="lp-profile-cover">
        <div class="lp-profile-avatar">
			<?php echo $user->get_profile_picture('', 120); ?>
        </div>
        <div class="kingster-learn-press-profile-cover-content" >
            <span class="profile-name"><?php echo $user->get_display_name(); ?></span>
            <span class="profile-email"><?php echo $user->get_email(); ?></span>
        </div>
    </div>
</div>


