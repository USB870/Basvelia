<?php
session_set_cookie_params(60 * 24 * 60 * 60);
session_start();
include "config.php";
session_unset();
session_destroy();
header("location: index.php");
?>