<?php include ".././inc/header.php";
$message = isset($_SESSION['login_message']) ? $_SESSION['login_message'] : ''

?>

    <div class="root">
        <h1>Login</h1>
        <?php $_COOKIE ?>
        <span class="response"><?php echo $message ?></span>
        <form action="/arttteotask/services/login.php" method="post" class="form form__register">
            <label for="email">Enter email</label>
            <input type="email" name="email" id="email">
            <label for="password">Enter password</label>
            <input type="password" name="password" id="password">
            <button type="submit">Login</button>
        </form>
    </div>

<?php include ".././inc/footer.php"; ?>