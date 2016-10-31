<?php
	require("core/class.php");
	$currentUrl = explode('/', $_SERVER['REQUEST_URI']);


	echo $user; // **echo's 100**

	PageBuilder::moviePage($currentUrl[1]);

?>