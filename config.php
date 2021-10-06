<?php
session_start();

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
