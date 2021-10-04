<?php
include_once "Products.php";
include_once "Cart.php";
$productsObject = new Products();
$productsItem = $productsObject->findAll();

// instance of cart
$cartObject = new Cart();
$cartCount = $cartObject->countCart();
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
    <title>Shop || Yaser Sharifi zade</title>
</head>
<body>
<!-- start top header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
                    <a class="nav-link" href="cart.html">Cart</a>
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
                        class="cartCount"><?= $cartCount; ?></span>)
                </button>
            </form>
        </div>
    </div>
</nav>
<!-- end top header -->

<!--start breadcrumb -->
<section id="breadcrumb" style="margin-top: 85px">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 yas-box-shadow">
                    <div class="card-body">
                        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
                             aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shop</li>
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
                <div class="row mb-4 mt-2">
                    <div class="col-12 col-md-6">
                        <div>
                            <select class="form-select yas-box-shadow-unset border-warning form-select-lg border-2">
                                <option value="-1" disabled>Sort By: Featured</option>
                                <option value="">Price: Low to High</option>
                                <option value="">Price: High to Low</option>
                                <option value="">Oldest</option>
                                <option value="">Newest</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <form action="#" class="searchForm d-flex flex-row">
                            <input type="text" class="form-control form-control-lg yas-box-shadow-unset yas-border-0">
                            <input type="submit" value="Search" class="btn btn-warning yas-border-radius-0 text-white">
                        </form>
                    </div>
                </div>
                <div class="row" id="message" style="display: none">
                    <div class="col-12">
                        <div class="alert" id="messageDiv"></div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <?php if (! empty($productsItem)): foreach ($productsItem as $item): ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card border-0 yas-box-shadow">
                            <img src="assets/images/<?= $item->image; ?>" class="card-img-top yas-height-250" alt="...">
                            <div class="card-body">
                                <h6 class="card-title"><?= $item->name; ?></h6>
                                <div class="card-text d-flex flex-row justify-content-between align-items-center my-3">
                                    <span><sup>$</sup><?= number_format($item->price); ?></span>
                                    <span>
                                        <i class="bi bi-star-fill text-warning yas-font-size-10"></i>
                                        <i class="bi bi-star-fill text-warning yas-font-size-10"></i>
                                        <i class="bi bi-star-fill text-warning yas-font-size-10"></i>
                                        <i class="bi bi-star text-warning yas-font-size-10"></i>
                                        <i class="bi bi-star text-warning yas-font-size-10"></i>
                                    </span>
                                </div>
                                <div class="d-grid">
                                    <input type="hidden" class="productId" value="<?= $item->id; ?>">
                                    <button class="addToCart btn btn-warning text-light d-flex justify-content-center">Add To Cart
                                        <i class="bi bi-cart ms-3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
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
<script>
    $(document).ready(function () {
        $(document).on("click", ".addToCart", function (e) {
            e.preventDefault();
            let productId = $(this).prev("input").val();
            
            $.ajax({
                url: "functions/cart/addToCart.php",
                method: "POST",
                data: {action: "addToCart", productId: productId, quantity: 1},
                success: function (response) {
                    let data = JSON.parse(response)[0];
                    console.log(data)
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
        })
    });
</script>

</body>
</html>