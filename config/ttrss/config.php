<?php
	// *******************************************
	// *** Database configuration (important!) ***
	// *******************************************

	define('DB_TYPE', "mysql"); // or mysql
	define('DB_HOST', "localhost");
	define('DB_USER', "ttrss");
	define('DB_NAME', "ttrss");
	define('DB_PASS', "passmysql");
	//define('DB_PORT', '5432'); // when neeeded, PG-only

	define('MYSQL_CHARSET', 'UTF8');
	// Connection charset for MySQL. If you have a legacy database and/or experience
	// garbage unicode characters with this option, try setting it to a blank string.

	// ***********************************
	// *** Basic settings (important!) ***
	// ***********************************

	define('SELF_URL_PATH', 'https://rss.yunohost.org');
	// Full URL of your tt-rss installation. This should be set to the
	// location of tt-rss directory, e.g. http://yourserver/tt-rss/
	// You need to set this option correctly otherwise several features
	// including PUSH, bookmarklets and browser integration will not work properly.

	define('SINGLE_USER_MODE', false);
	// Operate in single user mode, disables all functionality related to
	// multiple users.

	// *****************************
	// *** Files and directories ***
	// *****************************

	define('PHP_EXECUTABLE', '/usr/bin/php');
	// Path to PHP executable, used for various command-line tt-rss programs

	define('LOCK_DIRECTORY', 'lock');
	// Directory for lockfiles, must be writable to the user you run
	// daemon process or cronjobs under.

	define('CACHE_DIR', 'cache');
	// Local cache directory for RSS feed content.

	define('ICONS_DIR', "feed-icons");
	define('ICONS_URL', "feed-icons");
	// Local and URL path to the directory, where feed favicons are stored.
	// Unless you really know what you're doing, please keep those relative
	// to tt-rss main directory.

	// *********************
	// *** Feed settings ***
	// *********************

	define('DEFAULT_UPDATE_METHOD', 0);
	// Which feed parsing library to use as default:
	// 0 - Magpie
	// 1 - SimplePie

	define('FORCE_ARTICLE_PURGE', 0);
	// When this option is not 0, users ability to control feed purging
	// intervals is disabled and all articles (which are not starred) 
	// older than this amount of days are purged.

	// *** PubSubHubbub settings ***

	define('PUBSUBHUBBUB_HUB', '');
	// URL to a PubSubHubbub-compatible hub server. If defined, "Published
	// articles" generated feed would automatically become PUSH-enabled.

	define('PUBSUBHUBBUB_ENABLED', false);
	// Enable client PubSubHubbub support in tt-rss. When disabled, tt-rss
	// won't try to subscribe to PUSH feed updates.

	// *********************
	// *** Sphinx search ***
	// *********************

	define('SPHINX_ENABLED', false);
	// Enable fulltext search using Sphinx (http://www.sphinxsearch.com)
	// Please see http://tt-rss.org/wiki/SphinxSearch for more information.

	define('SPHINX_INDEX', 'ttrss');
	// Index name in Sphinx configuration. You can specify multiple indexes
	// as a comma-separated string.

	// **********************
	// *** Authentication ***
	// **********************

	define('ALLOW_REMOTE_USER_AUTH', true);
	// Set to 'true' if you trust your web server's REMOTE_USER 
	// environment variable that the user is logged in. This option can be 
	// used to integrate tt-rss with Apache's external authentication modules.

	define('AUTO_LOGIN', true);
	// Set this to true if you use ALLOW_REMOTE_USER_AUTH or client SSL
	// certificate authentication and you want to skip the login form. 
	// If set to true, users won't be able to set application language 
	// and settings profile.
	// Otherwise users will be redirected to login form with their login
	// information pre-filled.

	define('AUTO_CREATE_USER', true);
	// If users are authenticated by your web server, set this to true if
	// You want new users to be automaticaly created in tt-rss database
	// on first login

	// ***********************************
	// *** Self-registrations by users ***
	// ***********************************

	define('ENABLE_REGISTRATION', false);
	// Allow users to register themselves. Please be vary that allowing
	// random people to access your tt-rss installation is a security risk
	// and potentially might lead to data loss or server exploit. Disabled
	// by default.

	define('REG_NOTIFY_ADDRESS', 'user@your.domain.dom');
	// Email address to send new user notifications to.

	define('REG_MAX_USERS', 10);
	// Maximum amount of users which will be allowed to register on this
	// system. 0 - no limit.

	// **********************************
	// *** Cookies and login sessions ***
	// **********************************
	
	define('SESSION_COOKIE_LIFETIME', 0);
	// Default lifetime of a session (e.g. login) cookie. In seconds, 
	// 0 means cookie will be deleted when browser closes.

	define('SESSION_EXPIRE_TIME', 86400);
	// Hard expiration limit for sessions. Should be
	// greater or equal to SESSION_COOKIE_LIFETIME

	define('SESSION_CHECK_ADDRESS', 1);
	// Check client IP address when validating session:
	// 0 - disable checking
	// 1 - check first 3 octets of an address (recommended)
	// 2 - check first 2 octets of an address
	// 3 - check entire address

	// *********************************
	// *** Email and digest settings ***
	// *********************************

	define('SMTP_FROM_NAME', 'Tiny Tiny RSS');
	define('SMTP_FROM_ADDRESS', 'noreply@your.domain.dom');
	// Name, address and subject for sending outgoing mail. This applies
	// to password reset notifications, digest emails and any other mail.

	define('DIGEST_SUBJECT', '[tt-rss] New headlines for last 24 hours');
	// Subject line for email digests

	define('SMTP_HOST', '');
	// SMTP Host to send outgoing mail. Blank - use system MTA.

	define('SMTP_LOGIN', '');
	define('SMTP_PASSWORD', '');
	// These two options enable SMTP authentication when sending
	// outgoing mail. Only used with SMTP_HOST

	// ************************************
	// *** Twitter integration settings ***
	// ************************************
	
	define('CONSUMER_KEY', '');
	define('CONSUMER_SECRET', '');
	// Your OAuth instance authentication information for Twitter, visit
	// http://twitter.com/oauth_clients to register your instance.

	// ***************************************
	// *** Other settings (less important) ***
	// ***************************************

	define('CHECK_FOR_NEW_VERSION', true);
	// Check for new versions of tt-rss automatically.

	define('COUNTERS_MAX_AGE', 365);
	// Hard limit for unread counters calculation. Try tweaking this
	// parameter to speed up tt-rss when having a huge number of articles
	// in the database (better yet, enable purging!)

	define('ENABLE_GZIP_OUTPUT', false);
	// Selectively gzip output to improve wire performance. This requires
	// PHP Zlib extension on the server.

	define('FEEDBACK_URL', '');
	// Displays an URL for users to provide feedback or comments regarding
	// this instance of tt-rss. Can lead to a forum, contact email, etc.

	define('ARTICLE_BUTTON_PLUGINS', 'note,tweet,share,mail');
	// Comma-separated list of additional article action button plugins
	// to enable, like tweet button, etc.
	// The following plugins are available: note, tweet, share, mail
	// More plugins: http://tt-rss.org/wiki/Plugins

	define('CONFIG_VERSION', 25);
	// Expected config version. Please update this option in config.php
	// if necessary (after migrating all new options from this file).

	// vim:ft=php
?>
