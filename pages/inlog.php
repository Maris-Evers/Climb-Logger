<?php

include_once('../database/connection.php');
session_start();

unset($_SESSION['loggedInUser']);
unset($_SESSION['error']);

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user !== false) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedInUser'] = $user['id'];
            header("Location: statistics.php");
            die();
        } else {
            $_SESSION['error'] = "Username or Password is invalid.";
        }
    } else {
        $_SESSION['error'] = "Username or Password is invalid.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body class="bg-dark text-light">
    <div class="text-center position-absolute top-50 start-50 translate-middle">
        <form method="POST">
            <div class="py-2">
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="py-2">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </div>
            <?php if (isset($_SESSION['error'])) { ?>
                <div style="color: red;"><?= $_SESSION['error']; ?></div>
            <?php } ?>
            <input type="submit" value="Log in" class="my-2 px-4 pb-1 border border-0 rounded">
        </form>
        <a href="sign_up.php">Don't have an account yet?</a><br>
        <a href="enter_email.php">Reset password</a>
    </div>
</body>

</html>