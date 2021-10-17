<?php
include_once "./../../config.php";
include_once "./../../classes/Products.php";
include_once "./../../classes/Cart.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $productsObject = new Products();
    $cartObject = new Cart();

    $response = [];

    if (isset($_POST["action"]) && $_POST["action"] == "addToCart") {
        $productId = $_POST["productId"];
        $quantity = $_POST["quantity"];
        $cookieId = null;
        if (isset($_COOKIE["cookie_id"])) {
            $cookieId = $_COOKIE["cookie_id"];
            if ($cartObject->hasCookieId($cookieId)) {
                $cartItems = $cartObject->findAll($cookieId);
            }
        } else {
            $cookieId = md5(session_id());
            setcookie("cookie_id", $cookieId, COOKIE_EXPIRATION_TIME);
        }

        $productInfo = $productsObject->findById($productId);
        $productPrice = $productInfo->price;
        $totalPrice = $productPrice * $quantity;

        $cartInfo = $cartObject->findByCookieId($cookieId, $productId);



        if (! $cartInfo == true) {
            if ($cartObject->insert($productId, $quantity, $totalPrice, $cookieId) == true) {
                setcookie("cookie_id", $cookieId, COOKIE_EXPIRATION_TIME);
                $cartCount = $cartObject->countCart($cookieId);
                $response = array(
                    "status" => "ok",
                    "message" => "This product added to database successfully",
                    "cartCount" => $cartCount,
                );

            } else {
                $cartCount = $cartObject->countCart($cookieId);
                $response = array(
                    "status" => "error",
                    "message" => "This product don't added to cart",
                    "cartCount" => $cartCount,
                );
            }
        } else {
            $cartCount = $cartObject->countCart($cookieId);
            $response = array(
                "status" => "ok",
                "message" => "This product has already been added to the cart",
                "cartCount" => $cartCount,
            );

        }

    }
    echo json_encode(array($response));
}