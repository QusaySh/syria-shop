<?php ob_start(); $system = ""; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="msapplication-tap-highlight" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?= $system ?>/images/logo.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= $system ?>/css/global/materialize.min.css" />
    <link rel="stylesheet" href="<?= $system ?>/css/global/animate.min.css" />
    <?php
        if ( isset($_COOKIE["lang"]) && $_COOKIE["lang"] == "ar" ) {
    ?>
        <link rel="stylesheet" href="<?= $system ?>/css/global/materialize.rtl.min.css" />
        <link rel="stylesheet" href="<?= $system ?>/css/global/bootstrap.rtl.min.css" />
        <link rel="stylesheet" href="<?= $system ?>/css/global/alertify.rtl.min.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <?php
        } else {
    ?>
        <link rel="stylesheet" href="<?= $system ?>/css/global/ltr.css" />
        <link rel="stylesheet" href="<?= $system ?>/css/global/bootstrap.min.css" />
        <link rel="stylesheet" href="<?= $system ?>/css/global/alertify.min.css" />
    <?php
        }
    ?>
    <link rel="stylesheet" href="<?= $system ?>/css/global/mediaBox/lightgallery.css" />
    <link rel="stylesheet" href="<?= $system ?>/css/global/mediaBox/lg-transitions.min.css" />
    <link rel="stylesheet" href="<?= $system ?>/css/global/style.css" />
    <link rel="stylesheet" href="<?= $system ?>/css/global/styleShowAds.css" />
    <?php
        $fileCss = new \syriashop\controllers\AutoLoadStyle();
        $file = $fileCss->filesCss();
        if ( $file != false ) {
            echo '<link rel="stylesheet" href="' . $system .  $file . '" />';
        }
    ?>
    <?php if ( isset($_COOKIE["theme"]) && $_COOKIE["theme"] == "dark" ) { ?>
    <link rel="stylesheet" href="<?= $system ?>/css/global/darkmode.css" />
    <?php } ?>
    <script src="<?= $system ?>/js/global/jquery.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>Syria Shop</title>
  </head>
  <body>