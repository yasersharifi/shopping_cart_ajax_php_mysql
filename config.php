<?php
session_start();

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

#--- Start Constants ---#
defined("COOKIE_EXPIRATION_TIME") | define("COOKIE_EXPIRATION_TIME", time() + 360 * 24 * 60 * 60);
#--- End Constants ---#

defined("SITE_URL") || define("SITE_URL", "http://localhost/shopping_cart_ajax_php_mysql/");
function siteUrl($url = null) {
    if (! empty($url) && $url != "")
        return SITE_URL . $url;
    return SITE_URL;

}

// Cart Number
include_once "classes/Cart.php";
$cartObject = new Cart();
$cookieId = null;
$cartCount = 0;
if (isset($_COOKIE["cookie_id"])) {
    $cookieId = $_COOKIE["cookie_id"];
    if ($cartObject->hasCookieId($cookieId)) {
        $cartCount = $cartObject->countCart($cookieId);
    }
}

// Check user is login
include_once "classes/Users.php";
$userObject = new Users();
$isLogin = $userObject->isLogin();

