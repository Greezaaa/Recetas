<?php

session_start();
require_once "config/function.php";
require_once "config/config.php";
$page = $t["config"]["page_404"];
include_once("inc/header.php");

 echo "<h2 style='text-align: center; max-width: 50%; margin: auto; background-color: rgb(255 0 0 / 12%); padding: 1rem'>404 PAGE.... LINK NOT FOUND!</h2>";



include_once("inc/footer.php");