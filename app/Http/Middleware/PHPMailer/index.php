<?php namespace skunks;
$goTo="{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}/logout.php";
header("location:$$goTo",301);
exit();
