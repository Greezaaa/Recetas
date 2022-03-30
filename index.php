<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "config/function.php";
require_once "config/config.php";
$page = $t["config"]["page_home"];
include_once("inc/header.php");
include_once "recetas.php";
include_once("inc/footer.php");