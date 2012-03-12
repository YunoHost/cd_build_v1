<?php

/* lougout_redirect plugin */

/*
There are three modes:
#1 - Ajax login
     See example in ajax_login folder.
     Set login / logout to false.
     It will detect if you logged in
     from an outside form and the force
     the redirect to the given URL.
     Login and logout page are accessible.
     
#2 - Lock login page
     Set login to true.
     It will redirect the login page
     to the given URL in any case.
     
#3 - Lock logout page
     Set logout to true.
     It will redirect the logout page
     to the given URL in any case.
*/

/*
  e.g. http://mail4us.net/logout.php?domain=%d&user=%n
  the following two placeholders will be replaced in the redirect_url
  %d ~ users domain part
  %n ~ name part
*/
$rcmail_config['logout_redirect_url'] = 'https://auth.yunohost.org/index.pl?logout=1';

/* HTTP Referer
   null -> no check
   Url  -> check */
$rcmail_config['logout_redirect_referer'] = 'https://webmail.yunohost.org';

/* lock default login page */
$rcmail_config['logout_redirect_lock_default_login'] = false;

/* lock default logout page */
$rcmail_config['logout_redirect_lock_default_logout'] = true;

?>
