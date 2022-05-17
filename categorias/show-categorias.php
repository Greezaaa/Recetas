<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../config/config.php";
include_once "../config/function.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "SELECT * FROM cats WHERE cat_id = :id";

    if ($showCat = $pdo->prepare($sql)) {
        $showCat->bindParam(":id", $param_cat_id);
        $param_cat_id = trim($_GET["id"]);

        if ($showCat->execute()) {
            if ($showCat->rowCount() == 1) {
                $cat = $showCat->fetch(PDO::FETCH_ASSOC);
                $cat_id = $cat['cat_id'];
                $cat_name = $cat["cat_name"];
                $cat_desc = $cat["cat_desc"];
                $cat_img = $cat["cat_img"];
            } else {
                // Si el ID es incorrecto o no existe, mandamos a cuatro vientos
                $_SESSION['msg_type'] = $t["msg_type_dan"];
                $_SESSION['msg_text'] = $t["msg"]["msg_cat_not_found"];
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
    unset($showCat);
} else {
    $_SESSION['msg_type'] = $t["msg_type_dan"];
    $_SESSION['msg_text'] = $t["msg"]["msg_res_empty"];
    header("Location: index.php");
    exit();
}
$page = $t['config']['page_cat'];
include_once "../inc/header.php";
?>
<div class="page-content">

    <div class="content">
        <div class="">
            <h2><?php echo $cat['cat_name']; ?></h2>
        </div>

        <div class="contenido"><?php echo $cat['cat_desc']; ?></div>
        <div class="cats-img-wrapper"><img src="../uploads/cats/<?php echo $cat['cat_img'] ?>" width="50" height="50"
                style="object-fit: cover;"></img> </div>
        <?php actionNav($cat, $t); ?>
    </div>
    <h4>
        <?php echo $t['config']['page_recetas']  ?>
    </h4>

    <?php
$sql = "SELECT * FROM recetas WHERE recetas_cat_id = $cat_id";
if ($recetas = $pdo->query($sql)) {
    if ($recetas->rowCount() > 0) {
        echo "<div class='recetas-content'>";
        while ($receta = $recetas->fetch()) {
            ?>
    <div class="content">
        <div class="">
            <a href="show-receta.php?id=<?php echo $receta['receta_id']; ?>"><?php echo $receta['receta_name']; ?></a>
        </div>
        <div class="cats-here">
            <?php
            $cat_id = $receta['recetas_cat_id'];
            $s_cats = "SELECT * From cats WHERE cat_id = $cat_id";
            if ($cats_result = $pdo->query($s_cats)) {
                if ($cats_result->rowCount() > 0) {
                    while ($cats = $cats_result->fetch()) { ?>
            <div cat_link>
                <a href="../categorias/show-categorias.php?id=<?php echo $cats['cat_id']?>">
                    <?php echo $cats['cat_name']?>
                </a>
            </div>

            <?php
                        }
                }
                unset($cats_result);
            } ?>
        </div>
        <div class=""><?php echo $receta['receta_desc']; ?></div>
        <div class="cats-img-wrapper"><img src="../uploads/recetas/<?php echo $receta['receta_img'] ?>" width="50"
                height="50" style="object-fit: cover;"></img> </div>
        <!-- aqui tiene que estar el menu de acciones  -->
    </div>
    <?php
        }
        echo "</div> <!-- /receta-content -->";
        // Free result set
        unset($result);
    } else {
        echo '<div class=""><em>' . $t["error"]["empty"] . '</em><a href="categorias-add.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i>' . $t["button"]["add_cat"] . '</a></div>';
    }
} else {
    echo $t["error"]["admin"];
}
    // Close connection
    unset($pdo);
    ?>
</div>
<?php include_once "../inc/footer.php";