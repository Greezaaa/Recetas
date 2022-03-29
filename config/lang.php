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
?>