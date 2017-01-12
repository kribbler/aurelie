<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'database');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('WP_MEMORY_LIMIT', '96M');
define('WP_MAX_MEMORY_LIMIT', '256M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3C6/Qduc6Y@+>BIs8W[f~P+@<EBi;rPYZ9>^:7;E{5dX$-+<Z79QBPv,wqsDk.t1');
define('SECURE_AUTH_KEY',  'TSd+U,@O!|7VJN=E~Ftmk-6+|e^x@H3!W&u{E(-euXX`zYi)Bh&szWO*B$dyIc?e');
define('LOGGED_IN_KEY',    'Y!8vrLee|(-3RYdv.ZSi%<kXN!S-td6^0fUi|ZRX_w@?SquhgrQJ+m0*^!]A`4N#');
define('NONCE_KEY',        'cE)|&|J4=|rWOV9`M]80F}_?L=tN}^>{H(:x9L:R|f9_~lJd-!sy6<uqpteo!{O[');
define('AUTH_SALT',        'z/m!RqDF MGvI7-[g2,+dVbFL]X*/i!`7LlUeTeLjvg-;_XUiBTJ lL9oL16T%$i');
define('SECURE_AUTH_SALT', 'g kfUQV%:^0r]16v]ZgnyA$uyNNls:!p[|;,Jq9r|YnMmNYO*${FdI9ha.F+cT^0');
define('LOGGED_IN_SALT',   'nz+gH+ 5z-#jqK6G:ua=c_,Chi#s(V-+h/a~tK#/N^9RI#)1xO|a/zGb[{`&GPVq');
define('NONCE_SALT',       'jBe}n|p-U+_.dJiE2u|IXtWU9ZBX6FQS 3wPUBN[_A8xALY}b.]K@WXEb R)/~QH');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */

if ($_SERVER['REMOTE_ADDR'] == '::1'){
	define('WPLANG', 'en_US');
} else {
	define('WPLANG', 'nb_NO');
}

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163x'){
	define('WP_DEBUG', true);
} else {
	define('WP_DEBUG', false);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
