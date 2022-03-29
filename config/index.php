<?php
session_start();
$_SESSION["msg_type"] = $t["msg_type_dan"];
$_SESSION["msg_text"] = $t["msg"]["msg_cat_add_error"];
 header("Location: ../index.php");