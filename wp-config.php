<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_nxt' );

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
define( 'AUTH_KEY',         '[wlm<H[~]p#hy1*&6 ,lZl,~6i<6q!PlqT:L`3]:0*<f-y+)Sw;bPTB?6:3LW*1Z' );
define( 'SECURE_AUTH_KEY',  'i=^A-iGL^5vF.,;CV7JfBOJ2>W^QF`?(_V+)J?Yv(H%LevcWo-?s*T)rG?ZT?i?@' );
define( 'LOGGED_IN_KEY',    'fdtUfuOK1; |+_ji?CgX)NB;9-j=PTHz%K32%N[{89Wg:[.6.BS9}>Xb:LPu0M;9' );
define( 'NONCE_KEY',        'ZYVQFx}}%|?r(+DM~lQ&MBu6w+?yzd8bqJB]tA}-]MIB.y=bO6Ct$l4u p^Bfjfr' );
define( 'AUTH_SALT',        '<urYu[%6rNX^b+<-G=kS0T[#52Fy+m&{<$plWBpF-!j9NT`&Xwc^8i|Yu.=)(PG1' );
define( 'SECURE_AUTH_SALT', 'mlIqJ^ntciEA$nBnj EN<U(a;==mG/{}){vqB9kbe/=sv#nPn*l^*MFd]Eb@mv m' );
define( 'LOGGED_IN_SALT',   '.)]^L67-`vud.sg`eW4uZ.,_hY@kP`#<f0%=)nE4TG@xgTi[Wb?Zrn3zKP0^vZ^c' );
define( 'NONCE_SALT',       '.Kxp^?_xxVz@K{[d%wqi&B^w`Y#`Z%P_oUwen~5Q.}Gg?F?F~-D9+v%!G>tHXjtb' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
