<?php
// calendar administrator (access to test scripts)
$rcmail_config['calendar_admin'] = 'admin@yunohost.org';

// temporary directory 
$rcmail_config['cal_tempdir'] = './plugins/calendar/temp/';

// caldav debug
$rcmail_config['caldav_debug'] = false;

// backend type (dummy, caldav)
// Note: "dummy" is only for demonstrating basic functionality.
$rcmail_config['backend'] = "caldav";

/* If you don't want that users are able to overwrite defaults, then add
   'backend' in main configuration file (./config/main.inc.php) to
   'dont_override' array:
   // don't allow these settings to be overriden by the user
   $rcmail_config['dont_override'] = array(
     'backend',
     //other protected values ...
   );
*/

/* Max CalDavs */
$rcmail_config['max_caldavs'] = 3;

/* Max Layers */
$rcmail_config['max_feeds'] = 3;

/* default CalDAV backend (null = no default settings)
   %u  will be replaced by $_SESSION['username']
   %gu will be replaced by google calendar user (requires google_contacts plugin)
   %p  will be replaced by Roundcube Login Password
   %gp will be replaced by google calendar password (requires google_contacts plugin)
   %c  will be replaced by the category a CalDAV is associated with
*/
   
$rcmail_config['default_caldav_backend'] = array(
  'user' => '%u',
  'pass' => '%p',
  'url' => 'https://sync.yunohost.org/%u/',
  'cat' => 'https://sync.yunohost.org/%u/',
  'auth' => 'basic',
  'extr' => false, // external reminder service (f.e. google calendar reminders)
);

/* CalDAV Replication
   fetch events (x) years in past and (y) years in future
*/
$rcmail_config['caldav_replication_range'] = array(
  'past'   => 1, // (x)
  'future' => 1, // (y)
);

/* Replicate CalDAV automatically after (x) seconds
   Recommended: 1800
   Never replicate automatically: false
*/
$rcmail_config['caldav_replicate_automatically'] = 1800;

/* Don't save passwords
   Notice: If enabled shared calendaring is limited if the user is on a CalDAV
           backend. The plugin will use the replicated local database without
           synch'ing.
*/
$rcmail_config['cal_dont_save_passwords'] = false;

/* Database table mapping */
// notice: leading underscore
$rcmail_config['backend_db_table_map'] = array(
  'dummy' => '', // no db table
  'database' => '', // default db table
  'caldav' => '_caldav', // caldav db table (= default db table) extended by _caldav
);

/* database table name (main table) */
$rcmail_config['db_table_events'] = 'events';
$rcmail_config['db_sequence_events'] = 'events_ids';

/* database table name (cache) */
$rcmail_config['db_table_events_cache'] = 'events_cache';
$rcmail_config['db_sequence_events_cache'] = 'events_cache_ids';

/* database table name reminders */
$rcmail_config['db_table_events_reminders'] = 'reminders';

/* fields where search is performed */
$rcmail_config['cal_searchset'] = array(
  'summary',
  'description',
  'location',
  'categories'
);

/* display upcoming calendar in mailbox view
   If enabled it is resource consuming on the client side!
*/
$rcmail_config['upcoming_cal'] = false;

/* preview next x days */
$rcmail_config['cal_previews'] = 5;

/* cron */
$rcmail_config['cron_log'] = true;
$rcmail_config['cron_smtp_user'] = 'dummy@mail4us.net'; //smtp user
$rcmail_config['cron_smtp_pass'] = 'pass'; //smtp password
$rcmail_config['cron_rc_url'] = 'http://where_is_roundcube/'; //trailing slash !!!
$rcmail_config['cron_ip'] = '127.0.0.1'; //please use real IP
$rcmail_config['cron_sender'] = 'noreply@mail4us.net';

/* link colors for jquery-ui accordions 
   set according to your css */
$rcmail_config['linkcolor'] = '#212121';
$rcmail_config['rgblinkcolor'] = 'rgb(33, 33, 33)';

// use jqueryui theme
$rcmail_config['ui_theme_main_cal'] = true; // true is recommended
$rcmail_config['ui_theme_upcoming_cal'] = false; // false is recommended

// possible values: 'mycalendar'   show only the user's calendar as default
//                  'allcalendars' show all layers as default
$rcmail_config['default_calendar'] = 'allcalendar';

// default calendar view (agendaDay, agendaWeek, month)
$rcmail_config['default_view'] = "month";

// timeslots per hour (1, 2, 3, 4, 6)
$rcmail_config['timeslots'] = '4';

// first day of the week (0-6)
$rcmail_config['first_day'] = '1';

// first hour of the calendar (0-23)
// -1: scroll to current time
//$rcmail_config['first_hour'] = -1;
$rcmail_config['first_hour'] = '7';

// default category
$rcmail_config['default_category'] = 'c0c0c0';

// default font color ('complementary' or 'blackwhite')
$rcmail_config['default_font_color'] = 'blackwhite';

// event categories (can be modified by user)
$rcmail_config['categories'] = array(
  'Personal' => '19F7FF', 
  'Work' => 'ff0000',
  'Family' => '00ff00',
  'Holiday' => 'ff6600',
);

// event preview category
$rcmail_config['categories_preview'] = array(
  'preview' => '75FF42',
  'occupied' => 'FF0000',
  'schedule' => '75FF42',
);

// public calendar categories (can't be modified by user)
$rcmail_config['public_categories'] = array(
  'Public' => 'ff6600',
);

// associated CalDAVs (can't be modified by user)
/* you can use here the same placeholders as in
   'default_caldav_backend' */
$rcmail_config['public_caldavs'] = array();
/*$rcmail_config['public_caldavs'] = array(
  'Public' => array(
                'user' => '%u',
                'pass' => '%p',
                'url' => 'https://mycaldav.mydomain.tld/%u/events/public',
                'auth' => 'basic',
                'readonly' => false,
                'extr' => false,
              ),
);*/

// work days (0 = Sunday)
$rcmail_config['workdays'] = array(1,2,3,4,5);

// default event duration in hours (e.g. 0.25, 0.50, 1.00, 1.50, 2.00 ...)
$rcmail_config['default_duration'] = '1.00'; 

// event feeds (can be deleted by user; use it for pre-settings)
$rcmail_config['calendarfeeds'] = array(
  'http://www.google.com/calendar/feeds/french__fr@holiday.calendar.google.com/public/basic' => 'Google',
  'http://www.google.com/calendar/feeds/usa__en@holiday.calendar.google.com/public/basic' => 'Google',
);

/* public feeds (can't be deleted by user; inject here feeds which all users should see)
   
   IMPORTANT: Do not link static feeds directly!
     (*) Reason: If you do so, it builds a cache on a per user level.
                 This makes no sense, if each user should see the same feed.
                 It is not only slow, it blows up your cache database table.
                 Conclusion: Link only dynamic feeds directly!
     (*) The better way:
         (**) Create a user who holds your static feeds, f.e. public_user@yourdomain.tld.
         (**) Login as 'public_user@yourdomain.tld.
         (**) Goto Settings -> Calendar and choose 'Default view' => 'All Calendars'
         (**) Goto Settings -> Calendar Feeds and enable ...
              ... 'Confidential feed access [read only]'
         (**) Copy the 'Feed URL' to clipboard.
         (**) Add this URL below and associate it with a category ...
              (***) Add a separator '|' followed by 'cache' to the category ...
              (***) If you want to inherit colorizing of 'public_user@yourdomain.tld,
                    then add a further separator '|' followed by 'inherit' to the
                    category.
              (***) Now the config entry should be something like:
              
              './?_task=dummy&_action=plugin.calendar_showlayer&_userid=123&_ct=4a923b22b6d9ce51c5966a09fb6ad889' => 'Holiday|cache|inherit'
         
         (**) Now add your static feeds to 'public_user@yourdomain.tld'.
         (**) Navigate to calendar and wait until it is loaded. Notice: you have always
              to load the calendar before you logout 'public_user@yourdomain.tld' to be
              sure that the cache is built and up to date.
         (**) Now you are done!
         (**) If you make changes to your static feeds, login as 'public_user@yourdomain.tld'
              and wait until the calendar is loaded.
     (*) Notice: To be able to search events in feeds, the host of the webmail must be same as the host of the feed.
                 F.e.: http://www.mydomain.tld (webmail) is not the same as http://mydomain.tld/?_task=... (feed url).
                 Details: http://code.google.com/p/myroundcube/issues/detail?id=239

*/

$rcmail_config['public_calendarfeeds'] = array();

?>
