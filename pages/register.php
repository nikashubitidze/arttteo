<?php include ".././inc/header.php";
    $login_link = isset($_SESSION['register_status']) && $_SESSION['register_status'] == 200 ? "<a style='color: firebrick' href='/arttteotask/pages/login.php'> Login</a>" : " ";
    $message = isset($_SESSION['register_message']) ? $_SESSION['register_message']. '.' . $login_link : ''

?>

<div class="root">
    <h1>Register</h1>
    <?php $_COOKIE ?>
    <span class="response"><?php echo $message ?></span>
    <form action="/arttteotask/services/register.php" method="post" class="form form__register">
        <label for="email">Enter email</label>
        <input type="email" name="email" id="email">
        <label for="password">Enter password</label>
        <input type="password" name="password" id="password">
        <label for="repeat_password">Repeat password</label>
        <input type="password" name="repeat_password" id="repeat_password">
        <button type="submit">Register</button>
    </form>
</div>

<?php include ".././inc/footer.php"; ?>
