<?php include ".././inc/header.php";
    $name = isset($_SESSION['logged_user']) ?  $_SESSION['logged_user']['email'] : 'Guest';
?>

<div class="root">
    <h1 class="title title-main">Welcome <?php echo $name ?></h1>
    <?php if (!isset($_SESSION['logged_user'])) { ?>
        <span class="question">Already have an account? <a href="login.php">Sign in</a> or <a href="register.php">Register</a></span>
    <?php } else {?>
        <h1>Your logged in</h1>
        <a href="/arttteotask/pages/logout.php">Logout</a>
    <?php } ?>
</div>

<?php include ".././inc/footer.php"; ?>
