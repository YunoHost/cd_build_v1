<?php 

function hello_world()
  {
    return "yayaya";
  }

function welcome()
  {
    set_or_default('name', params('name'), "everybody");    
    return render("html_welcome.html.php");
  }

function listUser()
  {
    global $config;
    $results = $config['ldap']->search('ou=users'. $config['host'], 'cn=*', array("mail", "uid", "cn"));
    set_or_default('results', $results, "yayaya");    
    return render("list.html.php");
  }

function addUserForm () {
    return render("addUserForm.html.php");
  }

function addUserPost () {
    global $config;
    $name = htmlspecialchars($_POST["prenom"]);
    if ($config['ldap']->add('ou=users,dc=test,dc=yunohost,dc=org', 'qsbessfbebe', 'ddss')) {
      set('name', 'yayaya');
      //flash('success', true);
      redirect_to('/list');
    } else {
      return 'yayaya';
    }
  }

function are_you_ok($name = null)
  {
    if(is_null($name))
    {
      $name = params('name');
      if(empty($name)) halt(NOT_FOUND, "Undefined name.");

    }
    set('name', $name);
    return html("Are you ok $name ?");
  }

  function how_are_you()
  {
    $name = params('name');
    if(empty($name)) halt(NOT_FOUND, "Undefined name.");
    # you can call an other controller function if you want
    if(strlen($name) < 4) return are_you_ok($name);
    set('name', $name);
    return html("I hope you are fine, $name.");
  }

  function image_show()
  {
    $ext = file_extension(params('name'));
    $filename = option('public_dir').basename(params('name'), ".$ext");
    if(params('size') == 'thumb') $filename .= ".thb";
    $filename .= '.jpg';
    
    if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
    render_file($filename);
  }

   function image_show_jpeg_only()
  {
    $ext = file_extension(params(0));
    $filename = option('public_dir').params(0);
    if(params('size') == 'thumb') $filename .= ".thb";
    $filename .= '.jpg';
  
    if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
    render_file($filename);
  }