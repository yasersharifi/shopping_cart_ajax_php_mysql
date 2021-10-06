<?php
include_once "classes/Cart.php";
$cartObject = new Cart();
$cartItems = $cartObject->findAll();
$totalPrice = 0;

// load header
$pageTitle = "CheckOut";
include_once "template/header.php"; ?>
    <div class="container mt-5">
        <div class="card yas-box-shadow-nh yas-border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Your cart</span>
                            <span class="badge badge-secondary badge-pill">3</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <?php foreach ($cartItems as $item): $totalPrice += $item->quantity * $item->price; ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <img src="assets/images/<?= $item->image; ?>" class="yas-border-radius-5" height="50" alt="">
                                <div>
                                    <h6 class="my-0"><?= $item->name; ?></h6>
                                    <small class="text-muted">Qty: <?= $item->quantity; ?></small>
                                </div>
                                <span class="text-muted">$<?= number_format($item->quantity * $item->price); ?></span>
                            </li>
                            <?php endforeach; ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total (USD)</span>
                                <strong>$<?= number_format($totalPrice); ?></strong>
                            </li>
                        </ul>

                        <form class="card p-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Promo code">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">Redeem</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Billing address</h4>
                        <div class="card">
                            <div class="card-body">
                                <form class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="firstName">First name <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid first name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lastName">Last name <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid last name is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email">Email <span class="text-danger"><sup><b>*</b></sup></span></label>
                                        <input type="email" class="form-control" id="email" placeholder="you@example.com">
                                        <div class="invalid-feedback">
                                            Please enter a valid email address for shipping updates.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address">Address <span class="text-danger"><sup><b>*</b></sup></span></label>
                                        <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                                        <div class="invalid-feedback">
                                            Please enter your shipping address.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="country">Country <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <select class="custom-select d-block w-100 form-control" id="country" required>
                                                <option value="">Choose...</option>
                                                <option>Iran</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid country.
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="state">province <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <select class="custom-select d-block w-100 form-control" id="state" required>
                                                <option value="">Choose...</option>
                                                <option>California</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="state">City <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <select class="custom-select d-block w-100 form-control"  id="state" required>
                                                <option value="">Choose...</option>
                                                <option>California</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid state.
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label for="zip">Zip <span class="text-danger"><sup><b>*</b></sup></span></label>
                                            <input type="text" class="form-control" id="zip" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Zip code required.
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="mb-4">
                                    <button class="btn btn-success btn-lg btn-block" type="submit">Continue to checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once "template/footer.php"; ?>