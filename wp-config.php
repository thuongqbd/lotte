<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'lotte');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '0,fD[7a;]t^+#|`A>%FP13_t7#{^&4@|2a8W`K&80BVjd 0okO{+*8qecwFc-0kq');
define('SECURE_AUTH_KEY',  'WH(JmUXo,a:^)^tO=i$>+RXg@?[)8j9#dGNS3_/c6} ~o.AM-|AiW5$-m>Vj?O-l');
define('LOGGED_IN_KEY',    '3J@vOYm?-dH ?cL6APZW>A@e!)4[Z_0/W%OntQRVGjI&aF=HR;-^ ?L[bdM,$a6s');
define('NONCE_KEY',        '~A^DLLEO2|bB=3o4-NL^k_YNt}raYR6_Xq}+5dfLM8!#hE&KnE/uYL+Lf|V5nv<k');
define('AUTH_SALT',        '}g9JJTrF+MA?olP]*pDxrzvlSP;j!!dB9YLshU4c_`GtaHQON^ik:-kT;5ymXlM.');
define('SECURE_AUTH_SALT', '@62qc$3#_L;boqp7:9x|q&BYvFexlm:6071rRwak{CX3Y6 TJGk0=EOeLfui%Sb ');
define('LOGGED_IN_SALT',   'n[-mEw]=)Rm9vpX3A+%#D3Hc~1> w[{=NcwI>9*D;lnsFgys0<K+/-)K5sT!ldvV');
define('NONCE_SALT',       'M8Hv5ug3e:45R+SRVXNT2eg&`-H}shitcS>K=Z{FwX;XuAm<tP.Id-NYbV}~Ix(q');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');