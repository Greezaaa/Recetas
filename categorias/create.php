<?php
session_start();
include_once "../config/config.php";
include_once "../config/function.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false || $_SESSION["user_rol"] <= 2) {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_not_logged"];
    header("Location: index.php");
    exit;
}

 $cat_desc = $cats_cat_id = $cat_img = $cat_name = "";
$cat_name_err = $cats_cat_id_err = $cat_desc_err = $cat_img_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = $_FILES['cat_img'];
    $imgName = $img['name'];
    $imgTmpName = $img['tmp_name'];
    $imgSize = $img['size'];
    $imgError = $img['error'];
    $imgType = $img['type'];

    $cat_name = $_POST["cat_name"];

    //  adaptamos la extencion del archivo cargado
    $imgOldExt = explode('.', $imgName);
    $imgExt = strtolower(end($imgOldExt));
    //archivos permetidos
    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'svg');
    if (!in_array($imgExt, $allowed)) {
        $cat_img_err = $t["error"]["cat_img_err1"];
    } elseif ($imgError > 0) {
        $cat_img_err =  $t["error"]["cat_img_err2"];
    } elseif ($imgSize > 1000000) {
        $cat_img_err =  $t["error"]["cat_img_err3"] . byteToMb($imgSize);
    } elseif (empty($cat_name)) {
        $cat_name_err = $t["error"]["cat_name_err1"];
    } elseif (!filter_var($cat_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "$allowedChars")))) {
        $cat_name_err = $t["error"]["cat_name_err2"];
    } else {
        $sql = "SELECT cat_id FROM cats WHERE cat_name = :cat_name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":cat_name", $cat_name, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $cat_name_err = $t["error"]["cat_name_err3"];
        } else {
            $cat_img = uniqid(). "." . $imgExt;
            // creamos PATH para archivos
            $imgDestination = "../uploads/cats/" . $cat_img;
            // cargamos archivo al la carpeta UPLOADS
            move_uploaded_file($imgTmpName, $imgDestination);
            
            $sql = "INSERT INTO cats (`cat_id`, `cat_name`, `cat_img`) VALUES (NULL, :cat_name, :cat_img);";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":cat_name", $param_cat_name);
                $stmt->bindParam(":cat_img", $param_cat_img);
                
                $param_cat_name = $cat_name;
                $param_cat_img = $cat_img;

                if ($stmt->execute()) {
                    session_start();
                    // Si todo bien...Creamos mensaje y redirigimos a la pagina de inicio
                    $_SESSION['msg_type'] = $t["msg_type_suc"];
                    $_SESSION['msg_text'] = $t["msg"]["msg_res_add_success"];
                    header("Location: ../categorias.php");
                    exit();
                } else {
                    session_start();
                    $_SESSION['msg_type'] = $t["msg_type_dan"];
                    $_SESSION['msg_text'] = $t["msg"]["msg_res_add_error"];
                    header("Location: ../categorias.php");
                }
            }
            // Close statement
            unset($stmt);
            // Close connection
            unset($pdo);
        }
    }
}
$page = $t["config"]["page_cat"];
include_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php";
?>
<div class="page-content">
    <h2 class="mt-5">Añadir cat</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <label>cat_name</label>
            <input type="text" name="cat_name"
                class="form-control <?php echo (!empty($cat_name_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $cat_name; ?>">
            <span class="invalid-feedback"><?php echo $cat_name_err; ?></span>
        </div>

        <div class="input-group">
            <label>cat_img</label>
            <input type="file" name="cat_img"
                class="form-control <?php echo (!empty($cat_img_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $cat_img; ?>">
            <span class="invalid-feedback"><?php echo $cat_img_err; ?></span>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
<!-- /page-content -->
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php";

 ?>