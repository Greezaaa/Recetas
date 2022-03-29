<?php

echo "<pre>";
var_dump($_SESSION) ;
echo "</pre>";


//session msg
function sessionMSG()
{
    if (isset($_SESSION["msg_text"])) {
        echo '<div id="msg-alert" class="alert-msg '.$_SESSION["msg_type"].'"><span>' . $_SESSION["msg_text"] . '</span><span
        class="close-btn '.$_SESSION["msg_type"].'">&times;</span></div>';
    }
    unset($_SESSION['msg_text']);
    unset($_SESSION['msg_type']);
}
 sessionMSG();
 ?>
<footer>
    #footer Loaded
</footer>

</body>

</html>