<?php
session_start();
include_once "Cart.php";
$cartObject = new Cart();
$cartItems = $cartObject->findAll();

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
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/hover-min.css">
    <title>Cart || Yaser Sharifi zade</title>
</head>
<body>
<!-- start top header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-warning" href="#">Shopping Cart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Dashboard</a></li>
                        <li><a class="dropdown-item" href="#">Change Details</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <button class="btn btn-success" type="submit"><i class="bi bi-cart me-2"></i>Cart(<span
                        class="cartCount">3</span>)
                </button>
            </form>
        </div>
    </div>
</nav>
<!-- end top header -->

<!--start breadcrumb -->
<section id="breadcrumb">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 yas-box-shadow">
                    <div class="card-body">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                             aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--end breadcrumb -->

<!-- start main -->
<section id="main">
    <div class="container mt-4">
        <div class="card yas-box-shadow-nh border-0">
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
                        <!-- Shopping Cart-->
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive shopping-cart">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Subtotal</th>
                                            <th class="text-center">Discount</th>
                                            <th class="text-center"><a class="btn btn-sm btn-outline-danger" href="#">Clear Cart</a></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (! empty($cartItems)): foreach ($cartItems as $item): ?>
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
                                                    <input type="number" value="<?= $item->quantity; ?>" class="form-control yas-box-shadow-unset" style="width: 100px; margin: 0 auto">
                                                </div>
                                            </td>
                                            <td class="text-center text-lg text-medium align-middle subTotal">$<?= number_format($item->price); ?></td>
                                            <td class="text-center text-lg text-medium align-middle">$<?= number_format($item->price * $item->quantity); ?></td>
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
                                    <div class="column text-lg">Subtotal: <span class="text-medium">$289.68</span></div>
                                </div>
                                <hr>
                                <div class="shopping-cart-footer d-flex flex-row justify-content-between align-items-center mb-3 px-3">
                                    <div class="column"><a class="btn btn-outline-secondary" href="#"><i class="icon-arrow-left"></i>&nbsp;Back to Shopping</a></div>
                                    <div class="column">
                                        <a class="btn btn-warning text-white" href="#" data-toast="" data-toast-type="success" data-toast-position="topRight" data-toast-icon="icon-circle-check" data-toast-title="Your cart" data-toast-message="is updated successfully!">Update Cart</a>
                                        <a class="btn btn-success ms-3" href="#">Checkout</a>
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

<footer class="footer mt-5 py-3 bg-dark">
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <a href="mailto:yassersharifi74@gmail.com"><i class="bi bi-envelope text-white  contactIcon hvr-float"></i></a>
                    <a href="https://github.com/yasersharifi"><i class="bi bi-github text-white contactIcon hvr-float"></i></a>
                    <a href="3"><i class="bi bi-telegram text-white contactIcon hvr-float"></i></a>
                    <a href="3"><i class="bi bi-instagram text-white contactIcon hvr-float"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <span class="text-muted">
                    Develop By  <a href="mailto:yassersharifi74@gmail.com">Yaser Sharifi</a>
            </span>
    </div>
</footer>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</body>
</html>