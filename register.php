<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "config/function.php";
include_once "config/config.php";



// definimos parametros sin valor
$name = $password = $confirm_password = $email = "";
$name_err = $password_err = $confirm_password_err = $email_err = "";

if (isset($_POST['regUser'])) {
    $name = trim($_POST["name"]);
    $filtered_name = filter_var(
        $name,
        FILTER_VALIDATE_REGEXP,
        array("options" => array("regexp" => "$allowedChars"))
    );
    $email = trim($_POST["email"]);
    $filtered_email = filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($name)) {
        $name_err =  $t["error"]["reg_user_err1"];
    } elseif (!$filtered_name) {
        $name_err = $t["error"]["reg_user_err2"];
    } elseif (!$filtered_email) {
        $email_err = $t["error"]["reg_user_err3"];
    } elseif (empty($password)) {
        $password_err = $t["error"]["reg_user_err4"];
    } elseif (strlen($password) < 6) {
        $password_err = $t["error"]["reg_user_err5"];
    } elseif (empty($confirm_password)) {
        $confirm_password_err = $t["error"]["reg_user_err6"];
    } elseif ($password !== $confirm_password) {
        $confirm_password_err = $t["error"]["reg_user_err7"];
    } else {
        $sql = "SELECT user_id FROM users WHERE user_email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $filtered_email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $email_err = $t["error"]["reg_user_err8"];
        } else {
            $stmt->closeCursor(); // Limpiar el stmt de la consulta anterior
            $sql = "INSERT INTO users (user_name, user_email, user_password) 
            VALUES (:name, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            if ($stmt->execute()) {
                session_start();
                $_SESSION['msg_type'] = $t["msg_type_suc"];
                $_SESSION['msg_text'] = $t["msg"]["msg_signup_suc"];
                // Redirecion despues de registrar
                header("location: login.php");
            } else {
                echo $t["error"]["admin"];
            }
        }
        unset($stmt);
        unset($pdo);
    }
}
$page = $t["config"]["page_reg"];
include_once("inc/header.php");
?>
<div class="page-content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label><?php echo $t["label"]["name"] ?></label>
            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $name; ?>">
            <span class="invalid-feedback"><?php echo $name_err; ?></span>
        </div>
        <div class="form-group">
            <label><?php echo $t["label"]["email"] ?></label>
            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label><?php echo $t["label"]["password"] ?></label>
            <input type="password" name="password"
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <label><?php echo $t["label"]["password2"] ?></label>
            <input type="password" name="confirm_password"
                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-green full" name="regUser" value="Отправить">
        </div>
        <p class="text-center"><?php echo $t["other"]["reg_redirect"] ?> <a
                href="login.php"><?php echo $t["other"]["reg_redirect_2"] ?> </a></p>
    </form>
</div>
<?php include_once "inc/footer.php";