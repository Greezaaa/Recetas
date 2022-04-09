<!DOCTYPE html>
<html lang="<?php echo $idioma ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($PageTitle) ? $PageTitle : $t["config"]["page_title"]; ?> | <?php echo $page ?></title>
    <link rel="stylesheet" href="../media/css/app.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../media/js/app.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav id="main-nav" style="position:relative">
        <!-- <h1>
            <?= isset($PageTitle) ? $PageTitle : $t["config"]["page_title"]; ?>
        </h1> -->
        <div class="logo-conteiner" style="position:relative">
            <div class="logo" style="width: 500px;
                                    background-image: url(../media/naranja.png);
                                    background-size: 200px;
                                    background-repeat: no-repeat;
                                    background-position: center;
                                    margin: auto;">
                <img src="../media/logo_uk2.svg" alt="">
            </div>
            <hr width="70%" style="position: absolute;
top: 53%;
left: 50%;
transform: translate(-50%, -50%);
z-index: -1;
height: 2px;
background-color: #333;">
        </div>
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
                <a <?php echo(($page == $t["config"]["page_cat"]) ? 'class="active"' : '') ?> href="../categorias.php">
                    <?php echo $t["menu"]["cats"] ?>
                </a>
            </li>
            <li>
                <a <?php echo(($page == $t["config"]["page_reg"]) ? 'class="active"' : '') ?> href="../register.php">
                    <?php echo $t["user"]["signIn"] ?>
                </a>
            </li>
            <li>
                <a <?php echo(($page == $t["config"]["page_log"]) ? 'class="active"' : '') ?> href="../login.php">
                    <?php echo $t["user"]["login"] ?>
                </a>
            </li>
        </ul>
        <div class="lang">
            <ul>
                <li class='es'><a href='../config/lang.php?l=es'>Español</a></li>
                <li class='en'><a href='../config/lang.php?l=uk'>Українська</a></li>
            </ul>
        </div>
        <?php userNav($t, $page); ?>
    </nav>
    <p>#header loaded!</p>