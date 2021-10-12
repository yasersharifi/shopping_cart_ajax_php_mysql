<?php
session_start();

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

defined("SITE_URL") || define("SITE_URL", "http://localhost/shopping_cart_ajax_php_mysql/");
function siteUrl($url = null) {
    if (! empty($url) && $url != "")
        return SITE_URL . $url;
    return SITE_URL;

}

// Cart Number
include_once "classes/Cart.php";
$cartObject = new Cart();
$cartCount = $cartObject->countCart();

// Check user is login
include_once "classes/Users.php";
$userObject = new Users();
$isLogin = $userObject->isLogin();

