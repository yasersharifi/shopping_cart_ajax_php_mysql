<?php include_once "config.php"; ?>
<?php
include_once "classes/Users.php";
$userObject = new Users();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $data = array(
        "full_name" => $_POST["name"],
        "email" => $_POST["email"],
        "password" => $_POST["password"],
    );

    if ($userObject->insert($data) == true) {
        $_SESSION["msg"] = array(
            "success",
            "Register User successfully"
        );
        header("Location: login.php");
        exit();

    } else {
        $_SESSION["msg"] = array(
            "danger",
            "User don't register"
        );
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Login 01</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= siteUrl(); ?>assets/css/login/style.css">

</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Register Page</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php if (isset($_SESSION["msg"])): $msg = $_SESSION["msg"]; ?>
                <div class="col-12">
                    <div class="alert alert-<?= $msg[0]; ?>">
                        <?= $msg[1]; ?>
                    </div>
                </div>
            <?php endif; unset($_SESSION["msg"]); ?>
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center bg-warning">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Sign In</h3>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="login-form">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control rounded-left" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control rounded-left" placeholder="Email" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" name="confPassword" class="form-control rounded-left" placeholder="Password Confirm" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="register" class="form-control btn btn-primary rounded submit px-3">Register</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <a href="#" class="text-danger">Forgot Password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= siteUrl(); ?>assets/js/login/jquery.min.js"></script>
<script src="<?= siteUrl(); ?>assets/js/login/popper.js"></script>
<script src="<?= siteUrl(); ?>assets/js/login/bootstrap.min.js"></script>
<script src="<?= siteUrl(); ?>assets/js/login/main.js"></script>

</body>
</html>

