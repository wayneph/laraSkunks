<?php
$prefix="http://";
if (substr($_SERVER['SERVER_PROTOCOL'], 0, 5)=="HTTPS") {
    $prefix="https://";
}
$go_to="$prefix{$_SERVER['HTTP_HOST']}/index.php";
header("location:$go_to");
