<?php
include_once "./../../Products.php";
include_once "./../../Cart.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
    //request is ajax
    $productsObject = new Products();
    $cartObject = new Cart();

    $response = [];

    if (isset($_POST["action"]) && $_POST["action"] == "addToCart") {
        $productId = $_POST["productId"];
        $quantity = $_POST["quantity"];

        $productInfo = $productsObject->findById($productId);
        $productPrice = $productInfo->price;
        $totalPrice = $productPrice * $quantity;

        $cartInfo = $cartObject->findByProductId($productId);



        if (! $cartInfo == true) {
            if ($cartObject->insert($productId, $quantity, $totalPrice) == true) {
                $cartCount = $cartObject->countCart();
                $response = array(
                    "status" => "ok",
                    "message" => "This product added to database successfully",
                    "cartCount" => $cartCount,
                );

            } else {
                $cartCount = $cartObject->countCart();
                $response = array(
                    "status" => "error",
                    "message" => "This product don't added to cart",
                    "cartCount" => $cartCount,
                );
            }
        } else {
            $cartCount = $cartObject->countCart();
            $response = array(
                "status" => "ok",
                "message" => "This product has already been added to the cart",
                "cartCount" => $cartCount,
            );

        }

    }
    echo json_encode(array($response));
}