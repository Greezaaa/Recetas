<?php

//selecion de archivo para traduccion
$idioma = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
$archivo = file_exists($_SERVER['DOCUMENT_ROOT']."/lang/$idioma.json") ?
$_SERVER['DOCUMENT_ROOT']."/lang/$idioma.json" :
$_SERVER['DOCUMENT_ROOT']."/lang/es.json";
$contenido = file_get_contents($archivo);
$t = json_decode($contenido, true);

//mostrar tamaño del archivo
function byteToMb($size)
{
    $base = log($size) / log(1024);
    $suffix = array("B", "KB", "MB", "GB", "TB");
    $f_base = floor($base);
    return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}
//caracterres permetidos
$allowedChars = "/^[a-zA-Z\sаАбБвВгГдДеЕёЁжЖзЗиИйЙкКлЛмМнНоОпПрРсСтТуУфФхХцЦчЧшШщЩъЪыЫьЬэЭюЮяЯ1234567890_-óÓñÑíÍáÁéÉúÜÚ]+$/";

//user menu
function UserNav($t, $page)
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $user_nav = '
        <nav class="user-nav">
            <div>
            <a href="../index.php">' . $t["menu"]["home"] . '</a>
                <a href="../recetas/mis-recetas.php">' . $t["menu"]["misrecetas"] . '</a>
                <a href="../categorias.php">' . $t["menu"]["cats"] . '</a>
                <a href="../inc/logout.php" class="btn btn-danger">' . $t["user"]["logout"] . '</a>
                </div>
                </nav>';
        unset($_SESSION["log"]);
    } elseif (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
        if ($page == $t["config"]["page_log"]) {
            $user_nav =  "<h3>".$t['config']['page_log']."</h3>";
        } elseif ($page == $t["config"]["page_reg"]) {
            $user_nav =  "<h3>".$t['config']['page_reg']."</h3>";
        } else {
            $log = $t["userNav"]["logText"];
            $user_nav = '
        <nav class="user-nav">
            <div>
                <span>' . $log  . '</span>
                <a href="/login.php"  class="btn btn-success">' . $t["user"]["login"] . '</a>
            </div>
        </nav>';
        }
        // unset($_SESSION["log"]);
    }
    echo $user_nav;
}

function actionNav()
{
    $actionNav = "Futuro menu de acciones";
    echo $actionNav;
}
//añadir receta si estas logeado
function AddReceta($t)
{
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        echo '<div class="btn success"><a href="../recetas/create.php">'.$t["action"]["create"].'</a></div>';
    }
}

//previos item function
$old_id = "";
function PrevItem($pdo, $old_id)
{
    if (isset($_GET["id"]) && !empty(trim($_GET["id"])) && $_GET['id'] > 0) {
        $prev = "SELECT * FROM recetas WHERE receta_id < :id ORDER BY receta_id DESC LIMIT 1";
        if ($p_receta = $pdo->prepare($prev)) {
            $p_receta->bindParam(":id", $old_id);
            $old_id = trim($_GET["id"]);
            if ($p_receta->execute()) {
                if ($p_receta->rowCount() == 1) {
                    $prev_row = $p_receta->fetch(PDO::FETCH_ASSOC);
                    // Retrieve individual field value
                    $prev_receta_id = $prev_row["receta_id"];
                    $prev_receta_name = $prev_row["receta_name"];
                    $prev_receta_desc = $prev_row["receta_desc"];
                    $prev_receta_img = $prev_row["receta_img"];
            
                    echo '<div class="prev-item"><a href="show-receta.php?id='.$prev_receta_id.'"  title="'.$prev_receta_desc.'" ><span>&laquo;'.$prev_receta_name.'</span><img src="../uploads/recetas/'.$prev_receta_img.'"></a></div>';
                }
            }
        }
        unset($p_receta);
        // Close connection
    }
}

//next Item function
function NextItem($pdo, $old_id)
{
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $next = "SELECT * FROM recetas WHERE receta_id > :id ORDER BY receta_id ASC LIMIT 1";
        if ($n_receta = $pdo->prepare($next)) {
            $n_receta->bindParam(":id", $old_id);
            $old_id = trim($_GET["id"]);
            if ($n_receta->execute()) {
                if ($n_receta->rowCount() == 1) {
                    $next_row = $n_receta->fetch(PDO::FETCH_ASSOC);
                    // Retrieve individual field value
                    $next_receta_id = $next_row["receta_id"];
                    $next_receta_name = $next_row["receta_name"];
                    $next_receta_desc = $next_row["receta_desc"];
                    $next_receta_img = $next_row["receta_img"];
                    
                    echo '<div class="next-item"><a href="show-receta.php?id='.$next_receta_id.'"  title="'.$next_receta_desc.'" ><span>'.$next_receta_name. '&raquo;</span><img src="../uploads/recetas/'.$next_receta_img.'"></a></div>';
                }
            }
        }
        unset($n_receta);
        // Close connection
    }
}