<?php
session_start();
require_once("../config/function.php");

unset($_SESSION["user_name"]);
unset($_SESSION["user_email"]);
unset($_SESSION['user_status']);
unset($_SESSION["user_rol"]);
unset($_SESSION["user_id"]);
$_SESSION["loggedin"] = false;
$_SESSION["msg_type"] = "warning";
$_SESSION["msg_text"] = $t["msg"]["msg_loggedOut_suc"];
//redireccion a pagina de inicio
header("Location: ../index.php");
exit;