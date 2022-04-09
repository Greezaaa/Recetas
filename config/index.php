<?php
session_start();
include_once "../config/config.php";
include_once "../config/function.php";
//revisamos si usuario esta logeado
//queda por añadir condicion de rol de usuario
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_not_logged"];
    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}