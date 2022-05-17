<?php
echo "<pre>";
print_r($_SESSION);
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
</main>
<footer>
    <center style="vertical-align: center">
        with <span style="color: #ff0000; font-size:2.2rem"> &hearts;</span> from <a style=" color: #f2f2f2;
                text-decoration: none;" href="https://yellowcoffeecup.com" title="Yellow Coffee Cup | Coffee and Code">
            <img src="../media/yellowcoffeecup.svg" alt="" width="20">
        </a>
    </center>
</footer>

</body>

</html>