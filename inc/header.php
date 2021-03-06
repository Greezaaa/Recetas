<!DOCTYPE html>
<html lang="<?php echo $idioma ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($PageTitle) ? $PageTitle : $t["config"]["page_title"]; ?> | <?php echo $page ?></title>
    <link rel="stylesheet" href="../media/css/app.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../media/js/app.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <header>

        <div class="lang-wrapper">
            <ul>
                <li class='lang es <?php echo($idioma == "es") ? 'active': ''; ?>'><a
                        href='../config/lang.php?l=es'></a></li>
                <li class='lang uk <?php echo($idioma == "uk") ? 'active': ''; ?>'><a
                        href='../config/lang.php?l=uk'></a></li>
            </ul>
        </div>
        <?php userNav($t, $page); ?>

        <div class="logo-wrapper">
            <img src="../media/logo_uk2.svg" alt="">
        </div>
        <div class="nav-wrapper">
            <ul class="navbar">
                <li>
                    <a <?php echo(($page == $t["config"]["page_home"]) ? 'class="active"' : '') ?> href="../index.php">
                        <?php echo $t["menu"]["home"] ?>
                    </a>
                </li>
                <li>
                    <a <?php echo(($page == $t["config"]["page_recetas"]) ? 'class="active"' : '') ?>
                        href="../recetas/index.php">
                        <?php echo $t["menu"]["recetas"] ?>
                    </a>
                </li>
                <li>
                    <a <?php echo(($page == $t["config"]["page_cat"]) ? 'class="active"' : '') ?>
                        href="../categorias.php">
                        <?php echo $t["menu"]["cats"] ?>
                    </a>
                </li>
                <!-- <li>
    <a <?php echo(($page == $t["config"]["page_reg"]) ? 'class="active"' : '') ?> href="../register.php">
        <?php echo $t["user"]["signIn"] ?>
    </a>
</li>
<li>
    <a <?php echo(($page == $t["config"]["page_log"]) ? 'class="active"' : '') ?> href="../login.php">
        <?php echo $t["user"]["login"] ?>
    </a>
</li> -->
            </ul>

        </div>

    </header>
    <main>