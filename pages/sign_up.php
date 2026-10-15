<?php 

include_once('../database/connection.php');
session_start();

unset($_SESSION['loggedInUser']);
unset($_SESSION['error']);

if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $usernamecheck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usernamecheck == false) {
        $sql = "INSERT INTO users (`email`, `username`, `password`)
                VALUES (?, ?, ?);";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $username, $password]);
        $user_id = $pdo->lastInsertId();
    
        $_SESSION['loggedInUser'] = $user_id;
    
        header("Location: statistics.php");
        die();
    } else {
        $_SESSION['error'] = 'Username already taken';
    }

} else if (!empty($_POST['attempt']) && empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password'])) {
    $_SESSION['error'] = 'All fields must be filled in';
        unset($_POST['email']);
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['attempt']);
}

?>

<body>
    <form method="POST">
        <div>
            <label for="email">email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <input type="hidden" id="attempt" name="attempt" value="attempt">
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>
        <input type="submit" value="Sign up">
    </form>
    <a href="inlog.php">Already have an account?</a>
</body>