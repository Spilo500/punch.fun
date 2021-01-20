<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <base href="/CDEM/" ;>
    <link href="public/css/style.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <?php
    if (isset($css)) {
        echo $css;
    }
    ?>
</head>

<body>
    <header>
        <a id="logo" href="/CDEM"> cdem.fun</a>
        <div id="connect" class='connectHover'>
            <div id="round"></div>
            <?php
            if ($connected) {
            ?>
                <a href="disconnect">Se déconnecter</a>
            <?php
            } else {
            ?>
                <a href="connect">Se connecter</a>
            <?php
            }
            ?>
        </div>
    </header>