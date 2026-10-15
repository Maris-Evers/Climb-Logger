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

<body>
    <form method="POST">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>
        <input type="submit" value="Log in">
    </form>
    <a href="sign_up.php">Don't have an account yet?</a><br>
    <a href="enter_email.php">Reset password</a>
</body>