<?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

include_once $_SERVER['DOCUMENT_ROOT']."/config/function.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
$page = $t["config"]["page_cat"];
include_once $_SERVER['DOCUMENT_ROOT']."/inc/header.php";

?>
<div class="page-content">
    <h2 class=""><?php echo $t["cats"]["cat"] ?></h2>
    <a href="categorias-add.php" class="btn btn-success" title="<?php echo $t['action']['ceate']; ?>"
        data-toggle="tooltip"><?php echo $t["button"]["add_receta"]; ?></a>
    <?php
    // Attempt select query execution
    $sql = "SELECT * FROM cats ";
    if ($result = $pdo->query($sql)) {
        if ($result->rowCount() > 0) {
            echo "<div class='cats-content'>";
            while ($row = $result->fetch()) {
                ?>
    <div class="content-header">
        <div class=""><?php echo $t["cats"]["id"]; ?></div>
        <div class=""><?php echo $t["cats"]["name"]; ?></div>
        <div class=""><?php echo $t["cats"]["description"]; ?></div>
        <div class=""><?php echo $t["cats"]["img"]; ?></div>
    </div>
    <div class="content">
        <div class=""><?php echo $row['cat_id']; ?></div>
        <div class=""><?php echo $row['cat_name']; ?></div>
        <div class=""><?php echo $row['cat_desc']; ?></div>
        <div class="cats-img-wrapper"><img src="uploads/cats/<?php echo $row['cat_img'] ?>" width="50" height="50"
                style="object-fit: cover;"></img> </div>
        <?php actionNav($row, $t); ?>
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

<?php

include_once "inc/footer.php";