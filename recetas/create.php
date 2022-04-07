<?php
session_start();
include_once "../config/config.php";
include_once "../config/function.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_not_logged"];
    header("Location: index.php");
    exit;
}

$receta_content = $receta_desc = $recetas_cat_id = $receta_img = $receta_name = "";
$receta_name_err = $recetas_cat_id_err = $receta_desc_err = $receta_img_err = $receta_content_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img = $_FILES['receta_img'];
    $imgName = $img['name'];
    $imgTmpName = $img['tmp_name'];
    $imgSize = $img['size'];
    $imgError = $img['error'];
    $imgType = $img['type'];

    $receta_name = $_POST["receta_name"];
    $receta_desc = $_POST["receta_desc"];
    $receta_content = $_POST["receta_content"];
    $recetas_cat_id = $_POST["recetas_cat_id"];

    //  adaptamos la extencion del archivo cargado
    $imgOldExt = explode('.', $imgName);
    $imgExt = strtolower(end($imgOldExt));
    //archivos permetidos
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');
    if (!in_array($imgExt, $allowed)) {
        $receta_img_err = $t["error"]["receta_img_err1"];
    } elseif ($imgError > 0) {
        $receta_img_err =  $t["error"]["receta_img_err2"];
    } elseif ($imgSize > 1000000) {
        $receta_img_err =  $t["error"]["receta_img_err3"] . byteToMb($imgSize);
    } elseif (empty($receta_name)) {
        $receta_name_err = $t["error"]["receta_name_err1"];
    } elseif (!filter_var($receta_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "$allowedChars")))) {
        $receta_name_err = $t["error"]["receta_name_err2"];
    } elseif (empty($receta_desc)) {
        $receta_desc_err = $t["error"]["receta_desc_err1"];
    } else {
        $sql = "SELECT receta_id FROM recetas WHERE receta_name = :receta_name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":receta_name", $receta_name, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $receta_name_err = $t["error"]["receta_name_err3"];
        } else {
            $receta_img = str_replace(' ', '', $receta_name) .'-'. uniqid(). "." . $imgExt;
            // creamos PATH para archivos
            $imgDestination = "../uploads/recetas/" . $receta_img;
            // cargamos archivo al la carpeta UPLOADS
            move_uploaded_file($imgTmpName, $imgDestination);
            
            $sql = "INSERT INTO recetas (`receta_id`, `receta_name`, `receta_desc`, `receta_img`, `receta_content`, `recetas_cat_id`, `recetas_author_id`) VALUES (NULL, :receta_name, :receta_desc, :receta_img, :receta_content, :recetas_cat_id, :recetas_author_id );";
            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":receta_name", $param_receta_name);
                $stmt->bindParam(":receta_desc", $param_receta_desc);
                $stmt->bindParam(":receta_img", $param_receta_img);
                $stmt->bindParam(":receta_content", $param_receta_content);
                $stmt->bindParam(":recetas_cat_id", $param_recetas_cat_id);
                $stmt->bindParam(":recetas_author_id", $param_recetas_author_id);
                
                $param_receta_name = $receta_name;
                $param_receta_desc = $receta_desc;
                $param_receta_img = $receta_img;
                $param_receta_content = $receta_content;
                $param_recetas_cat_id = $recetas_cat_id;
                $param_recetas_author_id = $_SESSION['user_id'];

                if ($stmt->execute()) {
                    session_start();
                    // Si todo bien...Creamos mensaje y redirigimos a la pagina de inicio
                    $_SESSION['msg_type'] = $t["msg_type_suc"];
                    $_SESSION['msg_text'] = $t["msg"]["msg_cat_add_success"];
                    header("Location: index.php");
                    exit();
                } else {
                    session_start();
                    $_SESSION['msg_type'] = $t["msg_type_dan"];
                    $_SESSION['msg_text'] = $t["msg"]["msg_cat_add_error"];
                    header("Location: index.php");
                }
            }
            // Close statement
            unset($stmt);
            // Close connection
            unset($pdo);
        }
    }
}
$page = $t["config"]["page_recetas"];
include_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php";
?>
<div class="page-content">
    <h2 class="mt-5">Añadir receta</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>receta_name</label>
            <input type="text" name="receta_name"
                class="form-control <?php echo (!empty($receta_name_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $receta_name; ?>">
            <span class="invalid-feedback"><?php echo $receta_name_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_desc</label>
            <textarea name="receta_desc"
                class="form-control <?php echo (!empty($receta_desc_err)) ? 'is-invalid' : ''; ?>"><?php echo $receta_desc; ?></textarea>
            <span class="invalid-feedback"><?php echo $receta_desc_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_img</label>
            <input type="file" name="receta_img"
                class="form-control <?php echo (!empty($receta_img_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $receta_img; ?>">
            <span class="invalid-feedback"><?php echo $receta_img_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_content</label>
            <textarea name="receta_content"
                class="form-control <?php echo (!empty($receta_content_err)) ? 'is-invalid' : ''; ?>"><?php echo $receta_content; ?></textarea>
            <span class="invalid-feedback"><?php echo $receta_content_err; ?></span>
        </div>
        <div class="form-group">
            <label>recetas_cat_id</label>
            <select name="recetas_cat_id" id="">
                <?php $s_cats = "SELECT * FROM cats";
    if ($result = $pdo->query($s_cats)) {
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $cat_id = $row['cat_id'];
                $cat_name = $row['cat_name'];

                echo "<option value='" . $cat_id . "'>" . $cat_name . "</option>";
            }
        }
    }?>

            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
<!-- /page-content -->
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php";

 ?>