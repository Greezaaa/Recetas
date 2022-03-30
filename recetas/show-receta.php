<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once "../config/config.php";
include_once "../config/function.php";
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {

    // Prepare a select statement
    $sql = "SELECT * FROM recetas WHERE receta_id = :id";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_receta_id);

        // Set parameters
        $param_receta_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $receta_name = $row["receta_name"];
                $receta_desc = $row["receta_desc"];
                $receta_img = $row["receta_img"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    unset($stmt);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
$page = $t['config']['page_recetas'];
include_once "../inc/header.php";
?>
<div class="content">
    <div class="">
        <h2><?php echo $row['receta_name']; ?></h2>
    </div>

    <div class="contenido"><?php echo $row['receta_content']; ?></div>
    <div class="cats-img-wrapper"><img src="../uploads/recetas/<?php echo $row['receta_img'] ?>" width="50" height="50"
            style="object-fit: cover;"></img> </div>
    <?php actionNav($row, $t); ?>
</div>
<div class="item-menu">

    <?php

PrevItem($pdo, $old_id);

NextItem($pdo, $old_id);
unset($pdo);
?>

</div>
<?php include_once "../inc/footer.php";