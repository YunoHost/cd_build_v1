<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php $user = $_SERVER["PHP_AUTH_USER"];?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"> 
<head> 
	<title>Beudibox - Accueil</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <link rel="stylesheet" type="text/css" href="home.css" media="screen" /> 
	<base target="content">

</head> 
<body id="home"> 
<div id="top"> 
<div id="menu"> 	
<ul class="menu_right">
			<table><tr>
		        <td><img src="logo.png"></td>
			<td><li class="admin"><a href="https://www.test.yunohost.org/">Accueil</a></li></td>
			<td><li class="webmail"><a href="https://webmail.test.yunohost.org/">Webmail</a></li></td> 
			<td><li class="chat"><a href="https://im.test.yunohost.org/">Chat</a><li></td>
			<td><li class="status"><a href="https://rss.test.yunohost.org/">RSS</a><li></td> 
		
			<?php
			if ($user == useradmin) {
			echo '<td><li class="webmail"><a href="admin.test.yunohost.org">Administration</a><li></td>';
			};
			?>

		 	<td><a href="https://auth.test.yunohost.org/index.pl?logout=1" target="_top">Déconnecter</a></td>

</ul>

<div class="clearer"></div>
</div><!-- menu --> 
</body>
</html>

