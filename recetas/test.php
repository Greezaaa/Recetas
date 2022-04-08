<?php
//caracterres permetidos
$allowedChars = "/^[a-zA-Z\sаАбБвВгГдДеЕёЁжЖзЗиИйЙкКлЛмМнНоОпПрРсСтТуУфФхХцЦчЧшШщЩъЪыЫьЬэЭюЮяЯ1234567890_-óÓñÑíÍáÁéÉúÜÚ]+$/";

$receta_content = $receta_desc = $recetas_cat_id = $receta_img = $receta_name = $receta_author_id= "";
$receta_name_err = $receta_desc_err = $receta_img_err = $receta_content_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receta_name = $_POST['receta_name'];
    $receta_desc = $_POST['receta_desc'];
    $receta_content = $_POST['receta_content'];

    
    if (empty($receta_name)) {
        $receta_name_err = "No hay nombre";
    } elseif (!filter_var($receta_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "$allowedChars")))) {
        $receta_name_err = "nombre malo";
    } elseif (empty($receta_desc)) {
        $receta_desc_err = "no hay descripcion";
    } elseif (empty($receta_content)) {
        $receta_content_err = "no hay contenido";
    } else {
        //si no hay errores revisamos si se ha cargado la imagen o no
        //si no se actualiza la iagen ejecutamos =>
        
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        echo "TODO BIEN!";
    }
}
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



            </select>
        </div>
        <div class="form-group">
            <label>recetas_author_id</label>
            <select name="recetas_author_id" id="">
                <option value="" disabled>Seleciona autor</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" name="submit">
        <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
<!-- /page-content -->