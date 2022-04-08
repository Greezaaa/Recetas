<?php
session_start();
include_once "../config/config.php";
include_once "../config/function.php";
//revisamos si usuario esta logeado
//queda por añadir condicion de rol de usuario
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_not_logged"];
    header("Location: index.php");
    exit;
}

$receta_content = $receta_desc = $recetas_cat_id = $receta_img = $receta_name = $receta_author_id= "";
$receta_name_err = $receta_desc_err = $receta_img_err = $receta_content_err = "";
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $receta_id = $_POST['id'];
        $receta_name = $_POST['receta_name'];
        $receta_desc = $_POST['receta_desc'];
        $receta_content = $_POST['receta_content'];
        $recetas_cat_id = $_POST['recetas_cat_id'];
        $recetas_author_id = $_POST['recetas_author_id'];
        
        if (empty($receta_name)) {
            $receta_name_err = $t["error"]["receta_name_err1"];
        } elseif (!filter_var($receta_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "$allowedChars")))) {
            $receta_name_err = $t["error"]["receta_name_err2"] = "NOMBRE INVALIDO";
        } elseif (empty($receta_desc)) {
            $receta_desc_err = $t["error"]["receta_desc_err1"];
        } elseif (empty($receta_content)) {
            $receta_content_err = $t["error"]["receta_content_err1"];
        } else {

            //si no hay errores revisamos si se ha cargado la imagen o no
            //si no se actualiza la iagen ejecutamos =>
            if (!isset($_FILES['receta_img']) || $_FILES['receta_img']['error'] == UPLOAD_ERR_NO_FILE) {
                $receta_id = $_POST['id'];
                $receta_name = $_POST['receta_name'];
                $receta_desc = $_POST['receta_desc'];
                $recetas_cat_id = $_POST['recetas_cat_id'];
                $recetas_author_id = $_POST['recetas_author_id'];
                //queda por agregar parametros
                $sql_update = "UPDATE recetas SET `receta_name`=:receta_name WHERE `receta_id`=:receta_id;";
                if ($receta_upd = $pdo->prepare($sql_update)) {
                    $receta_upd->bindParam(":receta_name", $param_receta_name);
                    $receta_upd->bindParam(":receta_id", $param_receta_id);
                    $param_receta_name = $receta_name;
                    $param_receta_id = $receta_id;
            
                    if ($receta_upd->execute()) {
                        $_SESSION['msg_type'] = $t["msg_type_suc"];
                        $_SESSION['msg_text'] = $t["msg"]["msg_res_updated"];
                        header("Location: index.php");
                        exit();
                    } else {
                        $_SESSION['msg_type'] = $t["msg_type_dan"];
                        $_SESSION['msg_text'] = $t["msg"]["msg_res_updated_error"];
                        header("Location: index.php");
                        exit();
                    }
                }
                unset($receta_upd);
            } else {
                //en caso que se ha actualizado la imagen =>
                print_r($_FILES);
            }
        }
    }
} elseif (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $receta_id =  trim($_GET["id"]);
    $sql = "SELECT * FROM recetas WHERE receta_id = :id";
    if ($show_receta = $pdo->prepare($sql)) {
        $show_receta->bindParam(":id", $param_receta_id);
        $param_receta_id = $receta_id;
        if ($show_receta->execute()) {
            if ($show_receta->rowCount() == 1) {
                $row = $show_receta->fetch(PDO::FETCH_ASSOC);
                $receta_name = $row["receta_name"];
                $receta_desc = $row["receta_desc"];
                $receta_img = $row["receta_img"];
                $receta_content = $row["receta_content"];
                $receta_cat_id = $row["recetas_cat_id"];
                $receta_author_id = $row["recetas_author_id"];
                $receta_creat = $row["receta_creat"];
                $receta_update = $row["receta_update"];
            } else {
                // Si el ID es incorrecto o no existe, mandamos a cuatro vientos
                $_SESSION['msg_type'] = $t["msg_type_dan"];
                $_SESSION['msg_text'] = $t["msg"]["msg_res_not_found"];
                header("Location: index.php");
                exit();
            }
        } else {
            // Si el ID es incorrecto o no existe, mandamos a cuatro vientos
            $_SESSION['msg_type'] = $t["msg_type_dan"];
            $_SESSION['msg_text'] = $t["msg"]["msg_res_not_found"];
            header("Location: index.php");
            exit();
        }
    }
    // Close statement
    unset($show_receta);
} else {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_res_empty"];
    header("Location: index.php");
    exit();
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
                value="<?php echo (!empty($receta_name)) ? $receta_name : '' ; ?>">
            <span class="invalid-feedback"><?php echo $receta_name_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_desc</label>
            <textarea name="receta_desc"
                class="form-control <?php echo (!empty($receta_desc_err)) ? 'is-invalid' : ''; ?>"><?php echo (!empty($receta_desc)) ? $receta_desc : '' ; ?></textarea>
            <span class="invalid-feedback"><?php echo $receta_desc_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_img</label>
            <?php if (isset($receta_img) && (!empty($receta_img))) {
    ?>
            <img src="../uploads/recetas/<?php echo $row['receta_img'] ?>" width="50" height="50"
                style="object-fit: cover;"><?php
} ?>
            <input type="file" name="receta_img"
                class="form-control <?php echo (!empty($receta_img_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $receta_img; ?>">
            <span class="invalid-feedback"><?php echo $receta_img_err; ?></span>
        </div>
        <div class="form-group">
            <label>receta_content</label>
            <textarea name="receta_content"
                class="form-control <?php echo (!empty($receta_content_err)) ? 'is-invalid' : ''; ?>"><?php echo (!empty($receta_content)) ? $receta_content : '' ; ?></textarea>
            <span class="invalid-feedback"><?php echo $receta_content_err; ?></span>
        </div>
        <div class="form-group">
            <label>recetas_cat_id</label>
            <select name="recetas_cat_id" id="">
                <option value="" disabled>Seleciona categoria</option>
                <?php
               $recetas_cat_id = $row['recetas_cat_id'];
               $s_cats = "SELECT * From cats";
               if ($cats_result = $pdo->query($s_cats)) {
                   if ($cats_result->rowCount() > 0) {
                       while ($cats = $cats_result->fetch()) {
                           $cat_id = $cats['cat_id'];
                           $cat_name = $cats['cat_name'];
                           echo($receta_cat_id == $cat_id)
                           ? '<option value="'.$cat_id.'" selected>'.$cat_name .'</option>'
                           : '<option value="'.$cat_id.'">' . $cat_name .'</option>' ;
                       }
                   }
                   unset($cats_result);
               }
                ?>

            </select>
        </div>
        <div class="form-group">
            <label>recetas_author_id</label>
            <select name="recetas_author_id" id="">
                <option value="" disabled>Seleciona autor</option>

                <?php
            //Buscamos el nombre de autor y lo imprimimos en un div con link a mostrar todas las recetas del mismo autor
                $recetas_author_id = $row['recetas_author_id'];
                $s_author = "SELECT user_name, user_id From users";
                if ($authors = $pdo->query($s_author)) {
                    if ($authors->rowCount() > 0) {
                        while ($author = $authors->fetch()) {
                            $author_name = $author['user_name'];
                            $author_id = $author['user_id'];
                            echo($recetas_author_id === $author_id)
                            ? '<option value="'.$author_id.'" selected>'.$author_name .'</option>'
                            : '<option value="'.$author_id.'">' . $author_name .'</option>' ;
                        }
                    }
                    unset($authors);
                }?>
            </select>
        </div>
        <?php
                 
          ?>
        <input type="hidden" name="id" value="<?php echo $receta_id ?>" />
        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
<!-- /page-content -->
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php";

 ?>