<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '557taoyuan');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ',.yKpN7-R3&36ZClojOcX]%eM]*f,~+NC2`Wl->tu69hbGm7.:LW|stplTwFj^Wo');
define('SECURE_AUTH_KEY',  'AXC!fZv4=s8%L33s$GO,-H$:]ie&5)]9$&/NKO5` L/%uO;Qr(JuqM?P}$?!{u3|');
define('LOGGED_IN_KEY',    'J@ DD6gW@P;334OZz!LaxnUEVrA_6zG+]{rh5P:uE,57@4oe$9z]]~-y>Eq^c!$[');
define('NONCE_KEY',        '(-<BG1p/U8(i f(QYmrk76ziM`^S~jsj;#0]p_Z#9<TGvT?g#%NuIL_fP4o74=^)');
define('AUTH_SALT',        '>(:+Y#jpy8Wk;RXWYYCrQY-U/)Ovru<Tnzt7}]N@fv8YU`D7?YV0s+}P.}Ax2A9e');
define('SECURE_AUTH_SALT', ')j4qSGrKxk&Wh22u!4{gxn;_^8N,^)/bF`v/q?M5{-.hK$>#Q(Yh5<jL^%E=xxhd');
define('LOGGED_IN_SALT',   '&ZS^mMDOU5[`nfFsry8K?(4B-|0aWuf/ nJ0xKIClE;<4^EUX}$7BCd&u!()G(yw');
define('NONCE_SALT',       ';5wN+X:G;)8T)F6Amdq{[_;je`>K+Gd{@d(QjLn`HFSW*]MC+3+Jw6EuU7w!}YaW');
define('WPLANG', 'zh_CN');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
