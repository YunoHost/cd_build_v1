<h3>List</h3>

<ul>
	<?php foreach ($results as $user) { ?>
		<li> <?php echo $user['cn'][0]; ?> </li>
	<?php } ?>
</ul>