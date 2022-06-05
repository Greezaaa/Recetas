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
    // Attempt select query execution
    $sql = "SELECT r.receta_id, r.receta_name,r.receta_creat, r.receta_img, r.receta_desc, r.recetas_author_id, r.recetas_cat_id, u.user_name, u.user_id, c.cat_name, c.cat_id 
    FROM (( recetas AS r
    INNER JOIN users AS u ON r.recetas_author_id = u.user_id) 
    INNER JOIN cats AS c ON r.recetas_cat_id = c.cat_id) 
    ORDER BY r.receta_id ;
    ";
  $isFirst = true;
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            echo "<div class='items-wrapper'>";
            while ($row = $result->fetch()) {
                echo "<div class='item".($isFirst ? ' first' : '')."'>"; ?>
    <img src="../uploads/recetas/<?php echo $row['receta_img'] ?>" alt="">

    <div class="item-data">
        <h3 class="item-name">
            <a href="show-receta.php?id=<?php echo $row['receta_id']; ?>">
                <?php echo $row['receta_name']; ?>
            </a>
        </h3>
        <!-- item-name -->

        <span class="item-author">
            <a href="recetas-author.php?id=<?php echo $row['user_id']; ?>">
                <span class="tooltip">
                    Ver todas recetas del autor
                </span>
                <?php echo $row['user_name']; ?>
            </a>
        </span>
        <!-- item-author -->
        <span class="item-cat ">
            <a href="../categorias/show-categorias.php?id=<?php echo $row['cat_id']; ?>">
                <span class="tooltip">
                    Ver todas recetas de esta categoria
                </span>
                <?php echo $row['cat_name']; ?>
            </a>

        </span>
        <!-- item-cat -->
        <?php
                $date = strtotime($row['receta_creat']);
                if ($row['receta_creat'] != null) {
                    echo "<div class='item-create' >
                    <span class='item-create-day'>" . DateTraducida::DayNumber($date, $idioma) ."</span>
                    <span class='item-create-month'>" . DateTraducida::MonthShort($date, $idioma) . "</span>  
                    <span class='item-create-year'>" . DateTraducida::Year($date, $idioma) . "</span>  
                    </div>";
                } ?>
        <!-- item-create -->

        <div class="item-desc">
            <?php echo $row['receta_desc']; ?>
        </div>
        <!-- item-desc -->
    </div>
    <!-- item-data -->
    <a href="show-receta.php?id=<?php echo $row['receta_id'] ?>" class="itemReadMore">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="44" height="44"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />

            <line x1="9" y1="12" x2="15" y2="12" />
            <line x1="12" y1="9" x2="12" y2="15" />
        </svg>
    </a>
</div>
<!-- item -->
<?php
                if ($isFirst) {
                    $isFirst = false;
                }
            }
            
            echo "
            </div>
            <!-- items-wrapper -->";

            
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
<?php

    
     ?>
<?php






 ?>
</div>


<script>
//add/remove class on click
$(".item").click(function() {
    $(".item").removeClass("active");
    $(this).addClass("active");
});
</script>
<?php
include_once "../inc/footer.php";