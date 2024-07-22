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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', '' );

/** Database username */
define( 'DB_USER', '' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '' );

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
define( 'AUTH_KEY',         'F|4&M|%QfMp<m9iJ}]UFSvQ_bJpQ+r,sI|3O`X[ {#5Nc|%at<g@N<aqY8hIz5_Y' );
define( 'SECURE_AUTH_KEY',  'bN0)1R0OTFF{}zG&)os:.F6=W!3>2Dan]ah**d^|YZ1sw$apaZV=Jw7_#CEv`GD7' );
define( 'LOGGED_IN_KEY',    'NW|4WW(es2we,6-1}46=,$qNHMz&DsEDsX$jde<JZMh{INBs((+RanfFt$pKP.tj' );
define( 'NONCE_KEY',        '-BE)c/kFJrznvo1+zE+fDl4`(w]glVWUGrgBc{#6#Bn%+Ej%{vOs%@6:.~_n/wVc' );
define( 'AUTH_SALT',        'gL)#MUNGJ|)<lj/>KeQRj|Y J,rhd[?:];RDSnC<%_*bThP8El^G*Aj7+3.Wg#]%' );
define( 'SECURE_AUTH_SALT', '<%p $@WVI6ZOTJYHlh %m;DNwHu/FVBEFA$CB[0sI8KdsQ&hW8BG~/?{d2~)e@h7' );
define( 'LOGGED_IN_SALT',   '6*(~3?#B&S.;|32~MF?tqQNpeBo4B@)z#3]k|@Cg*Q3@w1.LA5Trt]<D*E=SD{mm' );
define( 'NONCE_SALT',       'l6>BmR*un#g`FH.ikjnH}!j}-=z!K=6M[6}5Urh#8NLQ5N?5@@BM@Er@731C8Y0J' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'uc_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
