<?php

require_once dirname(__FILE__).'/vendor/limonade.php';
require_once dirname(__FILE__).'/vendor/ldap.php';

$config['ldap'] = new Contacts();
$config['ldapDomain'] = 'localhost';

// admin.mydomain.fr > .mydomain.fr > ,dc=mydomain,dc=fr
$config['host'] = strtr(substr($_SERVER['HTTP_HOST'], strpos($_SERVER['HTTP_HOST'], '.')), array('.' => ',dc='));

function configure()
{
  //option('env', ENV_DEVELOPMENT);
  option('debug', true);
  option('base_uri', '/');
  //option('controllers_dir', dirname(__FILE__).'/controllers');
  //option('views_dir', dirname(__FILE__).'/views');
}

function before($route)
{
  global $config;

  function authenticate() {
    header('WWW-Authenticate: Basic realm="Restricted administration"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'You must identify yourself to access to this page.';
    exit;
  }

  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    authenticate();
  } else {
    if ($config['ldap']->connect(
        $config['ldapDomain'],
        'cn='.$_SERVER['PHP_AUTH_USER'].$config['host'],
        $_SERVER['PHP_AUTH_PW'])) 
        {
        //eader("X-LIM-route-function: ".$route['function']);
        header("X-LIM-route-params: ".json_encode($route['params']));
        header("X-LIM-route-options: ".json_encode($route['options']));
        layout("layout.html.php");
        error_layout("layout.html.php");
    } else {
      authenticate();
    }
  }
}

dispatch('/', 'hello_world');
  

dispatch('/hello/:who', 'hello');
  
dispatch('/welcome/:name', 'welcome');
  

dispatch('/list', 'listUser');
 
dispatch('/add', 'addUserForm');

dispatch_post('/add', 'addUserPost');
  

dispatch('/are_you_ok/:name', 'are_you_ok');
  
    
dispatch('/how_are_you/:name', 'how_are_you');
  
  
dispatch('/images/:name/:size', 'image_show');
  

dispatch('/*.jpg/:size', 'image_show_jpeg_only');
 

function after($output, $route)
{
  $time = number_format( (float)substr(microtime(), 0, 10) - LIM_START_MICROTIME, 6);
  $output .= "\n<!-- page rendered in $time sec., on ".date(DATE_RFC822)." -->\n";
  $output .= "<!-- for route\n";
  $output .= print_r($route, true);
  $output .= "-->";
  return $output;
}


run();

# HTML Layouts and templates

//function html_my_layout($vars){ extract($vars);

//function html_welcome($vars){ extract($vars);
