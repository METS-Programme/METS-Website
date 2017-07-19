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
define('DB_NAME', 'mets_website2017');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'METSUganda321');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '1`hT#/QV#A{BSC`loaO{]&frAg=:i4BA&x9,9D:lZ,]l8m1R]e9L*pXHk8rYfa2:');
define('SECURE_AUTH_KEY',  'z!*-qE}JJ-vW.JER/]k9WVlu[*&oxIym!<+p b2Z/G<oC4kAN *V8|i/`vP} b;Y');
define('LOGGED_IN_KEY',    '#)~_G[b}pJ^N`c}+kDi=lEVsd:3sq@$E0imsqz[B^})u6gk9FH)/VYzV~iHI`B78');
define('NONCE_KEY',        'x!#zU~}VYA82oZUs+.~zDGz4w{*oPDCp6?jz1?,s6Xc}LaQHFAIv}sUeoP_%k*.f');
define('AUTH_SALT',        'wv`Xt9P9&wd-fqc@y~O<X1a+eGy$++UIFq,554j2c!)a=D^!]oL*,es%]NJm#qD?');
define('SECURE_AUTH_SALT', 'Th)vRjtN +o tc4_abTr;KdEH-e]wjibf-DfR-gV#3?,1>R]x^Y&9t^0mtZb}o1Q');
define('LOGGED_IN_SALT',   '3`Bu-q([<j,._XAS`|0wpevZGk_E?(`O$wQ| {1G<x-%<9bxS0Fm]!@c!s5z{-kR');
define('NONCE_SALT',       'mV<5cBCDl3k0k;w#7n$3F~u._(69(-gF}nS^4^b2]mP0@A9|G^][CulR.#hAxgmI');

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
