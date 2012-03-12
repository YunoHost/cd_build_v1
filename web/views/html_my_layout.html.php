<html>
<head>
    <title>Limonade first example</title>
</head>
<body>
  <h1>Limonade first example</h1>
    <?php echo $content?>
    <hr>
    <a href="<?php echo url_for('/')?>">Home</a> |
    <a href="<?php echo url_for('/hello/', $name)?>">Hello</a> | 
    <a href="<?php echo url_for('/welcome/', $name)?>">Welcome !</a> | 
    <a href="<?php echo url_for('/are_you_ok/', $name)?>">Are you ok ?</a> | 
    <a href="<?php echo url_for('/how_are_you/', $name)?>">How are you ?</a>
</body>
</html>