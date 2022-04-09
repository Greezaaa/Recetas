<?php
session_start();
if (isset($_GET['l'])) {
    $_SESSION['lang'] = $_GET['l'] ?? 'es'; ?>
<script>
document.location.replace(document.referrer)
</script>
<?php
} else {
        header("Location: ../index.php");
    }

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        $_SESSION['msg_type'] = $t["msg_type_dan"];
        $_SESSION['msg_text'] = $t["msg"]["msg_not_logged"];
        header("Location: ../index.php");
        exit;
    } else {
        header("Location: ../index.php");
        exit;
    }
?>