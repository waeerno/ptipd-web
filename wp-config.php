<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ptipd' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0Hx%G))`.?QQ=[t-vdXhZvt9N~hh7f!zy)Gf&GVE:(E R@@s[Ts+-e{x5U}F2|+Q' );
define( 'SECURE_AUTH_KEY',  'Lw*AvjHu2o24>?uXjzNaSLInATUf&L)|9[5Ha%u/a<lESNlB6<cTZin/ej@vs`FA' );
define( 'LOGGED_IN_KEY',    ':tJZeKy5UOxh~=6*.`&savwC?#NQjF:L43t&kjn4{@J`Hss;;fNDkL.D96g3_-Iy' );
define( 'NONCE_KEY',        'LWv92tt_82>W+?bX9, cU<b-4d(!]PJb;VcJl`D}_;60WY{xx}1PqTqhv1MK{Hk@' );
define( 'AUTH_SALT',        'kE|BrRxUcCbTb.8Pa5{hM .vrm&c%f;vZ?1dTFY81_1@IrvZNwP<Q9la^)lYp2Mc' );
define( 'SECURE_AUTH_SALT', 'qMP)$*FX]rZG?dJxlpj)ntS0mO=[KMQ,)^vgBPVcXt(0P`|%p=0z*18ouQ,R}^KN' );
define( 'LOGGED_IN_SALT',   '0s?o1)<VOJ!PoT(qK5M5;`X6E]O(lU5muOS[xO<;.`;eMi)[]_QouLK),Rx/3:kd' );
define( 'NONCE_SALT',       'tq[$$!>A:HBk$D{uJ+,e^>`qhGE?T_xDt=&~W._-vE]U#;npBtc)qhpN8JZAKG6-' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'qwpo_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
