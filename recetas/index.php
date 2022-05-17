<?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

include_once $_SERVER['DOCUMENT_ROOT']."/config/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
$page = $t["config"]["page_recetas"];
include_once $_SERVER['DOCUMENT_ROOT']."../inc/header.php";

?>
<div class="page-content">
    <h2 class=""><?php echo $t["recetas"]["receta"] ?></h2>
    <?php AddReceta($t);  ?>
    <?php
    //version 01
    // Buscamos todas recetas de BBDD en la tabla "recetas"
    $sql = "SELECT * FROM recetas";
    if ($recetas = $pdo->query($sql)) {
        if ($recetas->rowCount() > 0) {
            echo "<div class='recetas'>";
            while ($receta = $recetas->fetch()) {
                ?>
    <div class="receta">
        <div class="receta-desc">
            <p>
                <?php echo $receta['receta_desc']; ?>
            </p>
        </div>
        <img src='../../uploads/recetas/<?php echo $receta['receta_img'] ?>' alt="">
        <div class="receta-info-wrapper">
            <a class="receta-name" href="show-receta.php?id=<?php echo $receta['receta_id']; ?>">
                <?php echo $receta['receta_name']; ?>
            </a>
            <div class="receta-info">

                <?php
            //Buscamos el nombre de categoria atraves de id y creamos link para mostrar la categoria
        $cat_id = $receta['recetas_cat_id'];
                $s_cats = "SELECT * From cats WHERE cat_id = $cat_id";
                if ($cats_result = $pdo->query($s_cats)) {
                    if ($cats_result->rowCount() > 0) {
                        while ($cats = $cats_result->fetch()) { ?>

                <a class="cat-name" href="../categorias/show.php?id=<?php echo $cats['cat_id']?>">
                    <?php echo $cats['cat_name']?>
                </a>
                <?php
                        }
                    }
                    unset($cats_result);
                }
                //categoria over?>
                <span>/</span>
                <?php
       //Buscamos el nombre de autor y lo imprimimos en un div con link a mostrar todas las recetas del mismo autor
                $user_id = $receta['recetas_author_id'];
                $s_author = "SELECT * From users WHERE user_id = $user_id";
                if ($authors = $pdo->query($s_author)) {
                    if ($authors->rowCount() > 0) {
                        while ($author = $authors->fetch()) { ?>

                <a class="receta-author" href="recetas-author.php?id=<?php echo $author['user_id']?>">
                    <?php echo $author['user_name']?>
                </a>
                <?php
                        }
                    }
                    unset($authors);
                }
                //author over?>
                <span>/</span>

                <?php
            $date = strtotime($receta['receta_creat']);
                echo "<span class='receta-create' >".$data_1 = date('Y-m-d', $date). "</span>"; ?>

            </div>
        </div>
        <!-- //receta info wrapper  -->





        <!-- acciones -->
        <div class="action">
            <?php  ActionRes($receta, $t); ?>
        </div>
        <!-- //acciones -->
    </div>

    <?php
            }
            echo "</div> <!-- /receta-content -->";
            unset($result);
        } else {
            echo '<div class=""><em>' . $t["error"]["empty"] . '</em><a href="recetas/create.php" class="btn success">' . $t["button"]["add_receta"] . '</a></div>';
        }
    } else {
        echo $t["error"]["admin"];
    }
    unset($pdo);
    ?>
</div>
<?php
include_once "../inc/footer.php";