<?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

include_once $_SERVER['DOCUMENT_ROOT']."/config/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
$page = $t["config"]["page_recetas"];
include_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php";

?>
<div class="page-content">
    <h2 class="page-title"><?php echo $t["recetas"]["receta"] ?></h2>
    <?php
    // Attempt select query execution
    $sql = "SELECT r.receta_id, r.receta_name,r.receta_creat, r.receta_img, r.receta_desc, r.recetas_author_id, r.recetas_cat_id, u.user_name, u.user_id, c.cat_name, c.cat_id 
    FROM (( recetas AS r
    INNER JOIN users AS u ON r.recetas_author_id = u.user_id) 
    INNER JOIN cats AS c ON r.recetas_cat_id = c.cat_id) 
    ORDER BY r.receta_id DESC LIMIT 6;
    ";
    
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            echo "<div class='items-wrapper'>";
            while ($row = $result->fetch()) {
                ?>

    <div class="item">
        <div class="content">
            <img src="/uploads/recetas/<?php echo $row['receta_img'] ?>" alt="">

            <div class="item-data">
                <h3 class="item-name">
                    <a href="recetas/show-receta.php?id=<?php echo $row['receta_id']; ?>">
                        <?php echo $row['receta_name']; ?>
                    </a>
                </h3>
                <!-- item-name -->
                <div class="item-cad">
                    <span class="item-author">
                        <a href="recetas/recetas-author.php?id=<?php echo $row['user_id']; ?>">
                            <?php echo $row['user_name']; ?>
                        </a>
                    </span>
                    <!-- item-author -->
                    <span class="item-cat ">
                        <a href="categorias/show-categorias.php?id=<?php echo $row['cat_id']; ?>">
                            <?php echo $row['cat_name']; ?>
                        </a>
                    </span>
                    <!-- item-cat -->
                    <?php
            $date = strtotime($row['receta_creat']);
                echo "<span class='item-create' >".$data_1 = date('d-m-Y', $date). "</span>"; ?>
                    <!-- item-create -->
                </div>
                <!-- item-cad -->
                <div class="item-desc">
                    <?php echo $row['receta_desc']; ?>
                </div>
                <!-- item-desc -->
            </div>
            <!-- item-data -->
        </div>
    </div>
    <!-- item -->

    <?php
            }
            echo "
            </div>
            <!-- items-wrapper -->";
            echo '<div><a href="recetas/index.php" >Ver todas recetas</a></div>';
            // Free result set
            unset($result);
        } else {
            echo '<div class=""><em>' . $t["error"]["empty"] . '</em><a href="recetas/create.php" class="btn success">' . $t["button"]["add_receta"] . '</a></div>';
        }
    } else {
        echo $t["error"]["admin"];
    }
    // Close connection
    unset($pdo);
    ?>
</div>



<?php

include_once "inc/footer.php";