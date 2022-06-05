<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "config/config.php";
include_once "config/function.php";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $_SESSION['msg_type'] = $t["msg_type_suc"];
    $_SESSION['msg_text'] = $t["msg"]["msg_allready_logged"]; ?>
<script>
document.location.replace(document.referrer)
</script>
<?php
exit;
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    if (empty($_POST["email"])) {
        $email_err = $t['error']['loging_err1'];
    } elseif (empty($_POST["password"])) {
        $password_err = $t['error']['loging_err2'];
    }
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT user_id, user_name, user_email, user_password, user_status, user_rol FROM users WHERE user_email = :email";
        if ($login_stmt = $pdo->prepare($sql)) {
            $login_stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = $_POST["email"];
            if ($login_stmt->execute()) {
                if ($login_stmt->rowCount() == 1) {
                    if ($row = $login_stmt->fetch()) {
                        $user_id = $row["user_id"];
                        $user_email = $row["user_email"];
                        $user_status = $row['user_status'];
                        $user_name = $row['user_name'];
                        $user_rol = $row['user_rol'];
                        $hashed_password = $row["user_password"];
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["user_name"] = $user_name;
                            $_SESSION["user_email"] = $user_email;
                            $_SESSION['user_status'] = $user_status;
                            $_SESSION["user_rol"] = $user_rol;
                            $_SESSION["msg_text"] = $t["msg"]["msg_loggedin_suc"] . ' ' . $_SESSION['user_name'];
                            $_SESSION['msg_type'] = $t["msg_type_suc"];
                            // Redirect user to welcome page
                            header("location: index.php");
                            exit;
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = $t['error']['loging_err3'];
                        }
                    }
                } else {
                    // email doesn't exist, display a generic error message
                    $login_err = $t['error']['loging_err3'];
                }
            } else {
                echo "<p class='text-center'>".$t['error']['admin']."</p>";
                exit;
            }

            // Close statement
            unset($login_stmt);
        }
    }
    // Close connection
    unset($pdo);
}
$page = $t["config"]["page_log"];
include_once("inc/header.php");
?>
<div class="page-content">
    <div class="content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-group">
                <input type="text" name="email"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $email; ?>">
                <label><?php echo $t["label"]["email"] ?></label>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="input-group">
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <label><?php echo $t["label"]["password"] ?></label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <?php
        
        if (!empty($login_err)) {
            echo '<span class="invalid-feedback">'. $login_err . '</span>';
        }
         
         ?>
            <div class="input-group">
                <input type="submit" class="btn btn-green full" value="<?php echo $t["user"]["login"] ?>">
            </div>
            <a href="register.php">
                <p class="text-center btn btn-orange full"><?php echo $t["user"]["signIn"] ?></p>
            </a>
        </form>
    </div>
    <!-- /page content -->

</div>
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php";

?>