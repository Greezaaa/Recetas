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
    <h2 class=""><?php echo $t["recetas"]["receta"] ?></h2>

    <?php
    // Attempt select query execution
    $sql = "SELECT * FROM recetas ORDER BY receta_id DESC LIMIT 5 ";
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            echo "<div class='recetas-content'>";
            while ($row = $result->fetch()) { ?>
    <div class="content">
        <div class="">
            <a href="recetas/show-receta.php?id=<?php echo $row['receta_id']; ?>"><?php echo $row['receta_name']; ?></a>
        </div>

        <div class=""><?php echo $row['receta_desc']; ?></div>
        <div class="cats-img-wrapper"><img src="uploads/recetas/<?php echo $row['receta_img'] ?>" width="50" height="50"
                style="object-fit: cover;"></img> </div>
        <?php actionNav($row, $t); ?>
    </div>
    <?php
            }
            echo "</div> <!-- /receta-content -->";
            echo '<div><a href="recetas/index.php" >Ver todas recetas</a></div>';
            // Free result set
            unset($result);
        } else {
            echo '<div class=""><em>' . $t["error"]["empty"] . '</em><a href="recetas/create.php" class="btn btn-success pull-right">' . $t["button"]["add_receta"] . '</a></div>';
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