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

} else if (!empty($_POST['attempt']) && empty($_POST['email']) && empty($_POST['username']) && empty($_POST['password'])) {
    $_SESSION['error'] = 'All fields must be filled in';
        unset($_POST['email']);
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['attempt']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <label for="email">email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="py-2">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
        </div>
        <div class="py-2">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <input type="hidden" id="attempt" name="attempt" value="attempt">
        <?php if (isset($_SESSION['error'])) { ?>
            <div style="color: red;"><?= $_SESSION['error']; ?></div>
        <?php } ?>
        <input type="submit" value="Sign up" class="my-2 px-4 pb-1 border border-0 rounded">
    </form>
    <a href="inlog.php">Already have an account?</a>
    </div>
</body>
</html>
