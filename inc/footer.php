<?php

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
</main>
<footer>

    <span>
        <center>
            Creado por <a style="color: #f2f2f2; text-decoration: none;" href="https://yellowcoffeecup.com"
                title="Yellow Coffee Cup | Coffee and Code"> Yellow Coffee
                Cup</a></center>
    </span>
</footer>

</body>

</html>