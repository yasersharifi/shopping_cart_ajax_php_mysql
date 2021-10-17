<?php
include_once "config.php";
include_once __DIR__ . "/classes/Products.php";
include_once __DIR__ . "/classes/Cart.php";
$productsObject = new Products();
$productsItem = $productsObject->findAll();

$pageTitle = "Shop";
include_once "template/header.php";
?>
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
<?php include_once "template/footer.php"; ?>
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