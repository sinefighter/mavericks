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
define( 'DB_NAME', 'mawericks' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'D1F<O/s*j&2L4t(@0y}vAG9cv9Bf!d~aS=K.LQJpTQM/Qt=R9>%VEf)gM&Uu jEw' );
define( 'SECURE_AUTH_KEY',  's)|(Ca_VFxG#$kWA*ptr#8s @TtMPUKAdy65.;aQ!pG?J5%2klJfC#/{q*h_&6-y' );
define( 'LOGGED_IN_KEY',    'xIoK/+r_IcX>R|LkS#1-eFl?/%NQR9+W<]e43kM!}A3vAI!G~<{QKOnu6if+du3-' );
define( 'NONCE_KEY',        'm~|ojqMB`MLP_Pv[g{{>1_)>0O*@|%>fz2HOoEZE MJ9h&by(d;M}IZ5Ez,TAPUu' );
define( 'AUTH_SALT',        '&-j/W%ZL0ZK]3/.G0us7[=bm2<~z:*Xcq.y+cz`Nfw4EsV&S;,,Xa2HBN`-5}8aL' );
define( 'SECURE_AUTH_SALT', 's.o~M|4iy_5ygjQ.g8-`niyO_B:|c*TBt.J_x7U|agtR?=qd7U1*5Rn*:A77,9}Y' );
define( 'LOGGED_IN_SALT',   'A(dk5=~TR?ZlO1AveG|Yg4+<ZtB%7Y#5HWt$*]M6&Q_=,1g+`dyQ.j9{mW&AI(kw' );
define( 'NONCE_SALT',       '(fW*b/TzV<%H;6(6[7X@f:=b#g9b|3ZAp>9[iHmBFweFFMfD;!C]Qhz#wfiFPL)G' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
