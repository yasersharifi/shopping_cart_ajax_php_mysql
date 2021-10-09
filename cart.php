<?php
include_once "classes/Cart.php";

$cartObject = new Cart();
$cartItems = $cartObject->findAll();
$totalPrice = 0;

// delete from cart
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete" && isset($_GET["cartId"])) {
        $cartId = $_GET["cartId"];
        if ($cartObject->delete($cartId) == true) {
            $_SESSION["msg"] = array(
                    "success",
                "Deleted Items successfully."
            );
        } else {
            $_SESSION["msg"] = array(
                "danger",
                "Deleted Items un successfully."
            );
        }
        header("Location: cart.php");
        exit();
    }
}

// load header
$pageTitle = "Cart";
include_once "template/header.php";
?>
<!-- start main -->
<section id="main">
    <div class="container mt-4">
        <div class="card yas-box-shadow-nh border-0 position-relative">
            <img class="loadingImg" src="<?= siteUrl('assets/images/loading/loading.gif') ?>" width="70" alt="">
            <div class="card-body">
                <div class="row">
                    <?php if (isset($_SESSION["msg"])): $msg = $_SESSION["msg"]; ?>
                    <div class="col-12">
                        <div class="alert alert-<?= $msg[0]; ?>">
                            <?= $msg[1]; ?>
                        </div>
                    </div>
                    <?php endif; unset($_SESSION["msg"]); ?>
                    <div class="col-12 mb-4">
                        <div class="row" id="message" style="display: none">
                            <div class="col-12">
                                <div class="alert" id="messageDiv"></div>
                            </div>
                        </div>
                        <!-- Shopping Cart-->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive shopping-cart">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Subtotal</th>
                                            <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="#">Clear Cart</a></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (! empty($cartItems)): foreach ($cartItems as $item): $totalPrice += $item->price * $item->quantity; ?>
                                        <tr>
                                            <td>
                                                <div class="product-item d-flex">
                                                    <a class="product-thumb" href="#"><img src="assets/images/<?= $item->image; ?>" class="yas-border-radius-5" height="100"  alt="Product"></a>
                                                    <div class="product-info ms-4 d-flex flex-column justify-content-center">
                                                        <h4 class="product-title"><a href="#" class="text-decoration-none text-secondary"><?= $item->name; ?></a></h4>
                                                        <span><em>Size:</em> 10.5</span>
                                                        <span><em>Color:</em> Dark Blue</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="count-input">
                                                    <input type="number" value="<?= $item->quantity; ?>" id="<?= $item->id; ?>" data-price="<?= $item->price; ?>" class="productQty form-control yas-box-shadow-unset" style="width: 100px; margin: 0 auto" min="1">
                                                </div>
                                            </td>
                                            <td class="text-center text-lg text-medium align-middle price">$<?= number_format($item->price); ?></td>
                                            <td class="text-center text-lg text-medium align-middle subTotal">$<?= number_format($item->price * $item->quantity); ?></td>
                                            <td class="text-center align-middle">
                                                <a class="remove-from-cart" href="?action=delete&cartId=<?= $item->cartID; ?>" data-toggle="tooltip" title="" data-original-title="Remove item">
                                                    <i class="bi bi-trash-fill text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="shopping-cart-footer d-flex flex-row justify-content-between align-items-center mt-2 mb-4 px-3">
                                    <div class="column">
                                        <form class="coupon-form" method="post">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <input class="form-control form-control-sm" type="text" placeholder="Coupon code" required="">
                                                <input class="btn btn-outline-primary btn-sm ms-4" type="submit" value="Apply Coupon">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="column text-lg">Subtotal: <span class="text-medium" id="totalPrice">$<?= number_format($totalPrice); ?></span></div>
                                </div>
                                <hr>
                                <div class="shopping-cart-footer d-flex flex-row justify-content-between align-items-center mb-3 px-3">
                                    <div class="column"><a class="btn btn-outline-secondary" href="index.php"><i class="icon-arrow-left"></i>&nbsp;Back to Shopping</a></div>
                                    <div class="column">
                                        <button id="updateCart" class="btn btn-warning text-white"  data-toast="" data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Your cart" data-toast-message="is updated successfully!">Update Cart</button>
                                        <a class="btn btn-success ms-3" href="<?= siteUrl('checkout.php'); ?>">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end main -->
<?php include_once "template/footer.php"; ?>
<script>
    // change subtotal price
    $(document).ready(function () {
        $(".productQty").change(function () {
            let price = $(this).attr("data-price");
            let qty = $(this).val();
            let totalPrice = price * qty;
            $(this).parent("div").parent("td").parent("tr").find(".subTotal").text("$" + totalPrice);
        });
    });

    $(document).ready(function () {
        $("#updateCart").on("click", function () {
            let data = [];
            let item = {};
            let totalPrice = 0;
            let price = 0;
            $(".productQty").each(function () {
                // calculate total cart price
                price = $(this).attr("data-price");
                totalPrice += parseFloat(price * $(this).val());

                item = {"productId": $(this).attr('id'), "productQty": $(this).val()};
                data.push(item);
            })
            // show total price
            $("#totalPrice").text("$" + totalPrice);

            // show loading
            $(".loadingImg").parent("div").addClass("loadingDiv");
            $(".loadingImg").css({display: "block"});

            // update cart
            $.ajax({
                url: "functions/cart/updateCart.php",
                method: "POST",
                data: {action: "updateCart", data: data},
                cache: false,
                success: function (response) {
                    let data = JSON.parse(response);

                    // hide loading
                    $(".loadingImg").parent("div").removeClass("loadingDiv");
                    $(".loadingImg").css({display: "none"});

                    if (data["status"] == "ok") {
                        $("#message").css({display: "block"});
                        $("#messageDiv").addClass("alert-success");
                        $("#messageDiv").text(data["message"]);
                        // change cart counter
                        $(".cartCount").text(data["cartCount"]);

                    } else {
                        $("#message").css({display: "block"});
                        $("#messageDiv").addClass("alert-danger");
                        $("#messageDiv").text(data["message"]);
                    }
                }
            });
        });
    });
</script>