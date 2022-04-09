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
if (isset($_POST["id"]) && !empty($_POST["id"])) {


    // Prepare a delete statement
    $sql = "DELETE FROM recetas WHERE receta_id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);

        // Set parameters
        $param_id = trim($_POST["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Si todo bien...Creamos mensaje y redirigimos a la pagina de inicio
            $_SESSION['msg_type'] = $t["msg_type_suc"];
            $_SESSION['msg_text'] = $t["msg"]["msg_res_del_suc"];
            header("Location: index.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);
} else {
    // Check existence of id parameter
    if (empty(trim($_GET["id"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}

$page = $t["config"]["page_recetas"];
include_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php";
?>
<h2 class="mt-5 mb-3">Delete Record</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class=" danger">
        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
        <p>
            <?php
            $receta_id = $_GET['id'];
            if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
                $sql = "SELECT * FROM recetas WHERE receta_id = :id";
                if ($stmt = $pdo->prepare($sql)) {
                    $stmt->bindParam(":id", $receta_id);
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() == 1) {
                            /* Fetch result row as an associative array. Since the result set
                            contains only one row, we don't need to use while loop */
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
                            // Retrieve individual field value
                            $receta_name = $row["receta_name"];
                            $receta_desc = $row["receta_desc"];
                            $receta_img = $row["receta_img"];
                            $receta_content = $row["receta_content"];
                            $recetas_cat_id = $row["recetas_cat_id"];
                            $recetas_author_id = $row["recetas_author_id"];
                            $recetas_status = $row["recetas_status"];
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
                        // mensaje si hay error interno
                        $_SESSION['msg_type'] = $t["msg_type_dan"];
                        $_SESSION['msg_text'] = $t["error"]["admin"];
                        header("Location: index.php");
                        exit();
                    }
                }
                // Close statement
                unset($stmt);
            } else {
                $_SESSION['msg_type'] = $t["msg_type_dan"];
                $_SESSION['msg_text'] = $t["msg"]["msg_res_empty"];
                header("Location: index.php");
                exit();
            }
            echo "De moento se queda asi ;)<br><h2>Seguro que quieres borrar esta receta?</h2>";
            echo $receta_name;
            echo "<br><img src='../uploads/recetas/".$receta_img ."' height='50' width='50'>";
            echo $receta_desc;
            ?>
        </p>

        <p>
            <input type="submit" value="Yes" class="btn btn-danger">
            <a href="index.php" class="btn btn-secondary ml-2">No</a>
        </p>
    </div>
</form>

<?php

include_once $_SERVER['DOCUMENT_ROOT']."/inc/footer.php";

 ?>