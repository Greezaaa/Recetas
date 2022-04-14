<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../config/config.php";
include_once "../config/function.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "SELECT * FROM cats WHERE cat_id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $param_cat_id);
        $param_cat_id = trim($_GET["id"]);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $cat_id = $row['cat_id'];
                $cat_name = $row["cat_name"];
                $cat_desc = $row["cat_desc"];
                $cat_img = $row["cat_img"];
            } else {
                // Si el ID es incorrecto o no existe, mandamos a cuatro vientos
                $_SESSION['msg_type'] = $t["msg_type_dan"];
                $_SESSION['msg_text'] = $t["msg"]["msg_res_not_found"];
                header("Location: index.php");
                exit();
            }
        } else {
            // Este sera mensaje si hay problemas con internos
            $_SESSION['msg_type'] = $t["msg_type_dan"];
            $_SESSION['msg_text'] = $t["error"]["admin"];
            header("Location: index.php");
            exit();
        }
    }
    unset($stmt);
} else {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_res_empty"];
    header("Location: index.php");
    exit();
}
$page = $t['config']['page_cat'];
include_once "../inc/header.php";
?>
<div class="content">
    <div class="">
        <h2><?php echo $row['cat_name']; ?></h2>
    </div>

    <div class="contenido"><?php echo $row['cat_desc']; ?></div>
    <div class="cats-img-wrapper"><img src="../uploads/cats/<?php echo $row['cat_img'] ?>" width="50" height="50"
            style="object-fit: cover;"></img> </div>
    <?php actionNav($row, $t); ?>
</div>
<h4>
    <?php echo $t['config']['page_recetas']  ?>
</h4>
<div class="content">
    <?php
    
    $sql = "SELECT * FROM recetas WHERE recetas_cat_id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":id", $param_receta_id);
        $param_receta_id = $cat_id;

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
            // Este sera mensaje si hay problemas con internos
            $_SESSION['msg_type'] = $t["msg_type_dan"];
            $_SESSION['msg_text'] = $t["error"]["admin"];
            header("Location: index.php");
            exit();
        }
    }
    unset($stmt);
        echo "name " . $receta_name . "<br>";
        echo "desc " . $receta_desc . "<br>";
        echo "cont " . $receta_content . "<br>";
        echo "<img src='../uploads/recetas/".$receta_img."' width='140' height='100'>";
     ?>


</div>



<?php include_once "../inc/footer.php";